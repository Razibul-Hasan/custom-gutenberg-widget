<?php
/**
 * bwe/steps + bwe/step: render exactly like the group-based numbered list (and its ol/li/span render filters).
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/steps.php';

/**
 * Old-shape step (group .bwex-num__item …), exactly as the patterns store it.
 *
 * @param string $n     Number.
 * @param string $title Title HTML.
 * @param string $text  Text HTML.
 */
function bwe_tb_step_old( string $n, string $title, string $text ): string {
	return '<!-- wp:group {"className":"bwex-num__item bwex-reveal"} -->' . "\n" . '<div class="wp-block-group bwex-num__item bwex-reveal">'
		. '<!-- wp:paragraph {"className":"bwex-num__n"} -->' . "\n" . '<p class="bwex-num__n">' . $n . "</p>\n<!-- /wp:paragraph -->\n\n"
		. '<!-- wp:group {"className":"bwex-num__body"} -->' . "\n" . '<div class="wp-block-group bwex-num__body">'
		. '<!-- wp:heading {"level":3,"className":"bwex-num__title bwe-h2x-plain"} -->' . "\n" . '<h3 class="wp-block-heading bwex-num__title bwe-h2x-plain">' . $title . "</h3>\n<!-- /wp:heading -->\n\n"
		. '<!-- wp:group {"className":"bwex-num__text"} -->' . "\n" . '<div class="wp-block-group bwex-num__text"><!-- wp:paragraph -->' . "\n<p>" . $text . "</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:group -->"
		. "</div>\n<!-- /wp:group --></div>\n<!-- /wp:group -->";
}

/**
 * Old-shape numbered list container.
 *
 * @param string[] $steps Step markup.
 */
function bwe_tb_steps_old( array $steps ): string {
	return '<!-- wp:group {"className":"bwex-num bwex-num--row bwex-num--dark"} -->' . "\n" . '<div class="wp-block-group bwex-num bwex-num--row bwex-num--dark">' . implode( "\n\n", $steps ) . "</div>\n<!-- /wp:group -->";
}

function test_steps_render_matches() {
	$old   = bwe_tb_steps_old(
		array(
			bwe_tb_step_old( '01', 'Free strategy call', 'Tell us your goals &amp; we audit your site.' ),
			bwe_tb_step_old( '02', 'Design you&#8217;ll love', 'See it before any <a href="/x/">code</a> is written.' ),
		)
	);
	$block = parse_blocks( $old )[0];
	$new   = bwe_tb_convert_steps( $block );
	bwe_tb_assert_true( is_array( $new ) && 2 === count( $new['innerBlocks'] ) && 'bwe/step' === $new['innerBlocks'][0]['blockName'], 'converted to steps with 2 step blocks' );
	bwe_tb_assert_same( bwe_tb_expected( 'numbered list renders identically', $old ), bwe_tb_render( serialize_blocks( array( $new ?: $block ) ) ), 'numbered list renders identically' );
}

function test_steps_variant_skipped() {
	$two_paras = str_replace( "<p>B</p>\n<!-- /wp:paragraph -->", "<p>B</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>C</p>\n<!-- /wp:paragraph -->", bwe_tb_steps_old( array( bwe_tb_step_old( '01', 'A', 'B' ) ) ) );
	bwe_tb_assert_true( false === bwe_tb_convert_steps( parse_blocks( $two_paras )[0] ), 'step text with two paragraphs → skipped' );
	$other = parse_blocks( '<!-- wp:group {"className":"bwex-num__body"} -->' . "\n" . '<div class="wp-block-group bwex-num__body"></div>' . "\n<!-- /wp:group -->" )[0];
	bwe_tb_assert_true( null === bwe_tb_convert_steps( $other ), 'other group → null' );
}

function test_section_library_steps() {
	$sample = require __DIR__ . '/fixtures/sl-steps-sample.php';
	bwe_tb_assert_true( false !== strpos( bwe_sl_steps( $sample ), '<!-- wp:bwe/step ' ), 'generator emits bwe/step' );
	bwe_tb_assert_same( file_get_contents( __DIR__ . '/fixtures/sl-steps.html' ), bwe_tb_render( bwe_sl_steps( $sample ) ), 'generator output renders as before' );
}
