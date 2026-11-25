<?php
/**
 * Plugin Name:       Best Web Expert Gutenberg Widget
 * Description:       BestWebExpert's own Gutenberg blocks (FAQ item, spec card, price row, steps, section head …). The editor shows the same markup as the live site; the styles come from the BestWebExpert Home plugin.
 * Version:           1.0.0
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Requires Plugins:  bestwebexpert-home
 * Author:            BestWebExpert
 * License:           GPL-2.0-or-later
 * Text Domain:       bestwebexpert
 * Domain Path:       /languages
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

define( 'BWE_GW_DIR', __DIR__ );
define( 'BWE_GW_VERSION', '1.0.0' );

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
