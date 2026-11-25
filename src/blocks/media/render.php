<?php
/**
 * Image / screenshot: a core-image <figure> (so the site's image rules apply too) with the frame, shape and
 * alignment classes of assets/css/blocks.css. A media-library image prints with srcset/sizes, its width/height
 * (no layout shift) and lazy loading — or eager + fetchpriority="high" when it is marked "Above the fold".
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$bwe_id  = (int) ( $attributes['id'] ?? 0 );
$bwe_url = trim( (string) ( $attributes['url'] ?? '' ) );
$bwe_alt = trim( wp_strip_all_tags( (string) ( $attributes['alt'] ?? '' ) ) );
if ( $bwe_id && '' === $bwe_alt ) { // Fall back to the alt text saved in the media library.
	$bwe_alt = trim( (string) get_post_meta( $bwe_id, '_wp_attachment_image_alt', true ) );
}
$bwe_ratio = (string) ( $attributes['ratio'] ?? '' );
$bwe_ratio = in_array( $bwe_ratio, array( '16/9', '4/3', '3/2', '1/1', '3/4', '2/3', '9/16', '21/9' ), true ) ? $bwe_ratio : '';
$bwe_fit   = 'contain' === ( $attributes['fit'] ?? '' ) ? 'contain' : 'cover';
$bwe_eager = ! empty( $attributes['priority'] );

$bwe_img_attr = array(
	'alt'      => $bwe_alt,
	'class'    => 'bwe-gw-media__img' . ( $bwe_id ? ' wp-image-' . $bwe_id : '' ),
	'decoding' => 'async',
	'loading'  => $bwe_eager ? 'eager' : 'lazy',
);
if ( $bwe_eager ) {
	$bwe_img_attr['fetchpriority'] = 'high';
}

$bwe_size = (string) ( $attributes['size'] ?? 'large' );
$bwe_img  = $bwe_id && wp_attachment_is_image( $bwe_id ) ? wp_get_attachment_image( $bwe_id, in_array( $bwe_size, get_intermediate_image_sizes(), true ) || 'full' === $bwe_size ? $bwe_size : 'large', false, $bwe_img_attr ) : '';
if ( '' === $bwe_img && '' !== $bwe_url ) {
	$bwe_img = '<img src="' . esc_url( $bwe_url ) . '"';
	foreach ( $bwe_img_attr as $bwe_k => $bwe_v ) {
		$bwe_img .= ' ' . $bwe_k . '="' . esc_attr( $bwe_v ) . '"';
	}
	$bwe_img .= '>';
}
if ( '' === $bwe_img ) {
	return;
}

$bwe_link = trim( (string) ( $attributes['link'] ?? '' ) );
if ( '' !== $bwe_link ) {
	$bwe_img = '<a class="bwe-gw-media__link" href="' . esc_url( $bwe_link ) . '"' . ( ! empty( $attributes['linkNewTab'] ) ? ' target="_blank" rel="noreferrer noopener"' : '' ) . '>' . $bwe_img . '</a>';
}

$bwe_frame = (string) ( $attributes['frame'] ?? '' );
$bwe_frame = in_array( $bwe_frame, array( 'rounded', 'shot', 'browser' ), true ) ? $bwe_frame : '';
if ( 'browser' === $bwe_frame ) {
	$bwe_bar = trim( wp_strip_all_tags( (string) ( $attributes['barText'] ?? '' ) ) );
	$bwe_img = '<div class="bwe-gw-media__frame"><div class="bwe-gw-media__bar" aria-hidden="true"><i></i><i></i><i></i>' . ( '' !== $bwe_bar ? '<span>' . esc_html( $bwe_bar ) . '</span>' : '' ) . '</div>' . $bwe_img . '</div>';
}

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );
$bwe_align                 = in_array( (string) ( $attributes['align'] ?? '' ), array( 'left', 'right', 'wide' ), true ) ? $attributes['align'] : 'center';
$bwe_classes               = array_filter( array( 'wp-block-image', 'bwe-gw-media', 'bwe-gw-media--' . $bwe_align, $bwe_frame ? 'bwe-gw-media--' . $bwe_frame : '', 'shot' === $bwe_frame ? 'bwe-shot' : '', $bwe_ratio ? 'bwe-gw-ratio-' . str_replace( '/', '-', $bwe_ratio ) : '', $bwe_ratio && 'contain' === $bwe_fit ? 'bwe-gw-fit-contain' : '', $bwe_scope ) );
$bwe_caption               = trim( (string) ( $attributes['caption'] ?? '' ) );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS from cleaned values; image built by core / escaped above.
	. '<figure' . ( empty( $attributes['anchor'] ) ? '' : ' id="' . esc_attr( $attributes['anchor'] ) . '"' ) . ' class="' . esc_attr( implode( ' ', $bwe_classes ) ) . '">'
	. $bwe_img
	. ( '' !== $bwe_caption ? '<figcaption class="wp-element-caption">' . wp_kses_post( $bwe_caption ) . '</figcaption>' : '' )
	. '</figure>';
