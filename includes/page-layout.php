<?php
/**
 * Page layout (editor: Page settings → "Page layout"): the wrappers around a page's sections come from this
 * setting, not from wrapper groups with classes in the page content.
 *
 * Before 2026-11-25 every page (except Home) kept its sections inside core groups whose "Additional CSS classes"
 * carried the site's page markup: a band per section (elementor-517 bwe-h2x bwe-sec + the 1001dd3 container),
 * a hero band, or one page-wide wrapper (Pricing, Write for Us, Contact, Services, Blog). The site's CSS is scoped
 * to that markup, so it must stay exactly the same; now the page only picks a layout and the top-level blocks are
 * wrapped here when the page is rendered:
 * - Sections (bands): each top-level block gets its own band; the hero gets the hero band, the call to action
 *   and the price list their band markers.
 * - One wrapper (Pricing page, Write for Us page, Services page, Contact page, Blog page): one wrapper around all
 *   top-level blocks; the hero sits inside it in its scope group, or stays outside with its own wrappers.
 * The page's "Structured data" setting adds the hero band's schema marker (bwe-pb-schema …, read by BestWebExpert
 * Home's schema code). The wrapper classes are also added to the page's expanded content as markers, so every
 * stylesheet / script that is loaded "when the page has class X" still loads.
 * Empty layout = as before (Home and new pages: page-mode.php's widget page wrapper).
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

const BWE_GW_BAND_INNER = 'elementor-element elementor-element-1001dd3 e-con-full bwe-home bwex e-flex e-con e-parent';

/**
 * The page layouts. bands = a band per section; otherwise one wrapper: outer + inner group classes, and where the
 * hero goes (scope = inside the wrapper in its scope group, own = before the wrapper, with its own wrappers).
 *
 * canvas = the scope classes the editor canvas gets (so the sections look the same while editing).
 *
 * @return array<string, array{label: string, canvas: string, bands?: bool, outer?: string, inner?: string, hero?: string}>
 */
function bwe_gw_page_layouts() {
	return array(
		'bands'        => array(
			'label' => __( 'Sections — each section in its own band', 'bestwebexpert' ),
			'canvas' => 'bwe-sec',
			'bands' => true,
		),
		'pricing'      => array(
			'label' => __( 'Pricing page — one wrapper (price list styles)', 'bestwebexpert' ),
			'canvas' => 'bwe-prx',
			'outer' => 'elementor elementor-517 bwe-h2x bwe-prx',
			'inner' => BWE_GW_BAND_INNER,
			'hero'  => 'scope',
		),
		'write-for-us' => array(
			'label' => __( 'Write for Us page — one wrapper', 'bestwebexpert' ),
			'canvas' => 'bwe-wfu',
			'outer' => 'elementor elementor-517 bwe-h2x bwe-wfu',
			'inner' => BWE_GW_BAND_INNER,
			'hero'  => 'scope',
		),
		'services'     => array(
			'label' => __( 'Services page — hero, then one wrapper', 'bestwebexpert' ),
			'canvas' => 'bwe-sec',
			'outer' => 'bwe-sec',
			'inner' => 'bwe-home bwex',
			'hero'  => 'own',
		),
		'contact'      => array(
			'label' => __( 'Contact page — hero, then one wrapper (form styles)', 'bestwebexpert' ),
			'canvas' => 'bwe-wfu bwe-ctx',
			'outer' => 'bwe-wfu bwe-ctx',
			'inner' => 'bwe-home bwex',
			'hero'  => 'own',
		),
		'blog'         => array(
			'label' => __( 'Blog page — one wrapper (blog styles)', 'bestwebexpert' ),
			'canvas' => 'bwe-blog',
			'outer' => 'bwe-home bwe-blog',
			'inner' => '',
			'hero'  => 'own',
		),
	);
}

/**
 * Structured data choices: the marker each one puts on the hero band (BestWebExpert Home prints the schema).
 *
 * @return array<string, array{label: string, marker: string}>
 */
