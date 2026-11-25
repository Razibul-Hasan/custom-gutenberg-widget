/**
 * Phone layout setting (List / Slider) for blocks with a list of cards — the editor side of
 * includes/mobile-slider.php. Attributes: phoneLayout, sliderTablet, slideWidth, sliderDots, sliderArrows; blocks with the
 * desktop slider also have desktopSlider and desktopSlides.
 */
import { __, sprintf } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	RangeControl,
	ToggleControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalToggleGroupControl as ToggleGroupControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalToggleGroupControlOption as ToggleGroupControlOption,
} from '@wordpress/components';

const isSlider = ( attributes ) => attributes.phoneLayout === 'slider';
const device = ( attributes ) => ( attributes.sliderTablet ? 't' : 'm' );

const desktopSlides = ( attributes ) =>
	Math.max( 2, Math.min( 4, Number( attributes.desktopSlides ) || 3 ) );
const isDesktopSlider = ( attributes, count ) =>
	!! attributes.desktopSlider && count > desktopSlides( attributes );

/**
 * Class and style for the list element (mirrors bwe_gw_slider_list_attrs()).
 *
 * @param {Object} attributes Block attributes.
 * @param {number} count      Number of cards (only the desktop slider depends on it).
 * @return {{className: string, style: (Object|undefined)}} Props to merge.
 */
export function sliderListProps( attributes, count = 0 ) {
	const classes = [];
	const style = {};
	if ( isSlider( attributes ) ) {
		const width = Math.max(
			50,
			Math.min( 100, Number( attributes.slideWidth ) || 85 )
		);
		classes.push( `bwe-ms--${ device( attributes ) }` );
		style[ '--bwe-ms-w' ] = `${ width }%`;
	}
	if ( isDesktopSlider( attributes, count ) ) {
		classes.push( 'bwe-ms--d' );
		style[ '--bwe-ms-n' ] = desktopSlides( attributes );
	}
	if ( ! classes.length ) {
		return { className: '', style: undefined };
	}
	return { className: [ 'bwe-ms', ...classes ].join( ' ' ), style };
}

/**
 * Dots / arrows row as the page shows it (first card active). Shown in the editor at the widths that slide.
 *
 * @param {Object} props
 * @param {Object} props.attributes Block attributes.
 * @param {number} props.count      Number of cards.
 */
export function SliderNav( { attributes, count } ) {
	const phone = isSlider( attributes );
	const desktopNav = isDesktopSlider( attributes, count );
	if ( ( ! phone && ! desktopNav ) || count < 2 ) {
		return null;
	}
	const dots = attributes.sliderDots !== false;
	const arrows = attributes.sliderArrows !== false;
	if ( ! dots && ! arrows ) {
		return null;
	}
	return (
		<div
			className={ [
				'bwe-ms__nav',
				phone && `bwe-ms__nav--${ device( attributes ) }`,
				desktopNav && 'bwe-ms__nav--d',
			]
				.filter( Boolean )
				.join( ' ' ) }
			aria-hidden="true"
		>
			{ dots && (
				<div className="bwe-ms__dots">
					{ Array.from( { length: count }, ( _, i ) => (
						<span
							key={ i }
							className="bwe-ms__dot"
							aria-current={ i === 0 ? 'true' : undefined }
						/>
					) ) }
				</div>
			) }
			{ arrows && (
				<div className="bwe-ms__arrows">
					<span className="bwe-ms__arrow bwe-ms__arrow--prev">←</span>
					<span className="bwe-ms__arrow bwe-ms__arrow--next">→</span>
				</div>
			) }
		</div>
	);
}

/**
 * "Phone layout" panel in the block's Settings tab ("Slider" for blocks with the desktop slider).
 *
 * @param {Object}   props
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Setter.
 * @param {string}   props.itemName      What one item is called ("card"), for the help text.
 * @param {boolean}  props.desktop       Also offer the desktop slider settings.
 */
