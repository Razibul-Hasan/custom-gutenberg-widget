<?php
/**
 * About split: text (eyebrow, heading, lead, more text) beside a card (title, checklist, button) — the markup of
 * the site's "about" sections (Contact "Who you'll be talking to", About story, plugin authors …). The checklist is
 * the block's inner List block. Empty parts are left out.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered inner blocks (the checklist).
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );

$bwe_w       = static fn( string $id, string $class, string $inner ): string => bwe_gw_group( "elementor-element elementor-element-$id $class", $inner );
$bwe_eyebrow = ( $attributes['showEyebrow'] ?? true ) ? bwe_gw_attr( $attributes, 'eyebrow' ) : '';
$bwe_id      = sanitize_title( bwe_gw_attr( $attributes, 'headingId' ) );
$bwe_lead    = bwe_gw_attr( $attributes, 'lead' );
$bwe_more    = array_values( array_filter( array_map( 'strval', (array) ( $attributes['more'] ?? array() ) ), static fn( $p ) => '' !== trim( $p ) ) );

$bwe_copy = ( '' !== $bwe_eyebrow ? $bwe_w( '5fa24d3', 'bwex-eyebrow elementor-widget elementor-widget-text-editor', bwe_gw_p( '', $bwe_eyebrow ) ) : '' )
	. $bwe_w( 'e4e543b', 'bwex-h2 elementor-widget elementor-widget-heading', '<h2' . ( '' !== $bwe_id ? ' id="' . esc_attr( $bwe_id ) . '"' : '' ) . ' class="elementor-heading-title elementor-size-default">' . wp_kses_post( bwe_gw_attr( $attributes, 'title' ) ) . '</h2>' )
	. ( '' !== $bwe_lead ? $bwe_w( '5d9fa0f', 'bwex-about__lead elementor-widget elementor-widget-text-editor', bwe_gw_p( '', $bwe_lead ) ) : '' )
	. ( $bwe_more ? $bwe_w( 'b6a1f79', 'bwex-about__more elementor-widget elementor-widget-bwex-read-more', bwe_gw_group( 'bwex bwex-readmorew', implode( '', array_map( static fn( $p ) => bwe_gw_p( 'bwex-about__text', $p ), $bwe_more ) ) ) ) : '' );

$bwe_card = ( '' !== bwe_gw_attr( $attributes, 'cardTitle' ) ? $bwe_w( '5ea19df', 'bwex-h3 elementor-widget elementor-widget-heading', '<h3 class="elementor-heading-title elementor-size-default">' . wp_kses_post( bwe_gw_attr( $attributes, 'cardTitle' ) ) . '</h3>' ) : '' )
	. ( '' !== trim( $content ) ? bwe_gw_group( 'bwex bwex-checksw', $content ) : '' )
	. ( '' !== bwe_gw_attr( $attributes, 'btnText' ) ? bwe_gw_button( 'elementor-element elementor-element-46d77b3 bwex-btn bwex-btn--fill elementor-widget elementor-widget-button', bwe_gw_attr( $attributes, 'btnUrl' ), bwe_gw_attr( $attributes, 'btnText' ), ! empty( $attributes['btnNewTab'] ) ) : '' );

$bwe_grid = $bwe_w( '929d0d7', 'e-con-full bwex-about__copy e-flex e-con e-child', $bwe_copy )
	. ( '' !== $bwe_card ? $bwe_w( '90925e9', 'e-con-full bwex-about__card e-flex e-con e-child', $bwe_card ) : '' );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS from cleaned values; parts escaped above.
	. '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( implode( ' ', array_filter( array( 'wp-block-group', trim( bwe_gw_attr( $attributes, 'classes' ) ), $bwe_classes ) ) ) ) . '">'
	. $bwe_w( '2f9aa12', 'e-con-full bwex-wrap e-flex e-con e-child', $bwe_w( '44e1935', 'e-con-full bwex-about__grid e-flex e-con e-child', $bwe_grid ) )
	. '</section>';
