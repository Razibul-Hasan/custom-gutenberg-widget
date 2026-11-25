<?php
/**
 * Rebuilds a page with the BWE widgets: every synced pattern (core/block) is inlined into the page, then every
 * converter in converters/ runs over the result until nothing more converts. Shapes a converter does not know stay
 * as they are, so the live HTML is unchanged (check with snapshot-front.php + compare-front.php).
 * Usage: php rebuild-page.php <wp-root> <post-id>[,<post-id>…] [--dry-run] [--no-inline]
 * Each page is backed up to app/backups/full-widget-rebuild-2026-11-24/post-<id>.html and gets a revision.
 *
 * @package BWE_Gutenberg_Widget
 */

require __DIR__ . '/lib.php';
$wp_root = $argv[1] ?? '';
$ids     = array_filter( array_map( 'intval', explode( ',', $argv[2] ?? '' ) ) );
$dry     = in_array( '--dry-run', $argv, true );
$inline  = ! in_array( '--no-inline', $argv, true );
if ( ! $wp_root || ! $ids ) {
	fwrite( STDERR, "usage: rebuild-page.php <wp-root> <post-id>[,<post-id>…] [--dry-run] [--no-inline]\n" );
	exit( 2 );
}
bwe_tb_boot( $wp_root );

// Section converters last: the component converters inside them must see the old core shapes first.
const BWE_TB_REBUILD_ALL = array( 'section-head', 'faq-item', 'spec-list', 'steps', 'who-list', 'price-list', 'platforms', 'services', 'work', 'hero', 'price-section', 'contact', 'section', 'home-sections', 'page-sections', 'parts', 'product-mockup' );
$order = BWE_TB_REBUILD_ALL;
foreach ( $argv as $a ) {
	if ( 0 === strpos( $a, '--converters=' ) ) {
		$pick  = explode( ',', substr( $a, 13 ) );
		$order = array_values( array_filter( BWE_TB_REBUILD_ALL, static fn( $c ) => in_array( $c, $pick, true ) ) );
	}
}
foreach ( $order as $c ) {
	require_once __DIR__ . "/converters/$c.php";
}
$restore = in_array( '--restore', $argv, true );

/**
 * Drops pattern-overrides bindings from a block's metadata (they only mean something inside a synced pattern).
 *
 * @param array $block Parsed block.
 */
function bwe_tb_rebuild_unbind( array $block ): array {
	if ( isset( $block['attrs']['metadata']['bindings'] ) ) {
		foreach ( $block['attrs']['metadata']['bindings'] as $key => $binding ) {
			if ( 'core/pattern-overrides' === ( $binding['source'] ?? '' ) ) {
				unset( $block['attrs']['metadata']['bindings'][ $key ] );
			}
		}
		if ( ! $block['attrs']['metadata']['bindings'] ) {
			unset( $block['attrs']['metadata']['bindings'] );
		}
		if ( ! $block['attrs']['metadata'] ) {
			unset( $block['attrs']['metadata'] );
		}
	}
	foreach ( $block['innerBlocks'] as $i => $child ) {
		$block['innerBlocks'][ $i ] = bwe_tb_rebuild_unbind( $child );
	}
	return $block;
}

/**
 * Replaces synced-pattern references with the pattern's blocks (recursively).
 *
 * @param array $blocks Parsed blocks.
 * @param array $seen   Pattern ids on the current path (loop guard).
 */
function bwe_tb_rebuild_inline( array $blocks, array $seen = array() ): array {
	$out = array();
	foreach ( $blocks as $block ) {
		if ( 'core/block' === ( $block['blockName'] ?? '' ) ) {
			$ref = (int) ( $block['attrs']['ref'] ?? 0 );
			if ( ! empty( $block['attrs']['content'] ) ) {
				throw new RuntimeException( "pattern $ref has per-page overrides; inline it by hand" );
			}
			$pattern = get_post( $ref );
			if ( ! $pattern || 'wp_block' !== $pattern->post_type || in_array( $ref, $seen, true ) ) {
				throw new RuntimeException( "pattern $ref missing or recursive" );
			}
			foreach ( bwe_tb_rebuild_inline( parse_blocks( $pattern->post_content ), array_merge( $seen, array( $ref ) ) ) as $child ) {
				if ( ! empty( $child['blockName'] ) ) {
					$out[] = bwe_tb_rebuild_unbind( $child );
				}
			}
			continue;
		}
		if ( ! empty( $block['innerBlocks'] ) ) {
			$block['innerBlocks'] = bwe_tb_rebuild_inline( $block['innerBlocks'], $seen );
		}
		$out[] = $block;
	}
	return $out;
}

