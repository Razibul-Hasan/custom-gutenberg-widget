<?php
/**
 * Plugin Name:       Best Web Expert Gutenberg Widget
 * Description:       BestWebExpert's own Gutenberg blocks (FAQ item, spec card, price row, steps, section head …). The editor shows the same markup as the live site. Self-contained: brings the site's styles, scripts and schema with it.
 * Version:           1.1.0
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Author:           BestWebExpert
 * License:           GPL-2.0-or-later
 * Text Domain:       bestwebexpert
 * Domain Path:       /languages
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

define( 'BWE_GW_DIR', __DIR__ );
define( 'BWE_GW_VERSION', '1.1.0' );

/**
 * Whether the old BestWebExpert Home plugin is active (and its file exists). This plugin loads before it, so its
 * constants aren't defined yet: ask WordPress's own list of plugins it is about to load.
 */
function bwe_gw_home_plugin_active(): bool {
	$file    = wp_normalize_path( WP_PLUGIN_DIR . '/bestwebexpert-home/bestwebexpert-home.php' );
	$plugins = wp_get_active_and_valid_plugins();
	if ( is_multisite() ) {
		$plugins = array_merge( $plugins, wp_get_active_network_plugins() );
	}
	return in_array( $file, array_map( 'wp_normalize_path', $plugins ), true );
}

require BWE_GW_DIR . '/includes/style-engine.php';
require BWE_GW_DIR . '/includes/icons.php';
require BWE_GW_DIR . '/includes/sections.php';
require BWE_GW_DIR . '/includes/blocks.php';
require BWE_GW_DIR . '/includes/global-controls.php';
require BWE_GW_DIR . '/includes/generic-blocks.php';
require BWE_GW_DIR . '/includes/product-art.php';
require BWE_GW_DIR . '/includes/price-section.php';
require BWE_GW_DIR . '/includes/contact-form.php';
require BWE_GW_DIR . '/includes/content-readers.php';
require BWE_GW_DIR . '/includes/rank-math-editor.php';
require BWE_GW_DIR . '/includes/previews.php';
require BWE_GW_DIR . '/includes/page-mode.php';
require BWE_GW_DIR . '/includes/page-layout.php';
require BWE_GW_DIR . '/includes/parts.php';
require BWE_GW_DIR . '/includes/starters.php';

/*
 * The site design layer (site/: styles, scripts, render filters, templates, schema), formerly the BestWebExpert Home
 * plugin. Loaded right here, at the moment WordPress would have loaded Home (the next plugin alphabetically), so every
 * hook is registered in the same order as before. With Home still active, Home serves it (both would clash).
 */
if ( ! bwe_gw_home_plugin_active() && ! defined( 'BWE_HOME_DIR' ) ) {
	define( 'BWE_HOME_DIR', BWE_GW_DIR . '/site' );
	define( 'BWE_HOME_VERSION', '1.8.0' ); // Home's last version: keeps the asset version strings it printed.
	define( 'BWE_GW_SITE_LAYER', true );
	require BWE_HOME_DIR . '/site.php';
}
