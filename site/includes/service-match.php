<?php
/**
 * Service pages "match Home" layer (2026-11-13).
 *
 * Adds the body class bwe-svcx on every service page and loads assets/service-match.css,
 * which restyles the shared bwe-* service components in the flat, hairline, light-type
 * look of the Home page. CSS only: no page content changes. Delete the CSS file to revert.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * Slugs of the service pages that get the Home look. Slugs (not IDs) so it survives the move to live.
 *
 * @return string[]
 */
function bwe_svcx_slugs() {
	return array(
		'wordpress-and-shopify-services',
		'best-wordpress-expert',
		'best-shopify-expert',
		'wordpress-speed-optimization',
		'wordpress-malware-removal',
		'wordpress-migration',
		'wordpress-maintenance',
		'woocommerce-development',
		'shopify-store-setup',
		'shopify-theme-customization',
		'shopify-speed-optimization',
		'migrate-to-shopify',
	);
}

/**
 * Whether the current request is one of the service pages and the CSS layer exists.
 *
 * @return bool
 */
function bwe_svcx_active() {
	if ( is_admin() || ! is_page() || ! file_exists( BWE_HOME_DIR . '/assets/service-match.css' ) ) {
		return false;
	}

	// Pages rebuilt from Home's sections (2026-11-21, marker bwe-rd) no longer need this layer.
	if ( false !== strpos( bwe_post_content_expanded( get_queried_object_id() ), 'bwe-rd' ) ) {
		return false;
	}

	return in_array( get_post_field( 'post_name', get_queried_object_id() ), bwe_svcx_slugs(), true );
}

/**
 * Marks service pages with the bwe-svcx body class.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function bwe_svcx_body_class( $classes ) {
	if ( bwe_svcx_active() ) {
		$classes[] = 'bwe-svcx';
	}

	return $classes;
}
add_filter( 'body_class', 'bwe_svcx_body_class' );

/**
 * Loads the layer after the existing service stylesheets.
 */
function bwe_svcx_enqueue() {
	if ( ! bwe_svcx_active() ) {
		return;
	}

	$deps = wp_style_is( 'bwe-wpx', 'enqueued' ) ? array( 'bwe-wpx' ) : array( 'bwe-services' );

	wp_enqueue_style(
		'bwe-svcx',
		plugins_url( 'assets/service-match.css', BWE_HOME_DIR . '/site.php' ),
		$deps,
		(string) filemtime( BWE_HOME_DIR . '/assets/service-match.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'bwe_svcx_enqueue', 20 );

/**
 * Loads the styles for Home's live-chat line in the final CTA on every other page that uses it
 * (Home gets them from home-2/v4.css).
 */
function bwe_final_chat_enqueue() {
	if ( is_admin() || is_front_page() || ! is_singular() || ! file_exists( BWE_HOME_DIR . '/assets/final-chat.css' ) ) {
		return;
	}

	if ( false === strpos( bwe_post_content_expanded( get_queried_object_id() ), 'bwe-final__chat' ) ) {
		return;
	}

	wp_enqueue_style(
		'bwe-final-chat',
		plugins_url( 'assets/final-chat.css', BWE_HOME_DIR . '/site.php' ),
		array(),
		(string) filemtime( BWE_HOME_DIR . '/assets/final-chat.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'bwe_final_chat_enqueue', 21 );
