import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis -- the link picker core blocks use.
	__experimentalLinkControl as LinkControl,
} from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const { url, title, text, tag } = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Card link', 'bestwebexpert' ) }>
					{ LinkControl ? (
						<LinkControl
							value={ { url } }
							onChange={ ( next ) =>
								setAttributes( { url: next.url || '' } )
							}
							settings={ [] }
						/>
					) : (
						<TextControl
							__nextHasNoMarginBottom
							label={ __( 'Link URL', 'bestwebexpert' ) }
							value={ url }
							onChange={ set( 'url' ) }
						/>
					) }
				</PanelBody>
			</InspectorControls>
			<li { ...useBlockProps() }>
				{ /* Same <a> as on the site (so the card styles apply); clicking it in the editor must not navigate. */ }
				<a
					href={ url || '#' }
					onClick={ ( event ) => event.preventDefault() }
				>
					<RichText
						tagName="strong"
						value={ title }
						onChange={ set( 'title' ) }
						placeholder={ __( 'Who', 'bestwebexpert' ) }
						allowedFormats={ [] }
						disableLineBreaks
					/>{ ' ' }
					<RichText
						tagName="span"
						value={ text }
						onChange={ set( 'text' ) }
						placeholder={ __(
							'What they need, in one line.',
							'bestwebexpert'
						) }
						allowedFormats={ [ 'core/bold', 'core/italic' ] }
					/>{ ' ' }
					<RichText
						tagName="em"
						value={ tag }
						onChange={ set( 'tag' ) }
						placeholder={ __( 'Platform', 'bestwebexpert' ) }
						allowedFormats={ [] }
						disableLineBreaks
					/>
				</a>
			</li>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
