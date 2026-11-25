<?php
/**
 * General-purpose blocks (Buttons, Image / screenshot, Grid / columns, Gap / divider), the settings every block
 * shares (Visibility, Heading tag) and the 2026-11-24 additions to Hero and Section.
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Renders one block from its name, attributes and inner markup.
 *
 * @param string $name  Block name.
 * @param array  $attrs Attributes.
 * @param string $inner Inner block markup.
 */
function bwe_tb_gen( string $name, array $attrs = array(), string $inner = '' ): string {
	$json = $attrs ? ' ' . wp_json_encode( $attrs ) : '';
	return bwe_tb_render_raw( '' === $inner ? "<!-- wp:$name$json /-->" : "<!-- wp:$name$json -->$inner<!-- /wp:$name -->" );
}

function test_buttons_render_site_classes_and_link_options() {
	$html = bwe_tb_gen(
		'bwe/buttons',
		array(
			'items'       => array(
				array( 'text' => 'Get a quote →', 'url' => '/contact/', 'style' => 'primary' ),
				array( 'text' => 'Partner', 'url' => 'https://example.com/', 'style' => 'link', 'newTab' => true, 'rel' => 'sponsored' ),
				array( 'text' => '', 'url' => '/x/' ),
			),
			'align'       => 'center',
			'alignMobile' => 'left',
			'fullMobile'  => true,
		)
	);
	bwe_tb_assert_true( false !== strpos( $html, '<div class="wp-block-buttons bwe-gw-btns bwe-gw-btns--center bwe-gw-btns--left-m bwe-gw-btns--full-m">' ), 'buttons wrapper classes (align per device, full width on phones)' );
	bwe_tb_assert_true( false !== strpos( $html, '<div class="wp-block-button bwe-btn bwe-btn--primary"><a class="wp-block-button__link wp-element-button" href="/contact/">Get a quote →</a></div>' ), 'primary button = the site\'s bwe-btn--primary' );
	bwe_tb_assert_true( false !== strpos( $html, 'href="https://example.com/" target="_blank" rel="noreferrer noopener sponsored">Partner</a>' ), 'new tab + sponsored rel' );
	bwe_tb_assert_same( 2, substr_count( $html, 'wp-block-button__link' ), 'a button without text is left out' );
	bwe_tb_assert_same( '', trim( bwe_tb_gen( 'bwe/buttons', array( 'items' => array() ) ) ), 'no buttons = no markup' );
}

function test_media_renders_figure_with_alt_and_loading() {
	$html = bwe_tb_gen( 'bwe/media', array( 'url' => 'https://example.com/a.jpg', 'alt' => 'A <b>screenshot</b>', 'frame' => 'browser', 'barText' => 'wp-admin', 'ratio' => '16/9', 'caption' => 'Caption <em>here</em>' ) );
	bwe_tb_assert_true( false !== strpos( $html, '<figure class="wp-block-image bwe-gw-media bwe-gw-media--center bwe-gw-media--browser bwe-gw-ratio-16-9">' ), 'figure classes (frame, shape)' );
	bwe_tb_assert_true( false !== strpos( $html, 'alt="A screenshot"' ) && false !== strpos( $html, 'loading="lazy"' ) && false !== strpos( $html, 'decoding="async"' ), 'alt text cleaned, lazy + async by default' );
	bwe_tb_assert_true( false !== strpos( $html, '<div class="bwe-gw-media__bar" aria-hidden="true"><i></i><i></i><i></i><span>wp-admin</span></div>' ), 'browser frame bar' );
	bwe_tb_assert_true( false !== strpos( $html, '<figcaption class="wp-element-caption">Caption <em>here</em></figcaption>' ), 'caption' );
	$hero = bwe_tb_gen( 'bwe/media', array( 'url' => 'https://example.com/a.jpg', 'priority' => true, 'link' => '/x/', 'linkNewTab' => true ) );
	bwe_tb_assert_true( false !== strpos( $hero, 'loading="eager"' ) && false !== strpos( $hero, 'fetchpriority="high"' ), 'above the fold: eager + high priority' );
	bwe_tb_assert_true( false !== strpos( $hero, '<a class="bwe-gw-media__link" href="/x/" target="_blank" rel="noreferrer noopener"><img' ), 'linked image' );
	bwe_tb_assert_same( '', trim( bwe_tb_gen( 'bwe/media', array() ) ), 'no image = no markup' );
	$ids = get_posts( array( 'post_type' => 'attachment', 'post_mime_type' => 'image', 'numberposts' => 1, 'fields' => 'ids' ) );
	if ( $ids ) {
		$lib = bwe_tb_gen( 'bwe/media', array( 'id' => (int) $ids[0], 'url' => 'x' ) );
		bwe_tb_assert_true( false !== strpos( $lib, 'srcset=' ) || false !== strpos( $lib, 'width=' ), 'media-library image: sizes / dimensions from WordPress' );
	}
}

