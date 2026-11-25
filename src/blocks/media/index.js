import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	BlockControls,
	InspectorControls,
	MediaPlaceholder,
	MediaReplaceFlow,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	TextControl,
	TextareaControl,
	ToggleControl,
} from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import metadata from './block.json';

const FRAMES = [
	{ label: __( 'Plain', 'bestwebexpert' ), value: '' },
	{ label: __( 'Rounded corners', 'bestwebexpert' ), value: 'rounded' },
	{
		label: __( 'Screenshot (rounded, border, shadow)', 'bestwebexpert' ),
		value: 'shot',
	},
	{ label: __( 'Browser window', 'bestwebexpert' ), value: 'browser' },
];
const RATIOS = [
	{ label: __( 'Original shape', 'bestwebexpert' ), value: '' },
	{ label: '16:9', value: '16/9' },
	{ label: '21:9', value: '21/9' },
	{ label: '4:3', value: '4/3' },
	{ label: '3:2', value: '3/2' },
	{ label: __( '1:1 (square)', 'bestwebexpert' ), value: '1/1' },
	{ label: '3:4', value: '3/4' },
	{ label: '2:3', value: '2/3' },
	{ label: __( '9:16 (phone, reel)', 'bestwebexpert' ), value: '9/16' },
];
const SIZES = [
	{ label: __( 'Medium (300px)', 'bestwebexpert' ), value: 'medium' },
	{
		label: __( 'Medium large (768px)', 'bestwebexpert' ),
		value: 'medium_large',
	},
	{ label: __( 'Large (1024px)', 'bestwebexpert' ), value: 'large' },
	{ label: __( 'Full size (original)', 'bestwebexpert' ), value: 'full' },
];

