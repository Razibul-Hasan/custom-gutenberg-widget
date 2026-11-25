<?php
/**
 * Custom icons for blocks whose icon the site CSS draws (service tiles, eyebrows, steps).
 *
 * A block's "bweIcon" attribute replaces that drawn icon:
 *   { source: "library", name, svg (inner markup of a Lucide icon), color, size }
 *   { source: "upload",  url, size }          — any image from the Media Library
 *   { source: "svg",     svg (full markup), color, size } — pasted SVG code
 *   { source: "none" }                         — no icon
 * Empty = the site's own icon, so an untouched block prints exactly its old markup.
 *
 * The icon is drawn as the background image of the same ::before / ::after the site uses, via a scoped <style>
 * (class bwe-i-<hash>). SVG goes in as a URL-encoded data URI: as an image it cannot run scripts, and the
 * encoding means it cannot close the CSS rule or the <style> element. The editor twin is
 * src/blocks/shared/icon-engine.js.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/** SVG elements and attributes kept from an icon. */
function bwe_gw_icon_kses() {
	$common = array_fill_keys( array( 'fill', 'stroke', 'stroke-width', 'stroke-linecap', 'stroke-linejoin', 'stroke-miterlimit', 'stroke-dasharray', 'stroke-dashoffset', 'opacity', 'fill-opacity', 'stroke-opacity', 'fill-rule', 'clip-rule', 'transform', 'class', 'id', 'style' ), true );
	$shape  = static fn( array $extra ) => $common + array_fill_keys( $extra, true );
	return array(
		'svg'            => $shape( array( 'xmlns', 'viewbox', 'width', 'height', 'preserveaspectratio' ) ),
		'g'              => $common,
		'path'           => $shape( array( 'd', 'pathlength' ) ),
		'circle'         => $shape( array( 'cx', 'cy', 'r' ) ),
		'ellipse'        => $shape( array( 'cx', 'cy', 'rx', 'ry' ) ),
		'rect'           => $shape( array( 'x', 'y', 'width', 'height', 'rx', 'ry' ) ),
		'line'           => $shape( array( 'x1', 'y1', 'x2', 'y2' ) ),
		'polyline'       => $shape( array( 'points' ) ),
		'polygon'        => $shape( array( 'points' ) ),
		'defs'           => array(),
		'lineargradient' => array_fill_keys( array( 'id', 'x1', 'y1', 'x2', 'y2', 'gradientunits', 'gradienttransform' ), true ),
		'radialgradient' => array_fill_keys( array( 'id', 'cx', 'cy', 'r', 'fx', 'fy', 'gradientunits', 'gradienttransform' ), true ),
		'stop'           => array_fill_keys( array( 'offset', 'stop-color', 'stop-opacity', 'style' ), true ),
		'clippath'       => array_fill_keys( array( 'id', 'clippathunits' ), true ),
		'mask'           => array_fill_keys( array( 'id', 'x', 'y', 'width', 'height', 'maskunits' ), true ),
		'use'            => array_fill_keys( array( 'href', 'x', 'y', 'width', 'height' ), true ),
		'title'          => array(),
	);
}

/** A colour safe to put in an SVG attribute ('' when it is not a colour). */
function bwe_gw_icon_color( $color ) {
	$color = trim( (string) $color );
	return preg_match( '/^(#[0-9a-fA-F]{3,8}|rgba?\([0-9.,\s%]+\)|hsla?\([0-9.,\s%deg]+\)|[a-zA-Z]{3,20})$/', $color ) ? $color : '';
}

/**
 * The CSS url() value for an icon ('' when there is none to draw).
 *
 * @param array  $icon          The bweIcon attribute.
 * @param string $default_color Line colour of library icons when none is picked.
 */
function bwe_gw_icon_url( array $icon, $default_color = '#c8ff3d' ) {
	$source = (string) ( $icon['source'] ?? '' );
	if ( 'upload' === $source ) {
		$url = esc_url_raw( (string) ( $icon['url'] ?? '' ) );
		return '' === $url ? '' : 'url("' . str_replace( array( '"', '\\', "\n", "\r", '<', '>' ), array( '%22', '%5C', '', '', '%3C', '%3E' ), $url ) . '")';
	}
	$color = bwe_gw_icon_color( $icon['color'] ?? '' );
	if ( 'library' === $source ) {
		$inner = wp_kses( (string) ( $icon['svg'] ?? '' ), bwe_gw_icon_kses() );
		if ( '' === trim( $inner ) ) {
			return '';
		}
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="' . ( '' !== $color ? $color : $default_color ) . '" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">' . $inner . '</svg>';
	} elseif ( 'svg' === $source ) {
		$svg = wp_kses( (string) ( $icon['svg'] ?? '' ), bwe_gw_icon_kses() );
		if ( ! preg_match( '/<svg\b/i', $svg ) ) {
			return '';
		}
		if ( ! preg_match( '/<svg\b[^>]*\bxmlns=/i', $svg ) ) {
			$svg = preg_replace( '/<svg\b/i', '<svg xmlns="http://www.w3.org/2000/svg"', $svg, 1 );
		}
		if ( '' !== $color ) {
			$svg = str_ireplace( 'currentColor', $color, $svg );
		}
	} else {
		return '';
	}
	return 'url("data:image/svg+xml,' . rawurlencode( $svg ) . '")';
}

/**
 * Scope class + <style> for a block's custom icon ('' / '' when the block uses the site's icon).
 *
 * @param array  $attributes Block attributes (reads bweIcon).
 * @param string $part          Selector of the drawn icon inside the block, e.g. ' .bwex-eyebrow p::before'.
 * @param string $default_color Line colour of library icons when none is picked.
 * @return array{0: string, 1: string}
 */
function bwe_gw_icon_for_block( array $attributes, $part, $default_color = '#c8ff3d' ) {
	$icon = is_array( $attributes['bweIcon'] ?? null ) ? $attributes['bweIcon'] : array();
	if ( empty( $icon['source'] ) ) {
		return array( '', '' );
	}
	$decls = array();
	if ( 'none' === $icon['source'] ) {
		$decls[] = 'display:none!important';
	} else {
		$url = bwe_gw_icon_url( $icon, $default_color );
		if ( '' === $url ) {
			return array( '', '' );
		}
		$decls[] = 'background-image:' . $url . '!important';
		$size    = preg_match( '/^\d{1,3}(\.\d+)?(px|rem|em|%)$/', (string) ( $icon['size'] ?? '' ) ) ? $icon['size'] : '';
		if ( '' !== $size ) {
			$decls[] = 'background-size:' . $size . ' ' . $size . '!important';
		} elseif ( 'upload' === $icon['source'] ) {
			$decls[] = 'background-size:contain!important';
		}
		$decls[] = 'background-repeat:no-repeat!important';
		$decls[] = 'background-position:center!important';
	}
	$class = 'bwe-i-' . substr( md5( (string) wp_json_encode( $icon ) . $part ), 0, 10 );
	$css   = 'html body .' . $class . ':not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c)' . $part . '{' . implode( ';', $decls ) . '}';
	return array( $class, '<style>' . $css . '</style>' );
}
