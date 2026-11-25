<?php
/**
 * Moves a page's wrapper groups (band per section, or one page-wide wrapper) into its "Page layout" setting
 * (includes/page-layout.php): the groups are removed, the setting prints the same markup. Kept only when the page
 * renders exactly as before (ignoring bwe-scope--* editor markers and the bwe-rd / bwe-cta-shared band markers,
 * which no stylesheet or script reads; they are now on every hero / CTA band).
 * Usage: php page-layout-migrate.php <wp-root> <id,id,…> [--dry-run]
 * Backups: app/backups/no-classes-2026-11-25/post-<id>.html (the page before the no-classes pass), never overwritten.
 *
 * @package BWE_Gutenberg_Widget
 */

require __DIR__ . '/lib.php';
$wp_root = $argv[1] ?? '';
$ids     = array_filter( array_map( 'intval', explode( ',', $argv[2] ?? '' ) ) );
$dry     = in_array( '--dry-run', $argv, true );
bwe_tb_boot( $wp_root );
wp_set_current_user( 1 );

/**
 * Classes of a parsed block.
 *
 * @param array|null $b Parsed block.
 */
function bwe_tb_pl_cls( ?array $b ): string {
	return trim( preg_replace( '/\s+/', ' ', preg_replace( '/\bbwe-scope--[a-z0-9-]+/', '', (string) ( $b['attrs']['className'] ?? '' ) ) ) );
}

/**
 * Non-empty child blocks.
 *
 * @param array $b Parsed block.
 */
function bwe_tb_pl_kids( array $b ): array {
	return array_values( array_filter( $b['innerBlocks'], static fn( $k ) => ! empty( $k['blockName'] ) ) );
}

/**
 * The only child of a group with exactly these classes (and align full when asked), or null.
 *
 * @param array  $b     Parsed block.
 * @param string $cls   Classes.
 * @param bool   $full  Must be align full.
 */
function bwe_tb_pl_only( array $b, string $cls, bool $full = false ): ?array {
	$kids = bwe_tb_pl_kids( $b );
	if ( 'core/group' !== $b['blockName'] || bwe_tb_pl_cls( $b ) !== $cls || 1 !== count( $kids ) || ( $full && 'full' !== ( $b['attrs']['align'] ?? '' ) ) ) {
		return null;
	}
	$other = array_diff_key( $b['attrs'], array( 'className' => 1, 'align' => 1, 'metadata' => 1 ) );
	return $other ? null : $kids[0];
}

/**
 * [ layout, schema, new top-level blocks ] for a page, or null when its shape is not known.
 *
 * @param array $top Top-level parsed blocks (no empty ones).
 */
function bwe_tb_pl_plan( array $top ): ?array {
	$layouts = bwe_gw_page_layouts();
	// One page-wide wrapper.
	foreach ( $layouts as $key => $l ) {
		if ( ! empty( $l['bands'] ) ) {
			continue;
		}
		$lead = array();
		$rest = $top;
		if ( 'own' === $l['hero'] && 'bwe/hero' === ( $rest[0]['blockName'] ?? '' ) ) {
			$lead = array( array_shift( $rest ) );
		}
		if ( 1 !== count( $rest ) || 'core/group' !== $rest[0]['blockName'] || bwe_tb_pl_cls( $rest[0] ) !== $l['outer'] || 'full' !== ( $rest[0]['attrs']['align'] ?? '' ) ) {
			continue;
		}
		$kids = bwe_tb_pl_kids( $rest[0] );
		if ( '' !== $l['inner'] ) {
			if ( 1 !== count( $kids ) || bwe_tb_pl_cls( $kids[0] ) !== $l['inner'] ) {
				return null;
			}
			$kids = bwe_tb_pl_kids( $kids[0] );
		}
		$out = $lead;
		foreach ( $kids as $k ) {
			$hero = 'scope' === $l['hero'] ? bwe_tb_pl_only( $k, 'bwe-home bwex bwex-hero-scope' ) : null;
			$out[] = ( $hero && 'bwe/hero' === $hero['blockName'] ) ? $hero : $k;
		}
		return array( $key, '', $out );
	}
	// A band per section.
	$out    = array();
	$schema = '';
	foreach ( $top as $b ) {
		$cls = bwe_tb_pl_cls( $b );
		if ( preg_match( '/^elementor elementor-517 bwe-h2x bwe-page-hero(?: bwe-rd)?(?: (bwe-[a-z]+-schema))?$/', $cls, $m ) ) {
			$inner = bwe_tb_pl_only( $b, $cls, true );
			$hero  = $inner ? bwe_tb_pl_only( $inner, 'bwe-home bwex bwex-hero-scope' ) : null;
			if ( ! $hero || 'bwe/hero' !== $hero['blockName'] ) {
				return null;
			}
			foreach ( bwe_gw_page_schemas() as $sk => $s ) {
				if ( ( $m[1] ?? '' ) === $s['marker'] ) {
					$schema = $sk;
				}
			}
			$out[] = $hero;
			continue;
		}
		if ( preg_match( '/^elementor elementor-517 bwe-h2x bwe-sec(?: bwe-cta-shared| bwe-prx)?$/', $cls ) ) {
			$inner = bwe_tb_pl_only( $b, $cls, true );
			$block = $inner ? bwe_tb_pl_only( $inner, BWE_GW_BAND_INNER ) : null;
			if ( ! $block ) {
				return null;
			}
			$out[] = $block;
			continue;
		}
		return null;
	}
	return array( 'bands', $schema, $out );
}

