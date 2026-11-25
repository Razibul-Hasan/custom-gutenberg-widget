/**
 * One editor bundle for all blocks (src/editor.js → build/blocks/editor/index.js) instead of one per block.
 * block.json files and render.php are still copied to build/blocks/<name>/ by @wordpress/scripts (--webpack-copy-php);
 * every block.json names the shared script handle "bwe-gw-editor" (registered in includes/blocks.php).
 */
const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
	...defaultConfig,
	entry: {
		'editor/index': path.resolve( __dirname, 'src/editor.js' ),
	},
	// Editor-only bundle (never loaded on the site): ~320 KB for all blocks, down from ~1.1 MB in 39 bundles.
	performance: { ...defaultConfig.performance, maxAssetSize: 520000, maxEntrypointSize: 520000 },
};
