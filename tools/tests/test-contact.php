<?php
/**
 * Contact form section (bwe/contact-form) and About split (bwe/about), 2026-11-23:
 * - the Contact page's two sections render exactly as before once converted;
 * - the converter keeps every text, ID, link, the form and the checklist;
 * - fresh blocks render cleanly and are usable on any page (form-styles wrapper, empty parts left out);
 * - style settings produce their CSS.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/contact.php';

/**
 * Converts the top-level sections of a block document.
 *
 * @param string $markup Serialized blocks.
 * @return array{0: string, 1: int, 2: array} [ new markup, converted count, new blocks ]
 */
function bwe_tb_contact_convert_doc( string $markup ): array {
	$count  = 0;
	$blocks = parse_blocks( $markup );
	foreach ( $blocks as $i => $block ) {
		$new = empty( $block['blockName'] ) ? null : bwe_tb_convert_contact( $block );
		if ( is_array( $new ) ) {
			$blocks[ $i ] = $new;
			++$count;
		}
	}
	$blocks = array_values( array_filter( $blocks, static fn( $b ) => ! empty( $b['blockName'] ) ) );
	return array( serialize_blocks( $blocks ), $count, $blocks );
}

/**
 * Renders markup and records PHP warnings.
 *
 * @param string $markup Serialized blocks.
 * @return array{0: string, 1: string}
 */
function bwe_tb_contact_render_clean( string $markup ): array {
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
	return array( $html, implode( ' | ', $problems ) );
}

function test_contact_sections_render_like_the_originals() {
	foreach ( array( 'contact-form' => 'bwe/contact-form', 'about' => 'bwe/about' ) as $slug => $name ) {
		$old             = file_get_contents( __DIR__ . "/fixtures/old-$slug.html" );
		[ $new, $count ] = bwe_tb_contact_convert_doc( $old );
		bwe_tb_assert_true( 1 === $count && false !== strpos( $new, "<!-- wp:$name " ), "Contact page section → $name" );
		bwe_tb_assert_same( bwe_tb_expected( $slug, $old ), bwe_tb_render( $new ), "$name renders identically" );
	}
}

function test_contact_converter_keeps_everything() {
	[ , , $b ] = bwe_tb_contact_convert_doc( file_get_contents( __DIR__ . '/fixtures/old-contact-form.html' ) );
	$a         = $b[0]['attrs'];
	bwe_tb_assert_same( 'form|project-form|0', $a['sectionId'] . '|' . $a['headingId'] . '|' . (int) ( $a['scope'] ?? true ), 'form section: IDs kept, no extra wrapper on Contact' );
	bwe_tb_assert_same( '[contact-form-7 id="53e845a" title="Project enquiry"]', $a['form'], 'form shortcode kept' );
	bwe_tb_assert_true( 0 === strpos( $a['note'], 'In a hurry? <a href="https://wa.me/' ), 'second intro line → note' );

	[ , , $b ] = bwe_tb_contact_convert_doc( file_get_contents( __DIR__ . '/fixtures/old-about.html' ) );
	$a         = $b[0]['attrs'];
	bwe_tb_assert_same( 'about|about-razibul|Fastest ways to reach me', $a['sectionId'] . '|' . $a['headingId'] . '|' . $a['cardTitle'], 'about: IDs and card title' );
	bwe_tb_assert_same( '2', (string) count( $a['more'] ), 'about: both "more" paragraphs' );
	bwe_tb_assert_true( ! empty( $a['btnNewTab'] ) && 0 === strpos( $a['btnUrl'], 'https://wa.me/' ), 'about: WhatsApp button, new tab' );
	bwe_tb_assert_same( 'core/list|5', $b[0]['innerBlocks'][0]['blockName'] . '|' . count( $b[0]['innerBlocks'][0]['innerBlocks'] ), 'about: checklist with 5 items kept as a List block' );
}

