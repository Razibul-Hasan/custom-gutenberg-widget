<?php
/**
 * Converter: core/list .bwe-prx__list (Pricing price rows) → bwe/price-list + bwe/price-row.
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Returns bwe/price-list for a known-shape price list, false for one in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_price_list( array $block ) {
	if ( 'core/list' !== $block['blockName'] || ! preg_match( '/(^|\s)bwe-prx__list(\s|$)/', $block['attrs']['className'] ?? '' ) ) {
		return null;
	}
	if ( array( 'className' => 'bwe-prx__list' ) !== $block['attrs'] || ! $block['innerBlocks'] ) {
		return false;
	}
	foreach ( $block['innerContent'] as $chunk ) {
		if ( is_string( $chunk ) && ! preg_match( '#^\s*(<ul class="wp-block-list bwe-prx__list">)?\s*(</ul>)?\s*$#', $chunk ) ) {
			return false;
		}
	}
	$rows = array();
	foreach ( $block['innerBlocks'] as $item ) {
		$re = '#^\s*<li><span class="bwe-prx__svc">(.*?) <small>(.*?)</small></span> <strong class="bwe-prx__amt">(.*?) <em>(.*?)</em></strong></li>\s*$#s';
		if ( 'core/list-item' !== $item['blockName'] || $item['attrs'] || $item['innerBlocks'] || ! preg_match( $re, $item['innerHTML'], $m ) ) {
			return false;
		}
		$rows[] = bwe_tb_leaf_block(
			'bwe/price-row',
			array(
				'service' => $m[1],
				'note'    => $m[2],
				'amount'  => $m[3],
				'unit'    => $m[4],
			)
		);
	}
	return bwe_tb_block_with_children( 'bwe/price-list', array(), $rows );
}
