<?php
/**
 * Home section blocks (2026-11-23): Why us, Testimonials (+ video card), Pricing (+ price plans, starting prices,
 * cost explainer), How it works, Our products (+ product card), FAQ, Call to action.
 * - the converted Home patterns render exactly like the originals;
 * - a freshly inserted block (defaults, template items) renders cleanly;
 * - show/hide settings, the FAQ "Show N more" button, style settings and the readers mode work.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/home-sections.php';

/**
 * Converts every Home section in a block document (as convert.php does).
 *
 * @param string $markup Serialized blocks.
 * @return array{0: string, 1: int} [ new markup, converted count ]
 */
function bwe_tb_hsx_convert_doc( string $markup ): array {
	$count = 0;
	$walk  = static function ( array $blocks ) use ( &$walk, &$count ): array {
		foreach ( $blocks as $i => $block ) {
			if ( empty( $block['blockName'] ) ) {
				continue;
			}
			$new = bwe_tb_convert_home_sections( $block );
			if ( is_array( $new ) ) {
				$blocks[ $i ] = $new;
				++$count;
			} elseif ( null === $new && $block['innerBlocks'] ) {
				$blocks[ $i ]['innerBlocks'] = $walk( $block['innerBlocks'] );
			}
		}
		return $blocks;
	};
	return array( serialize_blocks( $walk( parse_blocks( $markup ) ) ), $count );
}

/**
 * Renders block markup and records PHP warnings/notices raised meanwhile.
 *
 * @param string $markup Serialized blocks.
 * @return array{0: string, 1: string[]} [ html, problems ]
 */
function bwe_tb_hsx_render_clean( string $markup ): array {
	$problems = array();
	set_error_handler(
		static function ( $no, $msg, $file, $line ) use ( &$problems ) {
			$problems[] = "$msg ($file:$line)";
			return true;
		}
	);
	try {
		$html = bwe_tb_render_raw( $markup );
	} finally {
		restore_error_handler();
	}
	return array( $html, $problems );
}

function test_home_sections_render_like_the_originals() {
	$expect = array(
		1228 => 'bwe/plans',
		1355 => 'bwe/why-us',
		1356 => 'bwe/testimonials',
		1357 => 'bwe/pricing',
		1359 => 'bwe/process',
		1360 => 'bwe/products',
		1362 => 'bwe/faq',
		1363 => 'bwe/cta',
	);
	foreach ( $expect as $id => $name ) {
		$old             = file_get_contents( __DIR__ . "/fixtures/old-home-$id.html" );
		[ $new, $count ] = bwe_tb_hsx_convert_doc( $old );
		bwe_tb_assert_true( 1 === $count && false !== strpos( $new, '<!-- wp:' . $name . ' ' ), "pattern $id → $name" );
		bwe_tb_assert_same( bwe_tb_expected( "home-section-$id", $old ), bwe_tb_without_slider( bwe_tb_render( $new ) ), "pattern $id renders identically" );
	}
}

function test_home_sections_converter_keeps_items() {
	[ $new ] = bwe_tb_hsx_convert_doc( file_get_contents( __DIR__ . '/fixtures/old-home-1362.html' ) );
	$faq     = parse_blocks( $new )[0];
	bwe_tb_assert_same( '12', (string) count( $faq['innerBlocks'] ), 'FAQ keeps its 12 questions' );
	bwe_tb_assert_same( '', (string) ( $faq['attrs']['toggleText'] ?? '' ), '"Show 6 more questions" = the automatic label' );
	[ $new ] = bwe_tb_hsx_convert_doc( file_get_contents( __DIR__ . '/fixtures/old-home-1228.html' ) );
	$plans   = parse_blocks( $new )[0];
	bwe_tb_assert_same( 'false,true,false', implode( ',', array_map( static fn( $p ) => empty( $p['attrs']['featured'] ) ? 'false' : 'true', $plans['innerBlocks'] ) ), 'only Growth is featured' );
	bwe_tb_assert_same( 'core/list', $plans['innerBlocks'][0]['innerBlocks'][0]['blockName'], 'a plan keeps its feature list as a List block' );
}

