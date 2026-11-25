/**
 * The editor script of every block, as one bundle (build/blocks/editor/index.js, handle "bwe-gw-editor").
 *
 * Each block used to be its own bundle, and each of those carried its own copy of the shared code (Styles panels,
 * icon picker, labels …): 39 requests and about 1.1 MB in the editor. One bundle loads the shared code once.
 * A new block only needs its folder in src/blocks/ with an index.js — it is picked up here automatically.
 */
import './blocks/shared/global-controls';
import './page-layout';
import './blocks/shared/part-controls';

const blocks = require.context(
	'./blocks',
	true,
	/^\.\/[a-z0-9-]+\/index\.js$/
);
blocks.keys().forEach( blocks );
