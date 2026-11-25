<?php
/**
 * ProductReels demo store pages: Shop the look, Lookbook and Reel layouts.
 *
 * Shared pieces for the three demo patterns (the demo bar, the closing call to action and
 * product images pulled from WooCommerce) and their stylesheet, assets/demo.css.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * The demo pages, keyed by the slug the demo bar uses.
 *
 * @return array<string, array{title: string, path: string}>
 */
function bwe_demo_pages() {
	return array(
		'shop-the-look' => array(
			'title' => __( 'Shop the look', 'bestwebexpert-home' ),
			'path'  => '/shop-the-look/',
		),
		'lookbook'      => array(
			'title' => __( 'Lookbook', 'bestwebexpert-home' ),
			'path'  => '/lookbook/',
		),
		'reel-layouts'  => array(
			'title' => __( 'Reel layouts', 'bestwebexpert-home' ),
			'path'  => '/reel-layouts/',
		),
	);
}

/**
 * The ProductBoxes demo pages, keyed by the slug the demo bar uses, with the campaign each one shows.
 *
 * @return array<string, array{title: string, path: string, campaign: int}>
 */
function bwe_mmbb_demo_pages() {
	return array(
		'capsule-wardrobe-box' => array(
			'title'    => __( 'Tiered discount', 'bestwebexpert-home' ),
			'path'     => '/capsule-wardrobe-box/',
			'campaign' => 755,
		),
		'gift-box-builder'     => array(
			'title'    => __( 'Box sizes', 'bestwebexpert-home' ),
			'path'     => '/gift-box-builder/',
			'campaign' => 757,
		),
		'shirt-bundle'         => array(
			'title'    => __( 'Bundle price', 'bestwebexpert-home' ),
			'path'     => '/shirt-bundle/',
			'campaign' => 759,
		),
	);
}


/**
 * Enqueues the display font and demo stylesheet on the demo pages and inside the block editor.
 */
function bwe_demo_enqueue_assets() {
	if ( ! is_admin() && ! bwe_home_is_needed( 'bwe-demo' ) ) {
		return;
	}

	wp_enqueue_style(
		'bwe-home-fonts',
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500..800&display=swap',
		array(),
		null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Google Fonts URLs are versioned by their query string.
	);

	wp_enqueue_style(
		'bwe-demo',
		plugins_url( 'assets/demo.css', BWE_HOME_DIR . '/site.php' ),
		array( 'bwe-home-fonts' ),
		(string) filemtime( BWE_HOME_DIR . '/assets/demo.css' )
	);
}
add_action( 'enqueue_block_assets', 'bwe_demo_enqueue_assets' );

/**
 * A product price as short text: "$129" or "<s>$159</s> $129" when it is on sale.
 *
 * @param WC_Product $product Product.
 * @return string HTML.
 */
function bwe_demo_price( $product ) {
	$symbol = html_entity_decode( get_woocommerce_currency_symbol(), ENT_QUOTES, 'UTF-8' );
	$format = static function ( $amount ) use ( $symbol ) {
		$amount = (float) $amount;
		return esc_html( $symbol . ( floor( $amount ) === $amount ? number_format( $amount ) : number_format( $amount, 2 ) ) );
	};

	if ( $product->is_on_sale() && $product->get_regular_price() ) {
		return '<s>' . $format( $product->get_regular_price() ) . '</s> ' . $format( $product->get_price() );
	}

	return $format( $product->get_price() );
}

/**
 * Returns a WooCommerce product, or null when WooCommerce or the product is missing.
 *
 * @param int $product_id Product ID.
 * @return WC_Product|null
 */
function bwe_demo_product( $product_id ) {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return null;
	}

	$product = wc_get_product( $product_id );

	return $product && 'publish' === $product->get_status() ? $product : null;
}

/**
 * core/image block markup for a product's photo, linked to the product.
 *
 * @param int    $product_id Product ID.
 * @param string $classname  Extra class for the figure.
 * @param string $alt        Alt text.
 * @param bool   $caption    Whether to add the product name and price as the caption.
 * @return string Block markup, or an empty string when the product or its photo is missing.
 */