function test_home_sections_fresh_blocks_render_cleanly() {
	$fresh = array(
		'why-us'       => '<!-- wp:bwe/why-us {"intro":"Intro"} --><!-- wp:bwe/spec-card {"name":"Speed","text":"Fast."} /--><!-- /wp:bwe/why-us -->',
		'testimonials' => '<!-- wp:bwe/testimonials --><!-- wp:bwe/video-card {"url":"https://www.youtube.com/shorts/LlD2xDq5z_c","who":"<strong>Ann</strong> · Shop"} /--><!-- wp:bwe/video-card /--><!-- /wp:bwe/testimonials -->',
		'pricing'      => '<!-- wp:bwe/pricing --><!-- wp:bwe/plans --><!-- wp:bwe/price-plan {"name":"Basic","price":"$1 <em>/ mo</em>","btnText":"Buy"} --><!-- wp:list {"className":"bwex-checks"} --><ul class="wp-block-list bwex-checks"><!-- wp:list-item --><li>One</li><!-- /wp:list-item --></ul><!-- /wp:list --><!-- /wp:bwe/price-plan --><!-- wp:bwe/price-plan {"featured":true,"name":"Pro"} /--><!-- /wp:bwe/plans --><!-- wp:bwe/starting-prices /--><!-- wp:bwe/cost-panel {"items":[{"text":"<strong>A.</strong> b"}]} /--><!-- /wp:bwe/pricing -->',
		'process'      => '<!-- wp:bwe/process --><!-- wp:bwe/step {"n":"01","title":"Call","text":"Talk."} /--><!-- /wp:bwe/process -->',
		'products'     => '<!-- wp:bwe/products --><!-- wp:bwe/product-card {"name":"X"} /--><!-- wp:bwe/product-card {"art":"image","imageUrl":"https://example.com/a.png","name":"Y"} /--><!-- wp:bwe/product-card {"art":"none","name":"Z"} /--><!-- /wp:bwe/products -->',
		'faq'          => '<!-- wp:bwe/faq --><!-- wp:bwe/faq-item {"question":"Q?"} --><!-- wp:paragraph --><p>A.</p><!-- /wp:paragraph --><!-- /wp:bwe/faq-item --><!-- /wp:bwe/faq -->',
		'cta'          => '<!-- wp:bwe/cta /-->',
	);
	$roots = array(
		'why-us'       => 'bwex-spec',
		'testimonials' => 'bwex-proof',
		'pricing'      => 'bwex-pricing',
		'process'      => 'bwex-process',
		'products'     => 'bwex-work',
		'faq'          => 'bwex-faq-section',
		'cta'          => 'bwe-final',
	);
	foreach ( $fresh as $slug => $markup ) {
		[ $html, $problems ] = bwe_tb_hsx_render_clean( $markup );
		bwe_tb_assert_same( '', implode( ' | ', $problems ), "fresh $slug: no PHP warnings" );
		bwe_tb_assert_true( false !== strpos( $html, $roots[ $slug ] ) && false === strpos( $html, '<!-- wp:' ), "fresh $slug renders its section" );
	}
	[ $html ] = bwe_tb_hsx_render_clean( $fresh['testimonials'] );
	bwe_tb_assert_true( false !== strpos( $html, 'data-yt="LlD2xDq5z_c"' ), 'video card: YouTube link → click-to-play thumbnail' );
	[ $html ] = bwe_tb_hsx_render_clean( $fresh['products'] );
	bwe_tb_assert_true( false !== strpos( $html, 'bwe-work__art--reels' ) && false !== strpos( $html, 'bwe-work__art--image"><img src="https://example.com/a.png"' ), 'product card: mockup and own image' );
	bwe_tb_assert_same( '2', (string) substr_count( $html, 'class="bwe-work__art ' ), 'product card "No picture" prints no picture' );
	[ $html ] = bwe_tb_hsx_render_clean( $fresh['pricing'] );
	bwe_tb_assert_true( false !== strpos( $html, 'bwex-plan bwex-plan--featured' ) && false !== strpos( $html, '<p class="bwex-plan__badge wp-block-paragraph">Most popular</p>' ), 'featured plan gets its class and badge' );
	bwe_tb_assert_true( false !== strpos( $html, 'WooCommerce store' ), 'starting prices: default rows' );
}

