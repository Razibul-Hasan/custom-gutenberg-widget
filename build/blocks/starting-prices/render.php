<?php
/**
 * Starting prices card: a label, linked "service — from $X" rows, a note and a link to every price.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

$bwe_rows = '';
foreach ( (array) ( $attributes['items'] ?? array() ) as $bwe_item ) {
	$bwe_item  = is_array( $bwe_item ) ? $bwe_item : array();
	$bwe_label = wp_kses_post( (string) ( $bwe_item['label'] ?? '' ) );
	$bwe_price = wp_kses_post( (string) ( $bwe_item['price'] ?? '' ) );
	$bwe_url   = (string) ( $bwe_item['url'] ?? '' );
	if ( '' === $bwe_label && '' === $bwe_price ) {
		continue;
	}
	$bwe_row   = '<span>' . $bwe_label . '</span> <strong>' . $bwe_price . '</strong>';
	$bwe_rows .= '<li>' . ( '' !== $bwe_url ? '<a href="' . esc_url( $bwe_url ) . '">' . $bwe_row . '</a>' : $bwe_row ) . '</li>';
}
$bwe_label = ( $attributes['showLabel'] ?? true ) ? bwe_gw_attr( $attributes, 'label' ) : '';
$bwe_note  = ( $attributes['showNote'] ?? true ) ? bwe_gw_attr( $attributes, 'note' ) : '';
$bwe_all   = ( $attributes['showAll'] ?? true ) ? bwe_gw_attr( $attributes, 'allText' ) : '';

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. bwe_gw_group(
		'bwex-pricenote ' . $bwe_scope,
		( '' !== $bwe_label ? bwe_gw_p( 'bwex-pricenote__label', $bwe_label ) : '' )
		. ( '' !== $bwe_rows ? '<ul class="wp-block-list bwex-pricenote__list">' . $bwe_rows . '</ul>' : '' )
		. ( '' !== $bwe_note ? bwe_gw_p( 'bwex-pricenote__note', $bwe_note ) : '' )
		. ( '' !== $bwe_all ? bwe_gw_p( 'bwex-pricenote__all', '<a href="' . esc_url( bwe_gw_attr( $attributes, 'allUrl' ) ) . '">' . $bwe_all . '</a>' ) : '' )
	);
