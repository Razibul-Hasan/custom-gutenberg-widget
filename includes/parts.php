<?php
/**
 * Section parts ("Section part" → "Role in the section", src/blocks/shared/part-controls.js): a core block inside a
 * section keeps a named role (attribute bwePart) instead of CSS classes in Advanced → "Additional CSS class(es)".
 * The role's classes are in the block's saved HTML already; here they are also handed to the PHP code that reads a
 * block's classes while the page renders (BestWebExpert Home's button / image / heading markup, the hero and services
 * wrappers …), as if they were its className — at render time only, nothing is saved.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * The parts registry (includes/parts.json): key => { block, label, context, classes }.
 *
 * @return array<string, array{block: string, label: string, context: string, classes: string}>
 */
function bwe_gw_parts() {
	static $parts = null;
	if ( null === $parts ) {
		$parts = json_decode( (string) file_get_contents( __DIR__ . '/parts.json' ), true );
		$parts = is_array( $parts ) ? $parts : array();
	}
	return $parts;
}

/**
 * The part key for a block name + classes ('' when none matches exactly).
 *
 * @param string $name    Block name.
 * @param string $classes Classes.
 */
function bwe_gw_part_for( $name, $classes ) {
	foreach ( bwe_gw_parts() as $key => $part ) {
		if ( $part['block'] === $name && $part['classes'] === $classes ) {
			return $key;
		}
	}
	return '';
}

/**
 * Gives a block with a role its role's classes as className while it is rendered.
 *
 * @param array $parsed Parsed block.
 */
function bwe_gw_part_classes( $parsed ) {
	$key = (string) ( $parsed['attrs']['bwePart'] ?? '' );
	if ( '' === $key || ! empty( $parsed['attrs']['className'] ) ) {
		return $parsed;
	}
	$part = bwe_gw_parts()[ $key ] ?? null;
	if ( $part && $part['block'] === ( $parsed['blockName'] ?? '' ) ) {
		$parsed['attrs']['className'] = $part['classes'];
	}
	return $parsed;
}
add_filter( 'render_block_data', 'bwe_gw_part_classes', 0 );
