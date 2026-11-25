<?php
/**
 * Converter: ordered core/list .bwex-who__list ("Who we build for" linked cards) → bwe/who-list + bwe/who-card.
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Returns bwe/who-list for a known-shape who list, false for one in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_who_list( array $block ) {
	if ( 'core/list' !== $block['blockName'] || ! preg_match( '/(^|\s)bwex-who__list(\s|$)/', $block['attrs']['className'] ?? '' ) ) {
		return null;
	}
	$expected = array(
		'ordered'   => true,
		'className' => 'bwex-who__list',
	);
	if ( $expected !== $block['attrs'] || ! $block['innerBlocks'] ) {
		return false;
	}
	foreach ( $block['innerContent'] as $chunk ) {
		if ( is_string( $chunk ) && ! preg_match( '#^\s*(<ol class="wp-block-list bwex-who__list">)?\s*(</ol>)?\s*$#', $chunk ) ) {
			return false;
		}
	}
	$cards = array();
	foreach ( $block['innerBlocks'] as $item ) {
		$re = '#^\s*<li><a href="([^"]*)"><strong>(.*?)</strong> <span>(.*?)</span> <em>(.*?)</em></a></li>\s*$#s';
		if ( 'core/list-item' !== $item['blockName'] || $item['attrs'] || $item['innerBlocks'] || ! preg_match( $re, $item['innerHTML'], $m ) ) {
			return false;
		}
		$cards[] = bwe_tb_leaf_block(
			'bwe/who-card',
			array(
				'url'   => html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' ),
				'title' => $m[2],
				'text'  => $m[3],
				'tag'   => $m[4],
			)
		);
	}
	return bwe_tb_block_with_children( 'bwe/who-list', array(), $cards );
}
