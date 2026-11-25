<?php
/**
 * Registers every block built into build/blocks/<name>/ (source: src/blocks/<name>/, `npm run build`).
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * The built block.json files as one PHP array (build/blocks-manifest.php, made by `npm run build`), so a request
 * reads one cached PHP file instead of decoding 39 JSON files. Empty when the manifest is missing.
 *
 * @return array<string, array> Folder name => block.json data.
 */
function bwe_blocks_manifest() {
	static $manifest = null;
	if ( null === $manifest ) {
		$file     = BWE_GW_DIR . '/build/blocks-manifest.php';
		$manifest = is_file( $file ) ? (array) require $file : array();
	}
	return $manifest;
}

/**
 * Registers the shared editor script (all blocks in one bundle, src/editor.js) and the built blocks.
 */
function bwe_blocks_register() {
	$asset = BWE_GW_DIR . '/build/blocks/editor/index.asset.php';
	if ( is_file( $asset ) ) {
		$asset = require $asset;
		wp_register_script( 'bwe-gw-editor', plugins_url( 'build/blocks/editor/index.js', BWE_GW_DIR . '/bestwebexpert-gutenberg-widget.php' ), $asset['dependencies'], $asset['version'], false );
	}
	if ( bwe_blocks_manifest() && function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( BWE_GW_DIR . '/build/blocks', BWE_GW_DIR . '/build/blocks-manifest.php' );
		return;
	}
	foreach ( glob( BWE_GW_DIR . '/build/blocks/*/block.json' ) ?: array() as $json ) {
		register_block_type( dirname( $json ) );
	}
}
add_action( 'init', 'bwe_blocks_register' );

/**
 * "Best Web Expert" category, first in the block inserter: every block of this plugin is in it, so they can all be
 * found in one place (block.json "category": "bestwebexpert").
 *
 * @param array $categories Block categories.
 * @return array
 */
function bwe_blocks_category( $categories ) {
	foreach ( $categories as $category ) {
		if ( 'bestwebexpert' === ( $category['slug'] ?? '' ) ) {
			return $categories;
		}
	}
	array_unshift(
		$categories,
		array(
			'slug'  => 'bestwebexpert',
			'title' => __( 'Best Web Expert', 'bestwebexpert' ),
			'icon'  => null,
		)
	);
	return $categories;
}
add_filter( 'block_categories_all', 'bwe_blocks_category' );

/**
 * Category icon: the site's look in 24px — dark rounded square, white "B", lime dot. A custom SVG can only be
 * set from JavaScript (PHP accepts Dashicon names only).
 */
function bwe_blocks_category_icon() {
	wp_add_inline_script(
		'wp-blocks',
		'( function () {'
		. 'if ( ! window.wp || ! wp.blocks || ! wp.blocks.updateCategory || ! wp.element ) { return; }'
		. 'var el = wp.element.createElement;'
		. 'wp.blocks.updateCategory( "bestwebexpert", { icon: el( "svg", { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 24 24", width: 24, height: 24, "aria-hidden": "true", focusable: "false" },'
		. 'el( "rect", { x: 2, y: 2, width: 20, height: 20, rx: 5, fill: "#0b0b0c" } ),'
		. 'el( "path", { fill: "#ffffff", d: "M8 6.5h4.4c2.2 0 3.6 1.1 3.6 2.9 0 1.1-.6 1.9-1.5 2.3 1.2.4 1.9 1.3 1.9 2.6 0 2-1.5 3.2-3.9 3.2H8V6.5zm2.3 4.4h1.9c1 0 1.5-.4 1.5-1.2s-.5-1.2-1.5-1.2h-1.9v2.4zm0 4.6h2.1c1.1 0 1.7-.5 1.7-1.3 0-.9-.6-1.3-1.7-1.3h-2.1v2.6z" } ),'
		. 'el( "circle", { cx: 17.6, cy: 17.6, r: 2.2, fill: "#c8ff3d" } )'
		. ') } );'
		. '} )();'
	);
}
add_action( 'enqueue_block_editor_assets', 'bwe_blocks_category_icon' );

/**
 * Where the editor's icon picker loads its icon library from (build/icons/lucide.json, fetched only when the
 * picker opens).
 */
function bwe_blocks_icon_library_url() {
	wp_add_inline_script(
		'wp-blocks',
		'window.bweGw = Object.assign( window.bweGw || {}, ' . wp_json_encode( array( 'iconsUrl' => plugins_url( 'build/icons/lucide.json', BWE_GW_DIR . '/bestwebexpert-gutenberg-widget.php' ) ) ) . ' );',
		'before'
	);
}
add_action( 'enqueue_block_editor_assets', 'bwe_blocks_icon_library_url' );

/**
 * The video testimonial cards' stylesheet (BestWebExpert Home) in the editor canvas too, so a Testimonials block
 * shows the same 9:16 thumbnails with the play button as the live page. The front end loads it only where a video
 * is shown.
 */