function test_home_sections_product_image_fit() {
	$card     = static fn( string $attrs ) => '<!-- wp:bwe/products --><!-- wp:bwe/product-card {"art":"image","imageUrl":"https://example.com/a.png","name":"Y"' . $attrs . '} /--><!-- /wp:bwe/products -->';
	[ $html ] = bwe_tb_hsx_render_clean( $card( '' ) );
	bwe_tb_assert_true( false !== strpos( $html, 'style="width:100%;height:100%;object-fit:cover"' ), 'image fit: cover by default' );
	[ $html ] = bwe_tb_hsx_render_clean( $card( ',"imageFit":"contain","imagePosition":"center top","imagePadding":24' ) );
	bwe_tb_assert_true( false !== strpos( $html, 'style="width:100%;height:100%;object-fit:contain;object-position:center top;padding:24px;box-sizing:border-box"' ), 'image fit: contain, top, 24px space' );
	[ $html ] = bwe_tb_hsx_render_clean( $card( ',"imageFit":"bad;x","imagePosition":"evil\"><script>"' ) );
	bwe_tb_assert_true( false !== strpos( $html, 'object-fit:cover"' ) && false === strpos( $html, '<script>' ), 'image fit: bad values fall back' );
}

function test_home_sections_show_hide_settings() {
	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/why-us {"aside":"Line","showAside":false,"showEyebrow":false,"intro":"I","showIntro":false} /-->' );
	bwe_tb_assert_true( false === strpos( $html, 'bwex-spec__foot' ) && false === strpos( $html, 'bwex-eyebrow' ) && false === strpos( $html, 'bwex-intro' ), 'why us: line, eyebrow and intro hidden' );
	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/cta {"showBtn2":false,"showChat":false,"showNote":false} /-->' );
	bwe_tb_assert_true( false === strpos( $html, 'bwe-btn--ghost' ) && false === strpos( $html, 'bwe-final__chat' ) && false === strpos( $html, 'bwe-final__note' ) && false !== strpos( $html, 'bwe-btn--primary' ), 'CTA: second button, chat line and note hidden' );
	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/cta /-->' );
	bwe_tb_assert_true( false !== strpos( $html, 'data-bwe-chat=' ) && false !== strpos( $html, 'bwe-final__dot' ), 'CTA: chat link opens the live chat' );
	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/products {"more":"M","showMore":false} --><!-- wp:bwe/product-card {"name":"X","links":"<a href=\"/a\">A</a>","showLinks":false} /--><!-- /wp:bwe/products -->' );
	bwe_tb_assert_true( false === strpos( $html, 'bwex-more' ) && false === strpos( $html, 'bwex-card__links' ), 'products: line and demo links hidden' );
}

function test_home_sections_faq_show_more_button() {
	$item     = static fn( bool $extra ) => '<!-- wp:bwe/faq-item {"question":"Q"' . ( $extra ? ',"extra":true' : '' ) . '} --><!-- wp:paragraph --><p>A</p><!-- /wp:paragraph --><!-- /wp:bwe/faq-item -->';
	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/faq --> ' . $item( false ) . $item( false ) . ' <!-- /wp:bwe/faq -->' );
	bwe_tb_assert_true( false === strpos( $html, 'bwex-faq__toggle' ), 'no hidden questions → no button' );
	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/faq {"listId":"my-faq"} --> ' . $item( false ) . $item( true ) . ' <!-- /wp:bwe/faq -->' );
	bwe_tb_assert_true( false !== strpos( $html, 'aria-controls="my-faq"' ) && false !== strpos( $html, '>Show 1 more question</button>' ), 'one hidden question → "Show 1 more question"' );
	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/faq {"toggleText":"See {n} extra"} --> ' . $item( true ) . $item( true ) . ' <!-- /wp:bwe/faq -->' );
	bwe_tb_assert_true( false !== strpos( $html, '>See 2 extra</button>' ), 'own button text with {n}' );
}

