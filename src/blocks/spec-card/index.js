import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { RichText, useBlockProps } from '@wordpress/block-editor';
import metadata from './block.json';

const FORMATS = [ 'core/bold', 'core/italic', 'core/link' ];

function Edit( { attributes, setAttributes, isSelected } ) {
	const { name, text, chip } = attributes;
	return (
		<li { ...useBlockProps() }>
			<RichText
				tagName="strong"
				className="bwex-spec__name"
				value={ name }
				onChange={ ( value ) => setAttributes( { name: value } ) }
				placeholder={ __( 'Name', 'bestwebexpert' ) }
				allowedFormats={ FORMATS }
				disableLineBreaks
			/>
			<RichText
				tagName="span"
				className="bwex-spec__text"
				value={ text }
				onChange={ ( value ) => setAttributes( { text: value } ) }
				placeholder={ __(
					'One or two lines in plain words.',
					'bestwebexpert'
				) }
				allowedFormats={ FORMATS }
			/>
			{ /* The tag is optional: like on the site, it is only shown when it has text (or while editing the card). */ }
			{ ( chip || isSelected ) && (
				<RichText
					tagName="code"
					value={ chip }
					onChange={ ( value ) => setAttributes( { chip: value } ) }
					placeholder={ __( 'Tag (optional)', 'bestwebexpert' ) }
					allowedFormats={ [] }
					disableLineBreaks
				/>
			) }
		</li>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