function test_contact_fresh_blocks_work_on_any_page() {
	[ $html, $problems ] = bwe_tb_contact_render_clean( '<!-- wp:bwe/contact-form {"form":"[contact-form-7 id=\"x\"]"} /-->' );
	bwe_tb_assert_same( '', $problems, 'fresh form section: no PHP warnings' );
	bwe_tb_assert_true( 0 === strpos( $html, '<div class="wp-block-group bwe-wfu"><section id="form" class="wp-block-group bwex-section bwex-wfu-form">' ), 'fresh form section brings its own .bwe-wfu styles wrapper' );
	bwe_tb_assert_true( false !== strpos( $html, '<div class="wp-block-group bwe-home bwe-services bwe-contact bwe-form-card"><p>[contact-form-7 id="x"]</p></div>' ), 'form card with the shortcode (run with the page content)' );
	bwe_tb_assert_true( false === strpos( $html, '<h2 id=' ), 'no heading ID unless set' );

	[ $html ] = bwe_tb_contact_render_clean( '<!-- wp:bwe/contact-form {"intro":"","form":""} /-->' );
	bwe_tb_assert_true( false === strpos( $html, 'bwex-intro' ) && false === strpos( $html, 'bwe-form-card' ), 'no intro, no form: both left out' );

	[ $html, $problems ] = bwe_tb_contact_render_clean( '<!-- wp:bwe/about {"lead":"L"} /-->' );
	bwe_tb_assert_same( '', $problems, 'fresh about: no PHP warnings' );
	bwe_tb_assert_true( false !== strpos( $html, '<section id="about" class="wp-block-group elementor-element elementor-element-84190b5' ) && false !== strpos( $html, 'bwex-about__lead' ), 'fresh about prints its section and lead' );
	bwe_tb_assert_true( false === strpos( $html, 'bwex-about__card' ) && false === strpos( $html, 'bwex-about__more' ), 'about without card or more text: both left out' );
}

function test_contact_styles() {
	$html = bwe_tb_render( '<!-- wp:bwe/contact-form {"form":"[x]","bweStyle":{"btnBg":"#ff0000","columns":"minmax(0, 1fr) minmax(0, 1fr)","formFirst":true}} /-->' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwe-cf7 .wpcf7-submit{background-color:#ff0000!important;border-color:#ff0000!important}' ), 'send button colour' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwex-wfu-form__grid{grid-template-columns:minmax(0, 1fr) minmax(0, 1fr)!important}' ), 'text / form widths' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwe-form-card{order:-1!important}' ), 'form on the left' );

	$html = bwe_tb_render( '<!-- wp:bwe/about {"cardTitle":"C","bweStyle":{"cardBg":"#00ff00","listMark":"#0000ff","cardFirst":true}} /-->' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwex-about__card{background-color:#00ff00!important}' ), 'card background' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwex-checks li::before{color:#0000ff!important}' ), 'checklist mark colour' );

	$html = bwe_tb_render( '<!-- wp:bwe/work --><!-- wp:bwe/work-item {"title":"A","bweStyle":{"titleColor":"#ff0000"}} /--><!-- wp:bwe/work-item {"title":"B"} /--><!-- /wp:bwe/work -->' );
	bwe_tb_assert_true( false !== strpos( $html, ':not(#bwe-wi) .bwex-work__title{color:#ff0000!important}' ) && 1 === substr_count( $html, 'class="wp-block-group bwex-work__item bwe-s-' ), 'Selected work: one project\'s own title colour' );
}

function test_contact_blocks_registered_with_starters() {
	$registry = WP_Block_Type_Registry::get_instance();
	foreach ( array( 'bwe/contact-form', 'bwe/about' ) as $name ) {
		$type = $registry->get_registered( $name );
		bwe_tb_assert_true( $type && is_callable( $type->render_callback ), "$name is registered" );
		$starter = $type ? ( $type->variations[0] ?? array() ) : array();
		bwe_tb_assert_true( ! empty( $starter['isDefault'] ), "$name has a starter" );
	}
	$starter = WP_Block_Type_Registry::get_instance()->get_registered( 'bwe/contact-form' )->variations[0]['attributes'] ?? array();
	bwe_tb_assert_true( false !== strpos( (string) ( $starter['form'] ?? '' ), 'contact-form-7' ), 'form section starter picks a form' );
}