function bwe_demo_product_image( $product_id, $classname, $alt, $caption = false ) {
	$product = bwe_demo_product( $product_id );
	$id      = $product ? (int) $product->get_image_id() : 0;
	$src     = $id ? wp_get_attachment_image_url( $id, 'large' ) : false;

	if ( ! $src ) {
		return '';
	}

	$attrs = array(
		'id'              => $id,
		'sizeSlug'        => 'large',
		'linkDestination' => 'custom',
		'className'       => $classname,
	);

	$figcaption = $caption
		? sprintf(
			'<figcaption class="wp-element-caption"><strong>%s</strong> <span>%s</span></figcaption>',
			esc_html( $product->get_name() ),
			bwe_demo_price( $product )
		)
		: '';

	return sprintf(
		"<!-- wp:image %s -->\n<figure class=\"wp-block-image size-large %s\"><a href=\"%s\"><img src=\"%s\" alt=\"%s\" class=\"wp-image-%d\"/></a>%s</figure>\n<!-- /wp:image -->",
		wp_json_encode( $attrs ),
		esc_attr( $classname ),
		esc_url( $product->get_permalink() ),
		esc_url( $src ),
		esc_attr( $alt ),
		$id,
		$figcaption
	);
}

/**
 * A product name linked to the product, followed by its price, for price lists and tags.
 *
 * @param int $product_id Product ID.
 * @return string HTML, or an empty string when the product is missing.
 */
function bwe_demo_product_line( $product_id ) {
	$product = bwe_demo_product( $product_id );

	if ( ! $product ) {
		return '';
	}

	return sprintf(
		'<a href="%s">%s</a> <span>%s</span>',
		esc_url( $product->get_permalink() ),
		esc_html( $product->get_name() ),
		bwe_demo_price( $product )
	);
}

/**
 * A product name linked to the product, for running text.
 *
 * @param int $product_id Product ID.
 * @return string HTML, or an empty string when the product is missing.
 */
function bwe_demo_product_link( $product_id ) {
	$product = bwe_demo_product( $product_id );

	if ( ! $product ) {
		return '';
	}

	return sprintf( '<a href="%s">%s</a>', esc_url( $product->get_permalink() ), esc_html( $product->get_name() ) );
}

/**
 * The plugin a set of demo pages shows off: its name, landing page, download link and closing copy.
 *
 * @param string $plugin "reels" for ProductReels or "mmbb" for ProductBoxes.
 * @return array<string, mixed>
 */
function bwe_demo_plugin( $plugin ) {
	if ( 'mmbb' === $plugin ) {
		return array(
			'name'    => 'ProductBoxes',
			'full'    => 'ProductBoxes',
			'landing' => '/productboxes/',
			'wporg'   => 'https://wordpress.org/plugins/productboxes-mix-and-match-box-builder/',
			'pages'   => bwe_mmbb_demo_pages(),
			'anchor'  => 'get-productboxes',
			'title'   => 'Like what you see? Put a box builder on <em>your</em> store',
			'lead'    => 'Everything on this page is ProductBoxes running on a normal WooCommerce store. Install it free, create a campaign and publish it with a block. No code needed.',
			'meta'    => '3 campaign types · Tiered discounts · Gift wrap and messages · Analytics built in · Free forever',
		);
	}

	return array(
		'name'    => 'ProductReels',
		'full'    => 'ProductReels',
		'landing' => '/productreels/',
		'wporg'   => 'https://wordpress.org/plugins/productreels/',
		'pages'   => bwe_demo_pages(),
		'anchor'  => 'get-productreels',
		'title'   => 'Like what you see? Put reels like these on <em>your</em> store',
		'lead'    => 'Everything on this page is ProductReels running on a normal WooCommerce store. Install it free, tag your products in your videos and pick a layout. No code needed.',
		'meta'    => '5 layouts · 2 shapes · Add to cart inside the video · Click stats built in · Free forever',
	);
}

