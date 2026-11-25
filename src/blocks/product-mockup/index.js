import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import metadata from './block.json';

const ARTS = [
	{
		label: __( 'ProductBoxes — box builder', 'bestwebexpert' ),
		value: 'boxes',
	},
	{
		label: __( 'ProductReels — phone with reels', 'bestwebexpert' ),
		value: 'reels',
	},
	{ label: __( 'MigrateLift — site move', 'bestwebexpert' ), value: 'lift' },
];

function Edit( { attributes, setAttributes } ) {
	const markup = ( window.bweGw?.productArt || {} )[ attributes.art ] || '';
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Mockup', 'bestwebexpert' ) }>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Which plugin', 'bestwebexpert' ) }
						value={ attributes.art }
						options={ ARTS }
						onChange={ ( art ) => setAttributes( { art } ) }
					/>
				</PanelBody>
			</InspectorControls>
			{ /* Fixed markup from the site (includes/product-art.php), no user HTML. */ }
			<div
				{ ...useBlockProps() }
				dangerouslySetInnerHTML={ { __html: markup } }
			/>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit, save: () => null } );
