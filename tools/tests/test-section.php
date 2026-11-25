<?php
/**
 * bwe/section: a section group becomes a dynamic Section block that keeps its inner blocks, renders the same live
 * markup with no style settings, and turns style settings into one scoped <style>.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/section.php';

/**
 * Converts an old-shape section fixture.
 *
 * @param string $name Fixture suffix.
 * @return array|false|null
 */
function bwe_tb_section_convert( string $name ) {
	return bwe_tb_convert_section( parse_blocks( file_get_contents( __DIR__ . "/fixtures/old-section-$name.html" ) )[0] );
}

function test_sections_render_matches() {
	foreach ( array( 'testimonials', 'pricing', 'faq' ) as $name ) {
		$old = file_get_contents( __DIR__ . "/fixtures/old-section-$name.html" );
		$new = bwe_tb_section_convert( $name );
		bwe_tb_assert_true( is_array( $new ) && 'bwe/section' === $new['blockName'] && $new['innerBlocks'], "$name: converted, inner blocks kept" );
		bwe_tb_assert_same( bwe_tb_expected( "section $name renders identically", $old ), bwe_tb_without_slider( bwe_tb_render( serialize_blocks( array( $new ) ) ) ), "$name renders identically (no style settings)" );
	}
}

function test_section_gets_list_view_name() {
	$new = bwe_tb_section_convert( 'testimonials' );
	bwe_tb_assert_same( 'Testimonials section', (string) ( $new['attrs']['metadata']['name'] ?? '' ), 'named in List View' );
}

function test_section_style_settings_become_scoped_css() {
	$new                      = bwe_tb_section_convert( 'faq' );
	$new['attrs']['bweStyle'] = array(
		'bgColor'    => '#101010',
		'titleColor' => '#ffffff',
		'cardRadius' => '4px',
	);
	$html                     = bwe_tb_render_raw( serialize_blocks( array( $new ) ) );
	bwe_tb_assert_true( 1 === preg_match( '/<section id="faq" class="wp-block-group [^"]* (bwe-s-[0-9a-f]{10})">/', $html, $m ), 'section keeps its id and gets a bwe-s-* class' );
	$scope = 'html body .' . ( $m[1] ?? 'x' ) . ':not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c)';
	bwe_tb_assert_true( false !== strpos( $html, $scope . '{background-color:#101010!important}' ), 'background rule' );
	bwe_tb_assert_true( false !== strpos( $html, $scope . ' :is(.bwex-h2 :is(h2, .elementor-heading-title), .bwe-final__box > h2, h2.wp-block-heading){color:#ffffff!important}' ), 'heading colour rule' );
	bwe_tb_assert_true( false !== strpos( $html, 'border-radius:4px!important' ), 'card radius rule' );
}

function test_section_converter_skips() {
	$hero = parse_blocks( file_get_contents( __DIR__ . '/fixtures/old-hero.html' ) )[0];
	bwe_tb_assert_true( null === bwe_tb_convert_section( $hero ), 'hero sections are left to bwe/hero' );
	$loose = parse_blocks( "<!-- wp:group {\"tagName\":\"section\",\"className\":\"bwex-section\"} -->\n<section class=\"wp-block-group bwex-section\">loose text<!-- wp:paragraph -->\n<p>x</p>\n<!-- /wp:paragraph --></section>\n<!-- /wp:group -->" )[0];
	bwe_tb_assert_true( false === bwe_tb_convert_section( $loose ), 'section with loose HTML → skipped' );
}