/**
 * Normalized render of a page's content, the way the live page prints it.
 *
 * @param string $markup  Block markup.
 * @param int    $post_id Post ID (its layout setting applies).
 * @param bool   $layout  Wrap with the page layout.
 */
function bwe_tb_pl_render( string $markup, int $post_id, bool $layout ): string {
	if ( $layout ) {
		bwe_gw_page_layout_begin( $post_id, $markup );
	}
	$html = bwe_gw_page_layout_untag( bwe_tb_render_raw( $markup ) );
	bwe_gw_page_layout_end();
	$html = preg_replace( '/\bmmbb-(box-)?\d+\b/', 'mmbb-$1N', $html );
	$html = preg_replace( '/ ?\b(bwe-scope--[a-z0-9-]+|bwe-rd|bwe-cta-shared)\b/', '', $html );
	$html = preg_replace( '/ +"/', '"', $html );
	return bwe_tb_normalize( $html );
}

$dir = dirname( ABSPATH ) . '/backups/no-classes-2026-11-25';
foreach ( $ids as $id ) {
	$post = get_post( $id );
	if ( ! $post || 'page' !== $post->post_type ) {
		echo "$id: not a page\n";
		continue;
	}
	if ( '' !== (string) get_post_meta( $id, 'bwe_page_layout', true ) ) {
		echo "$id {$post->post_title}: already has a layout\n";
		continue;
	}
	$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	setup_postdata( $post );
	$top  = array_values( array_filter( parse_blocks( $post->post_content ), static fn( $b ) => ! empty( $b['blockName'] ) ) );
	$plan = bwe_tb_pl_plan( $top );
	if ( ! $plan ) {
		echo "$id {$post->post_title}: shape not known, left as is\n";
		continue;
	}
	[ $layout, $schema, $blocks ] = $plan;
	$content  = implode( "\n\n", array_map( 'serialize_block', $blocks ) );
	$baseline = bwe_tb_pl_render( $post->post_content, $id, false );
	update_post_meta( $id, 'bwe_page_layout', $layout );
	update_post_meta( $id, 'bwe_page_schema', $schema );
	$new = bwe_tb_pl_render( $content, $id, true );
	if ( $new !== $baseline || $dry ) {
		delete_post_meta( $id, 'bwe_page_layout' );
		delete_post_meta( $id, 'bwe_page_schema' );
	}
	if ( $new !== $baseline ) {
		$k = 0;
		$n = min( strlen( $new ), strlen( $baseline ) );
		while ( $k < $n && $new[ $k ] === $baseline[ $k ] ) {
			++$k;
		}
		echo "$id {$post->post_title}: DIFFERENT @$k ($layout)\n  old: " . substr( $baseline, max( 0, $k - 120 ), 260 ) . "\n  new: " . substr( $new, max( 0, $k - 120 ), 260 ) . "\n";
		continue;
	}
	echo "$id {$post->post_title}: $layout" . ( $schema ? " + schema $schema" : '' ) . ', ' . count( $top ) . ' → ' . count( $blocks ) . ' top-level blocks' . ( $dry ? ' (dry run)' : '' ) . "\n";
	if ( $dry ) {
		continue;
	}
	if ( ! is_dir( $dir ) ) {
		mkdir( $dir, 0777, true );
	}
	if ( ! is_file( "$dir/post-$id.html" ) ) {
		file_put_contents( "$dir/post-$id.html", $post->post_content );
	}
	kses_remove_filters();
	wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $content ) ) );
	clean_post_cache( $id );
}
