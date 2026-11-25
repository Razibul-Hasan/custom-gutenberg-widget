<?php
/**
 * Site design layer: the styles, scripts, render filters and schema the blocks' markup was written for.
 *
 * Ported from the BestWebExpert Home plugin (1.8.0), so the widget works on its own. Loaded by
 * bestwebexpert-gutenberg-widget.php only when BestWebExpert Home is NOT active (both at once would define the same
 * functions); with Home active, Home keeps serving all of this exactly as before.
 *
 * Layout mirrors Home's (assets/, includes/, content/, templates/), so BWE_HOME_DIR points here and the ported code
 * is unchanged apart from paths. Left out on purpose: Home's one-time installers (media library imports, the Contact
 * and Write for Us forms/pages, copy updates). They already ran on this site, and the content they made stays.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

// Same order as BestWebExpert Home, so hooks with equal priorities still run in the same order.
foreach ( array( 'blog', 'contact', 'demo', 'best-web-expert', 'seo', 'wordpress-expert', 'page-builder', 'footer', 'migrate-lift', 'home-2', 'block-markup', 'patterns-hero', 'section-library', 'frontend-optimize', 'pattern-library', 'video-testimonials', 'service-match', 'redirects', 'post-faq-schema', 'tracking' ) as $bwe_gw_site_file ) {
	require_once BWE_HOME_DIR . '/includes/' . $bwe_gw_site_file . '.php';
}
unset( $bwe_gw_site_file );

/**
 * Images bundled in assets/img, keyed by the name the pattern uses.
 *
 * @return array<string, array{file: string, title: string, alt: string}>
 */
function bwe_home_image_files() {
	return array(
		'wordpress'     => array(
			'file'  => 'custom-wordpress-website-design.jpg',
			'title' => 'Custom WordPress website design',
			'alt'   => 'Custom WordPress website design by Best Web Expert for a roofing company',
		),
		'shopify'       => array(
			'file'  => 'shopify-store-design-development.jpg',
			'title' => 'Shopify store design and development',
			'alt'   => 'Shopify store design and development concept for a skincare brand',
		),
		'mobile'        => array(
			'file'  => 'mobile-first-responsive-web-design.jpg',
			'title' => 'Mobile-first responsive web design',
			'alt'   => 'Mobile-first WordPress and Shopify development shown on two smartphones',
		),
		'versus'        => array(
			'file'  => 'wordpress-vs-shopify-which-to-choose.jpg',
			'title' => 'WordPress vs Shopify comparison',
			'alt'   => 'WordPress vs Shopify comparison: content and flexibility versus selling online',
		),
		'social'        => array(
			'file'  => 'wordpress-and-shopify-development-bestwebexpert.jpg',
			'title' => 'WordPress and Shopify development by BestWebExpert',
			'alt'   => 'WordPress and Shopify development that actually sells — BestWebExpert',
		),
		'reels'         => array(
			'file'  => 'productreels-shoppable-video-reels-woocommerce.jpg',
			'title' => 'ProductReels shoppable video reels for WooCommerce',
			'alt'   => 'ProductReels carousel of shoppable video reels with product cards on a WooCommerce store',
		),
		'reels-stats'   => array(
			'file'  => 'productreels-video-analytics-dashboard.jpg',
			'title' => 'ProductReels video analytics dashboard',
			'alt'   => 'ProductReels dashboard showing views, clicks and click rate for every shoppable video reel',
		),
		'reels-editor'  => array(
			'file'  => 'productreels-visual-editor-live-preview.jpg',
			'title' => 'ProductReels visual editor with live preview',
			'alt'   => 'ProductReels visual editor: drag reels into order and see the shoppable carousel in a live preview',
		),
		'reels-detail'  => array(
			'file'  => 'productreels-reel-analytics-click-rate.jpg',
			'title' => 'ProductReels widget statistics',
			'alt'   => 'ProductReels widget statistics with top reels and product button clicks',
		),
		'reels-stories' => array(
			'file'  => 'productreels-story-bubbles-layout.jpg',
			'title' => 'ProductReels story bubbles layout',
			'alt'   => 'ProductReels stories layout with round, Instagram-style video bubbles',
		),
		'reels-grid'    => array(
			'file'  => 'productreels-video-grid-layout.jpg',
			'title' => 'ProductReels video grid layout',
			'alt'   => 'ProductReels grid layout showing many shoppable video reels at once',
		),
		'reels-marquee' => array(
			'file'  => 'productreels-marquee-layout.jpg',
			'title' => 'ProductReels marquee layout',
			'alt'   => 'ProductReels marquee layout with an endless scrolling ribbon of video reels',
		),
		'reels-stacked' => array(
			'file'  => 'productreels-stacked-cards-layout.jpg',
			'title' => 'ProductReels stacked cards layout',
			'alt'   => 'ProductReels stacked cards layout showing reels as a layered card stack',
		),
		'reels-popup'   => array(
			'file'  => 'productreels-floating-popup-layout.jpg',
			'title' => 'ProductReels floating popup layout',
			'alt'   => 'ProductReels floating popup with a small shoppable reel in the corner of the page',
		),
		// Client photos next to the hero rating. Empty alt: they're decorative, the rating text beside them says it all.
		'client-1'      => array(
			'file'  => 'bestwebexpert-happy-client-1.jpg',
			'title' => 'BestWebExpert happy client',
			'alt'   => '',
		),
		'client-2'      => array(
			'file'  => 'bestwebexpert-happy-client-2.jpg',
			'title' => 'BestWebExpert happy client',
			'alt'   => '',
		),
		'client-3'      => array(
			'file'  => 'bestwebexpert-happy-client-3.jpg',
			'title' => 'BestWebExpert happy client',
			'alt'   => '',
		),
		'client-4'      => array(
			'file'  => 'bestwebexpert-happy-client-4.jpg',
			'title' => 'BestWebExpert happy client',
			'alt'   => '',
		),
	);
}

