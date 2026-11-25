<?php
/**
 * Fixes & services (bwe/price-section): the "even" card layout.
 *
 * The site's platform-card CSS is made for exactly two cards (first card: padding + divider on the right, last card:
 * padding on the left). With any other number of cards, or when a "Cards per row" setting is picked, the section
 * gets the classes bwe-ps--even bwe-ps--d{n} bwe-ps--t{n} bwe-ps--m{n} (cards per row on desktop / tablet / phone)
 * and this CSS: equal columns, a divider between the cards of a row, a line between rows. Two cards without a
 * setting keep the site's own layout and print nothing extra, so the Pricing page stays exactly as it was.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * Layout classes of a section ('' = the site's own two-card layout).
 *
 * @param array $attributes Block attributes.
 * @param int   $cards      Number of price cards.
 */
function bwe_gw_price_section_layout( array $attributes, $cards ) {
	$style = (array) ( $attributes['bweStyle'] ?? array() );
	$pick  = static function ( $key, $max ) use ( $style ) {
		$n = (int) ( $style[ $key ] ?? 0 );
		return $n >= 1 && $n <= $max ? $n : 0;
	};
	$d = $pick( 'columns', 3 );
	$t = $pick( 'columnsTablet', 3 );
	$m = $pick( 'columnsMobile', 2 );
	if ( 2 === (int) $cards && ! $d && ! $t && ! $m ) {
		return '';
	}
	$cards = max( 1, (int) $cards );
	$d     = $d ? $d : ( 4 === $cards ? 2 : min( 3, $cards ) );
	$t     = $t ? $t : min( 2, $cards );
	$m     = $m ? $m : 1;
	return "bwe-ps--even bwe-ps--d$d bwe-ps--t$t bwe-ps--m$m";
}

/**
 * CSS of the even layout (scoped to .bwe-ps--even).
 */
function bwe_gw_price_section_css() {
	$s    = 'html body .bwe-ps--even';
	$card = ' .bwex-plats > .elementor-widget-bwex-platform-card';
	$gap  = 'var(--bwe-ps-gap, clamp(48px, 6vw, 96px))';
	$line = 'var(--bwe-ps-line-w, 1px) solid var(--bwe-ps-line, var(--bwex-hair, #e3e3dc))';
	$css  = "$s .bwex-plats{display:grid!important;column-gap:$gap!important;row-gap:0!important}"
		. "$s$card{position:relative;padding-inline:0!important;border-inline:0!important;border-top:0!important}"
		. "$s$card .bwex-plat{padding-inline:0!important;border:0!important}"
		// The price list takes the spare height, so the "from" price + button line up at the bottom of a row.
		. "$s$card .bwex-plat__list{flex-grow:1}"
		. "$s$card::before{content:\"\";display:none;position:absolute;top:0;bottom:0;left:calc($gap / -2);width:var(--bwe-ps-line-w, 1px);background:var(--bwe-ps-line, var(--bwex-hair, #e3e3dc))}";
	$media = array(
		'd' => array( '@media (min-width:1025px)', 3 ),
		't' => array( '@media (min-width:782px) and (max-width:1024px)', 3 ),
		'm' => array( '@media (max-width:781px)', 2 ),
	);
	foreach ( $media as $bp => [ $query, $max ] ) {
		$rules = '';
		for ( $n = 1; $n <= $max; $n++ ) {
			$on     = "$s.bwe-ps--$bp$n";
			$rules .= "$on .bwex-plats{grid-template-columns:repeat($n, minmax(0, 1fr))!important}"
				. ( $n > 1 ? "$on$card:not(:nth-child({$n}n+1))::before{display:block}" : '' )
				. "$on$card:nth-child(n+" . ( $n + 1 ) . "){border-top:$line!important}";
		}
		$css .= $query . '{' . $rules . '}';
	}
	return $css;
}

/**
 * <style> with the even-layout CSS ('' in the readers mode or when unused). Printed by every section that uses it,
 * like the Styles-tab CSS: a once-per-page flag could be used up by an earlier render of the content (SEO plugins).
 *
 * @param string $layout Layout classes from bwe_gw_price_section_layout().
 */
function bwe_gw_price_section_style( $layout ) {
	if ( '' === $layout || bwe_gw_readers_mode() ) {
		return '';
	}
	return '<style>' . bwe_gw_price_section_css() . '</style>';
}

/**
 * The same CSS for the editor (window.bweGw.priceSectionCss).
 */
function bwe_gw_price_section_editor_data() {
	wp_add_inline_script(
		'wp-blocks',
		'window.bweGw = Object.assign( window.bweGw || {}, ' . wp_json_encode( array( 'priceSectionCss' => bwe_gw_price_section_css() ) ) . ' );',
		'before'
	);
}
add_action( 'enqueue_block_editor_assets', 'bwe_gw_price_section_editor_data' );
