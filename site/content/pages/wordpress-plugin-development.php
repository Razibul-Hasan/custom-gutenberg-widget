<?php
/**
 * WordPress Plugin Development (page 2324, added 2026-11-25). The page itself is built from bwe/* widgets in the
 * editor; this file only feeds its Service schema (bwe_pb_json_ld()). Custom builds are quoted per project, so the
 * only listed price is the existing $20 fix price.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

return array(
	'schema' => array(
		'name'        => 'WordPress plugin development services',
		'type'        => 'WordPress plugin development',
		'description' => 'Custom WordPress plugin development: custom plugins, WooCommerce extensions, Gutenberg blocks, API integrations, plugin fixes and WordPress.org publishing.',
		'catalog'     => 'WordPress plugin development packages',
		'prices'      => array(
			'WordPress plugin fixes' => 20,
		),
	),
);