function Edit( { attributes, setAttributes, clientId, isSelected } ) {
	const {
		id,
		url,
		alt,
		caption,
		size,
		frame,
		barText,
		ratio,
		fit,
		align,
		link,
		linkNewTab,
		priority,
	} = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const onSelect = ( media ) => {
		if ( ! media || ! media.url ) {
			return;
		}
		const sized =
			media.sizes?.[ size ]?.url || media.sizes?.large?.url || media.url;
		setAttributes( {
			id: media.id || 0,
			url: sized,
			alt: alt || media.alt || '',
		} );
	};
	const classes = [
		'wp-block-image',
		'bwe-gw-media',
		`bwe-gw-media--${ align || 'center' }`,
		frame && `bwe-gw-media--${ frame }`,
		frame === 'shot' && 'bwe-shot',
		ratio && `bwe-gw-ratio-${ ratio.replace( '/', '-' ) }`,
		ratio && fit === 'contain' && 'bwe-gw-fit-contain',
		className,
	]
		.filter( Boolean )
		.join( ' ' );
	// One useBlockProps call for both states (hooks must run in the same order on every render).
	const blockProps = useBlockProps( url ? { className: classes } : {} );

	if ( ! url ) {
		return (
			<div { ...blockProps }>
				<MediaPlaceholder
					icon="format-image"
					labels={ {
						title: __( 'Image / screenshot', 'bestwebexpert' ),
						instructions: __(
							'Upload an image, pick one from the media library, or paste a link.',
							'bestwebexpert'
						),
					} }
					accept="image/*"
					allowedTypes={ [ 'image' ] }
					onSelect={ onSelect }
					onSelectURL={ ( u ) => setAttributes( { id: 0, url: u } ) }
				/>
			</div>
		);
	}

	const img = <img className="bwe-gw-media__img" src={ url } alt={ alt } />;
	const framed =
		frame === 'browser' ? (
			<div className="bwe-gw-media__frame">
				<div className="bwe-gw-media__bar" aria-hidden="true">
					<i></i>
					<i></i>
					<i></i>
					{ barText && <span>{ barText }</span> }
				</div>
				{ img }
			</div>
		) : (
			img
		);
	return (
		<>
			<BlockControls group="other">
				<MediaReplaceFlow
					mediaId={ id }
					mediaURL={ url }
					allowedTypes={ [ 'image' ] }
					accept="image/*"
					onSelect={ onSelect }
					onSelectURL={ ( u ) => setAttributes( { id: 0, url: u } ) }
				/>
			</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Image', 'bestwebexpert' ) }>
					<TextareaControl
						__nextHasNoMarginBottom
						label={ __(
							'Alt text (for Google and screen readers)',
							'bestwebexpert'
						) }
						help={ __(
							'Say what the image shows, e.g. “ProductReels video grid on a WooCommerce product page”. Empty = the media library’s alt text.',
							'bestwebexpert'
						) }
						value={ alt }
						onChange={ set( 'alt' ) }
					/>
					{ id > 0 && (
						<SelectControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ __( 'Image file size to load',
								'bestwebexpert'
							) }
							help={ __(
								'Phones still get a smaller file (srcset).',
								'bestwebexpert'
							) }
							value={ size }
							options={ SIZES }
							onChange={ set( 'size' ) }
						/>
					) }
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Load it first (image is at the top of the page)',
							'bestwebexpert'
						) }
						help={ __(
							'For the first big image of a page: no lazy loading, high priority. Leave off for images further down.',
							'bestwebexpert'
						) }
						checked={ !! priority }
						onChange={ set( 'priority' ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Look', 'bestwebexpert' ) }>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Frame', 'bestwebexpert' ) }
						value={ frame }
						options={ FRAMES }
						onChange={ set( 'frame' ) }
					/>
					{ frame === 'browser' && (
						<TextControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ __( 'Address bar text', 'bestwebexpert' ) }
							value={ barText }
							onChange={ set( 'barText' ) }
							placeholder="example.com"
						/>
					) }
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Shape', 'bestwebexpert' ) }
						value={ ratio }
						options={ RATIOS }
						onChange={ set( 'ratio' ) }
					/>
					{ ratio && (
						<SelectControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ __( 'Fit', 'bestwebexpert' ) }
							value={ fit }
							options={ [
								{
									label: __(
										'Fill the shape (crop)',
										'bestwebexpert'
									),
									value: 'cover',
								},
								{
									label: __(
										'Show the whole image',
										'bestwebexpert'
									),
									value: 'contain',
								},
							] }
							onChange={ set( 'fit' ) }
						/>
					) }
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Alignment', 'bestwebexpert' ) }
						value={ align }
						options={ [
							{
								label: __( 'Centre', 'bestwebexpert' ),
								value: 'center',
							},
							{
								label: __( 'Left', 'bestwebexpert' ),
								value: 'left',
							},
							{
								label: __( 'Right', 'bestwebexpert' ),
								value: 'right',
							},
							{
								label: __(
									'Full width of the column',
									'bestwebexpert'
								),
								value: 'wide',
							},
						] }
						onChange={ set( 'align' ) }
					/>
				</PanelBody>
				<PanelBody
					title={ __( 'Link', 'bestwebexpert' ) }
					initialOpen={ false }
				>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Image links to', 'bestwebexpert' ) }
						value={ link }
						onChange={ set( 'link' ) }
					/>
					{ link && (
						<ToggleControl
							__nextHasNoMarginBottom
							label={ __( 'Open in a new tab', 'bestwebexpert' ) }
							checked={ !! linkNewTab }
							onChange={ set( 'linkNewTab' ) }
						/>
					) }
				</PanelBody>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ attributes.bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<figure { ...blockProps }>
				{ css && <style>{ css }</style> }
				{ framed }
				{ ( caption || isSelected ) && (
					<RichText
						tagName="figcaption"
						className="wp-element-caption"
						value={ caption }
						onChange={ set( 'caption' ) }
						placeholder={ __(
							'Caption (optional)',
							'bestwebexpert'
						) }
						allowedFormats={ [
							'core/bold',
							'core/italic',
							'core/link',
						] }
					/>
				) }
			</figure>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
	example: {
		attributes: {
			url: window?.bweGw?.exampleImage || '',
			alt: '',
			frame: 'shot',
		},
		viewportWidth: 800,
	},
} );
