<?php
/**
 * Custom icons (bweIcon): library / upload / pasted SVG / none replace the site's drawn icon through one scoped
 * <style>; untouched blocks print exactly their old markup; nothing in the icon can break out of the CSS.
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Renders one leaf block with attributes (live-page emulation).
 *
 * @param string $name  Block name.
 * @param array  $attrs Attributes.
 */
function bwe_tb_icon_render( string $name, array $attrs ): string {
	return bwe_tb_render_raw( serialize_blocks( array( bwe_tb_leaf_block( $name, $attrs ) ) ) );
}

const BWE_TB_ROCKET = '<path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/>';

function test_icon_untouched_blocks_print_no_icon_css() {
	$tile = bwe_tb_icon_render( 'bwe/service-tile', array( 'tag' => 'T', 'name' => 'N', 'desc' => 'D' ) );
	bwe_tb_assert_true( false === strpos( $tile, '<style' ) && false === strpos( $tile, 'bwe-i-' ), 'tile without bweIcon: no style, no class' );
	bwe_tb_assert_true( 1 === preg_match( '/^<li class="bwex-svc__item bwex-svc__item--wordpress"><a /', trim( $tile ) ), 'tile keeps its exact old opening markup' );
	$step = bwe_tb_icon_render( 'bwe/step', array( 'title' => 'x', 'text' => 'y' ) );
	bwe_tb_assert_true( 1 === preg_match( '/^<li class="bwex-num__item bwex-reveal"><span class="bwex-num__n"/', trim( $step ) ), 'step keeps its exact old opening markup' );
}

function test_icon_library_icon_on_service_tile() {
	$html = bwe_tb_icon_render( 'bwe/service-tile', array( 'name' => 'N', 'bweIcon' => array( 'source' => 'library', 'name' => 'rocket', 'svg' => BWE_TB_ROCKET, 'color' => '#ff0000', 'size' => '26px' ) ) );
	bwe_tb_assert_true( 1 === preg_match( '/<li class="bwex-svc__item bwex-svc__item--wordpress (bwe-i-[0-9a-f]{10})"><style>/', $html, $m ), 'tile gets a bwe-i-* class and its <style>' );
	$scope = 'html body .' . ( $m[1] ?? 'x' ) . ':not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c) .bwex-svc__top::before{';
	bwe_tb_assert_true( false !== strpos( $html, $scope . 'background-image:url("data:image/svg+xml,' ), 'icon drawn on the tile icon spot' );
	bwe_tb_assert_true( false !== strpos( $html, rawurlencode( 'stroke="#ff0000"' ) ), 'picked colour is the line colour' );
	bwe_tb_assert_true( false !== strpos( $html, 'background-size:26px 26px!important' ), 'icon size' );
}

function test_icon_default_colours_per_block() {
	$tile = bwe_tb_icon_render( 'bwe/service-tile', array( 'bweIcon' => array( 'source' => 'library', 'svg' => BWE_TB_ROCKET ) ) );
	bwe_tb_assert_true( false !== strpos( $tile, rawurlencode( 'stroke="#c8ff3d"' ) ), 'tile: lime lines by default (like its own icons)' );
	$step = bwe_tb_icon_render( 'bwe/step', array( 'bweIcon' => array( 'source' => 'library', 'svg' => BWE_TB_ROCKET ) ) );
	bwe_tb_assert_true( false !== strpos( $step, rawurlencode( 'stroke="#0b0d0c"' ) ) && false !== strpos( $step, '::after{' ), 'step: dark lines on its ::after tile' );
}

function test_icon_on_section_eyebrow() {
	$section = bwe_tb_block_with_children( 'bwe/section', array( 'classes' => 'bwex-section bwex-who', 'bweIcon' => array( 'source' => 'upload', 'url' => 'http://bestwebexpert.local/wp-content/uploads/x.png' ) ), array( bwe_tb_leaf_block( 'core/paragraph', array() ) ) );
	$html    = bwe_tb_render_raw( serialize_blocks( array( $section ) ) );
	bwe_tb_assert_true( 1 === preg_match( '/<section class="wp-block-group bwex-section bwex-who (bwe-i-[0-9a-f]{10})">/', $html, $m ), 'section gets the icon class' );
	bwe_tb_assert_true( false !== strpos( $html, $m[1] . ':not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c) :is(.bwex-eyebrow p, p.bwe-eyebrow)::before{background-image:url("http://bestwebexpert.local/wp-content/uploads/x.png")!important;background-size:contain!important' ), 'uploaded image fills the eyebrow icon tile' );
}

