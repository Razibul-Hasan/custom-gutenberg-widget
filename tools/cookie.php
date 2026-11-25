<?php
/**
 * Prints admin login cookies (name=value per line) for the headless editor check.
 * Usage: php cookie.php <wp-root> > "%TEMP%/bwe-cookies.txt"   — the output is a secret; never save it in the web root.
 *
 * @package BWE_Gutenberg_Widget
 */

require __DIR__ . '/lib.php';
bwe_tb_boot( $argv[1] ?? '' );
$user = get_user_by( 'login', 'razibul_hasan' );
if ( ! $user ) {
	fwrite( STDERR, "admin user razibul_hasan not found\n" );
	exit( 1 );
}
$expires = time() + 6 * HOUR_IN_SECONDS;
echo LOGGED_IN_COOKIE . '=' . wp_generate_auth_cookie( $user->ID, $expires, 'logged_in' ) . "\n";
echo AUTH_COOKIE . '=' . wp_generate_auth_cookie( $user->ID, $expires, 'auth' ) . "\n";