function bwe_gw_page_schemas() {
	return array(
		'service'          => array(
			'label'  => __( 'Service page (Service + FAQ)', 'bestwebexpert' ),
			'marker' => 'bwe-pb-schema',
		),
		'wordpress-expert' => array(
			'label'  => __( 'Best WordPress Expert page', 'bestwebexpert' ),
			'marker' => 'bwe-wpx-schema',
		),
		'shopify-expert'   => array(
			'label'  => __( 'Best Shopify Expert page', 'bestwebexpert' ),
			'marker' => 'bwe-spx-schema',
		),
		'migratelift'      => array(
			'label'  => __( 'MigrateLift plugin page', 'bestwebexpert' ),
			'marker' => 'bwe-ml-schema',
		),
	);
}

/**
 * Registers the two settings (REST: the editor's Page layout panel reads and saves them).
 */
function bwe_gw_page_layout_meta() {
	foreach ( array( 'bwe_page_layout', 'bwe_page_schema' ) as $key ) {
		register_post_meta(
			'page',
			$key,
			array(
				'type'              => 'string',
				'single'            => true,
				'default'           => '',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_key',
				'auth_callback'     => static fn() => current_user_can( 'edit_pages' ),
			)
		);
	}
}
add_action( 'init', 'bwe_gw_page_layout_meta' );

/**
 * The page's layout ('' = none) and its settings.
 *
 * @param int $post_id Post ID.
 * @return array{0: string, 1: array} [ key, layout ]
 */
function bwe_gw_page_layout( $post_id ) {
	$key     = $post_id > 0 ? (string) get_post_meta( (int) $post_id, 'bwe_page_layout', true ) : '';
	$layouts = bwe_gw_page_layouts();
	return isset( $layouts[ $key ] ) ? array( $key, $layouts[ $key ] ) : array( '', array() );
}

/**
 * Classes of the outer and inner wrapper a top-level block gets in a band layout.
 *
 * @param string $name    Block name.
 * @param int    $post_id Post ID (its Structured data setting).
 * @return array{0: string, 1: string} [ outer classes, inner classes ]
 */
function bwe_gw_band_classes( $name, $post_id ) {
	if ( 'bwe/hero' === $name ) {
		$schemas = bwe_gw_page_schemas();
		$schema  = (string) get_post_meta( (int) $post_id, 'bwe_page_schema', true );
		return array( trim( 'elementor elementor-517 bwe-h2x bwe-page-hero bwe-rd ' . ( $schemas[ $schema ]['marker'] ?? '' ) ), 'bwe-home bwex bwex-hero-scope' );
	}
	$extra = array(
		'bwe/cta'           => ' bwe-cta-shared', // the shared call to action
		'bwe/price-section' => ' bwe-prx',        // the price list's styles are scoped to it
	);
	return array( 'elementor elementor-517 bwe-h2x bwe-sec' . ( $extra[ $name ] ?? '' ), BWE_GW_BAND_INNER );
}

/**
 * Every wrapper class the page's layout prints (markers for the "load when the page has class X" checks).
 *
 * @param int    $post_id Post ID.
 * @param string $content Page content (block markup).
 */
function bwe_gw_page_layout_classes( $post_id, $content ) {
	[ $key, $layout ] = bwe_gw_page_layout( $post_id );
	if ( '' === $key ) {
		return '';
	}
	$classes = array();
	if ( ! empty( $layout['bands'] ) ) {
		foreach ( parse_blocks( (string) $content ) as $block ) {
			if ( ! empty( $block['blockName'] ) ) {
				$classes = array_merge( $classes, bwe_gw_band_classes( $block['blockName'], $post_id ) );
			}
		}
	} else {
		$classes = array( $layout['outer'], $layout['inner'], 'scope' === $layout['hero'] ? 'bwe-home bwex bwex-hero-scope' : '' );
	}
	$tokens = preg_split( '/\s+/', implode( ' ', $classes ), -1, PREG_SPLIT_NO_EMPTY );
	return implode( ' ', array_values( array_unique( $tokens ) ) );
}

