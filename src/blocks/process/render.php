<?php
/**
 * How it works: header and the numbered steps (bwe/step).
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered steps.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );


echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( trim( 'wp-block-group elementor-element elementor-element-8fdfd26 e-con-full bwex-section bwex-section--dark bwex-process e-flex e-con e-child ' . $bwe_classes ) ) . '">'
	. bwe_gw_group(
		'elementor-element elementor-element-de37328 e-con-full bwex-wrap e-flex e-con e-child',
		bwe_gw_head_widget( $attributes, '60e9620', 'headElementId' )
		. bwe_gw_group( 'elementor-element elementor-element-847773d elementor-widget elementor-widget-bwex-numbered-list', bwe_gw_group( 'elementor-widget-container', '<ol class="bwex-num bwex-num--row bwex-num--dark" start="1">' . $content . '</ol>' ) )
	)
	. '</section>';
