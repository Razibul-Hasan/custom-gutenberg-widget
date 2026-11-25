<?php
/**
 * Starter content: a block inserted from the inserter (or an item added with "+") arrives filled with sample text
 * and items in the site's own words, so it shows its finished look right away — then you just edit the words.
 *
 * Done with a default block variation ("isDefault", inserter scope) per block. Variations only act when a block is
 * inserted, so blocks already on pages keep exactly what they have.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * FAQ question with a one-paragraph answer (inner-blocks template form).
 *
 * @param string $n        Number.
 * @param string $question Question.
 * @param string $answer   Answer.
 * @param bool   $extra    Hidden until "Show more".
 */
function bwe_gw_starter_faq( $n, $question, $answer, $extra = false ) {
	return array( 'bwe/faq-item', array_filter( array( 'n' => $n, 'question' => $question, 'extra' => $extra ) ), array( array( 'core/paragraph', array( 'content' => $answer ) ) ) );
}

/**
 * Price plan with its feature list.
 *
 * @param array    $attrs    Plan attributes.
 * @param string[] $features Feature lines.
 */
function bwe_gw_starter_plan( array $attrs, array $features ) {
	return array(
		'bwe/price-plan',
		$attrs,
		array( array( 'core/list', array( 'bwePart' => bwe_gw_part_for( 'core/list', 'bwex-checks' ) ), array_map( static fn( $f ) => array( 'core/list-item', array( 'content' => $f ) ), $features ) ) ),
	);
}

/**
 * Starter attributes + inner blocks per block.
 *
 * @return array<string, array{0: array, 1?: array}>
 */
