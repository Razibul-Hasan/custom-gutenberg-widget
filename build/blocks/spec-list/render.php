<?php
/**
 * Spec cards list: the same <ul> the group-based spec list printed (CSS in BestWebExpert Home).
 *
 * @package BWE_Gutenberg_Widget
 * @var string $content Rendered spec cards.
 */

defined( 'ABSPATH' ) || exit;

// Items per row (Settings): a scope class + <style> only when set, else exactly the old markup.
[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );
echo $bwe_style . '<ul class="' . esc_attr( trim( 'wp-block-list bwex-spec__list ' . $bwe_scope ) ) . '">' . $content . '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks.
