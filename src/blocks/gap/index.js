import { __, sprintf } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {
	PanelBody,
	ToggleControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis -- core blocks use the same unit input.
	__experimentalUnitControl as UnitControl,
} from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import metadata from './block.json';

const UNITS = [ 'px', 'rem', 'em', 'vh', 'vw' ].map( ( value ) => ( {
	value,
	label: value,
} ) );
const HEIGHTS = [
	[ 'height', __( 'Height on desktop', 'bestwebexpert' ), '64px' ],
	[ 'heightTablet', __( 'Height on tablet', 'bestwebexpert' ), '48px' ],
	[ 'heightMobile', __( 'Height on phone', 'bestwebexpert' ), '32px' ],
];

function Edit( { attributes, setAttributes, clientId } ) {
	const style = attributes.bweStyle || {};
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		style,
		clientId
	);
	const setStyle = ( key, value ) => {
		const next = { ...style, [ key ]: value };
		if ( ! value ) {
			delete next[ key ];
		}
		setAttributes( { bweStyle: next } );
	};
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Gap', 'bestwebexpert' ) }>
					{ HEIGHTS.map( ( [ key, label, normal ] ) => (
						<div key={ key } style={ { marginBottom: 16 } }>
							<UnitControl
								__next40pxDefaultSize
								label={ label }
								help={ sprintf(
									/* translators: %s: the default height, e.g. 64px. */
									__( 'Empty = %s', 'bestwebexpert' ),
									normal
								) }
								value={ style[ key ] || '' }
								units={ UNITS }
								onChange={ ( v ) => setStyle( key, v || '' ) }
							/>
						</div>
					) ) }
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Show a divider line', 'bestwebexpert' ) }
						help={ __(
							'Colour, thickness, length and style: Styles tab → Line.',
							'bestwebexpert'
						) }
						checked={ !! attributes.line }
						onChange={ ( v ) => setAttributes( { line: v } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ style }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<div
				{ ...useBlockProps( {
					className: [
						'bwe-gw-gap',
						attributes.line && 'bwe-gw-gap--line',
						className,
					]
						.filter( Boolean )
						.join( ' ' ),
					'aria-hidden': true,
				} ) }
			>
				{ css && <style>{ css }</style> }
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