function bwe_gw_starters() {
	$spec  = array(
		array( 'bwe/spec-card', array( 'name' => __( 'Speed', 'bestwebexpert' ), 'text' => __( 'Images, code, fonts and caching tuned until pages feel instant on a mid-range phone.', 'bestwebexpert' ), 'chip' => __( 'Core Web Vitals: pass', 'bestwebexpert' ) ) ),
		array( 'bwe/spec-card', array( 'name' => __( 'Mobile-first design', 'bestwebexpert' ), 'text' => __( 'Laid out for thumbs first, then scaled up for tablets and desktops.', 'bestwebexpert' ), 'chip' => __( '360px and up', 'bestwebexpert' ) ) ),
		array( 'bwe/spec-card', array( 'name' => __( 'SEO foundations', 'bestwebexpert' ), 'text' => __( 'Clean headings, schema, an XML sitemap and internal links, set up before launch.', 'bestwebexpert' ), 'chip' => __( 'Schema + sitemap', 'bestwebexpert' ) ) ),
	);
	$steps = array(
		array( 'bwe/step', array( 'n' => '01', 'title' => __( 'Free strategy call', 'bestwebexpert' ), 'text' => __( 'Tell us your goals. We give you a clear plan, timeline and fixed price.', 'bestwebexpert' ) ) ),
		array( 'bwe/step', array( 'n' => '02', 'title' => __( 'Design you’ll love', 'bestwebexpert' ), 'text' => __( 'See your new website before any code is written.', 'bestwebexpert' ) ) ),
		array( 'bwe/step', array( 'n' => '03', 'title' => __( 'Build &amp; optimize', 'bestwebexpert' ), 'text' => __( 'Fast, SEO-ready code, tested on every device.', 'bestwebexpert' ) ) ),
		array( 'bwe/step', array( 'n' => '04', 'title' => __( 'Launch &amp; grow', 'bestwebexpert' ), 'text' => __( 'We go live, train your team and keep improving.', 'bestwebexpert' ) ) ),
	);
	$faq   = array(
		bwe_gw_starter_faq( '01', __( 'How long does a website take?', 'bestwebexpert' ), __( 'Most business websites launch in 2–4 weeks. You get a timeline with your fixed quote.', 'bestwebexpert' ) ),
		bwe_gw_starter_faq( '02', __( 'Do I own my website?', 'bestwebexpert' ), __( 'Yes. Once the project is paid, the site, content, domain and accounts are yours.', 'bestwebexpert' ) ),
		bwe_gw_starter_faq( '03', __( 'Can you fix my existing site?', 'bestwebexpert' ), __( 'Yes. We fix speed, bugs, security and design on existing WordPress and Shopify sites.', 'bestwebexpert' ) ),
	);
	$plans = array(
		bwe_gw_starter_plan( array( 'name' => __( 'Starter', 'bestwebexpert' ), 'price' => __( '$250 <em>/ project</em>', 'bestwebexpert' ), 'desc' => __( 'For new businesses that need a sharp, professional website, fast.', 'bestwebexpert' ), 'btnText' => __( 'Choose Starter', 'bestwebexpert' ), 'btnUrl' => '/contact/' ), array( __( 'Up to 5 pages', 'bestwebexpert' ), __( 'Mobile-first design', 'bestwebexpert' ), __( 'On-page SEO setup', 'bestwebexpert' ) ) ),
		bwe_gw_starter_plan( array( 'name' => __( 'Growth', 'bestwebexpert' ), 'price' => __( '$599 <em>/ project</em>', 'bestwebexpert' ), 'desc' => __( 'For brands ready to turn traffic into serious revenue.', 'bestwebexpert' ), 'featured' => true, 'badge' => __( 'Most popular', 'bestwebexpert' ), 'btnText' => __( 'Choose Growth →', 'bestwebexpert' ), 'btnUrl' => '/contact/' ), array( __( 'Up to 15 pages or a store', 'bestwebexpert' ), __( 'Speed optimization (90+)', 'bestwebexpert' ), __( '30 days of free support', 'bestwebexpert' ) ) ),
		bwe_gw_starter_plan( array( 'name' => __( 'Custom', 'bestwebexpert' ), 'price' => __( 'Let’s talk', 'bestwebexpert' ), 'desc' => __( 'For complex builds, custom functionality and big ambitions.', 'bestwebexpert' ), 'btnText' => __( 'Get a custom quote', 'bestwebexpert' ), 'btnUrl' => '/contact/' ), array( __( 'Custom plugins &amp; integrations', 'bestwebexpert' ), __( 'Platform migrations', 'bestwebexpert' ), __( 'Priority support', 'bestwebexpert' ) ) ),
	);
	$cost  = array(
		array( 'text' => __( '<strong>Pages and features.</strong> A five-page site is a very different project from a 500-product store.', 'bestwebexpert' ), 'wrap' => '' ),
		array( 'text' => __( '<strong>Platform and integrations.</strong> CRM, booking or inventory integrations add development time.', 'bestwebexpert' ), 'wrap' => '' ),
		array( 'text' => __( '<strong>Content, SEO and migration.</strong> We plan for it up front, so there are no surprise invoices.', 'bestwebexpert' ), 'wrap' => '' ),
	);
	$video = array(
		array( 'bwe/video-card', array( 'url' => 'https://www.youtube.com/shorts/LlD2xDq5z_c', 'who' => __( '<strong>Client name</strong> Business · Shopify store', 'bestwebexpert' ) ) ),
		array( 'bwe/video-card', array( 'url' => 'https://www.youtube.com/shorts/DEHGV4BIoX8', 'who' => __( '<strong>Client name</strong> Business · WordPress website', 'bestwebexpert' ) ) ),
		array( 'bwe/video-card', array( 'url' => 'https://www.youtube.com/shorts/W2iPvOXwmqU', 'who' => __( '<strong>Client name</strong> Business · WooCommerce store', 'bestwebexpert' ) ) ),
	);
	$cards = array(
		array( 'bwe/product-card', array( 'art' => 'reels', 'tag' => __( 'Free WooCommerce plugin', 'bestwebexpert' ), 'name' => __( 'ProductReels', 'bestwebexpert' ), 'text' => __( 'Shoppable video reels for WooCommerce: carousels, stories, grids and popups.', 'bestwebexpert' ), 'links' => __( '<a href="/shop-the-look/">Shop the look</a> <a href="/lookbook/">Lookbook</a>', 'bestwebexpert' ), 'btnText' => __( 'Explore ProductReels →', 'bestwebexpert' ), 'btnUrl' => '/productreels/' ) ),
		array( 'bwe/product-card', array( 'art' => 'boxes', 'tag' => __( 'Free WooCommerce plugin', 'bestwebexpert' ), 'name' => __( 'ProductBoxes', 'bestwebexpert' ), 'text' => __( 'Build-your-own boxes and mix-and-match bundles with tiered discounts.', 'bestwebexpert' ), 'links' => __( '<a href="/gift-box-builder/">Gift box</a> <a href="/shirt-bundle/">Any 3 shirts</a>', 'bestwebexpert' ), 'btnText' => __( 'Explore ProductBoxes →', 'bestwebexpert' ), 'btnUrl' => '/productboxes/' ) ),
		array( 'bwe/product-card', array( 'art' => 'lift', 'tag' => __( 'Free WordPress plugin', 'bestwebexpert' ), 'name' => __( 'MigrateLift', 'bestwebexpert' ), 'text' => __( 'Migration, backup and restore for WordPress in one archive.', 'bestwebexpert' ), 'linksLabel' => __( 'Take a look', 'bestwebexpert' ), 'links' => __( '<a href="/migrate-lift/#screenshots">Screenshots</a>', 'bestwebexpert' ), 'btnText' => __( 'Explore MigrateLift →', 'bestwebexpert' ), 'btnUrl' => '/migrate-lift/' ) ),
	);
	$tiles = array(
		array( 'bwe/service-tile', array( 'icon' => 'wordpress', 'platform' => 'wp', 'tag' => __( 'WordPress', 'bestwebexpert' ), 'name' => __( 'WordPress websites', 'bestwebexpert' ), 'desc' => __( 'Fast, SEO-ready business sites.', 'bestwebexpert' ), 'url' => '/best-wordpress-expert/' ) ),
		array( 'bwe/service-tile', array( 'icon' => 'shopify', 'platform' => 'shopify', 'tag' => __( 'Shopify', 'bestwebexpert' ), 'name' => __( 'Shopify stores', 'bestwebexpert' ), 'desc' => __( 'Stores built to sell from day one.', 'bestwebexpert' ), 'url' => '/best-shopify-expert/' ) ),
		array( 'bwe/service-tile', array( 'icon' => 'speed', 'platform' => 'both', 'tag' => __( 'Speed', 'bestwebexpert' ), 'name' => __( 'Speed optimization', 'bestwebexpert' ), 'desc' => __( '90+ PageSpeed on real phones.', 'bestwebexpert' ), 'url' => '/wordpress-speed-optimization/' ) ),
	);
	$who   = array(
		array( 'bwe/who-card', array( 'title' => __( 'Small businesses', 'bestwebexpert' ), 'text' => __( 'A site that brings in calls and bookings.', 'bestwebexpert' ), 'tag' => __( 'Websites', 'bestwebexpert' ), 'url' => '/best-wordpress-expert/' ) ),
		array( 'bwe/who-card', array( 'title' => __( 'Online stores', 'bestwebexpert' ), 'text' => __( 'A store that loads fast and checks out cleanly.', 'bestwebexpert' ), 'tag' => __( 'E-commerce', 'bestwebexpert' ), 'url' => '/best-shopify-expert/' ) ),
		array( 'bwe/who-card', array( 'title' => __( 'Agencies', 'bestwebexpert' ), 'text' => __( 'A developer you can hand work to.', 'bestwebexpert' ), 'tag' => __( 'White label', 'bestwebexpert' ), 'url' => '/contact/' ) ),
	);
	$rows  = array(
		array( 'bwe/price-row', array( 'service' => __( 'WordPress support &amp; bug fix', 'bestwebexpert' ), 'note' => __( 'Same day', 'bestwebexpert' ), 'amount' => '$20', 'unit' => '/ fix' ) ),
		array( 'bwe/price-row', array( 'service' => __( 'Speed optimization', 'bestwebexpert' ), 'note' => __( '90+ PageSpeed', 'bestwebexpert' ), 'amount' => '$99', 'unit' => '/ site' ) ),
		array( 'bwe/price-row', array( 'service' => __( 'Business website', 'bestwebexpert' ), 'note' => __( 'Up to 5 pages', 'bestwebexpert' ), 'amount' => '$250', 'unit' => '/ project' ) ),
	);
	// Home's two platform cards; their pictures by media ID, so the URL is always this site's own.
	$img   = static fn( int $id, string $alt ): array => wp_attachment_is_image( $id ) ? array( 'imageId' => $id, 'imageUrl' => (string) wp_get_attachment_image_url( $id, 'large' ), 'imageAlt' => $alt ) : array();
	// Their service links (drawn as chips), as on Home; an empty list would show a "List" placeholder in the editor.
	$checks = static fn( array $links ): array => array( array( 'core/list', array( 'bwePart' => bwe_gw_part_for( 'core/list', 'bwex-checks' ) ), array_map( static fn( $url, $text ) => array( 'core/list-item', array( 'content' => '<a href="' . $url . '">' . $text . '</a>' ) ), array_keys( $links ), $links ) ) );
	$plats = array(
		array( 'bwe/platform-card', $img( 900, __( 'Custom WordPress website design concept', 'bestwebexpert' ) ) + array( 'chip' => __( 'WordPress', 'bestwebexpert' ), 'title' => __( 'Custom WordPress Development', 'bestwebexpert' ), 'titleUrl' => '/best-wordpress-expert/', 'text' => __( 'Custom WordPress websites built for speed, search rankings and easy editing.', 'bestwebexpert' ), 'price' => __( 'Starting at <strong>$250</strong>', 'bestwebexpert' ), 'btnText' => __( 'See WordPress pricing →', 'bestwebexpert' ), 'btnUrl' => '/pricing/#wordpress-prices' ), $checks( array( '/woocommerce-development/' => __( 'WooCommerce development', 'bestwebexpert' ), '/wordpress-speed-optimization/' => __( 'WordPress speed optimization', 'bestwebexpert' ), '/wordpress-migration/' => __( 'WordPress migration', 'bestwebexpert' ), '/wordpress-malware-removal/' => __( 'Hacked site &amp; malware removal', 'bestwebexpert' ), '/wordpress-maintenance/' => __( 'Maintenance &amp; care plans', 'bestwebexpert' ) ) ) ),
		array( 'bwe/platform-card', $img( 902, __( 'Shopify store design concept', 'bestwebexpert' ) ) + array( 'chip' => __( 'Shopify', 'bestwebexpert' ), 'title' => __( 'Shopify Store Design &amp; Development', 'bestwebexpert' ), 'titleUrl' => '/best-shopify-expert/', 'text' => __( 'Shopify stores that look premium and turn browsers into buyers.', 'bestwebexpert' ), 'price' => __( 'Starting at <strong>$250</strong>', 'bestwebexpert' ), 'btnText' => __( 'See Shopify pricing →', 'bestwebexpert' ), 'btnUrl' => '/pricing/#shopify-prices' ), $checks( array( '/shopify-store-setup/' => __( 'Shopify store setup', 'bestwebexpert' ), '/shopify-theme-customization/' => __( 'Shopify theme customization', 'bestwebexpert' ), '/shopify-speed-optimization/' => __( 'Shopify speed optimization', 'bestwebexpert' ), '/migrate-to-shopify/' => __( 'Migrate to Shopify', 'bestwebexpert' ) ) ) ),
	);
	// The Pricing page's two price cards (Fixes & services).
	$row         = static fn( string $service, string $note, string $amount, string $unit ): array => array( 'bwe/price-row', array( 'service' => $service, 'note' => $note, 'amount' => $amount, 'unit' => $unit ) );
	$price_cards = array(
		array(
			'bwe/price-card',
			array( 'cardId' => 'wordpress-prices', 'chip' => __( 'WordPress', 'bestwebexpert' ), 'title' => __( 'WordPress Expert Pricing', 'bestwebexpert' ), 'titleUrl' => '/best-wordpress-expert/', 'text' => __( 'Fixes, speed, security, migrations, new websites and WooCommerce stores.', 'bestwebexpert' ), 'price' => __( 'Websites from <strong>$250</strong>', 'bestwebexpert' ), 'btnText' => __( 'Get a WordPress quote →', 'bestwebexpert' ), 'btnUrl' => '/contact/' ),
			array(
				array(
					'bwe/price-list',
					array(),
					array(
						$row( __( 'WordPress support &amp; bug fix', 'bestwebexpert' ), __( 'Same day', 'bestwebexpert' ), '$20', '/ fix' ),
						$row( __( 'WordPress customization', 'bestwebexpert' ), __( '1–2 days', 'bestwebexpert' ), '$40', '/ page' ),
						$row( __( '<a href="/wordpress-malware-removal/">Malware removal &amp; security</a>', 'bestwebexpert' ), __( '24 hours', 'bestwebexpert' ), '$50', '/ site' ),
						$row( __( '<a href="/wordpress-speed-optimization/">Speed optimization</a>', 'bestwebexpert' ), __( '2–3 days', 'bestwebexpert' ), '$70', '/ site' ),
						$row( __( '<a href="/best-wordpress-expert/">New WordPress website</a>', 'bestwebexpert' ), __( '2–4 weeks', 'bestwebexpert' ), '$250', '/ project' ),
					),
				),
			),
		),
		array(
			'bwe/price-card',
			array( 'cardId' => 'shopify-prices', 'chip' => __( 'Shopify', 'bestwebexpert' ), 'title' => __( 'Shopify Expert Pricing', 'bestwebexpert' ), 'titleUrl' => '/best-shopify-expert/', 'text' => __( 'Store setup, theme changes, apps, speed and migrations.', 'bestwebexpert' ), 'price' => __( 'Stores from <strong>$250</strong>', 'bestwebexpert' ), 'btnText' => __( 'Get a Shopify quote →', 'bestwebexpert' ), 'btnUrl' => '/contact/' ),
			array(
				array(
					'bwe/price-list',
					array(),
					array(
						$row( __( 'Shopify support &amp; bug fix', 'bestwebexpert' ), __( 'Same day', 'bestwebexpert' ), '$20', '/ fix' ),
						$row( __( 'App setup &amp; integration', 'bestwebexpert' ), __( '1 day', 'bestwebexpert' ), '$30', '/ setup' ),
						$row( __( '<a href="/shopify-theme-customization/">Theme customization</a>', 'bestwebexpert' ), __( '1–2 days', 'bestwebexpert' ), '$50', '/ task' ),
						$row( __( '<a href="/shopify-speed-optimization/">Shopify speed optimization</a>', 'bestwebexpert' ), __( '2–3 days', 'bestwebexpert' ), '$79', '/ store' ),
						$row( __( '<a href="/shopify-store-setup/">New Shopify store</a>', 'bestwebexpert' ), __( '3–5 weeks', 'bestwebexpert' ), '$250', '/ project' ),
					),
				),
			),
		),
	);
	$new_card    = array(
		array( 'chip' => __( 'New', 'bestwebexpert' ), 'title' => __( 'New service pricing', 'bestwebexpert' ), 'text' => __( 'One or two lines about these services, in plain words.', 'bestwebexpert' ), 'price' => __( 'From <strong>$20</strong>', 'bestwebexpert' ), 'btnText' => __( 'Get a quote →', 'bestwebexpert' ), 'btnUrl' => '/contact/' ),
		array( array( 'bwe/price-list', array(), $rows ) ),
	);
	// Portfolio projects (Selected work); screenshots by media ID, so the URL is always this site's own.
	$shot     = static fn( int $id, string $alt ): array => wp_attachment_is_image( $id ) ? array( 'imageId' => $id, 'imageUrl' => (string) wp_get_attachment_image_url( $id, 'full' ), 'imageAlt' => $alt ) : array();
	$projects = array(
		array( 'bwe/work-item', $shot( 1851, __( 'BestWebExpert website home page screenshot', 'bestwebexpert' ) ) + array( 'num' => '01', 'url' => '/', 'title' => __( 'BestWebExpert', 'bestwebexpert' ), 'tag' => __( 'Website', 'bestwebexpert' ), 'text' => __( 'This website: fast, SEO-ready WordPress built from custom block patterns, with no page builder.', 'bestwebexpert' ) ) ),
		array( 'bwe/work-item', $shot( 1852, __( 'ProductReels plugin video layouts screenshot', 'bestwebexpert' ) ) + array( 'num' => '02', 'url' => '/productreels/', 'title' => __( 'ProductReels', 'bestwebexpert' ), 'tag' => __( 'WordPress plugin', 'bestwebexpert' ), 'text' => __( 'Shoppable video reels for WooCommerce: carousels, story bubbles, grids and popups.', 'bestwebexpert' ) ) ),
		array( 'bwe/work-item', $shot( 1853, __( 'ProductBoxes plugin campaign types screenshot', 'bestwebexpert' ) ) + array( 'num' => '03', 'url' => '/productboxes/', 'title' => __( 'ProductBoxes', 'bestwebexpert' ), 'tag' => __( 'WordPress plugin', 'bestwebexpert' ), 'text' => __( 'Build-your-own boxes and mix-and-match bundles with tiered discounts.', 'bestwebexpert' ) ) ),
	);
	// Contact form section: the "Project enquiry" form when it exists, else the first form.
	$cf7  = function_exists( 'bwe_gw_cf7_forms' ) ? bwe_gw_cf7_forms() : array();
	$form = '';
	foreach ( $cf7 as $f ) {
		$form = ( '' === $form || 'Project enquiry' === $f['title'] ) ? $f['shortcode'] : $form;
	}
	$wa    = 'https://wa.me/8801794014979';
	$about = array(
		array(
			'headingId' => 'about-me',
			'lead'      => __( 'I’m the founder and lead developer behind BestWebExpert. For more than seven years I’ve built WordPress websites, WooCommerce stores and Shopify stores for businesses that need their website to bring in leads and sales.', 'bestwebexpert' ),
			'more'      => array( __( 'I also build free WordPress plugins: <a href="/productreels/">ProductReels</a>, <a href="/productboxes/">ProductBoxes</a> and <a href="/migrate-lift/">MigrateLift</a>.', 'bestwebexpert' ) ),
			'cardTitle' => __( 'Fastest ways to reach me', 'bestwebexpert' ),
			'btnText'   => __( 'Chat on WhatsApp →', 'bestwebexpert' ),
			'btnUrl'    => $wa,
			'btnNewTab' => true,
		),
		array( array( 'core/list', array( 'bwePart' => bwe_gw_part_for( 'core/list', 'bwex-checks' ) ), array( array( 'core/list-item', array( 'content' => '<a href="' . $wa . '">WhatsApp</a>' ) ), array( 'core/list-item', array( 'content' => __( '<a href="/contact/">The contact form</a>', 'bestwebexpert' ) ) ), array( 'core/list-item', array( 'content' => __( 'Live chat, bottom right of every page', 'bestwebexpert' ) ) ) ) ) ),
	);
	$head  = array( 'eyebrow' => __( 'Why BestWebExpert', 'bestwebexpert' ), 'title' => __( 'What Makes Us <em>The Right Partner</em>', 'bestwebexpert' ), 'intro' => __( 'We check these lines on every website we build, whatever the budget, before anything goes live.', 'bestwebexpert' ) );

	return array(
		'bwe/hero'            => array( array( 'title' => __( 'Best Web Developer for WordPress &amp; Shopify <em>Sites That Sell</em>', 'bestwebexpert' ), 'lead' => __( 'Fast, SEO-ready websites and stores designed to turn visitors into customers.', 'bestwebexpert' ), 'btn1Text' => __( 'Claim my free audit →', 'bestwebexpert' ), 'btn1Url' => '/contact/', 'btn2Text' => __( 'See pricing', 'bestwebexpert' ), 'btn2Url' => '/pricing/' ) ),
		'bwe/services'        => array( array( 'eyebrow' => __( 'Services', 'bestwebexpert' ), 'title' => __( 'What We <em>Build &amp; Fix</em>', 'bestwebexpert' ), 'lead' => __( 'Pick a service, or tell us what you need.', 'bestwebexpert' ), 'more' => __( 'Not sure what you need? <a href="/contact/">Ask us →</a>', 'bestwebexpert' ) ), $tiles ),
		'bwe/service-tile'    => array( $tiles[0][1] ),
		'bwe/section-head'    => array( $head ),
		'bwe/spec-list'       => array( array(), $spec ),
		'bwe/spec-card'       => array( $spec[0][1] ),
		'bwe/steps'           => array( array(), $steps ),
		'bwe/step'            => array( array( 'title' => __( 'New step', 'bestwebexpert' ), 'text' => __( 'Say what happens in this step, in one line.', 'bestwebexpert' ) ) ),
		'bwe/faq-item'        => array( array( 'question' => __( 'Your question?', 'bestwebexpert' ) ), array( array( 'core/paragraph', array( 'content' => __( 'The answer, in a sentence or two.', 'bestwebexpert' ) ) ) ) ),
		'bwe/who-list'        => array( array(), $who ),
		'bwe/who-card'        => array( $who[0][1] ),
		'bwe/price-list'      => array( array(), $rows ),
		'bwe/price-row'       => array( $rows[0][1] ),
		'bwe/why-us'          => array( $head + array( 'aside' => __( 'Want your site checked against this list? <a href="/contact/">Get a free audit →</a>', 'bestwebexpert' ) ), $spec ),
		'bwe/testimonials'    => array( array( 'intro' => __( 'Business owners hire us to build, fix and grow their websites. Hear it from them.', 'bestwebexpert' ), 'more' => __( 'Read every review on <a href="https://www.fiverr.com/razibul_hasan">Fiverr ↗</a>.', 'bestwebexpert' ) ), $video ),
		'bwe/video-card'      => array( $video[0][1] ),
		'bwe/pricing'         => array( array( 'intro' => __( 'Every package comes with a fixed quote before we start.', 'bestwebexpert' ) ), array( array( 'bwe/plans', array(), $plans ), array( 'bwe/starting-prices', array() ), array( 'bwe/cost-panel', array( 'items' => $cost ) ) ) ),
		'bwe/plans'           => array( array(), $plans ),
		'bwe/price-plan'      => array( $plans[0][1], $plans[0][2] ),
		'bwe/cost-panel'      => array( array( 'items' => $cost ) ),
		'bwe/process'         => array( array(), $steps ),
		'bwe/products'        => array( array( 'intro' => __( 'We build and maintain free WordPress plugins — try their live demos.', 'bestwebexpert' ), 'more' => __( 'Want to see client work too? <a href="/portfolio/">Browse the portfolio →</a>', 'bestwebexpert' ) ), $cards ),
		'bwe/product-card'    => array( $cards[0][1] ),
		'bwe/faq'             => array( array( 'intro' => __( 'Answers to the questions we hear most.', 'bestwebexpert' ) ), $faq ),
		'bwe/platforms'       => array( array(), $plats ),
		'bwe/platform-card'   => array( $plats[0][1], $plats[0][2] ),
		'bwe/price-section'   => array( array(), $price_cards ),
		'bwe/price-card'      => $new_card,
		'bwe/work'            => array( array( 'headingId' => 'selected-work' ), $projects ),
		'bwe/contact-form'    => array( array( 'headingId' => 'project-form', 'note' => sprintf( /* translators: %s: WhatsApp link address. */ __( 'In a hurry? <a href="%s">WhatsApp me</a> or use the live chat.', 'bestwebexpert' ), $wa ), 'form' => $form ) ),
		'bwe/about'           => $about,
		'bwe/work-item'       => array( array( 'title' => __( 'New project', 'bestwebexpert' ), 'tag' => __( 'Website', 'bestwebexpert' ), 'text' => __( 'One line about the project and what it does.', 'bestwebexpert' ) ) ),
		'bwe/buttons'         => array( array( 'items' => array( array( 'text' => __( 'Claim my free audit →', 'bestwebexpert' ), 'url' => '/contact/', 'style' => 'primary' ), array( 'text' => __( 'See pricing', 'bestwebexpert' ), 'url' => '/pricing/', 'style' => 'outline' ) ) ) ),
		'bwe/cta'             => array( array( 'lead' => __( 'Book a free 15-minute call and walk away with 3 quick wins for your website.', 'bestwebexpert' ) ) ),
	);
}