/**
 * Reference to the child list at an index path inside the page tree.
 *
 * @param array $root Top-level parsed blocks.
 * @param array $path Index path ([] = top level).
 */
function &bwe_tb_rebuild_list( array &$root, array $path ): array {
	$list = &$root;
	foreach ( $path as $i ) {
		$list = &$list[ $i ]['innerBlocks'];
	}
	return $list;
}

/**
 * One converter pass over the whole page tree. Each conversion is kept only when the WHOLE page still renders
 * exactly as it did before the rebuild (some blocks print differently depending on their parents), so the live
 * HTML cannot change. Replaced blocks are not descended into (the next round does that).
 *
 * @param array    $root     Top-level parsed blocks of the page (changed in place).
 * @param array    $path     Index path of the parent whose children are walked ([] = top level).
 * @param callable $fn       Converter.
 * @param array    $tally    Counts per converter.
 * @param string   $name     Converter name.
 * @param string   $baseline Normalized render of the page before the rebuild.
 */
function bwe_tb_rebuild_pass( array &$root, array $path, callable $fn, array &$tally, string $name, string $baseline ): void {
	$list = &bwe_tb_rebuild_list( $root, $path );
	foreach ( array_keys( $list ) as $i ) {
		$block = $list[ $i ];
		if ( empty( $block['blockName'] ) ) {
			continue;
		}
		$new = $fn( $block );
		if ( is_array( $new ) ) {
			$list[ $i ] = $new;
			$html       = bwe_tb_rebuild_render( $root );
			if ( $html === $baseline ) {
				$tally[ $name ] = ( $tally[ $name ] ?? 0 ) + 1;
				continue;
			}
			$list[ $i ] = $block;
			$tally[ "$name REJECTED" ] = ( $tally[ "$name REJECTED" ] ?? 0 ) + 1;
			if ( in_array( '--why', $GLOBALS['argv'], true ) ) {
				$n = min( strlen( $baseline ), strlen( $html ) );
				$k = 0;
				while ( $k < $n && $baseline[ $k ] === $html[ $k ] ) {
					++$k;
				}
				echo "    REJECT $name @$k\n      old: " . substr( $baseline, max( 0, $k - 90 ), 220 ) . "\n      new: " . substr( $html, max( 0, $k - 90 ), 220 ) . "\n";
			}
		}
		if ( $block['innerBlocks'] ) {
			bwe_tb_rebuild_pass( $root, array_merge( $path, array( $i ) ), $fn, $tally, $name, $baseline );
		}
	}
}

/**
 * Renders a page's blocks the way its front end would (bwe-h2x pages drop the group layout classes).
 *
 * @param array $blocks Parsed blocks.
 */
function bwe_tb_rebuild_render( array $blocks ): string {
	$markup = serialize_blocks( $blocks );
	$html   = ! empty( $GLOBALS['bwe_tb_rebuild_h2x'] ) ? bwe_tb_render_raw( $markup ) : do_blocks( $markup );
	// ProductBoxes' box builder numbers its instances per request (mmbb-1, mmbb-2 …); each render here counts on.
	$html = preg_replace( '/\bmmbb-(box-)?\d+\b/', 'mmbb-$1N', $html );
	// bwe-scope--* are editor-only markers that synced patterns carried for their page wrapper (no CSS or front-end
	// script uses them; home-2.php reads them in the editor). Inlined into the page, the wrapper itself is there.
	$html = preg_replace( '/ bwe-scope--[a-z0-9-]+/', '', $html );
	return bwe_tb_normalize( $html );
}

/**
 * Rebuilds the page's block list as a string with the same separators the editor writes.
 *
 * @param array $blocks Top-level parsed blocks (no freeform gaps).
 */
function bwe_tb_rebuild_serialize( array $blocks ): string {
	return implode( "\n\n", array_map( 'serialize_block', array_values( array_filter( $blocks, static fn( $b ) => ! empty( $b['blockName'] ) ) ) ) );
}

