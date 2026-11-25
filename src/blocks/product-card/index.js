import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	BaseControl,
	Button,
	PanelBody,
	RangeControl,
	SelectControl,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import { RawHTML } from '@wordpress/element';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import { AttrText } from '../shared/section-parts';
import metadata from './block.json';

const ARTS = [
	{ label: 'Animated: ProductReels (phone feed)', value: 'reels' },
	{ label: 'Animated: ProductBoxes (build a box)', value: 'boxes' },
	{ label: 'Animated: MigrateLift (site move)', value: 'lift' },
	{ label: 'My own image', value: 'image' },
	{ label: 'No picture', value: 'none' },
];
const MOCKUPS = [ 'reels', 'boxes', 'lift' ];
const FITS = [
	{ label: 'Cover (fill the box, crop the edges)', value: 'cover' },
	{ label: 'Contain (whole image, no crop)', value: 'contain' },
	{ label: 'Stretch (fill, may distort)', value: 'fill' },
	{ label: 'Actual size', value: 'none' },
	{ label: 'Shrink only if too big', value: 'scale-down' },
];
const POSITIONS = [
	'center center',
	'center top',
	'center bottom',
	'left center',
	'right center',
	'left top',
	'right top',
	'left bottom',
	'right bottom',
].map( ( value ) => ( {
	value,
	label: value
		.split( ' ' )
		.map( ( w ) => w[ 0 ].toUpperCase() + w.slice( 1 ) )
		.join( ' ' ),
} ) );

// Same inline style as render.php.
const imageStyle = ( { imageFit, imagePosition, imagePadding } ) => ( {
	width: '100%',
	height: '100%',
	objectFit: imageFit || 'cover',
	...( imagePosition && imagePosition !== 'center center'
		? { objectPosition: imagePosition }
		: {} ),
	...( imagePadding > 0
		? { padding: imagePadding, boxSizing: 'border-box' }
		: {} ),
} );

