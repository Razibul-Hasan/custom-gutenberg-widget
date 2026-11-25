<?php
/**
 * Converter: the Pricing page's "Fixes & services" section (pattern "Pricing – Price list") from core groups +
 * bwe/section-head + bwe/price-list to bwe/price-section + bwe/price-card. The price lists and their rows move
 * over unchanged.
 * Usage: php convert.php <wp-root> price-section [--dry-run] [--ids=1702]
 *
 * @package BWE_Gutenberg_Widget
 */

require_once __DIR__ . '/home-sections.php';

/** Classes bwe/price-section prints itself (render.php); the rest of the old className goes to "classes". */
const BWE_TB_PS_BASE = 'wp-block-group elementor-element elementor-element-0334ad8 e-con-full bwex-section bwex-services bwe-prx__prices e-flex e-con e-child';

/**
 * Returns the new section, false for this section in an unknown shape, null for any other block.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_price_section( array $block ) {
	if ( 'core/group' !== ( $block['blockName'] ?? '' ) || ! bwe_tb_hs_has( $block, 'bwex-section bwe-prx__prices' ) ) {
		return null;
	}
	$head = bwe_tb_hs_head( $block );
	if ( ! $head ) {
		return false;
	}
	$cards = array();
	foreach ( bwe_tb_hs_all( $block, static fn( $b ) => 'core/group' === $b['blockName'] && bwe_tb_hs_has( $b, 'elementor-widget-bwex-platform-card' ) ) as $wrap ) {
		$card = bwe_tb_convert_price_card( $wrap );
		if ( ! $card ) {
			return false;
		}
		$cards[] = $card;
	}
	if ( ! $cards ) {
		return false;
	}
	$extra = array_values( array_diff( preg_split( '/\s+/', trim( (string) ( $block['attrs']['className'] ?? '' ) ) ), explode( ' ', BWE_TB_PS_BASE ) ) );
	$attrs = bwe_tb_hs_attrs(
		'price-section',
		$head + array(
			'sectionId' => (string) ( $block['attrs']['anchor'] ?? '' ),
			'classes'   => implode( ' ', $extra ),
			'metadata'  => bwe_tb_hs_meta( 'Fixes & services' ),
		)
	);
	return bwe_tb_block_with_children( 'bwe/price-section', $attrs, $cards );
}

/**
 * One old platform-card group → bwe/price-card holding its bwe/price-list (null for an unknown shape).
 *
 * @param array $wrap Parsed .elementor-widget-bwex-platform-card group.
 */
function bwe_tb_convert_price_card( array $wrap ): ?array {
	$card  = bwe_tb_hs_get( $wrap, 'core/group', 'bwex-plat bwe-prx__card' );
	$list  = bwe_tb_hs_get( $wrap, 'bwe/price-list' );
	$title = bwe_tb_hs_inner( bwe_tb_hs_get( $wrap, 'core/heading' ) );
	if ( ! $card || ! $list || '' === $title ) {
		return null;
	}
	$url = '';
	if ( preg_match( '#^<a href="([^"]*)">(.*)</a>$#s', $title, $m ) ) {
		$url   = html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' );
		$title = $m[2];
	}
	[ $btn_url, $btn_text ] = bwe_tb_hs_button( bwe_tb_hs_get( $wrap, 'core/button', 'bwex-btn' ) );
	$values                 = array(
		'wrapClasses' => (string) ( $wrap['attrs']['className'] ?? '' ),
		'cardId'      => (string) ( $card['attrs']['anchor'] ?? '' ),
		'chip'        => bwe_tb_hs_inner( bwe_tb_hs_get( $wrap, 'core/paragraph', 'bwex-plat__chip' ) ),
		'title'       => $title,
		'titleUrl'    => $url,
		'text'        => bwe_tb_hs_inner( bwe_tb_hs_get( bwe_tb_hs_get( $wrap, 'core/group', 'bwex-plat__text' ) ?? array(), 'core/paragraph' ) ),
		'price'       => bwe_tb_hs_inner( bwe_tb_hs_get( $wrap, 'core/paragraph', 'bwex-plat__price' ) ),
		'btnText'     => $btn_text,
		'btnUrl'      => $btn_url,
		'metadata'    => bwe_tb_hs_meta( 'Price card: ' . bwe_tb_hs_label( $title ) ),
	);
	return bwe_tb_block_with_children( 'bwe/price-card', bwe_tb_hs_attrs( 'price-card', $values ), array( $list ) );
}
