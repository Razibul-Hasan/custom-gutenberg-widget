<?php
/**
 * Builds the two site CSS bundles in site/assets/home-2/bundle/:
 *   bundle.min.css  the stylesheets a site page enqueues on the front end;
 *   editor.min.css  the same stack as the block editor (canvas + pattern previews) enqueues it.
 * Run after editing any CSS in site/assets/ (until rebuilt, the out-of-date side simply loads the individual files):
 *   php tools/build-site-bundle.php <wp-root>            front-end bundle, then the editor bundle
 *   php tools/build-site-bundle.php <wp-root> --editor   (internal) the editor bundle only
 * Runs with BestWebExpert Home switched off for this process (tools/without-home.php), so the widget's site layer builds.
 *
 * @package BWE_Gutenberg_Widget
 */

$editor = in_array( '--editor', $argv, true );
if ( $editor ) {
	define( 'WP_ADMIN', true ); // is_admin(): the editor's stack (no final-cta.css, + site font).
}
require __DIR__ . '/without-home.php';
require __DIR__ . '/lib.php';
bwe_tb_boot( $argv[1] ?? '' );
if ( ! defined( 'BWE_GW_SITE_LAYER' ) ) {
	fwrite( STDERR, "the widget's site layer did not load\n" );
	exit( 1 );
}
add_filter( 'bwe_h2x_use_bundle', '__return_false' );

if ( $editor ) {
	require_once ABSPATH . 'wp-admin/includes/admin.php';
	wp_set_current_user( (int) ( get_users( array( 'role' => 'administrator', 'number' => 1, 'fields' => 'ID' ) )[0] ?? 0 ) );
	set_current_screen( 'page' ); // Some themes/plugins ask for the screen while enqueuing.
	do_action( 'enqueue_block_assets' );
	echo 'editor bundle: ' . bwe_h2x_build_bundle() . "\n";
	exit;
}

$page = get_page_by_path( 'wordpress-migration' ) ?: get_post( (int) get_option( 'page_on_front' ) );
query_posts( array( 'page_id' => $page->ID ) );
$GLOBALS['wp_the_query'] = $GLOBALS['wp_query']; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
the_post();
do_action( 'wp_enqueue_scripts' );
echo 'bundle: ' . bwe_h2x_build_bundle() . "\n";

// The editor bundle needs a fresh process (is_admin() is fixed when WordPress loads).
passthru( escapeshellarg( PHP_BINARY ) . ' -c ' . escapeshellarg( (string) php_ini_loaded_file() ) . ' ' . escapeshellarg( __FILE__ ) . ' ' . escapeshellarg( $argv[1] ) . ' --editor' );
