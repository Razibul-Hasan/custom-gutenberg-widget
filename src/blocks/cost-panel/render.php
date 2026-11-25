<?php
/**
 * Cost panel: a heading and short explainer paragraphs (bold start = the point's name).
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

$bwe_items = '';
foreach ( (array) ( $attributes['items'] ?? array() ) as $bwe_item ) {
	$bwe_item = is_array( $bwe_item ) ? $bwe_item : array( 'text' => (string) $bwe_item );
	$bwe_text = (string) ( $bwe_item['text'] ?? '' );
	if ( '' === trim( $bwe_text ) ) {
		continue;
	}
	$bwe_wrap   = (string) ( $bwe_item['wrap'] ?? '' );
	$bwe_items .= bwe_gw_group( '' !== $bwe_wrap ? $bwe_wrap : 'elementor-element elementor-widget elementor-widget-text-editor', bwe_gw_p( '', $bwe_text ) );
}
$bwe_title = bwe_gw_attr( $attributes, 'title' );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. bwe_gw_group(
		'elementor-element elementor-element-fc1d409 e-con-full bwex-cost e-flex e-con e-child ' . $bwe_scope,
		( '' !== $bwe_title ? bwe_gw_group( 'elementor-element elementor-element-b452c35 bwex-cost__title elementor-widget elementor-widget-heading', '<h3 class="elementor-heading-title elementor-size-default">' . wp_kses_post( $bwe_title ) . '</h3>' ) : '' )
		. bwe_gw_group( 'elementor-element elementor-element-0fee8c3 e-con-full bwex-cost__grid e-flex e-con e-child', $bwe_items )
	);
