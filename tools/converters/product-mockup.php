<?php
/**
 * Converter (2026-11-25): a Custom HTML block that is exactly one of the plugin mockups (includes/product-art.php)
 * becomes the Plugin mockup widget (no HTML blocks on the site's pages).
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Returns the widget for a matching core/html block, or null.
 *
 * @param array $block Parsed block.
 * @return array|null
 */
function bwe_tb_convert_product_mockup( array $block ) {
	if ( 'core/html' !== ( $block['blockName'] ?? '' ) ) {
		return null;
	}
	foreach ( bwe_gw_product_arts() as $art => $markup ) {
		if ( trim( $block['innerHTML'] ) === $markup ) {
			return bwe_tb_leaf_block( 'bwe/product-mockup', 'boxes' === $art ? array() : array( 'art' => $art ) );
		}
	}
	return null;
}
