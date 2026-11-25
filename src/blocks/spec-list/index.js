import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import useBlockStyle from '../shared/use-block-style';
import metadata from './block.json';

const TEMPLATE = [
	[ 'bwe/spec-card' ],
	[ 'bwe/spec-card' ],
	[ 'bwe/spec-card' ],
];

function Edit( { attributes, clientId } ) {
	// Items per row (Settings → Items per row): scoped CSS, as on the site.
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const { children, ...innerBlocksProps } = useInnerBlocksProps(
		useBlockProps( {
			className: [ 'wp-block-list bwex-spec__list', className ]
				.filter( Boolean )
				.join( ' ' ),
		} ),
		{
			allowedBlocks: [ 'bwe/spec-card' ],
			template: TEMPLATE,
		}
	);
	return (
		<ul { ...innerBlocksProps }>
			{ css && <style>{ css }</style> }
			{ children }
		</ul>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
