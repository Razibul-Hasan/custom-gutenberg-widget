<?php
/**
 * Fixes from the Semrush site audit (2026-10-27): stale sitemap and llms.txt rewrites, Cloudflare email
 * links, category descriptions, shop category links and the out-of-stock "Read more" button.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * Re-saves the rewrite rules when Rank Math's sitemap or llms.txt rule is missing from them.
 *
 * Rank Math registers these rules on init, but WordPress only stores rules when permalinks are flushed, so a
 * module switched on by a database import or migration leaves /sitemap_index.xml and /llms.txt as 404s.
 * Checked at most once a day.
 */
function bwe_seo_fix_stale_rewrites() {
	global $wp_rewrite;

	$saved = get_option( 'rewrite_rules' );
	if ( ! is_array( $saved ) || get_transient( 'bwe_seo_rewrites_checked' ) ) {
		return;
	}

	set_transient( 'bwe_seo_rewrites_checked', 1, DAY_IN_SECONDS );

	foreach ( array_keys( $wp_rewrite->extra_rules_top ) as $regex ) {
		if ( preg_match( '/sitemap|llms/', $regex ) && ! isset( $saved[ $regex ] ) ) {
			flush_rewrite_rules( false );
			return;
		}
	}
}
add_action( 'wp_loaded', 'bwe_seo_fix_stale_rewrites' );

/**
 * Sends retired page URLs to their new home with a 301, so old links and indexed URLs keep working.
 *
 * Mix and Max Box Builder was renamed ProductBoxes (2026-10-29) and its landing page moved to /productboxes/.
 * WordPress's own old-slug redirect only covers posts, not pages.
 */
