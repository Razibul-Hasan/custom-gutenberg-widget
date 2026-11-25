<?php
/**
 * Migration to Shopify service page. Rendered by bwe_pb_service_page().
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact = home_url( '/contact/' );

return array(
	'title'    => 'Migrate to Shopify',
	'platform' => 'shopify',
	'seo'      => array(
		'title'       => 'Migrate to Shopify From WooCommerce, Wix or Etsy From $149',
		'description' => 'Migrate to Shopify from WooCommerce, Wix, Squarespace, BigCommerce or Etsy. Products, customers, orders and 301 redirects moved safely, SEO kept. From $149.',
		'keyword'     => 'migrate to Shopify,WooCommerce to Shopify,Shopify migration service,Wix to Shopify,Etsy to Shopify',
		'og_title'    => 'Migrate to Shopify Without Losing Orders or SEO',
		'image'       => 'versus',
	),
	'hero'     => array(
		'pill'    => 'Shopify migrations from $149 — see packages →',
		'kicker'  => 'Switch platforms without losing products, customers or rankings',
		'h1'      => 'Migrate to Shopify <em>Without Losing a Sale</em>',
		'lead'    => 'Our Shopify migration service moves your products, variants, customers, order history, blog posts and images from WooCommerce, Wix, Squarespace, BigCommerce or Etsy to Shopify, with 301 redirects for every old URL so your Google rankings come with you.',
		'cta'     => 'Move my store',
		'num'     => '$149',
		'label'   => 'starting price to migrate a store to Shopify, done in 3–7 days',
		'checks'  => array( 'Products, customers &amp; orders', '301 redirects &amp; SEO kept', 'Design rebuilt in Shopify' ),
		'sticker' => 'SEO-safe migration ✦',
	),
	'marquee'  => array( 'WooCommerce to Shopify', 'Wix to Shopify', 'Squarespace to Shopify', 'BigCommerce to Shopify', 'Etsy to Shopify', 'Products', 'Customers', 'Order History', '301 Redirects', 'Reviews' ),
	'signs'    => array(
		'eyebrow' => 'Thinking of switching?',
		'h2'      => '6 Reasons Store Owners <em>Move to Shopify</em>',
		'anchor'  => 'reasons-to-migrate-to-shopify',
		'lead'    => 'If running your store feels harder every month, these are the reasons most brands make the switch.',
		'items'   => array(
			array( 'You’re tired of updates and plugin conflicts.', 'Shopify handles hosting, security and updates for you.' ),
			array( 'Your store keeps going down under traffic.', 'Shopify scales for sales and launches without server worries.' ),
			array( 'Checkout is clunky.', 'Shopify’s checkout and Shop Pay are trusted by shoppers and convert well.' ),
			array( 'You’ve outgrown Wix, Squarespace or Etsy.', 'More apps, more control and your own brand instead of a marketplace.' ),
			array( 'You want to sell everywhere.', 'Google, Meta, TikTok and marketplaces connect in a few clicks.' ),
			array( 'You’re afraid of losing SEO.', 'That’s why redirects and a careful migration plan matter so much.' ),
		),
	),
	'included' => array(
		'eyebrow' => 'What’s included',
		'h2'      => 'What We Move When You <em>Migrate to Shopify</em>',
		'anchor'  => 'what-is-included',
		'lead'    => 'A complete move, planned and tested so nothing important gets left behind.',
		'cards'   => array(
			array( '', 'Products &amp; variants', 'Titles, descriptions, prices, variants, SKUs, stock, images and SEO fields mapped correctly.' ),
			array( '', 'Customers &amp; orders', 'Customer accounts and full order history, so you keep your data and your reports.' ),
			array( '', 'Blog posts &amp; pages', 'Content, images and authors moved, with formatting cleaned up for your new theme.' ),
			array( '', '301 redirects', 'Every old product, category and page URL redirected to its new Shopify URL to protect your rankings.' ),
			array( '', 'Design &amp; theme', 'Your look rebuilt on a fast Shopify theme, or a fresh design if it’s time for a change.' ),
			array( '', 'Apps &amp; launch', 'Reviews, email and payment apps set up, plus a final check before we switch your domain.' ),
		),
	),
	'packages' => array(
		'eyebrow' => 'Packages',
		'h2'      => 'Shopify Migration <em>Prices</em>',
		'anchor'  => 'shopify-migration-price',
		'lead'    => 'Fixed prices by store size. Your Shopify plan and migration apps, if used, are billed by Shopify.',
		'plans'   => array(
			array( 'Small store', '$149', '/ store', 'Up to 100 products, moved fast.', array( 'Products, variants &amp; images', 'Customers', '301 redirects', 'Basic theme setup', '14 days of follow-up support' ), false, 'Choose Small store', $contact ),
			array( 'Full migration', '$399', '/ store', 'Up to 1,000 products with order history.', array( 'Everything in Small store', 'Order history &amp; blog posts', 'Reviews moved', 'Design rebuilt in Shopify', '30 days of follow-up support' ), true, 'Choose Full migration →', $contact ),
			array( 'Large store', 'Let’s talk', '', 'Big catalogs, B2B or Shopify Plus.', array( 'Thousands of products', 'Custom data mapping', 'Multiple markets &amp; languages', 'Shopify Plus setup', 'Priority support' ), false, 'Get a custom quote', $contact ),
		),
		'note'    => 'Your old store stays live until the new Shopify store is checked and approved, so you never stop selling.',
	),
	'steps_h2' => 'Move to Shopify in 4 Steps. <em>Your Store Keeps Selling.</em>',
	'why'      => array(
		'eyebrow'    => 'Why BestWebExpert',
		'h2'         => 'Why Trust Us With Your Shopify Migration',
		'anchor'     => 'why-trust-us-with-your-shopify-migration',
		'paragraphs' => array(
			'We know both sides of the move. We build on WooCommerce and WordPress as well as Shopify, so we understand how your old data is stored and how to map it correctly into Shopify.',
			'Migration apps move the data; we make sure it arrives right: variants that match, images in the right order, customers who can log in and redirects for every URL Google knows.',
			'You get a fixed price, a test store to review before launch and a domain switch with no downtime.',
		),
		'image'      => array( 'versus', 'Migrate to Shopify from WooCommerce or WordPress' ),
		'card_title' => 'Every migration includes',
		'checks'     => array( 'Full backup of your old store', 'Test store you review first', '301 redirects for every URL', 'No downtime during the switch', 'Free follow-up support' ),
	),
	'faq'      => array(
		'h2'     => 'Migrate to Shopify <em>FAQ</em>',
		'anchor' => 'migrate-to-shopify-faq',
		'lead'   => 'Thinking about switching? Tell us your platform and store size.',
		'items'  => array(
			array( 'How much does it cost to migrate to Shopify?', 'A small store with up to 100 products starts at $149, a full migration with order history and up to 1,000 products is $399, and larger stores get a fixed quote.' ),
			array( 'Will I lose my Google rankings?', 'Not when it’s done properly. We set up 301 redirects for every product, category and page, keep your SEO titles and descriptions and submit your new sitemap.' ),
			array( 'Can my customers keep their accounts?', 'Customer accounts move with their details and order history. For security, passwords can’t be moved, so customers get an invite to set a new one.' ),
			array( 'Which platforms can you migrate from?', 'WooCommerce, WordPress, Wix, Squarespace, BigCommerce, Etsy, Magento and most other platforms that let you export data.' ),
			array( 'How long does the migration take?', 'Small stores usually take 3–5 days and full migrations about a week. Your old store stays live the whole time.' ),
			array( 'Should I move from WooCommerce to Shopify?', 'It depends on your needs. Read our <a href="' . esc_url( home_url( '/wordpress-vs-shopify-which-should-you-choose/' ) ) . '">WordPress vs Shopify guide</a> or ask us; we work with both, so you get an honest answer.' ),
		),
	),
	'final'    => array(
		'h2'   => 'Ready to <em>Move to Shopify</em>?',
		'lead' => 'Tell us your current platform and how many products you have. You’ll get a fixed price, usually within 2 hours.',
	),
	'related'  => array(
		'shopify-store-setup' => 'Shopify store setup',
		'wordpress-migration' => 'WordPress migration',
	),
	'schema'   => array(
		'name'        => 'Migration to Shopify',
		'type'        => 'Shopify migration',
		'description' => 'Migrate to Shopify from WooCommerce, Wix, Squarespace, BigCommerce or Etsy: products, customers, orders, blog posts and 301 redirects, with SEO kept intact.',
		'catalog'     => 'Shopify migration packages',
		'prices'      => array(
			'Small store migration to Shopify' => 149,
			'Full migration to Shopify'        => 399,
		),
	),
);
