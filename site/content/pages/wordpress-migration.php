<?php
/**
 * WordPress migration service page. Rendered by bwe_pb_service_page().
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact = home_url( '/contact/' );

return array(
	'title'    => 'WordPress Migration Service',
	'platform' => 'wordpress',
	'seo'      => array(
		'title'       => 'WordPress Migration Service: Zero Downtime From $69',
		'description' => 'WordPress migration service to a new host, domain or from Wix and Squarespace. Zero downtime, no lost content and your SEO kept intact. Fixed price from $69.',
		'keyword'     => 'WordPress migration,WordPress migration service,move WordPress site to new host,Wix to WordPress,change WordPress domain',
		'og_title'    => 'WordPress Migration With Zero Downtime From $69',
		'image'       => 'wordpress',
	),
	'hero'     => array(
		'pill'    => 'Migrations from $69 — see packages →',
		'kicker'  => 'Move your site without losing content, emails or rankings',
		'h1'      => 'WordPress Migration Service With <em>Zero Downtime</em>',
		'lead'    => 'Moving to a faster host, a new domain or from Wix, Squarespace or Blogger to WordPress? Our WordPress migration service moves every file, page, image and setting, keeps your URLs and redirects working and protects the Google rankings you’ve earned.',
		'cta'     => 'Move my site',
		'num'     => '$69',
		'label'   => 'starting price for moving a WordPress site to a new host, done in 1–2 days',
		'checks'  => array( 'Host, domain &amp; platform moves', 'Zero downtime switch', 'Redirects &amp; SEO kept' ),
		'sticker' => 'Zero downtime ✦',
	),
	'marquee'  => array( 'Host to Host', 'Domain Change', 'HTTP to HTTPS', 'Wix to WordPress', 'Squarespace to WordPress', 'Blogger to WordPress', 'Multisite', 'WooCommerce Stores', '301 Redirects', 'DNS &amp; Email' ),
	'signs'    => array(
		'eyebrow' => 'Time to move?',
		'h2'      => '6 Reasons to Migrate Your <em>WordPress Site</em>',
		'anchor'  => 'reasons-to-migrate-your-wordpress-site',
		'lead'    => 'A move done badly can cost you traffic for months. A move done right can make your site faster, cheaper and easier to run.',
		'items'   => array(
			array( 'Your hosting is slow or unreliable.', 'Downtime and slow servers cost you visitors and rankings.' ),
			array( 'Your hosting bill keeps rising.', 'Renewal prices often double. A better host can cost less.' ),
			array( 'You’re rebranding to a new domain.', 'Without proper redirects, you start your SEO from zero.' ),
			array( 'You’ve outgrown Wix or Squarespace.', 'WordPress gives you full control, more features and better SEO.' ),
			array( 'Your site still runs on HTTP.', 'Browsers mark it “Not secure” and visitors leave.' ),
			array( 'You’re afraid of losing everything.', 'That’s exactly why a WordPress expert should handle the move.' ),
		),
	),
	'included' => array(
		'eyebrow' => 'What’s included',
		'h2'      => 'What Our WordPress Migration Service <em>Includes</em>',
		'anchor'  => 'what-is-included',
		'lead'    => 'We plan the move, test everything on the new server and switch over only when it all works.',
		'cards'   => array(
			array( '', 'Full backup &amp; transfer', 'Files, database, media, users, plugins and settings moved together, with a full backup kept safe.' ),
			array( '', 'Zero-downtime switch', 'We test the site on the new server first and switch DNS only when everything works.' ),
			array( '', 'Domain &amp; URL changes', 'Every internal link, image path and serialized setting updated correctly for the new domain.' ),
			array( '', '301 redirects &amp; SEO', 'Old URLs redirected to new ones, sitemaps updated and Search Console told about the move.' ),
			array( '', 'Email &amp; DNS', 'MX, SPF and DKIM records moved, so your business email keeps working through the switch.' ),
			array( '', 'SSL &amp; final checks', 'Free SSL certificate, HTTPS everywhere and a full check of forms, checkout and speed.' ),
		),
	),
	'packages' => array(
		'eyebrow' => 'Packages',
		'h2'      => 'WordPress Migration <em>Prices</em>',
		'anchor'  => 'wordpress-migration-price',
		'lead'    => 'Fixed prices for every type of move. Not sure which one you need? Send us your URL.',
		'plans'   => array(
			array( 'Host move', '$69', '/ site', 'Move a WordPress site to a new hosting provider.', array( 'Full site transfer', 'Zero-downtime DNS switch', 'SSL setup', 'Post-move checks' ), false, 'Choose Host move', $contact ),
			array( 'Domain change', '$99', '/ site', 'Move to a new domain without losing your SEO.', array( 'Everything in Host move', 'URL &amp; database update', '301 redirects for every page', 'Search Console change of address', '14 days of follow-up support' ), true, 'Choose Domain change →', $contact ),
			array( 'Platform switch', '$199', '/ site', 'Move from Wix, Squarespace or Blogger to WordPress.', array( 'Pages, posts &amp; images moved', 'Design rebuilt in WordPress', '301 redirects &amp; SEO settings', 'Contact forms &amp; analytics', '30 days of follow-up support' ), false, 'Choose Platform switch', $contact ),
		),
		'note'    => 'WooCommerce stores, multisite networks and very large sites get a fixed quote after a quick look.',
	),
	'steps_h2' => 'Move Your WordPress Site in 4 Steps. <em>No Downtime.</em>',
	'why'      => array(
		'eyebrow'    => 'Why BestWebExpert',
		'h2'         => 'Why Hire a WordPress Expert for Your Migration',
		'anchor'     => 'why-hire-a-wordpress-expert-for-your-migration',
		'paragraphs' => array(
			'Migration plugins work until they don’t: broken images, lost settings, a white screen on the new host or emails that stop arriving. Fixing that after the fact costs far more than doing it right the first time.',
			'We move WordPress sites and WooCommerce stores regularly, test on the new server before going live and keep your old site untouched until the new one is confirmed working.',
			'You get one fixed price, zero downtime and a final check of every important page, form and payment. If something goes wrong, we fix it at no extra cost.',
		),
		'image'      => array( 'wordpress', 'WordPress migration to a new host with zero downtime' ),
		'card_title' => 'Every migration includes',
		'checks'     => array( 'Full backup before the move', 'Testing on the new server first', 'Redirects and SEO kept', 'Email kept working', 'Free follow-up support' ),
	),
	'faq'      => array(
		'h2'     => 'WordPress Migration <em>FAQ</em>',
		'anchor' => 'wordpress-migration-faq',
		'lead'   => 'Planning a move? Send us your current and new host and we’ll reply with a fixed price.',
		'items'  => array(
			array( 'How much does a WordPress migration cost?', 'Moving to a new host starts at $69, a domain change at $99 and a move from Wix, Squarespace or Blogger to WordPress at $199. You get a fixed price before we start.' . ' Read our <a href="' . esc_url( home_url( '/wordpress-migration-cost/' ) ) . '">WordPress migration cost guide</a>.' ),
			array( 'Will my site go down during the migration?', 'No. We copy and test the site on the new server while the old one keeps running, then switch DNS. Visitors never see a broken site.' ),
			array( 'Will I lose my Google rankings?', 'Not when it’s done properly. We keep your URLs or set up 301 redirects for every page, update your sitemap and tell Google about the move in Search Console.' ),
			array( 'Can you move my site from Wix or Squarespace?', 'Yes. We move your pages, posts and images, rebuild the design in WordPress and redirect your old URLs so you keep your traffic.' ),
			array( 'Will my email keep working?', 'Yes. We move your DNS records, including MX, SPF and DKIM, so your business email keeps working before, during and after the move.' ),
			array( 'Which hosting do you recommend?', 'It depends on your traffic and budget. We’ll recommend a fast, affordable host and can set up the account with you.' ),
		),
	),
	'final'    => array(
		'h2'   => 'Ready to <em>Move</em> Your Site?',
		'lead' => 'Tell us where your site is now and where it’s going. You’ll get a fixed price, usually within 2 hours.',
	),
	'related'  => array(
		'wordpress-speed-optimization' => 'WordPress speed optimization',
		'migrate-to-shopify'           => 'migration to Shopify',
	),
	'schema'   => array(
		'name'        => 'WordPress migration service',
		'type'        => 'WordPress migration',
		'description' => 'WordPress migration to a new host or domain, or from Wix, Squarespace or Blogger to WordPress, with zero downtime, 301 redirects and SEO kept intact.',
		'catalog'     => 'WordPress migration packages',
		'prices'      => array(
			'WordPress host migration'              => 69,
			'WordPress domain change'               => 99,
			'Wix or Squarespace to WordPress'       => 199,
		),
	),
);