export function PhoneLayoutPanel( {
	attributes,
	setAttributes,
	itemName = __( 'card', 'bestwebexpert' ),
	desktop = false,
} ) {
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const slider = isSlider( attributes );
	const desktopOn = desktop && !! attributes.desktopSlider;
	return (
		<InspectorControls>
			<PanelBody
				title={
					desktop
						? __( 'Slider', 'bestwebexpert' )
						: __( 'Phone layout', 'bestwebexpert' )
				}
				initialOpen={ slider || desktopOn }
			>
				{ desktop && (
					<>
						<ToggleControl
							__nextHasNoMarginBottom
							label={ __(
								'Slider on computers',
								'bestwebexpert'
							) }
							help={ __(
								'Slides only when there are more items than fit in view. Fewer stay in the normal row.',
								'bestwebexpert'
							) }
							checked={ desktopOn }
							onChange={ set( 'desktopSlider' ) }
						/>
						{ desktopOn && (
							<RangeControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ __(
									'Items in view on computers',
									'bestwebexpert'
								) }
								help={ __(
									'With more items than this, the row becomes a slider.',
									'bestwebexpert'
								) }
								min={ 2 }
								max={ 4 }
								value={ desktopSlides( attributes ) }
								onChange={ ( value ) =>
									setAttributes( {
										desktopSlides: value ?? 3,
									} )
								}
							/>
						) }
					</>
				) }
				<ToggleGroupControl
					__nextHasNoMarginBottom
					__next40pxDefaultSize
					isBlock
					label={ __(
						'On phones, show the items as',
						'bestwebexpert'
					) }
					value={ slider ? 'slider' : 'list' }
					onChange={ set( 'phoneLayout' ) }
					help={
						slider
							? sprintf(
									/* translators: %s: what one item is called, e.g. "card". */
									__(
										'One %s at a time: swipe sideways, the next one peeks in from the edge.',
										'bestwebexpert'
									),
									itemName
								)
							: __(
									'Stacked one under the other (the normal layout).',
									'bestwebexpert'
								)
					}
				>
					<ToggleGroupControlOption
						value="list"
						label={ __( 'List', 'bestwebexpert' ) }
					/>
					<ToggleGroupControlOption
						value="slider"
						label={ __( 'Slider', 'bestwebexpert' ) }
					/>
				</ToggleGroupControl>
				{ slider && (
					<>
						<RangeControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ __(
								'Width of one slide (% of the row)',
								'bestwebexpert'
							) }
							help={ __(
								'Less than 100 lets the next one peek in, so people see they can swipe.',
								'bestwebexpert'
							) }
							min={ 60 }
							max={ 100 }
							value={ Number( attributes.slideWidth ) || 85 }
							onChange={ ( value ) =>
								setAttributes( { slideWidth: value ?? 85 } )
							}
						/>
						<ToggleControl
							__nextHasNoMarginBottom
							label={ __(
								'Slider on tablets too',
								'bestwebexpert'
							) }
							help={ __(
								'Off: phones only (up to 781px wide). On: up to 1024px wide.',
								'bestwebexpert'
							) }
							checked={ !! attributes.sliderTablet }
							onChange={ set( 'sliderTablet' ) }
						/>
					</>
				) }
				{ ( slider || desktopOn ) && (
					<>
						<ToggleControl
							__nextHasNoMarginBottom
							label={ __( 'Show dots', 'bestwebexpert' ) }
							checked={ attributes.sliderDots !== false }
							onChange={ set( 'sliderDots' ) }
						/>
						<ToggleControl
							__nextHasNoMarginBottom
							label={ __(
								'Show arrow buttons',
								'bestwebexpert'
							) }
							checked={ attributes.sliderArrows !== false }
							onChange={ set( 'sliderArrows' ) }
						/>
					</>
				) }
			</PanelBody>
		</InspectorControls>
	);
}