function test_home_sections_style_settings() {
	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/testimonials {"bweStyle":{"bgColor":"#ff0000","columns":"2","titleColor":"#00ff00"}} --><!-- wp:bwe/video-card /--><!-- /wp:bwe/testimonials -->' );
	bwe_tb_assert_true( 1 === preg_match( '/<section id="testimonials" class="[^"]*bwex-proof[^"]* (bwe-s-[0-9a-f]{10})"/', $html, $m ), 'section gets a bwe-s-* class' );
	$scope = 'html body .' . ( $m[1] ?? 'x' ) . ':not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c)';
	bwe_tb_assert_true( false !== strpos( $html, $scope . '{background-color:#ff0000!important}' ), 'background colour rule' );
	bwe_tb_assert_true( false !== strpos( $html, $scope . ' .bwex-h2 h2{color:#00ff00!important}' ), 'heading colour rule' );
	bwe_tb_assert_true( false !== strpos( $html, '@media (min-width:1025px){' . $scope . ' .bwex-quotes{grid-template-columns:repeat(2, minmax(0, 1fr))!important;display:grid!important}' ), 'desktop columns rule' );
	// Items per row (2026-11-24): narrower cards may wrap their buttons instead of letting them stick out.
	bwe_tb_assert_true( 1 === preg_match( '/@media \(min-width:1025px\)\{[^@]*' . preg_quote( $scope . ' .bwex-quotes :is(.wp-block-button__link, .elementor-button, .bwex-card__btn){white-space:normal!important', '/' ) . '/', $html ), 'desktop columns: item buttons may wrap' );
	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/cta {"bweIcon":{"source":"none"}} /-->' );
	bwe_tb_assert_true( 1 === preg_match( '/bwe-i-[0-9a-f]{10}:not\(#bwe-gw-a\):not\(#bwe-gw-b\):not\(#bwe-gw-c\) p\.bwe-eyebrow::before\{display:none!important\}/', $html ), 'eyebrow icon setting' );
}

function test_home_sections_readers_mode() {
	$GLOBALS['bwe_gw_readers'] = true;
	try {
		$html = render_block( parse_blocks( '<!-- wp:bwe/video-card {"url":"https://www.youtube.com/shorts/LlD2xDq5z_c","who":"Ann"} /-->' )[0] );
		$card = render_block( parse_blocks( '<!-- wp:bwe/product-card {"name":"X"} /-->' )[0] );
	} finally {
		$GLOBALS['bwe_gw_readers'] = null;
	}
	bwe_tb_assert_true( false !== strpos( $html, "\nhttps://www.youtube.com/shorts/LlD2xDq5z_c\n" ) && false === strpos( $html, 'bwex-yt' ), 'readers: the saved embed (link), no thumbnail' );
	bwe_tb_assert_true( false === strpos( $card, 'bwe-work__art' ), 'readers: no mockup words' );
}

