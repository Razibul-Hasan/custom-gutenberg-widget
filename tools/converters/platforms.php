<?php
/**
 * Converter: the core-block platform cards grid (group .bwex-plats > cards, each
 * group[…bwex-platform-card] > container > platw > plat > img? chip h3 text list? foot) → bwe/platforms + bwe/platform-card.
 * The service list stays a core List block (inside the card), so its links and per-page overrides are kept.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once __DIR__ . '/services.php'; // bwe_tb_svc_children(), bwe_tb_svc_p(), bwe_tb_hero_attrs_are().

/**
 * Returns bwe/platforms for a known-shape cards grid, false for one in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_platforms( array $block ) {
	$class = (string) ( $block['attrs']['className'] ?? '' );
	if ( 'core/group' !== $block['blockName'] || ! preg_match( '/(^|\s)bwex-plats(\s|$)/', $class ) ) {
		return null;
	}
	if ( ! bwe_tb_hero_attrs_are( $block, array( 'className' => $class ) ) || ! $block['innerBlocks'] ) {
		return false;
	}
	$cards = array();
	foreach ( $block['innerBlocks'] as $card ) {
		$new = bwe_tb_convert_platform_card( $card );
		if ( ! $new ) {
			return false;
		}
		$cards[] = $new;
	}
	$attrs = 'bwex-plats bwex-plats--3' === $class ? array() : array( 'classes' => $class );
	$attrs['metadata'] = array( 'name' => 'Platform cards' );
	return bwe_tb_block_with_children( 'bwe/platforms', $attrs, $cards );
}

/**
 * One card → bwe/platform-card, or null when its shape is not the known one.
 *
 * @param array $card Parsed card group.
 */
function bwe_tb_convert_platform_card( array $card ): ?array {
	$wrap = (string) ( $card['attrs']['className'] ?? '' );
	if ( 'core/group' !== $card['blockName'] || ! preg_match( '/(^|\s)elementor-widget-bwex-platform-card(\s|$)/', $wrap ) ) {
		return null;
	}
	$container = bwe_tb_svc_children( $card, $wrap, 1 );
	$platw     = $container ? bwe_tb_svc_children( $container[0], 'elementor-widget-container', 1 ) : null;
	$plat      = $platw ? bwe_tb_svc_children( $platw[0], 'bwex bwex-platw', 1 ) : null;
	$parts     = $plat && 'core/group' === $plat[0]['blockName'] && bwe_tb_hero_attrs_are( $plat[0], array( 'className' => 'bwex-plat' ) ) ? $plat[0]['innerBlocks'] : null;
	if ( ! $parts ) {
		return null;
	}
	$a    = array( 'wrapClasses' => $wrap );
	$list = array();
	$seen = array();
	foreach ( $parts as $part ) {
		$part_class = (string) ( $part['attrs']['className'] ?? '' );
		$kids       = bwe_tb_svc_children( $part, $part_class, count( $part['innerBlocks'] ) );
		if ( ! $kids || isset( $seen[ $part_class ] ) ) {
			return null;
		}
		$seen[ $part_class ] = true;
		switch ( $part_class ) {
			case 'bwex-plat__img':
				$img = $kids[0];
				if ( 1 !== count( $kids ) || 'core/image' !== $img['blockName'] ) {
					return null;
				}
				$id = (int) ( $img['attrs']['id'] ?? 0 );
				if ( ! bwe_tb_hero_attrs_are( $img, array_filter( array( 'id' => $id ? $id : null, 'sizeSlug' => 'large', 'linkDestination' => 'none', 'className' => 'bwe-raw-img' ) ) )
					|| ! preg_match( '#^\s*<figure class="wp-block-image size-large bwe-raw-img"><img src="([^"]*)" alt="([^"]*)"' . ( $id ? ' class="wp-image-' . $id . '"' : '' ) . '/></figure>\s*$#', $img['innerHTML'], $m ) ) {
					return null;
				}
				$a['imageId']  = $id;
				$a['imageUrl'] = html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' );
				$a['imageAlt'] = html_entity_decode( $m[2], ENT_QUOTES, 'UTF-8' );
				break;
			case 'bwex-plat__chipwrap':
				$chip = 1 === count( $kids ) ? bwe_tb_svc_p( $kids[0], 'bwex-plat__chip' ) : null;
				if ( null === $chip ) {
					return null;
				}
				$a['chip'] = $chip;
				break;
			case 'bwex-h3':
				$h = $kids[0];
				if ( 1 !== count( $kids ) || 'core/heading' !== $h['blockName'] || ! bwe_tb_hero_attrs_are( $h, array( 'level' => 3, 'className' => 'elementor-heading-title bwe-h2x-plain' ) )
					|| ! preg_match( '#^\s*<h3 class="wp-block-heading elementor-heading-title bwe-h2x-plain">(.*)</h3>\s*$#s', $h['innerHTML'], $m ) ) {
					return null;
				}
				if ( preg_match( '#^<a href="([^"]*)">(.*)</a>$#s', $m[1], $link ) ) {
					$a['titleUrl'] = html_entity_decode( $link[1], ENT_QUOTES, 'UTF-8' );
					$a['title']    = $link[2];
				} elseif ( false === strpos( $m[1], '<a ' ) ) {
					$a['title'] = $m[1];
				} else {
					return null;
				}
				break;
			case 'bwex-plat__text':
				$text = 1 === count( $kids ) ? bwe_tb_svc_p( $kids[0] ) : null;
				if ( null === $text ) {
					return null;
				}
				$a['text'] = $text;
				break;
			case 'bwex-plat__list':
				if ( 1 !== count( $kids ) || 'core/list' !== $kids[0]['blockName'] || ( $kids[0]['attrs']['className'] ?? '' ) !== 'bwex-checks' ) {
					return null;
				}
				$list = $kids;
				break;
			case 'bwex-plat__foot':
				foreach ( $kids as $k ) {
					if ( 'core/paragraph' === $k['blockName'] && ! isset( $a['price'] ) ) {
						$price = bwe_tb_svc_p( $k, 'bwex-plat__price' );
						if ( null === $price ) {
							return null;
						}
						$a['price'] = $price;
					} elseif ( 'core/buttons' === $k['blockName'] && bwe_tb_hero_attrs_are( $k, array( 'className' => 'bwe-btns-raw' ) ) && 1 === count( $k['innerBlocks'] ) ) {
						$b = $k['innerBlocks'][0];
						if ( 'core/button' !== $b['blockName'] || ! bwe_tb_hero_attrs_are( $b, array( 'className' => 'bwex-btn' ) )
							|| ! preg_match( '#^\s*<div class="wp-block-button bwex-btn"><a class="wp-block-button__link wp-element-button" href="([^"]*)">(.*)</a></div>\s*$#s', $b['innerHTML'], $m ) ) {
							return null;
						}
						$a['btnUrl']  = html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' );
						$a['btnText'] = $m[2];
					} else {
						return null;
					}
				}
				break;
			default:
				return null;
		}
	}
	if ( ! isset( $a['title'] ) ) {
		return null;
	}
	if ( 'elementor-element elementor-widget elementor-widget-bwex-platform-card' === $wrap ) {
		unset( $a['wrapClasses'] );
	}
	// Per-page text overrides of the old paragraphs/heading/button are replaced by the card's own (same idea).
	$a['metadata'] = array(
		'name'     => 'Card: ' . wp_strip_all_tags( $a['chip'] ?? $a['title'] ),
		'bindings' => array( '__default' => array( 'source' => 'core/pattern-overrides' ) ),
	);
	return bwe_tb_block_with_children( 'bwe/platform-card', $a, $list );
}
