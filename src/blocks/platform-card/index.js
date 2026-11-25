import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import {
	Button,
	PanelBody,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import { withRoles } from '../shared/part-controls';
import metadata from './block.json';

const LIST_TEMPLATE = withRoles( [
	[ 'core/list', { className: 'bwex-checks' } ],
] );
const BADGE_STYLE = {
	position: 'absolute',
	top: 18,
	right: 18,
	zIndex: 2,
	padding: '6px 12px',
	borderRadius: 999,
	background: '#c8ff3d',
	color: '#0b0b0c',
	fontSize: 12,
	fontWeight: 600,
	letterSpacing: '.06em',
	lineHeight: 1.2,
	textTransform: 'uppercase',
};

// Links must not navigate while editing.
const stop = ( event ) => event.preventDefault();

function Edit( { attributes, setAttributes, clientId, isSelected } ) {
	const {
		wrapClasses,
		imageId,
		imageUrl,
		imageAlt,
		chip,
		title,
		titleUrl,
		text,
		price,
		btnText,
		btnUrl,
		btnNewTab,
		badge,
		bweStyle,
	} = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		bweStyle,
		clientId
	);
	const blockProps = useBlockProps( {
		className: [ 'wp-block-group', wrapClasses, className ]
			.filter( Boolean )
			.join( ' ' ),
		style: badge ? { position: 'relative' } : undefined,
	} );
	const listProps = useInnerBlocksProps(
		{ className: 'wp-block-group bwex-plat__list' },
		{
			allowedBlocks: [ 'core/list' ],
			template: LIST_TEMPLATE,
		}
	);
	const pickImage = ( media ) =>
		setAttributes( {
			imageId: media.id || 0,
			imageUrl:
				media.sizes?.large?.url || media.url || media.source_url || '',
			imageAlt: media.alt || imageAlt,
		} );
	const removeImage = () =>
		setAttributes( { imageId: 0, imageUrl: '', imageAlt: '' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Image', 'bestwebexpert' ) }>
					<MediaUploadCheck>
						<MediaUpload
							allowedTypes={ [ 'image' ] }
							value={ imageId }
							onSelect={ pickImage }
							render={ ( { open } ) => (
								<div
									style={ {
										display: 'flex',
										gap: 8,
										alignItems: 'center',
										marginBottom: 12,
									} }
								>
									{ imageUrl && (
										<img
											src={ imageUrl }
											alt=""
											style={ {
												width: 64,
												height: 40,
												objectFit: 'cover',
												borderRadius: 6,
											} }
										/>
									) }
									<Button
										variant="secondary"
										onClick={ open }
									>
										{ imageUrl
											? __( 'Replace', 'bestwebexpert' )
											: __(
													'Choose image',
													'bestwebexpert'
												) }
									</Button>
									{ imageUrl && (
										<Button
											variant="tertiary"
											isDestructive
											onClick={ removeImage }
										>
											{ __( 'Remove', 'bestwebexpert' ) }
										</Button>
									) }
								</div>
							) }
						/>
					</MediaUploadCheck>
					{ imageUrl && (
						<TextControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ __(
								'Alt text (describe the image)',
								'bestwebexpert'
							) }
							value={ imageAlt }
							onChange={ set( 'imageAlt' ) }
						/>
					) }
				</PanelBody>
				<PanelBody title={ __( 'Links', 'bestwebexpert' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __(
							'Title link (empty = no link)',
							'bestwebexpert'
						) }
						value={ titleUrl }
						onChange={ set( 'titleUrl' ) }
					/>
					<div style={ { height: 12 } } />
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Button link', 'bestwebexpert' ) }
						value={ btnUrl }
						onChange={ set( 'btnUrl' ) }
					/>
					<div style={ { height: 12 } } />
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Open the button link in a new tab',
							'bestwebexpert'
						) }
						checked={ btnNewTab }
						onChange={ set( 'btnNewTab' ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Badge', 'bestwebexpert' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Badge text', 'bestwebexpert' ) }
						help={ __(
							'A small label on the card corner, e.g. Popular or New. Leave empty for none. Its colours are in the Styles tab.',
							'bestwebexpert'
						) }
						value={ badge }
						onChange={ set( 'badge' ) }
					/>
				</PanelBody>{ ' ' }
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<div { ...blockProps }>
				{ css && <style>{ css }</style> }
				{ badge && (
					<span className="bwe-pc-badge" style={ BADGE_STYLE }>
						{ badge }
					</span>
				) }
				<div className="wp-block-group elementor-widget-container">
					<div className="wp-block-group bwex bwex-platw">
						<div className="wp-block-group bwex-plat">
							{ imageUrl && (
								<div className="wp-block-group bwex-plat__img">
									<img
										src={ imageUrl }
										alt={ imageAlt }
										className={ `attachment-large size-large${
											imageId
												? ' wp-image-' + imageId
												: ''
										}` }
									/>
								</div>
							) }
							{ ! imageUrl && isSelected && (
								<MediaUploadCheck>
									<MediaUpload
										allowedTypes={ [ 'image' ] }
										onSelect={ pickImage }
										render={ ( { open } ) => (
											<div style={ { padding: 12 } }>
												<Button
													variant="secondary"
													onClick={ open }
												>
													{ __(
														'+ Add image (optional)',
														'bestwebexpert'
													) }
												</Button>
											</div>
										) }
									/>
								</MediaUploadCheck>
							) }
							<div className="wp-block-group bwex-plat__chipwrap">
								<RichText
									tagName="p"
									className="bwex-plat__chip wp-block-paragraph"
									value={ chip }
									onChange={ set( 'chip' ) }
									placeholder={ __(
										'Chip, e.g. WordPress',
										'bestwebexpert'
									) }
									allowedFormats={ [] }
									disableLineBreaks
								/>
							</div>
							<div className="wp-block-group bwex-h3">
								<h3 className="elementor-heading-title">
									{ titleUrl ? (
										<a href={ titleUrl } onClick={ stop }>
											<RichText
												tagName="span"
												value={ title }
												onChange={ set( 'title' ) }
												placeholder={ __(
													'Card title',
													'bestwebexpert'
												) }
												allowedFormats={ [
													'core/italic',
												] }
												disableLineBreaks
											/>
										</a>
									) : (
										<RichText
											tagName="span"
											value={ title }
											onChange={ set( 'title' ) }
											placeholder={ __(
												'Card title',
												'bestwebexpert'
											) }
											allowedFormats={ [ 'core/italic' ] }
											disableLineBreaks
										/>
									) }
								</h3>
							</div>
							<div className="wp-block-group bwex-plat__text">
								<RichText
									tagName="p"
									className="wp-block-paragraph"
									value={ text }
									onChange={ set( 'text' ) }
									placeholder={ __(
										'One or two lines about this card.',
										'bestwebexpert'
									) }
									allowedFormats={ [
										'core/bold',
										'core/italic',
										'core/link',
									] }
								/>
							</div>
							<div { ...listProps } />
							<div className="wp-block-group bwex-plat__foot">
								<RichText
									tagName="p"
									className="bwex-plat__price wp-block-paragraph"
									value={ price }
									onChange={ set( 'price' ) }
									placeholder={ __(
										'Starting at $250 (make the amount bold)',
										'bestwebexpert'
									) }
									allowedFormats={ [ 'core/bold' ] }
									disableLineBreaks
								/>
								<div className="bwex-btn">
									{  }
									<a
										className="elementor-button elementor-button-link elementor-size-sm"
										href={ btnUrl || '#' }
										onClick={ stop }
									>
										<span className="elementor-button-content-wrapper">
											<RichText
												tagName="span"
												className="elementor-button-text"
												value={ btnText }
												onChange={ set( 'btnText' ) }
												placeholder={ __(
													'Button text',
													'bestwebexpert'
												) }
												allowedFormats={ [] }
												disableLineBreaks
											/>
										</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
