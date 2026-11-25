<?php
/**
 * The Product card's animated mockups (decorative, aria-hidden; animated by the BestWebExpert Home product-art
 * CSS). One copy of the markup: the card's render.php prints it, the editor gets the same strings.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * Mockup markup by variant.
 *
 * @return array<string, string> reels | boxes | lift => HTML.
 */
function bwe_gw_product_arts(): array {
	return array(
		'reels' => '<div class="bwe-work__art bwe-work__art--reels" aria-hidden="true"><span class="bwe-pa-ghost"></span><div class="bwe-pa-phone"><p class="bwe-pa-bars"><i></i><i></i><i></i></p><p class="bwe-pa-feed"><span></span><span></span><span></span><span></span></p><p class="bwe-pa-tag"><em></em><span>Shirt<b>$49</b></span><strong>Add</strong></p></div><span class="bwe-pa-ghost"></span></div>',
		'boxes' => '<div class="bwe-work__art bwe-work__art--boxes" aria-hidden="true"><div class="bwe-pa-card bwe-pa-box"><p class="bwe-pa-head"><span>Build your box</span><span class="bwe-pa-count"></span></p><p class="bwe-pa-slots"><i></i><i></i><i></i><i></i></p><p class="bwe-pa-bar"><span></span></p><p class="bwe-pa-msg"><span>Add 4 items to save 15%</span><span>✓ Bundle price unlocked · −15%</span></p></div></div>',
		'lift'  => '<div class="bwe-work__art bwe-work__art--lift" aria-hidden="true"><div class="bwe-pa-card bwe-pa-lift"><p class="bwe-pa-route"><span>old-host.com</span><i></i><span>new-host.com</span></p><p class="bwe-pa-steps"><span>Database</span><span>Files</span><span>URLs</span></p><p class="bwe-pa-bar"><span></span></p><p class="bwe-pa-msg"><span>Migrating… <b class="bwe-pa-pct"></b></span><span>✓ Site moved · 0 downtime</span></p></div></div>',
	);
}

/**
 * One mockup's markup ('' for an unknown variant).
 *
 * @param string $variant reels | boxes | lift.
 * @return string
 */
function bwe_gw_product_art( string $variant ): string {
	return bwe_gw_product_arts()[ $variant ] ?? '';
}

/**
 * The same markup for the Product card's editor preview (window.bweGw.productArt).
 */
function bwe_gw_product_art_editor_data() {
	wp_add_inline_script(
		'wp-blocks',
		'window.bweGw = Object.assign( window.bweGw || {}, ' . wp_json_encode( array( 'productArt' => bwe_gw_product_arts() ) ) . ' );',
		'before'
	);
}
add_action( 'enqueue_block_editor_assets', 'bwe_gw_product_art_editor_data' );
