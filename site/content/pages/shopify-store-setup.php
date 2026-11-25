<?php
/**
 * Shopify store setup service page. Rendered by bwe_pb_service_page().
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact = home_url( '/contact/' );

return array(
	'title'    => 'Shopify Store Setup Service',
	'platform' => 'shopify',
	'seo'      => array(
		'title'       => 'Shopify Store Setup Service: Ready to Sell From $250',
		'description' => 'Shopify store setup service: theme design, products, payments, shipping, taxes and apps, done for you. A complete, ready-to-sell Shopify store from $250.',
		'keyword'     => 'Shopify store setup,Shopify store setup service,Shopify store design,build Shopify store,Shopify developer',
		'og_title'    => 'Shopify Store Setup: A Ready-to-Sell Store From $250',
		'image'       => 'shopify',
	),
	'hero'     => array(
		'pill'    => 'Complete stores from $250 — see packages →',
		'kicker'  => 'Launch a store that looks like a brand, not a template',
		'h1'      => 'Shopify Store Setup That Gets You <em>Selling Fast</em>',
		'lead'    => 'Our Shopify store setup service gives you a complete, ready-to-sell store: a theme designed around your brand, products and collections, payments, shipping, taxes, policies, emails and the apps you actually need, all tested on real phones before launch.',
		'cta'     => 'Set up my store',
		'num'     => '$250',
		'label'   => 'starting price for a complete Shopify store, launched in 3–5 weeks',
		'checks'  => array( 'Theme design &amp; branding', 'Products, payments &amp; shipping', 'SEO, apps &amp; launch support' ),
		'sticker' => 'Ready to sell ✦',
	),
	'marquee'  => array( 'Store Design', 'Theme Setup', 'Product Upload', 'Collections', 'Shopify Payments', 'Shipping Rates', 'Taxes', 'Apps', 'Shopify SEO', 'Launch Support' ),
	'signs'    => array(
		'eyebrow' => 'Common mistakes',
		'h2'      => '6 Shopify Setup Mistakes That <em>Cost You Sales</em>',
		'anchor'  => 'shopify-setup-mistakes',
		'lead'    => 'Most DIY Shopify stores make at least three of these. Each one quietly lowers your conversion rate.',
		'items'   => array(
			array( 'An unchanged default theme.', 'Shoppers can tell, and a generic store doesn’t build trust.' ),
			array( 'Thin product pages.', 'Few photos, short descriptions and no reviews mean fewer sales.' ),
			array( 'Confusing shipping costs.', 'Surprise fees at checkout are the top reason for abandoned carts.' ),
			array( 'Too many apps.', 'Each one slows the store and adds a monthly bill.' ),
			array( 'Missing policies and trust signals.', 'No returns policy or contact details makes buyers nervous.' ),
			array( 'No SEO setup.', 'Products without titles and descriptions never show up on Google.' ),
		),
	),
	'included' => array(
		'eyebrow' => 'What’s included',
		'h2'      => 'What Our Shopify Store Setup <em>Includes</em>',
		'anchor'  => 'what-is-included',
		'lead'    => 'Everything you need to start selling, done properly from day one.',
		'cards'   => array(
			array( '', 'Theme design', 'A fast Online Store 2.0 theme customized to your brand: colors, fonts, homepage, product and collection pages.' ),
			array( '', 'Products &amp; collections', 'Products, variants, images and collections set up, with descriptions written to sell and rank.' ),
			array( '', 'Payments &amp; checkout', 'Shopify Payments, PayPal and local payment methods, with a checkout tested from cart to confirmation.' ),
			array( '', 'Shipping &amp; taxes', 'Shipping zones, rates, free-shipping rules and tax settings for the countries you sell to.' ),
			array( '', 'Apps &amp; marketing', 'Reviews, email marketing, Google and Meta sales channels, and only the apps you really need.' ),
			array( '', 'SEO &amp; launch', 'Titles, descriptions, policies, domain, analytics and a launch checklist, plus training on running your store.' ),
		),
	),
	'packages' => array(
		'eyebrow' => 'Packages',
		'h2'      => 'Shopify Store Setup <em>Prices</em>',
		'anchor'  => 'shopify-store-setup-price',
		'lead'    => 'Fixed prices for complete stores. Your Shopify plan and paid apps are billed by Shopify.',
		'plans'   => array(
			array( 'Starter', '$250', '/ store', 'For new brands with a small catalog.', array( 'Up to 30 products', 'Premium theme customized to your brand', 'Payments, shipping &amp; tax', 'Policies &amp; legal pages', '14 days of free support' ), false, 'Choose Starter', $contact ),
			array( 'Growth', '$1,499', '/ store', 'For brands that want a store that converts.', array( 'Up to 300 products', 'Custom homepage &amp; product page design', 'Custom Liquid sections', 'Reviews, upsells &amp; email setup', '30 days of free support' ), true, 'Choose Growth →', $contact ),
			array( 'Custom', 'Let’s talk', '', 'For large catalogs, Shopify Plus and custom apps.', array( 'Shopify Plus features', 'Custom apps &amp; integrations', 'Wholesale &amp; B2B', 'Multiple markets &amp; languages', 'Priority support' ), false, 'Get a custom quote', $contact ),
		),
		'note'    => 'Moving from another platform? See our <a href="' . esc_url( home_url( '/migrate-to-shopify/' ) ) . '">migration to Shopify</a> service.',
	),
	'steps_h2' => 'Launch Your Shopify Store in 4 Steps. <em>In 3–5 Weeks.</em>',
	'why'      => array(
		'eyebrow'    => 'Why BestWebExpert',
		'h2'         => 'Why Let a Shopify Expert Set Up Your Store',
		'anchor'     => 'why-let-a-shopify-expert-set-up-your-store',
		'paragraphs' => array(
			'Anyone can open a Shopify account. Building a store that turns visitors into buyers is different: it takes the right theme setup, persuasive product pages, clear shipping and a checkout without friction.',
			'We’ve built and looked after online stores for more than seven years, on Shopify and WooCommerce. We set up only what you need, so your store stays fast and your monthly app bill stays low.',
			'You get a fixed price, a clear launch date and a store you fully own and know how to run.',
		),
		'image'      => array( 'shopify', 'Shopify store setup and design for a skincare brand' ),
		'card_title' => 'Every store setup includes',
		'checks'     => array( 'Mobile-first design', 'Products set up to sell and rank', 'Checkout tested end to end', 'Training on running your store', 'Free post-launch support' ),
	),
	'faq'      => array(
		'h2'     => 'Shopify Store Setup <em>FAQ</em>',
		'anchor' => 'shopify-store-setup-faq',
		'lead'   => 'Planning a new store? Ask us anything about Shopify.',
		'items'  => array(
			array( 'How much does Shopify store setup cost?', 'A complete Shopify store starts at $250, a Growth store with custom design starts at $1,499, and larger projects get a fixed quote. Your Shopify plan and any paid apps are billed separately by Shopify.' ),
			array( 'How long does it take to set up a Shopify store?', 'Most stores launch in 3–5 weeks, depending on the number of products and how much custom design you need.' ),
			array( 'Do I need to buy a premium theme?', 'Not always. Shopify’s free themes are fast and flexible. If a premium theme fits your brand better, we’ll recommend one and buy it in your name.' ),
			array( 'Can you add my products?', 'Yes. We can import them from a spreadsheet or another platform, or add them by hand with images, variants and SEO descriptions.' ),
			array( 'Which Shopify plan do I need?', 'Most new stores start on the Basic plan. We’ll recommend the right plan for your sales volume and features.' ),
			array( 'Will I be able to manage the store myself?', 'Yes. We train you on adding products, handling orders and editing pages, and we’re here if you need help later.' ),
		),
	),
	'final'    => array(
		'h2'   => 'Ready to Launch Your <em>Shopify Store</em>?',
		'lead' => 'Tell us what you sell. You’ll get a fixed price and launch date, usually within 2 hours.',
	),
	'related'  => array(
		'shopify-theme-customization' => 'Shopify theme customization',
		'shopify-speed-optimization'  => 'Shopify speed optimization',
	),
	'schema'   => array(
		'name'        => 'Shopify store setup service',
		'type'        => 'Shopify store setup',
		'description' => 'Complete Shopify store setup: theme design, products and collections, payments, shipping, taxes, apps, SEO and launch support.',
		'catalog'     => 'Shopify store setup packages',
		'prices'      => array(
			'Starter Shopify store' => 699,
			'Growth Shopify store'  => 1499,
		),
	),
);
