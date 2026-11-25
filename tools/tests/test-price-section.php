<?php
/**
 * Fixes & services (bwe/price-section + bwe/price-card, 2026-11-23), the Pricing page's service prices:
 * - the converted pattern renders exactly like the original;
 * - the converter keeps every card, price row and link;
 * - a freshly inserted section / card renders cleanly; cards per row and card colours produce their CSS.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/price-section.php';

/**
 * Converts the Fixes & services section in a block document (as convert.php does).
 *
 * @param string $markup Serialized blocks.
 * @return array{0: string, 1: int} [ new markup, converted count ]
 */
function bwe_tb_ps_convert_doc( string $markup ): array {
	$count  = 0;
	$blocks = parse_blocks( $markup );
	foreach ( $blocks as $i => $block ) {
		$new = empty( $block['blockName'] ) ? null : bwe_tb_convert_price_section( $block );
		if ( is_array( $new ) ) {
			$blocks[ $i ] = $new;
			++$count;
		}
	}
	return array( serialize_blocks( $blocks ), $count );
}

function test_price_section_renders_like_the_original() {
	$old             = file_get_contents( __DIR__ . '/fixtures/old-price-section.html' );
	[ $new, $count ] = bwe_tb_ps_convert_doc( $old );
	bwe_tb_assert_true( 1 === $count && false !== strpos( $new, '<!-- wp:bwe/price-section ' ), 'pattern → bwe/price-section' );
	bwe_tb_assert_same( bwe_tb_expected( 'price-section', $old ), bwe_tb_render( $new ), 'Fixes & services renders identically' );
}

function test_price_section_converter_keeps_items() {
	[ $new ] = bwe_tb_ps_convert_doc( file_get_contents( __DIR__ . '/fixtures/old-price-section.html' ) );
	$section = parse_blocks( $new )[0];
	bwe_tb_assert_same( 'prices', (string) ( $section['attrs']['sectionId'] ?? '' ), 'section keeps its #prices ID' );
	bwe_tb_assert_same( 'bwe/price-card,bwe/price-card', implode( ',', array_column( $section['innerBlocks'], 'blockName' ) ), 'two price cards' );
	$wp = $section['innerBlocks'][0];
	bwe_tb_assert_same( 'wordpress-prices', (string) ( $wp['attrs']['cardId'] ?? '' ), 'card keeps its #wordpress-prices ID' );
	bwe_tb_assert_same( 'http://bestwebexpert.local/best-wordpress-expert/', (string) ( $wp['attrs']['titleUrl'] ?? '' ), 'title link → Title link setting' );
	bwe_tb_assert_same( 'WordPress Expert Pricing', (string) ( $wp['attrs']['title'] ?? '' ), 'title without the link' );
	bwe_tb_assert_same( '8,8', implode( ',', array_map( static fn( $c ) => count( $c['innerBlocks'][0]['innerBlocks'] ), $section['innerBlocks'] ) ), 'each card keeps its 8 price rows' );
	bwe_tb_assert_same( 'Fixes & services', (string) ( $section['attrs']['metadata']['name'] ?? '' ), 'List View name' );
}

function test_price_section_fresh_blocks_render_cleanly() {
	$markup = '<!-- wp:bwe/price-section --><!-- wp:bwe/price-card {"chip":"A","title":"T","price":"From <strong>$1</strong>","btnText":"Go","btnUrl":"/x/"} --><!-- wp:bwe/price-list --><!-- wp:bwe/price-row {"service":"S","note":"N","amount":"$1","unit":"/ u"} /--><!-- /wp:bwe/price-list --><!-- /wp:bwe/price-card --><!-- wp:bwe/price-card /--><!-- /wp:bwe/price-section -->';
	$problems = array();
	set_error_handler(
		static function ( $no, $msg, $file, $line ) use ( &$problems ) {
			$problems[] = "$msg ($file:$line)";
			return true;
		}
	);
	try {
		$html = bwe_tb_render( $markup );
	} finally {
		restore_error_handler();
	}
	bwe_tb_assert_same( '', implode( ' | ', $problems ), 'fresh section: no PHP warnings' );
	bwe_tb_assert_true( false !== strpos( $html, '<section id="prices" class="wp-block-group' ) && false !== strpos( $html, 'bwex-plats bwe-prx__plats' ), 'fresh section prints its section and grid' );
	bwe_tb_assert_same( '2', (string) substr_count( $html, 'class="wp-block-group bwex-plat bwe-prx__card"' ), 'cards without an ID print no id=""' );
	bwe_tb_assert_same( '1', (string) substr_count( $html, 'bwex-plat__chipwrap' ), 'an empty card leaves out its chip' );
	bwe_tb_assert_true( false !== strpos( $html, '<strong class="bwe-prx__amt">$1 <em>/ u</em></strong>' ), 'price row inside the card' );
}

