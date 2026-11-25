<?php
/**
 * Shared parts of the general-purpose blocks (Buttons, Media, Grid, Gap) and their stylesheet
 * assets/css/blocks.css — which also holds the Visibility rules every block can use (includes/global-controls.php).
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * Button looks: value => the classes the site's button CSS (and blocks.css) styles.
 */
const BWE_GW_BUTTON_LOOKS = array(
	'primary' => 'bwe-btn bwe-btn--primary',
	'outline' => 'bwe-btn',
	'dark'    => 'bwe-btn bwe-gw-btn--dark',
	'light'   => 'bwe-btn bwe-gw-btn--light',
	'link'    => 'bwe-gw-btn--link',
);

/**
 * One button as core prints it: <div class="wp-block-button …"><a class="wp-block-button__link wp-element-button">.
 *
 * @param array $item text, url, style (see BWE_GW_BUTTON_LOOKS), newTab, rel ('' | nofollow | sponsored | ugc).
 */
function bwe_gw_buttons_item( array $item ) {
	$look   = BWE_GW_BUTTON_LOOKS[ (string) ( $item['style'] ?? 'primary' ) ] ?? BWE_GW_BUTTON_LOOKS['primary'];
	$rel    = array();
	$target = '';
	if ( ! empty( $item['newTab'] ) ) {
		$target = ' target="_blank"';
		$rel    = array( 'noreferrer', 'noopener' );
	}
	if ( in_array( (string) ( $item['rel'] ?? '' ), array( 'nofollow', 'sponsored', 'ugc' ), true ) ) {
		$rel[] = $item['rel'];
	}
	$url = trim( (string) ( $item['url'] ?? '' ) );
	return '<div class="wp-block-button ' . esc_attr( $look ) . '"><a class="wp-block-button__link wp-element-button"'
		. ( '' !== $url ? ' href="' . esc_url( $url ) . '"' : '' )
		. $target
		. ( $rel ? ' rel="' . esc_attr( implode( ' ', $rel ) ) . '"' : '' )
		. '>' . wp_kses( (string) $item['text'], array( 'strong' => array(), 'em' => array(), 'span' => array( 'class' => true ), 'br' => array() ) ) . '</a></div>';
}

/**
 * Classes of a Grid block (editor twin: gridClasses() in src/blocks/grid/index.js).
 *
 * @param array $attributes Block attributes.
 * @return string[]
 */
function bwe_gw_grid_classes( array $attributes ) {
	$count   = static fn( $v, $d ) => max( 1, min( 6, (int) ( $v ?? $d ) ) );
	$classes = array(
		'bwe-gw-grid',
		'bwe-gw-grid--c' . $count( $attributes['columns'] ?? null, 3 ),
		'bwe-gw-grid--t' . $count( $attributes['columnsTablet'] ?? null, 2 ),
		'bwe-gw-grid--m' . $count( $attributes['columnsMobile'] ?? null, 1 ),
	);
	if ( in_array( (string) ( $attributes['ratio'] ?? '' ), array( '2-1', '1-2', '3-2', '2-3', '3-1', '1-3' ), true ) ) {
		$classes[] = 'bwe-gw-grid--r' . $attributes['ratio'];
	}
	if ( in_array( (string) ( $attributes['valign'] ?? '' ), array( 'start', 'center', 'end' ), true ) ) {
		$classes[] = 'bwe-gw-grid--v-' . $attributes['valign'];
	}
	if ( in_array( (string) ( $attributes['cards'] ?? '' ), array( 'card', 'soft', 'dark', 'line' ), true ) ) {
		$classes[] = 'bwe-gw-grid--cards';
		$classes[] = 'bwe-gw-grid--cards-' . $attributes['cards'];
	}
	if ( ! empty( $attributes['reverseMobile'] ) ) {
		$classes[] = 'bwe-gw-grid--rev-m';
	}
	return $classes;
}

/**
 * Opening tag (and scoped <style>) of a Grid block.
 *
 * @param string $block_dir  Block directory (style map).
 * @param array  $attributes Block attributes.
 */
function bwe_gw_grid_open( $block_dir, array $attributes ) {
	[ $scope, $style ] = bwe_gw_style_for_block( $block_dir, $attributes );
	$classes           = bwe_gw_grid_classes( $attributes );
	if ( $scope ) {
		$classes[] = $scope;
	}
	return $style . '<div' . ( empty( $attributes['anchor'] ) ? '' : ' id="' . esc_attr( $attributes['anchor'] ) . '"' ) . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">';
}

/**
 * The general-purpose blocks' stylesheet: in the editor always; on the site only on pages that need it — a page
 * with one of these blocks, a Visibility setting or a changed heading tag (so pages without them stay byte-for-byte
 * as they were). Small: about 5 KB.
 */
