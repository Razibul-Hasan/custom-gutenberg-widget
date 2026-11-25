<?php
/**
 * Permanent redirects for pages that were removed.
 *
 * Slugs (not IDs) so this works unchanged on live. Add a row when a page is deleted.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * Removed page path (no slashes) => where visitors and Google should go instead.
 *
 * @return array<string, string>
 */
function bwe_removed_page_redirects() {
	return array(
		// AI SEO service removed 2026-11-16.
		'best-ai-seo-expert' => '/wordpress-and-shopify-services/',
		// Overlapping blog posts merged into the live guides 2026-11-21.
		'how-to-hire-the-best-wordpress-developer' => '/how-to-hire-a-web-developer/',
		'questions-to-ask-a-wordpress-developer'   => '/how-to-hire-a-web-developer/#questions-to-ask',
		'custom-wordpress-website-cost'            => '/how-much-does-a-website-cost/#custom-wordpress-cost',
		// "Web Design Tips" category renamed to WordPress 2026-11-21.
		'category/web-design-tips'                 => '/category/wordpress/',
	);
}

/**
 * 301-redirects a removed page to its replacement.
 */
function bwe_redirect_removed_pages() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
		return;
	}

	$path = trim( (string) wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '', PHP_URL_PATH ), '/' );
	$map  = bwe_removed_page_redirects();

	if ( isset( $map[ $path ] ) ) {
		wp_safe_redirect( home_url( $map[ $path ] ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'bwe_redirect_removed_pages', 1 );
