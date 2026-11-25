<?php
/**
 * Front-end asset optimisation (2026-11-21).
 *
 * 1. Home-style CSS bundle: the ~39 small stylesheets of Home's stack (bwe-h2x-*) are served as ONE minified
 *    file built by tools/home-2/build-bundle.php. The swap only happens when the page enqueues exactly the
 *    bundled stylesheets and none of them changed since the build; otherwise the individual files load as
 *    before, so an outdated bundle can never break the design. Rebuild after editing Home's CSS.
 * 2. One Google Fonts request: Bricolage Grotesque (one variable range covers every weight used) + Inter.
 * 3. No emoji script/styles (the site uses no emoji images).
 * 4. Content pages built from Home's sections don't load WooCommerce's shop scripts/styles
 *    (add-to-cart, blockUI, grid CSS). Order-attribution tracking stays.
 *
 * Filters: bwe_h2x_use_bundle (bool), bwe_optimize_woo_assets (bool).
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * Bundle paths. Two bundles: the front end's (bundle.min.css) and the block editor's (editor.min.css, 2026-11-21).
 * The editor one matters most in Appearance → Design → Patterns, where every pattern preview is its own frame
 * that loads all of the editor's stylesheets: one file instead of ~50 lets the previews show styled at once.
 *
 * @return array{dir:string,url:string,css:string,manifest:string}
 */
function bwe_h2x_bundle_paths() {
	$name = is_admin() ? 'editor' : 'bundle';
	return array(
		'dir'      => BWE_HOME_DIR . '/assets/home-2/bundle/',
		'url'      => plugins_url( 'assets/home-2/bundle/', BWE_HOME_DIR . '/site.php' ),
		'css'      => $name . '.min.css',
		'manifest' => 'editor' === $name ? 'editor-manifest.json' : 'manifest.json',
	);
}

/**
 * Bundled stylesheets currently queued, in print order: [handle => [path, after-inline-css]].
 * Only local files of the Home stack (bwe-h2x-*); page-specific extras (pricing.css) stay separate.
 *
 * @return array
 */
function bwe_h2x_bundle_candidates() {
	$styles = wp_styles();
	$styles->all_deps( $styles->queue );
	$out    = array();
	$base   = trailingslashit( content_url() );
	foreach ( $styles->to_do as $handle ) {
		if ( 0 !== strpos( $handle, 'bwe-h2x-' ) || in_array( $handle, array( 'bwe-h2x-pricing', 'bwe-h2x-bundle', 'bwe-h2x-editor-compat' ), true ) ) {
			continue;
		}
		$src = (string) $styles->registered[ $handle ]->src;
		if ( 0 !== strpos( $src, $base ) ) {
			continue;
		}
		$path           = WP_CONTENT_DIR . '/' . substr( strtok( $src, '?' ), strlen( $base ) );
		$after          = $styles->get_data( $handle, 'after' );
		$out[ $handle ] = array( $path, is_array( $after ) ? implode( "\n", $after ) : '' );
	}
	$styles->to_do = array();
	return $out;
}

/**
 * Light, safe CSS minifier (comments + whitespace only; never touches selectors' meaningful spaces).
 *
 * @param string $css CSS.
 */
function bwe_h2x_minify_css( $css ) {
	$css = preg_replace( '#/\*.*?\*/#s', '', $css );
	$css = preg_replace( '/\s+/', ' ', $css );
	$css = preg_replace( '/\s*([{};])\s*/', '$1', $css );
	$css = preg_replace( '/,\s+/', ',', $css );
	return trim( str_replace( ';}', '}', $css ) );
}

/**
 * Builds the bundle from the stylesheets the current request queued. Returns a short report.
 */
