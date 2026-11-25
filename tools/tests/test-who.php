<?php
/**
 * bwe/who-list + bwe/who-card: render exactly like the core List "Who we build for" cards.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/who-list.php';

/**
 * Old-shape who list (ordered core/list .bwex-who__list with linked items).
 *
 * @param string[] $lis List item inner HTML.
 */
function bwe_tb_who_old( array $lis ): string {
	$items = array_map( static fn( $li ) => "<!-- wp:list-item -->\n<li>$li</li>\n<!-- /wp:list-item -->", $lis );
	return '<!-- wp:list {"ordered":true,"className":"bwex-who__list"} -->' . "\n" . '<ol class="wp-block-list bwex-who__list">' . implode( "\n\n", $items ) . "</ol>\n<!-- /wp:list -->";
}

function test_who_render_matches() {
	$old   = bwe_tb_who_old(
		array(
			'<a href="/best-shopify-expert/"><strong>E-commerce brands</strong> <span>Fast product pages, smart upsells and a checkout that turns carts into orders.</span> <em>Shopify · WooCommerce</em></a>',
			'<a href="/best-wordpress-expert/"><strong>Coaches &amp; consultants</strong> <span>Personal brand sites with online booking.</span> <em>WordPress</em></a>',
		)
	);
	$block = parse_blocks( $old )[0];
	$new   = bwe_tb_convert_who_list( $block );
	bwe_tb_assert_true( is_array( $new ) && 2 === count( $new['innerBlocks'] ), 'converted to who-list with 2 cards' );
	bwe_tb_assert_same( bwe_tb_expected( 'who list renders identically', $old ), bwe_tb_render( serialize_blocks( array( $new ?: $block ) ) ), 'who list renders identically' );
}

function test_who_variant_skipped() {
	$no_tag = parse_blocks( bwe_tb_who_old( array( '<a href="/x/"><strong>T</strong> <span>Text</span></a>' ) ) )[0];
	bwe_tb_assert_true( false === bwe_tb_convert_who_list( $no_tag ), 'card without <em> tag → skipped' );
	$unordered = parse_blocks( str_replace( array( '"ordered":true,', '<ol ', '</ol>' ), array( '', '<ul ', '</ul>' ), bwe_tb_who_old( array( '<a href="/x/"><strong>T</strong> <span>X</span> <em>Y</em></a>' ) ) ) )[0];
	bwe_tb_assert_true( false === bwe_tb_convert_who_list( $unordered ), 'unordered who list (not used anywhere) → skipped' );
}

function test_section_library_who() {
	$sample = require __DIR__ . '/fixtures/sl-who-sample.php';
	bwe_tb_assert_true( false !== strpos( bwe_sl_who( $sample ), '<!-- wp:bwe/who-card' ), 'generator emits bwe/who-card' );
	bwe_tb_assert_same( file_get_contents( __DIR__ . '/fixtures/sl-who.html' ), bwe_tb_render( bwe_sl_who( $sample ) ), 'generator output renders as before' );
}
