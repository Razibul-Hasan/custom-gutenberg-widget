<?php
/**
 * Converter (2026-11-25, "no classes in Advanced"): a core block whose Additional CSS classes are exactly one of the
 * section parts in includes/parts.json gets that part as its role (bwePart) and an empty className. Its saved HTML
 * keeps the same classes (the role prints them), so the page renders the same. The editor-only bwe-scope--* markers
 * are dropped on the way (no CSS or script reads them; the page layout gives the editor its scope now).
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Returns the block with its role, or null.
 *
 * @param array $block Parsed block.
 * @return array|null
 */
function bwe_tb_convert_parts( array $block ) {
	$name = (string) ( $block['blockName'] ?? '' );
	$cls  = (string) ( $block['attrs']['className'] ?? '' );
	if ( '' === $cls || 0 !== strpos( $name, 'core/' ) ) {
		return null;
	}
	$clean = trim( preg_replace( '/\s+/', ' ', preg_replace( '/\bbwe-scope--[a-z0-9-]+/', '', $cls ) ) );
	$key   = bwe_gw_part_for( $name, $clean );
	if ( '' === $key ) {
		return null;
	}
	unset( $block['attrs']['className'] );
	$block['attrs'] = array( 'bwePart' => $key ) + $block['attrs'];
	if ( $clean !== $cls ) {
		// The scope markers are in the saved HTML's first class attribute too.
		$strip = static function ( $html ) {
			return preg_replace_callback(
				'/class="([^"]*)"/',
				static fn( $m ) => 'class="' . trim( preg_replace( '/\s+/', ' ', preg_replace( '/\bbwe-scope--[a-z0-9-]+/', '', $m[1] ) ) ) . '"',
				(string) $html,
				1
			);
		};
		$block['innerHTML'] = $strip( $block['innerHTML'] );
		if ( isset( $block['innerContent'][0] ) && is_string( $block['innerContent'][0] ) ) {
			$block['innerContent'][0] = $strip( $block['innerContent'][0] );
		}
	}
	return $block;
}
