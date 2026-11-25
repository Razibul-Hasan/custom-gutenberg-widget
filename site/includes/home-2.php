<?php
/**
 * Home 2 (/home-2/): a Gutenberg copy of the Elementor Home (517).
 *
 * The page content is ordinary blocks (groups, headings, paragraphs, lists, details)
 * that carry the same classes as Home, so the same stylesheets style it:
 * - BWE Elementor's base + widget CSS and home.css (registered by the BWE Elementor plugin),
 * - Elementor's frontend CSS for the container grid,
 * - assets/home-2/layout.css + kit.css: a snapshot of Home's generated Elementor CSS
 *   (uploads/elementor/css/post-517.css and post-989.css). Re-copy it if Home's layout changes.
 * The root group carries the marker class bwe-h2x. Converter: tools/home-2/convert.php.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * Is the current request a page built from the Home 2 copy?
 *
 * @return bool
 */
function bwe_h2x_is_page() {
	return ! is_admin() && bwe_home_is_needed( 'bwe-h2x' );
}

/**
 * Home's stylesheets, in Home's order. Used on the front end and inside the block editor.
 */
function bwe_h2x_enqueue_styles() {
	// Self-contained since 2026-11-13: Elementor, Pro Elements and BWE Elementor were removed from the site,
	// so their files (recovered byte-for-byte) live in assets/home-2/. Same order as the old Elementor Home.
	$dir  = BWE_HOME_DIR . '/assets/home-2/';
	$url  = plugins_url( 'assets/home-2/', BWE_HOME_DIR . '/site.php' );
	$ver  = static function ( $rel ) use ( $dir ) {
		return (string) filemtime( $dir . $rel );
	};
	$home = wp_style_is( 'bwe-home', 'registered' ) ? array( 'bwe-home' ) : array();

	wp_enqueue_style( 'bwe-h2x-base', $url . 'css/base.min.css', $home, $ver( 'css/base.min.css' ) );
	foreach ( glob( $dir . 'css/widgets/*.css' ) as $file ) {
		$rel = 'css/widgets/' . basename( $file );
		wp_enqueue_style( 'bwe-h2x-' . basename( $file, '.min.css' ), $url . $rel, array( 'bwe-h2x-base' ), $ver( $rel ) );
	}
	wp_enqueue_style( 'bwe-h2x-elementor', $url . 'css/elementor-frontend.min.css', array( 'bwe-h2x-base' ), $ver( 'css/elementor-frontend.min.css' ) );
	wp_add_inline_style( 'bwe-h2x-elementor', (string) file_get_contents( $dir . 'css/elementor-inline.css' ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local file.
	foreach ( array( 'kit', 'layout' ) as $name ) {
		wp_enqueue_style( 'bwe-h2x-' . $name, $url . $name . '.css', array( 'bwe-h2x-elementor' ), $ver( $name . '.css' ) );
	}

	// Minimal layer (2026-11-13): header-style hero buttons + phone hairline rows. Delete the file to revert.
	if ( is_readable( $dir . 'minimal.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-minimal', $url . 'minimal.css', array( 'bwe-h2x-layout' ), $ver( 'minimal.css' ) );
	}

	// "Free reality check" compact (2026-11-13): heading row + 5 short icon tiles. Delete the file to revert.
	if ( is_readable( $dir . 'signs.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-signs', $url . 'signs.css', array( 'bwe-h2x-layout' ), $ver( 'signs.css' ) );
	}

	// "How much does a website really cost?" dark panel + icon tiles (2026-11-13). Delete the file to revert.
	if ( is_readable( $dir . 'cost.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-cost', $url . 'cost.css', array( 'bwe-h2x-layout' ), $ver( 'cost.css' ) );
	}

	// "Hiring checklist" (#choose) compact checklist card (2026-11-13). Delete the file to revert.
	if ( is_readable( $dir . 'check.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-check', $url . 'check.css', array( 'bwe-h2x-layout' ), $ver( 'check.css' ) );
	}

	// Home v4 (2026-11-13): "Our services" as 2 skill columns (WordPress, Shopify). Delete the file to revert.
	if ( is_readable( $dir . 'v4.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-v4', $url . 'v4.css', array( 'bwe-h2x-layout' ), $ver( 'v4.css' ) );
	}

	// "Why BestWebExpert" (#spec) as a minimal bento grid (2026-11-17). Delete the file to revert.
	if ( is_readable( $dir . 'spec.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-spec', $url . 'spec.css', array( 'bwe-h2x-layout' ), $ver( 'spec.css' ) );
	}

	// "How it works" (#process) as four glass cards with a connecting line (2026-11-17). Delete the file to revert.
	if ( is_readable( $dir . 'process.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-process', $url . 'process.css', array( 'bwe-h2x-layout' ), $ver( 'process.css' ) );
	}

	// SEO plan (2026-11-19): service icons, testimonials review links and FAQ answer lists. Delete the file to revert.
	if ( is_readable( $dir . 'seo-plan.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-seo-plan', $url . 'seo-plan.css', array( 'bwe-h2x-layout' ), $ver( 'seo-plan.css' ) );
	}

	// Off-white hero (2026-11-19): same design, light background, grid kept. Delete the file to revert.
	if ( is_readable( $dir . 'hero-light.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-hero-light', $url . 'hero-light.css', array( 'bwe-h2x-layout' ), $ver( 'hero-light.css' ) );
	}

	// Palette (2026-11-19): off-white, white, ash gray, lime; no dark bands. Delete the file to revert.
	if ( is_readable( $dir . 'palette.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-palette', $url . 'palette.css', array( 'bwe-h2x-hero-light' ), $ver( 'palette.css' ) );
	}

	// Spacing scale (2026-11-19): shared gutter, section padding, head and card gaps. Delete the file to revert.
	if ( is_readable( $dir . 'spacing.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-spacing', $url . 'spacing.css', array( 'bwe-h2x-layout', 'bwe-h2x-palette' ), $ver( 'spacing.css' ) );
	}

	// Phones (2026-11-19): tighter rhythm, 48px tap targets. Delete the file to revert.
	if ( is_readable( $dir . 'mobile.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-mobile', $url . 'mobile.css', array( 'bwe-h2x-spacing' ), $ver( 'mobile.css' ) );
	}

	// Sell pass (2026-11-20): dark-grid "How it works", Growth plan and closing CTA. Delete the file to revert.
	if ( is_readable( $dir . 'sell.css' ) ) {
		$sell_deps = array_values( array_filter( array( 'bwe-h2x-layout', 'bwe-h2x-palette', 'bwe-h2x-mobile' ), 'wp_style_is' ) );
		wp_enqueue_style( 'bwe-h2x-sell', $url . 'sell.css', $sell_deps, $ver( 'sell.css' ) );
	}

	// "Our services" cards like old-bestwebexpert.local (2026-11-20). Delete the file to revert.
	if ( is_readable( $dir . 'services-old.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-services-old', $url . 'services-old.css', array_values( array_filter( array( 'bwe-h2x-seo-plan', 'bwe-h2x-sell', 'bwe-h2x-mobile' ), 'wp_style_is' ) ), $ver( 'services-old.css' ) );
	}

	// Section labels with a lime icon chip, like the old site (2026-11-20). Delete the file to revert.
	if ( is_readable( $dir . 'eyebrow-icons.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-eyebrow-icons', $url . 'eyebrow-icons.css', array_values( array_filter( array( 'bwe-h2x-sell', 'bwe-h2x-mobile', 'bwe-h2x-services-old' ), 'wp_style_is' ) ), $ver( 'eyebrow-icons.css' ) );
	}

	// About "Read more" pill button + numbered text (2026-11-20). Delete the file to revert.
	if ( is_readable( $dir . 'about.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-about', $url . 'about.css', array_values( array_filter( array( 'bwe-h2x-sell', 'bwe-h2x-mobile', 'bwe-h2x-eyebrow-icons' ), 'wp_style_is' ) ), $ver( 'about.css' ) );
	}

	// "How it works": big outlined step numbers + lime icon tiles (2026-11-20). Delete the file to revert.
	if ( is_readable( $dir . 'process-num.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-process-num', $url . 'process-num.css', array_values( array_filter( array( 'bwe-h2x-process', 'bwe-h2x-palette', 'bwe-h2x-sell', 'bwe-h2x-mobile' ), 'wp_style_is' ) ), $ver( 'process-num.css' ) );
	}

	// Pricing "starting prices" card with price chips (2026-11-20). Delete the file to revert the look.
	if ( is_readable( $dir . 'pricenote.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-pricenote', $url . 'pricenote.css', array_values( array_filter( array( 'bwe-h2x-palette', 'bwe-h2x-sell', 'bwe-h2x-mobile' ), 'wp_style_is' ) ), $ver( 'pricenote.css' ) );
	}

	// Eye-catching hero (2026-11-20): same dark grid + colour glows, lit cells, a lime grid spotlight
	// that drifts (follows the cursor on desktop via js/hero-glow.js). Delete the file to revert.
	if ( is_readable( $dir . 'hero-glow.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-hero-glow', $url . 'hero-glow.css', array_values( array_filter( array( 'bwe-h2x-hero-light', 'bwe-h2x-palette', 'bwe-h2x-sell', 'bwe-h2x-mobile', 'bwe-h2x-about' ), 'wp_style_is' ) ), $ver( 'hero-glow.css' ) );
		if ( is_readable( $dir . 'js/hero-glow.js' ) ) {
			wp_enqueue_script( 'bwe-h2x-hero-glow', $url . 'js/hero-glow.js', array(), $ver( 'js/hero-glow.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
		}
	}

	// Light-beams alternative (tried 2026-11-20, owner went back to hero-glow): files are
	// hero-beams.css.off / js/hero-beams.js.off, so this block stays inactive unless renamed back.
	if ( is_readable( $dir . 'hero-beams.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-hero-beams', $url . 'hero-beams.css', array_values( array_filter( array( 'bwe-h2x-hero-light', 'bwe-h2x-palette', 'bwe-h2x-sell', 'bwe-h2x-mobile', 'bwe-h2x-about' ), 'wp_style_is' ) ), $ver( 'hero-beams.css' ) );
		if ( is_readable( $dir . 'js/hero-beams.js' ) ) {
			wp_enqueue_script( 'bwe-h2x-hero-beams', $url . 'js/hero-beams.js', array(), $ver( 'js/hero-beams.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
		}
	}

	// Home-style section library extras (2026-11-21): default eyebrow icons, text sections.
	if ( is_readable( $dir . 'sections.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-sections', $url . 'sections.css', array_values( array_filter( array( 'bwe-h2x-palette', 'bwe-h2x-sell', 'bwe-h2x-mobile', 'bwe-h2x-eyebrow-icons' ), 'wp_style_is' ) ), $ver( 'sections.css' ) );
	}

	// Portfolio "Selected work" gallery (2026-11-22, synced pattern on /portfolio/ #work). Loads on every
	// section page + the editor, like sections.css, so the pattern can be dropped onto any page.
	if ( is_readable( $dir . 'work.css' ) ) {
		wp_enqueue_style( 'bwe-h2x-work', $url . 'work.css', array_values( array_filter( array( 'bwe-h2x-sections' ), 'wp_style_is' ) ), $ver( 'work.css' ) );
	}
	// v2 rows: the hovered row's screenshot follows the cursor (front end, only where the gallery is used).
	if ( ! is_admin() && is_readable( $dir . 'js/work.js' ) && bwe_home_is_needed( 'bwex-work__grid' ) ) {
		wp_enqueue_script( 'bwe-h2x-work', $url . 'js/work.js', array(), $ver( 'js/work.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
	}

	// Pricing page (839, root class bwe-prx) rebuilt from Home sections 2026-11-21: price-list rows etc.
	if ( is_readable( $dir . 'pricing.css' ) && ( is_admin() || bwe_home_is_needed( 'bwe-prx' ) ) ) {
		wp_enqueue_style( 'bwe-h2x-pricing', $url . 'pricing.css', array_values( array_filter( array( 'bwe-h2x-palette', 'bwe-h2x-sell', 'bwe-h2x-mobile', 'bwe-h2x-pricenote', 'bwe-h2x-eyebrow-icons' ), 'wp_style_is' ) ), $ver( 'pricing.css' ) );
	}

	// Astra pads full-width groups (48px); Home's Elementor root had none.
	wp_add_inline_style( 'bwe-h2x-layout', '.bwe-h2x.wp-block-group.alignfull{padding:0!important;margin:0!important;max-width:none!important}' );
}

/**
 * Which Home-style editor setup the post being edited needs: 'page' (content built from Home's
 * sections, marker bwe-h2x), 'pattern' (a synced pattern holding Home section parts) or ''.
 */
function bwe_h2x_editor_mode() {
	global $pagenow;
	// Appearance → Design (site editor): on this classic theme it only edits patterns, which are Home sections.
	if ( 'site-editor.php' === $pagenow ) {
		return 'page';
	}
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only, only decides which styles load.
	if ( ! $post_id ) {
		// Any other block-editor screen (new page/post, Design → Patterns however it is opened, pattern
		// previews): load Home's styles so every pattern preview and insert looks like the site.
		return 'page';
	}
	$content = (string) get_post_field( 'post_content', $post_id );
	if ( 'wp_block' === get_post_type( $post_id ) ) {
		// Section patterns carry their own root wrappers (bwe-h2x): just load the styles. Bare parts (the price
		// plans) need the wrappers added to the canvas ('pattern').
		if ( false !== strpos( $content, 'bwe-h2x' ) ) {
			return 'page';
		}
		return false !== strpos( $content, 'bwex-' ) ? 'pattern' : '';
	}
	// Every page (not only those already built from Home's sections), so patterns preview and insert styled.
	// Shop pages built with WooCommerce blocks keep the plain editor.
	if ( in_array( get_post_type( $post_id ), array( 'page', 'post' ), true ) && ! has_block( 'woocommerce/checkout', $post_id ) && ! has_block( 'woocommerce/cart', $post_id ) && false === strpos( $content, 'bwe-demo' ) ) {
		return 'page';
	}
	return false !== strpos( $content, 'bwe-h2x' ) ? 'page' : '';
}

/**
 * Same styles and motion scripts as Home.
 */
function bwe_h2x_enqueue_assets() {
	if ( ! bwe_h2x_is_page() ) {
		return;
	}

	bwe_h2x_enqueue_styles();

	$dir = BWE_HOME_DIR . '/assets/home-2/';
	$url = plugins_url( 'assets/home-2/', BWE_HOME_DIR . '/site.php' );
	$ver = static function ( $rel ) use ( $dir ) {
		return (string) filemtime( $dir . $rel );
	};

	$defer = array(
		'in_footer' => true,
		'strategy'  => 'defer',
	);
	// Shared handles (2026-11-13): the theme's header/footer motion reuses these, so GSAP loads once, not twice.
	if ( ! wp_script_is( 'bwex-gsap', 'registered' ) ) {
		wp_register_script( 'bwex-gsap', $url . 'js/vendor/gsap.min.js', array(), '3.12.5', $defer );
	}
	if ( ! wp_script_is( 'bwex-scrolltrigger', 'registered' ) ) {
		wp_register_script( 'bwex-scrolltrigger', $url . 'js/vendor/ScrollTrigger.min.js', array( 'bwex-gsap' ), '3.12.5', $defer );
	}
	wp_enqueue_script( 'bwe-h2x-fx', $url . 'js/bwex-fx.js', array( 'bwex-gsap', 'bwex-scrolltrigger' ), $ver( 'js/bwex-fx.js' ), $defer );
	wp_enqueue_script( 'bwe-h2x-motion', $url . 'js/bwex-motion.js', array( 'bwe-h2x-fx' ), $ver( 'js/bwex-motion.js' ), $defer );
	wp_enqueue_script( 'bwe-h2x-js', $url . 'js/bwex.js', array(), $ver( 'js/bwex.js' ), $defer );
}
add_action( 'wp_enqueue_scripts', 'bwe_h2x_enqueue_assets', 30 );

/**
 * Hero pre-hide (2026-11-13): hides the hero copy until bwex-fx.js starts the entrance, so it never
 * shows, vanishes and then animates in. bwex-fx.js removes the class; the CSS animation is a failsafe
 * that shows the copy after 1.5s if the script never runs. Skipped for reduced motion.
 */
function bwe_h2x_hero_prehide() {
	if ( ! bwe_h2x_is_page() ) {
		return;
	}
	echo "<style id=\"bwex-hero-pre\">@keyframes bwexPreFail{to{opacity:1}}.bwex-hero-pre .bwex-hero .bwe-hero__copy{opacity:0;animation:bwexPreFail .2s 1.5s forwards}</style>\n";
	echo "<script id=\"bwex-hero-pre-js\">if(!(window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches)){document.documentElement.classList.add('bwex-hero-pre');}</script>\n";
}
add_action( 'wp_head', 'bwe_h2x_hero_prehide', 2 );

/**
 * Keeps SiteGround from moving the pre-hide snippet into its combined file (it must run in <head>).
 *
 * @param string[] $excluded Substrings of inline scripts SG must leave alone.
 * @return string[]
 */
function bwe_h2x_sg_inline_exclude( $excluded ) {
	$excluded[] = 'bwex-hero-pre';
	return $excluded;
}
add_filter( 'sgo_javascript_combine_excluded_inline_content', 'bwe_h2x_sg_inline_exclude' );

/**
 * Elementor's kit class makes the copied kit CSS (.elementor-kit-989 …) apply.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function bwe_h2x_body_class( $classes ) {
	if ( bwe_h2x_is_page() ) {
		$classes[] = 'elementor-kit-989';
		$classes[] = 'bwe-h2x-page';
	}
	return $classes;
}
add_filter( 'body_class', 'bwe_h2x_body_class' );

/**
 * WordPress gives every group "is-layout-flow", whose 24px block gap would push the copied
 * sections apart. Home's spacing comes from its own CSS, so drop the layout classes here.
 *
 * @param string $html  Rendered block.
 * @param array  $block Block.
 * @return string
 */
function bwe_h2x_strip_layout( $html, $block ) {
	static $on = null;
	if ( null === $on ) {
		$on = bwe_h2x_is_page();
	}
	if ( ! $on ) {
		return $html;
	}
	return str_replace( ' is-layout-flow wp-block-group-is-layout-flow', '', $html );
}
add_filter( 'render_block_core/group', 'bwe_h2x_strip_layout', 20, 2 );

/**
 * Headings that had no "wp-block-heading" class on Home carry the marker bwe-h2x-plain;
 * drop the class on the front end so home.css's bold heading rules don't hit them.
 *
 * @param string $html Rendered block.
 * @return string
 */
function bwe_h2x_plain_heading( $html ) {
	if ( false === strpos( $html, 'bwe-h2x-plain' ) ) {
		return $html;
	}
	return str_replace( array( 'wp-block-heading ', ' bwe-h2x-plain' ), '', $html );
}
add_filter( 'render_block_core/heading', 'bwe_h2x_plain_heading', 20 );

/**
 * Block editor: the same Home styles, so the page looks like the site while editing.
 *
 * Only for pages that contain the bwe-h2x marker. The editor canvas is an iframe whose body has no
 * "bwe-h2x-page" class, which some Home stylesheets need, so a small script adds it.
 */
function bwe_h2x_editor_assets() {
	// Every block-editor screen in wp-admin, without exceptions: the site's patterns (Home's synced sections,
	// the section library) can be previewed or inserted on any of them, and a screen that is not recognised
	// would show them unstyled. All of Home's CSS is scoped to its own classes, so other content is unaffected.
	if ( ! is_admin() ) {
		return;
	}

	bwe_h2x_enqueue_styles();

	// The theme's site font (Bricolage headings, prices, sizes) is front-end only; load it in the canvas too
	// so the editor matches the live page.
	if ( function_exists( 'bwe_site_font_on' ) && bwe_site_font_on() ) {
		wp_enqueue_style( 'bwe-site-font-face', 'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap', array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		$css = get_stylesheet_directory() . '/assets/site-font.css';
		if ( is_readable( $css ) ) {
			wp_enqueue_style( 'bwe-site-font', get_stylesheet_directory_uri() . '/assets/site-font.css', array( 'bwe-h2x-layout' ), (string) filemtime( $css ) );
		}
	}

	// Note: final-cta.css itself must NOT load in the editor — its :has() selectors make the editor canvas hang.
	// editor-compat.css carries an editor-safe copy of it (see tools/home-2/build-editor-compat.php).

	// Editor-only copies of the rules written for front-end button links (built by tools/home-2/build-editor-compat.php).
	if ( is_readable( BWE_HOME_DIR . '/assets/home-2/editor-compat.css' ) ) {
		wp_enqueue_style(
			'bwe-h2x-editor-compat',
			plugins_url( 'assets/home-2/editor-compat.css', BWE_HOME_DIR . '/site.php' ),
			array_values( array_filter( array( 'bwe-h2x-layout', 'bwe-site-font', 'bwe-h2x-pricenote', 'bwe-h2x-minimal', 'bwe-h2x-sell' ), 'wp_style_is' ) ),
			(string) filemtime( BWE_HOME_DIR . '/assets/home-2/editor-compat.css' )
		);
		// Pattern previews (Design → Patterns, inserter) don't load YouTube embeds and would show WordPress's
		// "Embed URL" box in each testimonial card; there, show a dark video tile with the play button instead.
		$tile = '.is-preview-mode .bwex-vt__video:is(.components-placeholder, :has(> .components-placeholder))';
		wp_add_inline_style(
			'bwe-h2x-editor-compat',
			$tile . '{position:relative;display:block;min-height:0;aspect-ratio:9/16;margin:0;padding:0;border:0;border-radius:18px;background:linear-gradient(160deg,#2b2e2c,#0b0d0c);box-shadow:none;outline:0;overflow:hidden}'
			. $tile . ' *{visibility:hidden}'
			. $tile . '::after{content:"";position:absolute;left:50%;top:50%;width:64px;height:64px;margin:-32px 0 0 -32px;border-radius:50%;background:#c8ff3d url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Cpath d=\'M8 5v14l11-7z\' fill=\'%230b0d0c\'/%3E%3C/svg%3E") no-repeat 55% 50%/26px;visibility:visible}'
		);
	}

	// (Spec cards are the "Spec card" block of the Best Web Expert Gutenberg Widget plugin since 2026-11-23: the editor
	// prints the same <li><strong/><span/><code/></li> as the site, so the old editor-only override was removed.)
}
add_action( 'enqueue_block_assets', 'bwe_h2x_editor_assets', 30 );

/**
 * Adds the bwe-h2x-page class to the editor canvas body (see bwe_h2x_editor_assets()).
 */
function bwe_h2x_editor_script() {
	// Runs on every block-editor screen (see bwe_h2x_editor_assets()); it only touches editor iframes that
	// show the site's sections.

	// Patterns that hold bare Home parts (Home's synced sections, the price plans) are shown — in the pattern
	// editor and in every preview — without Home's page wrapper. When a canvas has Home markup (.bwex) but no
	// wrapper (.bwe-h2x), its root container gets the wrapper classes; a bare price-plans part also gets the
	// pricing section around it. Detected per iframe, so it works for any pattern on any screen.
	// The editor rewrites the root's class attribute (e.g. on a Desktop/Tablet/Mobile preview switch), so the
	// added classes are kept in data-bwe-wrap-cls and put back whenever they are gone (2026-11-23).
	$wrap = 'var r=d.querySelector(".is-root-container");if(r&&r.dataset.bweWrapCls&&!r.classList.contains(r.dataset.bweWrapCls.split(" ")[0])){r.classList.add.apply(r.classList,r.dataset.bweWrapCls.split(" "));}if(r&&!r.dataset.bweWrapped&&d.querySelector(".bwex, .bwex-plans, .bwex-section")&&!d.querySelector(".bwe-h2x")){r.dataset.bweWrapped="1";var plans=r.querySelector(":scope > .bwex-plans, :scope > .wp-block > .bwex-plans")&&!d.querySelector(".bwex-section");if(plans){b.classList.add("elementor","elementor-517","bwe-h2x","bwe-home","bwex");r.classList.add("bwex-section","bwex-pricing","bwex-wrap");r.dataset.bweWrapCls="bwex-section bwex-pricing bwex-wrap";r.setAttribute("data-bwe-anchor","pricing");}else{b.classList.add("elementor","elementor-517");r.classList.add("bwe-home","bwex","elementor-element","elementor-element-1001dd3","e-con-full","e-flex","e-con","e-parent");r.dataset.bweWrapCls="bwe-home bwex elementor-element elementor-element-1001dd3 e-con-full e-flex e-con e-parent";}}';
	// Sections of one-wrapper pages (Contact, Pricing, Write for Us, Blog, demos) are synced patterns that
	// carry their page wrapper's classes as markers (bwe-scope--bwe-wfu …, tools/home-2/make-pages-synced.php).
	// Where the wrapper itself is missing (the pattern's own canvas, previews), the body gets those classes so
	// page-scoped CSS (.bwe-wfu …, .bwe-prx …, .bwe-demo …) applies there too.
	$scope = 'd.querySelectorAll("[class*=\"bwe-scope--\"]").forEach(function(el){el.classList.forEach(function(c){if(c.indexOf("bwe-scope--")===0){var k=c.slice(11);if(k&&!d.querySelector("."+k)){b.classList.add(k);}}});});';
	// On the site, buttons with the class bwex-btn print Elementor's button classes (includes/block-markup.php);
	// give the editor's button text the same classes so it is styled the same.
	// Block anchors (#pricing, #process, #faq …) are only printed on the site, and Home's CSS styles some parts
	// by those IDs (eyebrow icons, plan badge). The editor keeps its own block IDs, so the anchor goes into
	// data-bwe-anchor and editor-compat.css maps "#pricing" rules to [data-bwe-anchor="pricing"].
	$btns = 'if(!d.bweBtnObs){var fix=function(){d.querySelectorAll(".bwex-btn > .wp-block-button__link").forEach(function(x){x.classList.add("elementor-button","elementor-button-link","elementor-size-sm");});'
		. 'var s=window.wp&&wp.data&&wp.data.select("core/block-editor");if(s){var walk=function(bs){bs.forEach(function(k){if(k.attributes&&k.attributes.anchor){var el=d.querySelector("[data-block=\""+k.clientId+"\"]");if(el&&el.getAttribute("data-bwe-anchor")!==k.attributes.anchor){el.setAttribute("data-bwe-anchor",k.attributes.anchor);}}walk(k.innerBlocks||[]);});};walk(s.getBlocks());}'
		// Pattern previews (Design → Patterns grid, inserter) have their own block store that the page can't
		// reach, so there the anchor is read from the block's own React props (each block element once).
		. 'd.querySelectorAll("[data-block]:not([data-bwe-fb])").forEach(function(el){el.setAttribute("data-bwe-fb","1");if(el.hasAttribute("data-bwe-anchor")){return;}var k=Object.keys(el).find(function(x){return x.indexOf("__reactFiber$")===0;});for(var f=k&&el[k],i=0;f&&i<60;i++,f=f.return){var p=f.memoizedProps;if(p&&p.clientId===el.getAttribute("data-block")&&p.attributes){if(p.attributes.anchor){el.setAttribute("data-bwe-anchor",p.attributes.anchor);}break;}}});};'
		// Coalesced: at most one run per 150 ms, however many DOM changes the editor makes while loading.
		. 'var due=0;d.bweBtnObs=new MutationObserver(function(){if(!due){due=setTimeout(function(){due=0;fix();},150);}});d.bweBtnObs.observe(b,{childList:true,subtree:true});fix();}';
	// Runs for the whole session (cheap): the Design → Patterns screen replaces the canvas iframe for every
	// pattern you open, so each new canvas gets the classes and helpers too.
	// Attached to the block editor package itself, so it runs on every block-editor screen.
	wp_add_inline_script(
		'wp-block-editor',
		// Every editor iframe: the canvas and the pattern previews (Design → Patterns grid, inserter).
		'(function(){setInterval(function(){document.querySelectorAll("iframe").forEach(function(f){var d;try{d=f.contentDocument;}catch(e){return;}var b=d&&d.body;if(!b||!b.classList.contains("editor-styles-wrapper")){return;}b.classList.add("bwe-h2x-page","elementor-kit-989");' . $scope . $wrap . $btns . '});},700);})();'
	);
}
add_action( 'enqueue_block_editor_assets', 'bwe_h2x_editor_script' );

/**
 * Dark grid hero (2026-11-20): the header floats over a dark hero on the front page only, so use the
 * light logo there (attachment 1224, the logo with a light wordmark). Other pages keep their logo.
 */
add_filter(
	'theme_mod_bwe_hf_logo_light',
	function ( $value ) {
		// 2026-11-20: /write-for-us/ and /contact/ use the same dark hero, so they get the light logo too.
		if ( ! is_admin() && ( is_front_page() || is_page( array( 'write-for-us', 'contact' ) ) ) && wp_attachment_is_image( 1224 ) ) {
			return 1224;
		}
		return $value;
	}
);

/**
 * FAQPage schema for the pricing page (839), which lost the page-builder marker when it was
 * rebuilt from Home's sections on 2026-11-21.
 *
 * @param array $data JSON-LD graph Rank Math prints.
 * @return array
 */
function bwe_prx_json_ld( $data ) {
	if ( is_admin() || ! bwe_home_is_needed( 'bwe-prx' ) || ! function_exists( 'bwe_bwe_details_faq' ) ) {
		return $data;
	}
	$faq = bwe_bwe_details_faq( bwe_post_content_expanded( get_queried_object_id() ) );
	if ( $faq ) {
		$faq['@id']     = get_permalink( get_queried_object_id() ) . '#faq';
		$data['bweFaq'] = $faq;
	}
	return $data;
}
add_filter( 'rank_math/json_ld', 'bwe_prx_json_ld', 98 );

/**
 * Hero built from core blocks (2026-11-21; it was one Custom HTML block).
 * A section group with the class "bwex-hero" gets the animation settings the GSAP hero script reads
 * (blocks can't store data-* attributes), unless the markup already has them.
 *
 * @param string $html  Rendered block.
 * @param array  $block Block.
 * @return string
 */
function bwe_h2x_hero_block_attrs( $html, $block ) {
	$cls = ' ' . ( $block['attrs']['className'] ?? '' ) . ' ';
	if ( false === strpos( $cls, ' bwex-hero ' ) || false !== strpos( $html, 'data-bwex-hero' ) ) {
		return $html;
	}
	$settings = apply_filters(
		'bwe_h2x_hero_settings',
		array(
			'on'      => true,
			'speed'   => 1,
			'delay'   => 0,
			'stagger' => 0.055,
			'words'   => 'rise',
			'header'  => true,
			'bg'      => true,
			'pill'    => true,
			'line'    => true,
			'lead'    => true,
			'btns'    => true,
			'proof'   => true,
			'cue'     => true,
			'pointer' => 1,
			'magnet'  => 1,
			'fade'    => array( 70, 0.15 ),
			'swell'   => 1.35,
			'gx'      => 50,
			'gy'      => 30,
		),
		$block
	);
	$attrs = ' data-bwex-hero="' . esc_attr( wp_json_encode( $settings ) ) . '" data-bwex-pre="1"';
	return preg_replace( '/^(\s*<(?:section|div)\b[^>]*?)>/', '$1' . $attrs . '>', $html, 1 );
}
add_filter( 'render_block_core/group', 'bwe_h2x_hero_block_attrs', 10, 2 );

/**
 * Hero scroll cue as an editable paragraph (class "bwex-scroll-wrap", one link inside): printed as the
 * original cue markup, with the animated line (<i>) the paragraph can't hold.
 *
 * @param string $html  Rendered block.
 * @param array  $block Block.
 * @return string
 */
function bwe_h2x_scroll_cue( $html, $block ) {
	if ( false === strpos( ' ' . ( $block['attrs']['className'] ?? '' ) . ' ', ' bwex-scroll-wrap ' ) ) {
		return $html;
	}
	if ( ! preg_match( '/<a\b[^>]*href="([^"]*)"[^>]*>(.*?)<\/a>/s', $html, $m ) ) {
		return $html;
	}
	return '<div class="bwex-scroll-wrap"><a class="bwex-scroll" href="' . esc_url( html_entity_decode( $m[1] ) ) . '"><span>' . wp_strip_all_tags( $m[2] ) . '</span><i aria-hidden="true"></i></a></div>';
}
add_filter( 'render_block_core/paragraph', 'bwe_h2x_scroll_cue', 10, 2 );
