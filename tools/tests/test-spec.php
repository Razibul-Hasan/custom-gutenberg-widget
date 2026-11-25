<?php
/**
 * bwe/spec-list + bwe/spec-card: render exactly like the group/paragraph spec cards (and their render filters).
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/spec-list.php';

/**
 * Old-shape spec list: group .bwex-spec__list > group .bwex-spec__item > paragraphs (name, text[, chip]).
 *
 * @param array $cards [ [name, text, chip|null], … ].
 */
function bwe_tb_spec_old( array $cards ): string {
	$p     = static fn( $html, $cls ) => '<!-- wp:paragraph {"className":"' . $cls . '"} -->' . "\n" . '<p class="' . $cls . '">' . $html . "</p>\n<!-- /wp:paragraph -->";
	$items = array();
	foreach ( $cards as $c ) {
		$inner   = $p( $c[0], 'bwex-spec__name' ) . "\n\n" . $p( $c[1], 'bwex-spec__text' ) . ( isset( $c[2] ) ? "\n\n" . $p( $c[2], 'bwex-spec__chip' ) : '' );
		$items[] = '<!-- wp:group {"className":"bwex-spec__item"} -->' . "\n" . '<div class="wp-block-group bwex-spec__item">' . $inner . "</div>\n<!-- /wp:group -->";
	}
	return '<!-- wp:group {"className":"bwex-spec__list"} -->' . "\n" . '<div class="wp-block-group bwex-spec__list">' . implode( "\n\n", $items ) . "</div>\n<!-- /wp:group -->";
}

/**
 * Converts the top-level spec list in $old.
 *
 * @param string $old Old markup.
 */
function bwe_tb_spec_convert( string $old ): string {
	$block = parse_blocks( $old )[0];
	$new   = bwe_tb_convert_spec_list( $block );
	return serialize_blocks( array( is_array( $new ) ? $new : $block ) );
}

function test_spec_render_matches() {
	$old = bwe_tb_spec_old(
		array(
			array( 'Speed &amp; Core Web Vitals', 'Images, code and <a href="/x/">caching</a> tuned.', 'Core Web Vitals: pass' ),
			array( 'Mobile-first design', 'Laid out for thumbs first.', null ),
			array( 'Owner&#8217;s rights', 'You own it · all of it.', '100% yours' ),
		)
	);
	$new = bwe_tb_spec_convert( $old );
	bwe_tb_assert_true( false !== strpos( $new, '<!-- wp:bwe/spec-list' ) && 3 === substr_count( $new, '<!-- wp:bwe/spec-card' ), 'converted to spec-list with 3 spec-cards' );
	bwe_tb_assert_same( bwe_tb_expected( 'spec list renders identically', $old ), bwe_tb_render( $new ), 'spec list renders identically' );
}

function test_spec_variant_skipped() {
	$four = str_replace( '</div>' . "\n" . '<!-- /wp:group --></div>', "\n\n" . '<!-- wp:paragraph -->' . "\n<p>extra</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:group --></div>", bwe_tb_spec_old( array( array( 'A', 'B', 'C' ) ) ) );
	bwe_tb_assert_true( false !== strpos( $four, '<p>extra</p>' ), 'fixture has a 4th paragraph' );
	bwe_tb_assert_true( false === bwe_tb_convert_spec_list( parse_blocks( $four )[0] ), 'card with a 4th paragraph → skipped' );
	$other = parse_blocks( '<!-- wp:group {"className":"bwex-spec__body"} -->' . "\n" . '<div class="wp-block-group bwex-spec__body"></div>' . "\n<!-- /wp:group -->" )[0];
	bwe_tb_assert_true( null === bwe_tb_convert_spec_list( $other ), 'other group → null' );
}

function test_section_library_cards() {
	$sample = require __DIR__ . '/fixtures/sl-cards-sample.php';
	bwe_tb_assert_true( false !== strpos( bwe_sl_cards( $sample ), '<!-- wp:bwe/spec-card' ), 'generator emits bwe/spec-card' );
	bwe_tb_assert_same( file_get_contents( __DIR__ . '/fixtures/sl-cards.html' ), bwe_tb_render( bwe_sl_cards( $sample ) ), 'generator output renders as before' );
}
