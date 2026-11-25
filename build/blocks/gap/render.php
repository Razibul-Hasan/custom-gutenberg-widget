<?php
/**
 * Gap / divider: an empty, aria-hidden <div> (the default heights 64 / 48 / 32px and the line are in
 * assets/css/blocks.css); the height per device and the line settings come from the block's style settings.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS from cleaned values.
	. '<div' . ( empty( $attributes['anchor'] ) ? '' : ' id="' . esc_attr( $attributes['anchor'] ) . '"' ) . ' class="' . esc_attr( trim( 'bwe-gw-gap' . ( ! empty( $attributes['line'] ) ? ' bwe-gw-gap--line' : '' ) . ( $bwe_scope ? ' ' . $bwe_scope : '' ) ) ) . '" aria-hidden="true"></div>';
