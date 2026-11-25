<?php
/**
 * Platform cards: the same grid <div> the Home "WordPress & Shopify experts" section printed; its cards are
 * bwe/platform-card blocks. Plus a scoped <style> when Styles-tab settings are used.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered cards.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

$bwe_classes = trim( 'wp-block-group ' . ( $attributes['classes'] ?? '' ) . ( $bwe_scope ? ' ' . $bwe_scope : '' ) );

echo $bwe_style . '<div class="' . esc_attr( $bwe_classes ) . '">' . $content . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS from cleaned values; cards rendered by their blocks.
