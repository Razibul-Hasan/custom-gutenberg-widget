<?php
/**
 * bwe/faq-item: renders exactly like the core Details FAQ item it replaces; converter; schema; generator.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/faq-item.php';

/**
 * Old-shape FAQ item (core/details), exactly as the patterns store it.
 *
 * @param string $n        Number ("01").
 * @param string $question Question HTML.
 * @param string $answer   Answer block markup.
 * @param string $class    Details className.
 */
function bwe_tb_faq_old( string $n, string $question, string $answer, string $class = 'bwex-faq__item' ): string {
	return '<!-- wp:details {"className":"' . $class . '"} -->' . "\n"
		. '<details class="wp-block-details ' . $class . '"><summary><span class="bwex-faq__n" aria-hidden="true">' . $n . '</span><span class="bwex-faq__q">' . $question . '</span><span class="bwex-faq__icon" aria-hidden="true"></span></summary>'
		. '<!-- wp:group {"className":"bwex-faq__a"} -->' . "\n" . '<div class="wp-block-group bwex-faq__a">' . "\n" . $answer . "\n" . '</div>' . "\n" . '<!-- /wp:group -->'
		. "</details>\n<!-- /wp:details -->";
}

/** Answer with a link, entities and a list. */
function bwe_tb_faq_answer(): string {
	return "<!-- wp:paragraph -->\n<p>It&#8217;s done in a day. <a href=\"/pricing/\">See prices</a> &amp; plans.</p>\n<!-- /wp:paragraph -->\n\n"
		. "<!-- wp:list -->\n<ul class=\"wp-block-list\"><!-- wp:list-item -->\n<li><strong>Fast:</strong> one day</li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list -->";
}

/**
 * Converts every top-level block of $old and serializes the result.
 *
 * @param string $old Old markup.
 */
function bwe_tb_faq_convert_all( string $old ): string {
	$out = array();
	foreach ( parse_blocks( $old ) as $block ) {
		if ( ! $block['blockName'] ) {
			continue;
		}
		$new   = bwe_tb_convert_faq_item( $block );
		$out[] = is_array( $new ) ? $new : $block;
	}
	return serialize_blocks( $out );
}

function test_faq_item_render_matches_details() {
	$old = bwe_tb_faq_old( '01', 'How fast &amp; how cheap? It&#8217;s <em>quick</em>', bwe_tb_faq_answer() );
	$new = bwe_tb_faq_convert_all( $old );
	bwe_tb_assert_true( false !== strpos( $new, '<!-- wp:bwe/faq-item' ), 'converted to bwe/faq-item' );
	bwe_tb_assert_same( bwe_tb_expected( 'faq item renders identically', $old ), bwe_tb_render( $new ), 'faq item renders identically' );
}

function test_faq_item_extra_class() {
	$old = bwe_tb_faq_old( '07', 'Do you write copy?', "<!-- wp:paragraph -->\n<p>On request · extra.</p>\n<!-- /wp:paragraph -->", 'bwex-faq__item bwex-faq__item--extra' );
	$new = bwe_tb_faq_convert_all( $old );
	bwe_tb_assert_true( false !== strpos( $new, '"extra":true' ), 'extra attribute set' );
	bwe_tb_assert_same( bwe_tb_expected( 'extra faq item renders identically', $old ), bwe_tb_render( $new ), 'extra faq item renders identically' );
}

function test_faq_item_variant_skipped() {
	$p     = "<!-- wp:paragraph -->\n<p>x</p>\n<!-- /wp:paragraph -->";
	$extra = parse_blocks( bwe_tb_faq_old( '01', 'Q?', $p, 'bwex-faq__item foo' ) )[0];
	bwe_tb_assert_true( false === bwe_tb_convert_faq_item( $extra ), 'unknown extra class → reported as skipped' );
	$bare = parse_blocks( '<!-- wp:details {"className":"bwex-faq__item"} -->' . "\n" . '<details class="wp-block-details bwex-faq__item"><summary><span class="bwex-faq__n" aria-hidden="true">01</span><span class="bwex-faq__q">Q?</span><span class="bwex-faq__icon" aria-hidden="true"></span></summary>' . $p . "</details>\n<!-- /wp:details -->" )[0];
	bwe_tb_assert_true( false === bwe_tb_convert_faq_item( $bare ), 'answer not wrapped in bwex-faq__a → skipped' );
	$other = parse_blocks( '<!-- wp:details -->' . "\n" . '<details class="wp-block-details"><summary>Plain</summary>' . $p . "</details>\n<!-- /wp:details -->" )[0];
	bwe_tb_assert_true( null === bwe_tb_convert_faq_item( $other ), 'plain details block is not a FAQ item → null' );
}

function test_faq_schema_unchanged() {
	$old = bwe_tb_faq_old( '01', 'How fast &amp; how cheap?', bwe_tb_faq_answer() )
		. "\n\n" . bwe_tb_faq_old( '02', 'Do I own it?', "<!-- wp:paragraph -->\n<p>Yes.</p>\n<!-- /wp:paragraph -->" )
		. "\n\n" . bwe_tb_faq_old( '03', 'What&#8217;s next?', "<!-- wp:paragraph -->\n<p>A call.</p>\n<!-- /wp:paragraph -->", 'bwex-faq__item bwex-faq__item--extra' );
	$new = bwe_tb_faq_convert_all( $old );
	bwe_tb_assert_same( wp_json_encode( bwe_bwe_details_faq( bwe_tb_render_raw( $old ) ) ), wp_json_encode( bwe_bwe_details_faq( bwe_tb_render_raw( $new ) ) ), 'FAQPage schema node' );
}

function test_section_library_faq() {
	$sample = require __DIR__ . '/fixtures/sl-faq-sample.php';
	bwe_tb_assert_true( false !== strpos( bwe_sl_faq( $sample ), '<!-- wp:bwe/faq-item' ), 'generator emits bwe/faq-item' );
	bwe_tb_assert_same( file_get_contents( __DIR__ . '/fixtures/sl-faq.html' ), bwe_tb_render( bwe_sl_faq( $sample ) ), 'generator output renders as before' );
}