function test_grid_classes_per_device_and_cards() {
	$inner = '<!-- wp:paragraph --><p>a</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>b</p><!-- /wp:paragraph -->';
	$html  = bwe_tb_gen( 'bwe/grid', array( 'columns' => 2, 'columnsTablet' => 2, 'columnsMobile' => 1, 'ratio' => '3-2', 'valign' => 'center', 'cards' => 'soft', 'reverseMobile' => true ), $inner );
	bwe_tb_assert_true( 0 === strpos( $html, '<div class="bwe-gw-grid bwe-gw-grid--c2 bwe-gw-grid--t2 bwe-gw-grid--m1 bwe-gw-grid--r3-2 bwe-gw-grid--v-center bwe-gw-grid--cards bwe-gw-grid--cards-soft bwe-gw-grid--rev-m">' ), 'grid classes' );
	bwe_tb_assert_true( false !== strpos( $html, '>a</p>' ) && false !== strpos( $html, '>b</p>' ), 'inner blocks rendered' );
	$odd = bwe_tb_gen( 'bwe/grid', array( 'columns' => 99, 'cards' => 'evil"', 'ratio' => 'x' ), $inner );
	bwe_tb_assert_true( 0 === strpos( $odd, '<div class="bwe-gw-grid bwe-gw-grid--c6 bwe-gw-grid--t2 bwe-gw-grid--m1">' ), 'bad values are clamped / ignored' );
	$styled = bwe_tb_gen( 'bwe/grid', array( 'bweStyle' => array( 'gapMobile' => '10px' ) ), $inner );
	bwe_tb_assert_true( false !== strpos( $styled, '@media (max-width:781px){html body .bwe-s-' ) && false !== strpos( $styled, '{gap:10px!important}' ), 'gap on phones = scoped media rule' );
}

function test_gap_and_line() {
	bwe_tb_assert_same( '<div class="bwe-gw-gap" aria-hidden="true"></div>', trim( bwe_tb_gen( 'bwe/gap' ) ), 'plain gap' );
	$html = bwe_tb_gen( 'bwe/gap', array( 'line' => true, 'bweStyle' => array( 'height' => '100px', 'heightMobile' => '20px', 'lineStyle' => 'dashed' ) ) );
	bwe_tb_assert_true( false !== strpos( $html, 'bwe-gw-gap bwe-gw-gap--line bwe-s-' ), 'line class + scope' );
	bwe_tb_assert_true( false !== strpos( $html, '@media (min-width:1025px){' ) && false !== strpos( $html, '{height:100px!important}' ), 'desktop height only on desktop' );
	bwe_tb_assert_true( false !== strpos( $html, '::before{border-top-style:dashed!important}' ), 'line style' );
}

function test_hero_kicker_new_tab_and_jump_links() {
	$base = array( 'title' => 'Reel <em>Layouts</em>', 'lead' => 'Lead', 'btn1Text' => 'Go', 'btn1Url' => '#a', 'btn2Text' => 'Free', 'btn2Url' => 'https://wordpress.org/', 'animate' => false );
	$plain = bwe_tb_gen( 'bwe/hero', $base );
	bwe_tb_assert_true( false === strpos( $plain, 'bwe-kicker' ) && false === strpos( $plain, 'bwex-jump' ) && false === strpos( $plain, 'target=' ), 'nothing new printed when unused' );
	$html = bwe_tb_gen( 'bwe/hero', $base + array( 'kicker' => '5 layouts · 1 plugin', 'btn2NewTab' => true, 'jumpLinks' => array( array( 'label' => 'Carousel', 'url' => '#carousel' ), array( 'label' => '', 'url' => '#x' ), array( 'label' => 'Grid', 'url' => '#grid' ) ) ) );
	bwe_tb_assert_true( false !== strpos( $html, '<div class="wp-block-group bwe-hero__copy"><p class="bwe-kicker wp-block-paragraph">5 layouts · 1 plugin</p><h1 ' ), 'kicker above the heading' );
	bwe_tb_assert_true( false !== strpos( $html, 'href="https://wordpress.org/" target="_blank" rel="noreferrer noopener">Free</a>' ), 'second button in a new tab' );
	bwe_tb_assert_true( false !== strpos( $html, '<p class="bwex-jump wp-block-paragraph"><a href="#carousel"><span>01</span>Carousel</a><a href="#grid"><span>02</span>Grid</a></p></div>' ), 'numbered jump links inside the copy, empty ones skipped' );
}

function test_section_tag() {
	$inner = '<!-- wp:paragraph --><p>x</p><!-- /wp:paragraph -->';
	bwe_tb_assert_true( 0 === strpos( trim( bwe_tb_gen( 'bwe/section', array(), $inner ) ), '<section class="wp-block-group bwex-section">' ), 'section by default' );
	bwe_tb_assert_true( 1 === preg_match( '#^<aside class="wp-block-group bwex-demobar">.*</aside>$#s', trim( bwe_tb_gen( 'bwe/section', array( 'tagName' => 'aside', 'classes' => 'bwex-demobar' ), $inner ) ) ), 'aside tag' );
	bwe_tb_assert_true( 0 === strpos( trim( bwe_tb_gen( 'bwe/section', array( 'tagName' => 'script' ), $inner ) ), '<section ' ), 'unknown tag → section' );
}

