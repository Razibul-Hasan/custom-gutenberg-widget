<?php
/**
 * Widget pages: a page built from our blocks looks like Home on the site, without any extra setup.
 *
 * Home and the pages made from its patterns start with a wrapper group ("bwe-h2x" + "bwe-home bwex") and use
 * Astra's full-width layout without a page title. The site's section CSS needs all of that: the bwe-h2x marker
 * loads the stylesheets and the bwe-h2x-page body class, the .bwex wrapper scopes the rules. A new page made
 * from our widgets had none of it, so its sections showed unstyled (the editor already adds the wrapper itself,
 * see BestWebExpert Home's bwe_h2x_editor_script()). Here the front end does the same:
 * - the page's expanded content gets the bwe-h2x / bwe-home markers (styles, body class);
 * - the rendered content is wrapped in Home's two wrapper groups;
 * - when the page starts with one of our blocks and has no own Astra settings: full width, no page title.
 * Pages that already have the wrapper (Home, every existing page) are left exactly as they are.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

const BWE_GW_WIDGET_PAGE_MARK = '<!-- bwe-gw-widget-page bwe-h2x bwe-home -->';

/**
 * Adds the markers to the expanded content of a page that uses our blocks but has no Home wrapper.
 * Runs before the content readers (priority 10), while the block comments are still there.
 *
 * @param string $content Expanded content.
 */
function bwe_gw_widget_page_markers( $content ) {
	$content = (string) $content;
	if ( false !== strpos( $content, '<!-- wp:bwe/' ) && ! preg_match( '/bwe-h2x(?![\w-])/', $content ) ) {
		$content .= "\n" . BWE_GW_WIDGET_PAGE_MARK;
	}
	return $content;
}
add_filter( 'bwe_post_content_expanded', 'bwe_gw_widget_page_markers', 5 );

/**
 * Whether the post is a widget page (uses our blocks, no Home wrapper of its own).
 *
 * @param int $post_id Post ID (0 = the queried object).
 */
function bwe_gw_is_widget_page( $post_id = 0 ) {
	if ( is_admin() || ! function_exists( 'bwe_post_content_expanded' ) ) {
		return false;
	}
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	return $post_id > 0 && false !== strpos( bwe_post_content_expanded( $post_id ), BWE_GW_WIDGET_PAGE_MARK );
}

/**
 * Wraps a widget page's content in Home's wrapper groups (the site's section CSS is scoped to them).
 *
 * @param string $content Rendered content.
 */
function bwe_gw_widget_page_wrap( $content ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() || get_the_ID() !== (int) get_queried_object_id() || ! bwe_gw_is_widget_page() ) {
		return $content;
	}
	return '<div class="wp-block-group alignfull elementor elementor-517 bwe-h2x bwe-prx bwe-gw-page">' // bwe-prx: the Price list's styles are scoped to it.
		. '<div class="wp-block-group elementor-element elementor-element-1001dd3 e-con-full bwe-home bwex e-flex e-con e-parent">'
		. $content
		. '</div></div>';
}
add_filter( 'the_content', 'bwe_gw_widget_page_wrap', 12 );

/**
 * Whether a widget page starts with one of our blocks (then it brings its own top section: no page title,
 * full width), and the page has no Astra layout settings of its own.
 *
 * @param string $meta Astra meta key the owner may have set.
 */
function bwe_gw_widget_page_takes_over( $meta ) {
	if ( ! is_singular() || ! bwe_gw_is_widget_page() ) {
		return false;
	}
	$id = (int) get_queried_object_id();
	if ( ! in_array( (string) get_post_meta( $id, $meta, true ), array( '', 'default' ), true ) ) { // Astra's registered default is 'default' = not set.
		return false;
	}
	return 0 === strpos( bwe_gw_first_block( $id ), 'bwe/' );
}

add_filter(
	'astra_the_title_enabled',
	static fn( $on ) => bwe_gw_widget_page_takes_over( 'site-post-title' ) ? false : $on
);
add_filter(
	'astra_get_content_layout',
	static fn( $layout ) => bwe_gw_widget_page_takes_over( 'ast-site-content-layout' ) && in_array( (string) get_post_meta( (int) get_queried_object_id(), 'site-content-layout', true ), array( '', 'default' ), true ) ? 'page-builder' : $layout
);
add_filter(
	'astra_page_layout',
	static fn( $layout ) => bwe_gw_widget_page_takes_over( 'site-sidebar-layout' ) ? 'no-sidebar' : $layout
);

