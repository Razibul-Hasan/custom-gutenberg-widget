<?php
/**
 * Converter: FAQ item as core/details (+ summary spans + bwex-faq__a group) → bwe/faq-item.
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Returns the bwe/faq-item block for a known-shape FAQ item, false for a FAQ item in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_faq_item( array $block ) {
	$class = $block['attrs']['className'] ?? '';
	if ( 'core/details' !== $block['blockName'] || ! preg_match( '/(^|\s)bwex-faq__item(\s|$)/', $class ) ) {
		return null;
	}
	if ( array( 'className' ) !== array_keys( $block['attrs'] ) || ! in_array( $class, array( 'bwex-faq__item', 'bwex-faq__item bwex-faq__item--extra' ), true ) ) {
		return false;
	}
	$chunks = $block['innerContent'];
	$head   = (string) reset( $chunks );
	$tail   = (string) end( $chunks );
	$re     = '#^\s*<details class="wp-block-details ' . preg_quote( $class, '#' ) . '"><summary><span class="bwex-faq__n" aria-hidden="true">(\d+)</span><span class="bwex-faq__q">(.*?)</span><span class="bwex-faq__icon" aria-hidden="true"></span></summary>\s*$#s';
	if ( ! preg_match( $re, $head, $m ) || ! preg_match( '#^\s*</details>\s*$#', $tail ) || 1 !== count( $block['innerBlocks'] ) ) {
		return false;
	}
	$group = $block['innerBlocks'][0];
	if ( 'core/group' !== $group['blockName'] || array( 'className' => 'bwex-faq__a' ) !== $group['attrs'] || ! $group['innerBlocks'] ) {
		return false;
	}
	foreach ( $group['innerContent'] as $chunk ) {
		if ( is_string( $chunk ) && ! preg_match( '#^\s*(<div class="wp-block-group bwex-faq__a">)?\s*(</div>)?\s*$#', $chunk ) ) {
			return false; // Loose HTML inside the answer group would be lost.
		}
	}

	$attrs = array(
		'n'        => $m[1],
		'question' => $m[2],
	);
	if ( false !== strpos( $class, '--extra' ) ) {
		$attrs['extra'] = true;
	}
	return bwe_tb_block_with_children( 'bwe/faq-item', $attrs, $group['innerBlocks'] );
}
