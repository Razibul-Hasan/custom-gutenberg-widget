<?php
/**
 * Code that reads a page's raw content (FAQPage schema, Rank Math reading time / og:image in <head>, stylesheet
 * markers) must see the same thing it saw before the migration — the bwe/* blocks keep their text in attributes.
 * The "before" content is rebuilt from the converter backups (the first backup of a pattern is its original).
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Page content with every synced pattern inlined — before the migration (true) or now (false).
 *
 * @param int  $page_id Page ID.
 * @param bool $before  Use the pre-migration pattern content.
 */
function bwe_tb_expanded_page( int $page_id, bool $before ): string {
	if ( ! $before ) {
		return bwe_post_content_expanded( $page_id );
	}
	$dir    = dirname( ABSPATH ) . '/backups/blocks-migration-2026-11-22';
	$orig   = static function ( int $id ) use ( $dir ): string {
		foreach ( array( 'faq-item', 'spec-list', 'price-list', 'who-list', 'steps', 'section-head', 'hero', 'services', 'section', 'home-sections' ) as $conv ) {
			if ( is_file( "$dir/$conv/wp_block-$id.html" ) ) {
				return file_get_contents( "$dir/$conv/wp_block-$id.html" );
			}
		}
		return (string) get_post( $id )->post_content;
	};
	$expand = static function ( string $c, int $depth ) use ( &$expand, $orig ): string {
		return $depth > 3 ? $c : preg_replace_callback( '/<!-- wp:block \{"ref":(\d+)\} \/-->/', static fn( $m ) => $expand( $orig( (int) $m[1] ), $depth + 1 ), $c );
	};
	// Pages rebuilt with the widgets on 2026-11-24 (tools/rebuild-page.php) no longer point at patterns: start from
	// the page content saved before that rebuild.
	$page = dirname( ABSPATH ) . "/backups/full-widget-rebuild-2026-11-24/post-$page_id.html";
	return $expand( is_file( $page ) ? (string) file_get_contents( $page ) : (string) get_post( $page_id )->post_content, 0 );
}

/** Pages with FAQs built from every converted component (Home, plugin page, service page, pricing, contact). */
const BWE_TB_READER_PAGES = array( 1104, 941, 822, 839, 521, 1115, 544 );

function test_faq_schema_from_page_content_matches_premigration() {
	foreach ( BWE_TB_READER_PAGES as $id ) {
		$before = bwe_bwe_details_faq( bwe_tb_expanded_page( $id, true ) );
		bwe_tb_assert_true( ! empty( $before['mainEntity'] ), "page $id had FAQ schema before" );
		bwe_tb_assert_same( wp_json_encode( $before ), wp_json_encode( bwe_bwe_details_faq( bwe_tb_expanded_page( $id, false ) ) ), "page $id FAQPage schema" );
	}
}

function test_page_text_matches_premigration() {
	foreach ( BWE_TB_READER_PAGES as $id ) {
		$words = static fn( $c ) => (string) str_word_count( wp_strip_all_tags( $c ) );
		bwe_tb_assert_same( $words( bwe_tb_expanded_page( $id, true ) ), $words( bwe_tb_expanded_page( $id, false ) ), "page $id word count (Rank Math reading time)" );
	}
}

function test_stylesheet_markers_match_premigration() {
	$markers = array( 'bwe-blog', 'bwe-contact', 'bwe-demo', 'bwe-h2x', 'bwe-ml', 'bwe-ml-tour', 'bwe-mmbb', 'bwe-pb', 'bwe-pb-schema', 'bwe-prx', 'bwe-reels', 'bwe-services', 'bwe-spx', 'bwe-wfu', 'bwe-wpx', 'bwex-guide__toc', 'bwex-tour', 'bwex-work__grid', 'wp:contact-form-7/', 'wp:mmbb/', 'wp:productreels/', '[contact-form-7', '[mmbb_box', 'bwe-page-hero', 'bwe-rd', 'bwe-final__chat' );
	foreach ( BWE_TB_PAGES as $id ) {
		$before = bwe_tb_expanded_page( $id, true );
		$now    = bwe_tb_expanded_page( $id, false );
		$diff   = array_filter( $markers, static fn( $m ) => ( false !== strpos( $before, $m ) ) !== ( false !== strpos( $now, $m ) ) );
		bwe_tb_assert_same( '', implode( ',', $diff ), "page $id content markers" );
	}
}
