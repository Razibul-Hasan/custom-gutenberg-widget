<?php
/**
 * Converter: the core-block services band (section .bwex-svc-band > wrap > svc > head + body[list, more]) →
 * bwe/services + bwe/service-tile.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once __DIR__ . '/hero.php'; // bwe_tb_hero_attrs_are().

/**
 * The only child of a group with exactly this className (pattern-overrides metadata allowed), or null.
 *
 * @param array  $group Parsed block.
 * @param string $class className.
 * @param int    $count Expected number of children.
 */
function bwe_tb_svc_children( array $group, string $class, int $count ): ?array {
	if ( 'core/group' !== $group['blockName'] || ! bwe_tb_hero_attrs_are( $group, array( 'className' => $class ) ) || count( $group['innerBlocks'] ) !== $count ) {
		return null;
	}
	return $group['innerBlocks'];
}

/**
 * Inner HTML of a paragraph with the given class ('' = no class), or null.
 *
 * @param array|null $p     Parsed paragraph.
 * @param string     $class className.
 */
function bwe_tb_svc_p( ?array $p, string $class = '' ): ?string {
	if ( ! $p || 'core/paragraph' !== $p['blockName'] || ! bwe_tb_hero_attrs_are( $p, '' === $class ? array() : array( 'className' => $class ) ) ) {
		return null;
	}
	$open = '' === $class ? '<p>' : '<p class="' . $class . '">';
	return preg_match( '#^\s*' . preg_quote( $open, '#' ) . '(.*)</p>\s*$#s', $p['innerHTML'], $m ) ? $m[1] : null;
}

/**
 * Returns bwe/services for a known-shape services band, false for one in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_services( array $block ) {
	$class = (string) ( $block['attrs']['className'] ?? '' );
	if ( 'core/group' !== $block['blockName'] || ! preg_match( '/(^|\s)bwex-svc-band(\s|$)/', $class ) ) {
		return null;
	}
	$attrs = $block['attrs'];
	unset( $attrs['metadata'] );
	$anchor = $attrs['anchor'] ?? '';
	unset( $attrs['anchor'] );
	if ( array( 'tagName' => 'section', 'className' => $class ) !== $attrs || 1 !== count( $block['innerBlocks'] ) ) {
		return false;
	}
	$wrap = bwe_tb_svc_children( $block['innerBlocks'][0], 'bwex-wrap', 1 );
	$svc  = $wrap ? ( bwe_tb_svc_children( $wrap[0], 'bwex-svc', 3 ) ?? bwe_tb_svc_children( $wrap[0], 'bwex-svc', 2 ) ) : null;
	if ( ! $svc ) {
		return false;
	}
	$head = bwe_tb_svc_children( $svc[0], 'bwex-svc__head', 2 ) ?? bwe_tb_svc_children( $svc[0], 'bwex-svc__head', 1 );
	$body = bwe_tb_svc_children( $svc[1], 'bwex-svc__body', 1 );
	if ( ! $head || ! $body ) {
		return false;
	}
	$title_group = bwe_tb_svc_children( $head[0], 'bwex-h2 bwex-svc__title', 2 );
	if ( ! $title_group ) {
		return false;
	}
	$eyebrow_kids = bwe_tb_svc_children( $title_group[0], 'bwex-eyebrow', 1 );
	$eyebrow      = $eyebrow_kids ? bwe_tb_svc_p( $eyebrow_kids[0] ) : null;
	$h2           = $title_group[1];
	if ( null === $eyebrow || 'core/heading' !== $h2['blockName'] || ! bwe_tb_hero_attrs_are( $h2, array( 'className' => 'elementor-heading-title bwe-h2x-plain' ) )
		|| ! preg_match( '#^\s*<h2 class="wp-block-heading elementor-heading-title bwe-h2x-plain">(.*)</h2>\s*$#s', $h2['innerHTML'], $title ) ) {
		return false;
	}
	$lead = '';
	if ( isset( $head[1] ) ) {
		$lead_kids = bwe_tb_svc_children( $head[1], 'bwex-svc__lead', 1 );
		$lead      = $lead_kids ? bwe_tb_svc_p( $lead_kids[0] ) : null;
		if ( null === $lead ) {
			return false;
		}
	}
	$list = $body[0];
	if ( 'core/list' !== $list['blockName'] || ! bwe_tb_hero_attrs_are( $list, array( 'className' => 'bwex-svc__grid' ) ) || ! $list['innerBlocks'] ) {
		return false;
	}
	$tiles = array();
	foreach ( $list['innerBlocks'] as $item ) {
		$re = '#^\s*<li class="bwex-svc__item bwex-svc__item--([a-z0-9-]+)"><a class="bwex-svc__tile bwex-svc__tile--([a-z0-9-]+)" href="([^"]*)"><span class="bwex-svc__top"><span class="bwex-svc__tag">(.*?)</span></span><strong class="bwex-svc__name">(.*?)</strong><span class="bwex-svc__desc">(.*?)</span><span class="bwex-svc__arrow" aria-hidden="true">→</span></a></li>\s*$#s';
		if ( 'core/list-item' !== $item['blockName'] || $item['innerBlocks'] || ! preg_match( $re, $item['innerHTML'], $m ) || ! bwe_tb_hero_attrs_are( $item, array( 'className' => 'bwex-svc__item bwex-svc__item--' . $m[1] ) ) ) {
			return false;
		}
		$tiles[] = bwe_tb_leaf_block(
			'bwe/service-tile',
			array(
				'icon'     => $m[1],
				'platform' => $m[2],
				'url'      => html_entity_decode( $m[3], ENT_QUOTES, 'UTF-8' ),
				'tag'      => $m[4],
				'name'     => $m[5],
				'desc'     => $m[6],
			)
		);
	}
	$more = '';
	if ( isset( $svc[2] ) ) { // The line under the tiles sits after the tile area, inside .bwex-svc.
		$more = bwe_tb_svc_p( $svc[2], 'bwex-more' );
		if ( null === $more ) {
			return false;
		}
	}
	$new = array(
		'eyebrow' => $eyebrow,
		'title'   => $title[1],
		'lead'    => $lead,
		'more'    => $more,
	);
	if ( 'services' !== $anchor ) {
		$new['sectionId'] = $anchor;
	}
	if ( 'bwex-section bwex-section--dark bwex-svc-band' !== $class ) {
		$new['modifiers'] = $class;
	}
	return bwe_tb_block_with_children( 'bwe/services', $new, $tiles );
}
