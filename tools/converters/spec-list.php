<?php
/**
 * Converter: spec list (group .bwex-spec__list > group .bwex-spec__item > paragraphs) → bwe/spec-list + bwe/spec-card.
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Inner HTML of a paragraph block with exactly the given className, or null.
 *
 * @param array  $block Parsed block.
 * @param string $class Expected className.
 */
function bwe_tb_spec_paragraph( array $block, string $class ): ?string {
	if ( 'core/paragraph' !== $block['blockName'] || array( 'className' => $class ) !== $block['attrs'] ) {
		return null;
	}
	return preg_match( '#^\s*<p class="' . preg_quote( $class, '#' ) . '">(.*)</p>\s*$#s', $block['innerHTML'], $m ) ? $m[1] : null;
}

/**
 * Whether a group's own HTML (between its children) is only its wrapper div.
 *
 * @param array  $group Parsed group.
 * @param string $class Its className.
 */
function bwe_tb_spec_wrapper_only( array $group, string $class ): bool {
	foreach ( $group['innerContent'] as $chunk ) {
		if ( is_string( $chunk ) && ! preg_match( '#^\s*(<div class="wp-block-group ' . preg_quote( $class, '#' ) . '">)?\s*(</div>)?\s*$#', $chunk ) ) {
			return false;
		}
	}
	return true;
}

/**
 * Returns bwe/spec-list for a known-shape spec list, false for a spec list in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_spec_list( array $block ) {
	if ( 'core/group' !== $block['blockName'] || ! preg_match( '/(^|\s)bwex-spec__list(\s|$)/', $block['attrs']['className'] ?? '' ) ) {
		return null;
	}
	if ( array( 'className' => 'bwex-spec__list' ) !== $block['attrs'] || ! $block['innerBlocks'] || ! bwe_tb_spec_wrapper_only( $block, 'bwex-spec__list' ) ) {
		return false;
	}
	$cards = array();
	foreach ( $block['innerBlocks'] as $item ) {
		if ( 'core/group' !== $item['blockName'] || array( 'className' => 'bwex-spec__item' ) !== $item['attrs'] || ! bwe_tb_spec_wrapper_only( $item, 'bwex-spec__item' ) ) {
			return false;
		}
		$parts = $item['innerBlocks'];
		if ( count( $parts ) < 2 || count( $parts ) > 3 ) {
			return false;
		}
		$name = bwe_tb_spec_paragraph( $parts[0], 'bwex-spec__name' );
		$text = bwe_tb_spec_paragraph( $parts[1], 'bwex-spec__text' );
		$chip = isset( $parts[2] ) ? bwe_tb_spec_paragraph( $parts[2], 'bwex-spec__chip' ) : '';
		if ( null === $name || null === $text || null === $chip ) {
			return false;
		}
		$attrs = array(
			'name' => $name,
			'text' => $text,
		);
		if ( '' !== $chip ) {
			$attrs['chip'] = $chip;
		}
		$cards[] = bwe_tb_leaf_block( 'bwe/spec-card', $attrs );
	}
	return bwe_tb_block_with_children( 'bwe/spec-list', array(), $cards );
}