/**
 * First top-level block of the page ('' when none).
 *
 * @param int $id Post ID.
 */
function bwe_gw_first_block( $id ) {
	static $first = array();
	if ( ! isset( $first[ $id ] ) ) {
		// 'raw': the saved blocks, not the readers' markup Rank Math is given while wp_head runs (content-readers.php).
		$blocks       = array_values( array_filter( parse_blocks( (string) get_post_field( 'post_content', $id, 'raw' ) ), static fn( $b ) => ! empty( $b['blockName'] ) ) );
		$first[ $id ] = (string) ( $blocks[0]['blockName'] ?? '' );
	}
	return $first[ $id ];
}

/**
 * The transparent header floats over a dark hero; a widget page that starts with anything else (light
 * sections) keeps the solid header, so the menu stays readable. The page's own "solid header" setting still wins.
 *
 * @param bool $solid Solid header.
 */
function bwe_gw_widget_page_solid_header( $solid ) {
	return $solid || ( is_singular() && bwe_gw_is_widget_page() && 'bwe/hero' !== bwe_gw_first_block( (int) get_queried_object_id() ) );
}
add_filter( 'bwe_hf_is_solid', 'bwe_gw_widget_page_solid_header' );

/**
 * Body class for widget pages (used by the small layout fix below).
 *
 * @param string[] $classes Body classes.
 */
function bwe_gw_widget_page_body_class( $classes ) {
	if ( is_singular() && bwe_gw_is_widget_page() ) {
		$classes[] = 'bwe-gw-widget-page';
	}
	return $classes;
}
add_filter( 'body_class', 'bwe_gw_widget_page_body_class' );

/**
 * Astra gives full-width pages without their own layout setting a 20px article padding; Home has none, so
 * widget pages drop it (sections go edge to edge, like Home).
 */
function bwe_gw_widget_page_css() {
	if ( is_singular() && bwe_gw_is_widget_page() && wp_style_is( 'bwe-home', 'enqueued' ) ) {
		wp_add_inline_style( 'bwe-home', 'body.bwe-gw-widget-page.ast-page-builder-template .site-main>article{padding:0}' );
	}
}
add_action( 'wp_enqueue_scripts', 'bwe_gw_widget_page_css', 99 );

/**
 * Widget-page stylesheet (Section "Dark" style + parts placed straight on a page): in the editor, and on pages
 * that are widget pages or use the Dark section style.
 */
function bwe_gw_widget_page_stylesheet() {
	$url = plugins_url( 'assets/css/widget-page.css', BWE_GW_DIR . '/bestwebexpert-gutenberg-widget.php' );
	$ver = (string) filemtime( BWE_GW_DIR . '/assets/css/widget-page.css' );
	if ( is_admin() ) {
		wp_enqueue_style( 'bwe-gw-widget-page', $url, array(), $ver );
		return;
	}
	// Block attributes save "--" as --, so look for the class name's start only.
	if ( is_singular() && function_exists( 'bwe_post_content_expanded' ) && ( bwe_gw_is_widget_page() || false !== strpos( bwe_post_content_expanded( (int) get_queried_object_id() ), 'bwe-gw-tone' ) ) ) {
		wp_enqueue_style( 'bwe-gw-widget-page', $url, wp_style_is( 'bwe-home', 'registered' ) ? array( 'bwe-home' ) : array(), $ver );
	}
}
add_action( 'enqueue_block_assets', 'bwe_gw_widget_page_stylesheet', 40 );

/**
 * Home's hero and services patterns keep three wrapper groups around the block (the old Elementor widget
 * wrapper); the site's CSS for those two sections is scoped to them (no link underline on the tiles, spacing…).
 * A hero or services block placed straight on a page has no such parent, so it prints the wrappers itself.
 * Editor side: src/blocks/shared/outer-wrap.js (keep the two lists in step).
 *
 * @return array<string, array{0: string, 1: string, 2: string}> Block => [ marker class, outer group, inner group ].
 */
