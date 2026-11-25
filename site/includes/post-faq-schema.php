<?php
/**
 * FAQPage schema for blog posts that use the Rank Math FAQ block.
 *
 * Rank Math adds FAQPage schema for posts edited in the block editor. Posts created from code
 * (the cost guides) do not get it, so this builds it from the block's own question data. It does
 * nothing when Rank Math already printed FAQPage.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * Adds FAQPage to the WebPage node of a single post.
 *
 * @param array $data JSON-LD graph Rank Math prints.
 * @return array
 */
function bwe_post_faq_schema( $data ) {
	if ( ! is_singular( 'post' ) || ! isset( $data['WebPage'] ) || false !== strpos( wp_json_encode( $data['WebPage'] ), 'FAQPage' ) ) {
		return $data;
	}

	$questions = array();
	foreach ( parse_blocks( bwe_post_content_expanded( get_queried_object_id() ) ) as $block ) {
		if ( 'rank-math/faq-block' !== $block['blockName'] || empty( $block['attrs']['questions'] ) ) {
			continue;
		}
		foreach ( $block['attrs']['questions'] as $q ) {
			if ( empty( $q['title'] ) || empty( $q['content'] ) || ( isset( $q['visible'] ) && ! $q['visible'] ) ) {
				continue;
			}
			$questions[] = array(
				'@type'          => 'Question',
				'name'           => wp_strip_all_tags( $q['title'] ),
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_kses_post( $q['content'] ),
				),
			);
		}
	}

	if ( $questions ) {
		$data['WebPage']['@type']      = array( 'WebPage', 'FAQPage' );
		$data['WebPage']['mainEntity'] = $questions;
	}

	return $data;
}
add_filter( 'rank_math/json_ld', 'bwe_post_faq_schema', 99 );
