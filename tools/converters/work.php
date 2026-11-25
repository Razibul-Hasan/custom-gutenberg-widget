<?php
/**
 * Converter: the Portfolio page's "Selected Work" section (pattern "Portfolio – Selected Work") from core groups +
 * bwe/section-head + core Image / Paragraph / Heading blocks to bwe/work + bwe/work-item.
 * Usage: php convert.php <wp-root> work [--dry-run] [--ids=1861]
 *
 * @package BWE_Gutenberg_Widget
 */

require_once __DIR__ . '/home-sections.php';

/**
 * Returns the new section, false for this section in an unknown shape, null for any other block.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_work( array $block ) {
	if ( 'core/group' !== ( $block['blockName'] ?? '' ) || ! bwe_tb_hs_has( $block, 'elementor-widget-bwex-work' ) ) {
		return null;
	}
	$section = bwe_tb_hs_get( $block, 'core/group', 'bwex-section bwex-work' );
	$head    = bwe_tb_hs_get( $block, 'bwe/section-head' );
	if ( ! $section || ! $head ) {
		return false;
	}
	$items = array();
	foreach ( bwe_tb_hs_all( $block, static fn( $b ) => 'core/group' === $b['blockName'] && bwe_tb_hs_has( $b, 'bwex-work__item' ) ) as $item ) {
		$new = bwe_tb_convert_work_item( $item );
		if ( ! $new ) {
			return false;
		}
		$items[] = $new;
	}
	if ( ! $items ) {
		return false;
	}
	$h     = $head['attrs'];
	$attrs = bwe_tb_hs_attrs(
		'work',
		array(
			'eyebrow'     => (string) ( $h['eyebrow'] ?? '' ),
			'title'       => (string) ( $h['title'] ?? '' ),
			'intro'       => (string) ( $h['intro'] ?? '' ),
			'split'       => $h['split'] ?? true,
			'headingId'   => (string) ( $h['headingId'] ?? '' ),
			'sectionId'   => (string) ( $section['attrs']['anchor'] ?? '' ),
			'wrapClasses' => (string) ( $block['attrs']['className'] ?? '' ),
			'metadata'    => bwe_tb_hs_meta( 'Selected work' ),
		)
	);
	return bwe_tb_block_with_children( 'bwe/work', $attrs, $items );
}

/**
 * One .bwex-work__item group → bwe/work-item (null for an unknown shape: e.g. the screenshot and the title link
 * to different pages, which the block cannot keep).
 *
 * @param array $item Parsed item group.
 */
function bwe_tb_convert_work_item( array $item ): ?array {
	$image   = bwe_tb_hs_get( $item, 'core/image' );
	$heading = bwe_tb_hs_inner( bwe_tb_hs_get( $item, 'core/heading' ) );
	if ( ! preg_match( '#^<a href="([^"]*)">(.*)</a>$#s', $heading, $t ) ) {
		return null;
	}
	$url    = html_entity_decode( $t[1], ENT_QUOTES, 'UTF-8' );
	$values = array(
		'num'      => bwe_tb_hs_inner( bwe_tb_hs_get( $item, 'core/paragraph', 'bwex-work__num' ) ),
		'url'      => $url,
		'title'    => $t[2],
		'tag'      => bwe_tb_hs_inner( bwe_tb_hs_get( $item, 'core/paragraph', 'bwex-work__tag' ) ),
		'text'     => bwe_tb_hs_inner( bwe_tb_hs_get( $item, 'core/paragraph', 'bwex-work__text' ) ),
		'metadata' => bwe_tb_hs_meta( 'Project: ' . bwe_tb_hs_label( $t[2] ) ),
	);
	if ( $image ) {
		if ( ! preg_match( '#<a href="([^"]*)"><img src="([^"]*)" alt="([^"]*)"#', $image['innerHTML'], $m ) || html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' ) !== $url ) {
			return null;
		}
		$values += array(
			'imageId'  => (int) ( $image['attrs']['id'] ?? 0 ),
			'imageUrl' => html_entity_decode( $m[2], ENT_QUOTES, 'UTF-8' ),
			'imageAlt' => html_entity_decode( $m[3], ENT_QUOTES, 'UTF-8' ),
		);
	}
	return bwe_tb_leaf_block( 'bwe/work-item', bwe_tb_hs_attrs( 'work-item', $values ) );
}
