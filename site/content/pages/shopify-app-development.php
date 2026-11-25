<?php
/**
 * Shopify App Development (page 2326, added 2026-11-25). The page itself is built from bwe/* widgets in the
 * editor; this file only feeds its Service schema (bwe_pb_json_ld()). Listed prices: custom apps from $399,
 * app setup from $30.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

return array(
	'schema' => array(
		'name'        => 'Shopify app development services',
		'type'        => 'Shopify app development',
		'description' => 'Custom Shopify app development: private apps, API integrations, theme app extensions, checkout and discount logic, app setup and app fixes.',
		'catalog'     => 'Shopify app development packages',
		'prices'      => array(
			'Custom Shopify app development' => 399,
			'Shopify app setup and integration' => 30,
		),
	),
);