function test_price_section_cards_per_row_and_colours() {
	$card  = '<!-- wp:bwe/price-card {"title":"T"} /-->';
	$three = str_repeat( $card, 3 );
	$html  = bwe_tb_render( '<!-- wp:bwe/price-section {"bweStyle":{"columns":"3","columnsMobile":"2","rowAmount":"#ff0000","gap":"40px"}} -->' . $three . '<!-- /wp:bwe/price-section -->' );
	bwe_tb_assert_true( false !== strpos( $html, 'bwe-ps--even bwe-ps--d3 bwe-ps--t2 bwe-ps--m2' ), 'chosen cards per row → layout classes (tablet default 2)' );
	bwe_tb_assert_true( false !== strpos( $html, '.bwe-ps--even.bwe-ps--d3 .bwex-plats{grid-template-columns:repeat(3, minmax(0, 1fr))!important}' ), 'even-layout CSS printed' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwex-plats{gap:40px!important;--bwe-ps-gap:40px!important}' ), 'space between cards also centres the dividers' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwe-prx__amt{color:#ff0000!important}' ), 'price colour for every card' );

	$html = bwe_tb_render( '<!-- wp:bwe/price-section -->' . $three . '<!-- /wp:bwe/price-section -->' );
	bwe_tb_assert_true( false !== strpos( $html, 'bwe-ps--even bwe-ps--d3 bwe-ps--t2 bwe-ps--m1' ), 'three cards, no setting → 3 / 2 / 1 per row' );

	$html = bwe_tb_render( '<!-- wp:bwe/price-section -->' . str_repeat( $card, 2 ) . '<!-- /wp:bwe/price-section -->' );
	bwe_tb_assert_true( false === strpos( $html, 'bwe-ps--' ) && false === strpos( $html, '<style' ), 'two cards, no setting → the site\'s own layout, no extra CSS' );

	$html = bwe_tb_render( '<!-- wp:bwe/price-section -->' . str_replace( '"T"}', '"T","bweStyle":{"bg":"#00ff00"}}', $card ) . $card . '<!-- /wp:bwe/price-section -->' );
	bwe_tb_assert_true( false !== strpos( $html, ':not(#bwe-pc){background-color:#00ff00!important}' ), 'one card\'s own background' );

	$css = bwe_gw_price_section_css();
	bwe_tb_assert_true( false !== strpos( $css, '.bwe-ps--even.bwe-ps--d3 .bwex-plats > .elementor-widget-bwex-platform-card:not(:nth-child(3n+1))::before{display:block}' ), 'divider before every card but the first of a row' );
	bwe_tb_assert_true( false !== strpos( $css, '.bwe-ps--even.bwe-ps--m1 .bwex-plats > .elementor-widget-bwex-platform-card:nth-child(n+2){border-top:' ), 'line between rows' );
}

function test_price_section_registered_with_starters() {
	$registry = WP_Block_Type_Registry::get_instance();
	foreach ( array( 'bwe/price-section', 'bwe/price-card' ) as $name ) {
		$type = $registry->get_registered( $name );
		bwe_tb_assert_true( $type && is_callable( $type->render_callback ), "$name is registered" );
		$starter = $type ? ( $type->variations[0] ?? array() ) : array();
		bwe_tb_assert_true( ! empty( $starter['isDefault'] ) && ! empty( $starter['innerBlocks'] ), "$name has a filled starter" );
	}
}
