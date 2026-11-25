import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	RichText,
	useBlockEditingMode,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	Button,
	PanelBody,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import { useEffect } from '@wordpress/element';
import useSiblingNumber from '../shared/use-sibling-number';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import metadata from './block.json';

// Links must not navigate while editing.
const stop = ( event ) => event.preventDefault();

function Edit( { attributes, setAttributes, clientId, isSelected } ) {
	const { num, imageId, imageUrl, imageAlt, url, newTab, title, tag, text } =
		attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const number = useSiblingNumber( clientId, 'bwe/work-item' );
	// This project's own colours (Styles tab).
	const own = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const editable = useBlockEditingMode() === 'default';

	// Keep 01, 02 … in order when projects move (as the steps and FAQ questions do).
	useEffect( () => {
		if ( editable && number && number !== num ) {
			setAttributes( { num: number } );
		}
	}, [ editable, number, num, setAttributes ] );

	const pickImage = ( media ) =>
		setAttributes( {
			imageId: media.id || 0,
			imageUrl: media.url || media.source_url || '',
			imageAlt: media.alt || imageAlt,
		} );
	const imagePicker = ( label ) => (
		<MediaUploadCheck>
			<MediaUpload
				allowedTypes={ [ 'image' ] }
				value={ imageId }
				onSelect={ pickImage }
				render={ ( { open } ) => (
					<Button variant="secondary" onClick={ open }>
						{ label }
					</Button>
				) }
			/>
		</MediaUploadCheck>
	);
	const linked = ( inner ) =>
		url ? (
			<a href={ url } onClick={ stop }>
				{ inner }
			</a>
		) : (
			inner
		);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Project', 'bestwebexpert' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __(
							'Link (screenshot and title)',
							'bestwebexpert'
						) }
						value={ url }
						onChange={ set( 'url' ) }
					/>
					<div style={ { height: 12 } } />
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Open in a new tab', 'bestwebexpert' ) }
						checked={ newTab }
						onChange={ set( 'newTab' ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Screenshot', 'bestwebexpert' ) }>
					{ imageUrl && (
						<img
							src={ imageUrl }
							alt=""
							style={ {
								width: '100%',
								borderRadius: 8,
								marginBottom: 8,
							} }
						/>
					) }
					<div
						style={ { display: 'flex', gap: 8, marginBottom: 12 } }
					>
						{ imagePicker(
							imageUrl
								? __( 'Replace', 'bestwebexpert' )
								: __( 'Choose screenshot', 'bestwebexpert' )
						) }
						{ imageUrl && (
							<Button
								variant="tertiary"
								isDestructive
								onClick={ () =>
									setAttributes( {
										imageId: 0,
										imageUrl: '',
										imageAlt: '',
									} )
								}
							>
								{ __( 'Remove', 'bestwebexpert' ) }
							</Button>
						) }
					</div>
					{ imageUrl && (
						<TextControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ __(
								'Alt text (describe the screenshot)',
								'bestwebexpert'
							) }
							value={ imageAlt }
							onChange={ set( 'imageAlt' ) }
						/>
					) }
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
						'wp-block-group bwex-work__item',
						own.className,
					]
						.filter( Boolean )
						.join( ' ' ),
				} ) }
			>
				{ own.css && <style>{ own.css }</style> }
				{ imageUrl && (
					<figure className="wp-block-image size-full bwex-work__shot">
						{ linked(
							<img
								src={ imageUrl }
								alt={ imageAlt }
								className={
									imageId
										? `wp-image-${ imageId }`
										: undefined
								}
							/>
						) }
					</figure>
				) }
				{ ! imageUrl && isSelected && (
					<div style={ { gridRow: '1 / 3' } }>
						{ imagePicker( __( '+ Screenshot', 'bestwebexpert' ) ) }
					</div>
				) }
				<div className="wp-block-group bwex-work__meta">
					<p className="bwex-work__num wp-block-paragraph">{ num }</p>
					<h3 className="wp-block-heading bwex-work__title">
						{ linked(
							<RichText
								tagName="span"
								value={ title }
								onChange={ set( 'title' ) }
								placeholder={ __(
									'Project name',
									'bestwebexpert'
								) }
								allowedFormats={ [] }
								disableLineBreaks
							/>
						) }
					</h3>
					<RichText
						tagName="p"
						className="bwex-work__tag wp-block-paragraph"
						value={ tag }
						onChange={ set( 'tag' ) }
						placeholder={ __(
							'Tag, e.g. Website',
							'bestwebexpert'
						) }
						allowedFormats={ [] }
						disableLineBreaks
					/>
				</div>
				<RichText
					tagName="p"
					className="bwex-work__text wp-block-paragraph"
					value={ text }
					onChange={ set( 'text' ) }
					placeholder={ __(
						'One line about the project.',
						'bestwebexpert'
					) }
					allowedFormats={ [ 'core/bold', 'core/italic' ] }
				/>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
