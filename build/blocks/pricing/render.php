<?php
/**
 * Pricing: header, then its content blocks (price plans, starting prices, cost panel …) in the section's wrap.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered inner blocks.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );

// Note under the plans ("Hosting upgrades … are quoted separately").
$bwe_more = bwe_gw_attr( $attributes, 'more' );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( trim( 'wp-block-group elementor-element elementor-element-74d01ef e-con-full bwex-section bwex-pricing e-flex e-con e-child ' . $bwe_classes ) ) . '">'
	. bwe_gw_group(
		'elementor-element elementor-element-d60292a e-con-full bwex-wrap e-flex e-con e-child',
		bwe_gw_head_widget( $attributes, '15dc625', 'headElementId' )
		. $content
		. ( '' !== $bwe_more ? bwe_gw_p( 'bwex-more', $bwe_more ) : '' )
	)
	. '</section>';
