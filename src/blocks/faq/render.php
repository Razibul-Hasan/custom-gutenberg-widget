<?php
/**
 * FAQ: header + "ask a question" button on one side, the numbered questions (bwe/faq-item) on the other, and the
 * "Show N more questions" button when some questions are set to stay hidden until it is clicked.
 *
 * @package BWE_Gutenberg_Widget
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered questions.
 * @var WP_Block $block      Block instance.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );

$bwe_list_id = sanitize_title( bwe_gw_attr( $attributes, 'listId' ) );
$bwe_list_id = '' !== $bwe_list_id ? $bwe_list_id : 'bwex-faq-' . substr( md5( (string) wp_json_encode( $attributes ) ), 0, 7 );

$bwe_hidden = 0;
foreach ( $block->parsed_block['innerBlocks'] ?? array() as $bwe_item ) {
	if ( 'bwe/faq-item' === ( $bwe_item['blockName'] ?? '' ) && ! empty( $bwe_item['attrs']['extra'] ) ) {
		++$bwe_hidden;
	}
}
$bwe_toggle = '';
if ( $bwe_hidden > 0 ) {
	$bwe_label  = bwe_gw_attr( $attributes, 'toggleText' );
	$bwe_label  = '' !== $bwe_label ? $bwe_label : ( 1 === $bwe_hidden ? 'Show {n} more question' : 'Show {n} more questions' );
	$bwe_toggle = bwe_gw_button( 'bwex-faq__toggle', '#' . $bwe_list_id, str_replace( '{n}', (string) $bwe_hidden, $bwe_label ) );
}

$bwe_ask = ( $attributes['showAsk'] ?? true ) && '' !== bwe_gw_attr( $attributes, 'askText' )
	? bwe_gw_button( 'elementor-element elementor-element-90a6427 bwex-btn elementor-widget elementor-widget-button', bwe_gw_attr( $attributes, 'askUrl' ), bwe_gw_attr( $attributes, 'askText' ), ! empty( $attributes['askNewTab'] ) )
	: '';


$bwe_intro = bwe_gw_group(
	'elementor-element elementor-element-9e568fa e-con-full bwex-faq__intro e-flex e-con e-child',
	bwe_gw_head_widget( $attributes, 'b4093ad', 'headElementId' ) . $bwe_ask
);
$bwe_list  = bwe_gw_group(
	'elementor-element elementor-element-5eb4cba elementor-widget elementor-widget-bwex-faq',
	bwe_gw_group( 'elementor-widget-container', '<div id="' . esc_attr( $bwe_list_id ) . '" class="wp-block-group bwex-faq">' . $content . '</div>' . $bwe_toggle )
);

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( trim( 'wp-block-group elementor-element elementor-element-bfd7b46 e-con-full bwex-section bwex-faq-section e-flex e-con e-child ' . $bwe_classes ) ) . '">'
	. bwe_gw_group( 'elementor-element elementor-element-4652c6c e-con-full bwex-wrap e-flex e-con e-child', bwe_gw_group( 'elementor-element elementor-element-17f5218 e-con-full bwex-faq__grid e-flex e-con e-child', $bwe_intro . $bwe_list ) )
	. '</section>';