function Edit( { attributes, setAttributes, clientId } ) {
	const {
		art,
		imageUrl,
		imageAlt,
		tag,
		name,
		text,
		linksLabel,
		links,
		showLinks,
		btnText,
	} = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const mockup = MOCKUPS.includes( art );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Picture', 'bestwebexpert' ) }>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Picture', 'bestwebexpert' ) }
						value={ art }
						options={ ARTS }
						onChange={ set( 'art' ) }
					/>
					{ art === 'image' && (
						<BaseControl
							id={ `bwe-pc-img-${ clientId }` }
							label={ __( 'Image', 'bestwebexpert' ) }
							__nextHasNoMarginBottom
						>
							<MediaUploadCheck>
								<MediaUpload
									allowedTypes={ [ 'image' ] }
									onSelect={ ( media ) =>
										setAttributes( {
											imageUrl: media.url,
											imageId: media.id,
											imageAlt: media.alt || '',
										} )
									}
									render={ ( { open } ) => (
										<div
											style={ {
												display: 'flex',
												gap: 8,
											} }
										>
											<Button
												variant="secondary"
												onClick={ open }
											>
												{ imageUrl
													? __(
															'Replace',
															'bestwebexpert'
														)
													: __(
															'Choose image',
															'bestwebexpert'
														) }
											</Button>
											{ imageUrl && (
												<Button
													variant="tertiary"
													isDestructive
													onClick={ () =>
														setAttributes( {
															imageUrl: '',
															imageId: 0,
															imageAlt: '',
														} )
													}
												>
													{ __(
														'Remove',
														'bestwebexpert'
													) }
												</Button>
											) }
										</div>
									) }
								/>
							</MediaUploadCheck>
						</BaseControl>
					) }
					{ art === 'image' && imageUrl && (
						<TextControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ __( 'Alt text', 'bestwebexpert' ) }
							value={ imageAlt }
							onChange={ set( 'imageAlt' ) }
						/>
					) }
					{ art === 'image' && imageUrl && (
						<>
							<SelectControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ __( 'Image fit', 'bestwebexpert' ) }
								value={ attributes.imageFit }
								options={ FITS }
								onChange={ set( 'imageFit' ) }
							/>
							{ attributes.imageFit !== 'fill' && (
								<SelectControl
									__nextHasNoMarginBottom
									__next40pxDefaultSize
									label={ __(
										'Image position',
										'bestwebexpert'
									) }
									value={ attributes.imagePosition }
									options={ POSITIONS }
									onChange={ set( 'imagePosition' ) }
								/>
							) }
							<RangeControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ __(
									'Space around the image (px)',
									'bestwebexpert'
								) }
								value={ attributes.imagePadding }
								min={ 0 }
								max={ 80 }
								onChange={ ( v ) =>
									setAttributes( { imagePadding: v ?? 0 } )
								}
							/>
						</>
					) }
				</PanelBody>
				<PanelBody title={ __( 'Links', 'bestwebexpert' ) }>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Show the demo links line',
							'bestwebexpert'
						) }
						checked={ showLinks !== false }
						onChange={ set( 'showLinks' ) }
					/>
					<AttrText
						label={ __( 'Button link', 'bestwebexpert' ) }
						name="btnUrl"
						attributes={ attributes }
						setAttributes={ setAttributes }
					/>
				</PanelBody>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ attributes.bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<div
				{ ...useBlockProps( {
					className: [
						'wp-block-group',
						attributes.wrapClasses,
						className,
					]
						.filter( Boolean )
						.join( ' ' ),
				} ) }
			>
				{ css && <style>{ css }</style> }
				<div className="wp-block-group elementor-widget-container">
					<article
						className={
							'wp-block-group bwex-card' +
							( mockup ? ` bwex-card--${ art }` : '' )
						}
					>
						{ mockup && (
							// Same markup as the site (includes/product-art.php → window.bweGw.productArt).
							<RawHTML>
								{ window.bweGw?.productArt?.[ art ] || '' }
							</RawHTML>
						) }
						{ art === 'image' && imageUrl && (
							<div className="bwe-work__art bwe-work__art--image">
								<img
									src={ imageUrl }
									alt={ imageAlt }
									style={ imageStyle( attributes ) }
								/>
							</div>
						) }
						<div className="wp-block-group bwex-card__body">
							<RichText
								tagName="p"
								className="bwex-card__tag wp-block-paragraph"
								value={ tag }
								onChange={ set( 'tag' ) }
								placeholder={ __( 'Tag', 'bestwebexpert' ) }
								allowedFormats={ [] }
								disableLineBreaks
							/>
							<RichText
								tagName="h3"
								className="bwex-card__title"
								value={ name }
								onChange={ set( 'name' ) }
								placeholder={ __(
									'Product name',
									'bestwebexpert'
								) }
								allowedFormats={ [] }
								disableLineBreaks
							/>
							<div className="wp-block-group bwex-card__text">
								<RichText
									tagName="p"
									className="wp-block-paragraph"
									value={ text }
									onChange={ set( 'text' ) }
									placeholder={ __(
										'What it does',
										'bestwebexpert'
									) }
									allowedFormats={ [
										'core/bold',
										'core/italic',
										'core/link',
									] }
								/>
							</div>
							{ showLinks !== false && (
								<p className="bwex-card__links wp-block-paragraph">
									<RichText
										tagName="span"
										value={ linksLabel }
										onChange={ set( 'linksLabel' ) }
										placeholder={ __(
											'Live demos',
											'bestwebexpert'
										) }
										allowedFormats={ [] }
										disableLineBreaks
									/>{ ' ' }
									<RichText
										tagName="span"
										className="bwe-gw-card-links"
										value={ links }
										onChange={ set( 'links' ) }
										placeholder={ __(
											'Demo links (select a word, add a link)',
											'bestwebexpert'
										) }
										allowedFormats={ [ 'core/link' ] }
										disableLineBreaks
									/>
								</p>
							) }
							<RichText
								tagName="span"
								className="bwex-card__btn"
								value={ btnText }
								onChange={ set( 'btnText' ) }
								placeholder={ __(
									'Button text',
									'bestwebexpert'
								) }
								allowedFormats={ [] }
								disableLineBreaks
							/>
						</div>
					</article>
				</div>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
