<?php
/**
 * "Best WordPress expert" and "Best Shopify expert" landing pages: Service and FAQPage schema.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * Schema details for each landing page, keyed by the classes on its pattern wrapper (the bare marker would
 * also match the shared bwe-wpx-* component classes).
 *
 * 'prices' are the starting prices on the page's price list, in USD, keyed by service name.
 *
 * @return array<string, array{name: string, type: string, description: string, catalog: string, prices: array<string, int>}>
 */
function bwe_wpx_pages() {
	return array(
		'bwe-services bwe-wpx' => array(
			'name'        => 'Best WordPress expert: support, customization, development, speed optimization and migration',
			'type'        => 'WordPress development and support',
			'description' => 'Affordable WordPress expert services from BestWebExpert: support and bug fixes, customization, website and WooCommerce development, speed optimization, migration, malware removal and maintenance, with fixed prices.',
			'catalog'     => 'WordPress expert services',
			'prices'      => array(
				'WordPress support and bug fixes'        => 25,
				'WordPress customization'                => 49,
				'WordPress malware removal and security' => 59,
				'WordPress migration'                    => 69,
				'WordPress speed optimization'           => 79,
				'WordPress SEO setup'                    => 99,
				'WordPress maintenance plan (monthly)'   => 39,
				'WordPress website development'          => 499,
				'WooCommerce store development'          => 799,
			),
		),
		'bwe-services bwe-spx' => array(
			'name'        => 'Best Shopify expert: store setup, theme customization, support, speed optimization and migration',
			'type'        => 'Shopify development and support',
			'description' => 'Affordable Shopify expert services from BestWebExpert: store setup and design, theme customization, custom Liquid sections, support and bug fixes, speed optimization, migration to Shopify, app setup and Shopify SEO, with fixed prices.',
			'catalog'     => 'Shopify expert services',
			'prices'      => array(
				'Shopify support and bug fixes'      => 25,
				'Shopify app setup and integration'  => 39,
				'Shopify theme customization'        => 49,
				'Custom Shopify Liquid sections'     => 59,
				'Shopify speed optimization'         => 79,
				'Shopify SEO setup'                  => 99,
				'Migration to Shopify'               => 149,
				'Monthly Shopify support'            => 49,
				'Shopify store setup and design'     => 699,
			),
		),
	);
}

/**
 * Builds a Service schema node with an offer catalog of starting prices.
 *
 * @param string $url  Page URL.
 * @param array  $page name, type, description, catalog and prices (service name => starting price in USD).
 * @return array
 */
function bwe_wpx_service_node( $url, $page ) {
	$offers = array();
	foreach ( $page['prices'] as $name => $price ) {
		$offers[] = array(
			'@type'              => 'Offer',
			'itemOffered'        => array(
				'@type' => 'Service',
				'name'  => $name,
			),
			'priceSpecification' => array(
				'@type'         => 'PriceSpecification',
				'minPrice'      => $price,
				'priceCurrency' => 'USD',
			),
		);
	}

	return array(
		'@type'           => 'Service',
		'@id'             => $url . '#service',
		'name'            => $page['name'],
		'serviceType'     => $page['type'],
		'description'     => $page['description'],
		'url'             => $url,
		'areaServed'      => 'Worldwide',
		'provider'        => array(
			'@type'         => 'ProfessionalService',
			'name'          => 'BestWebExpert',
			'alternateName' => 'Best Web Expert',
			'url'           => home_url( '/' ),
		),
		'hasOfferCatalog' => array(
			'@type'           => 'OfferCatalog',
			'name'            => $page['catalog'],
			'itemListElement' => $offers,
		),
	);
}

/**
 * Adds Service and FAQPage schema to pages built from the "Best WordPress Expert" or "Best Shopify Expert" pattern.
 *
 * @param array $data JSON-LD graph Rank Math prints.
 * @return array
 */
function bwe_wpx_json_ld( $data ) {
	foreach ( bwe_wpx_pages() as $marker => $page ) {
		// Pages rebuilt from Home's sections (2026-11-21) carry "<last marker class>-schema", e.g. bwe-wpx-schema.
		$schema_marker = substr( (string) strrchr( ' ' . $marker, ' ' ), 1 ) . '-schema';
		if ( bwe_home_is_needed( $marker ) || bwe_home_is_needed( $schema_marker ) ) {
			break;
		}
		$page = null;
	}

	if ( ! $page ) {
		return $data;
	}

	$url = get_permalink( get_queried_object_id() );

	$faq = bwe_bwe_details_faq( bwe_post_content_expanded( get_queried_object_id() ) );
	if ( $faq ) {
		$faq['@id']     = $url . '#faq';
		$data['bweFaq'] = $faq;
	}

	$data['bweWpxService'] = bwe_wpx_service_node( $url, $page );

	return $data;
}
add_filter( 'rank_math/json_ld', 'bwe_wpx_json_ld', 98 );