function bwe_blocks_editor_video_style() {
	if ( ! is_admin() || ! defined( 'BWE_HOME_DIR' ) || ! is_file( BWE_HOME_DIR . '/assets/video-testimonials.css' ) ) {
		return;
	}
	wp_enqueue_style( 'bwe-gw-video-testimonials', plugins_url( 'assets/video-testimonials.css', BWE_HOME_DIR . '/bestwebexpert-home.php' ), array(), (string) filemtime( BWE_HOME_DIR . '/assets/video-testimonials.css' ) );
}
add_action( 'enqueue_block_assets', 'bwe_blocks_editor_video_style' );

/**
 * Text attributes each block lets a synced pattern override per page ("pattern overrides": the same pattern
 * with different words in different places, without touching the original). Used on render (WP_Block) and
 * in the editor (block editor settings), WP 6.9+. Structural attributes (step number, split layout, ids)
 * stay shared.
 */
const BWE_BLOCKS_OVERRIDABLE = array(
	'bwe/section-head' => array( 'eyebrow', 'title', 'intro' ),
	'bwe/step'         => array( 'title', 'text' ),
	'bwe/spec-card'    => array( 'name', 'text', 'chip' ),
	'bwe/who-card'     => array( 'title', 'text', 'tag', 'url' ),
	'bwe/price-row'    => array( 'service', 'note', 'amount', 'unit' ),
	'bwe/faq-item'     => array( 'question' ),
	'bwe/hero'         => array( 'kicker', 'title', 'lead', 'btn1Text', 'btn1Url', 'btn2Text', 'btn2Url' ),
	'bwe/services'     => array( 'eyebrow', 'title', 'lead', 'more' ),
	'bwe/service-tile' => array( 'tag', 'name', 'desc', 'url' ),
	'bwe/platform-card' => array( 'chip', 'title', 'titleUrl', 'text', 'price', 'btnText', 'btnUrl', 'badge' ),
	// Home section blocks (2026-11-23).
	'bwe/why-us'          => array( 'eyebrow', 'title', 'intro', 'aside' ),
	'bwe/testimonials'    => array( 'eyebrow', 'title', 'intro', 'more' ),
	'bwe/video-card'      => array( 'url', 'who' ),
	'bwe/pricing'         => array( 'eyebrow', 'title', 'intro' ),
	'bwe/price-plan'      => array( 'name', 'price', 'desc', 'badge', 'btnText', 'btnUrl' ),
	'bwe/starting-prices' => array( 'label', 'note', 'allText', 'allUrl' ),
	'bwe/cost-panel'      => array( 'title' ),
	'bwe/process'         => array( 'eyebrow', 'title', 'intro' ),
	'bwe/products'        => array( 'eyebrow', 'title', 'intro', 'more' ),
	'bwe/product-card'    => array( 'tag', 'name', 'text', 'linksLabel', 'links', 'btnText', 'btnUrl' ),
	'bwe/faq'             => array( 'eyebrow', 'title', 'intro', 'askText', 'askUrl' ),
	'bwe/cta'             => array( 'eyebrow', 'title', 'lead', 'btn1Text', 'btn1Url', 'btn2Text', 'btn2Url', 'chat', 'note' ),
	// Pricing page "Fixes & services" (2026-11-23).
	'bwe/price-section'   => array( 'eyebrow', 'title', 'intro' ),
	'bwe/price-card'      => array( 'chip', 'title', 'titleUrl', 'text', 'price', 'btnText', 'btnUrl' ),
	// Portfolio page "Selected work" (2026-11-23).
	'bwe/work'            => array( 'eyebrow', 'title', 'intro' ),
	'bwe/work-item'       => array( 'num', 'title', 'tag', 'text', 'url' ),
	// Contact page "Send a message" / "Who you'll be talking to" (2026-11-23).
	'bwe/contact-form'    => array( 'eyebrow', 'title', 'intro', 'note' ),
	'bwe/about'           => array( 'eyebrow', 'title', 'lead', 'cardTitle', 'btnText', 'btnUrl' ),
	// General-purpose blocks (2026-11-24).
	'bwe/media'           => array( 'url', 'alt', 'caption', 'link' ),
);

/**
 * Adds our blocks' text attributes to the attributes block bindings (and so pattern overrides) support.
 *
 * @param string[] $attributes Supported attributes.
 * @param string   $block_type Block name.
 * @return string[]
 */
function bwe_blocks_bindings_supported( $attributes, $block_type ) {
	return isset( BWE_BLOCKS_OVERRIDABLE[ $block_type ] ) ? array_values( array_unique( array_merge( (array) $attributes, BWE_BLOCKS_OVERRIDABLE[ $block_type ] ) ) ) : $attributes;
}
add_filter( 'block_bindings_supported_attributes', 'bwe_blocks_bindings_supported', 10, 2 );

/**
 * Tells admins when the plugin was copied without its build/ folder (the blocks would then be missing).
 */
function bwe_blocks_missing_build_notice() {
	if ( current_user_can( 'activate_plugins' ) && ! glob( BWE_GW_DIR . '/build/blocks/*/block.json' ) ) {
		echo '<div class="notice notice-error"><p>' . esc_html__( 'Best Web Expert Gutenberg Widget: the build/ folder is missing, so its blocks are not registered. Run "npm run build" in the plugin folder, or upload the built plugin.', 'bestwebexpert' ) . '</p></div>';
	}
}
add_action( 'admin_notices', 'bwe_blocks_missing_build_notice' );
