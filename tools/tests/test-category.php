<?php
/**
 * All our blocks sit together in one "Best Web Expert" inserter category, listed first.
 *
 * @package BWE_Gutenberg_Widget
 */

function test_block_category_registered_first() {
	$cats = apply_filters( 'block_categories_all', get_default_block_categories(), new WP_Block_Editor_Context() );
	bwe_tb_assert_same( 'bestwebexpert', (string) ( $cats[0]['slug'] ?? '' ), 'first inserter category is bestwebexpert' );
	bwe_tb_assert_same( 'Best Web Expert', (string) ( $cats[0]['title'] ?? '' ), 'category title' );
	bwe_tb_assert_same( '1', (string) count( wp_list_filter( $cats, array( 'slug' => 'bestwebexpert' ) ) ), 'category listed once' );
}

function test_all_bwe_blocks_in_category() {
	$wrong = array();
	foreach ( WP_Block_Type_Registry::get_instance()->get_all_registered() as $name => $type ) {
		if ( 0 === strpos( $name, 'bwe/' ) && 'bestwebexpert' !== $type->category ) {
			$wrong[] = "$name:{$type->category}";
		}
	}
	bwe_tb_assert_same( '', implode( ',', $wrong ), 'bwe/* blocks outside the Best Web Expert category' );
}
