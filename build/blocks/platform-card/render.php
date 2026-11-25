<?php
/**
 * Platform card: the same markup Home's platform cards printed. The image and the button are rendered through
 * the core Image / Button blocks with the site's markers (bwe-raw-img, bwex-btn), so they come out exactly as
 * before — srcset, size classes and the elementor-button markup included. The service list is the card's inner
 * blocks (a normal List block). Empty parts are left out; a badge is only printed when it has text.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered inner blocks (the service list).
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

$bwe_group = static fn( string $class, string $inner ): string => '<div class="wp-block-group ' . $class . '">' . $inner . '</div>';
$bwe_attr  = static fn( string $key ): string => (string) ( $attributes[ $key ] ?? '' );

$bwe_inner = '';

// Image (core Image block, marker bwe-raw-img: the <img> only).
$bwe_img_id  = (int) ( $attributes['imageId'] ?? 0 );
$bwe_img_url = $bwe_attr( 'imageUrl' );
if ( '' === $bwe_img_url && $bwe_img_id ) {
	$bwe_img_url = (string) wp_get_attachment_image_url( $bwe_img_id, 'large' );
}
if ( '' !== $bwe_img_url ) {
	$bwe_image  = array(
		'blockName'    => 'core/image',
		'attrs'        => array_filter(
			array(
				'id'              => $bwe_img_id ? $bwe_img_id : null,
				'sizeSlug'        => 'large',
				'linkDestination' => 'none',
				'className'       => 'bwe-raw-img',
			)
		),
		'innerBlocks'  => array(),
		'innerHTML'    => '',
		'innerContent' => array(),
	);
	$bwe_img_html = '<figure class="wp-block-image size-large bwe-raw-img"><img src="' . esc_url( $bwe_img_url ) . '" alt="' . esc_attr( $bwe_attr( 'imageAlt' ) ) . '"' . ( $bwe_img_id ? ' class="wp-image-' . $bwe_img_id . '"' : '' ) . '/></figure>';
	$bwe_image['innerHTML']    = $bwe_img_html;
	$bwe_image['innerContent'] = array( $bwe_img_html );
	$bwe_inner .= $bwe_group( 'bwex-plat__img', render_block( $bwe_image ) );
}

if ( '' !== $bwe_attr( 'chip' ) ) {
	$bwe_inner .= $bwe_group( 'bwex-plat__chipwrap', '<p class="bwex-plat__chip wp-block-paragraph">' . wp_kses_post( $bwe_attr( 'chip' ) ) . '</p>' );
}

$bwe_title = wp_kses_post( $bwe_attr( 'title' ) );
if ( '' !== $bwe_attr( 'titleUrl' ) ) {
	$bwe_title = '<a href="' . esc_url( $bwe_attr( 'titleUrl' ) ) . '">' . $bwe_title . '</a>';
}
$bwe_inner .= $bwe_group( 'bwex-h3', '<h3 class="elementor-heading-title">' . $bwe_title . '</h3>' );

if ( '' !== $bwe_attr( 'text' ) ) {
	$bwe_inner .= $bwe_group( 'bwex-plat__text', '<p class="wp-block-paragraph">' . wp_kses_post( $bwe_attr( 'text' ) ) . '</p>' );
}

if ( '' !== trim( $content ) ) {
	$bwe_inner .= $bwe_group( 'bwex-plat__list', $content );
}

// Price + button (core Button block, marker bwex-btn: <div class="bwex-btn"><a class="elementor-button …">).
$bwe_foot = '' !== $bwe_attr( 'price' ) ? '<p class="bwex-plat__price wp-block-paragraph">' . wp_kses_post( $bwe_attr( 'price' ) ) . '</p>' : '';
if ( '' !== $bwe_attr( 'btnText' ) ) {
	$bwe_target  = empty( $attributes['btnNewTab'] ) ? '' : ' target="_blank" rel="noopener"';
	$bwe_btn     = '<div class="wp-block-button bwex-btn"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $bwe_attr( 'btnUrl' ) ) . '"' . $bwe_target . '>' . wp_kses_post( $bwe_attr( 'btnText' ) ) . '</a></div>';
	$bwe_foot   .= render_block(
		array(
			'blockName'    => 'core/button',
			'attrs'        => array( 'className' => 'bwex-btn' ),
			'innerBlocks'  => array(),
			'innerHTML'    => $bwe_btn,
			'innerContent' => array( $bwe_btn ),
		)
	);
}
if ( '' !== $bwe_foot ) {
	$bwe_inner .= $bwe_group( 'bwex-plat__foot', $bwe_foot );
}

// Optional badge ("Popular", "New"…): only printed when it has text, so cards without one keep their markup.
$bwe_badge = '';
$bwe_wrap  = '';
if ( '' !== trim( wp_strip_all_tags( $bwe_attr( 'badge' ) ) ) ) {
	$bwe_badge = '<span class="bwe-pc-badge" style="position:absolute;top:18px;right:18px;z-index:2;padding:6px 12px;border-radius:999px;background:#c8ff3d;color:#0b0b0c;font-size:12px;font-weight:600;letter-spacing:.06em;line-height:1.2;text-transform:uppercase">' . wp_kses_post( $bwe_attr( 'badge' ) ) . '</span>';
	$bwe_wrap  = ' style="position:relative"';
}

$bwe_classes = trim( 'wp-block-group ' . $bwe_attr( 'wrapClasses' ) . ( $bwe_scope ? ' ' . $bwe_scope : '' ) );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS from cleaned values.
	. '<div class="' . esc_attr( $bwe_classes ) . '"' . $bwe_wrap . '>' . $bwe_badge
	. $bwe_group( 'elementor-widget-container', $bwe_group( 'bwex bwex-platw', $bwe_group( 'bwex-plat', $bwe_inner ) ) )
	. '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- parts escaped above.
