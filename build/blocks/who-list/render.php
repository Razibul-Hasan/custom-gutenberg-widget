<?php
/**
 * "Who we build for" list: the same <ol> the core List printed (CSS in BestWebExpert Home).
 *
 * @package BWE_Gutenberg_Widget
 * @var string $content Rendered cards.
 */

defined( 'ABSPATH' ) || exit;

// Items per row (Settings): a scope class + <style> only when set, else exactly the old markup.
[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );
echo $bwe_style . '<ol class="' . esc_attr( trim( 'wp-block-list bwex-who__list ' . $bwe_scope ) ) . '">' . $content . '</ol>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks.
