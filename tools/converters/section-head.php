<?php
/**
 * Converter: section head (group .bwex.bwex-headw > .bwex-head > __main(eyebrow, h2) [+ intro]) → bwe/section-head.
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * The only child of a wrapper-only group with exactly this className, or null.
 *
 * @param array  $group Parsed block.
 * @param string $class className.
 */
function bwe_tb_head_only_child( array $group, string $class ): ?array {
	if ( 'core/group' !== $group['blockName'] || array( 'className' => $class ) !== $group['attrs'] || 1 !== count( $group['innerBlocks'] ) || ! bwe_tb_head_wrapper_only( $group, $class ) ) {
		return null;
	}
	return $group['innerBlocks'][0];
}

/**
 * Whether a group's own HTML is only its wrapper div.
 *
 * @param array  $group Parsed group.
 * @param string $class Its className.
 */
function bwe_tb_head_wrapper_only( array $group, string $class ): bool {
	foreach ( $group['innerContent'] as $chunk ) {
		if ( is_string( $chunk ) && ! preg_match( '#^\s*(<div class="wp-block-group ' . preg_quote( $class, '#' ) . '">)?\s*(</div>)?\s*$#', $chunk ) ) {
			return false;
		}
	}
	return true;
}

/**
 * Inner HTML of a plain paragraph (no attributes), or null.
 *
 * @param array|null $block Parsed block.
 */
function bwe_tb_head_plain_p( ?array $block ): ?string {
	if ( ! $block || 'core/paragraph' !== $block['blockName'] || $block['attrs'] || ! preg_match( '#^\s*<p>(.*)</p>\s*$#s', $block['innerHTML'], $m ) ) {
		return null;
	}
	return $m[1];
}

/**
 * Returns bwe/section-head for a known-shape head, false for a head in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_section_head( array $block ) {
	if ( 'core/group' !== $block['blockName'] || ! preg_match( '/(^|\s)bwex-headw(\s|$)/', $block['attrs']['className'] ?? '' ) ) {
		return null;
	}
	$head = bwe_tb_head_only_child( $block, 'bwex bwex-headw' );
	if ( ! $head || 'core/group' !== $head['blockName'] ) {
		return false;
	}
	$head_class = $head['attrs']['className'] ?? '';
	if ( array( 'className' ) !== array_keys( $head['attrs'] ) || ! in_array( $head_class, array( 'bwex-head', 'bwex-head bwex-head--split' ), true ) || ! bwe_tb_head_wrapper_only( $head, $head_class ) ) {
		return false;
	}
	$parts = $head['innerBlocks'];
	if ( count( $parts ) < 1 || count( $parts ) > 2 ) {
		return false;
	}
	$main = $parts[0];
	if ( 'core/group' !== $main['blockName'] || array( 'className' => 'bwex-head__main' ) !== $main['attrs'] || 2 !== count( $main['innerBlocks'] ) || ! bwe_tb_head_wrapper_only( $main, 'bwex-head__main' ) ) {
		return false;
	}
	$eyebrow = bwe_tb_head_plain_p( bwe_tb_head_only_child( $main['innerBlocks'][0], 'bwex-eyebrow' ) );
	$heading = bwe_tb_head_only_child( $main['innerBlocks'][1], 'bwex-h2' );
	if ( null === $eyebrow || ! $heading || 'core/heading' !== $heading['blockName'] ) {
		return false;
	}
	$h_attrs = $heading['attrs'];
	$id      = $h_attrs['anchor'] ?? '';
	unset( $h_attrs['anchor'] );
	$h_re = '#^\s*<h2' . ( '' !== $id ? ' id="' . preg_quote( $id, '#' ) . '"' : '' ) . ' class="wp-block-heading elementor-heading-title bwe-h2x-plain">(.*)</h2>\s*$#s';
	if ( array( 'className' => 'elementor-heading-title bwe-h2x-plain' ) !== $h_attrs || ! preg_match( $h_re, $heading['innerHTML'], $title ) ) {
		return false;
	}
	$intro = '';
	if ( isset( $parts[1] ) ) {
		$intro = bwe_tb_head_plain_p( bwe_tb_head_only_child( $parts[1], 'bwex-intro' ) );
		if ( null === $intro || '' === $intro ) {
			return false;
		}
	}
	$attrs = array(
		'eyebrow' => $eyebrow,
		'title'   => $title[1],
	);
	if ( '' !== $id ) {
		$attrs['headingId'] = $id;
	}
	if ( '' !== $intro ) {
		$attrs['intro'] = $intro;
	}
	if ( 'bwex-head' === $head_class ) {
		$attrs['split'] = false;
	}
	return bwe_tb_leaf_block( 'bwe/section-head', $attrs );
}
