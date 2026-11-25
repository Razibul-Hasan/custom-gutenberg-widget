<?php
/**
 * FAQ question: the same markup the core Details FAQ item printed (CSS in BestWebExpert Home, FAQPage schema reads it).
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered answer blocks.
 */

defined( 'ABSPATH' ) || exit;

$bwe_classes = 'wp-block-details bwex-faq__item' . ( empty( $attributes['extra'] ) ? '' : ' bwex-faq__item--extra' ) . ' is-layout-flow wp-block-details-is-layout-flow';

printf(
	'<details class="%1$s"><summary><span class="bwex-faq__n" aria-hidden="true">%2$s</span><span class="bwex-faq__q">%3$s</span><span class="bwex-faq__icon" aria-hidden="true"></span></summary><div class="wp-block-group bwex-faq__a">%4$s</div></details>',
	esc_attr( $bwe_classes ),
	esc_html( $attributes['n'] ?? '' ),
	wp_kses_post( $attributes['question'] ?? '' ),
	$content // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks.
);