function test_heading_tag_changes_only_the_main_heading() {
	$head = bwe_tb_gen( 'bwe/section-head', array( 'eyebrow' => 'E', 'title' => 'Big <em>title</em>', 'headingTag' => 'h1' ) );
	bwe_tb_assert_true( false !== strpos( $head, '<h1 class="elementor-heading-title">Big <em>title</em></h1>' ) && false === strpos( $head, '<h2' ), 'section head as h1, classes kept' );
	$hero = bwe_tb_gen( 'bwe/hero', array( 'title' => 'T', 'btn1Text' => 'B', 'animate' => false, 'headingTag' => 'h2' ) );
	bwe_tb_assert_true( false !== strpos( $hero, '<h2 class="wp-block-heading elementor-heading-title bwe-hero__title">T</h2>' ), 'hero heading as h2' );
	$spec = bwe_tb_gen( 'bwe/spec-card', array( 'name' => 'Speed', 'text' => 'Fast', 'headingTag' => 'h3' ) );
	bwe_tb_assert_true( false !== strpos( $spec, '<h3 class="bwex-spec__name">Speed</h3>' ), 'spec card name as h3' );
	$step = bwe_tb_gen( 'bwe/step', array( 'title' => 'One $1 step', 'text' => 'x', 'headingTag' => 'p' ) );
	bwe_tb_assert_true( false !== strpos( $step, '>One $1 step</p>' ) && false === strpos( $step, '<h3' ), 'step title as p ($1 kept literally)' );
	$bad = bwe_tb_gen( 'bwe/section-head', array( 'title' => 'T', 'headingTag' => 'script' ) );
	bwe_tb_assert_true( false !== strpos( $bad, '<h2 ' ) && false === strpos( $bad, '<script' ), 'unknown tag ignored' );
	bwe_tb_assert_same( bwe_tb_gen( 'bwe/section-head', array( 'title' => 'T' ) ), bwe_tb_gen( 'bwe/section-head', array( 'title' => 'T', 'headingTag' => '' ) ), 'empty = unchanged' );
}

function test_visibility_classes_on_first_element() {
	$html = bwe_tb_gen( 'bwe/gap', array( 'bweHide' => array( 'desktop' => true, 'mobile' => true ), 'bweStyle' => array( 'height' => '10px' ) ) );
	bwe_tb_assert_true( 0 === strpos( $html, '<style>' ), 'the style element stays first' );
	bwe_tb_assert_true( 1 === preg_match( '#<div class="bwe-gw-gap [^"]*bwe-hide-d bwe-hide-m"#', $html ), 'hide classes on the block element, not on <style>' );
	$hero = bwe_tb_gen( 'bwe/hero', array( 'title' => 'T', 'btn1Text' => 'B', 'animate' => false, 'bweHide' => array( 'tablet' => true ) ) );
	bwe_tb_assert_true( 1 === preg_match( '#^<div class="wp-block-group elementor-element [^"]*bwe-hide-t"#', trim( $hero ) ), 'hero hides with its own wrappers' );
	bwe_tb_assert_same( bwe_tb_gen( 'bwe/gap' ), bwe_tb_gen( 'bwe/gap', array( 'bweHide' => array() ) ), 'nothing hidden = unchanged' );
}

function test_blocks_css_only_where_needed() {
	$home = get_post( 1104 );
	// Home has no general-purpose blocks; it loads blocks.css only for a slider (products phone slider, Testimonials).
	$slider = $home && 1 === preg_match( '#"phoneLayout":"slider"|<!-- wp:bwe/testimonials[\s/]#', $home->post_content );
	bwe_tb_assert_true( $home && $slider === bwe_gw_needs_blocks_css( 1104 ), 'Home loads blocks.css only when it uses the phone slider' );
}

function test_manifest_matches_block_json() {
	$manifest = bwe_blocks_manifest();
	bwe_tb_assert_true( count( $manifest ) === count( glob( BWE_GW_DIR . '/build/blocks/*/block.json' ) ), 'manifest has every built block' );
	$same = true;
	foreach ( $manifest as $dir => $meta ) {
		$json = json_decode( (string) file_get_contents( BWE_GW_DIR . "/build/blocks/$dir/block.json" ), true );
		$same = $same && ( $json['bweStyleMap'] ?? array() ) === ( $meta['bweStyleMap'] ?? array() ) && bwe_gw_style_map( BWE_GW_DIR . "/build/blocks/$dir" ) === ( $json['bweStyleMap'] ?? array() );
	}
	bwe_tb_assert_true( $same, 'style maps from the manifest = block.json' );
}

function test_blocks_share_one_editor_script() {
	$handles = array();
	foreach ( WP_Block_Type_Registry::get_instance()->get_all_registered() as $name => $type ) {
		if ( 0 === strpos( $name, 'bwe/' ) ) {
			$handles = array_merge( $handles, (array) $type->editor_script_handles );
		}
	}
	bwe_tb_assert_same( 'bwe-gw-editor', implode( ',', array_unique( $handles ) ), 'every block uses the one editor bundle' );
	bwe_tb_assert_true( wp_script_is( 'bwe-gw-editor', 'registered' ), 'bundle registered' );
}
