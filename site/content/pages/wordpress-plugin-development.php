<?php
/**
 * WordPress Plugin Development (page 2324, added 2026-11-25). The page itself is built from bwe/* widgets in the
 * editor; this file only feeds its Service schema (bwe_pb_json_ld()). Listed prices: custom development from $299,
 * plugin fixes from $20.
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
			'Custom WordPress plugin development' => 299,
			'WordPress plugin fixes' => 20,
		),
	),
);
