<?php
/**
 * Shopify theme customization service page. Rendered by bwe_pb_service_page().
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact = home_url( '/contact/' );

return array(
	'title'    => 'Shopify Theme Customization Service',
	'platform' => 'shopify',
	'seo'      => array(
		'title'       => 'Shopify Theme Customization From $50 per Task %sep% %sitename%',
		'description' => 'Shopify theme customization for Dawn and premium themes: product pages, custom Liquid sections, cart drawers and layout changes. Fixed price from $50 per task.',
		'keyword'     => 'Shopify theme customization,Shopify theme developer,customize Shopify theme,Shopify Liquid developer,Dawn theme customization',
		'og_title'    => 'Shopify Theme Customization From $50 per Task',
		'image'       => 'shopify',
	),
	'hero'     => array(
		'pill'    => 'Theme changes from $50 — see packages →',
		'kicker'  => 'Make your theme look and work like your brand',
		'h1'      => 'Shopify Theme Customization <em>Without the Agency Price</em>',
		'lead'    => 'Our Shopify theme customization service changes your theme exactly the way you want: product pages, collection filters, headers, cart drawers and custom Liquid sections you can edit yourself. Dawn, premium themes or custom themes, all on a duplicate theme so your store keeps selling.',
		'cta'     => 'Customize my theme',
		'num'     => '$50',
		'label'   => 'starting price per Shopify theme change, usually done in 1–2 days',
		'checks'  => array( 'Product &amp; collection pages', 'Custom Liquid sections', 'Cart, header &amp; layout changes' ),
		'sticker' => 'Works on any theme ✦',
	),
	'marquee'  => array( 'Dawn', 'Premium Themes', 'Liquid', 'Online Store 2.0', 'Custom Sections', 'Product Pages', 'Collection Filters', 'Cart Drawer', 'Mega Menus', 'Theme Updates' ),
	'signs'    => array(
		'eyebrow' => 'Sound familiar?',
		'h2'      => '6 Signs Your Store Needs <em>Theme Customization</em>',
		'anchor'  => 'signs-you-need-shopify-theme-customization',
		'lead'    => 'Your theme should work for your products, not the other way around.',
		'items'   => array(
			array( 'Your store looks like a thousand others.', 'An unchanged theme makes it hard to stand out or build trust.' ),
			array( 'The theme editor can’t do what you need.', 'Some layouts need a custom section or a few lines of Liquid.' ),
			array( 'You pay for apps that only change the design.', 'Size charts, badges and tabs can often be built into the theme.' ),
			array( 'Product pages don’t answer questions.', 'Missing details, sizes or delivery info mean fewer sales.' ),
			array( 'A theme update broke your changes.', 'Edits in the wrong place get lost on every update.' ),
			array( 'Mobile layout looks off.', 'Most of your shoppers are on phones; small details matter.' ),
		),
	),
	'included' => array(
		'eyebrow' => 'What we customize',
		'h2'      => 'What Our Shopify Theme Customization <em>Covers</em>',
		'anchor'  => 'what-is-included',
		'lead'    => 'Small tweaks or big redesigns, every change is built cleanly so it survives theme updates.',
		'cards'   => array(
			array( '', 'Product pages', 'Image galleries, variant pickers, size charts, tabs, badges, trust icons and delivery estimates.' ),
			array( '', 'Collection pages', 'Filters, sorting, product cards, banners and quick-add buttons that help shoppers find the right item.' ),
			array( '', 'Custom Liquid sections', 'Editable sections for landing pages, comparisons, FAQs, countdowns and more, often replacing paid apps.' ),
			array( '', 'Cart &amp; header', 'Cart drawers, free-shipping bars, upsells, mega menus and announcement bars.' ),
			array( '', 'Homepage &amp; landing pages', 'Sale pages, campaign landing pages and homepage layouts built to convert.' ),
			array( '', 'Theme updates', 'Move your customizations to a new theme version safely, so you get new features without losing changes.' ),
		),
	),
	'packages' => array(
		'eyebrow' => 'Packages',
		'h2'      => 'Shopify Theme Customization <em>Prices</em>',
		'anchor'  => 'shopify-theme-customization-price',
		'lead'    => 'Pay per task, or bundle several changes for a lower price.',
		'plans'   => array(
			array( 'Single task', '$50', '/ task', 'One clear change to your theme.', array( 'One layout or design change', 'Done on a duplicate theme', 'Mobile &amp; desktop tested', '7 days of follow-up support' ), false, 'Choose Single task', $contact ),
			array( 'Custom section', '$60', '/ section', 'A new section you can edit in the theme editor.', array( 'Custom Liquid section', 'Settings you can change yourself', 'Mobile-first design', 'Replaces a paid app where possible', '14 days of follow-up support' ), true, 'Choose Custom section →', $contact ),
			array( 'Theme makeover', '$299', '/ store', 'A full refresh of your theme’s key pages.', array( 'Homepage, product &amp; collection pages', 'Header, footer &amp; cart', 'Brand colors &amp; typography', 'Speed check', '30 days of follow-up support' ), false, 'Choose Theme makeover', $contact ),
		),
		'note'    => 'Need many small changes every month? Our monthly Shopify support from $49/month may work out cheaper.',
	),
	'steps_h2' => 'Customize Your Shopify Theme in 4 Steps. <em>Usually in 1–2 Days.</em>',
	'why'      => array(
		'eyebrow'    => 'Why BestWebExpert',
		'h2'         => 'Why Hire a Shopify Theme Developer Like Us',
		'anchor'     => 'why-hire-a-shopify-theme-developer',
		'paragraphs' => array(
			'Quick theme edits often go in the wrong place: they break on the next theme update, slow down the store or can’t be changed without a developer.',
			'We build changes the Online Store 2.0 way, as sections and blocks with settings you can edit yourself, and we work on a duplicate theme so your live store is never at risk.',
			'Fixed price per task, a preview before anything goes live and free follow-up support after.',
		),
		'image'      => array( 'shopify', 'Shopify theme customization for a skincare brand store' ),
		'card_title' => 'Every customization includes',
		'checks'     => array( 'Work on a duplicate theme', 'Editable sections, not hard-coded changes', 'Mobile and desktop testing', 'Preview before publishing', 'Free follow-up support' ),
	),
	'faq'      => array(
		'h2'     => 'Shopify Theme Customization <em>FAQ</em>',
		'anchor' => 'shopify-theme-customization-faq',
		'lead'   => 'Have a change in mind? Send a screenshot and we’ll quote it.',
		'items'  => array(
			array( 'How much does Shopify theme customization cost?', 'Single changes start at $50, custom Liquid sections at $60 and a full theme makeover at $299. You get a fixed price before we start.' ),
			array( 'Which themes do you work with?', 'Dawn and all free Shopify themes, premium themes from the Shopify Theme Store and custom themes built by other developers.' ),
			array( 'Will my changes be lost when the theme updates?', 'We build changes as sections and blocks wherever possible, and we can move your customizations to new theme versions for you.' ),
			array( 'Is it safe for my live store?', 'Yes. We work on a duplicate theme, you preview the result, and we publish only when you approve.' ),
			array( 'Can you replace a paid app with custom code?', 'Often, yes. Size charts, tabs, badges, countdowns and simple upsells can usually be built into your theme, saving you a monthly fee.' ),
			array( 'How do I give you access?', 'You add us as a collaborator from your Shopify admin with only the permissions needed, and remove us when the work is done.' ),
		),
	),
	'final'    => array(
		'h2'   => 'Make Your Shopify Theme <em>Truly Yours</em>',
		'lead' => 'Send a screenshot or description of the change. You’ll get a fixed price, usually within 2 hours.',
	),
	'related'  => array(
		'shopify-store-setup'        => 'Shopify store setup',
		'shopify-speed-optimization' => 'Shopify speed optimization',
	),
	'schema'   => array(
		'name'        => 'Shopify theme customization service',
		'type'        => 'Shopify theme customization',
		'description' => 'Shopify theme customization for Dawn, premium and custom themes: product and collection pages, custom Liquid sections, cart and header changes and theme updates.',
		'catalog'     => 'Shopify theme customization packages',
		'prices'      => array(
			'Shopify theme change'         => 49,
			'Custom Shopify Liquid section' => 59,
			'Shopify theme makeover'       => 299,
		),
	),
);
