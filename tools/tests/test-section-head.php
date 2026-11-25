<?php
/**
 * bwe/section-head: renders exactly like the 8-group section head it replaces.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/section-head.php';

/**
 * Old-shape section head (as stored in the patterns).
 *
 * @param string $eyebrow Eyebrow.
 * @param string $title   Title HTML.
 * @param string $intro   Intro HTML ('' = none).
 * @param bool   $split   Split layout.
 * @param string $id      Heading id ('' = none).
 */
function bwe_tb_head_old( string $eyebrow, string $title, string $intro, bool $split, string $id ): string {
	$g       = static fn( $cls, $inner ) => '<!-- wp:group {"className":"' . str_replace( '--', '--', $cls ) . '"} -->' . "\n" . '<div class="wp-block-group ' . $cls . '">' . $inner . "</div>\n<!-- /wp:group -->";
	$p       = static fn( $html ) => "<!-- wp:paragraph -->\n<p>$html</p>\n<!-- /wp:paragraph -->";
	$h_attrs = '{"className":"elementor-heading-title bwe-h2x-plain"' . ( $id ? ',"anchor":"' . $id . '"' : '' ) . '}';
	$h       = '<!-- wp:heading ' . $h_attrs . " -->\n<h2" . ( $id ? ' id="' . $id . '"' : '' ) . ' class="wp-block-heading elementor-heading-title bwe-h2x-plain">' . $title . "</h2>\n<!-- /wp:heading -->";
	$main    = $g( 'bwex-head__main', $g( 'bwex-eyebrow', $p( $eyebrow ) ) . "\n\n" . $g( 'bwex-h2', $h ) );
	$head    = $main . ( '' !== $intro ? "\n\n" . $g( 'bwex-intro', $p( $intro ) ) : '' );
	return $g( 'bwex bwex-headw', $g( $split ? 'bwex-head bwex-head--split' : 'bwex-head', $head ) );
}

/**
 * Asserts one variant converts and renders identically.
 *
 * @param string $label Label.
 * @param string $old   Old markup.
 */
function bwe_tb_head_check( string $label, string $old ): void {
	$block = parse_blocks( $old )[0];
	$new   = bwe_tb_convert_section_head( $block );
	bwe_tb_assert_true( is_array( $new ) && 'bwe/section-head' === $new['blockName'], "$label: converted" );
	bwe_tb_assert_same( bwe_tb_expected( "$label: renders identically", $old ), bwe_tb_render( serialize_blocks( array( is_array( $new ) ? $new : $block ) ) ), "$label: renders identically" );
}

function test_head_render_matches() {
	bwe_tb_head_check( 'split + intro + em', bwe_tb_head_old( 'What&#8217;s included', 'Everything You Get, <em>In One Place</em>', 'Cards &amp; more, <a href="/x/">see</a>.', true, '' ) );
	bwe_tb_head_check( 'not split, no intro', bwe_tb_head_old( 'How it works', 'Launch in <em>21 Days</em>', '', false, '' ) );
	bwe_tb_head_check( 'heading id', bwe_tb_head_old( 'FAQ', 'Questions? <em>Answered.</em>', 'Quick answers.', true, 'faq-title' ) );
}

function test_head_variant_skipped() {
	$two = str_replace( "<p>Intro</p>\n<!-- /wp:paragraph -->", "<p>Intro</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>More</p>\n<!-- /wp:paragraph -->", bwe_tb_head_old( 'E', 'T', 'Intro', true, '' ) );
	bwe_tb_assert_true( false === bwe_tb_convert_section_head( parse_blocks( $two )[0] ), 'intro with two paragraphs → skipped' );
	$other = parse_blocks( "<!-- wp:group {\"className\":\"bwex-head\"} -->\n<div class=\"wp-block-group bwex-head\"></div>\n<!-- /wp:group -->" )[0];
	bwe_tb_assert_true( null === bwe_tb_convert_section_head( $other ), 'bare bwex-head group → null' );
}

function test_section_library_head() {
	$sample = require __DIR__ . '/fixtures/sl-head-sample.php';
	bwe_tb_assert_true( false !== strpos( bwe_sl_head( $sample ), '<!-- wp:bwe/section-head' ), 'generator emits bwe/section-head' );
	bwe_tb_assert_same( file_get_contents( __DIR__ . '/fixtures/sl-head.html' ), bwe_tb_render( bwe_sl_head( $sample ) ), 'generator output renders as before' );
}
