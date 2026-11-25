<?php
/**
 * Pricing page: every WordPress and Shopify price in one place. Rendered by bwe_pb_render().
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact = home_url( '/contact/' );
$link    = static function ( $slug, $label ) {
	return '<a href="' . esc_url( home_url( '/' . $slug . '/' ) ) . '">' . $label . '</a>';
};

return array(
	'title'    => 'Pricing',
	'seo'      => array(
		'title'       => 'WordPress Expert Pricing: Fixes From $20, Sites From $250',
		'description' => 'WordPress expert pricing and Shopify expert pricing in one place: fixes from $20, speed from $70, websites from $250 and Shopify stores from $250. Fixed quotes.',
		'keyword'     => 'WordPress expert pricing,Shopify expert pricing,WordPress developer cost,Shopify developer cost,website pricing',
		'og_title'    => 'WordPress Expert Pricing: Fixed Prices From $20',
		'image'       => 'social',
	),
	'sections' => array(
		bwe_pb_hero(
			array(
				'pill'      => array( 'Every price is fixed before we start →', '#wordpress-prices' ),
				'kicker'    => 'No hourly meter. No surprise invoices.',
				'h1'        => 'WordPress Expert Pricing &amp; Shopify Prices: <em>Fixed and Fair</em>',
				'lead'      => 'Here is our WordPress expert pricing and Shopify expert pricing in one place, from a $20 fix to a complete online store. Every job gets a fixed price in writing before work starts, and if we can’t fix it, you don’t pay.',
				'buttons'   => array( array( 'Get my fixed quote →', $contact, 'accent' ), array( 'Compare prices ↓', '#wordpress-prices', 'ghost' ) ),
				'jump'      => array( array( 'WordPress', '#wordpress-prices' ), array( 'Shopify', '#shopify-prices' ), array( 'Websites', '#pricing' ), array( 'FAQ', '#faq' ) ),
				'num'       => '$20',
				'label'     => 'starting price for any WordPress or Shopify fix, quoted before any work starts',
				'checks'    => array( 'Fixed prices in writing', 'No fix, no fee', 'Free follow-up support' ),
				'sticker_a' => 'No hourly billing ✦',
				'sticker_b' => '✓ No fix, no fee',
			)
		),
		bwe_pb_table_section(
			array(
				'eyebrow' => 'WordPress',
				'h2'      => 'WordPress Expert <em>Pricing</em>',
				'anchor'  => 'wordpress-expert-prices',
				'id'      => 'wordpress-prices',
				'lead'    => 'Support, fixes, speed, security, migration and new websites. See our ' . $link( 'best-wordpress-expert', 'best WordPress expert' ) . ' page for details.',
				'table'   => array(
					array( 'WordPress service', 'Starting price', 'Typical delivery' ),
					array(
						array( 'WordPress support &amp; bug fix', '<strong>$20</strong> per fix', 'Same day' ),
						array( 'WordPress customization', '<strong>$40</strong> per page', '1–2 days' ),
						array( $link( 'wordpress-malware-removal', 'Malware removal &amp; security' ), '<strong>$50</strong> per site', '24 hours' ),
						array( $link( 'wordpress-migration', 'WordPress migration' ), '<strong>$69</strong> per site', '1–2 days' ),
						array( $link( 'wordpress-speed-optimization', 'WordPress speed optimization' ), '<strong>$70</strong> per site', '2–3 days' ),
						array( 'WordPress SEO setup', '<strong>$99</strong> per site', '2–3 days' ),
						array( $link( 'wordpress-maintenance', 'WordPress maintenance plan' ), '<strong>$40</strong> per month', 'Ongoing' ),
						array( 'New WordPress website', '<strong>$250</strong> per project', '2–4 weeks' ),
						array( $link( 'woocommerce-development', 'WooCommerce store' ), '<strong>$400</strong> per project', '3–5 weeks' ),
						array( $link( 'wordpress-plugin-development', 'WordPress plugin development' ), '<strong>$299</strong> per project', 'Varies by scope' ),
					),
				),
			)
		),
		bwe_pb_table_section(
			array(
				'eyebrow' => 'Shopify',
				'h2'      => 'Shopify Expert <em>Pricing</em>',
				'anchor'  => 'shopify-expert-prices',
				'id'      => 'shopify-prices',
				'tint'    => true,
				'lead'    => 'Store setup, theme changes, speed and migrations. See our ' . $link( 'best-shopify-expert', 'best Shopify expert' ) . ' page for details.',
				'table'   => array(
					array( 'Shopify service', 'Starting price', 'Typical delivery' ),
					array(
						array( 'Shopify support &amp; bug fix', '<strong>$20</strong> per fix', 'Same day' ),
						array( 'Shopify app setup &amp; integration', '<strong>$30</strong> per setup', '1 day' ),
						array( $link( 'shopify-theme-customization', 'Shopify theme customization' ), '<strong>$50</strong> per task', '1–2 days' ),
						array( 'Custom Liquid section', '<strong>$60</strong> per section', '1–3 days' ),
						array( $link( 'shopify-speed-optimization', 'Shopify speed optimization' ), '<strong>$79</strong> per store', '2–3 days' ),
						array( 'Shopify SEO setup', '<strong>$99</strong> per store', '2–3 days' ),
						array( $link( 'migrate-to-shopify', 'Migration to Shopify' ), '<strong>$149</strong> per store', '3–7 days' ),
						array( 'Monthly Shopify support', '<strong>$49</strong> per month', 'Ongoing' ),
						array( $link( 'shopify-store-setup', 'New Shopify store' ), '<strong>$250</strong> per project', '3–5 weeks' ),
						array( $link( 'shopify-app-development', 'Shopify app development' ), '<strong>$399</strong> per project', 'Varies by scope' ),
					),
				),
				'note'    => 'Shopify expert pricing doesn’t include your <a href="https://www.shopify.com/pricing" target="_blank" rel="noopener">Shopify plan</a> or paid apps, which Shopify bills directly.',
			)
		),
		bwe_pb_plans(
			array(
				'eyebrow' => 'New websites &amp; stores',
				'h2'      => 'Website &amp; Store <em>Packages</em>',
				'anchor'  => 'website-packages',
				'lead'    => 'Complete WordPress websites, WooCommerce stores and Shopify stores, with mobile-first design, speed and on-page SEO included.',
				'plans'   => array(
					array( 'Starter', '$250', '/ project', 'For new businesses that need a sharp, professional website, fast.', array( 'WordPress website, up to 5 pages', 'Mobile-first, responsive design', 'On-page SEO &amp; analytics setup', 'Contact form &amp; social links', '14 days of free support' ), false, 'Choose Starter', $contact ),
					array( 'Growth', '$599', '/ project', 'For brands ready to turn traffic into serious revenue.', array( 'Up to 15 pages or a full online store', 'WordPress, WooCommerce or Shopify', 'Speed optimization (90+ PageSpeed)', 'Conversion-focused page layouts', '30 days of free support' ), true, 'Choose Growth →', $contact ),
					array( 'Custom', 'Let’s talk', '', 'For complex builds, custom functionality and big ambitions.', array( 'Custom plugins, apps &amp; integrations', 'Platform migrations', 'Shopify Plus &amp; headless builds', 'Ongoing growth retainer', 'Priority support' ), false, 'Get a custom quote', $contact ),
				),
				'note'    => 'Shopify stores start at $250 and WooCommerce stores at $400. Want to know what drives the price? Read <a href="' . esc_url( home_url( '/how-much-does-a-website-cost/' ) ) . '">how much a website really costs</a>.',
			)
		),
		bwe_pb_table_section(
			array(
				'eyebrow' => 'Monthly plans',
				'h2'      => 'Monthly Care &amp; Support <em>Plans</em>',
				'anchor'  => 'monthly-care-plans',
				'id'      => 'care-plans',
				'lead'    => 'Keep a WordPress or Shopify expert on call every month. No contracts, cancel anytime.',
				'table'   => array(
					array( 'Plan', 'Price', 'Best for' ),
					array(
						array( $link( 'wordpress-maintenance', 'WordPress Essential' ), '<strong>$40</strong> per month', 'Small sites: updates, backups, monitoring, 30 min of changes' ),
						array( $link( 'wordpress-maintenance', 'WordPress Business' ), '<strong>$79</strong> per month', 'Business sites: free malware cleanup, speed checks, 2 h of changes' ),
						array( $link( 'wordpress-maintenance', 'WooCommerce care' ), '<strong>$129</strong> per month', 'Stores: checkout testing, staging, 4 h of changes' ),
						array( 'Shopify support', '<strong>$49</strong> per month', 'Shopify stores: new products, banners, fixes and small changes' ),
					),
				),
			)
		),
		bwe_pb_split(
			array(
				'eyebrow'    => 'Why so affordable?',
				'h2'         => 'How Our WordPress Expert Pricing Stays <em>Low</em>',
				'anchor'     => 'why-our-wordpress-expert-pricing-is-low',
				'paragraphs' => array(
					'Agencies often charge $100–$200 an hour, and much of that pays for account managers, offices and sales teams. Our WordPress expert pricing skips all of that: you talk directly to the developer doing the work, so the savings go to you.',
					'We also only work with WordPress and Shopify. We’ve fixed the same errors, set up the same payment gateways and sped up the same themes many times, so a job that takes a generalist a day often takes us an hour. You pay a fixed price for the result, not for our learning curve.',
					'That’s why the WordPress developer cost and Shopify developer cost on this page are starting prices you can actually rely on. Send us your project and the quote you get will be fixed in writing.',
				),
				'image'      => array( 'social', 'WordPress expert pricing for affordable WordPress and Shopify development' ),
				'card_title' => 'Every price includes',
				'checks'     => array( 'A fixed quote in writing', 'Backup before any change', 'No fix, no fee', 'Free follow-up support', 'Full ownership of your site' ),
				'cta'        => array( 'Get my fixed quote →', $contact ),
			)
		),
		bwe_pb_faq(
			array(
				'h2'     => 'Pricing <em>FAQ</em>',
				'anchor' => 'pricing-faq',
				'lead'   => 'Not sure which option fits? Tell us what you need and we’ll quote it.',
				'cta'    => $contact,
				'items'  => array(
					array( 'How much does a WordPress developer cost?', 'With us, a WordPress developer costs from $20 for a fix, $40 per page for customization, $70 for speed optimization and $250 for a complete website. Agencies usually charge $100–$200 an hour, so fixed prices like these save most small businesses a lot.' . ' Read our <a href="' . esc_url( home_url( '/how-much-does-a-wordpress-expert-cost/' ) ) . '">WordPress expert cost guide</a>.' ),
					array( 'How much does a Shopify developer cost?', 'Shopify developer cost with us starts at $20 for a fix, $50 for a theme change, $149 for a migration to Shopify and $250 for a complete store. Your Shopify plan and paid apps are extra and billed by Shopify.' ),
					array( 'Are these prices fixed?', 'Yes. These are starting prices for a typical job. After you describe your project, you get a fixed price in writing. That price doesn’t change unless you ask for extra work.' ),
					array( 'Why are your prices lower than agencies?', 'We focus only on WordPress and Shopify and have no agency overhead: no account managers or sales team. You talk directly to the expert doing the work.' ),
					array( 'Do I pay upfront?', 'Small fixes are paid when the job is done and you’re happy. Website and store projects are usually split into a deposit and a final payment at launch.' ),
					array( 'What if you can’t fix my problem?', 'Then you don’t pay. If a job turns out bigger than quoted, we tell you before doing any extra work.' ),
					array( 'Which payment methods do you accept?', 'Bank transfer, PayPal and other common methods. Ask us for the option that works best in your country.' ),
					array( 'Do prices include hosting, themes or apps?', 'No. Hosting, premium themes and plugins, your Shopify plan and paid apps are bought in your name, so you own them. We always tell you about these costs up front.' ),
				),
			)
		),
		bwe_pb_final(
			array(
				'h2'      => 'Get Your <em>Fixed Price</em> Today',
				'anchor'  => '',
				'lead'    => 'Tell us what you need. You’ll get a fixed price in writing, usually within 2 hours, with no obligation.',
				'buttons' => array( array( 'Get my fixed quote →', $contact, 'primary' ), array( 'Back to prices', '#wordpress-prices', 'ghost' ) ),
				'note'    => 'Fixed prices. No fix, no fee. Free follow-up support.',
			)
		),
	),
);
