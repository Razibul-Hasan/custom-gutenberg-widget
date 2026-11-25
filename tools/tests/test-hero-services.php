<?php
/**
 * bwe/hero, bwe/services + bwe/service-tile: same live markup as the Home hero / services patterns when no style
 * setting is used; style settings become one scoped <style> per block; converters.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/hero.php';
require_once dirname( __DIR__ ) . '/converters/services.php';

/**
 * Converts the top-level block of an old-shape fixture with the given converter.
 *
 * @param string   $fixture Fixture file name.
 * @param callable $convert Converter.
 * @return array|false|null
 */
function bwe_tb_hs_convert( string $fixture, callable $convert ) {
	return $convert( parse_blocks( file_get_contents( __DIR__ . '/fixtures/' . $fixture ) )[0] );
}

/**
 * Serialized block inside a group with the given class (Home's pattern puts the hero / services there).
 *
 * @param array  $block Parsed block.
 * @param string $class Group class.
 */
function bwe_tb_hs_in_group( array $block, string $class ): string {
	return '<!-- wp:group {"className":"' . $class . '"} --><div class="wp-block-group ' . $class . '">' . serialize_block( $block ) . '</div><!-- /wp:group -->';
}

/**
 * The live HTML inside Home's wrapper group, and the block placed on its own (it then prints Home's wrappers).
 *
 * @param string $name     Block name.
 * @param array  $new      Converted block.
 * @param string $expected Expected HTML of the block itself.
 * @param string $label    Label.
 */
function bwe_tb_hs_assert_wraps( string $name, array $new, string $expected, string $label ): void {
	[ , $outer, $inner ] = bwe_gw_outer_wraps()[ $name ];
	bwe_tb_assert_same( bwe_tb_normalize( '<div class="wp-block-group ' . $inner . '">' . $expected . '</div>' ), bwe_tb_render( bwe_tb_hs_in_group( $new, $inner ) ), $label . " renders identically inside Home's wrapper (no style settings)" );
	bwe_tb_assert_same(
		bwe_tb_normalize( '<div class="wp-block-group ' . $outer . '"><div class="wp-block-group elementor-widget-container"><div class="wp-block-group ' . $inner . '">' . $expected . '</div></div></div>' ),
		bwe_tb_render( serialize_blocks( array( $new ) ) ),
		$label . " on its own prints Home's three wrappers around the same markup"
	);
}

function test_hero_render_matches() {
	$old = file_get_contents( __DIR__ . '/fixtures/old-hero.html' );
	$new = bwe_tb_hs_convert( 'old-hero.html', 'bwe_tb_convert_hero' );
	bwe_tb_assert_true( is_array( $new ) && 'bwe/hero' === $new['blockName'], 'hero converted' );
	bwe_tb_hs_assert_wraps( 'bwe/hero', $new, bwe_tb_expected( 'hero renders identically', $old ), 'hero' );
}

function test_services_render_matches() {
	$old = file_get_contents( __DIR__ . '/fixtures/old-services.html' );
	$new = bwe_tb_hs_convert( 'old-services.html', 'bwe_tb_convert_services' );
	bwe_tb_assert_true( is_array( $new ) && 'bwe/services' === $new['blockName'] && 9 === count( $new['innerBlocks'] ), 'services converted with 9 tiles' );
	bwe_tb_hs_assert_wraps( 'bwe/services', $new, bwe_tb_expected( 'services renders identically', $old ), 'services' );
}

function test_hero_style_settings_become_scoped_css() {
	$new                        = bwe_tb_hs_convert( 'old-hero.html', 'bwe_tb_convert_hero' );
	$new['attrs']['bweStyle']   = array(
		'titleColor'      => '#ff0000',
		'titleSizeMobile' => '40px',
		'accent'          => '#00ff00',
	);
	$html                       = bwe_tb_render_raw( serialize_blocks( array( $new ) ) );
	bwe_tb_assert_true( 1 === preg_match( '/class="wp-block-group bwe-section[^"]* (bwe-s-[0-9a-f]{10})"/', $html, $m ), 'section gets a bwe-s-* class' );
	$scope = 'html body .' . ( $m[1] ?? 'x' ) . ':not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c)';
	bwe_tb_assert_true( false !== strpos( $html, $scope . ' .bwe-hero__title{color:#ff0000!important}' ), 'title colour rule' );
	bwe_tb_assert_true( false !== strpos( $html, '@media (max-width:781px){' . $scope . ' .bwe-hero__title{font-size:40px!important}}' ), 'phone title size rule' );
	bwe_tb_assert_true( false !== strpos( $html, $scope . '{--bwe-accent:#00ff00!important;--bwex-accent:#00ff00!important;--bwex-hero-line-c:#00ff00!important}' ), 'accent variables' );
	bwe_tb_assert_true( 1 === substr_count( $html, '<style' ), 'one style element' );
}

function test_style_values_are_sanitized() {
	$new                      = bwe_tb_hs_convert( 'old-hero.html', 'bwe_tb_convert_hero' );
	$new['attrs']['bweStyle'] = array( 'titleColor' => 'red;}</style><script>alert(1)</script>{' );
	$html                     = bwe_tb_render_raw( serialize_blocks( array( $new ) ) );
	bwe_tb_assert_true( false === strpos( $html, '<script>' ) && false === strpos( $html, 'red;}' ), 'no tag or rule break-out' );
}

function test_services_columns_and_hidden_arrow() {
	$new                      = bwe_tb_hs_convert( 'old-services.html', 'bwe_tb_convert_services' );
	$new['attrs']['bweStyle'] = array(
		'columns'   => '4',
		'hideArrow' => true,
	);
	$html                     = bwe_tb_render_raw( serialize_blocks( array( $new ) ) );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwex-svc__grid{grid-template-columns:repeat(4, minmax(0, 1fr))!important}' ), 'columns rule' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwex-svc__arrow{display:none!important}' ), 'hidden arrow rule' );
}

function test_hero_and_services_variants_skipped() {
	$hero = parse_blocks( str_replace( '"className":"bwe-lead"', '"className":"bwe-lead extra"', file_get_contents( __DIR__ . '/fixtures/old-hero.html' ) ) )[0];
	bwe_tb_assert_true( false === bwe_tb_convert_hero( $hero ), 'hero with an unknown lead class → skipped' );
	$plain = parse_blocks( "<!-- wp:group {\"tagName\":\"section\",\"className\":\"bwe-section\"} -->\n<section class=\"wp-block-group bwe-section\"></section>\n<!-- /wp:group -->" )[0];
	bwe_tb_assert_true( null === bwe_tb_convert_hero( $plain ) && null === bwe_tb_convert_services( $plain ), 'other sections → null' );
}
