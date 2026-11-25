<?php
/**
 * Core blocks that print the site's original section markup (2026-11-21).
 *
 * Home and the pages built from it used Custom HTML blocks for buttons, images, the numbered
 * process list, the FAQ "show more" button and the live-chat line. Those are now normal blocks
 * the owner can edit; the filters below make them render exactly the markup the stylesheets and
 * scripts were written for. Each filter only acts on a block that carries its marker class.
 *
 * Markers:
 * - core/buttons  .bwe-btns-raw      → only the buttons inside are printed (no wrapper div).
 * - core/button   .bwex-btn          → <div class="…"><a class="elementor-button …"><span>…</span></a></div>
 * - core/button   .bwex-card__btn    → <a class="bwex-card__btn">
 * - core/button   .bwex-faq__toggle  → <button> that opens the extra FAQs; its link (#id) is the FAQ list.
 * - core/image    .bwe-raw-img       → the <img> only (no <figure>).
 * - core/paragraph .bwe-final__chat  → live-chat line with the green dot; its link opens Crisp.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * True when the block's className has the class.
 *
 * @param array  $block Block.
 * @param string $class Class.
 */
function bwe_bm_has( $block, $class ) {
	return false !== strpos( ' ' . ( $block['attrs']['className'] ?? '' ) . ' ', ' ' . $class . ' ' );
}

/**
 * Link parts of a rendered core/button.
 *
 * @param string $html Rendered button.
 * @return array|null [ href, text, target, rel ]
 */
function bwe_bm_link( $html ) {
	if ( ! preg_match( '/<a\b([^>]*)>(.*?)<\/a>/s', $html, $m ) ) {
		return null;
	}
	$attr = static function ( $name ) use ( $m ) {
		return preg_match( '/\s' . $name . '="([^"]*)"/', $m[1], $a ) ? html_entity_decode( $a[1], ENT_QUOTES ) : '';
	};
	return array( $attr( 'href' ), trim( $m[2] ), $attr( 'target' ), $attr( 'rel' ) );
}

/**
 * Buttons wrapper marked bwe-btns-raw: print the buttons only.
 *
 * @param string $html  Rendered block.
 * @param array  $block Block.
 */
function bwe_bm_buttons( $html, $block ) {
	if ( ! bwe_bm_has( $block, 'bwe-btns-raw' ) ) {
		return $html;
	}
	$html = trim( $html );
	$html = preg_replace( '/^<div\b[^>]*>/', '', $html, 1 );
	return preg_replace( '/<\/div>$/', '', $html, 1 );
}
add_filter( 'render_block_core/buttons', 'bwe_bm_buttons', 20, 2 );

/**
 * Button variants.
 *
 * @param string $html  Rendered block.
 * @param array  $block Block.
 */
function bwe_bm_button( $html, $block ) {
	$card   = bwe_bm_has( $block, 'bwex-card__btn' );
	$toggle = bwe_bm_has( $block, 'bwex-faq__toggle' );
	$btn    = bwe_bm_has( $block, 'bwex-btn' );
	if ( ! $card && ! $toggle && ! $btn ) {
		return $html;
	}
	$link = bwe_bm_link( $html );
	if ( ! $link ) {
		return $html;
	}
	list( $href, $text, $target, $rel ) = $link;
	$extra = ( $target ? ' target="' . esc_attr( $target ) . '"' : '' ) . ( $rel ? ' rel="' . esc_attr( $rel ) . '"' : '' );

	if ( $toggle ) {
		$label = wp_strip_all_tags( $text );
		return '<button type="button" class="bwex-faq__toggle" aria-expanded="false" aria-controls="' . esc_attr( ltrim( $href, '#' ) ) . '" data-more="' . esc_attr( $label ) . '" data-less="' . esc_attr__( 'Show fewer questions', 'bestwebexpert' ) . '">' . esc_html( $label ) . '</button>';
	}
	if ( $card ) {
		return '<a href="' . esc_url( $href ) . '" class="bwex-card__btn"' . $extra . '>' . $text . '</a>';
	}
	return '<div class="' . esc_attr( trim( $block['attrs']['className'] ) ) . '"><a class="elementor-button elementor-button-link elementor-size-sm" href="' . esc_url( $href ) . '"' . $extra . '><span class="elementor-button-content-wrapper"><span class="elementor-button-text">' . $text . '</span></span></a></div>';
}
add_filter( 'render_block_core/button', 'bwe_bm_button', 20, 2 );

/**
 * Image marked bwe-raw-img: the <img> only, with the classes the old markup had.
 *
 * @param string $html  Rendered block.
 * @param array  $block Block.
 */
function bwe_bm_image( $html, $block ) {
	if ( ! bwe_bm_has( $block, 'bwe-raw-img' ) || ! preg_match( '/<img\b[^>]*>/', $html, $m ) ) {
		return $html;
	}
	$img = $m[0];
	$img = preg_replace( '/\sclass="([^"]*)"/', ' class="attachment-large size-large $1"', $img, 1 );
	if ( false === strpos( $img, ' class="' ) ) {
		$img = str_replace( '<img ', '<img class="attachment-large size-large" ', $img );
	}
	return $img;
}
add_filter( 'render_block_core/image', 'bwe_bm_image', 20, 2 );

/**
 * Paragraph variant: live-chat line.
 *
 * @param string $html  Rendered block.
 * @param array  $block Block.
 */
function bwe_bm_paragraph( $html, $block ) {
	if ( ! bwe_bm_has( $block, 'bwe-final__chat' ) || ! preg_match( '/^\s*<p\b[^>]*>(.*?)(<a\b[^>]*>.*?<\/a>)(.*?)<\/p>\s*$/s', $html, $m ) ) {
		return $html;
	}
	$msg  = apply_filters( 'bwe_chat_message', __( "Hi! I found you on your website and I'd like to chat about my project.", 'bestwebexpert' ) );
	$link = false === strpos( $m[2], 'data-bwe-chat' ) ? preg_replace( '/^<a\b/', '<a data-bwe-chat="' . esc_attr( $msg ) . '"', $m[2] ) : $m[2];
	return '<p class="bwe-final__chat"><span class="bwe-final__dot" aria-hidden="true"></span><span>' . trim( $m[1] ) . '</span> ' . $link . $m[3] . '</p>';
}
add_filter( 'render_block_core/paragraph', 'bwe_bm_paragraph', 20, 2 );


// "BWE Product art" block (bwe/product-art) moved to the Best Web Expert Gutenberg Widget plugin (2026-11-22).

// Numbered steps, spec cards, price rows, FAQ items, "who" cards and section headers are blocks of the
// Best Web Expert Gutenberg Widget plugin since 2026-11-23; their old group/paragraph render filters were removed.

