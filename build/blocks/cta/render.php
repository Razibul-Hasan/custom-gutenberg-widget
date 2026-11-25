<?php
/**
 * Call to action ("Ready when you are"): the dark closing box — eyebrow, heading, text, two buttons, the live-chat
 * line (its link opens the chat) and a small note.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes, ' p.bwe-eyebrow::before' );

$bwe_eyebrow = ( $attributes['showEyebrow'] ?? true ) ? bwe_gw_attr( $attributes, 'eyebrow' ) : '';
$bwe_lead    = bwe_gw_attr( $attributes, 'lead' );
$bwe_buttons = '';
if ( '' !== bwe_gw_attr( $attributes, 'btn1Text' ) ) {
	$bwe_buttons .= bwe_gw_button( 'bwe-btn bwe-btn--primary', bwe_gw_attr( $attributes, 'btn1Url' ), bwe_gw_attr( $attributes, 'btn1Text' ), ! empty( $attributes['btn1NewTab'] ) );
}
if ( ( $attributes['showBtn2'] ?? true ) && '' !== bwe_gw_attr( $attributes, 'btn2Text' ) ) {
	$bwe_buttons .= bwe_gw_button( 'bwe-btn bwe-btn--ghost', bwe_gw_attr( $attributes, 'btn2Url' ), bwe_gw_attr( $attributes, 'btn2Text' ), ! empty( $attributes['btn2NewTab'] ) );
}
$bwe_chat = '';
if ( ( $attributes['showChat'] ?? true ) && '' !== bwe_gw_attr( $attributes, 'chat' ) ) {
	$bwe_chat = '<p class="bwe-final__chat">' . wp_kses_post( bwe_gw_attr( $attributes, 'chat' ) ) . '</p>';
	if ( function_exists( 'bwe_bm_paragraph' ) ) { // Green dot + the link opens the live chat (BestWebExpert Home).
		$bwe_chat = bwe_bm_paragraph( $bwe_chat, array( 'attrs' => array( 'className' => 'bwe-final__chat' ) ) );
	}
}
$bwe_note = ( $attributes['showNote'] ?? true ) ? bwe_gw_attr( $attributes, 'note' ) : '';

$bwe_box = ( '' !== $bwe_eyebrow ? bwe_gw_group( 'bwex-cta__eyebrow', bwe_gw_p( 'bwe-eyebrow', $bwe_eyebrow ) ) : '' )
	. '<h2 class="wp-block-heading">' . wp_kses_post( bwe_gw_attr( $attributes, 'title' ) ) . '</h2>'
	. ( '' !== $bwe_lead ? bwe_gw_p( 'bwe-lead', $bwe_lead ) : '' )
	. ( '' !== $bwe_buttons ? bwe_gw_group( 'bwe-actions', $bwe_buttons ) : '' )
	. $bwe_chat
	. ( '' !== $bwe_note ? bwe_gw_p( 'bwe-final__note', $bwe_note ) : '' );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. bwe_gw_group(
		'elementor-element elementor-element-f672073 elementor-widget elementor-widget-bwex-cta',
		bwe_gw_group(
			'elementor-widget-container',
			bwe_gw_group( 'bwe-home bwex bwex-ctaw', '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( trim( 'wp-block-group bwe-section bwe-final ' . $bwe_classes ) ) . '">' . bwe_gw_group( 'bwe-final__box', $bwe_box ) . '</section>' )
		)
	);
