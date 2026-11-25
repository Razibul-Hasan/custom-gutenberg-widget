<?php
/**
 * WordPress maintenance plans page. Rendered by bwe_pb_service_page().
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact = home_url( '/contact/' );

return array(
	'title'    => 'WordPress Maintenance Plans',
	'platform' => 'wordpress',
	'seo'      => array(
		'title'       => 'WordPress Maintenance Plans From $40/Month %sep% %sitename%',
		'description' => 'WordPress maintenance plans from $40 a month: updates, daily backups, security and uptime monitoring, plus small changes from your own WordPress expert.',
		'keyword'     => 'WordPress maintenance,WordPress maintenance plans,WordPress support plan,WordPress care plan,monthly WordPress support',
		'og_title'    => 'WordPress Maintenance Plans From $40 a Month',
		'image'       => 'wordpress',
	),
	'hero'     => array(
		'pill'    => 'Care plans from $40/month — see plans →',
		'kicker'  => 'Stop worrying about updates, backups and hackers',
		'h1'      => 'WordPress Maintenance Plans That <em>Keep Your Site Safe</em>',
		'lead'    => 'Our WordPress maintenance plans keep your site updated, backed up, secure and fast every month, with a real WordPress expert on call for fixes and small changes. You run your business; we look after your website.',
		'cta'     => 'Start my care plan',
		'num'     => '$40',
		'label'   => 'per month for updates, daily backups, security and uptime monitoring',
		'checks'  => array( 'Safe updates &amp; daily backups', 'Security &amp; uptime monitoring', 'Small changes every month' ),
		'sticker' => 'Cancel anytime ✦',
	),
	'marquee'  => array( 'Core Updates', 'Plugin Updates', 'Daily Backups', 'Uptime Monitoring', 'Malware Scans', 'Firewall', 'Speed Checks', 'Content Changes', 'Monthly Reports', 'Priority Support' ),
	'signs'    => array(
		'eyebrow' => 'Sound familiar?',
		'h2'      => '6 Signs You Need a <em>WordPress Maintenance Plan</em>',
		'anchor'  => 'signs-you-need-wordpress-maintenance',
		'lead'    => 'Most hacked and broken WordPress sites have one thing in common: nobody was looking after them.',
		'items'   => array(
			array( 'You have plugins waiting for updates.', 'Outdated plugins are the number one way WordPress sites get hacked.' ),
			array( 'You’re scared updates will break the site.', 'So you skip them, and the risk grows every month.' ),
			array( 'You don’t know when your last backup was.', 'Without a tested backup, one bad day can wipe out years of work.' ),
			array( 'You only notice downtime when a customer tells you.', 'Every hour offline is lost leads and sales.' ),
			array( 'Small changes wait for weeks.', 'Prices, banners and team pages go out of date.' ),
			array( 'Your site gets slower every month.', 'Bloat builds up quietly until visitors start leaving.' ),
		),
	),
	'included' => array(
		'eyebrow' => 'What’s included',
		'h2'      => 'What Our WordPress Maintenance Plans <em>Include</em>',
		'anchor'  => 'what-is-included',
		'lead'    => 'Everything a WordPress site needs to stay healthy, done for you every month.',
		'cards'   => array(
			array( '', 'Safe updates', 'WordPress core, theme and plugin updates, tested first and rolled back instantly if anything breaks.' ),
			array( '', 'Daily backups', 'Automatic off-site backups kept for 30 days, with one-click restores when you need them.' ),
			array( '', 'Security monitoring', 'Malware scans, firewall and login protection, with free cleanup if something gets through.' ),
			array( '', 'Uptime monitoring', 'We check your site every few minutes and start fixing it before most visitors notice.' ),
			array( '', 'Small changes', 'Text, images, prices, banners and new pages. Just send a message and it’s done.' ),
			array( '', 'Monthly report', 'What we updated, backed up and fixed, plus your speed and uptime, in one short email.' ),
		),
	),
	'packages' => array(
		'eyebrow' => 'Plans',
		'h2'      => 'WordPress Maintenance <em>Prices</em>',
		'anchor'  => 'wordpress-maintenance-price',
		'lead'    => 'Simple monthly plans. No contracts, cancel anytime.',
		'plans'   => array(
			array( 'Essential', '$40', '/ month', 'For small sites that need to stay safe and updated.', array( 'Weekly safe updates', 'Daily off-site backups', 'Uptime &amp; security monitoring', '30 minutes of changes', 'Monthly report' ), false, 'Choose Essential', $contact ),
			array( 'Business', '$79', '/ month', 'For business sites that can’t afford downtime.', array( 'Everything in Essential', 'Free malware cleanup', 'Monthly speed check &amp; tune-up', '2 hours of changes', 'Priority replies' ), true, 'Choose Business →', $contact ),
			array( 'WooCommerce', '$129', '/ month', 'For online stores where every hour of downtime costs sales.', array( 'Everything in Business', 'Checkout &amp; payment testing', 'Staging site for updates', '4 hours of changes', 'Same-day emergency fixes' ), false, 'Choose WooCommerce', $contact ),
		),
		'note'    => 'Unused change time doesn’t roll over. Bigger projects get a separate fixed quote, with a discount for care plan clients.',
	),
	'steps_h2' => 'Start Your Care Plan in 4 Steps. <em>Live the Same Week.</em>',
	'why'      => array(
		'eyebrow'    => 'Why BestWebExpert',
		'h2'         => 'Why Choose Our WordPress Maintenance',
		'anchor'     => 'why-choose-our-wordpress-maintenance',
		'paragraphs' => array(
			'Automatic updates and backup plugins are a good start, but they don’t notice when an update breaks your checkout or when a backup quietly fails. A person does.',
			'With our WordPress maintenance plans you get a real WordPress expert who knows your site, checks every update and is there when you need a change or a fix, without a ticket queue.',
			'Plans start at $40 a month, with no contracts. If you’re not happy, cancel anytime and keep all your backups.',
		),
		'image'      => array( 'wordpress', 'WordPress maintenance plan keeping a business website updated and secure' ),
		'card_title' => 'Every plan includes',
		'checks'     => array( 'A WordPress expert who knows your site', 'Updates tested before they go live', 'Daily backups you can restore', 'No contracts, cancel anytime', 'Monthly report' ),
	),
	'faq'      => array(
		'h2'     => 'WordPress Maintenance <em>FAQ</em>',
		'anchor' => 'wordpress-maintenance-faq',
		'lead'   => 'Questions about our care plans? Ask us anything.',
		'items'  => array(
			array( 'How much does WordPress maintenance cost?', 'Our WordPress maintenance plans cost $40 a month for Essential, $79 for Business and $129 for WooCommerce stores. There are no setup fees or contracts.' ),
			array( 'What happens if an update breaks my site?', 'We test updates first and keep a backup from right before every update. If something breaks, we roll it back and fix it at no extra cost.' ),
			array( 'Can I cancel anytime?', 'Yes. Plans are month to month. If you cancel, we send you your latest backup.' ),
			array( 'What counts as a “small change”?', 'Text and image updates, new blog posts, price changes, banners, simple new pages and small design tweaks. Bigger projects get a fixed quote.' ),
			array( 'Do you fix my site if it gets hacked?', 'Yes. Business and WooCommerce plans include free malware cleanup. On Essential, cleanup is offered at a discount.' ),
			array( 'Do you need my hosting login?', 'We need WordPress admin access, and hosting access helps for backups and emergencies. We keep all logins secure and you can revoke them anytime.' ),
		),
	),
	'final'    => array(
		'h2'   => 'Let a WordPress Expert <em>Look After</em> Your Site',
		'lead' => 'Start a care plan this week. We’ll run a free health check first and fix anything urgent before your first month begins.',
	),
	'related'  => array(
		'wordpress-malware-removal'    => 'WordPress malware removal',
		'wordpress-speed-optimization' => 'WordPress speed optimization',
	),
	'schema'   => array(
		'name'        => 'WordPress maintenance plans',
		'type'        => 'WordPress maintenance',
		'description' => 'Monthly WordPress maintenance: safe updates, daily backups, security and uptime monitoring, small changes and a monthly report.',
		'catalog'     => 'WordPress maintenance plans',
		'prices'      => array(
			'Essential WordPress maintenance (monthly)'   => 39,
			'Business WordPress maintenance (monthly)'    => 79,
			'WooCommerce maintenance (monthly)'           => 129,
		),
	),
);
