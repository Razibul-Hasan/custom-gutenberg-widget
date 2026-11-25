<?php
/**
 * Pattern library (2026-11-21).
 *
 * The site's patterns are saved patterns (Appearance → Design → Patterns, category "BestWebExpert"), so they
 * can be edited there. Everything else is switched off so the inserter only shows patterns this site uses:
 * WordPress core patterns, the online Pattern Directory and WooCommerce's patterns.
 *
 * Saved patterns are created/updated by tools/home-2/create-pattern-library.php.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

// No patterns from wordpress.org's Pattern Directory.
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * No WordPress core patterns.
 */
function bwe_pl_no_core_patterns() {
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'bwe_pl_no_core_patterns', 99 );

/**
 * Unregisters every pattern that is not this site's own (core leftovers, WooCommerce, WooCommerce Blocks).
 * Runs late on init and again before the REST API answers, because some plugins register patterns lazily.
 */
function bwe_pl_unregister_foreign_patterns() {
	if ( ! class_exists( 'WP_Block_Patterns_Registry' ) ) {
		return;
	}
	$registry = WP_Block_Patterns_Registry::get_instance();
	foreach ( $registry->get_all_registered() as $pattern ) {
		if ( 0 !== strpos( $pattern['name'], 'bestwebexpert/' ) ) {
			unregister_block_pattern( $pattern['name'] );
		}
	}
}
add_action( 'init', 'bwe_pl_unregister_foreign_patterns', 999 );

/**
 * Rank Math analyses only the page's own content in the editor. Home (and the closing CTA on every page)
 * are synced patterns, so their text is added to the analysis — otherwise the score drops although the
 * published page is unchanged.
 */
function bwe_pl_rank_math_synced_content() {
	if ( ! wp_script_is( 'wp-hooks', 'registered' ) ) {
		return;
	}
	wp_add_inline_script(
		'wp-hooks',
		'(function(){if(!window.wp||!wp.hooks){return;}'
		. 'var refs=function(){var out=[];var s=wp.data&&wp.data.select("core/block-editor");if(!s){return out;}(function walk(bs){bs.forEach(function(b){if(b.name==="core/block"&&b.attributes&&b.attributes.ref){out.push(b.attributes.ref);}walk(b.innerBlocks||[]);});})(s.getBlocks());return out;};'
		. 'var nested=function(c,depth){return depth<2?c.replace(/<!-- wp:block \{"ref":(\d+)[\s\S]*?\} \/-->/g,function(m,n){return raw(+n,depth+1);}):c;};'
		. 'var raw=function(id,depth){var r=wp.data.select("core").getEntityRecord("postType","wp_block",id);if(!r||!r.content){return "";}var c=typeof r.content==="string"?r.content:(r.content.raw||"");return nested(c,depth);};'
		// Each pattern as shown on this page: its inner blocks with this page's pattern overrides (core/block "content") applied.
		. 'var withOv=function(bs,ov){return bs.map(function(b){var m=b.attributes.metadata||{};var o=m.name&&m.bindings&&m.bindings.__default&&ov[m.name];return Object.assign({},b,{attributes:o?Object.assign({},b.attributes,o):b.attributes,innerBlocks:withOv(b.innerBlocks||[],ov)});});};'
		. 'var shown=function(){var s=wp.data&&wp.data.select("core/block-editor");var out=[];if(!s){return out;}(function walk(bs){bs.forEach(function(b){if(b.name==="core/block"&&b.attributes&&b.attributes.ref){var inner=s.getBlocks(b.clientId);out.push(inner.length&&wp.blocks&&wp.blocks.serialize?nested(wp.blocks.serialize(withOv(inner,b.attributes.content||{})),0):raw(b.attributes.ref,0));}else{walk(b.innerBlocks||[]);}});})(s.getBlocks());return out;};'
		. 'wp.hooks.addFilter("rank_math_content","bestwebexpert/synced-patterns",function(content){return content+shown().join("\n");});'
		. 'var tries=0;var t=setInterval(function(){tries++;var ids=refs();var ready=ids.length&&ids.every(function(id){return wp.data.select("core").getEntityRecord("postType","wp_block",id);});if((ready||tries>20)&&window.rankMathEditor&&rankMathEditor.refresh){rankMathEditor.refresh("content");clearInterval(t);}else if(tries>40){clearInterval(t);}},1000);'
		. '})();'
	);
}
add_action( 'enqueue_block_editor_assets', 'bwe_pl_rank_math_synced_content' );
add_action( 'rest_api_init', 'bwe_pl_unregister_foreign_patterns', 999 );
add_action( 'current_screen', 'bwe_pl_unregister_foreign_patterns', 999 );

/**
 * Pages are made of synced patterns, so their post_content is mostly `<!-- wp:block {"ref":N} /-->`.
 * Rank Math builds the <head> from the raw post_content (time to read, og:image = first image in the content,
 * TOC/FAQ schema blocks), which would then miss everything. While wp_head runs, the queried post objects
 * carry the expanded content (patterns inlined, bwe_post_content_expanded()); restored right after.
 * In memory only — the object cache and the database are never touched.
 *
 * @param bool $expand True to expand, false to restore.
 */
function bwe_pl_head_content( $expand ) {
	static $saved = array();
	if ( ! $expand ) {
		foreach ( $saved as $item ) {
			$item[0]->post_content = $item[1];
		}
		$saved = array();
		remove_filter( 'post_content', 'bwe_pl_head_content_field', 10 );
		remove_filter( 'rank_math/opengraph/content_image_cache', '__return_false' );
		return;
	}
	if ( ! is_singular() || ! function_exists( 'bwe_post_content_expanded' ) ) {
		return;
	}
	$id = get_queried_object_id();
	global $wp_query, $post;
	$objects = array( get_queried_object(), $post, $wp_query->post ?? null );
	foreach ( (array) ( $wp_query->posts ?? array() ) as $p ) {
		$objects[] = $p;
	}
	$expanded = null;
	foreach ( $objects as $obj ) {
		if ( ! ( $obj instanceof WP_Post ) || (int) $obj->ID !== (int) $id || false === strpos( $obj->post_content, '<!-- wp:block ' ) ) {
			continue;
		}
		if ( null === $expanded ) {
			$expanded = bwe_post_content_expanded( $id );
		}
		$saved[]           = array( $obj, $obj->post_content );
		$obj->post_content = $expanded;
	}
	if ( null !== $expanded ) {
		// Rank Math's og:image reads a fresh get_post() through sanitize_post_field() (filter "post_content").
		// Its image cache is keyed on the raw content, which doesn't change when a pattern does: off here.
		add_filter( 'post_content', 'bwe_pl_head_content_field', 10, 2 );
		add_filter( 'rank_math/opengraph/content_image_cache', '__return_false' );
	}
}

/**
 * The queried page's post_content as shown (see bwe_pl_head_content()).
 *
 * @param string $value   Field value.
 * @param int    $post_id Post ID.
 * @return string
 */
function bwe_pl_head_content_field( $value, $post_id ) {
	if ( (int) $post_id === (int) get_queried_object_id() && false !== strpos( (string) $value, '<!-- wp:block ' ) ) {
		return bwe_post_content_expanded( $post_id );
	}
	return $value;
}
add_action( 'wp_head', fn() => bwe_pl_head_content( true ), -1000 );
add_action( 'wp_head', fn() => bwe_pl_head_content( false ), PHP_INT_MAX );
