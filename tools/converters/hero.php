<?php
/**
 * Converter: the core-block hero section (group section .bwex-hero > copy[h1, lead, buttons] + scroll cue) → bwe/hero.
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Whether a block's attributes are exactly the expected ones (a pattern-overrides "metadata" entry is allowed).
 *
 * @param array $block    Parsed block.
 * @param array $expected Expected attributes.
 */
function bwe_tb_hero_attrs_are( array $block, array $expected ): bool {
	$attrs = $block['attrs'];
	unset( $attrs['metadata'] );
	return $attrs === $expected;
}

/**
 * Returns bwe/hero for a known-shape hero, false for a hero in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_hero( array $block ) {
	$class = (string) ( $block['attrs']['className'] ?? '' );
	if ( 'core/group' !== $block['blockName'] || 'section' !== ( $block['attrs']['tagName'] ?? '' ) || ! preg_match( '/(^|\s)bwex-hero(\s|$)/', $class ) ) {
		return null;
	}
	if ( ! bwe_tb_hero_attrs_are( $block, array( 'tagName' => 'section', 'className' => $class ) ) || count( $block['innerBlocks'] ) < 1 || count( $block['innerBlocks'] ) > 2 ) {
		return false;
	}
	$copy = $block['innerBlocks'][0];
	if ( 'core/group' !== $copy['blockName'] || ! bwe_tb_hero_attrs_are( $copy, array( 'className' => 'bwe-hero__copy' ) ) || count( $copy['innerBlocks'] ) < 3 || count( $copy['innerBlocks'] ) > 6 ) {
		return false;
	}
	$parts = $copy['innerBlocks'];
	// Optional lines after the buttons, in render order: facts (p.bwex-hero__meta), then jump links (p.bwex-jump).
	$facts = array();
	$jumps = array();
	$tail  = static fn( array $b, string $class ): ?string => 'core/paragraph' === $b['blockName'] && bwe_tb_hero_attrs_are( $b, array( 'className' => $class ) )
		&& preg_match( '#^\s*<p class="' . preg_quote( $class, '#' ) . '">(.*)</p>\s*$#s', $b['innerHTML'], $m ) ? $m[1] : null;
	$last  = end( $parts );
	if ( null !== ( $html = $tail( $last, 'bwex-jump' ) ) ) {
		if ( ! preg_match_all( '#<a href="([^"]*)"><span>(\d+)</span>([^<]*)</a>#', $html, $all, PREG_SET_ORDER ) || preg_replace( '#<a href="[^"]*"><span>\d+</span>[^<]*</a>#', '', $html ) !== '' ) {
			return false;
		}
		foreach ( $all as $n => $a ) {
			if ( (int) $a[2] !== $n + 1 ) {
				return false; // The widget numbers the links itself.
			}
			$jumps[] = array( 'label' => html_entity_decode( $a[3], ENT_QUOTES, 'UTF-8' ), 'url' => html_entity_decode( $a[1], ENT_QUOTES, 'UTF-8' ) );
		}
		array_pop( $parts );
		$last = end( $parts );
	}
	if ( null !== ( $html = $tail( $last, 'bwex-hero__meta' ) ) ) {
		if ( ! preg_match_all( '#<span>(.*?)</span>#s', $html, $all ) || preg_replace( '#<span>.*?</span>#s', '', $html ) !== '' ) {
			return false;
		}
		$facts = array_map( static fn( $t ) => array( 'text' => $t ), $all[1] );
		array_pop( $parts );
	}
	if ( ! in_array( count( $parts ), array( 3, 4 ), true ) ) {
		return false;
	}
	$kicker = null;
	if ( 4 === count( $parts ) ) {
		// Page heroes: a small kicker line above the heading (bwe/hero "kicker").
		$k = array_shift( $parts );
		if ( 'core/paragraph' !== $k['blockName'] || ! bwe_tb_hero_attrs_are( $k, array( 'className' => 'bwe-kicker' ) ) || ! preg_match( '#^\s*<p class="bwe-kicker">(.*)</p>\s*$#s', $k['innerHTML'], $km ) ) {
			return false;
		}
		$kicker = $km[1];
	}
	[ $h1, $lead, $buttons ] = $parts;
	if ( 'core/heading' !== $h1['blockName'] || ! bwe_tb_hero_attrs_are( $h1, array( 'level' => 1, 'className' => 'elementor-heading-title bwe-hero__title' ) )
		|| ! preg_match( '#^\s*<h1 class="wp-block-heading elementor-heading-title bwe-hero__title">(.*)</h1>\s*$#s', $h1['innerHTML'], $title ) ) {
		return false;
	}
	if ( 'core/paragraph' !== $lead['blockName'] || ! bwe_tb_hero_attrs_are( $lead, array( 'className' => 'bwe-lead' ) ) || ! preg_match( '#^\s*<p class="bwe-lead">(.*)</p>\s*$#s', $lead['innerHTML'], $lead_html ) ) {
		return false;
	}
	if ( 'core/buttons' !== $buttons['blockName'] || ! bwe_tb_hero_attrs_are( $buttons, array( 'className' => 'bwe-actions' ) ) || count( $buttons['innerBlocks'] ) < 1 || count( $buttons['innerBlocks'] ) > 2 ) {
		return false;
	}
	$btn_classes = array( 'bwe-btn bwe-btn--primary', 'bwe-btn bwex-hero__link bwex-hero__btn2' );
	$btns        = array();
	$newtab_attrs = array( 'linkTarget' => '_blank', 'rel' => 'noreferrer noopener' );
	foreach ( $buttons['innerBlocks'] as $i => $button ) {
		$newtab = isset( $button['attrs']['linkTarget'] );
		$expect = array( 'className' => $btn_classes[ $i ] ) + ( $newtab ? $newtab_attrs : array() );
		$target = $newtab ? ' target="_blank" rel="noreferrer noopener"' : '';
		if ( 'core/button' !== $button['blockName'] || ! bwe_tb_hero_attrs_are( $button, $expect )
			|| ! preg_match( '#^\s*<div class="wp-block-button ' . preg_quote( $btn_classes[ $i ], '#' ) . '"><a class="wp-block-button__link wp-element-button" href="([^"]*)"' . $target . '>(.*)</a></div>\s*$#s', $button['innerHTML'], $m ) ) {
			return false;
		}
		$btns[] = array( html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' ), $m[2], $newtab );
	}
	$attrs = array(
		'title'    => $title[1],
		'lead'     => $lead_html[1],
		'btn1Text' => $btns[0][1],
		'btn1Url'  => $btns[0][0],
	);
	if ( null !== $kicker ) {
		$attrs = array( 'kicker' => $kicker ) + $attrs;
	}
	if ( $facts ) {
		$attrs['facts'] = $facts;
	}
	if ( $jumps ) {
		$attrs['jumpLinks'] = $jumps;
	}
	if ( $btns[0][2] ) {
		$attrs['btn1NewTab'] = true;
	}
	if ( isset( $btns[1] ) ) {
		$attrs['btn2Text'] = $btns[1][1];
		$attrs['btn2Url']  = $btns[1][0];
		if ( $btns[1][2] ) {
			$attrs['btn2NewTab'] = true;
		}
	} else {
		$attrs['showBtn2'] = false;
	}
	if ( isset( $block['innerBlocks'][1] ) ) {
		$cue = $block['innerBlocks'][1];
		if ( 'core/paragraph' !== $cue['blockName'] || ! bwe_tb_hero_attrs_are( $cue, array( 'className' => 'bwex-scroll-wrap' ) )
			|| ! preg_match( '#^\s*<p class="bwex-scroll-wrap"><a href="([^"]*)">([^<]*)</a></p>\s*$#', $cue['innerHTML'], $m ) ) {
			return false;
		}
		if ( 'Scroll' !== $m[2] ) {
			$attrs['scrollText'] = $m[2];
		}
		if ( '#services' !== $m[1] ) {
			$attrs['scrollUrl'] = html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' );
		}
	} else {
		$attrs['showScroll'] = false;
	}
	$default_mods = 'bwe-section bwe-hero bwe-hero--no-visual bwe-hero--paper bwex-hero bwe-hero--night';
	if ( $class !== $default_mods ) {
		$attrs['modifiers'] = $class;
	}
	return bwe_tb_leaf_block( 'bwe/hero', $attrs );
}
