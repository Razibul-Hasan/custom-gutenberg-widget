<?php
/**
 * Rewrites sections of ONE post or page (convert.php does the synced patterns) with a converter from converters/.
 * Usage: php convert-post.php <wp-root> <converter> <post-id> [--dry-run]
 * The post's content is backed up to app/backups/blocks-migration-2026-11-22/<converter>/post-<id>.html first, and
 * the post gets a revision, so the change can be undone from the editor too.
 *
 * @package BWE_Gutenberg_Widget
 */

require __DIR__ . '/lib.php';
$wp_root   = $argv[1] ?? '';
$converter = $argv[2] ?? '';
$post_id   = (int) ( $argv[3] ?? 0 );
$dry       = in_array( '--dry-run', $argv, true );
if ( ! $wp_root || ! $post_id || ! preg_match( '/^[a-z0-9-]+$/', $converter ) || ! is_file( __DIR__ . "/converters/$converter.php" ) ) {
	fwrite( STDERR, "usage: convert-post.php <wp-root> <converter> <post-id> [--dry-run]\n" );
	exit( 2 );
}
bwe_tb_boot( $wp_root );
require_once __DIR__ . "/converters/$converter.php";
$fn   = 'bwe_tb_convert_' . str_replace( '-', '_', $converter );
$post = get_post( $post_id );
if ( ! $post ) {
	fwrite( STDERR, "no post $post_id\n" );
	exit( 1 );
}
if ( ! bwe_tb_roundtrip_safe( $post->post_content ) ) {
	echo "$post_id: SKIP not round-trip safe\n";
	exit( 1 );
}

$converted = 0;
$skipped   = 0;
$walk      = static function ( array $blocks ) use ( &$walk, $fn, &$converted, &$skipped ): array {
	foreach ( $blocks as $i => $block ) {
		if ( empty( $block['blockName'] ) ) {
			continue;
		}
		$new = $fn( $block );
		if ( is_array( $new ) ) {
			$blocks[ $i ] = $new;
			++$converted;
		} elseif ( false === $new ) {
			++$skipped;
		} elseif ( $block['innerBlocks'] ) {
			$blocks[ $i ]['innerBlocks'] = $walk( $block['innerBlocks'] );
		}
	}
	return $blocks;
};
$content = serialize_blocks( $walk( parse_blocks( $post->post_content ) ) );
echo "$post_id {$post->post_title} (modified {$post->post_modified}): converted $converted, skipped $skipped" . ( $dry ? ' (dry run, nothing written)' : '' ) . "\n";
if ( $dry || ! $converted ) {
	exit( 0 );
}
$dir = dirname( ABSPATH ) . "/backups/blocks-migration-2026-11-22/$converter";
if ( ! is_dir( $dir ) ) {
	mkdir( $dir, 0777, true );
}
file_put_contents( "$dir/post-$post_id.html", $post->post_content );
// wp_update_post keeps a revision; kses would strip block markup without a user, so it is turned off here.
kses_remove_filters();
wp_update_post( wp_slash( array( 'ID' => $post_id, 'post_content' => $content ) ) );
clean_post_cache( $post_id );
if ( function_exists( 'sg_cachepress_purge_everything' ) ) {
	sg_cachepress_purge_everything();
}
echo "written; backup: $dir/post-$post_id.html\n";
