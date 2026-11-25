<?php
/**
 * Service tile: the same linked <li> the Home services list printed. The icon comes from the site CSS
 * (.bwex-svc__item--<icon>), the colour scheme from .bwex-svc__tile--<platform>.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

// A custom icon (Icon panel) replaces the drawn one; none set = exactly the old markup.
[ $bwe_icon_class, $bwe_icon_style ] = bwe_gw_icon_for_block( $attributes, ' .bwex-svc__top::before', '#c8ff3d' );

printf(
	'<li class="bwex-svc__item bwex-svc__item--%1$s%7$s">%8$s<a class="bwex-svc__tile bwex-svc__tile--%2$s" href="%3$s"><span class="bwex-svc__top"><span class="bwex-svc__tag">%4$s</span></span><strong class="bwex-svc__name">%5$s</strong><span class="bwex-svc__desc">%6$s</span><span class="bwex-svc__arrow" aria-hidden="true">→</span></a></li>',
	esc_attr( sanitize_html_class( (string) ( $attributes['icon'] ?? '' ) ) ),
	esc_attr( sanitize_html_class( (string) ( $attributes['platform'] ?? '' ) ) ),
	esc_url( (string) ( $attributes['url'] ?? '' ) ),
	wp_kses_post( (string) ( $attributes['tag'] ?? '' ) ),
	wp_kses_post( (string) ( $attributes['name'] ?? '' ) ),
	wp_kses_post( (string) ( $attributes['desc'] ?? '' ) ),
	$bwe_icon_class ? ' ' . esc_attr( $bwe_icon_class ) : '',
	$bwe_icon_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from kses-cleaned, URL-encoded values.
);
