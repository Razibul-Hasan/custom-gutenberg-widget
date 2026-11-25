<?php
/**
 * Saves the normalized live HTML (+ JSON-LD) of every checked page.
 * Usage: php snapshot-front.php <wp-root> <out-dir>
 *
 * @package BWE_Gutenberg_Widget
 */

require __DIR__ . '/lib.php';
[ , $wp_root, $out ] = $argv + array( null, null, null );
if ( ! $wp_root || ! $out ) {
	fwrite( STDERR, "usage: snapshot-front.php <wp-root> <out-dir>\n" );
	exit( 2 );
}
bwe_tb_boot( $wp_root );
if ( function_exists( 'sg_cachepress_purge_everything' ) ) {
	sg_cachepress_purge_everything();
}
if ( ! is_dir( $out ) ) {
	mkdir( $out, 0777, true );
}
$ctx = stream_context_create( array( 'http' => array( 'timeout' => 60, 'header' => "Cache-Control: no-cache\r\n" ) ) );
foreach ( BWE_TB_PAGES as $id ) {
	$url  = add_query_arg( 'bwe_snap', (string) microtime( true ), get_permalink( $id ) );
	$html = file_get_contents( $url, false, $ctx ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	if ( false === $html || '' === $html ) {
		echo "$id FETCH-FAILED $url\n";
		exit( 1 );
	}
	file_put_contents( "$out/$id.html", bwe_tb_page_fingerprint( $html ) );
	file_put_contents( "$out/$id.head.html", bwe_tb_head_fingerprint( $html ) );
	echo "$id " . strlen( $html ) . " bytes\n";
}
