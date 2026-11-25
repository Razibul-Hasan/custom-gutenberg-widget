<?php
/**
 * Converter (2026-11-24 full rebuild): <section> groups on pages without Home's wrapper (.bwe-h2x — the Blog) →
 * bwe/section. There WordPress prints its flow-layout classes on the group, so they go into the Section's classes
 * to keep the live HTML (and the spacing rules that hang on them) the same.
 * Used by rebuild-page.php, which sets $GLOBALS['bwe_tb_rebuild_h2x'] for the page being rebuilt.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once __DIR__ . '/section.php';

/**
 * Returns the new block, false for a known section in an unknown shape, null for any other block.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_page_sections( array $block ) {
	if ( ! empty( $GLOBALS['bwe_tb_rebuild_h2x'] ) || 'core/group' !== ( $block['blockName'] ?? '' ) || ! empty( $block['attrs']['layout'] ) ) {
		return null;
	}
	$new = bwe_tb_convert_section( $block );
	if ( ! is_array( $new ) ) {
		return $new;
	}
	$new['attrs']['classes'] .= ' is-layout-flow wp-block-group-is-layout-flow';
	return $new;
}
