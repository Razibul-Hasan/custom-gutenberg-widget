import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import metadata from './block.json';

function Edit() {
	const innerBlocksProps = useInnerBlocksProps(
		useBlockProps( { className: 'wp-block-list bwe-prx__list' } ),
		{
			allowedBlocks: [ 'bwe/price-row' ],
			template: [ [ 'bwe/price-row' ] ],
		}
	);
	return <ul { ...innerBlocksProps } />;
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
