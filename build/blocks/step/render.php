<?php
/**
 * Step: the same <li> the group-based step printed on the live page.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

// A custom icon (Icon panel) replaces the step's drawn icon tile picture; none set = exactly the old markup.
[ $bwe_icon_class, $bwe_icon_style ] = bwe_gw_icon_for_block( $attributes, '::after', '#0b0d0c' );

printf(
	'<li class="bwex-num__item%1$s%5$s">%6$s<span class="bwex-num__n" aria-hidden="true">%2$s</span><div class="bwex-num__body"><h3 class="bwex-num__title">%3$s</h3><div class="bwex-num__text"><p class="wp-block-paragraph">%4$s</p></div></div></li>',
	( $attributes['reveal'] ?? true ) ? ' bwex-reveal' : '',
	esc_html( $attributes['n'] ?? '' ),
	wp_kses_post( $attributes['title'] ?? '' ),
	wp_kses_post( $attributes['text'] ?? '' ),
	$bwe_icon_class ? ' ' . esc_attr( $bwe_icon_class ) : '',
	$bwe_icon_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from kses-cleaned, URL-encoded values.
);
