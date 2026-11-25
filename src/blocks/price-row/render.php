<?php
/**
 * Price row: the same <li> the core List item printed.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

printf(
	'<li><span class="bwe-prx__svc">%1$s <small>%2$s</small></span> <strong class="bwe-prx__amt">%3$s <em>%4$s</em></strong></li>',
	wp_kses_post( $attributes['service'] ?? '' ),
	wp_kses_post( $attributes['note'] ?? '' ),
	wp_kses_post( $attributes['amount'] ?? '' ),
	wp_kses_post( $attributes['unit'] ?? '' )
);