/**
 * Returns core/image block markup for a bundled image, using the Media Library copy when there is one.
 *
 * @param string $key       Key from bwe_home_image_files().
 * @param string $classname Extra class for the figure.
 * @param string $alt       Alt text for this placement; defaults to the image's own alt text.
 * @return string Block markup.
 */
function bwe_home_image( $key, $classname = 'bwe-shot', $alt = '' ) {
	$image = bwe_home_image_files()[ $key ];
	$ids   = (array) get_option( 'bwe_home_images', array() );
	$id    = isset( $ids[ $key ] ) ? (int) $ids[ $key ] : 0;
	$src   = $id ? wp_get_attachment_image_url( $id, 'large' ) : false;
	$attrs = array();

	if ( $src ) {
		$attrs['id'] = $id;
		$img_class   = ' class="wp-image-' . $id . '"';
	} else {
		$src       = plugins_url( 'assets/img/' . $image['file'], __FILE__ );
		$img_class = '';
	}

	$attrs['sizeSlug']        = 'large';
	$attrs['linkDestination'] = 'none';
	$attrs['className']       = $classname;

	return sprintf(
		"<!-- wp:image %s -->\n<figure class=\"wp-block-image size-large %s\"><img src=\"%s\" alt=\"%s\"%s/></figure>\n<!-- /wp:image -->",
		wp_json_encode( $attrs ),
		esc_attr( $classname ),
		esc_url( $src ),
		esc_attr( $alt ? $alt : $image['alt'] ),
		$img_class
	);
}

/**
 * A post's content with its synced patterns (<!-- wp:block {"ref":N} /-->) written out, cached per request.
 * Home and the redesigned pages are partly made of synced patterns, so anything that looks for a class or
 * reads FAQ items in the content must see what the visitor sees — including the page's own pattern
 * overrides (<!-- wp:block {"ref":N,"content":{…}} /-->, see tools/home-2/enable-pattern-overrides.php).
 *
 * @param int|WP_Post|null $post Post (default: queried object).
 * @return string
 */
