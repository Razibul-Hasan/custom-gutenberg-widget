<?php
/**
 * Rewrites one component in every synced pattern (wp_block) from its old core-block shape to the new block.
 * Usage: php convert.php <wp-root> <converter> [--dry-run] [--ids=1,2]
 *   converter = file name in converters/ (e.g. faq-item → function bwe_tb_convert_faq_item).
 * Every rewritten pattern is backed up to app/backups/blocks-migration-2026-11-22/<converter>/wp_block-<id>.html.
 *
 * @package BWE_Gutenberg_Widget
 */

require __DIR__ . '/lib.php';
$wp_root   = $argv[1] ?? '';
$converter = $argv[2] ?? '';
$dry       = in_array( '--dry-run', $argv, true );
$only      = array();
foreach ( $argv as $a ) {
	if ( 0 === strpos( $a, '--ids=' ) ) {
		$only = array_map( 'intval', explode( ',', substr( $a, 6 ) ) );
	}
}
if ( ! $wp_root || ! preg_match( '/^[a-z0-9-]+$/', $converter ) || ! is_file( __DIR__ . "/converters/$converter.php" ) ) {
	fwrite( STDERR, "usage: convert.php <wp-root> <converter> [--dry-run] [--ids=1,2]\n" );
	exit( 2 );
}
bwe_tb_boot( $wp_root );
require_once __DIR__ . "/converters/$converter.php";
$fn = 'bwe_tb_convert_' . str_replace( '-', '_', $converter );

$backup_dir = dirname( ABSPATH ) . "/backups/blocks-migration-2026-11-22/$converter";
global $wpdb;
$rows   = $wpdb->get_results( "SELECT ID, post_title, post_content FROM {$wpdb->posts} WHERE post_type = 'wp_block' AND post_status = 'publish' ORDER BY ID" );
$totals = array( 'patterns' => 0, 'converted' => 0, 'skipped' => 0 );
foreach ( $rows as $row ) {
	if ( $only && ! in_array( (int) $row->ID, $only, true ) ) {
		continue;
	}
	if ( ! bwe_tb_roundtrip_safe( $row->post_content ) ) {
		echo "{$row->ID} {$row->post_title}: SKIP not round-trip safe\n";
		continue;
	}
	$stats  = bwe_tb_convert_tree( parse_blocks( $row->post_content ), $fn );
	$blocks = $stats['blocks'];
	if ( ! $stats['converted'] && ! $stats['skipped'] ) {
		continue;
	}
	++$totals['patterns'];
	$totals['converted'] += $stats['converted'];
	$totals['skipped']   += count( $stats['skipped'] );
	echo "{$row->ID} {$row->post_title}: converted {$stats['converted']}, skipped " . count( $stats['skipped'] ) . "\n";
	foreach ( $stats['skipped'] as $s ) {
		echo "    skipped shape: $s\n";
	}
	if ( $dry || ! $stats['converted'] ) {
		continue;
	}
	if ( ! is_dir( $backup_dir ) ) {
		mkdir( $backup_dir, 0777, true );
	}
	file_put_contents( "$backup_dir/wp_block-{$row->ID}.html", $row->post_content );
	$wpdb->update( $wpdb->posts, array( 'post_content' => serialize_blocks( $blocks ) ), array( 'ID' => $row->ID ) );
	clean_post_cache( (int) $row->ID );
}
printf( "TOTAL: %d patterns, %d converted, %d skipped%s\n", $totals['patterns'], $totals['converted'], $totals['skipped'], $dry ? ' (dry run, nothing written)' : '' );
if ( ! $dry && function_exists( 'sg_cachepress_purge_everything' ) ) {
	sg_cachepress_purge_everything();
}

/**
 * Walks a block list depth-first; a converter's non-null result replaces the block (its children are not walked).
 * A converter may return false for "this is the component, but in a shape I don't know" — counted as skipped.
 *
 * @param array    $blocks Parsed blocks.
 * @param callable $fn     Converter.
 * @return array{blocks: array, converted: int, skipped: string[]}
 */
function bwe_tb_convert_tree( array $blocks, callable $fn ): array {
	$converted = 0;
	$skipped   = array();
	foreach ( $blocks as $i => $block ) {
		if ( empty( $block['blockName'] ) ) {
			continue;
		}
		$new = $fn( $block );
		if ( is_array( $new ) ) {
			$blocks[ $i ] = $new;
			++$converted;
			continue;
		}
		if ( false === $new ) {
			$skipped[] = $block['blockName'] . ' ' . ( $block['attrs']['className'] ?? '' ) . ' — ' . substr( bwe_tb_normalize( wp_strip_all_tags( render_block( $block ) ) ), 0, 80 );
			continue;
		}
		if ( $block['innerBlocks'] ) {
			$sub                         = bwe_tb_convert_tree( $block['innerBlocks'], $fn );
			$blocks[ $i ]['innerBlocks'] = $sub['blocks'];
			$converted                  += $sub['converted'];
			$skipped                     = array_merge( $skipped, $sub['skipped'] );
		}
	}
	return array( 'blocks' => $blocks, 'converted' => $converted, 'skipped' => $skipped );
}
