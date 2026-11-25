<?php
/**
 * Counts old core-block shapes vs new bwe/* blocks across all synced patterns.
 * Usage: php inventory.php <wp-root>
 *
 * @package BWE_Gutenberg_Widget
 */

require __DIR__ . '/lib.php';
bwe_tb_boot( $argv[1] ?? '' );

$components = array(
	'faq-item'     => array( '<!-- wp:details {"className":"bwex-faq__item', '<!-- wp:bwe/faq-item' ),
	'spec-card'    => array( '"className":"bwex-spec__item"', '<!-- wp:bwe/spec-card' ),
	'price-row'    => array( '<span class="bwe-prx__svc">', '<!-- wp:bwe/price-row' ),
	'who-list'     => array( '"className":"bwex-who__list"', '<!-- wp:bwe/who-list' ),
	'step'         => array( '"className":"bwex-num__item', '<!-- wp:bwe/step ' ),
	'section-head' => array( '"className":"bwex bwex-headw"', '<!-- wp:bwe/section-head' ),
);
global $wpdb;
$rows = $wpdb->get_col( "SELECT post_content FROM {$wpdb->posts} WHERE post_type = 'wp_block' AND post_status = 'publish'" );
printf( "%-13s %8s %8s\n", 'component', 'old', 'new' );
foreach ( $components as $name => $sig ) {
	$old = 0;
	$new = 0;
	foreach ( $rows as $c ) {
		$old += '' === $sig[0] ? 0 : substr_count( $c, $sig[0] );
		$new += substr_count( $c, $sig[1] );
	}
	printf( "%-13s %8d %8d\n", $name, $old, $new );
}
