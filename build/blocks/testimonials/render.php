<?php
/**
 * Testimonials: header, video testimonials (bwe/video-card) and the review links line.
 *
 * "Slider" settings: swipe row on phones, and on desktop once there are more videos than fit (includes/mobile-slider.php).
 *
 * @package BWE_Gutenberg_Widget
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered video cards.
 * @var WP_Block $block      Block instance.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );
$bwe_more                    = ( $attributes['showMore'] ?? true ) ? bwe_gw_attr( $attributes, 'more' ) : '';

$bwe_count                       = isset( $block ) ? count( $block->inner_blocks ) : 0;
[ $bwe_ms_class, $bwe_ms_style ] = bwe_gw_slider_list_attrs( $attributes, $bwe_count );
$bwe_quotes_class                = 'bwex-quotes' . ( bwe_gw_slider_on( $attributes ) ? '' : ' bwex-quotes--list' ) . ( '' !== $bwe_ms_class ? ' ' . $bwe_ms_class : '' );
$bwe_quotes                      = '' === $bwe_ms_class
	? bwe_gw_group( $bwe_quotes_class, $content )
	: '<div class="wp-block-group ' . esc_attr( $bwe_quotes_class ) . '" style="' . esc_attr( $bwe_ms_style ) . '">' . $content . '</div>' . bwe_gw_slider_nav( $attributes, $bwe_count );

$bwe_proof = bwe_gw_group( 'bwex bwex-proofw', $bwe_quotes . ( '' !== $bwe_more ? bwe_gw_p( 'bwex-more', $bwe_more ) : '' ) );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( trim( 'wp-block-group elementor-element elementor-element-fdfb384 e-con-full bwex-section bwex-section--dark bwex-proof e-flex e-con e-child ' . $bwe_classes ) ) . '">'
	. bwe_gw_group(
		'elementor-element elementor-element-68c7412 e-con-full bwex-wrap e-flex e-con e-child',
		bwe_gw_head_widget( $attributes, 'a63a1b2' )
		. bwe_gw_group( 'elementor-element elementor-element-ace3f83 elementor-widget elementor-widget-bwex-proof', bwe_gw_group( 'elementor-widget-container', $bwe_proof ) )
	)
	. '</section>';
