<?php
/**
 * Shared contact details and profiles (used by the About/Portfolio pages, schema, and the astra-child
 * header panel and footer), plus the display font loaded on every page.
 *
 * The site footer itself is rendered by the astra-child theme (inc/footer.php, Customizer → Footer).
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * WhatsApp number in international format, digits only.
 */
define( 'BWE_WHATSAPP', '8801794014979' );

/**
 * Contact email.
 */
define( 'BWE_EMAIL', 'razibulhasan.ra@gmail.com' );

/**
 * Razibul Hasan's public profiles, used in the footer, on the About and Portfolio pages and as schema sameAs links.
 *
 * @return array<string, string> Network => URL.
 */
function bwe_profiles() {
	return array(
		'Fiverr'   => 'https://www.fiverr.com/razibul_hasan',
		'Upwork'   => 'https://www.upwork.com/freelancers/~016283b7c5d2f22ff0',
		'LinkedIn' => 'https://www.linkedin.com/in/razibulhasanofficial/',
		'Facebook' => 'https://www.facebook.com/razibulhasanofficial',
	);
}

/**
 * WhatsApp link with a ready-made first message.
 *
 * @return string
 */
function bwe_footer_whatsapp_url() {
	return 'https://wa.me/' . BWE_WHATSAPP . '?text=' . rawurlencode( 'Hi! I found you on ' . wp_parse_url( home_url(), PHP_URL_HOST ) . ' and need help with my website.' );
}

/**
 * Display font (Bricolage Grotesque, used by the header and footer wordmark) on every front-end page.
 */
function bwe_site_fonts() {
	wp_enqueue_style(
		'bwe-home-fonts',
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500..800&display=swap',
		array(),
		null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Google Fonts URLs are versioned by their query string.
	);
}
add_action( 'wp_enqueue_scripts', 'bwe_site_fonts' );
