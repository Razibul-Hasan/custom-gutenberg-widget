<?php
/**
 * One product card: a picture (animated mockup, own image or none), tag, name, text, demo links and a button.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );
$bwe_art                   = (string) ( $attributes['art'] ?? 'reels' );
$bwe_picture               = '';
// The mockups are decoration (aria-hidden): the content readers never counted their words, so they get none.
if ( in_array( $bwe_art, array( 'reels', 'boxes', 'lift' ), true ) && ! bwe_gw_readers_mode() ) {
	$bwe_picture = bwe_gw_product_art( $bwe_art );
} elseif ( 'image' === $bwe_art && '' !== bwe_gw_attr( $attributes, 'imageUrl' ) ) {
	// Image fit / position / space around it (Picture panel); defaults = cover, centred, no space.
	$bwe_fit = (string) ( $attributes['imageFit'] ?? 'cover' );
	$bwe_fit = in_array( $bwe_fit, array( 'cover', 'contain', 'fill', 'none', 'scale-down' ), true ) ? $bwe_fit : 'cover';
	$bwe_pos = (string) ( $attributes['imagePosition'] ?? 'center center' );
	$bwe_pos = preg_match( '/^(left|center|right) (top|center|bottom)$/', $bwe_pos ) ? $bwe_pos : 'center center';
	$bwe_pad = max( 0, min( 200, (int) ( $attributes['imagePadding'] ?? 0 ) ) );
	$bwe_css = 'width:100%;height:100%;object-fit:' . $bwe_fit
		. ( 'center center' !== $bwe_pos ? ';object-position:' . $bwe_pos : '' )
		. ( $bwe_pad > 0 ? ';padding:' . $bwe_pad . 'px;box-sizing:border-box' : '' );

	$bwe_picture = '<div class="bwe-work__art bwe-work__art--image"><img src="' . esc_url( bwe_gw_attr( $attributes, 'imageUrl' ) ) . '" alt="' . esc_attr( bwe_gw_attr( $attributes, 'imageAlt' ) ) . '" loading="lazy" decoding="async" style="' . esc_attr( $bwe_css ) . '"></div>';
}

$bwe_tag   = bwe_gw_attr( $attributes, 'tag' );
$bwe_text  = bwe_gw_attr( $attributes, 'text' );
$bwe_links = ( $attributes['showLinks'] ?? true ) ? bwe_gw_attr( $attributes, 'links' ) : '';
$bwe_label = bwe_gw_attr( $attributes, 'linksLabel' );
$bwe_btn   = bwe_gw_attr( $attributes, 'btnText' );
$bwe_body  = ( '' !== $bwe_tag ? bwe_gw_p( 'bwex-card__tag', $bwe_tag ) : '' )
	. '<h3 class="bwex-card__title">' . wp_kses_post( bwe_gw_attr( $attributes, 'name' ) ) . '</h3>'
	. ( '' !== $bwe_text ? bwe_gw_group( 'bwex-card__text', bwe_gw_p( '', $bwe_text ) ) : '' )
	. ( '' !== $bwe_links ? bwe_gw_p( 'bwex-card__links', ( '' !== $bwe_label ? '<span>' . $bwe_label . '</span> ' : '' ) . $bwe_links ) : '' )
	. ( '' !== $bwe_btn ? bwe_gw_button( 'bwex-card__btn', bwe_gw_attr( $attributes, 'btnUrl' ), $bwe_btn ) : '' );

$bwe_card_class = 'bwex-card' . ( in_array( $bwe_art, array( 'reels', 'boxes', 'lift' ), true ) ? ' bwex-card--' . $bwe_art : '' );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. bwe_gw_group(
		trim( bwe_gw_attr( $attributes, 'wrapClasses' ) . ' ' . $bwe_scope ),
		bwe_gw_group( 'elementor-widget-container', '<article class="wp-block-group ' . esc_attr( $bwe_card_class ) . '">' . $bwe_picture . bwe_gw_group( 'bwex-card__body', $bwe_body ) . '</article>' )
	);
