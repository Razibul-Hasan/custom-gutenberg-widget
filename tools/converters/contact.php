<?php
/**
 * Converter: the contact form section and the "about" split section — as bwe/section wrappers with core blocks
 * inside (the rebuilt Contact page) or as core groups (patterns) — to bwe/contact-form and bwe/about.
 * Usage: php convert-post.php <wp-root> contact <post-id> [--dry-run]   (pages)
 *        php convert.php <wp-root> contact [--dry-run] [--ids=…]        (synced patterns)
 *
 * @package BWE_Gutenberg_Widget
 */

require_once __DIR__ . '/home-sections.php';

/**
 * Returns the new block, false for a known section in an unknown shape, null for any other block.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_contact( array $block ) {
	$name = $block['blockName'] ?? '';
	if ( ! in_array( $name, array( 'bwe/section', 'core/group' ), true ) ) {
		return null;
	}
	if ( bwe_tb_hs_has( $block, 'bwex-section bwex-wfu-form' ) ) {
		return bwe_tb_convert_contact_form( $block );
	}
	if ( bwe_tb_hs_has( $block, 'bwex-section bwex-about' ) ) {
		return bwe_tb_convert_about( $block );
	}
	return null;
}

/**
 * Section classes, ID and inner blocks of a bwe/section or a core group section.
 *
 * @param array $block Parsed block.
 * @return array{0: string, 1: string} [ classes, id ]
 */
function bwe_tb_contact_section( array $block ): array {
	$classes = (string) ( $block['attrs']['classes'] ?? $block['attrs']['className'] ?? '' );
	return array( trim( $classes ), (string) ( $block['attrs']['anchor'] ?? '' ) );
}

/**
 * Heading [ inner HTML, anchor ] of the first core/heading with the given level.
 *
 * @param array $block Parsed block.
 * @param int   $level Heading level.
 */
function bwe_tb_contact_heading( array $block, int $level ): array {
	$h = bwe_tb_hs_find( $block, static fn( $b ) => 'core/heading' === $b['blockName'] && $level === (int) ( $b['attrs']['level'] ?? 2 ) );
	return $h ? array( bwe_tb_hs_inner( $h ), (string) ( $h['attrs']['anchor'] ?? '' ) ) : array( '', '' );
}

/**
 * Contact form section → bwe/contact-form.
 *
 * @param array $block Parsed section.
 * @return array|false
 */
function bwe_tb_convert_contact_form( array $block ) {
	[ $classes, $id ] = bwe_tb_contact_section( $block );
	[ $title, $hid ]  = bwe_tb_contact_heading( $block, 2 );
	$card             = bwe_tb_hs_get( $block, 'core/group', 'bwe-form-card' );
	$code             = $card ? bwe_tb_hs_get( $card, 'core/shortcode' ) : null;
	$intro            = bwe_tb_hs_get( $block, 'core/group', 'bwex-intro' );
	$paras            = $intro ? array_map( 'bwe_tb_hs_inner', array_filter( $intro['innerBlocks'], static fn( $b ) => 'core/paragraph' === $b['blockName'] ) ) : array();
	if ( '' === $title || ! $code || count( $paras ) > 2 ) {
		return false;
	}
	$paras = array_values( $paras );
	// The page's own wrapper already has .bwe-wfu where the section was built for it (Contact, Write for Us).
	$attrs = bwe_tb_hs_attrs(
		'contact-form',
		array(
			'eyebrow'     => bwe_tb_hs_inner( bwe_tb_hs_get( bwe_tb_hs_get( $block, 'core/group', 'bwex-eyebrow' ) ?? array(), 'core/paragraph' ) ),
			'title'       => $title,
			'headingId'   => $hid,
			'intro'       => $paras[0] ?? '',
			'note'        => $paras[1] ?? '',
			'form'        => trim( (string) $code['innerHTML'] ),
			'sectionId'   => $id,
			'classes'     => $classes,
			'cardClasses' => (string) $card['attrs']['className'],
			'scope'       => false,
			'metadata'    => bwe_tb_hs_meta( 'Contact form' ),
		),
		$block
	);
	return bwe_tb_leaf_block( 'bwe/contact-form', $attrs );
}

/**
 * About split section → bwe/about (the checklist List block moves over unchanged).
 *
 * @param array $block Parsed section.
 * @return array|false
 */
function bwe_tb_convert_about( array $block ) {
	// The block prints the site's fixed Elementor wrapper IDs; a copy with other IDs would not render the same.
	$markup = serialize_block( $block );
	foreach ( array( '2f9aa12', '44e1935', '929d0d7' ) as $wrapper ) {
		if ( false === strpos( $markup, 'elementor-element-' . $wrapper . ' ' ) ) {
			return false;
		}
	}
	[ $classes, $id ] = bwe_tb_contact_section( $block );
	[ $title, $hid ]  = bwe_tb_contact_heading( $block, 2 );
	[ $card_title ]   = bwe_tb_contact_heading( $block, 3 );
	$list             = bwe_tb_hs_get( $block, 'core/list', 'bwex-checks' );
	$button           = bwe_tb_hs_get( $block, 'core/button', 'bwex-btn' );
	$lead             = bwe_tb_hs_get( $block, 'core/group', 'bwex-about__lead' );
	$more             = bwe_tb_hs_all( $block, static fn( $b ) => 'core/paragraph' === $b['blockName'] && bwe_tb_hs_has( $b, 'bwex-about__text' ) );
	if ( '' === $title || bwe_tb_hs_get( $block, 'core/image' ) || ( $button && false === strpos( serialize_block( $button ), 'elementor-element-46d77b3 ' ) ) ) {
		return false;
	}
	[ $btn_url, $btn_text ] = bwe_tb_hs_button( $button );
	$values                 = array(
		'eyebrow'   => bwe_tb_hs_inner( bwe_tb_hs_get( bwe_tb_hs_get( $block, 'core/group', 'bwex-eyebrow' ) ?? array(), 'core/paragraph' ) ),
		'title'     => $title,
		'headingId' => $hid,
		'lead'      => $lead ? bwe_tb_hs_inner( bwe_tb_hs_get( $lead, 'core/paragraph' ) ) : '',
		'more'      => array_values( array_map( 'bwe_tb_hs_inner', $more ) ),
		'cardTitle' => $card_title,
		'btnText'   => $btn_text,
		'btnUrl'    => $btn_url,
		'btnNewTab' => '_blank' === ( $button['attrs']['linkTarget'] ?? '' ),
		'sectionId' => $id,
		'classes'   => $classes,
		'metadata'  => bwe_tb_hs_meta( 'About: ' . bwe_tb_hs_label( $title ) ),
	);
	return bwe_tb_block_with_children( 'bwe/about', bwe_tb_hs_attrs( 'about', $values, $block ), $list ? array( $list ) : array() );
}
