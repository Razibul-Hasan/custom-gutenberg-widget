<?php
/**
 * Plugin mockup: the animated product-card picture (includes/product-art.php) on its own.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

echo bwe_gw_product_art( (string) ( $attributes['art'] ?? 'boxes' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed markup from bwe_gw_product_arts().
