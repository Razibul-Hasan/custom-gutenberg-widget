<?php
/**
 * Foundation: patterns round-trip through the block parser, and the Product card mockups render as before.
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Every synced pattern must survive parse → serialize with the same block tree, or convert.php could not rewrite
 * it safely. (Byte equality is too strict: script-made patterns store "--" in attribute JSON where WordPress
 * writes "--"; both parse to the same value.)
 */
function test_roundtrip_all_patterns() {
	global $wpdb;
	$bad = array();
	foreach ( $wpdb->get_results( "SELECT ID, post_content FROM {$wpdb->posts} WHERE post_type = 'wp_block' AND post_status = 'publish'" ) as $row ) {
		if ( ! bwe_tb_roundtrip_safe( $row->post_content ) ) {
			$bad[] = $row->ID;
		}
	}
	bwe_tb_assert_same( '', implode( ',', $bad ), 'wp_block posts that do not round-trip' );
}

/** The safety check itself: a changed attribute value must be caught. */
function test_roundtrip_check_catches_changes() {
	$markup = "<!-- wp:paragraph {\"className\":\"a--b\"} -->\n<p class=\"a--b\">x</p>\n<!-- /wp:paragraph -->";
	bwe_tb_assert_true( bwe_tb_roundtrip_safe( $markup ), 'unescaped -- in attributes is safe' );
	bwe_tb_assert_true( ! bwe_tb_same_tree( $markup, str_replace( '"a--b"}', '"a-b"}', $markup ) ), 'a changed attribute is a different tree' );
}

/** The Product card's mockups print exactly what the old bwe/product-art block printed (fixtures). */
function test_product_art_renders() {
	foreach ( array( 'reels', 'boxes', 'lift' ) as $variant ) {
		bwe_tb_assert_same(
			bwe_tb_normalize( file_get_contents( __DIR__ . "/fixtures/product-art-$variant.html" ) ),
			bwe_tb_normalize( bwe_gw_product_art( $variant ) ),
			"product-art $variant"
		);
		$card = bwe_tb_render( '<!-- wp:bwe/products --><!-- wp:bwe/product-card {"art":"' . $variant . '","name":"X"} /--><!-- /wp:bwe/products -->' );
		bwe_tb_assert_true( false !== strpos( $card, bwe_gw_product_art( $variant ) ), "product card draws the $variant mockup" );
	}
	bwe_tb_assert_same( '', bwe_gw_product_art( 'nope' ), 'unknown mockup prints nothing' );
}

/** The standalone Product art block was removed (2026-11-23): only the Product card draws mockups now. */
function test_product_art_block_removed() {
	bwe_tb_assert_true( ! WP_Block_Type_Registry::get_instance()->is_registered( 'bwe/product-art' ), 'bwe/product-art is not registered' );
}
