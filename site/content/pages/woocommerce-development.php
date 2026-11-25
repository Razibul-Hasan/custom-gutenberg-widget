<?php
/**
 * WooCommerce development service page. Rendered by bwe_pb_service_page().
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact = home_url( '/contact/' );

return array(
	'title'    => 'WooCommerce Development Services',
	'platform' => 'wordpress',
	'seo'      => array(
		'title'       => 'WooCommerce Development Services: Stores From $400',
		'description' => 'WooCommerce development services: new stores, custom features, payment and shipping setup, fixes and speed. Built by WooCommerce plugin authors. Stores from $400.',
		'keyword'     => 'WooCommerce development,WooCommerce developer,WooCommerce store development,WooCommerce customization,hire WooCommerce expert',
		'og_title'    => 'WooCommerce Development by WooCommerce Plugin Authors',
		'image'       => 'reels',
	),
	'hero'     => array(
		'pill'    => 'WooCommerce stores from $400 — see packages →',
		'kicker'  => 'Sell online inside WordPress, with no monthly platform fees',
		'h1'      => 'WooCommerce Development for Stores That <em>Sell More</em>',
		'lead'    => 'Our WooCommerce development services cover everything from a brand-new store to custom features, payment and shipping setup, fixes and speed. We build WooCommerce plugins of our own, so your store is in the hands of people who know WooCommerce inside out.',
		'cta'     => 'Build my store',
		'num'     => '$400',
		'label'   => 'starting price for a complete WooCommerce store, launched in 3–5 weeks',
		'checks'  => array( 'New stores &amp; redesigns', 'Custom WooCommerce features', 'Fixes, speed &amp; checkout' ),
		'sticker' => 'WooCommerce plugin authors ✦',
	),
	'marquee'  => array( 'WooCommerce Stores', 'Product Setup', 'Payments', 'Shipping &amp; Tax', 'Subscriptions', 'Bundles &amp; Boxes', 'Product Videos', 'Checkout Optimization', 'Custom Plugins', 'Store Speed' ),
	'signs'    => array(
		'eyebrow' => 'Sound familiar?',
		'h2'      => '6 Signs Your Store Needs a <em>WooCommerce Developer</em>',
		'anchor'  => 'signs-you-need-a-woocommerce-developer',
		'lead'    => 'WooCommerce can do almost anything, but only when it’s set up properly. These problems cost stores sales every day.',
		'items'   => array(
			array( 'Shoppers abandon the checkout.', 'Too many fields, surprise costs or a slow checkout send them away.' ),
			array( 'Your store is slow.', 'Heavy themes and plugins make product pages crawl on mobile.' ),
			array( 'You need a feature no plugin does well.', 'Custom pricing, bundles, bookings or integrations.' ),
			array( 'Updates keep breaking things.', 'Conflicts between plugins break carts and payments.' ),
			array( 'Managing products takes forever.', 'Hundreds of variations and manual stock updates eat your day.' ),
			array( 'Your store looks like every other store.', 'A generic theme doesn’t build trust or a brand.' ),
		),
	),
	'included' => array(
		'eyebrow' => 'Services',
		'h2'      => 'Our WooCommerce Development <em>Services</em>',
		'anchor'  => 'woocommerce-development-services',
		'lead'    => 'Whether you’re launching your first store or growing an established one, we cover every part of WooCommerce.',
		'cards'   => array(
			array( 'From $400', 'New WooCommerce store', 'A complete store: design, products, payments, shipping, taxes, emails and a fast, mobile-first checkout.' ),
			array( 'From $40 / page', 'WooCommerce customization', 'Product pages, shop filters, cart and checkout changes, custom fields and email templates.' ),
			array( 'Fixed quote', 'Custom WooCommerce plugins', 'Bundles, build-your-own boxes, custom pricing, B2B features and API integrations built to last.' ),
			array( 'From $20', 'WooCommerce fixes', 'Broken checkout, payment errors, missing orders, plugin conflicts and update problems.' ),
			array( 'From $199', 'WooCommerce speed', 'Faster product, cart and checkout pages, so more shoppers finish their order.' ),
			array( 'From $149', 'Store migration', 'Move products, customers and orders from Shopify, Wix or another platform to WooCommerce.' ),
		),
	),
	'packages' => array(
		'eyebrow' => 'Packages',
		'h2'      => 'WooCommerce Development <em>Prices</em>',
		'anchor'  => 'woocommerce-development-price',
		'lead'    => 'Fixed prices for complete stores. Every package includes mobile-first design, on-page SEO and speed optimization.',
		'plans'   => array(
			array( 'Starter store', '$400', '/ project', 'For new brands with a small catalog.', array( 'Up to 30 products', 'Premium theme customized to your brand', 'Payments, shipping &amp; tax', 'Order emails &amp; legal pages', '14 days of free support' ), false, 'Choose Starter', $contact ),
			array( 'Growth store', '$599', '/ project', 'For brands ready to scale.', array( 'Up to 300 products', 'Custom design &amp; product pages', 'Checkout optimization', 'Reviews, upsells &amp; email marketing', '30 days of free support' ), true, 'Choose Growth →', $contact ),
			array( 'Custom', 'Let’s talk', '', 'For custom features, integrations and large catalogs.', array( 'Custom WooCommerce plugins', 'ERP, CRM &amp; API integrations', 'Subscriptions &amp; memberships', 'B2B &amp; wholesale pricing', 'Priority support' ), false, 'Get a custom quote', $contact ),
		),
		'note'    => 'Premium plugins and themes, if needed, are bought in your name so you own the licenses.',
	),
	'steps_h2' => 'Launch Your WooCommerce Store in 4 Steps. <em>In 3–5 Weeks.</em>',
	'why'      => array(
		'eyebrow'    => 'Why BestWebExpert',
		'h2'         => 'Why Hire WooCommerce Plugin Authors to Build Your Store',
		'anchor'     => 'why-hire-woocommerce-plugin-authors',
		'paragraphs' => array(
			'We don’t just install WooCommerce. We build plugins for it, including shoppable video reels and build-your-own box tools, so we know how products, carts and checkouts work at the code level.',
			'That means fewer plugins, faster pages and features that work the way your customers expect, built in a way that survives WooCommerce updates.',
			'You get a fixed price, a clear timeline and a store you fully own, with no monthly platform fees.',
		),
		'image'      => array( 'reels', 'WooCommerce development: shoppable video reels on a WooCommerce store' ),
		'card_title' => 'Every WooCommerce project includes',
		'checks'     => array( 'Mobile-first, fast checkout', 'On-page SEO for products', 'Payment &amp; shipping testing', 'Training on managing your store', 'Free post-launch support' ),
	),
	'faq'      => array(
		'h2'     => 'WooCommerce Development <em>FAQ</em>',
		'anchor' => 'woocommerce-development-faq',
		'lead'   => 'Planning a store? Ask us anything about WooCommerce.',
		'items'  => array(
			array( 'How much does WooCommerce development cost?', 'A complete WooCommerce store starts at $400, a growth store at $599 and custom builds are quoted per project. Smaller fixes start at $20 and customizations at $40 per page.' ),
			array( 'How long does it take to build a WooCommerce store?', 'Most stores launch in 3–5 weeks. Larger catalogs and custom features get a written timeline before we start.' ),
			array( 'WooCommerce or Shopify: which is better?', 'WooCommerce gives you full control and no platform fees; Shopify is simpler to run. Read our <a href="' . esc_url( home_url( '/wordpress-vs-shopify-which-should-you-choose/' ) ) . '">WordPress vs Shopify comparison</a> or ask us for an honest recommendation.' ),
			array( 'Can you add products for me?', 'Yes. We can import products from a spreadsheet or another platform, or add them by hand, including variations, images and SEO descriptions.' ),
			array( 'Can you build a custom WooCommerce feature?', 'Yes. Custom pricing, bundles, bookings, B2B features and integrations are what we do best. You get a fixed quote after a short call.' ),
			array( 'Do you fix existing WooCommerce stores?', 'Yes. Checkout errors, payment problems, plugin conflicts and slow stores. Fixes start at $20.' ),
		),
	),
	'final'    => array(
		'h2'   => 'Let’s Build a WooCommerce Store <em>That Sells</em>',
		'lead' => 'Tell us what you sell and what you need. You’ll get a fixed price and timeline, usually within 2 hours.',
	),
	'related'  => array(
		'wordpress-speed-optimization' => 'WordPress speed optimization',
		'shopify-store-setup'          => 'Shopify store setup',
	),
	'schema'   => array(
		'name'        => 'WooCommerce development services',
		'type'        => 'WooCommerce development',
		'description' => 'WooCommerce development: new stores, customization, custom plugins, fixes, speed optimization and store migration.',
		'catalog'     => 'WooCommerce development packages',
		'prices'      => array(
			'WooCommerce starter store' => 799,
			'WooCommerce growth store'  => 1499,
			'WooCommerce customization' => 49,
			'WooCommerce fixes'         => 25,
		),
	),
);
