<?php
/**
 * Shopify speed optimization service page. Rendered by bwe_pb_service_page().
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact = home_url( '/contact/' );

return array(
	'title'    => 'Shopify Speed Optimization Service',
	'platform' => 'shopify',
	'seo'      => array(
		'title'       => 'Shopify Speed Optimization Service From $79 %sep% %sitename%',
		'description' => 'Shopify speed optimization that makes your store load fast on mobile: app cleanup, image optimization, theme code fixes and Core Web Vitals. Fixed price from $79.',
		'keyword'     => 'Shopify speed optimization,speed up Shopify store,Shopify page speed,Shopify Core Web Vitals,Shopify speed expert',
		'og_title'    => 'Shopify Speed Optimization: A Faster Store From $79',
		'image'       => 'mobile',
	),
	'hero'     => array(
		'pill'    => 'Speed fixes from $79 — see packages →',
		'kicker'  => 'A slow store loses shoppers before they see your products',
		'h1'      => 'Shopify Speed Optimization for a Store That <em>Loads Fast</em>',
		'lead'    => 'Our Shopify speed optimization service removes leftover app code, compresses images, defers heavy scripts and cleans up your theme until your store feels instant on mobile. Fixed price, before-and-after report, and your design stays exactly as it is.',
		'cta'     => 'Speed up my store',
		'num'     => '$79',
		'label'   => 'starting price for Shopify speed optimization, done in 2–3 days',
		'checks'  => array( 'App &amp; script cleanup', 'Image &amp; theme optimization', 'Before-and-after speed report' ),
		'sticker' => 'Design stays the same ✦',
	),
	'marquee'  => array( 'Core Web Vitals', 'LCP', 'INP', 'CLS', 'App Cleanup', 'Leftover Code', 'Image Optimization', 'Lazy Loading', 'Font Loading', 'Theme Code' ),
	'signs'    => array(
		'eyebrow' => 'Is your store slow?',
		'h2'      => '6 Reasons Your <em>Shopify Store</em> Is Slow',
		'anchor'  => 'why-is-my-shopify-store-slow',
		'lead'    => 'Shopify’s servers are fast. When a store is slow, the cause is almost always one of these.',
		'items'   => array(
			array( 'Too many apps.', 'Each app adds scripts and styles to every page, even pages that don’t use it.' ),
			array( 'Leftover code from deleted apps.', 'Uninstalling an app often leaves its code behind in your theme.' ),
			array( 'Huge images.', 'Uncompressed hero banners and product photos are the biggest single cause of slow pages.' ),
			array( 'Heavy sliders and videos.', 'Autoplay videos and big sliders above the fold slow the first view.' ),
			array( 'Too many fonts and tracking scripts.', 'Each one delays the moment shoppers can see and tap.' ),
			array( 'An old or heavy theme.', 'Older themes load everything up front instead of when needed.' ),
		),
	),
	'included' => array(
		'eyebrow' => 'What’s included',
		'h2'      => 'What Our Shopify Speed Optimization <em>Includes</em>',
		'anchor'  => 'what-is-included',
		'lead'    => 'We measure first, fix the real bottlenecks and show you the difference.',
		'cards'   => array(
			array( '', 'Speed audit', 'PageSpeed and Core Web Vitals tests on your homepage, collection and product pages.' ),
			array( '', 'App audit &amp; cleanup', 'We find which apps slow you down, remove leftover code and suggest lighter alternatives.' ),
			array( '', 'Image optimization', 'Right-sized, compressed images with lazy loading, so pages load fast without looking worse.' ),
			array( '', 'Theme code fixes', 'Deferred scripts, preloaded key assets, fewer fonts and cleaner Liquid where it matters.' ),
			array( '', 'Layout shift fixes', 'Stable images, banners and fonts, so the page doesn’t jump while it loads.' ),
			array( '', 'Before &amp; after report', 'Clear before-and-after scores, plus a list of what to avoid to keep your store fast.' ),
		),
	),
	'packages' => array(
		'eyebrow' => 'Packages',
		'h2'      => 'Shopify Speed Optimization <em>Prices</em>',
		'anchor'  => 'shopify-speed-optimization-price',
		'lead'    => 'Fixed prices. If we can’t make your store measurably faster, you don’t pay.',
		'plans'   => array(
			array( 'Basic', '$79', '/ store', 'For smaller stores with a few slow pages.', array( 'Speed audit of 3 key pages', 'Image optimization', 'Leftover app code removal', 'Before-and-after report' ), false, 'Choose Basic', $contact ),
			array( 'Advanced', '$149', '/ store', 'For stores that must pass Core Web Vitals.', array( 'Everything in Basic', 'Core Web Vitals fixes', 'Script &amp; font optimization', 'App audit with lighter alternatives', '14 days of follow-up support' ), true, 'Choose Advanced →', $contact ),
			array( 'Pro', '$249', '/ store', 'For large catalogs and heavily customized themes.', array( 'Everything in Advanced', 'Theme code refactoring', 'Collection &amp; search page tuning', 'Custom sections to replace apps', '30 days of follow-up support' ), false, 'Choose Pro', $contact ),
		),
		'note'    => 'All work is done on a duplicate theme first, so your live store keeps selling during the optimization.',
	),
	'steps_h2' => 'A Faster Shopify Store in 4 Steps. <em>Usually in 2–3 Days.</em>',
	'why'      => array(
		'eyebrow'    => 'Why BestWebExpert',
		'h2'         => 'Why Hire Us for Shopify Speed Optimization',
		'anchor'     => 'why-hire-us-for-shopify-speed-optimization',
		'paragraphs' => array(
			'Speed apps promise one-click fixes, but they can’t remove the code other apps left behind or fix how your theme loads. Real gains come from working in the theme code.',
			'We work in Liquid every day and know which theme and app patterns slow stores down. We keep your design the same and make it load faster.',
			'You get a fixed price, a duplicate-theme preview and a before-and-after report. No improvement, no fee.',
		),
		'image'      => array( 'mobile', 'Shopify speed optimization for a fast mobile store' ),
		'card_title' => 'Every speed job includes',
		'checks'     => array( 'Work on a duplicate theme', 'Your design kept the same', 'Before-and-after report', 'No fix, no fee', 'Free follow-up support' ),
	),
	'faq'      => array(
		'h2'     => 'Shopify Speed Optimization <em>FAQ</em>',
		'anchor' => 'shopify-speed-optimization-faq',
		'lead'   => 'Send us your store URL for a free speed check.',
		'items'  => array(
			array( 'How much does Shopify speed optimization cost?', 'Shopify speed optimization starts at $79 for a basic tune-up, $149 for full Core Web Vitals fixes and $249 for large or heavily customized stores.' ),
			array( 'Will you change how my store looks?', 'No. We keep your design exactly as it is and change only how it loads. You preview everything on a duplicate theme first.' ),
			array( 'Do I have to remove my apps?', 'Not necessarily. We show you which apps cost the most speed and suggest lighter options or custom sections. You decide what stays.' ),
			array( 'Can you guarantee a 100 PageSpeed score?', 'No honest expert can, because Shopify’s own checkout scripts and tracking pixels cost some points. We aim for big real-world gains and passing Core Web Vitals.' ),
			array( 'How long does it take?', 'Most stores are done in 2–3 days. Large stores on the Pro package can take up to a week.' ),
			array( 'Does a faster store sell more?', 'Faster stores keep more shoppers on the page, and Core Web Vitals are part of Google’s ranking signals, so speed helps both sales and SEO.' ),
		),
	),
	'final'    => array(
		'h2'   => 'Ready for a <em>Faster</em> Shopify Store?',
		'lead' => 'Send us your store URL. We’ll run a free speed check and reply with a fixed price, usually within 2 hours.',
	),
	'related'  => array(
		'shopify-theme-customization' => 'Shopify theme customization',
		'shopify-store-setup'         => 'Shopify store setup',
	),
	'schema'   => array(
		'name'        => 'Shopify speed optimization service',
		'type'        => 'Shopify speed optimization',
		'description' => 'Shopify speed optimization: app and leftover code cleanup, image optimization, theme code fixes and Core Web Vitals, with a before-and-after report.',
		'catalog'     => 'Shopify speed optimization packages',
		'prices'      => array(
			'Basic Shopify speed optimization'    => 79,
			'Advanced Shopify speed optimization' => 149,
			'Pro Shopify speed optimization'      => 249,
		),
	),
);