function bwe_post_content_expanded( $post = null ) {
	static $cache = array();
	$post = get_post( $post ? $post : get_queried_object_id() );
	if ( ! $post ) {
		return '';
	}
	if ( isset( $cache[ $post->ID ] ) ) {
		return $cache[ $post->ID ];
	}
	$expand = static function ( $content, $depth ) use ( &$expand ) {
		if ( $depth > 3 || false === strpos( $content, '<!-- wp:block ' ) ) {
			return $content;
		}
		return preg_replace_callback(
			'/<!-- wp:block (\{"ref":\d+.*?\}) \/-->/s',
			static function ( $m ) use ( $expand, $depth ) {
				$attrs = json_decode( $m[1], true );
				$ref   = get_post( (int) ( $attrs['ref'] ?? 0 ) );
				if ( ! $ref || 'wp_block' !== $ref->post_type || 'publish' !== $ref->post_status ) {
					return '';
				}
				$inner = $ref->post_content;
				if ( ! empty( $attrs['content'] ) && is_array( $attrs['content'] ) ) {
					$inner = bwe_pattern_apply_overrides( $inner, $attrs['content'] );
				}
				return $expand( $inner, $depth + 1 );
			},
			$content
		);
	};
	/**
	 * Filters the expanded content that schema, <head> and asset-marker code read (Best Web Expert Gutenberg Widget
	 * puts the markup of its blocks back in here — their text lives in block attributes).
	 *
	 * @param string  $content Content with synced patterns inlined.
	 * @param WP_Post $post    The post.
	 */
	$cache[ $post->ID ] = (string) apply_filters( 'bwe_post_content_expanded', $expand( (string) $post->post_content, 0 ), $post );
	return $cache[ $post->ID ];
}

/**
 * A synced pattern's markup with one page's overrides written into its named blocks — the same
 * replacement core does when it renders the pattern (WP_Block::replace_html()).
 *
 * @param string $content   Pattern post_content.
 * @param array  $overrides Block name => array( attribute => value ).
 * @return string
 */
function bwe_pattern_apply_overrides( $content, $overrides ) {
	try {
		$replace = new ReflectionMethod( 'WP_Block', 'replace_html' );
		$walk    = static function ( $blocks ) use ( &$walk, $overrides, $replace ) {
			foreach ( $blocks as &$block ) {
				$name = $block['attrs']['metadata']['name'] ?? '';
				$src  = $block['attrs']['metadata']['bindings']['__default']['source'] ?? '';
				if ( '' !== $name && 'core/pattern-overrides' === $src && ! empty( $overrides[ $name ] ) && is_array( $overrides[ $name ] ) ) {
					$type     = WP_Block_Type_Registry::get_instance()->get_registered( $block['blockName'] );
					$leaf     = empty( $block['innerBlocks'] );
					$instance = $leaf ? new WP_Block( $block ) : null;
					foreach ( $overrides[ $name ] as $attr => $value ) {
						if ( ! $type || ! in_array( $attr, get_block_bindings_supported_attributes( $block['blockName'] ), true ) ) {
							continue;
						}
						if ( isset( $type->attributes[ $attr ]['source'] ) ) {
							if ( $leaf ) {
								$block['innerHTML']    = $replace->invoke( $instance, $block['innerHTML'], $attr, $value );
								$block['innerContent'] = array( $block['innerHTML'] );
							}
						} else {
							$block['attrs'][ $attr ] = $value;
						}
					}
				}
				if ( ! empty( $block['innerBlocks'] ) ) {
					$block['innerBlocks'] = $walk( $block['innerBlocks'] );
				}
			}
			return $blocks;
		};
		return serialize_blocks( $walk( parse_blocks( $content ) ) );
	} catch ( Throwable $e ) {
		return $content;
	}
}

/**
 * Whether the current front-end request shows content built from one of the patterns.
 *
 * @param string $marker Class name the pattern's wrapper carries.
 * @return bool
 */
function bwe_home_is_needed( $marker = 'bwe-home' ) {
	if ( ! is_singular() ) {
		return false;
	}

	return false !== strpos( bwe_post_content_expanded( get_queried_object_id() ), $marker );
}

/**
 * Enqueues the font and stylesheet on matching pages and inside the block editor.
 */
