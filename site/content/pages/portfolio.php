<?php
/**
 * Portfolio and reviews page. Rendered by bwe_pb_render().
 *
 * Shows only work visitors can open themselves (the WordPress.org plugins and their live demo stores) and
 * sends them to the marketplace profiles for verified client reviews. Add client case studies to the
 * cards below once their details can be shared.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact = home_url( '/contact/' );
$open    = static function ( $path, $label ) {
	return ' <a href="' . esc_url( 0 === strpos( $path, 'http' ) ? $path : home_url( $path ) ) . '">' . $label . ' →</a>';
};

$profiles = bwe_profiles();
$review   = static function ( $network, $text ) use ( $profiles ) {
	return array( $network, 'Razibul on ' . $network, $text . ' <a href="' . esc_url( $profiles[ $network ] ) . '" target="_blank" rel="me noopener">Open ' . $network . ' profile →</a>' );
};

return array(
	'title'    => 'Portfolio',
	'seo'      => array(
		'title'       => 'WordPress Developer Portfolio: 3 Plugins & 6 Demo Stores',
		'description' => 'A WordPress developer portfolio of live work you can test: three free plugins on WordPress.org, six WooCommerce demo stores and verified 5-star reviews on Fiverr.',
		'keyword'     => 'WordPress developer portfolio,WooCommerce portfolio,WordPress developer reviews,WooCommerce plugin developer',
		'og_title'    => 'WordPress Developer Portfolio: Live Work and Verified Reviews',
		'image'       => 'reels',
	),
	'sections' => array(
		bwe_pb_hero(
			array(
				'pill'      => array( 'Read verified client reviews →', '#reviews' ),
				'kicker'    => 'Don’t trust screenshots. Open the real thing.',
				'h1'        => 'WordPress Developer Portfolio: Live Work You Can <em>Open and Test</em>',
				'lead'      => 'This WordPress developer portfolio shows only work that’s live right now. Install our plugins from WordPress.org, click through the demo stores on your phone, then read what clients say on Fiverr and Upwork. That’s the same quality of work your website gets.',
				'buttons'   => array( array( 'Start my project →', $contact, 'accent' ), array( 'See the work ↓', '#work', 'ghost' ) ),
				'jump'      => array( array( 'Plugins', '#work' ), array( 'Demo stores', '#demos' ), array( 'Reviews', '#reviews' ) ),
				'num'       => '5.0',
				'label'     => 'star rating from clients on Fiverr, with every review public on the profile',
				'checks'    => array( '3 plugins on WordPress.org', '6 live WooCommerce demo stores', 'Verified marketplace reviews' ),
				'sticker_a' => 'All live, all clickable ✦',
				'sticker_b' => '✓ 5.0 on Fiverr',
			)
		),
		bwe_pb_split(
			array(
				'eyebrow'    => 'Why live work only',
				'h2'         => 'A WordPress Developer Portfolio You Can <em>Actually Test</em>',
				'anchor'     => 'about-this-wordpress-developer-portfolio',
				'paragraphs' => array(
					'Screenshots are easy to fake and hard to judge. That’s why this WordPress developer portfolio only lists work you can open yourself: plugins anyone can install from WordPress.org, and WooCommerce demo stores you can click through on your own phone.',
					'Our plugins go through the WordPress.org plugin review, which checks code for security and coding standards: ProductReels, ProductBoxes and MigrateLift all passed it and are live there now. The demo stores run on this very site, so you can feel how fast the pages load and how smooth the cart is.',
					'Client sites usually can’t be shown without permission, so for those, read the verified reviews on Fiverr, where only paying clients can leave feedback. Then judge the work, not the sales pitch.',
				),
				'image'      => array( 'reels', 'WordPress developer portfolio: ProductReels shoppable video reels on a WooCommerce store' ),
				'card_title' => 'What you can check here',
				'checks'     => array( '3 plugins on WordPress.org', '6 live WooCommerce demo stores', 'Page speed on your own phone', 'Verified Fiverr reviews', 'This website itself' ),
				'cta'        => array( 'Start my project →', $contact ),
			)
		),
		bwe_pb_cards(
			array(
				'eyebrow' => 'Our plugins',
				'h2'      => 'WordPress Plugins on <em>WordPress.org</em>',
				'anchor'  => 'wordpress-plugins',
				'grid'    => 'bwe-grid bwe-grid--2',
				'lead'    => 'Built, reviewed and published on the official WordPress plugin directory, free for any site or store to install.',
				'cards'   => array(
					array( 'WordPress.org', 'ProductReels', 'Shoppable video reels for WooCommerce: product videos in carousels, stories, grids and popups, with a visual editor and click analytics.' . $open( '/productreels/', 'See the plugin' ) ),
					array( 'WordPress.org', 'ProductBoxes', 'Build-your-own boxes and mix-and-match bundles for WooCommerce, with tiered discounts, gift options and box analytics.' . $open( '/productboxes/', 'See the plugin' ) ),
					array( 'WordPress.org', 'MigrateLift', 'WordPress migration, backup and restore: move a site to a new host or domain with automatic URL replacement, and keep daily backups.' . $open( '/migrate-lift/', 'See the plugin' ) ),
					array( 'This website', 'BestWebExpert', 'Custom block theme patterns, Rank Math schema, fast Core Web Vitals and every page you’re reading now, built in WordPress with no page builder.' . $open( '/', 'See the home page' ) ),
				),
			),
			'',
			'work'
		),
		bwe_pb_cards(
			array(
				'eyebrow' => 'Live demo stores',
				'h2'      => 'WooCommerce Demo Stores <em>You Can Shop</em>',
				'anchor'  => 'woocommerce-demo-stores',
				'lead'    => 'Real WooCommerce pages built to show what our plugins and custom work can do. Open them on your phone.',
				'cards'   => array(
					array( 'Video commerce', 'Shop the Look', 'Shoppable outfit videos: tap a reel and add every item you see straight to the cart.' . $open( '/shop-the-look/', 'Open the demo' ) ),
					array( 'Video commerce', 'Fall Lookbook', 'An editorial lookbook where every look is a shoppable video.' . $open( '/lookbook/', 'Open the demo' ) ),
					array( 'Video commerce', 'Reel Layouts', 'Carousel, stories, grid, marquee, stacked cards and popup layouts on one page.' . $open( '/reel-layouts/', 'Open the demo' ) ),
					array( 'Bundles', 'Capsule Wardrobe Box', 'A build-your-own wardrobe box with a live price and progress bar.' . $open( '/capsule-wardrobe-box/', 'Open the demo' ) ),
					array( 'Bundles', 'Gift Box Builder', 'Pick the gifts, add a message and wrapping, and checkout as one box.' . $open( '/gift-box-builder/', 'Open the demo' ) ),
					array( 'Bundles', 'Any 3 Shirts for $120', 'A fixed-price “pick any 3” bundle offer that raises average order value.' . $open( '/shirt-bundle/', 'Open the demo' ) ),
				),
			),
			'bwe-tint',
			'demos'
		),
		bwe_pb_cards(
			array(
				'eyebrow' => 'Client reviews',
				'h2'      => 'WordPress Developer Reviews From <em>Real Clients</em>',
				'anchor'  => 'client-reviews',
				'lead'    => 'Marketplace reviews can only be left by clients who actually paid for a project, so they’re the most honest proof we can show.',
				'cards'   => array(
					$review( 'Fiverr', 'Rated 5.0 by clients for custom WordPress themes, plugins and WooCommerce work. Reviewers mention on-time delivery and fast fixes, like a white-screen error solved quickly.' ),
					$review( 'Upwork', 'Prefer hiring through a marketplace? Hire Razibul on Upwork with Upwork’s payment protection, and see the feedback from completed jobs on the profile.' ),
					$review( 'LinkedIn', 'Razibul’s professional profile and work history. Connect there to follow new plugins and projects.' ),
				),
			),
			'',
			'reviews'
		),
		bwe_pb_final(
			array(
				'h2'      => 'Want Work Like This? <em>Let’s Talk.</em>',
				'anchor'  => '',
				'lead'    => 'Tell us about your website or store. You’ll get honest advice and a fixed price, usually within 2 hours.',
				'buttons' => array( array( 'Start my project →', $contact, 'primary' ), array( 'See pricing', home_url( '/pricing/' ), 'ghost' ) ),
				'note'    => 'No pressure. No sales pitch. Just honest advice.',
			)
		),
	),
);
