<?php
/**
 * bwe/price-list + bwe/price-row: render exactly like the core List price rows on /pricing/.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/price-list.php';

/**
 * Old-shape price list (core/list .bwe-prx__list with inline-formatted list items).
 *
 * @param string[] $lis List item inner HTML.
 */
function bwe_tb_price_old( array $lis ): string {
	$items = array_map( static fn( $li ) => "<!-- wp:list-item -->\n<li>$li</li>\n<!-- /wp:list-item -->", $lis );
	return '<!-- wp:list {"className":"bwe-prx__list"} -->' . "\n" . '<ul class="wp-block-list bwe-prx__list">' . implode( "\n\n", $items ) . "</ul>\n<!-- /wp:list -->";
}

function test_price_render_matches() {
	$old   = bwe_tb_price_old(
		array(
			'<span class="bwe-prx__svc">WordPress support &amp; bug fix <small>Same day</small></span> <strong class="bwe-prx__amt">$20 <em>/ fix</em></strong>',
			'<span class="bwe-prx__svc">WordPress customization <small>1–2 days</small></span> <strong class="bwe-prx__amt">$40 <em>/ page</em></strong>',
			'<span class="bwe-prx__svc"><a href="http://bestwebexpert.local/wordpress-malware-removal/">Malware removal &amp; security</a> <small>24 hours</small></span> <strong class="bwe-prx__amt">$50 <em>/ site</em></strong>',
		)
	);
	$block = parse_blocks( $old )[0];
	$new   = bwe_tb_convert_price_list( $block );
	bwe_tb_assert_true( is_array( $new ) && 3 === count( $new['innerBlocks'] ), 'converted to price-list with 3 rows' );
	bwe_tb_assert_same( bwe_tb_expected( 'price list renders identically', $old ), bwe_tb_render( serialize_blocks( array( $new ?: $block ) ) ), 'price list renders identically' );
}

function test_price_variant_skipped() {
	$no_note = parse_blocks( bwe_tb_price_old( array( '<span class="bwe-prx__svc">Theme setup</span> <strong class="bwe-prx__amt">$30 <em>/ site</em></strong>' ) ) )[0];
	bwe_tb_assert_true( false === bwe_tb_convert_price_list( $no_note ), 'row without <small> note → skipped' );
	$plain = parse_blocks( "<!-- wp:list -->\n<ul class=\"wp-block-list\"><!-- wp:list-item -->\n<li>x</li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list -->" )[0];
	bwe_tb_assert_true( null === bwe_tb_convert_price_list( $plain ), 'plain list → null' );
}