function bwe_home_enqueue_assets() {
	if ( ! is_admin() && ! bwe_home_is_needed() && ! ( function_exists( 'bwe_blog_view' ) && bwe_blog_view() ) ) {
		return;
	}

	wp_enqueue_style(
		'bwe-home-fonts',
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500..800&display=swap',
		array(),
		null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Google Fonts URLs are versioned by their query string.
	);

	wp_enqueue_style(
		'bwe-home',
		plugins_url( 'assets/home.css', __FILE__ ),
		array( 'bwe-home-fonts' ),
		(string) filemtime( BWE_HOME_DIR . '/assets/home.css' )
	);

	if ( is_admin() || bwe_home_is_needed( 'bwe-services' ) ) {
		wp_enqueue_style(
			'bwe-services',
			plugins_url( 'assets/services.css', __FILE__ ),
			array( 'bwe-home' ),
			(string) filemtime( BWE_HOME_DIR . '/assets/services.css' )
		);
	}

	if ( is_admin() || ( function_exists( 'bwe_blog_view' ) && bwe_blog_view() ) || bwe_home_is_needed( 'bwe-blog' ) ) {
		wp_enqueue_style(
			'bwe-blog-serif',
			'https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,opsz,wght@0,8..60,400..700;1,8..60,400..700&display=swap',
			array(),
			null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Google Fonts URLs are versioned by their query string.
		);
		wp_enqueue_style(
			'bwe-blog',
			plugins_url( 'assets/blog.css', __FILE__ ),
			array( 'bwe-home', 'bwe-blog-serif' ),
			(string) filemtime( BWE_HOME_DIR . '/assets/blog.css' )
		);
	}

	if ( is_admin() || bwe_home_is_needed( 'bwe-contact' ) ) {
		wp_enqueue_style(
			'bwe-contact',
			plugins_url( 'assets/contact.css', __FILE__ ),
			array( 'bwe-services' ),
			(string) filemtime( BWE_HOME_DIR . '/assets/contact.css' )
		);

		wp_enqueue_style(
			'bwe-form-minimal',
			plugins_url( 'assets/form-minimal.css', __FILE__ ),
			array( 'bwe-contact' ),
			(string) filemtime( BWE_HOME_DIR . '/assets/form-minimal.css' )
		);
	}

	if ( is_admin() || bwe_home_is_needed( 'bwe-wfu' ) ) {
		wp_enqueue_style(
			'bwe-wfu',
			plugins_url( 'assets/write-for-us.css', __FILE__ ),
			array( 'bwe-contact' ),
			(string) filemtime( BWE_HOME_DIR . '/assets/write-for-us.css' )
		);
	}

	if ( is_admin() || bwe_home_is_needed( 'bwe-reels' ) ) {
		wp_enqueue_style(
			'bwe-reels',
			plugins_url( 'assets/productreels.css', __FILE__ ),
			array( 'bwe-services' ),
			(string) filemtime( BWE_HOME_DIR . '/assets/productreels.css' )
		);
	}

	if ( is_admin() || bwe_home_is_needed( 'bwe-wpx' ) || bwe_home_is_needed( 'bwe-spx' ) || bwe_home_is_needed( 'bwe-pb' ) ) {
		wp_enqueue_style(
			'bwe-wpx',
			plugins_url( 'assets/wordpress-expert.css', __FILE__ ),
			array( 'bwe-services' ),
			(string) filemtime( BWE_HOME_DIR . '/assets/wordpress-expert.css' )
		);
	}

	if ( is_admin() || bwe_home_is_needed( 'bwe-mmbb' ) ) {
		wp_enqueue_style(
			'bwe-mmbb',
			plugins_url( 'assets/mix-and-max.css', __FILE__ ),
			array( 'bwe-services' ),
			(string) filemtime( BWE_HOME_DIR . '/assets/mix-and-max.css' )
		);
	}
}
add_action( 'enqueue_block_assets', 'bwe_home_enqueue_assets' );

/**
 * Loads the four client photos in the hero eagerly and lazy-loads every other content image, which all sit below the fold.
 *
 * @param int $threshold Number of leading content images WordPress loads eagerly.
 * @return int
 */
