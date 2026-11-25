<?php
/**
 * One price card: chip, linked title, text, the price rows (inner bwe/price-list), "from" price and button —
 * the platform-card markup the Pricing page printed. Empty parts are left out.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered inner blocks (the price list).
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

$bwe_inner = '';
if ( '' !== bwe_gw_attr( $attributes, 'chip' ) ) {
	$bwe_inner .= bwe_gw_group( 'bwex-plat__chipwrap', bwe_gw_p( 'bwex-plat__chip', bwe_gw_attr( $attributes, 'chip' ) ) );
}

$bwe_title = wp_kses_post( bwe_gw_attr( $attributes, 'title' ) );
if ( '' !== bwe_gw_attr( $attributes, 'titleUrl' ) ) {
	$bwe_title = '<a href="' . esc_url( bwe_gw_attr( $attributes, 'titleUrl' ) ) . '">' . $bwe_title . '</a>';
}
$bwe_inner .= bwe_gw_group( 'bwex-h3', '<h3 class="elementor-heading-title">' . $bwe_title . '</h3>' );

if ( '' !== bwe_gw_attr( $attributes, 'text' ) ) {
	$bwe_inner .= bwe_gw_group( 'bwex-plat__text', bwe_gw_p( '', bwe_gw_attr( $attributes, 'text' ) ) );
}
if ( '' !== trim( $content ) ) {
	$bwe_inner .= bwe_gw_group( 'bwex-plat__list', $content );
}

$bwe_foot = '' !== bwe_gw_attr( $attributes, 'price' ) ? bwe_gw_p( 'bwex-plat__price', bwe_gw_attr( $attributes, 'price' ) ) : '';
if ( '' !== bwe_gw_attr( $attributes, 'btnText' ) ) {
	$bwe_foot .= bwe_gw_button( 'bwex-btn', bwe_gw_attr( $attributes, 'btnUrl' ), bwe_gw_attr( $attributes, 'btnText' ), ! empty( $attributes['btnNewTab'] ) );
}
if ( '' !== $bwe_foot ) {
	$bwe_inner .= bwe_gw_group( 'bwex-plat__foot', $bwe_foot );
}

$bwe_id = sanitize_title( bwe_gw_attr( $attributes, 'cardId' ) );
$bwe_card = '<div' . ( '' !== $bwe_id ? ' id="' . esc_attr( $bwe_id ) . '"' : '' ) . ' class="wp-block-group bwex-plat bwe-prx__card">' . $bwe_inner . '</div>';

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS from cleaned values; parts escaped above.
	. bwe_gw_group(
		trim( bwe_gw_attr( $attributes, 'wrapClasses' ) . ' ' . $bwe_scope ),
		bwe_gw_group( 'elementor-widget-container', bwe_gw_group( 'bwex bwex-platw', $bwe_card ) )
	);