/**
 * Adds the wrapper classes to the page's expanded content. Runs before page-mode.php's widget page check
 * (priority 5): a layout with bwe-h2x is not a widget page.
 *
 * @param string $content Expanded content.
 * @param mixed  $post    Post (when the filter passes it).
 */
function bwe_gw_page_layout_markers( $content, $post = null ) {
	$post = get_post( $post ? $post : get_queried_object_id() );
	if ( ! $post || 'page' !== $post->post_type ) {
		return $content;
	}
	$classes = bwe_gw_page_layout_classes( $post->ID, $post->post_content );
	return '' === $classes ? $content : $content . "\n<!-- bwe-gw-page-layout " . $classes . ' -->';
}
add_filter( 'bwe_post_content_expanded', 'bwe_gw_page_layout_markers', 4, 2 );

/**
 * Layout run state: the page being rendered, its top-level blocks (to recognise them while rendering) and the
 * index of the next one.
 *
 * @param array|null $set New state (null = read).
 * @param bool       $clear Clear the state.
 */
function bwe_gw_page_layout_state( $set = null, $clear = false ) {
	static $state = null;
	if ( $clear ) {
		$state = null;
	} elseif ( null !== $set ) {
		$state = $set;
	}
	return $state;
}

/**
 * Starts wrapping for one rendering of a page's content (the_content, or the migration tools).
 *
 * @param int    $post_id Post ID.
 * @param string $content Block markup about to be rendered.
 */
function bwe_gw_page_layout_begin( $post_id, $content ) {
	[ $key, $layout ] = bwe_gw_page_layout( $post_id );
	if ( '' === $key ) {
		bwe_gw_page_layout_state( null, true );
		return;
	}
	$top = array_values( array_filter( parse_blocks( (string) $content ), static fn( $b ) => ! empty( $b['blockName'] ) ) );
	if ( ! $top ) {
		return;
	}
	// One wrapper: around every top-level block, except a first hero that stays outside ("own").
	$first = ( 'own' === ( $layout['hero'] ?? '' ) && 'bwe/hero' === $top[0]['blockName'] ) ? 1 : 0;
	bwe_gw_page_layout_state(
		array(
			'post'   => (int) $post_id,
			'layout' => $layout,
			'top'    => $top,
			'next'   => 0,
			'first'  => $first,
			'last'   => count( $top ) - 1,
		)
	);
}

/**
 * Ends the wrapping started by bwe_gw_page_layout_begin().
 */
function bwe_gw_page_layout_end() {
	bwe_gw_page_layout_state( null, true );
}

/**
 * Starts the wrapping for the main page content, just before the blocks are rendered (do_blocks runs at 9).
 *
 * @param string $content Content.
 */
function bwe_gw_page_layout_content_begin( $content ) {
	$id = (int) get_the_ID();
	if ( $id > 0 && 'page' === get_post_type( $id ) && has_blocks( $content ) ) {
		if ( function_exists( 'bwe_post_content_expanded' ) ) {
			bwe_post_content_expanded( $id ); // cached now: its readers render blocks too, never while the page is wrapped
		}
		bwe_gw_page_layout_begin( $id, $content );
	}
	return $content;
}
add_filter( 'the_content', 'bwe_gw_page_layout_content_begin', 8 );
add_filter(
	'the_content',
	static function ( $content ) {
		bwe_gw_page_layout_end();
		return $content;
	},
	10
);

/**
 * Marks the page's top-level blocks (in order) while they are rendered: bweLayout = their index. Synced patterns
 * render their own blocks at the top level too; those are not the next expected block, so they are left alone.
 *
 * @param array         $parsed Parsed block.
 * @param array         $source Source block.
 * @param WP_Block|null $parent Parent block.
 */
