<?php
/**
 * Numbered steps: the same <ol> the group-based list printed on the live page (CSS in BestWebExpert Home).
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered steps.
 */

defined( 'ABSPATH' ) || exit;

$bwe_modifiers = trim( (string) ( $attributes['modifiers'] ?? 'bwex-num--row bwex-num--dark' ) );
// Items per row (Settings): a scope class + <style> only when set, else exactly the old markup.
[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );
echo $bwe_style . '<ol class="' . esc_attr( trim( 'bwex-num ' . $bwe_modifiers . ' ' . $bwe_scope ) ) . '" start="1">' . $content . '</ol>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks.
