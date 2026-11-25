import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import metadata from './block.json';

const TEMPLATE = [
	[ 'bwe/price-plan' ],
	[ 'bwe/price-plan', { featured: true } ],
	[ 'bwe/price-plan' ],
];

function Edit( { attributes, setAttributes, clientId } ) {
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const props = useInnerBlocksProps(
		useBlockProps( {
			className: [
				'wp-block-group elementor-element elementor-element-e077279 e-con-full bwex-plans e-flex e-con e-child',
				className,
			]
				.filter( Boolean )
				.join( ' ' ),
		} ),
		{
			allowedBlocks: [ 'bwe/price-plan' ],
			template: TEMPLATE,
			orientation: 'horizontal',
		}
	);
	return (
		<>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ attributes.bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			{ css && <style>{ css }</style> }
			<div { ...props } />
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
