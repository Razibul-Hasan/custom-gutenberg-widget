import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';
import metadata from './block.json';
import Edit from './edit';

registerBlockType( metadata.name, {
	edit: Edit,
	// Dynamic block: only the answer blocks are saved; render.php prints the HTML.
	save: () => <InnerBlocks.Content />,
} );
