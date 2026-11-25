<?php
/**
 * WordPress speed optimization service page. Rendered by bwe_pb_service_page().
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact = home_url( '/contact/' );

return array(
	'title'    => 'WordPress Speed Optimization Service',
	'platform' => 'wordpress',
	'seo'      => array(
		'title'       => 'WordPress Speed Optimization Service From $70 %sep% %sitename%',
		'description' => 'WordPress speed optimization service that passes Core Web Vitals. We fix slow plugins, images, caching and hosting. Fixed price from $70, done in 2–3 days.',
		'keyword'     => 'WordPress speed optimization,WordPress speed optimization service,speed up WordPress site,Core Web Vitals,PageSpeed',
		'og_title'    => 'WordPress Speed Optimization: Pass Core Web Vitals From $70',
		'image'       => 'mobile',
	),
	'hero'     => array(
		'pill'    => 'Speed fixes from $70 — see packages →',
		'kicker'  => 'Slow pages lose visitors, sales and Google rankings',
		'h1'      => 'WordPress Speed Optimization That Makes Your Site <em>Feel Instant</em>',
		'lead'    => 'Our WordPress speed optimization service finds what’s really slowing your site down, from heavy plugins and huge images to weak caching and slow hosting, and fixes it until your Core Web Vitals pass. Fixed price, before-and-after report, no guesswork.',
		'cta'     => 'Speed up my site',
		'num'     => '$70',
		'label'   => 'starting price for a full WordPress speed optimization, done in 2–3 days',
		'checks'  => array( 'Core Web Vitals fixes', 'Image, cache &amp; database cleanup', 'Before-and-after PageSpeed report' ),
		'sticker' => '90+ mobile score target ✦',
	),
	'marquee'  => array( 'Core Web Vitals', 'LCP', 'INP', 'CLS', 'Caching', 'Image Compression', 'WebP &amp; AVIF', 'Lazy Loading', 'Database Cleanup', 'CDN Setup' ),
	'signs'    => array(
		'eyebrow' => 'Is your site slow?',
		'h2'      => '6 Signs Your WordPress Site Needs <em>Speed Optimization</em>',
		'anchor'  => 'signs-your-wordpress-site-is-slow',
		'lead'    => 'Every extra second of load time costs you visitors and sales. If any of these sound familiar, your site is leaving money on the table.',
		'items'   => array(
			array( 'Pages take more than 3 seconds to load on mobile.', 'Most visitors leave before a slow page finishes loading.' ),
			array( 'Google PageSpeed shows red or orange scores.', 'Failing Core Web Vitals can hold back your rankings.' ),
			array( 'Search Console reports “Poor URLs”.', 'Google is telling you real users have a slow experience.' ),
			array( 'Your admin dashboard crawls.', 'A bloated database and heavy plugins slow the back end too.' ),
			array( 'The layout jumps while the page loads.', 'That’s layout shift (CLS), and it makes people misclick.' ),
			array( 'Your host keeps asking you to upgrade.', 'More server power rarely fixes a site that’s badly optimized.' ),
		),
	),
	'included' => array(
		'eyebrow' => 'What’s included',
		'h2'      => 'What Our WordPress Speed Optimization Service <em>Includes</em>',
		'anchor'  => 'what-is-included',
		'lead'    => 'We don’t just install a caching plugin and hope. We measure, find the real bottlenecks and fix them one by one.',
		'cards'   => array(
			array( '', 'Full speed audit', 'PageSpeed Insights, Core Web Vitals and waterfall tests on your key pages, so we know exactly what’s slow and why.' ),
			array( '', 'Caching &amp; CDN setup', 'Page, browser and object caching configured properly for your host, plus a CDN when it helps your visitors.' ),
			array( '', 'Image optimization', 'Compression, WebP or AVIF conversion, correct sizes and lazy loading, without visible quality loss.' ),
			array( '', 'Plugin &amp; script cleanup', 'We find heavy plugins, remove unused CSS and JavaScript, and defer what doesn’t need to load first.' ),
			array( '', 'Database optimization', 'Old revisions, transients, spam and orphaned tables cleaned up, so pages and the admin respond faster.' ),
			array( '', 'Before &amp; after report', 'Clear before-and-after scores and load times, plus tips to keep your site fast after we’re done.' ),
		),
	),
	'packages' => array(
		'eyebrow' => 'Packages',
		'h2'      => 'WordPress Speed Optimization <em>Prices</em>',
		'anchor'  => 'wordpress-speed-optimization-price',
		'lead'    => 'Pick a package or send us your URL for a fixed quote. You pay only when you’re happy with the result.',
		'plans'   => array(
			array( 'Basic', '$70', '/ site', 'For blogs and small business sites with a few slow pages.', array( 'Speed audit of 3 key pages', 'Caching &amp; image optimization', 'Database cleanup', 'Before-and-after report' ), false, 'Choose Basic', $contact ),
			array( 'Advanced', '$149', '/ site', 'For business sites that must pass Core Web Vitals.', array( 'Everything in Basic', 'Core Web Vitals fixes (LCP, INP, CLS)', 'Unused CSS &amp; JS removal', 'CDN setup', '14 days of follow-up support' ), true, 'Choose Advanced →', $contact ),
			array( 'WooCommerce', '$199', '/ store', 'For online stores with product, cart and checkout pages.', array( 'Everything in Advanced', 'Product, cart &amp; checkout tuning', 'Cart fragment &amp; AJAX fixes', 'Heavy query optimization', '30 days of follow-up support' ), false, 'Choose WooCommerce', $contact ),
		),
		'note'    => 'Hosting upgrades and premium plugins, if needed, are billed by their providers. We always tell you before recommending one.',
	),
	'steps_h2' => 'A Faster WordPress Site in 4 Steps. <em>Usually in 2–3 Days.</em>',
	'why'      => array(
		'eyebrow'    => 'Why BestWebExpert',
		'h2'         => 'Why Hire Us for WordPress Speed Optimization',
		'anchor'     => 'why-hire-us-for-wordpress-speed-optimization',
		'paragraphs' => array(
			'Speed plugins alone rarely fix a slow WordPress site. Real speed comes from understanding how your theme, plugins, images and hosting work together, and that’s what we do every day.',
			'We build lightweight block themes and our own WordPress.org plugin, so we know which code is heavy and how to make it lighter without breaking features. Every change is tested on a staging copy first.',
			'You get a fixed price up front and a clear before-and-after report at the end. If we can’t make your site measurably faster, you don’t pay.',
		),
		'image'      => array( 'mobile', 'WordPress speed optimization for a fast, mobile-first website' ),
		'card_title' => 'Every speed job includes',
		'checks'     => array( 'Full backup before any change', 'Testing on a staging copy', 'Before-and-after PageSpeed report', 'No fix, no fee', 'Free follow-up support' ),
	),
	'faq'      => array(
		'h2'     => 'WordPress Speed Optimization <em>FAQ</em>',
		'anchor' => 'wordpress-speed-optimization-faq',
		'lead'   => 'Can’t find your answer? Send us your URL and we’ll reply within a few hours.',
		'items'  => array(
			array( 'How much does WordPress speed optimization cost?', 'Our WordPress speed optimization starts at $70 for a small site, $149 for a full Core Web Vitals fix and $199 for a WooCommerce store. You get a fixed price before any work starts.' ),
			array( 'How long does it take?', 'Most sites are done in 2–3 days. Large WooCommerce stores can take up to a week. You get the delivery time with your quote.' ),
			array( 'Can you guarantee a 100 PageSpeed score?', 'No honest expert can promise 100 on every site, because third-party scripts like chat widgets and ads cost points. We aim for 90+ on mobile and passing Core Web Vitals, and we show you the real before-and-after numbers.' ),
			array( 'Will speed optimization break my site?', 'We take a full backup first and test changes on a staging copy where possible. If anything looks wrong, we roll it back before it reaches your visitors.' ),
			array( 'Do I need better hosting?', 'Sometimes, but not usually. Most slow sites are slow because of plugins, images and caching. If your hosting really is the bottleneck, we’ll show you the numbers and recommend an affordable option.' ),
			array( 'Does a faster site help SEO?', 'Yes. Page experience and Core Web Vitals are part of how Google ranks pages, and faster pages also keep visitors on your site longer, which means more leads and sales.' ),
		),
	),
	'final'    => array(
		'h2'   => 'Ready for a <em>Faster</em> WordPress Site?',
		'lead' => 'Send us your URL. We’ll run a free speed check and reply with a fixed price, usually within 2 hours.',
	),
	'related'  => array(
		'wordpress-maintenance'   => 'WordPress maintenance',
		'woocommerce-development' => 'WooCommerce development',
	),
	'schema'   => array(
		'name'        => 'WordPress speed optimization service',
		'type'        => 'WordPress speed optimization',
		'description' => 'WordPress speed optimization that passes Core Web Vitals: caching, image optimization, plugin and script cleanup, database optimization and a before-and-after report.',
		'catalog'     => 'WordPress speed optimization packages',
		'prices'      => array(
			'Basic WordPress speed optimization'       => 79,
			'Advanced WordPress speed optimization'    => 149,
			'WooCommerce speed optimization'           => 199,
		),
	),
);