/**
 * The dark bar at the top of every demo page: what this is, a switcher between the demos, and the download link.
 *
 * @param string $current Slug of the current demo page.
 * @param string $plugin  Plugin the demo shows, see bwe_demo_plugin().
 * @return string Block markup.
 */
function bwe_demo_bar( $current, $plugin = 'reels' ) {
	$info = bwe_demo_plugin( $plugin );
	$tabs = '';

	foreach ( $info['pages'] as $slug => $page ) {
		$tabs .= sprintf(
			'<a href="%s"%s>%s</a>',
			esc_url( home_url( $page['path'] ) ),
			$slug === $current ? ' aria-current="page"' : '',
			esc_html( $page['title'] )
		);
	}

	ob_start();
	?>
<!-- wp:group {"tagName":"aside","className":"bwe-demo-bar"} -->
<aside class="wp-block-group bwe-demo-bar"><!-- wp:paragraph {"className":"bwe-demo-bar__label"} -->
<p class="bwe-demo-bar__label"><strong>Live demo</strong> Built with <a href="<?php echo esc_url( home_url( $info['landing'] ) ); ?>"><?php echo esc_html( $info['name'] ); ?></a><span class="bwe-demo-bar__more">, our free WooCommerce plugin</span></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"bwe-demo-bar__tabs"} -->
<p class="bwe-demo-bar__tabs"><?php echo $tabs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"bwe-demo-bar__cta"} -->
<p class="bwe-demo-bar__cta"><a href="<?php echo esc_url( $info['wporg'] ); ?>" target="_blank" rel="noreferrer noopener">Get it free →</a></p>
<!-- /wp:paragraph --></aside>
<!-- /wp:group -->
	<?php
	return trim( (string) ob_get_clean() );
}

/**
 * The closing call to action, in the BestWebExpert brand rather than the demo store's.
 *
 * @param string $plugin Plugin the demo shows, see bwe_demo_plugin().
 * @return string Block markup.
 */
function bwe_demo_cta( $plugin = 'reels' ) {
	$info = bwe_demo_plugin( $plugin );
	ob_start();
	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- Title, lead and meta are fixed strings in bwe_demo_plugin().
	?>
<!-- wp:group {"tagName":"section","className":"bwe-demo-sec bwe-demo-cta"} -->
<section class="wp-block-group bwe-demo-sec bwe-demo-cta"><!-- wp:paragraph {"className":"bwe-demo-eyebrow"} -->
<p class="bwe-demo-eyebrow"><?php echo esc_html( $info['full'] ); ?> · Free on WordPress.org</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"bwe-demo-cta__title","anchor":"<?php echo esc_attr( $info['anchor'] ); ?>"} -->
<h2 class="wp-block-heading bwe-demo-cta__title" id="<?php echo esc_attr( $info['anchor'] ); ?>"><?php echo $info['title']; ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"bwe-demo-lead"} -->
<p class="bwe-demo-lead"><?php echo $info['lead']; ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"bwe-demo-btns"} -->
<div class="wp-block-buttons bwe-demo-btns"><!-- wp:button {"className":"bwe-demo-btn bwe-demo-btn--lime"} -->
<div class="wp-block-button bwe-demo-btn bwe-demo-btn--lime"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $info['wporg'] ); ?>" target="_blank" rel="noreferrer noopener">Download free on WordPress.org →</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"bwe-demo-btn bwe-demo-btn--ghost"} -->
<div class="wp-block-button bwe-demo-btn bwe-demo-btn--ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Want us to set it up?</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"className":"bwe-demo-cta__meta"} -->
<p class="bwe-demo-cta__meta"><?php echo $info['meta']; ?></p>
<!-- /wp:paragraph --></section>
<!-- /wp:group -->
	<?php
	// phpcs:enable
	return trim( (string) ob_get_clean() );
}
