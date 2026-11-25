<?php
/**
 * Testimonials: header, video testimonials (bwe/video-card) and the review links line.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered video cards.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );
$bwe_more                    = ( $attributes['showMore'] ?? true ) ? bwe_gw_attr( $attributes, 'more' ) : '';

$bwe_proof = bwe_gw_group( 'bwex bwex-proofw', bwe_gw_group( 'bwex-quotes', $content ) . ( '' !== $bwe_more ? bwe_gw_p( 'bwex-more', $bwe_more ) : '' ) );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( trim( 'wp-block-group elementor-element elementor-element-fdfb384 e-con-full bwex-section bwex-section--dark bwex-proof e-flex e-con e-child ' . $bwe_classes ) ) . '">'
	. bwe_gw_group(
		'elementor-element elementor-element-68c7412 e-con-full bwex-wrap e-flex e-con e-child',
		bwe_gw_head_widget( $attributes, 'a63a1b2' )
		. bwe_gw_group( 'elementor-element elementor-element-ace3f83 elementor-widget elementor-widget-bwex-proof', bwe_gw_group( 'elementor-widget-container', $bwe_proof ) )
	)
	. '</section>';
