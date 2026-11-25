<?php
/**
 * Conversion event tracking for Google Analytics 4 (assets/bwe-events.js).
 *
 * Skipped for logged-in admins so your own clicks and test form sends are not counted.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * Loads the event script on the front end.
 */
function bwe_enqueue_tracking() {
	if ( is_admin() || current_user_can( 'manage_options' ) ) {
		return;
	}

	$file = BWE_HOME_DIR . '/assets/bwe-events.js';
	if ( ! is_readable( $file ) ) {
		return;
	}

	wp_enqueue_script(
		'bwe-events',
		plugins_url( 'assets/bwe-events.js', BWE_HOME_DIR . '/site.php' ),
		array(),
		(string) filemtime( $file ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'bwe_enqueue_tracking', 40 );