function bwe_gw_outer_wraps() {
	return array(
		'bwe/hero'     => array( 'bwex-hero-scope', 'elementor-element elementor-element-1876638 elementor-widget elementor-widget-bwex-hero', 'bwe-home bwex bwex-hero-scope' ),
		'bwe/services' => array( 'bwex-svcw', 'elementor-element elementor-element-be895a2 elementor-widget elementor-widget-bwex-services', 'bwex bwex-svcw' ),
	);
}

/**
 * Marks a hero / services block whose parent is not Home's wrapper group.
 *
 * @param array         $parsed Parsed block.
 * @param array         $source Source block.
 * @param WP_Block|null $parent Parent block (null at the top level).
 */
function bwe_gw_outer_mark( $parsed, $source, $parent = null ) {
	$wraps = bwe_gw_outer_wraps();
	$name  = (string) ( $parsed['blockName'] ?? '' );
	// A hero the page layout wraps (page-layout.php) is inside its scope group already.
	if ( isset( $wraps[ $name ] ) && ! ( function_exists( 'bwe_gw_page_layout_wraps_hero' ) && bwe_gw_page_layout_wraps_hero( $parsed ) ) ) {
		$cls = $parent instanceof WP_Block ? (string) ( $parent->parsed_block['attrs']['className'] ?? '' ) : '';
		if ( ! in_array( $wraps[ $name ][0], preg_split( '/\s+/', $cls ), true ) ) {
			$parsed['bweOwnWrap'] = true;
		}
	}
	return $parsed;
}
add_filter( 'render_block_data', 'bwe_gw_outer_mark', 10, 3 );

/**
 * Prints the wrapper groups around a marked hero / services block.
 *
 * @param string $html  Rendered block.
 * @param array  $block Parsed block.
 */
function bwe_gw_outer_wrap( $html, $block ) {
	$wraps = bwe_gw_outer_wraps();
	$name  = (string) ( $block['blockName'] ?? '' );
	if ( empty( $block['bweOwnWrap'] ) || ! isset( $wraps[ $name ] ) || '' === trim( (string) $html ) ) {
		return $html;
	}
	return '<div class="wp-block-group ' . esc_attr( $wraps[ $name ][1] ) . '"><div class="wp-block-group elementor-widget-container"><div class="wp-block-group ' . esc_attr( $wraps[ $name ][2] ) . '">'
		. $html
		. '</div></div></div>';
}
add_filter( 'render_block', 'bwe_gw_outer_wrap', 10, 2 );

/**
 * Editor: a widget page's canvas gets the scope classes of the site's widget-page wrapper (bwe-gw-page on the
 * body, bwe-prx on the root — the Price list's styles are scoped to it), so the parts look the same while editing.
 * Every editor canvas also gets html.bwe-gw-canvas, for Astra's smaller root font size on tablets / phones.
 * BestWebExpert Home's editor script marks a canvas it wrapped with data-bwe-wrapped (pages without Home's own
 * wrapper, and patterns opened alone); only page canvases get the classes, like on the site.
 */
function bwe_gw_widget_page_editor_script() {
	wp_add_inline_script(
		'wp-block-editor',
		// The site's rules read "body .bwe-prx …", so bwe-prx goes on the canvas root (below the body); checked
		// every time, because the editor can rewrite the root's classes (device preview switch).
		'(function(){setInterval(function(){document.querySelectorAll("iframe").forEach(function(f){var d;try{d=f.contentDocument;}catch(e){return;}var b=d&&d.body;if(!b||!b.classList.contains("editor-styles-wrapper")){return;}if(!d.documentElement.classList.contains("bwe-gw-canvas")){d.documentElement.classList.add("bwe-gw-canvas");}if(!b.classList.contains("post-type-page")){return;}var r=d.querySelector(".is-root-container[data-bwe-wrapped]");if(r&&!r.classList.contains("bwe-prx")){b.classList.add("bwe-gw-page");r.classList.add("bwe-prx");}});},700);})();'
	);
}
add_action( 'enqueue_block_editor_assets', 'bwe_gw_widget_page_editor_script' );