// --current: start from the page as it is now (the 2026-11-25 "no classes" pass, which keeps the owner's later
// edits); its own backups (the page before that pass) are in backups/no-classes-2026-11-25, --restore uses them.
$current = in_array( '--current', $argv, true );
$dir     = dirname( ABSPATH ) . ( $current ? '/backups/no-classes-2026-11-25' : '/backups/full-widget-rebuild-2026-11-24' );
foreach ( $ids as $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post ) {
		echo "$post_id: no such post\n";
		continue;
	}
	// Always start from the content the page had before the first rebuild, so a run can be repeated or narrowed.
	$source = is_file( "$dir/post-$post_id.html" ) && ( ! $current || $restore ) ? file_get_contents( "$dir/post-$post_id.html" ) : $post->post_content;
	if ( $restore ) {
		if ( $source !== $post->post_content ) {
			kses_remove_filters();
			wp_update_post( wp_slash( array( 'ID' => $post_id, 'post_content' => $source ) ) );
			clean_post_cache( $post_id );
			echo "$post_id restored\n";
		}
		continue;
	}
	$blocks = parse_blocks( $source );
	if ( $inline ) {
		$blocks = bwe_tb_rebuild_inline( $blocks );
	}
	// Render in this page's context: global $post (the readers / filters look at it) and Home's layout-class strip.
	$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	setup_postdata( $post );
	$GLOBALS['bwe_tb_rebuild_h2x'] = false !== strpos( serialize_blocks( $blocks ), 'bwe-h2x' );
	$tally    = array();
	$baseline = bwe_tb_rebuild_render( $blocks );
	for ( $round = 0; $round < 10; ++$round ) {
		$before = serialize_blocks( $blocks );
		foreach ( $order as $c ) {
			bwe_tb_rebuild_pass( $blocks, array(), 'bwe_tb_convert_' . str_replace( '-', '_', $c ), $tally, $c, $baseline );
		}
		if ( serialize_blocks( $blocks ) === $before ) {
			break;
		}
	}
	if ( $current ) {
		$blocks = array_map( static fn( $b ) => empty( $b['blockName'] ) ? $b : bwe_tb_rebuild_unbind( $b ), $blocks ); // no pattern here: plain List View names
	}
	$content = bwe_tb_rebuild_serialize( $blocks );
	echo "$post_id {$post->post_title}: " . ( $tally ? json_encode( $tally ) : 'nothing converted' ) . ( $dry ? ' (dry run)' : '' ) . "\n";
	if ( in_array( '--leftover', $argv, true ) ) {
		// Core groups that are still a page section (a <section>, or a widget wrapper) after conversion.
		$walk = static function ( array $list, int $depth ) use ( &$walk ): void {
			foreach ( $list as $b ) {
				if ( empty( $b['blockName'] ) ) {
					continue;
				}
				$cls = (string) ( $b['attrs']['className'] ?? '' );
				if ( 'core/group' === $b['blockName'] && ( 'section' === ( $b['attrs']['tagName'] ?? '' ) || preg_match( '/elementor-widget-bwex-|bwex-section|bwe-section/', $cls ) ) ) {
					$text = substr( bwe_tb_normalize( wp_strip_all_tags( render_block( $b ) ) ), 0, 50 );
					echo '    ' . str_repeat( '  ', $depth ) . 'LEFT ' . preg_replace( '/elementor-element |e-con-full |e-flex |e-con |e-child/', '', $cls ) . " — $text\n";
					continue;
				}
				$walk( $b['innerBlocks'], $depth + ( 0 === strpos( $b['blockName'], 'bwe/' ) ? 1 : 0 ) );
			}
		};
		$walk( $blocks, 0 );
	}
	if ( $dry || $content === $post->post_content ) {
		continue;
	}
	if ( ! is_dir( $dir ) ) {
		mkdir( $dir, 0777, true );
	}
	if ( ! is_file( "$dir/post-$post_id.html" ) ) {
		file_put_contents( "$dir/post-$post_id.html", $post->post_content );
	}
	kses_remove_filters();
	wp_update_post( wp_slash( array( 'ID' => $post_id, 'post_content' => $content ) ) );
	clean_post_cache( $post_id );
}
if ( ! $dry && function_exists( 'sg_cachepress_purge_everything' ) ) {
	sg_cachepress_purge_everything();
}