function bwe_h2x_build_bundle() {
	$cand = bwe_h2x_bundle_candidates();
	if ( ! $cand ) {
		return 'nothing queued';
	}
	$paths = bwe_h2x_bundle_paths();
	wp_mkdir_p( $paths['dir'] );
	$css      = '';
	$manifest = array();
	foreach ( $cand as $handle => list( $path, $after ) ) {
		$css       .= "\n" . (string) file_get_contents( $path ) . ( '' !== $after ? "\n" . $after : '' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local file.
		// Path relative to site/ and the file's hash (not its mtime): a git checkout resets mtimes, the content stays.
		$manifest[] = array( $handle, ltrim( str_replace( '\\', '/', substr( wp_normalize_path( $path ), strlen( wp_normalize_path( BWE_HOME_DIR ) ) ) ), '/' ), md5_file( $path ), md5( $after ) );
	}
	$min = bwe_h2x_minify_css( $css );
	file_put_contents( $paths['dir'] . $paths['css'], $min ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
	file_put_contents( $paths['dir'] . $paths['manifest'], wp_json_encode( $manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
	return count( $manifest ) . ' files, ' . round( strlen( $css ) / 1024, 1 ) . ' KB → ' . round( strlen( $min ) / 1024, 1 ) . ' KB';
}

/**
 * Swaps the queued Home stack for the bundle when it matches exactly.
 */
function bwe_h2x_use_bundle() {
	if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ! apply_filters( 'bwe_h2x_use_bundle', true ) || ! wp_style_is( 'bwe-h2x-base', 'enqueued' ) ) {
		return;
	}
	$paths = bwe_h2x_bundle_paths();
	$file  = $paths['dir'] . $paths['css'];
	$mf    = $paths['dir'] . $paths['manifest'];
	if ( ! is_readable( $file ) || ! is_readable( $mf ) ) {
		return;
	}
	$manifest = json_decode( (string) file_get_contents( $mf ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local file.
	$cand     = bwe_h2x_bundle_candidates();
	if ( ! is_array( $manifest ) || count( $manifest ) !== count( $cand ) ) {
		return;
	}
	$keys  = array_keys( $cand );
	$stamp = array();
	foreach ( $manifest as $i => list( $handle, $rel, $hash, $after_md5 ) ) {
		if ( ( $keys[ $i ] ?? '' ) !== $handle || md5( $cand[ $handle ][1] ) !== $after_md5 ) {
			return; // Different set, order or inline CSS.
		}
		$path = BWE_HOME_DIR . '/' . $rel;
		if ( wp_normalize_path( $path ) !== wp_normalize_path( $cand[ $handle ][0] ) || ! is_readable( $path ) ) {
			return;
		}
		$stamp[] = $rel . ':' . filemtime( $path ) . ':' . filesize( $path );
	}
	// Hashing ~40 files on every request would be wasteful: the result is cached until a file's mtime or size changes.
	$stamp = md5( $paths['css'] . '|' . implode( '|', $stamp ) );
	$known = get_transient( 'bwe_gw_site_bundle_' . md5( $paths['css'] ) );
	if ( ! is_array( $known ) || ( $known[0] ?? '' ) !== $stamp ) {
		$valid = true;
		foreach ( $manifest as list( , $rel, $hash ) ) {
			if ( md5_file( BWE_HOME_DIR . '/' . $rel ) !== $hash ) {
				$valid = false; // A source changed since the build.
				break;
			}
		}
		$known = array( $stamp, $valid );
		set_transient( 'bwe_gw_site_bundle_' . md5( $paths['css'] ), $known, WEEK_IN_SECONDS );
	}
	if ( ! $known[1] ) {
		return;
	}

	$styles  = wp_styles();
	$bundled = array_keys( $cand );
	$outside = array();
	foreach ( $bundled as $handle ) {
		foreach ( (array) $styles->registered[ $handle ]->deps as $dep ) {
			if ( ! in_array( $dep, $bundled, true ) ) {
				$outside[] = $dep;
			}
		}
	}
	wp_register_style( 'bwe-h2x-bundle', $paths['url'] . $paths['css'], array_values( array_unique( $outside ) ), (string) filemtime( $file ) );
	// Put the bundle exactly where the first bundled sheet sat in the queue, so the cascade order is unchanged
	// (theme sheets such as site-font.css still load after it).
	$queue = array();
	$put   = false;
	foreach ( $styles->queue as $h ) {
		if ( in_array( $h, $bundled, true ) ) {
			if ( ! $put ) {
				$queue[] = 'bwe-h2x-bundle';
				$put     = true;
			}
			continue;
		}
		$queue[] = $h;
	}
	if ( ! $put ) {
		$queue[] = 'bwe-h2x-bundle';
	}
	$styles->queue = $queue;
	foreach ( $bundled as $handle ) {
		// Anything else that depends on a bundled sheet now depends on the bundle.
		foreach ( $styles->registered as $other ) {
			if ( $other->deps && in_array( $handle, $other->deps, true ) ) {
				$other->deps = array_values( array_unique( array_map( static fn( $d ) => $d === $handle ? 'bwe-h2x-bundle' : $d, $other->deps ) ) );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'bwe_h2x_use_bundle', 1000 );
// Block editor (canvas + every pattern preview): after bwe_h2x_editor_assets() (priority 30).
add_action(
	'enqueue_block_assets',
	static function () {
		if ( is_admin() ) {
			bwe_h2x_use_bundle();
		}
	},
	1000
);

/**
 * Inter (footer text) joins the site-font request: one Google Fonts request less.
 * The several Bricolage Grotesque requests are kept on purpose: each serves slightly different font files,
 * and dropping any of them changes text widths by a pixel (tested 2026-11-21).
 */
function bwe_merge_google_fonts() {
	if ( is_admin() || ! wp_style_is( 'bwe-site-font-face', 'enqueued' ) || ! wp_style_is( 'bwe-ft-text-font', 'enqueued' ) ) {
		return;
	}
	$styles = wp_styles();
	$inter  = (string) $styles->registered['bwe-ft-text-font']->src;
	$site   = (string) $styles->registered['bwe-site-font-face']->src;
	if ( false === strpos( $inter, 'family=Inter' ) || false !== strpos( $site, 'family=Inter' ) || ! preg_match( '/family=Inter[^&]*/', $inter, $m ) ) {
		return;
	}
	$styles->registered['bwe-site-font-face']->src = str_replace( '&display=swap', '&' . $m[0] . '&display=swap', $site );
	wp_dequeue_style( 'bwe-ft-text-font' );
}
add_action( 'wp_enqueue_scripts', 'bwe_merge_google_fonts', 1001 );

/**
 * No emoji detection script or styles.
 */
function bwe_disable_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'bwe_disable_emoji' );

/**
 * WooCommerce shop assets are not needed on content pages built from Home's sections.
 */
function bwe_trim_woo_assets() {
	if ( is_admin() || ! function_exists( 'bwe_h2x_is_page' ) || ! bwe_h2x_is_page() || ! apply_filters( 'bwe_optimize_woo_assets', true ) ) {
		return;
	}
	if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
		return;
	}
	// Demo stores built from Home's sections still sell from the video (ProductReels / ProductBoxes add to cart).
	if ( bwe_home_is_needed( 'wp:productreels/' ) || bwe_home_is_needed( 'wp:mmbb/' ) || bwe_home_is_needed( '[mmbb_box' ) ) {
		return;
	}
	foreach ( array( 'woocommerce-layout', 'woocommerce-smallscreen', 'woocommerce-general' ) as $h ) {
		wp_dequeue_style( $h );
	}
	foreach ( array( 'wc-add-to-cart', 'woocommerce', 'jquery-blockui', 'js-cookie', 'wc-cart-fragments' ) as $h ) {
		wp_dequeue_script( $h );
	}
}
add_action( 'wp_enqueue_scripts', 'bwe_trim_woo_assets', 999 );