function bwe_seo_moved_pages() {
	if ( ! is_404() ) {
		return;
	}

	$moved = array(
		'mix-and-max-box-builder'           => '/productboxes/',
		'how-to-choose-the-best-web-expert' => '/how-to-hire-a-web-developer/',
	);

	$path = trim( (string) wp_parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );
	if ( isset( $moved[ $path ] ) ) {
		wp_safe_redirect( home_url( $moved[ $path ] ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'bwe_seo_moved_pages', 1 );

/**
 * Keeps Cloudflare's email obfuscation off mailto links.
 *
 * Cloudflare rewrites them to /cdn-cgi/l/email-protection#..., which crawlers report as a broken internal link.
 *
 * @param string $content Post content.
 * @return string
 */
function bwe_seo_email_off( $content ) {
	if ( false === strpos( $content, 'mailto:' ) ) {
		return $content;
	}

	return preg_replace( '#<a\b[^>]*\bhref="mailto:[^"]*"[^>]*>.*?</a>#is', '<!--email_off-->$0<!--/email_off-->', $content );
}
add_filter( 'the_content', 'bwe_seo_email_off', 99 );

/**
 * Shows product category descriptions under the products instead of between the title and the grid.
 */
function bwe_seo_move_term_description() {
	if ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) {
		remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
		add_action( 'woocommerce_after_shop_loop', 'woocommerce_taxonomy_archive_description', 20 );
	}
}
add_action( 'wp', 'bwe_seo_move_term_description' );

/**
 * "Shop by category" links above the products on the shop, category and tag archives.
 *
 * Gives every product category links from all the store archives, instead of a single link from its parent.
 */
function bwe_seo_shop_category_links() {
	if ( ! is_shop() && ! is_product_taxonomy() ) {
		return;
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
			'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
			'orderby'    => 'name',
		)
	);

	if ( is_wp_error( $terms ) || ! $terms ) {
		return;
	}

	$current = is_product_category() ? (int) get_queried_object_id() : 0;
	$links   = sprintf(
		'<li><a href="%s"%s>%s</a></li>',
		esc_url( wc_get_page_permalink( 'shop' ) ),
		is_shop() ? ' aria-current="page"' : '',
		esc_html__( 'All', 'bestwebexpert-home' )
	);

	foreach ( $terms as $term ) {
		$links .= sprintf(
			'<li><a href="%s"%s>%s</a></li>',
			esc_url( get_term_link( $term ) ),
			$current === $term->term_id ? ' aria-current="page"' : '',
			esc_html( $term->name )
		);
	}

	printf(
		'<nav class="bwe-shop-cats" aria-label="%s"><ul>%s</ul></nav>',
		esc_attr__( 'Shop by category', 'bestwebexpert-home' ),
		$links // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
	);
}
add_action( 'woocommerce_before_shop_loop', 'bwe_seo_shop_category_links', 5 );

/**
 * Styles for the category links and the description under the products.
 */
function bwe_seo_shop_styles() {
	if ( ! function_exists( 'is_shop' ) || ( ! is_shop() && ! is_product_taxonomy() ) ) {
		return;
	}

	wp_register_style( 'bwe-shop', false, array(), BWE_HOME_VERSION );
	wp_enqueue_style( 'bwe-shop' );
	wp_add_inline_style(
		'bwe-shop',
		'.bwe-shop-cats{clear:both;margin:0 0 1.5em}.bwe-shop-cats ul{display:flex;flex-wrap:wrap;gap:.5em;margin:0;padding:0;list-style:none}'
		. '.bwe-shop-cats a{display:inline-block;padding:.35em .9em;border:1px solid currentColor;border-radius:999px;font-size:.875em;line-height:1.4;text-decoration:none}'
		. '.bwe-shop-cats a[aria-current]{background:rgba(0,0,0,.08)}'
		. '.woocommerce-pagination+.term-description,.products+.term-description{clear:both;max-width:46em;margin-top:2.5em}'
	);
}
add_action( 'wp_enqueue_scripts', 'bwe_seo_shop_styles' );

/**
 * Names the out-of-stock button after what it does, instead of WooCommerce's "Read more".
 *
 * @param string     $text    Button text.
 * @param WC_Product $product Product.
 * @return string
 */
function bwe_seo_add_to_cart_text( $text, $product ) {
	if ( $product instanceof WC_Product && $product->is_type( 'simple' ) && ! $product->is_in_stock() ) {
		return __( 'Sold out: see item', 'bestwebexpert-home' );
	}

	return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'bwe_seo_add_to_cart_text', 10, 2 );

/**
 * Descriptions for the product and blog categories, keyed by taxonomy and slug.
 *
 * 'meta' is the Rank Math meta description; 'text' is the term description shown on the archive.
 *
 * @return array<string, array<string, array{meta: string, text: string}>>
 */
function bwe_seo_term_copy() {
	$link = static function ( $path, $label ) {
		return '<a href="' . esc_url( home_url( $path ) ) . '">' . $label . '</a>';
	};

	$reels = $link( '/shop-the-look/', 'Shop the Look reels' );

	return array(
		'product_cat' => array(
			'clothing'    => array(
				'meta' => 'Shop the clothing edit: crisp shirts, cozy knits, jackets, a black slip dress and relaxed trousers. Easy pieces you can watch styled in video reels.',
				'text' => 'Our clothing edit is a small, tight wardrobe: crisp shirts, cozy knits, jackets for every season, one perfect slip dress and relaxed trousers that go with all of it. Every piece is picked to mix and match, so three or four buys give you a full week of outfits.'
					. "\n\n" . 'Not sure how something looks on? Most of these pieces star in our ' . $reels . ' and the ' . $link( '/lookbook/', 'fall lookbook' ) . ', where you can watch them styled and add them to your cart straight from the video.',
			),
			'shirts'      => array(
				'meta' => 'Seven shirts that do the heavy lifting: white poplin, sage oxford, forest linen, cornflower satin, wine red slim-fit, pastel oversized and ivory cord.',
				'text' => 'A good shirt carries half your outfits, so we keep seven that each do a different job. The Easy White Poplin Shirt is the one you reach for three times a week. The Sage Oxford and Wine Red Slim-Fit look sharp with trousers, while the Forest Linen Shirt keeps you cool on hot days.'
					. "\n\n" . 'For something softer, try the liquid Cornflower Satin Shirt or the blush and lilac Pastel Oversized Shirt. The Ivory Corduroy Overshirt layers over a tee on crisp mornings. Pair any of them with our ' . $link( '/product-category/clothing/trousers/', 'relaxed trousers' ) . ' or a ' . $link( '/product-category/clothing/jackets/', 'jacket' ) . ', and watch them styled in the ' . $reels . '.',
			),
			'sweater'     => array(
				'meta' => 'Cozy knits for cold days: the Sage Mock-Neck, Sunday Mustard Crew, Holiday Stripe Chunky Knit and Oatmeal Cropped Knit. Soft, warm and easy to style.',
				'text' => 'Four knits, four moods. The Sage Mock-Neck Sweater is soft, slightly fuzzy and calm. The Sunday Mustard Crew Sweater is sunshine in an oversized fit, made for baggy jeans and lazy weekends. The Holiday Stripe Chunky Knit is the one everyone asks about in photos, and the Oatmeal Cropped Knit sits just right over high-waisted jeans.'
					. "\n\n" . 'Every sweater here is chunky enough for real cold and soft enough to wear all day. Layer one under the ' . $link( '/product-category/clothing/jackets/', 'Camel City Trench Coat' ) . ', finish the look with a ' . $link( '/product-category/clothing/accessories/', 'bucket hat' ) . ', and see how they move in our ' . $reels . '.',
			),
			'jackets'     => array(
				'meta' => 'Jackets for every season: a camel trench, black leather biker, vintage denim, pinstripe oversized blazer and tobacco suede overshirt. Layers that last.',
				'text' => 'The right jacket turns a plain tee into an outfit. The Camel City Trench Coat is water-repellent and belted for city walks. The Midnight Leather Biker Jacket only gets better with age, and the Vintage Wash Denim Jacket goes with almost everything you own.'
					. "\n\n" . 'For sharper days there is the Pinstripe Oversized Blazer, made to wear with baggy jeans. The Tobacco Suede Overshirt is the easy in-between layer for crisp mornings. Throw any of them over our ' . $link( '/product-category/clothing/shirts/', 'shirts' ) . ' or ' . $link( '/product-category/clothing/sweater/', 'sweaters' ) . ', and watch every jacket styled in the ' . $reels . '.',
			),
			'accessories' => array(
				'meta' => 'Finish the look: the Classic Black Bucket Hat, Color-Pop Ribbed Socks and Everyday White Crew Socks. Small accessories that pull every outfit together.',
				'text' => 'Accessories are the quickest way to make an outfit look styled. The Classic Black Bucket Hat has a soft structure and a short brim that works with streetwear and knits alike. The Color-Pop Ribbed Socks come as a green and orange 2-pack, made to show off with heels, loafers and sandals.'
					. "\n\n" . 'For everyday wear, the Everyday White Crew Socks are thick, cushioned and bright white in a 3-pack, the finishing touch for clean ' . $link( '/product-category/shoes/', 'sneakers' ) . '. They also make easy gift add-ons next to our ' . $link( '/product-category/beauty/', 'beauty picks' ) . '. See them styled in the ' . $reels . '.',
			),
			'shoes'       => array(
				'meta' => 'Shoes that go with everything: Court Classic white leather sneakers, the feather-light Graphite Cloud Runner and patent leather combat boots.',
				'text' => 'Three pairs cover almost every outfit. The Court Classic White Leather Sneakers are clean and minimal, and they starred in three of our reels. The Graphite Cloud Runner is feather-light with a springy foam sole, built for long walks and morning runs.'
					. "\n\n" . 'When you want more edge, the Patent Leather Combat Boots bring high shine on a chunky lug sole, comfortable from the first wear. Pair the sneakers with our ' . $link( '/product-category/clothing/accessories/', 'white crew socks' ) . ' and ' . $link( '/product-category/clothing/trousers/', 'relaxed trousers' ) . ', or put the boots under the ' . $link( '/product-category/clothing/dresses/', 'black slip dress' ) . '. Watch every pair in the ' . $reels . '.',
			),
			'beauty'      => array(
				'meta' => 'Beauty picks we actually use: cooling hydrogel under-eye patches with caffeine and hyaluronic acid, for brighter, smoother eyes in about 15 minutes.',
				'text' => 'Our beauty shelf is short on purpose. We only stock what we would use ourselves, and right now that means one hero: the Hydrogel Under-Eye Patches. Each box holds 30 pairs of cooling patches with caffeine and hyaluronic acid, made for the mornings after a late night or a long flight.'
					. "\n\n" . 'Put a pair on while you make coffee, take them off 15 minutes later, and your under-eyes look brighter and smoother. They slip into a travel bag, sit happily under make-up and make a thoughtful gift next to our ' . $link( '/product-category/clothing/accessories/', 'accessories' ) . '. See them in action in the ' . $reels . '.',
			),
			'dresses'     => array(
				'meta' => 'The little black dress, made easy: a bias-cut black slip midi dress that works with white sneakers by day and heels or combat boots by night.',
				'text' => 'One dress, endless outfits. The Black Slip Midi Dress is cut on the bias so it skims instead of clings, and its midi length works for the office, dinner and everything in between. It is the little black dress made easy, and it packs flat for weekends away.'
					. "\n\n" . 'Wear it with the ' . $link( '/product-category/shoes/', 'Court Classic white sneakers' ) . ' by day, then switch to heels or patent combat boots at night. Layer the ' . $link( '/product-category/clothing/shirts/', 'Cornflower Satin Shirt' ) . ' open on top, or throw a ' . $link( '/product-category/clothing/jackets/', 'leather biker jacket' ) . ' over it when it gets cold. Watch it styled in the ' . $reels . '.',
			),
			'trousers'    => array(
				'meta' => 'Off-White Relaxed Trousers with an easy, relaxed leg: smart enough for dinner, comfortable enough for a long day out. Pair them with any shirt or knit.',
				'text' => 'The Off-White Relaxed Trousers are the pair that makes everything else look better. The soft fabric and easy, relaxed leg feel like loungewear, but the clean off-white colour looks smart enough for dinner or the office. Roll the hem once to show off sneakers, or leave it long over boots. They work just as well in spring as under a winter coat.'
					. "\n\n" . 'They are the base of half our outfits: try them with the ' . $link( '/product-category/clothing/shirts/', 'Sage Oxford Shirt' ) . ', a cozy ' . $link( '/product-category/clothing/sweater/', 'knit' ) . ' or the ' . $link( '/product-category/clothing/jackets/', 'Tobacco Suede Overshirt' ) . ', then finish with ' . $link( '/product-category/shoes/', 'white leather sneakers' ) . '. See how they move in the ' . $reels . '.',
			),
		),
		'category'    => array(
			'woocommerce'     => array(
				'meta' => 'Practical WooCommerce guides: product videos, build-your-own boxes, mix and match bundles and developer hooks. Step by step, with real store examples.',
				'text' => 'Practical WooCommerce guides: product videos, build-your-own boxes, mix and match bundles and the hooks behind them. Step by step, with real store examples.',
			),
			'web-design-tips' => array(
				'meta' => 'Straight answers on website costs, WordPress vs Shopify and hiring the right web expert, from 7+ years of WordPress and Shopify client work.',
				'text' => 'Straight answers on what a website costs, whether to pick WordPress or Shopify and how to hire the right web expert, from 7+ years of client work.',
			),
		),
	);
}

/**
 * Fills in category descriptions and meta descriptions that are still empty, and gives the product videos
 * guide an SEO title that differs from its H1. Runs from bwe_home_maybe_upgrade(), so edits made in the
 * dashboard afterwards are kept.
 */
function bwe_seo_apply_copy() {
	foreach ( bwe_seo_term_copy() as $taxonomy => $terms ) {
		foreach ( $terms as $slug => $copy ) {
			$term = get_term_by( 'slug', $slug, $taxonomy );
			if ( ! $term ) {
				continue;
			}

			if ( '' === trim( $term->description ) ) {
				wp_update_term( $term->term_id, $taxonomy, array( 'description' => $copy['text'] ) );
			}

			if ( '' === (string) get_term_meta( $term->term_id, 'rank_math_description', true ) ) {
				update_term_meta( $term->term_id, 'rank_math_description', $copy['meta'] );
			}
		}
	}

	$guide = get_page_by_path( 'woocommerce-product-videos', OBJECT, 'post' );
	if ( $guide && get_post_meta( $guide->ID, 'rank_math_title', true ) === $guide->post_title ) {
		update_post_meta( $guide->ID, 'rank_math_title', 'WooCommerce Product Videos: What to Film and Where to Add Them' );
	}
}