function bwe_gw_blocks_stylesheet() {
	$file = BWE_GW_DIR . '/assets/css/blocks.css';
	if ( ! is_file( $file ) ) {
		return;
	}
	$url = plugins_url( 'assets/css/blocks.css', BWE_GW_DIR . '/bestwebexpert-gutenberg-widget.php' );
	if ( ! is_admin() && ! bwe_gw_needs_blocks_css( is_singular() ? (int) get_queried_object_id() : 0 ) ) {
		return;
	}
	wp_enqueue_style( 'bwe-gw-blocks', $url, wp_style_is( 'bwe-home', 'registered' ) ? array( 'bwe-home' ) : array(), (string) filemtime( $file ) );
	// Keeps the look of headings the site styles by their tag (call to action) when "Heading tag" changes them.
	$compat = BWE_GW_DIR . '/assets/css/heading-compat.css';
	if ( is_file( $compat ) ) {
		wp_enqueue_style( 'bwe-gw-heading-compat', plugins_url( 'assets/css/heading-compat.css', BWE_GW_DIR . '/bestwebexpert-gutenberg-widget.php' ), array( 'bwe-gw-blocks' ), (string) filemtime( $compat ) );
	}
}
add_action( 'enqueue_block_assets', 'bwe_gw_blocks_stylesheet', 45 );

/**
 * Whether a post uses the general-purpose blocks or the shared settings (patterns expanded).
 *
 * @param int $id Post ID (0 = none).
 */
function bwe_gw_needs_blocks_css( $id ) {
	if ( $id <= 0 ) {
		return false;
	}
	static $seen = array();
	if ( ! isset( $seen[ $id ] ) ) {
		// The saved block markup, read from the database, with synced patterns inlined. Not the post object: while the
		// <head> is built, the content readers (bwe_post_content_expanded) swap the cached post content for a version
		// in which some bwe/* blocks are plain HTML, so their attributes — bweHide, headingTag — would be gone.
		global $wpdb;
		$raw    = static fn( int $post ): string => (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $post ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery -- once per page view, cached in $seen.
		$expand = static function ( string $content, int $depth ) use ( &$expand, $raw ): string {
			return $depth > 3 ? $content : (string) preg_replace_callback(
				'/<!-- wp:block \{"ref":(\d+)[^}]*\} \/-->/',
				static fn( $m ) => $expand( $raw( (int) $m[1] ), $depth + 1 ),
				$content
			);
		};
		$seen[ $id ] = 1 === preg_match( '#<!-- wp:bwe/(?:buttons|media|grid|gap|guide|testimonials)[\s/]|"(?:bweHide|headingTag)":|"phoneLayout":"slider"#', $expand( $raw( $id ), 0 ) );
	}
	return $seen[ $id ];
}

/**
 * Inserter preview of the Image block: one of the site's own screenshots.
 */
function bwe_gw_example_image() {
	if ( ! defined( 'BWE_HOME_DIR' ) || ! is_file( BWE_HOME_DIR . '/assets/img/productreels-video-grid-layout.jpg' ) ) {
		return;
	}
	wp_add_inline_script(
		'wp-blocks',
		'window.bweGw = Object.assign( window.bweGw || {}, ' . wp_json_encode( array( 'exampleImage' => plugins_url( 'assets/img/productreels-video-grid-layout.jpg', BWE_HOME_DIR . '/bestwebexpert-home.php' ) ) ) . ' );',
		'before'
	);
}
add_action( 'enqueue_block_editor_assets', 'bwe_gw_example_image' );

/**
 * Translations: the plugin's own languages/ folder first (bestwebexpert-<locale>.mo and the editor's
 * bestwebexpert-<locale>-<hash>.json), then wp-content/languages/plugins/ (Loco Translate, translate.wordpress.org).
 */
function bwe_gw_load_textdomain() {
	load_plugin_textdomain( 'bestwebexpert', false, dirname( plugin_basename( BWE_GW_DIR . '/bestwebexpert-gutenberg-widget.php' ) ) . '/languages' );
}
add_action( 'init', 'bwe_gw_load_textdomain', 1 );

/**
 * Editor scripts of our blocks read their translations from languages/ too (WordPress already looks in
 * wp-content/languages/plugins/ for block scripts with a "textdomain").
 */
function bwe_gw_script_translations() {
	$handles = array();
	foreach ( WP_Block_Type_Registry::get_instance()->get_all_registered() as $name => $type ) {
		if ( 0 === strpos( $name, 'bwe/' ) ) {
			$handles = array_merge( $handles, (array) $type->editor_script_handles );
		}
	}
	foreach ( array_unique( $handles ) as $handle ) { // All blocks share "bwe-gw-editor" since the one-bundle build.
		wp_set_script_translations( $handle, 'bestwebexpert', BWE_GW_DIR . '/languages' );
	}
}
add_action( 'enqueue_block_editor_assets', 'bwe_gw_script_translations', 1 );
