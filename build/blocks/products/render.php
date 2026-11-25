<?php
/**
 * Our products: header, product cards (bwe/product-card) and the line under them.
 * Phone layout "slider": the cards swipe sideways on phones (includes/mobile-slider.php).
 *
 * @package BWE_Gutenberg_Widget
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered product cards.
 * @var WP_Block $block      Block instance.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );
$bwe_more                    = ( $attributes['showMore'] ?? true ) ? bwe_gw_attr( $attributes, 'more' ) : '';
[ $bwe_ms_class, $bwe_ms_style ] = bwe_gw_slider_list_attrs( $attributes );
$bwe_cards_class                 = 'elementor-element elementor-element-923a8b6 e-con-full bwex-cards e-flex e-con e-child' . ( '' !== $bwe_ms_class ? ' ' . $bwe_ms_class : '' );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( trim( 'wp-block-group elementor-element elementor-element-d09262e e-con-full bwex-section bwex-section--soft bwex-work e-flex e-con e-child ' . $bwe_classes ) ) . '">'
	. bwe_gw_group(
		'elementor-element elementor-element-bf148e3 e-con-full bwex-wrap e-flex e-con e-child',
		bwe_gw_head_widget( $attributes, 'addf4f8' )
		. ( '' === $bwe_ms_class
			? bwe_gw_group( $bwe_cards_class, $content )
			: '<div class="wp-block-group ' . esc_attr( $bwe_cards_class ) . '" style="' . esc_attr( $bwe_ms_style ) . '">' . $content . '</div>'
				. bwe_gw_slider_nav( $attributes, isset( $block ) ? count( $block->inner_blocks ) : substr_count( $content, '<article' ) ) )
		. ( '' !== $bwe_more ? bwe_gw_group( 'elementor-element elementor-element-6fc4e95 bwex-more elementor-widget elementor-widget-text-editor', bwe_gw_p( '', $bwe_more ) ) : '' )
	)
	. '</section>';
