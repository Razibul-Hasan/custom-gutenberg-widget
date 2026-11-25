<?php
/**
 * "Best web expert" landing page and guides: bundled images, Rank Math FAQ blocks, schema and styles.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;



/**
 * Loads the extra styles on the home page and on posts that carry a Rank Math FAQ or table of contents.
 */
function bwe_bwe_enqueue_assets() {
	if ( ! is_singular() ) {
		return;
	}

	$content = bwe_post_content_expanded( get_queried_object_id() );
	if ( ! is_front_page() && false === strpos( $content, 'rank-math' ) ) {
		return;
	}

	wp_enqueue_style(
		'bwe-seo',
		plugins_url( 'assets/seo.css', BWE_HOME_DIR . '/site.php' ),
		array( 'bwe-home' ),
		(string) filemtime( BWE_HOME_DIR . '/assets/seo.css' )
	);
}
add_action( 'enqueue_block_assets', 'bwe_bwe_enqueue_assets', 20 );

/**
 * Builds FAQPage schema from the home page's FAQ accordion (core Details blocks), which Rank Math doesn't read.
 *
 * @param string $content Post content.
 * @return array Schema node, or an empty array when there are no questions.
 */
function bwe_bwe_details_faq( $content ) {
	// bwe-faq__item = old Gutenberg Home; bwex-faq__item = the Gutenberg copy of the Elementor Home (2026-11-13).
	preg_match_all( '#<details class="wp-block-details bwex?-faq__item[^"]*"[^>]*><summary>(.*?)</summary>(.*?)</details>#s', $content, $found, PREG_SET_ORDER );

	$questions = array();
	foreach ( $found as $item ) {
		if ( preg_match( '#<span class="bwex-faq__q">(.*?)</span>#s', $item[1], $q ) ) {
			$item[1] = $q[1]; // Skip the "01" number and icon spans.
		}
		$questions[] = array(
			'@type'          => 'Question',
			'name'           => trim( html_entity_decode( wp_strip_all_tags( $item[1] ), ENT_QUOTES, 'UTF-8' ) ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => trim( wp_strip_all_tags( $item[2] ) ),
			),
		);
	}

	if ( ! $questions ) {
		return array();
	}

	return array(
		'@type'      => 'FAQPage',
		'@id'        => home_url( '/#faq' ),
		'mainEntity' => $questions,
	);
}

/**
 * Adds Service and FAQPage schema to the home page, which targets the "best web expert" search.
 *
 * @param array $data JSON-LD graph Rank Math prints.
 * @return array
 */
function bwe_bwe_json_ld( $data ) {
	if ( ! is_front_page() ) {
		return $data;
	}

	$faq = bwe_bwe_details_faq( bwe_post_content_expanded( get_queried_object_id() ) );
	if ( $faq ) {
		$data['bweFaq'] = $faq;
	}

	$data['bweService'] = array(
		'@type'           => 'Service',
		'@id'             => home_url( '/#service' ),
		'name'            => 'WordPress and Shopify web design and development',
		'serviceType'     => 'Web design and development',
		'description'     => 'Fast, SEO-optimized WordPress websites and high-converting Shopify stores from BestWebExpert, with a fixed price in writing.',
		'url'             => home_url( '/' ),
		'areaServed'      => 'Worldwide',
		'provider'        => array(
			'@type'         => 'ProfessionalService',
			'name'          => 'BestWebExpert',
			'alternateName' => 'Best Web Expert',
			'url'           => home_url( '/' ),
		),
		'hasOfferCatalog' => array(
			'@type'           => 'OfferCatalog',
			'name'            => 'Web development services',
			'itemListElement' => array(
				array(
					'@type'       => 'Offer',
					'itemOffered' => array(
						'@type' => 'Service',
						'name'  => 'WordPress website development',
					),
					'priceSpecification' => array(
						'@type'         => 'PriceSpecification',
						'minPrice'      => 250,
						'priceCurrency' => 'USD',
					),
				),
				array(
					'@type'       => 'Offer',
					'itemOffered' => array(
						'@type' => 'Service',
						'name'  => 'Shopify store development',
					),
					'priceSpecification' => array(
						'@type'         => 'PriceSpecification',
						'minPrice'      => 250,
						'priceCurrency' => 'USD',
					),
				),
				array(
					'@type'       => 'Offer',
					'itemOffered' => array(
						'@type' => 'Service',
						'name'  => 'WooCommerce store development',
					),
					'priceSpecification' => array(
						'@type'         => 'PriceSpecification',
						'minPrice'      => 400,
						'priceCurrency' => 'USD',
					),
				),
			),
		),
	);

	return $data;
}
add_filter( 'rank_math/json_ld', 'bwe_bwe_json_ld', 98 );





