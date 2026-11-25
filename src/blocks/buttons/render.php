<?php
/**
 * Buttons: core button markup (wp-block-buttons > wp-block-button > a.wp-block-button__link) with the site's button
 * classes, so the site's button CSS styles them; the extra looks and the layout are in assets/css/blocks.css.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$bwe_items = array_values( array_filter( (array) ( $attributes['items'] ?? array() ), static fn( $i ) => is_array( $i ) && '' !== trim( wp_strip_all_tags( (string) ( $i['text'] ?? '' ) ) ) ) );
if ( ! $bwe_items ) {
	return;
}

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

$bwe_classes = array( 'wp-block-buttons', 'bwe-gw-btns' );
foreach ( array( 'align' => '', 'alignTablet' => '-t', 'alignMobile' => '-m' ) as $bwe_key => $bwe_suffix ) {
	$bwe_align = (string) ( $attributes[ $bwe_key ] ?? '' );
	if ( in_array( $bwe_align, array( 'left', 'center', 'right', 'between' ), true ) ) {
		$bwe_classes[] = 'bwe-gw-btns--' . $bwe_align . $bwe_suffix;
	}
}
if ( ! empty( $attributes['stackMobile'] ) ) {
	$bwe_classes[] = 'bwe-gw-btns--stack-m';
}
if ( ! empty( $attributes['fullMobile'] ) ) {
	$bwe_classes[] = 'bwe-gw-btns--full-m';
}
if ( in_array( (string) ( $attributes['size'] ?? '' ), array( 'sm', 'lg' ), true ) ) {
	$bwe_classes[] = 'bwe-gw-btns--' . $attributes['size'];
}
if ( $bwe_scope ) {
	$bwe_classes[] = $bwe_scope;
}

$bwe_html = '';
foreach ( $bwe_items as $bwe_item ) {
	$bwe_html .= bwe_gw_buttons_item( $bwe_item );
}

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS from cleaned values; parts escaped in bwe_gw_buttons_item().
	. '<div' . ( empty( $attributes['anchor'] ) ? '' : ' id="' . esc_attr( $attributes['anchor'] ) . '"' ) . ' class="' . esc_attr( implode( ' ', $bwe_classes ) ) . '">' . $bwe_html . '</div>';
