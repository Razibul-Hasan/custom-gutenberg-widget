<?php
/**
 * bwe/platforms + bwe/platform-card: Home's platform cards (and the library pattern's) convert to the blocks and
 * render the same live markup; a new card (pack) can be added; style settings become scoped CSS where the
 * card's own settings beat the grid's; the badge appears only when it has text.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/platforms.php';

/**
 * Converts an old-shape platforms fixture.
 *
 * @param string $name Fixture suffix (home | library).
 * @return array|false|null
 */
function bwe_tb_plats_convert( string $name ) {
	return bwe_tb_convert_platforms( parse_blocks( file_get_contents( __DIR__ . "/fixtures/old-platforms-$name.html" ) )[0] );
}

function test_platforms_render_matches() {
	foreach ( array( 'home', 'library' ) as $name ) {
		$old = file_get_contents( __DIR__ . "/fixtures/old-platforms-$name.html" );
		$new = bwe_tb_plats_convert( $name );
		bwe_tb_assert_true( is_array( $new ) && 'bwe/platforms' === $new['blockName'] && 2 === count( $new['innerBlocks'] ), "$name: converted to 2 cards" );
		bwe_tb_assert_same( bwe_tb_expected( "platforms $name renders identically", $old ), bwe_tb_render( serialize_blocks( array( $new ) ) ), "$name renders identically" );
	}
}

function test_platform_card_attributes() {
	$card = bwe_tb_plats_convert( 'home' )['innerBlocks'][0];
	$a    = $card['attrs'];
	bwe_tb_assert_true( 900 === $a['imageId'] && 'WordPress' === $a['chip'] && 'Custom WordPress Development' === $a['title'] && 'http://bestwebexpert.local/best-wordpress-expert/' === $a['titleUrl'], 'image, chip, title + link read' );
	bwe_tb_assert_true( 'Starting at <strong>$250</strong>' === $a['price'] && 'http://bestwebexpert.local/pricing/#wordpress-prices' === $a['btnUrl'] && 'See WordPress pricing →' === $a['btnText'], 'price + button read' );
	bwe_tb_assert_true( 'core/list' === $card['innerBlocks'][0]['blockName'] && 5 === count( $card['innerBlocks'][0]['innerBlocks'] ), 'service list kept as a List block (5 links)' );
	bwe_tb_assert_true( 'Card: WordPress' === $a['metadata']['name'] && isset( $a['metadata']['bindings']['__default'] ), 'card text overridable per page' );
	$lib = bwe_tb_plats_convert( 'library' )['innerBlocks'][0]['attrs'];
	bwe_tb_assert_true( empty( $lib['imageId'] ) && empty( $lib['imageUrl'] ) && 'WordPress Development' === $lib['title'], 'library card without image' );
}

function test_platforms_new_pack_card() {
	// A card made in the editor ("+ Add a card"): default wrapper classes, no image, a list.
	$list = parse_blocks( "<!-- wp:list {\"className\":\"bwex-checks\"} -->\n<ul class=\"wp-block-list bwex-checks\"><!-- wp:list-item -->\n<li>First service</li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list -->" )[0];
	$card = bwe_tb_block_with_children( 'bwe/platform-card', array( 'chip' => 'AI SEO', 'title' => 'AI SEO Package', 'text' => 'Rank in AI answers.', 'price' => 'Starting at <strong>$399</strong>', 'btnText' => 'See AI SEO pricing →', 'btnUrl' => '/pricing/#ai-seo' ), array( $list ) );
	$html = bwe_tb_render( serialize_blocks( array( bwe_tb_block_with_children( 'bwe/platforms', array(), array( $card ) ) ) ) );
	bwe_tb_assert_true( false !== strpos( $html, '<div class="wp-block-group bwex-plats bwex-plats--3"><div class="wp-block-group elementor-element elementor-widget elementor-widget-bwex-platform-card">' ), 'new card gets the classes the site styles' );
	bwe_tb_assert_true( false === strpos( $html, 'bwex-plat__img' ) && false !== strpos( $html, '<h3 class="elementor-heading-title">AI SEO Package</h3>' ), 'no image part, title without link' );
	bwe_tb_assert_true( false !== strpos( $html, '<a class="elementor-button elementor-button-link elementor-size-sm" href="/pricing/#ai-seo"><span class="elementor-button-content-wrapper"><span class="elementor-button-text">See AI SEO pricing →</span></span></a>' ), 'button rendered like the other cards' );
	bwe_tb_assert_true( false !== strpos( $html, '<div class="wp-block-group bwex-plat__list"><ul class="wp-block-list bwex-checks">' ), 'service list' );
	bwe_tb_assert_true( false === strpos( $html, 'bwe-pc-badge' ), 'no badge when empty' );
	$card['attrs']['badge']     = 'Popular';
	$card['attrs']['btnNewTab'] = true;
	$html                       = bwe_tb_render_raw( serialize_blocks( array( $card ) ) );
	bwe_tb_assert_true( false !== strpos( $html, 'elementor-widget-bwex-platform-card" style="position:relative"><span class="bwe-pc-badge"' ) && false !== strpos( $html, '>Popular</span>' ), 'badge shown' );
	bwe_tb_assert_true( false !== strpos( $html, 'target="_blank" rel="noopener"' ), 'button can open in a new tab' );
}

function test_platforms_styles() {
	$new                       = bwe_tb_plats_convert( 'home' );
	$new['attrs']['bweStyle']  = array( 'columns' => '3', 'cardBg' => '#101010', 'btnBg' => '#ff0000' );
	$new['innerBlocks'][1]['attrs']['bweStyle'] = array( 'btnBg' => '#00ff00' );
	$html                      = bwe_tb_render_raw( serialize_blocks( array( $new ) ) );
	bwe_tb_assert_true( 1 === preg_match( '/<div class="wp-block-group [^"]*bwex-plats bwex-plats--3 [^"]*(bwe-s-[0-9a-f]{10})">/', $html, $m ), 'grid gets a bwe-s-* class' );
	$grid = 'html body .' . ( $m[1] ?? 'x' ) . ':not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c)';
	bwe_tb_assert_true( false !== strpos( $html, $grid . '{grid-template-columns:repeat(3, minmax(0, 1fr))!important}' ), 'cards per row' );
	bwe_tb_assert_true( false !== strpos( $html, $grid . ' > .elementor-widget-bwex-platform-card{background-color:#101010!important}' ), 'card background for all cards' );
	bwe_tb_assert_true( 1 === preg_match( '/:not\(#bwe-gw-c\):not\(#bwe-pc\) \.bwex-btn \.elementor-button\{background-color:#00ff00!important;border-color:#00ff00!important\}/', $html ), 'one card has its own button colour (one ID stronger than the grid rule)' );
}

function test_platforms_converter_skips() {
	$odd = parse_blocks( "<!-- wp:group {\"className\":\"bwex-plats\"} -->\n<div class=\"wp-block-group bwex-plats\"><!-- wp:paragraph -->\n<p>x</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:group -->" )[0];
	bwe_tb_assert_true( false === bwe_tb_convert_platforms( $odd ), 'grid with an unknown child → skipped' );
	$other = parse_blocks( "<!-- wp:group {\"className\":\"bwex-cards\"} -->\n<div class=\"wp-block-group bwex-cards\"></div>\n<!-- /wp:group -->" )[0];
	bwe_tb_assert_true( null === bwe_tb_convert_platforms( $other ), 'other group → null' );
}
