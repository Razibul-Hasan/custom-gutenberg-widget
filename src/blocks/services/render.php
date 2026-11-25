<?php
/**
 * Services band: the same markup the Home services pattern printed, plus a scoped <style> when Styles-tab
 * settings are used.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered service tiles.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

$bwe_classes = trim( 'wp-block-group ' . ( $attributes['modifiers'] ?? '' ) . ( $bwe_scope ? ' ' . $bwe_scope : '' ) );
$bwe_id      = '' === (string) ( $attributes['sectionId'] ?? '' ) ? '' : ' id="' . esc_attr( $attributes['sectionId'] ) . '"';
$bwe_lead    = (string) ( $attributes['lead'] ?? '' );
$bwe_more    = ! empty( $attributes['showMore'] ) && '' !== (string) ( $attributes['more'] ?? '' );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . $bwe_id . ' class="' . esc_attr( $bwe_classes ) . '"><div class="wp-block-group bwex-wrap"><div class="wp-block-group bwex-svc">'
	. '<div class="wp-block-group bwex-svc__head"><div class="wp-block-group bwex-h2 bwex-svc__title">'
	. '<div class="wp-block-group bwex-eyebrow"><p class="wp-block-paragraph">' . wp_kses_post( (string) ( $attributes['eyebrow'] ?? '' ) ) . '</p></div>'
	. '<h2 class="elementor-heading-title">' . wp_kses_post( (string) ( $attributes['title'] ?? '' ) ) . '</h2></div>'
	. ( '' !== $bwe_lead ? '<div class="wp-block-group bwex-svc__lead"><p class="wp-block-paragraph">' . wp_kses_post( $bwe_lead ) . '</p></div>' : '' )
	. '</div>'
	. '<div class="wp-block-group bwex-svc__body"><ul class="wp-block-list bwex-svc__grid">' . $content . '</ul></div>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks.
	. ( $bwe_more ? '<p class="bwex-more wp-block-paragraph">' . wp_kses_post( (string) $attributes['more'] ) . '</p>' : '' )
	. '</div></div></section>';
