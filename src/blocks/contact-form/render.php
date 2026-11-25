<?php
/**
 * Contact form section: eyebrow, heading and intro beside a Contact Form 7 form in its card — the markup of the
 * Contact page's "Send a message" section (and Write for Us' pitch form).
 *
 * The form's layout CSS (BestWebExpert Home's write-for-us.css) is scoped to the page class .bwe-wfu. Contact and
 * Write for Us have that class on their page wrapper; anywhere else the block adds a small .bwe-wfu wrapper of its
 * own ("scope", on by default), so the section looks the same on any page.
 * The shortcode is printed as the core Shortcode block printed it ([…] in a paragraph): WordPress runs it with the
 * rest of the page content, after the text filters, exactly as before.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );

$bwe_eyebrow = ( $attributes['showEyebrow'] ?? true ) ? bwe_gw_attr( $attributes, 'eyebrow' ) : '';
$bwe_id      = sanitize_title( bwe_gw_attr( $attributes, 'headingId' ) );
$bwe_intro   = bwe_gw_attr( $attributes, 'intro' );
$bwe_note    = bwe_gw_attr( $attributes, 'note' );
$bwe_form    = trim( bwe_gw_attr( $attributes, 'form' ) );

$bwe_aside = ( '' !== $bwe_eyebrow ? bwe_gw_group( 'bwex-eyebrow', bwe_gw_p( '', $bwe_eyebrow ) ) : '' )
	. bwe_gw_group( 'bwex-h2', '<h2' . ( '' !== $bwe_id ? ' id="' . esc_attr( $bwe_id ) . '"' : '' ) . ' class="elementor-heading-title">' . wp_kses_post( bwe_gw_attr( $attributes, 'title' ) ) . '</h2>' )
	. ( '' !== $bwe_intro . $bwe_note ? bwe_gw_group( 'bwex-intro', ( '' !== $bwe_intro ? bwe_gw_p( '', $bwe_intro ) : '' ) . ( '' !== $bwe_note ? bwe_gw_p( '', $bwe_note ) : '' ) ) : '' );

$bwe_card = '' !== $bwe_form ? bwe_gw_group( bwe_gw_attr( $attributes, 'cardClasses' ), wpautop( "\n" . wp_kses_post( $bwe_form ) . "\n" ) ) : '';

$bwe_section = '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( implode( ' ', array_filter( array( 'wp-block-group', trim( bwe_gw_attr( $attributes, 'classes' ) ), $bwe_classes ) ) ) ) . '">'
	. bwe_gw_group( 'bwex-wrap', bwe_gw_group( 'bwex-wfu-form__grid', bwe_gw_group( 'bwex-wfu-form__aside', $bwe_aside ) . $bwe_card ) )
	. '</section>';

if ( ! empty( $attributes['scope'] ) ) {
	$bwe_section = bwe_gw_group( 'bwe-wfu', $bwe_section );
}

echo $bwe_style . $bwe_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS from cleaned values; parts escaped above.
