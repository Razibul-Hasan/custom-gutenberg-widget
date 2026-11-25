<?php
/**
 * Hero: the same markup the Home hero pattern printed (core groups + the GSAP settings filter + the scroll-cue
 * filter of BestWebExpert Home), plus a scoped <style> when Styles-tab settings are used.
 *
 * @package BWE_Gutenberg_Widget
 * @var array    $attributes Block attributes.
 * @var WP_Block $block      Block instance.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );

// Entrance animation: same settings (and filter) the hero script has always read; the block can turn it off or
// change its speed and delay.
$bwe_anim = apply_filters(
	'bwe_h2x_hero_settings',
	array(
		'on'      => true,
		'speed'   => 1,
		'delay'   => 0,
		'stagger' => 0.055,
		'words'   => 'rise',
		'header'  => true,
		'bg'      => true,
		'pill'    => true,
		'line'    => true,
		'lead'    => true,
		'btns'    => true,
		'proof'   => true,
		'cue'     => true,
		'pointer' => 1,
		'magnet'  => 1,
		'fade'    => array( 70, 0.15 ),
		'swell'   => 1.35,
		'gx'      => 50,
		'gy'      => 30,
	),
	$block->parsed_block
);
if ( empty( $attributes['animate'] ) ) {
	$bwe_anim['on'] = false;
}
if ( isset( $attributes['animSpeed'] ) && (float) $attributes['animSpeed'] > 0 && abs( (float) $attributes['animSpeed'] - 1.0 ) > 0.001 ) {
	$bwe_anim['speed'] = (float) $attributes['animSpeed'];
}
if ( ! empty( $attributes['animDelay'] ) ) {
	$bwe_anim['delay'] = (float) $attributes['animDelay'];
}

$bwe_classes = trim( 'wp-block-group ' . ( $attributes['modifiers'] ?? '' ) . ( $bwe_scope ? ' ' . $bwe_scope : '' ) );
$bwe_id      = empty( $attributes['anchor'] ) ? '' : ' id="' . esc_attr( $attributes['anchor'] ) . '"';
$bwe_button  = static fn( string $class, string $url, string $text, bool $newtab = false ): string => '<div class="wp-block-button ' . $class . '"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $url ) . '"' . ( $newtab ? ' target="_blank" rel="noreferrer noopener"' : '' ) . '>' . wp_kses_post( $text ) . '</a></div>';

$bwe_buttons = $bwe_button( 'bwe-btn bwe-btn--primary', (string) ( $attributes['btn1Url'] ?? '' ), (string) ( $attributes['btn1Text'] ?? '' ), ! empty( $attributes['btn1NewTab'] ) );
if ( ! empty( $attributes['showBtn2'] ) && '' !== (string) ( $attributes['btn2Text'] ?? '' ) ) {
	$bwe_buttons .= $bwe_button( 'bwe-btn bwex-hero__link bwex-hero__btn2', (string) ( $attributes['btn2Url'] ?? '' ), (string) $attributes['btn2Text'], ! empty( $attributes['btn2NewTab'] ) );
}

// Kicker: the small line above the heading (the page heroes' "bwe-kicker"); empty = left out.
$bwe_kicker = trim( (string) ( $attributes['kicker'] ?? '' ) );
$bwe_kicker = '' === $bwe_kicker ? '' : '<p class="bwe-kicker wp-block-paragraph">' . wp_kses_post( $bwe_kicker ) . '</p>';

// Jump links: numbered in-page links under the buttons (site CSS: p.bwex-jump); none = left out.
$bwe_jump = '';
foreach ( array_values( array_filter( (array) ( $attributes['jumpLinks'] ?? array() ), static fn( $l ) => is_array( $l ) && '' !== trim( (string) ( $l['label'] ?? '' ) ) ) ) as $bwe_i => $bwe_link ) {
	$bwe_jump .= '<a href="' . esc_url( (string) ( $bwe_link['url'] ?? '' ) ) . '"><span>' . esc_html( str_pad( (string) ( $bwe_i + 1 ), 2, '0', STR_PAD_LEFT ) ) . '</span>' . esc_html( wp_strip_all_tags( (string) $bwe_link['label'] ) ) . '</a>';
}
$bwe_jump = '' === $bwe_jump ? '' : '<p class="bwex-jump wp-block-paragraph">' . $bwe_jump . '</p>';

// Facts line: short facts under the buttons ("10 looks", "14 pieces" …; site CSS: .bwex-hero__meta); none = left out.
$bwe_facts = '';
foreach ( (array) ( $attributes['facts'] ?? array() ) as $bwe_fact ) {
	$bwe_fact = is_array( $bwe_fact ) ? trim( (string) ( $bwe_fact['text'] ?? '' ) ) : '';
	if ( '' !== $bwe_fact ) {
		$bwe_facts .= '<span>' . wp_kses_post( $bwe_fact ) . '</span>';
	}
}
$bwe_facts = '' === $bwe_facts ? '' : '<p class="bwex-hero__meta wp-block-paragraph">' . $bwe_facts . '</p>';

$bwe_cue = '';
if ( ! empty( $attributes['showScroll'] ) ) {
	$bwe_cue = '<div class="bwex-scroll-wrap"><a class="bwex-scroll" href="' . esc_url( (string) ( $attributes['scrollUrl'] ?? '#services' ) ) . '"><span>' . esc_html( wp_strip_all_tags( (string) ( $attributes['scrollText'] ?? '' ) ) ) . '</span><i aria-hidden="true"></i></a></div>';
}

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . $bwe_id . ' class="' . esc_attr( $bwe_classes ) . '" data-bwex-hero="' . esc_attr( (string) wp_json_encode( $bwe_anim ) ) . '" data-bwex-pre="1">'
	. '<div class="wp-block-group bwe-hero__copy">'
	. $bwe_kicker
	. '<h1 class="wp-block-heading elementor-heading-title bwe-hero__title">' . wp_kses_post( (string) ( $attributes['title'] ?? '' ) ) . '</h1>'
	. ( '' !== (string) ( $attributes['lead'] ?? '' ) ? '<p class="bwe-lead wp-block-paragraph">' . wp_kses_post( (string) $attributes['lead'] ) . '</p>' : '' )
	. '<div class="wp-block-buttons bwe-actions is-layout-flex wp-block-buttons-is-layout-flex">' . $bwe_buttons . '</div>'
	. $bwe_facts
	. $bwe_jump
	. '</div>'
	. $bwe_cue
	. '</section>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
