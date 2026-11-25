import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import useBlockStyle from '../shared/use-block-style';
import metadata from './block.json';

function Edit( { attributes, clientId } ) {
	// Items per row (Settings → Items per row): scoped CSS, as on the site.
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const { children, ...innerBlocksProps } = useInnerBlocksProps(
		useBlockProps( {
			className: [ `bwex-num ${ attributes.modifiers }`, className ]
				.filter( Boolean )
				.join( ' ' ),
		} ),
		{
			allowedBlocks: [ 'bwe/step' ],
			template: [
				[ 'bwe/step' ],
				[ 'bwe/step' ],
				[ 'bwe/step' ],
				[ 'bwe/step' ],
			],
			orientation: 'horizontal',
		}
	);
	return (
		<ol { ...innerBlocksProps } start="1">
			{ css && <style>{ css }</style> }
			{ children }
		</ol>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
