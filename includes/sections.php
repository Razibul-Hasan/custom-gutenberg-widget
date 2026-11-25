<?php
/**
 * Shared markup helpers for the Home section blocks (Why us, Testimonials, Pricing, Starting prices, Cost panel,
 * How it works, Our products, FAQ, Call to action). Each block prints exactly the markup its old core-block
 * pattern printed, so the site's stylesheets and scripts keep working unchanged.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * A core group <div>.
 *
 * @param string $class Classes after wp-block-group.
 * @param string $inner Inner HTML.
 */
function bwe_gw_group( $class, $inner ) {
	return '<div class="wp-block-group ' . esc_attr( trim( $class ) ) . '">' . $inner . '</div>';
}

/**
 * A core paragraph as the live page prints it (wp-block-paragraph class added by core).
 *
 * @param string $class Extra classes ('' = none).
 * @param string $html  Paragraph HTML (cleaned with wp_kses_post).
 */
function bwe_gw_p( $class, $html ) {
	return '<p class="' . esc_attr( trim( $class . ' wp-block-paragraph' ) ) . '">' . wp_kses_post( (string) $html ) . '</p>';
}

/**
 * An attribute as a string.
 *
 * @param array  $attributes Block attributes.
 * @param string $key        Attribute.
 */
function bwe_gw_attr( array $attributes, $key ) {
	return (string) ( $attributes[ $key ] ?? '' );
}

/**
 * Section header: eyebrow, heading (italic = highlight) and intro — the markup of bwe/section-head.
 *
 * @param array $attributes Block attributes (eyebrow, title, intro, split, showEyebrow, showIntro, headingId).
 * @param bool  $headw      Wrap it in .bwex.bwex-headw (as the section-head widget did).
 */
function bwe_gw_head( array $attributes, $headw = true ) {
	$eyebrow = ( $attributes['showEyebrow'] ?? true ) ? bwe_gw_attr( $attributes, 'eyebrow' ) : '';
	$intro   = ( $attributes['showIntro'] ?? true ) ? bwe_gw_attr( $attributes, 'intro' ) : '';
	$main    = ( '' !== $eyebrow ? bwe_gw_group( 'bwex-eyebrow', bwe_gw_p( '', $eyebrow ) ) : '' )
		. bwe_gw_group( 'bwex-h2', '<h2' . ( '' !== bwe_gw_attr( $attributes, 'headingId' ) ? ' id="' . esc_attr( sanitize_title( bwe_gw_attr( $attributes, 'headingId' ) ) ) . '"' : '' ) . ' class="elementor-heading-title">' . wp_kses_post( bwe_gw_attr( $attributes, 'title' ) ) . '</h2>' );
	$head    = bwe_gw_group( 'bwex-head__main', $main ) . ( '' !== $intro ? bwe_gw_group( 'bwex-intro', bwe_gw_p( '', $intro ) ) : '' );
	$head    = bwe_gw_group( ( $attributes['split'] ?? true ) ? 'bwex-head bwex-head--split' : 'bwex-head', $head );
	return $headw ? bwe_gw_group( 'bwex bwex-headw', $head ) : $head;
}

/**
 * The section header inside the section-head widget wrapper the site's sections use (the same markup in every
 * section widget).
 *
 * @param array  $attributes Block attributes (the header fields).
 * @param string $element_id Elementor id of the wrapper ('' = none). With $id_key, the block's own setting wins.
 * @param string $id_key     Attribute that can change the id (headElementId), '' = fixed.
 */
function bwe_gw_head_widget( array $attributes, $element_id = '', $id_key = '' ) {
	$id = sanitize_html_class( (string) ( '' !== $id_key ? ( $attributes[ $id_key ] ?? $element_id ) : $element_id ) );
	return bwe_gw_group(
		'elementor-element ' . ( '' !== $id ? 'elementor-element-' . $id . ' ' : '' ) . 'elementor-widget elementor-widget-bwex-section-head',
		bwe_gw_group( 'elementor-widget-container', bwe_gw_head( $attributes ) )
	);
}

/**
 * Style + icon CSS of a section block, and the classes they need.
 *
 * @param string $block_dir  Block directory (its block.json has the style map).
 * @param array  $attributes Block attributes.
 * @param string $icon_part  Where the eyebrow icon is drawn ('' = block has no eyebrow icon).
 * @return array{0: string, 1: string} [ extra classes, <style> elements ]
 */
function bwe_gw_section_style( $block_dir, array $attributes, $icon_part = ' .bwex-eyebrow p::before' ) {
	[ $scope, $style ] = bwe_gw_style_for_block( $block_dir, $attributes );
	$icon_class        = '';
	$icon_style        = '';
	if ( '' !== $icon_part && function_exists( 'bwe_gw_icon_for_block' ) ) {
		[ $icon_class, $icon_style ] = bwe_gw_icon_for_block( $attributes, $icon_part, '#0b0b0c' );
	}
	return array( trim( $scope . ' ' . $icon_class ), $style . $icon_style );
}

/**
 * id="" attribute from a section ID setting.
 *
 * @param array  $attributes Block attributes.
 * @param string $key        Attribute holding the ID.
 */
function bwe_gw_id_attr( array $attributes, $key = 'sectionId' ) {
	$id = sanitize_title( bwe_gw_attr( $attributes, $key ) );
	return '' === $id ? '' : ' id="' . esc_attr( $id ) . '"';
}

/**
 * A core button, rendered through BestWebExpert Home's button variants (.bwex-btn → Elementor-style button,
 * .bwex-card__btn → plain link, .bwex-faq__toggle → the FAQ "show more" button).
 *
 * @param string $class  Button wrapper classes.
 * @param string $url    Link.
 * @param string $text   Label (inline HTML allowed).
 * @param bool   $newtab Open in a new tab.
 */
function bwe_gw_button( $class, $url, $text, $newtab = false ) {
	$extra = $newtab ? ' target="_blank" rel="noreferrer noopener"' : '';
	$html  = '<div class="wp-block-button ' . esc_attr( trim( $class ) ) . '"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $url ) . '"' . $extra . '>' . wp_kses_post( $text ) . '</a></div>';
	if ( function_exists( 'bwe_bm_button' ) ) {
		$html = bwe_bm_button( $html, array( 'attrs' => array( 'className' => trim( $class ) ) ) );
	}
	return $html;
}

/**
 * True while the content readers (schema, Rank Math <head>, stylesheet markers) are rendering our blocks: blocks
 * then print plain markup and enqueue nothing (see includes/content-readers.php).
 */
function bwe_gw_readers_mode() {
	return ! empty( $GLOBALS['bwe_gw_readers'] );
}
