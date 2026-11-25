<?php
/**
 * One project of Selected work: screenshot (linked), number, linked title, tag and text — the core Image /
 * Paragraph / Heading markup the Portfolio page printed. Empty parts are left out.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$bwe_url    = bwe_gw_attr( $attributes, 'url' );
$bwe_target = ! empty( $attributes['newTab'] ) && '' !== $bwe_url ? ' target="_blank" rel="noreferrer noopener"' : '';
$bwe_link   = static fn( string $inner ): string => '' !== $bwe_url ? '<a href="' . esc_url( $bwe_url ) . '"' . $bwe_target . '>' . $inner . '</a>' : $inner;

$bwe_img_id  = (int) ( $attributes['imageId'] ?? 0 );
$bwe_img_url = bwe_gw_attr( $attributes, 'imageUrl' );
if ( '' === $bwe_img_url && $bwe_img_id ) {
	$bwe_img_url = (string) wp_get_attachment_image_url( $bwe_img_id, 'full' );
}
$bwe_shot = '';
if ( '' !== $bwe_img_url ) {
	$bwe_img  = '<img src="' . esc_url( $bwe_img_url ) . '" alt="' . esc_attr( bwe_gw_attr( $attributes, 'imageAlt' ) ) . '"' . ( $bwe_img_id ? ' class="wp-image-' . $bwe_img_id . '"' : '' ) . '/>';
	$bwe_shot = '<figure class="wp-block-image size-full bwex-work__shot">' . $bwe_link( $bwe_img ) . '</figure>';
	// The core Image block's stylesheet, loaded at the same point of the page as when this was a core Image block.
	if ( ! bwe_gw_readers_mode() ) {
		wp_enqueue_style( 'wp-block-image' );
	}
}

$bwe_num  = bwe_gw_attr( $attributes, 'num' );
$bwe_tag  = bwe_gw_attr( $attributes, 'tag' );
$bwe_text = bwe_gw_attr( $attributes, 'text' );
$bwe_meta = ( '' !== $bwe_num ? bwe_gw_p( 'bwex-work__num', $bwe_num ) : '' )
	. '<h3 class="wp-block-heading bwex-work__title">' . $bwe_link( wp_kses_post( bwe_gw_attr( $attributes, 'title' ) ) ) . '</h3>'
	. ( '' !== $bwe_tag ? bwe_gw_p( 'bwex-work__tag', $bwe_tag ) : '' );

// This project's own colours (Styles tab): only printed when set, so projects without them keep their markup.
[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

echo $bwe_style . bwe_gw_group( trim( 'bwex-work__item ' . $bwe_scope ), $bwe_shot . bwe_gw_group( 'bwex-work__meta', $bwe_meta ) . ( '' !== $bwe_text ? bwe_gw_p( 'bwex-work__text', $bwe_text ) : '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- parts escaped above.