function bwe_gw_page_layout_mark( $parsed, $source, $parent = null ) {
	$state = bwe_gw_page_layout_state();
	if ( ! $state || null !== $parent || empty( $source['blockName'] ) || $state['next'] >= count( $state['top'] ) ) {
		return $parsed;
	}
	$want = $state['top'][ $state['next'] ];
	if ( $want['blockName'] !== $source['blockName'] || $want['attrs'] !== $source['attrs'] || $want['innerHTML'] !== $source['innerHTML'] ) {
		return $parsed;
	}
	$parsed['bweLayout'] = $state['next'];
	++$state['next'];
	bwe_gw_page_layout_state( $state );
	return $parsed;
}
add_filter( 'render_block_data', 'bwe_gw_page_layout_mark', 1, 3 );

/**
 * Whether the hero block is wrapped by the page layout (then it does not print its own wrappers).
 *
 * @param array $parsed Parsed block.
 */
function bwe_gw_page_layout_wraps_hero( $parsed ) {
	$state = bwe_gw_page_layout_state();
	return $state && isset( $parsed['bweLayout'] ) && ( ! empty( $state['layout']['bands'] ) || 'scope' === ( $state['layout']['hero'] ?? '' ) );
}

/**
 * Prints the layout's wrappers around a marked top-level block.
 *
 * @param string $html  Rendered block.
 * @param array  $block Parsed block.
 */
function bwe_gw_page_layout_wrap( $html, $block ) {
	$state = bwe_gw_page_layout_state();
	if ( ! $state || ! isset( $block['bweLayout'] ) ) {
		return $html;
	}
	$i      = (int) $block['bweLayout'];
	$name   = (string) $block['blockName'];
	$layout = $state['layout'];
	$group  = static fn( string $class, string $inner ): string => '<div class="wp-block-group ' . esc_attr( $class ) . '">' . $inner . '</div>';
	// A synced pattern (core/block) passes the render_block filter twice with the same block: wrap once.
	if ( false !== strpos( substr( $html, 0, 600 ), 'data-bwe-layout="' ) ) {
		return $html;
	}
	if ( ! empty( $layout['bands'] ) ) {
		[ $outer, $inner ] = bwe_gw_band_classes( $name, $state['post'] );
		return bwe_gw_page_layout_tag( $group( 'alignfull ' . $outer, $group( $inner, $html ) ) );
	}
	if ( $i < $state['first'] ) {
		return $html; // the hero before the wrapper (prints its own wrappers)
	}
	if ( 'bwe/hero' === $name && 'scope' === $layout['hero'] ) {
		$html = $group( 'bwe-home bwex bwex-hero-scope', $html );
	}
	if ( $i === $state['first'] ) {
		$html = '<div data-bwe-layout="" class="wp-block-group alignfull ' . esc_attr( $layout['outer'] ) . '">' . ( '' !== $layout['inner'] ? '<div class="wp-block-group ' . esc_attr( $layout['inner'] ) . '">' : '' ) . $html;
	}
	if ( $i !== $state['first'] ) {
		$html = '<!--data-bwe-layout=""-->' . $html;
	}
	if ( $i === $state['last'] ) {
		$html .= ( '' !== $layout['inner'] ? '</div>' : '' ) . '</div>';
	}
	return $html;
}
add_filter( 'render_block', 'bwe_gw_page_layout_wrap', 30, 2 );

/**
 * Tags a band's opening tag (read back by the twice-filtered check above, removed again on output).
 *
 * @param string $html Band.
 */
function bwe_gw_page_layout_tag( $html ) {
	return preg_replace( '/^<div /', '<div data-bwe-layout="" ', $html, 1 );
}

/**
 * Removes the wrap tags from the rendered page.
 *
 * @param string $content Rendered content.
 */
