<?php
/**
 * Price plans: the row of plan cards (bwe/price-plan).
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered plans.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

echo $bwe_style . bwe_gw_group( 'elementor-element elementor-element-e077279 e-con-full bwex-plans e-flex e-con e-child ' . $bwe_scope, $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS from cleaned values; inner blocks rendered by core.
