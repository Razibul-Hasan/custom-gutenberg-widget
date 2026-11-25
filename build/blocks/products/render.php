<?php
/**
 * Our products: header, product cards (bwe/product-card) and the line under them.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered product cards.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );
$bwe_more                    = ( $attributes['showMore'] ?? true ) ? bwe_gw_attr( $attributes, 'more' ) : '';

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( trim( 'wp-block-group elementor-element elementor-element-d09262e e-con-full bwex-section bwex-section--soft bwex-work e-flex e-con e-child ' . $bwe_classes ) ) . '">'
	. bwe_gw_group(
		'elementor-element elementor-element-bf148e3 e-con-full bwex-wrap e-flex e-con e-child',
		bwe_gw_head_widget( $attributes, 'addf4f8' )
		. bwe_gw_group( 'elementor-element elementor-element-923a8b6 e-con-full bwex-cards e-flex e-con e-child', $content )
		. ( '' !== $bwe_more ? bwe_gw_group( 'elementor-element elementor-element-6fc4e95 bwex-more elementor-widget elementor-widget-text-editor', bwe_gw_p( '', $bwe_more ) ) : '' )
	)
	. '</section>';
