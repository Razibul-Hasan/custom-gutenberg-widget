<?php
/**
 * Contact Form 7 tweaks for the contact page.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/*
 * The enquiry form's markup (Contact > Contact Forms) is laid out by assets/contact.css,
 * so Contact Form 7 must not wrap it in extra <p> and <br> tags.
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Loads Contact Form 7's scripts and styles only on pages that show a form.
 *
 * @param bool $load Whether Contact Form 7 would load them.
 * @return bool
 */
function bwe_contact_load_cf7_assets( $load ) {
	if ( ! $load || is_admin() ) {
		return $load;
	}

	return bwe_home_is_needed( '[contact-form-7' ) || bwe_home_is_needed( 'wp:contact-form-7/' );
}
add_filter( 'wpcf7_load_js', 'bwe_contact_load_cf7_assets' );
add_filter( 'wpcf7_load_css', 'bwe_contact_load_cf7_assets' );