function bwe_home_lazy_threshold( $threshold ) {
	return ! is_admin() && bwe_home_is_needed() ? 4 : $threshold;
}
add_filter( 'wp_omit_loading_attr_threshold', 'bwe_home_lazy_threshold' );

/**
 * Drops Rank Math's "used Content AI" check while the Content AI module is off.
 *
 * That check scores whether Rank Math's credit-based AI research was run, not the content itself,
 * so without the module it can only ever fail. It comes back as soon as the module is enabled.
 *
 * @param array $tests Rank Math SEO tests, keyed by test name.
 * @return array
 */
function bwe_home_rank_math_tests( $tests ) {
	if ( class_exists( '\RankMath\Helper' ) && ! \RankMath\Helper::is_module_active( 'content-ai' ) ) {
		unset( $tests['hasContentAI'] );
	}

	return $tests;
}
add_filter( 'rank_math/researches/tests', 'bwe_home_rank_math_tests' );

/**
 * Preconnects to Google Fonts when the stylesheet is in use.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function bwe_home_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type && wp_style_is( 'bwe-home-fonts', 'queue' ) ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'bwe_home_resource_hints', 10, 2 );

/**
 * Tells search engines that "Best Web Expert" is the name of this business.
 *
 * @param array $data JSON-LD graph Rank Math prints.
 * @return array
 */
function bwe_home_json_ld( $data ) {
	if ( ! is_front_page() ) {
		return $data;
	}

	$data['bweProfessionalService'] = array(
		'@type'         => 'ProfessionalService',
		'@id'           => home_url( '/#professionalservice' ),
		'name'          => 'BestWebExpert',
		'alternateName' => array( 'Best Web Expert', 'Best Web Expert – WordPress & Shopify Development' ),
		'url'           => home_url( '/' ),
		'description'   => 'WordPress and Shopify design and development: fast, SEO-optimized websites and stores.',
		'serviceType'   => array( 'WordPress development', 'Shopify development', 'Web design' ),
		'areaServed'    => 'Worldwide',
		'sameAs'        => array_values( bwe_profiles() ),
		'founder'       => array(
			'@type'    => 'Person',
			'name'     => 'Razibul Hasan',
			'jobTitle' => 'WordPress and Shopify developer',
			'url'      => home_url( '/about/' ),
			'sameAs'   => array_values( bwe_profiles() ),
		),
	);

	return $data;
}
add_filter( 'rank_math/json_ld', 'bwe_home_json_ld', 99 );

/**
 * Tells search engines and AI answer engines that "Best Web Expert" (with spaces) and
 * "BestWebExpert" are the same business, on every page where Rank Math prints the Organization.
 *
 * @param array $data JSON-LD graph Rank Math prints.
 * @return array
 */
function bwe_home_org_alternate_name( $data ) {
	foreach ( $data as $key => $node ) {
		if ( is_array( $node ) && 'Organization' === ( $node['@type'] ?? '' ) ) {
			$names = array_values( array_unique( array_merge( (array) ( $node['alternateName'] ?? array() ), array( 'Best Web Expert' ) ) ) );

			$data[ $key ]['alternateName'] = $names;
		}
	}
	return $data;
}
add_filter( 'rank_math/json_ld', 'bwe_home_org_alternate_name', 100 );

/**
 * Final CTA ("Ready when you are") as a dark card on every page that has one (2026-11-17).
 * Loads after every other plugin stylesheet. Delete assets/final-cta.css to go back to the lime block.
 */
function bwe_final_cta_enqueue() {
	if ( is_admin() || ! wp_style_is( 'bwe-home', 'enqueued' ) || ! is_readable( BWE_HOME_DIR . '/assets/final-cta.css' ) ) {
		return;
	}

	wp_enqueue_style(
		'bwe-final-cta',
		plugins_url( 'assets/final-cta.css', __FILE__ ),
		array( 'bwe-home' ),
		(string) filemtime( BWE_HOME_DIR . '/assets/final-cta.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'bwe_final_cta_enqueue', 99 );
