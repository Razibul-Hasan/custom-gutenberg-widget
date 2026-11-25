<?php
/**
 * Converter: numbered list built from groups (.bwex-num > .bwex-num__item …) → bwe/steps + bwe/step.
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Whether a group's own HTML is only its wrapper div.
 *
 * @param array  $group Parsed group.
 * @param string $class Its className.
 */
function bwe_tb_steps_wrapper_only( array $group, string $class ): bool {
	foreach ( $group['innerContent'] as $chunk ) {
		if ( is_string( $chunk ) && ! preg_match( '#^\s*(<div class="wp-block-group ' . preg_quote( $class, '#' ) . '">)?\s*(</div>)?\s*$#', $chunk ) ) {
			return false;
		}
	}
	return true;
}

/**
 * Returns bwe/steps for a known-shape numbered list, false for one in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_steps( array $block ) {
	$class = $block['attrs']['className'] ?? '';
	if ( 'core/group' !== $block['blockName'] || ! preg_match( '/^bwex-num(\s+bwex-num--[a-z-]+)*$/', $class ) ) {
		return null;
	}
	if ( array( 'className' ) !== array_keys( $block['attrs'] ) || ! $block['innerBlocks'] || ! bwe_tb_steps_wrapper_only( $block, $class ) ) {
		return false;
	}
	$steps = array();
	foreach ( $block['innerBlocks'] as $item ) {
		$item_class = $item['attrs']['className'] ?? '';
		if ( 'core/group' !== $item['blockName'] || array( 'className' ) !== array_keys( $item['attrs'] ) || ! in_array( $item_class, array( 'bwex-num__item', 'bwex-num__item bwex-reveal' ), true ) || ! bwe_tb_steps_wrapper_only( $item, $item_class ) || 2 !== count( $item['innerBlocks'] ) ) {
			return false;
		}
		[ $num, $body ] = $item['innerBlocks'];
		if ( 'core/paragraph' !== $num['blockName'] || array( 'className' => 'bwex-num__n' ) !== $num['attrs'] || ! preg_match( '#^\s*<p class="bwex-num__n">(\d+)</p>\s*$#', $num['innerHTML'], $n ) ) {
			return false;
		}
		if ( 'core/group' !== $body['blockName'] || array( 'className' => 'bwex-num__body' ) !== $body['attrs'] || ! bwe_tb_steps_wrapper_only( $body, 'bwex-num__body' ) || 2 !== count( $body['innerBlocks'] ) ) {
			return false;
		}
		[ $heading, $text_group ] = $body['innerBlocks'];
		$heading_attrs            = array(
			'level'     => 3,
			'className' => 'bwex-num__title bwe-h2x-plain',
		);
		if ( 'core/heading' !== $heading['blockName'] || $heading_attrs !== $heading['attrs'] || ! preg_match( '#^\s*<h3 class="wp-block-heading bwex-num__title bwe-h2x-plain">(.*)</h3>\s*$#s', $heading['innerHTML'], $title ) ) {
			return false;
		}
		if ( 'core/group' !== $text_group['blockName'] || array( 'className' => 'bwex-num__text' ) !== $text_group['attrs'] || ! bwe_tb_steps_wrapper_only( $text_group, 'bwex-num__text' ) || 1 !== count( $text_group['innerBlocks'] ) ) {
			return false;
		}
		$para = $text_group['innerBlocks'][0];
		if ( 'core/paragraph' !== $para['blockName'] || $para['attrs'] || ! preg_match( '#^\s*<p>(.*)</p>\s*$#s', $para['innerHTML'], $text ) ) {
			return false;
		}
		$attrs = array(
			'n'     => $n[1],
			'title' => $title[1],
			'text'  => $text[1],
		);
		if ( 'bwex-num__item' === $item_class ) {
			$attrs['reveal'] = false;
		}
		$steps[] = bwe_tb_leaf_block( 'bwe/step', $attrs );
	}
	$modifiers = trim( substr( $class, strlen( 'bwex-num' ) ) );
	return bwe_tb_block_with_children( 'bwe/steps', 'bwex-num--row bwex-num--dark' === $modifiers ? array() : array( 'modifiers' => $modifiers ), $steps );
}
