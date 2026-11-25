<?php
/**
 * Converter: a <section> core group → bwe/section (Section block), keeping all its inner blocks as they are.
 * Hero and services sections are left alone (they have their own blocks).
 *
 * @package BWE_Gutenberg_Widget
 */

/** List View names by section class (shown in the editor's List View). */
const BWE_TB_SECTION_NAMES = array(
	'bwex-services'    => 'Experts section',
	'bwex-spec'        => 'Why us section',
	'bwex-proof'       => 'Testimonials section',
	'bwex-pricing'     => 'Pricing section',
	'bwex-who'         => 'Who we build for section',
	'bwex-process'     => 'How it works section',
	'bwex-work'        => 'Products section',
	'bwex-about'       => 'About section',
	'bwex-faq-section' => 'FAQ section',
	'bwe-final'        => 'Closing call to action',
);

/**
 * Returns bwe/section for a known-shape section group, false for one in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_section( array $block ) {
	$class = (string) ( $block['attrs']['className'] ?? '' );
	if ( 'core/group' !== $block['blockName'] || 'section' !== ( $block['attrs']['tagName'] ?? '' ) || preg_match( '/(^|\s)(bwex-hero|bwex-svc-band)(\s|$)/', $class ) ) {
		return null;
	}
	$attrs = $block['attrs'];
	unset( $attrs['metadata'], $attrs['tagName'], $attrs['className'] );
	$anchor = $attrs['anchor'] ?? '';
	unset( $attrs['anchor'] );
	if ( $attrs || '' === $class || ! $block['innerBlocks'] ) {
		return false;
	}
	$open = '<section' . ( '' !== $anchor ? ' id="' . $anchor . '"' : '' ) . ' class="wp-block-group ' . $class . '">';
	foreach ( $block['innerContent'] as $i => $chunk ) {
		if ( ! is_string( $chunk ) ) {
			continue;
		}
		$rest = trim( str_replace( array( $open, '</section>' ), '', $chunk ) );
		if ( '' !== $rest ) {
			return false; // Loose HTML between the inner blocks would be lost.
		}
	}
	$name = 'Section';
	foreach ( BWE_TB_SECTION_NAMES as $key => $label ) {
		if ( preg_match( '/(^|\s)' . preg_quote( $key, '/' ) . '(\s|$)/', $class ) ) {
			$name = $label;
			break;
		}
	}
	$new = array(
		'classes'  => $class,
		'metadata' => array( 'name' => $name ),
	);
	if ( '' !== $anchor ) {
		$new['anchor'] = $anchor;
	}
	return bwe_tb_block_with_children( 'bwe/section', $new, $block['innerBlocks'] );
}
