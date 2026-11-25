import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { RichText, useBlockProps } from '@wordpress/block-editor';
import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const { service } = attributes;
	const field = ( key, tagName, placeholder, formats = [] ) => (
		<RichText
			tagName={ tagName }
			value={ attributes[ key ] }
			onChange={ ( value ) => setAttributes( { [ key ]: value } ) }
			placeholder={ placeholder }
			allowedFormats={ formats }
			disableLineBreaks
		/>
	);
	// Same elements as on the site, so pricing.css lays the row out the same way: service left, price right.
	return (
		<li { ...useBlockProps() }>
			<span className="bwe-prx__svc">
				<RichText
					tagName="span"
					value={ service }
					onChange={ ( value ) =>
						setAttributes( { service: value } )
					}
					placeholder={ __( 'Service', 'bestwebexpert' ) }
					allowedFormats={ [ 'core/link' ] }
					disableLineBreaks
				/>{ ' ' }
				{ field(
					'note',
					'small',
					__( 'Turnaround', 'bestwebexpert' )
				) }
			</span>{ ' ' }
			<strong className="bwe-prx__amt">
				{ field( 'amount', 'span', '$0' ) }{ ' ' }
				{ field( 'unit', 'em', __( '/ unit', 'bestwebexpert' ) ) }
			</strong>
		</li>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