function test_icon_none_hides_it() {
	$html = bwe_tb_icon_render( 'bwe/service-tile', array( 'bweIcon' => array( 'source' => 'none' ) ) );
	bwe_tb_assert_true( false !== strpos( $html, '.bwex-svc__top::before{display:none!important}' ), 'No icon hides the drawn icon' );
}

function test_icon_svg_code_is_cleaned_and_cannot_escape() {
	$evil = '<svg viewBox="0 0 24 24" onload="alert(1)"><script>alert(2)</script><path d="M1 1" fill="currentColor"/></svg></style><script>alert(3)</script>';
	$html = bwe_tb_icon_render( 'bwe/service-tile', array( 'bweIcon' => array( 'source' => 'svg', 'svg' => $evil, 'color' => '#00ff00' ) ) );
	preg_match( '/<style>(.*?)<\/style>/s', $html, $m );
	$css = $m[1] ?? '';
	bwe_tb_assert_true( '' !== $css && false === strpos( $css, '<' ), 'icon CSS present, no raw < inside it' );
	bwe_tb_assert_true( 1 === substr_count( $html, '<style>' ) && 1 === substr_count( $html, '</style>' ), 'pasted SVG cannot close the <style> element' );
	$svg = rawurldecode( preg_replace( '/^.*data:image\/svg\+xml,([^"]*)".*$/s', '$1', $css ) );
	bwe_tb_assert_true( false === stripos( $svg, 'script' ) && false === stripos( $svg, 'onload' ), 'scripts and event handlers removed' );
	bwe_tb_assert_true( false !== strpos( $svg, 'xmlns="http://www.w3.org/2000/svg"' ) && false !== strpos( $svg, 'fill="#00ff00"' ), 'xmlns added, currentColor → picked colour' );
	$bad = bwe_tb_icon_render( 'bwe/service-tile', array( 'bweIcon' => array( 'source' => 'library', 'svg' => BWE_TB_ROCKET, 'color' => 'red;}</style><script>', 'size' => '1px;}' ) ) );
	bwe_tb_assert_true( 1 === substr_count( $bad, '</style>' ) && false === strpos( $bad, '<script' ) && false === strpos( $bad, 'background-size' ), 'bad colour / size values are dropped' );
	$url = bwe_tb_icon_render( 'bwe/service-tile', array( 'bweIcon' => array( 'source' => 'upload', 'url' => 'javascript:alert(1)' ) ) );
	bwe_tb_assert_true( false === strpos( $url, '<style' ), 'non-http upload URL draws nothing' );
}

function test_icon_php_matches_editor_engine() {
	// The editor twin (icon-engine.js) must build the same SVG; compare the library SVG both produce.
	$php = str_replace( ' />', '/>', rawurldecode( preg_replace( '/^url\("data:image\/svg\+xml,(.*)"\)$/', '$1', bwe_gw_icon_url( array( 'source' => 'library', 'svg' => BWE_TB_ROCKET ), '#c8ff3d' ) ) ) ); // kses writes "<path … />"

	$js  = file_get_contents( dirname( __DIR__, 2 ) . '/src/blocks/shared/icon-engine.js' );
	bwe_tb_assert_true( false !== strpos( $js, 'stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">' ) && false !== strpos( $php, 'viewBox="0 0 24 24" fill="none" stroke="#c8ff3d" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">' . BWE_TB_ROCKET . '</svg>' ), 'PHP and editor build the same library SVG' );
}

function test_icon_library_file_built() {
	$file = dirname( __DIR__, 2 ) . '/build/icons/lucide.json';
	$json = is_readable( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : null;
	bwe_tb_assert_true( is_array( $json['icons'] ?? null ) && count( $json['icons'] ) > 1500 && isset( $json['icons']['rocket'][0] ), 'build/icons/lucide.json has the library (npm run icons)' );
}