/**
 * Whether this request can show the block editor or serve it data: wp-admin, AJAX, the REST API (block types,
 * patterns) or the CLI. Front-end page views never use inserter variations, so they skip building them.
 */
function bwe_gw_is_editor_request() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'WP_CLI' ) && WP_CLI ) || PHP_SAPI === 'cli' ) {
		return true;
	}
	// The REST API is not known yet at init (blocks register there), so look at the address.
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- only compared.
	return false !== strpos( $uri, '/' . rest_get_url_prefix() . '/' ) || isset( $_GET['rest_route'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read only.
}

/**
 * Attributes as a JSON object (an empty PHP array would become [] in the editor).
 *
 * @param array $attrs Attributes.
 */
function bwe_gw_starter_object( array $attrs ) {
	return $attrs ? $attrs : new stdClass();
}

/**
 * Inner-blocks template with every attribute list as a JSON object.
 *
 * @param array $template [ [ name, attrs, inner ], … ].
 */
function bwe_gw_starter_template( array $template ) {
	return array_map(
		static fn( $item ) => array_filter( array( $item[0], bwe_gw_starter_object( $item[1] ?? array() ), isset( $item[2] ) ? bwe_gw_starter_template( $item[2] ) : null ), static fn( $v ) => null !== $v ),
		$template
	);
}

/**
 * Adds the starter as the block's default inserter variation.
 *
 * @param array $metadata block.json data.
 */
function bwe_gw_starter_variation( $metadata ) {
	static $starters = null;
	$name            = (string) ( $metadata['name'] ?? '' );
	if ( 0 !== strpos( $name, 'bwe/' ) || ! bwe_gw_is_editor_request() ) {
		return $metadata;
	}
	// Built once per request (it was rebuilt for each of the ~40 blocks, ~190 translations every time).
	$starters = $starters ?? bwe_gw_starters();
	if ( ! isset( $starters[ $name ] ) ) {
		return $metadata;
	}
	$variation = array(
		'name'        => 'bwe-starter',
		'title'       => (string) ( $metadata['title'] ?? $name ),
		'description' => (string) ( $metadata['description'] ?? '' ),
		'isDefault'   => true,
		'scope'       => array( 'inserter' ),
		'attributes'  => bwe_gw_starter_object( $starters[ $name ][0] ),
	);
	if ( isset( $starters[ $name ][1] ) ) {
		$variation['innerBlocks'] = bwe_gw_starter_template( $starters[ $name ][1] );
	}
	if ( isset( $metadata['icon'] ) ) {
		$variation['icon'] = $metadata['icon'];
	}
	$metadata['variations'] = array_merge( array( $variation ), (array) ( $metadata['variations'] ?? array() ) );
	return $metadata;
}
add_filter( 'block_type_metadata', 'bwe_gw_starter_variation' );
