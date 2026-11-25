<?php
/**
 * "BWE Page hero" block pattern (2026-11-21): the site's dark hero as normal, editable blocks.
 *
 * Insert it at the top of any page (Patterns → BestWebExpert → BWE Page hero) and edit the badge,
 * small heading, title (italic words = highlighted), intro and buttons. The background comes from
 * Customizer → Custom Settings → Hero Background (astra-child/inc/hero-background.php), and the
 * entrance animation from includes/home-2.php, exactly like the Home hero.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

// The "BWE Page hero" pattern is a saved pattern now (Appearance → Design → Patterns).

/**
 * A page that holds the hero needs Astra's full-width, no-title layout (like Contact and Pricing).
 * Set it when the page is saved, unless the owner already chose a layout for that page.
 *
 * @param int $post_id Post ID.
 */
function bwe_page_hero_layout( $post_id ) {
	if ( wp_is_post_revision( $post_id ) || 'page' !== get_post_type( $post_id ) ) {
		return;
	}
	// Expanded: a page's hero is usually a synced pattern.
	if ( false === strpos( bwe_post_content_expanded( $post_id ), 'bwe-page-hero' ) ) {
		return;
	}
	$meta = array(
		'ast-site-content-layout' => 'full-width-container',
		'site-content-style'      => 'unboxed',
		'site-sidebar-layout'     => 'no-sidebar',
		'site-sidebar-style'      => 'unboxed',
		'site-post-title'         => 'disabled',
		'ast-featured-img'        => 'disabled',
	);
	foreach ( $meta as $key => $value ) {
		if ( in_array( (string) get_post_meta( $post_id, $key, true ), array( '', 'default' ), true ) ) {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_page', 'bwe_page_hero_layout', 20 );