function bwe_gw_page_layout_untag( $content ) {
	return false === strpos( (string) $content, 'data-bwe-layout=""' ) ? $content : str_replace( array( '<div data-bwe-layout="" ', '<!--data-bwe-layout=""-->' ), array( '<div ', '' ), $content );
}
add_filter( 'the_content', 'bwe_gw_page_layout_untag', 11 );

/**
 * The page's block markup inside its one-wrapper layout as real group blocks — for templates that render a page's
 * markup themselves instead of the_content (BestWebExpert Home's blog archive renders the Blog page that way, and
 * swaps the wrapper's first section for an archive header). Band layouts and pages without a layout: unchanged.
 *
 * @param int    $post_id Post ID.
 * @param string $markup  Block markup.
 */
function bwe_gw_page_layout_markup( $post_id, $markup ) {
	[ $key, $layout ] = bwe_gw_page_layout( $post_id );
	if ( '' === $key || ! empty( $layout['bands'] ) ) {
		return $markup;
	}
	$markup = preg_replace( '/
?<!-- bwe-gw-page-layout [^>]*-->/', '', (string) $markup ); // the marker comment stays out of the page
	$group  = static fn( string $class, string $inner, bool $full ): string => '<!-- wp:group ' . wp_json_encode( array_filter( array( 'align' => $full ? 'full' : '', 'className' => $class ) ) ) . " -->\n"
		. '<div class="wp-block-group' . ( $full ? ' alignfull' : '' ) . ' ' . esc_attr( $class ) . '">' . $inner . "</div>\n<!-- /wp:group -->";
	$inner = '' !== $layout['inner'] ? $group( $layout['inner'], $markup, false ) : $markup;
	return $group( $layout['outer'], $inner, true );
}

/**
 * The wrappers are group markup, and the sections print core button markup: keep core's group / buttons / button
 * styles loading on layout pages, in the same place as when they were group / button blocks (right before the
 * site's font + stylesheet, so the site's rules still come after them).
 */
function bwe_gw_page_layout_styles() {
	$id = is_singular( 'page' ) ? (int) get_queried_object_id() : 0;
	if ( ! $id || '' === bwe_gw_page_layout( $id )[0] ) {
		return;
	}
	$handles = array( 'wp-block-group' );
	if ( function_exists( 'bwe_post_content_expanded' ) && false !== strpos( bwe_post_content_expanded( $id ), 'wp-block-button' ) ) {
		$handles = array( 'wp-block-button', 'wp-block-buttons', 'wp-block-group' );
	}
	$styles = wp_styles();
	$before = isset( $styles->registered['bwe-home-fonts'] ) ? 'bwe-home-fonts' : ( isset( $styles->registered['bwe-home'] ) ? 'bwe-home' : '' );
	foreach ( $handles as $handle ) {
		if ( '' !== $before && ! in_array( $handle, $styles->registered[ $before ]->deps, true ) ) {
			$styles->registered[ $before ]->deps[] = $handle;
		}
		wp_enqueue_style( $handle );
	}
}
add_action( 'wp_enqueue_scripts', 'bwe_gw_page_layout_styles', 99 );

/**
 * Data for the editor's Page layout panel (src/page-layout.js).
 */
function bwe_gw_page_layout_editor_data() {
	$out = array(
		'layouts' => array(),
		'schemas' => array(),
	);
	foreach ( bwe_gw_page_layouts() as $value => $l ) {
		$out['layouts'][] = array(
			'value'  => $value,
			'label'  => $l['label'],
			'canvas' => $l['canvas'],
		);
	}
	foreach ( bwe_gw_page_schemas() as $value => $sch ) {
		$out['schemas'][] = array(
			'value' => $value,
			'label' => $sch['label'],
		);
	}
	wp_add_inline_script( 'bwe-gw-editor', 'window.bweGwPageLayout = ' . wp_json_encode( $out ) . ';', 'before' );
}
add_action( 'enqueue_block_editor_assets', 'bwe_gw_page_layout_editor_data' );
