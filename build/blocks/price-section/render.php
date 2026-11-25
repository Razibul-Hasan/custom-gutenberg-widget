<?php
/**
 * Fixes & services: header and the price cards (bwe/price-card) in the platform-card grid — the markup the
 * Pricing page's "Price list" section printed before it became a block.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered price cards.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );
// Cards per row: the site's own two-card layout, or the even layout (includes/price-section.php).
$bwe_layout = bwe_gw_price_section_layout( $attributes, isset( $block ) && $block instanceof WP_Block ? count( $block->inner_blocks ) : 2 );
$bwe_style .= bwe_gw_price_section_style( $bwe_layout );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( implode( ' ', array_filter( array( 'wp-block-group elementor-element elementor-element-0334ad8 e-con-full bwex-section bwex-services bwe-prx__prices e-flex e-con e-child', trim( bwe_gw_attr( $attributes, 'classes' ) ), $bwe_layout, $bwe_classes ) ) ) ) . '">'
	. bwe_gw_group(
		'elementor-element elementor-element-b51609b e-con-full bwex-wrap e-flex e-con e-child',
		bwe_gw_head_widget( $attributes, 'b43b5f9' )
		. bwe_gw_group( 'elementor-element elementor-element-1de90ac e-con-full bwex-plats bwe-prx__plats e-flex e-con e-child', $content )
	)
	. '</section>';
