<?php
/**
 * Require BEFORE WordPress loads: this CLI process runs as if BestWebExpert Home were deactivated, so the widget's
 * own site layer (site/) is used. Nothing is saved; the site's real plugin list is untouched.
 *
 * @package BWE_Gutenberg_Widget
 */

if ( PHP_SAPI !== 'cli' ) {
	exit;
}

// Pre-initialized hook (WP_Hook::build_preinitialized_hooks): active before any plugin loads.
$GLOBALS['wp_filter']['option_active_plugins'][10][] = array(
	'function'      => static fn( $plugins ) => array_values( array_filter( (array) $plugins, static fn( $p ) => 0 !== strpos( (string) $p, 'bestwebexpert-home/' ) ) ),
	'accepted_args' => 1,
);
