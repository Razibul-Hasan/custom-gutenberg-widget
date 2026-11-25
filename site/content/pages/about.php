<?php
/**
 * About page. Rendered by bwe_pb_render().
 *
 * Facts come from the owner's public profiles (bwe_profiles()) and the site itself. Anything that couldn't be
 * confirmed (start year, city, team size) is left out rather than guessed.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

$contact  = home_url( '/contact/' );
$profiles = array();
foreach ( bwe_profiles() as $network => $url ) {
	$profiles[ $network ] = '<a href="' . esc_url( $url ) . '" target="_blank" rel="me noopener">' . $network . '</a>';
}

return array(
	'title'    => 'About',
	'seo'      => array(
		'title'       => 'About BestWebExpert: Razibul Hasan, WordPress & Shopify',
		'description' => 'Meet Razibul Hasan, the WordPress and Shopify developer behind BestWebExpert: custom themes, plugins and WooCommerce, three free plugins on WordPress.org and 5-star client reviews.',
		'keyword'     => 'Razibul Hasan,about BestWebExpert,WordPress developer Bangladesh,WordPress and Shopify expert,WooCommerce developer',
		'og_title'    => 'About Razibul Hasan, the WordPress & Shopify Expert Behind BestWebExpert',
		'image'       => 'social',
	),
	'sections' => array(
		bwe_pb_hero(
			array(
				'pill'      => array( 'See our plugins on WordPress.org →', 'https://wordpress.org/plugins/productreels/' ),
				'kicker'    => 'Two platforms. One focus. Your growth.',
				'h1'        => 'Meet the Expert Behind <em>BestWebExpert</em>',
				'lead'      => 'BestWebExpert is run by Razibul Hasan, a WordPress developer from Bangladesh who specializes in custom themes, plugins and WooCommerce, and builds Shopify stores too. For more than seven years, businesses around the world have hired Razibul to fix, speed up and build their websites.',
				'buttons'   => array( array( 'Work with Razibul →', $contact, 'accent' ), array( 'The story ↓', '#story', 'ghost' ) ),
				'jump'      => array( array( 'The story', '#story' ), array( 'How we work', '#values' ), array( 'FAQ', '#faq' ) ),
				'num'       => '5.0',
				'label'     => 'star rating from clients on Fiverr, with reviews you can read on the profile',
				'checks'    => array( 'Custom themes &amp; plugins', 'WooCommerce &amp; Shopify', 'Three plugins on WordPress.org' ),
				'sticker_a' => 'WordPress.org plugin author ✦',
				'sticker_b' => '✓ Fixed quotes',
			)
		),
		bwe_pb_stats(
			array(
				array( '7+', 'years of WordPress &amp; Shopify experience' ),
				array( '5.0', 'star rating on Fiverr' ),
				array( '3', 'free plugins on WordPress.org' ),
				array( '&lt;2h', 'typical first reply time' ),
			)
		),
		bwe_pb_group(
			bwe_pb_group(
				bwe_pb_join(
					array(
						bwe_pb_p( 'The story', 'bwe-eyebrow' ),
						bwe_pb_h( 'A WordPress Developer Who <em>Builds the Tools</em>, Not Just the Sites', 2, '', 'the-story' ),
						bwe_pb_p( 'Razibul Hasan is a custom WordPress developer from Bangladesh. Most of the work is the kind clients struggle to find someone reliable for: custom themes, custom plugins, WooCommerce stores, and fixing sites that are broken, slow or hacked. Clients on ' . $profiles['Fiverr'] . ' rate that work 5.0 stars, mostly for on-time delivery and fast fixes, and Razibul also takes projects on ' . $profiles['Upwork'] . '.' ),
						bwe_pb_p( 'BestWebExpert brings that work under one name, for WordPress and Shopify. Most businesses don’t need a big agency; they need one expert who replies quickly, explains things clearly and charges a fair, fixed price. That’s the whole idea behind this studio.' ),
						bwe_pb_p( 'Razibul also builds WordPress and WooCommerce plugins that anyone can install for free from WordPress.org: <a href="' . esc_url( home_url( '/productreels/' ) ) . '">ProductReels</a> for shoppable video reels, <a href="' . esc_url( home_url( '/productboxes/' ) ) . '">ProductBoxes</a> for build-your-own boxes and <a href="' . esc_url( home_url( '/migrate-lift/' ) ) . '">MigrateLift</a> for site migration, backup and restore. Writing code that thousands of stores can run keeps it clean, secure and up to date, and every client project benefits.' ),
						bwe_home_image( 'social', 'bwe-shot', 'BestWebExpert by Razibul Hasan: WordPress and Shopify development' ),
					)
				),
				'bwe-about__copy'
			) . "\n\n" . bwe_pb_group(
				bwe_pb_join(
					array(
						bwe_pb_h( 'At a glance', 3 ),
						bwe_pb_list(
							array(
								'Founder: Razibul Hasan',
								'Based in: Bangladesh, working with clients worldwide',
								'Specialty: custom WordPress themes, plugins &amp; WooCommerce',
								'Also: Shopify stores, speed, security &amp; migrations',
								'Plugins: ProductReels, ProductBoxes, MigrateLift',
								'Find Razibul on: ' . implode( ', ', $profiles ),
							)
						),
						bwe_pb_buttons( array( array( 'Start a project →', $contact, 'primary' ) ) ),
					)
				),
				'bwe-about__card'
			),
			'bwe-section bwe-tint bwe-about',
			'section',
			'story'
		),
		bwe_pb_cards(
			array(
				'eyebrow' => 'How we work',
				'h2'      => 'Six Promises We Make to <em>Every Client</em>',
				'anchor'  => 'how-we-work',
				'lead'    => 'These aren’t slogans. They’re how every job runs, from a $20 fix to a full store.',
				'cards'   => array(
					array( '', 'Fixed prices', 'You get the total price in writing before we start. No hourly meter, no surprise invoices.' ),
					array( '', 'No fix, no fee', 'If we can’t solve the problem, you don’t pay. Simple as that.' ),
					array( '', 'Safety first', 'Full backups before every change, and work on staging sites or duplicate themes whenever possible.' ),
					array( '', 'Plain language', 'We explain what we did and why, without jargon, so you always understand your own website.' ),
					array( '', 'Fast replies', 'A real person replies, usually within 2 hours on business days. No ticket queues.' ),
					array( '', 'You own everything', 'Your code, content, domain and logins stay in your name. No lock-in, ever.' ),
				),
			),
			'',
			'values'
		),
		bwe_pb_faq(
			array(
				'h2'     => 'About Us <em>FAQ</em>',
				'anchor' => 'about-faq',
				'lead'   => 'Want to know more before you hire us? Just ask.',
				'cta'    => $contact,
				'items'  => array(
					array( 'Who will work on my project?', 'Every project is led by Razibul Hasan, and you talk directly to the person doing the work. No account managers in between.' ),
					array( 'Where are you based?', 'In Bangladesh, working with clients worldwide. Calls are scheduled in your time zone, and most messages get a reply within 2 hours on business days.' ),
					array( 'Can I hire you on Fiverr or Upwork instead?', 'Yes. You can hire Razibul on ' . $profiles['Fiverr'] . ' or ' . $profiles['Upwork'] . ' if you prefer the platform’s payment protection, or work directly through our <a href="' . esc_url( $contact ) . '">contact page</a>.' ),
					array( 'Why only WordPress and Shopify?', 'Because focus makes us faster and better. Instead of being average at ten platforms, we know two platforms deeply, including how to fix them when things go wrong.' ),
					array( 'Can I see your work?', 'Yes. See our <a href="' . esc_url( home_url( '/portfolio/' ) ) . '">portfolio</a>, try our free plugins on WordPress.org, or ask for examples similar to your project.' ),
				),
			)
		),
		bwe_pb_final(
			array(
				'h2'      => 'Let’s Work <em>Together</em>',
				'anchor'  => '',
				'lead'    => 'Tell us about your website or store. You’ll get honest advice and a fixed price, usually within 2 hours.',
				'buttons' => array( array( 'Start a project →', $contact, 'primary' ), array( 'See pricing', home_url( '/pricing/' ), 'ghost' ) ),
				'note'    => 'No pressure. No sales pitch. Just honest advice.',
			)
		),
	),
);