function test_products_phone_slider() {
	$cards = '<!-- wp:bwe/product-card {"name":"X"} /--><!-- wp:bwe/product-card {"name":"Y"} /--><!-- wp:bwe/product-card {"name":"Z"} /-->';

	[ $list ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/products -->' . $cards . '<!-- /wp:bwe/products -->' );
	bwe_tb_assert_true( false === strpos( $list, 'bwe-ms' ) && false === strpos( $list, 'wp-block-group wp-block-group' ) && false !== strpos( $list, '<div class="wp-block-group elementor-element elementor-element-923a8b6 e-con-full bwex-cards e-flex e-con e-child">' ), 'products: default phone layout is the list (markup unchanged)' );

	[ $html, $problems ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/products {"phoneLayout":"slider"} -->' . $cards . '<!-- /wp:bwe/products -->' );
	bwe_tb_assert_same( '', implode( '; ', $problems ), 'products slider: renders without notices' );
	bwe_tb_assert_true( false !== strpos( $html, 'bwex-cards e-flex e-con e-child bwe-ms bwe-ms--m" style="--bwe-ms-w:85%"' ), 'products slider: list gets the phone slider classes and slide width' );
	bwe_tb_assert_same( '3', (string) substr_count( $html, 'class="bwe-ms__dot"' ), 'products slider: one dot per card' );
	bwe_tb_assert_true( false !== strpos( $html, 'aria-label="Card 1 of 3" aria-current="true"' ), 'products slider: first dot is current' );
	bwe_tb_assert_true( false !== strpos( $html, 'bwe-ms__arrow--prev" aria-label="Previous card" disabled' ) && false !== strpos( $html, 'bwe-ms__arrow--next' ), 'products slider: arrows, previous disabled at the start' );
	bwe_tb_assert_true( wp_script_is( 'bwe-gw-mobile-slider', 'enqueued' ), 'products slider: script queued' );

	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/products {"phoneLayout":"slider","sliderTablet":true,"slideWidth":120,"sliderDots":false} -->' . $cards . '<!-- /wp:bwe/products -->' );
	bwe_tb_assert_true( false !== strpos( $html, 'bwe-ms bwe-ms--t" style="--bwe-ms-w:100%"' ) && false !== strpos( $html, 'bwe-ms__nav--t' ), 'products slider: tablets too, width capped at 100%' );
	bwe_tb_assert_true( false === strpos( $html, 'bwe-ms__dot' ) && false !== strpos( $html, 'bwe-ms__arrows' ), 'products slider: dots off, arrows stay' );

	[ $html ] = bwe_tb_hsx_render_clean( '<!-- wp:bwe/products {"phoneLayout":"slider","sliderDots":false,"sliderArrows":false} -->' . $cards . '<!-- /wp:bwe/products -->' );
	bwe_tb_assert_true( false !== strpos( $html, 'bwe-ms--m' ) && false === strpos( $html, 'bwe-ms__nav' ), 'products slider: no dots and no arrows → no nav row, still swipes' );

	bwe_tb_assert_true( 1 === preg_match( '#"phoneLayout":"slider"#', '<!-- wp:bwe/products {"phoneLayout":"slider"} -->' ) && function_exists( 'bwe_gw_needs_blocks_css' ), 'slider pages load blocks.css' );
}

function test_testimonials_slider() {
	$block = static fn( int $n, string $attrs = '' ): string => '<!-- wp:bwe/testimonials ' . $attrs . ' -->' . str_repeat( '<!-- wp:bwe/video-card {"url":"https://www.youtube.com/shorts/LlD2xDq5z_c"} /-->', $n ) . '<!-- /wp:bwe/testimonials -->';

	[ $html, $problems ] = bwe_tb_hsx_render_clean( $block( 3 ) );
	bwe_tb_assert_same( '', implode( '; ', $problems ), 'testimonials slider: renders without notices' );
	bwe_tb_assert_true( false !== strpos( $html, 'bwex-quotes bwe-ms bwe-ms--m" style="--bwe-ms-w:72%"' ) && false === strpos( $html, 'bwe-ms--d' ), 'testimonials: 3 videos slide on phones only' );

	[ $html ] = bwe_tb_hsx_render_clean( $block( 4 ) );
	bwe_tb_assert_true( false !== strpos( $html, 'bwe-ms bwe-ms--m bwe-ms--d" style="--bwe-ms-w:72%;--bwe-ms-n:3"' ) && false !== strpos( $html, 'bwe-ms__nav bwe-ms__nav--m bwe-ms__nav--d' ), 'testimonials: 4 videos slide on desktop too' );
	bwe_tb_assert_same( '4', (string) substr_count( $html, 'class="bwe-ms__dot"' ), 'testimonials: one dot per video' );

	[ $html ] = bwe_tb_hsx_render_clean( $block( 4, '{"desktopSlides":4}' ) );
	bwe_tb_assert_true( false === strpos( $html, 'bwe-ms--d' ), 'testimonials: 4 in view, 4 videos, no desktop slider' );

	[ $html ] = bwe_tb_hsx_render_clean( $block( 5, '{"desktopSlider":false}' ) );
	bwe_tb_assert_true( false === strpos( $html, 'bwe-ms--d' ) && false !== strpos( $html, 'bwe-ms--m' ), 'testimonials: desktop slider off' );

	[ $html ] = bwe_tb_hsx_render_clean( $block( 5, '{"phoneLayout":"list"}' ) );
	bwe_tb_assert_true( false !== strpos( $html, 'bwex-quotes bwex-quotes--list bwe-ms bwe-ms--d" style="--bwe-ms-n:3"' ) && false !== strpos( $html, 'bwe-ms__nav bwe-ms__nav--d"' ), 'testimonials: phone list, desktop slider' );

	[ $html ] = bwe_tb_hsx_render_clean( $block( 3, '{"phoneLayout":"list"}' ) );
	bwe_tb_assert_true( false !== strpos( $html, '<div class="wp-block-group bwex-quotes bwex-quotes--list">' ) && false === strpos( $html, 'bwe-ms' ), 'testimonials: plain list' );
}
