<?php
/**
 * Shopify App Development (page 2326, added 2026-11-25). The page itself is built from bwe/* widgets in the
 * editor; this file only feeds its Service schema (bwe_pb_json_ld()). Custom apps are quoted per project, so the
 * only listed price is the existing $30 app setup price.
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
			'Shopify app setup and integration' => 30,
		),
	),
);
