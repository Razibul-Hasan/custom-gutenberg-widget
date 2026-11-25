import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	InspectorControls,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import {
	INLINE,
	HeadWidget,
	SectionSettings,
	SectionStyles,
	useSectionLook,
} from '../shared/section-parts';
import metadata from './block.json';

const TEMPLATE = [
	[ 'bwe/step' ],
	[ 'bwe/step' ],
	[ 'bwe/step' ],
	[ 'bwe/step' ],
	[ 'bwe/step' ],
];

// Links must not navigate while editing.
const stop = ( event ) => event.preventDefault();

/**
 * Classes of the section (same as render.php).
 *
 * @param {Object} attributes Block attributes.
 */
const guideClasses = ( attributes ) =>
	[
		'bwex-guide',
		attributes.headAlign === 'left'
			? 'bwex-guide--left'
			: 'bwex-guide--center',
		'bwex-guide--last-' +
			( [ 'left', 'center', 'right', 'stretch' ].includes(
				attributes.lastRow
			)
				? attributes.lastRow
				: 'center' ),
		[ 'left', 'center', 'right' ].includes( attributes.btnAlign )
			? `bwex-guide--btn-${ attributes.btnAlign }`
			: '',
	]
		.filter( Boolean )
		.join( ' ' );

function Edit( { attributes, setAttributes, clientId } ) {
	const look = useSectionLook( metadata, attributes, clientId );
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const blockProps = useBlockProps( {
		className: [
			'wp-block-group elementor-element e-con-full bwex-section bwex-section--dark bwex-process',
			guideClasses( attributes ),
			'e-flex e-con e-child',
			look.className,
		]
			.filter( Boolean )
			.join( ' ' ),
		'data-bwe-anchor': attributes.sectionId || undefined,
	} );
	const stepsProps = useInnerBlocksProps(
		{
			className: 'bwex-num bwex-num--row bwex-num--dark bwex-guide__list',
		},
		{
			allowedBlocks: [ 'bwe/step' ],
			template: TEMPLATE,
			orientation: 'horizontal',
		}
	);
	const btnClass =
		attributes.btnStyle === 'outline'
			? 'bwex-btn'
			: 'bwex-btn bwex-btn--fill';
	return (
		<>
			<SectionSettings
				attributes={ attributes }
				setAttributes={ setAttributes }
			>
				<SelectControl
					__nextHasNoMarginBottom
					__next40pxDefaultSize
					label={ __( 'Header alignment', 'bestwebexpert' ) }
					value={ attributes.headAlign || 'center' }
					options={ [
						{
							label: __( 'Centre', 'bestwebexpert' ),
							value: 'center',
						},
						{ label: __( 'Left', 'bestwebexpert' ), value: 'left' },
					] }
					onChange={ set( 'headAlign' ) }
				/>
				<SelectControl
					__nextHasNoMarginBottom
					__next40pxDefaultSize
					label={ __( 'Card position', 'bestwebexpert' ) }
					help={ __(
						'Where a row that is not full sits, e.g. the last 2 of 5 cards at 3 per row. "Stretch" makes those cards fill the row.',
						'bestwebexpert'
					) }
					value={ attributes.lastRow || 'center' }
					options={ [
						{
							label: __( 'Centre', 'bestwebexpert' ),
							value: 'center',
						},
						{ label: __( 'Left', 'bestwebexpert' ), value: 'left' },
						{
							label: __( 'Right', 'bestwebexpert' ),
							value: 'right',
						},
						{
							label: __(
								'Stretch to fill the row',
								'bestwebexpert'
							),
							value: 'stretch',
						},
					] }
					onChange={ set( 'lastRow' ) }
				/>
			</SectionSettings>
			<InspectorControls>
				<PanelBody
					title={ __( 'Button', 'bestwebexpert' ) }
					initialOpen={ false }
				>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Button text', 'bestwebexpert' ) }
						help={ __( 'Empty = no button.', 'bestwebexpert' ) }
						value={ attributes.btnText || '' }
						onChange={ set( 'btnText' ) }
					/>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Button link', 'bestwebexpert' ) }
						value={ attributes.btnUrl || '' }
						onChange={ set( 'btnUrl' ) }
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Open in a new tab', 'bestwebexpert' ) }
						checked={ !! attributes.btnNewTab }
						onChange={ set( 'btnNewTab' ) }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Button alignment', 'bestwebexpert' ) }
						value={ attributes.btnAlign || '' }
						options={ [
							{
								label: __(
									'Same as the header',
									'bestwebexpert'
								),
								value: '',
							},
							{
								label: __( 'Left', 'bestwebexpert' ),
								value: 'left',
							},
							{
								label: __( 'Centre', 'bestwebexpert' ),
								value: 'center',
							},
							{
								label: __( 'Right', 'bestwebexpert' ),
								value: 'right',
							},
						] }
						onChange={ set( 'btnAlign' ) }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Button look', 'bestwebexpert' ) }
						value={ attributes.btnStyle || 'fill' }
						options={ [
							{
								label: __( 'Filled (accent)', 'bestwebexpert' ),
								value: 'fill',
							},
							{
								label: __( 'Outline', 'bestwebexpert' ),
								value: 'outline',
							},
						] }
						onChange={ set( 'btnStyle' ) }
					/>
				</PanelBody>
			</InspectorControls>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<section { ...blockProps }>
				{ look.css && <style>{ look.css }</style> }
				<div className="wp-block-group elementor-element e-con-full bwex-wrap e-flex e-con e-child">
					<HeadWidget
						attributes={ attributes }
						setAttributes={ setAttributes }
					/>
					<div className="wp-block-group elementor-element elementor-widget elementor-widget-bwex-numbered-list">
						<div className="wp-block-group elementor-widget-container">
							<ol { ...stepsProps } start="1" />
						</div>
					</div>
					<div className="wp-block-group bwex-guide__foot">
						<div className="wp-block-buttons bwe-btns-raw">
							<div
								className={ `elementor-element ${ btnClass } elementor-widget elementor-widget-button` }
							>
								<a
									className="elementor-button elementor-button-link elementor-size-sm"
									href={ attributes.btnUrl || '#' }
									onClick={ stop }
								>
									<span className="elementor-button-content-wrapper">
										<RichText
											tagName="span"
											className="elementor-button-text"
											value={ attributes.btnText }
											onChange={ set( 'btnText' ) }
											placeholder={ __(
												'Button text (optional)',
												'bestwebexpert'
											) }
											allowedFormats={ [] }
											disableLineBreaks
										/>
									</span>
								</a>
							</div>
						</div>
						<RichText
							tagName="p"
							className="bwex-guide__note wp-block-paragraph"
							value={ attributes.note }
							onChange={ set( 'note' ) }
							placeholder={ __(
								'Small note beside the button (optional)',
								'bestwebexpert'
							) }
							allowedFormats={ INLINE }
						/>
					</div>
				</div>
			</section>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
