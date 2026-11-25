<?php
/**
 * Shared helpers for the block-migration tools and tests (CLI only).
 *
 * @package BWE_Gutenberg_Widget
 */

if ( PHP_SAPI !== 'cli' ) {
	exit;
}

/** The 31 pages whose live HTML must never change (Home + every page built from synced patterns). */
const BWE_TB_PAGES = array( 1104, 512, 513, 514, 519, 521, 544, 547, 754, 761, 762, 763, 822, 826, 830, 831, 832, 833, 834, 835, 836, 837, 838, 839, 840, 841, 842, 843, 844, 941, 1115 );

/**
 * Local's MySQL port. Local picks a new one when the site restarts (it was 10011, then 10009), so it is read
 * from the site's my.cnf (conf/mysql/my.cnf next to the conf/php/php.ini this CLI runs with). BWE_DB_PORT overrides.
 */
function bwe_tb_db_port(): int {
	$env = (int) getenv( 'BWE_DB_PORT' );
	if ( $env > 0 ) {
		return $env;
	}
	$ini = (string) php_ini_loaded_file();
	$cnf = '' !== $ini ? dirname( $ini, 2 ) . '/mysql/my.cnf' : '';
	if ( '' !== $cnf && is_readable( $cnf ) && preg_match( '/^\s*port\s*=\s*(\d+)/m', (string) file_get_contents( $cnf ), $m ) ) {
		return (int) $m[1];
	}
	return 10011;
}

/**
 * Loads WordPress from the CLI on Local's MySQL port (bwe_tb_db_port()).
 *
 * @param string $wp_root WordPress root.
 */
function bwe_tb_boot( string $wp_root ): void {
	ini_set( 'mysqli.default_port', (string) bwe_tb_db_port() ); // phpcs:ignore WordPress.PHP.IniSet.Risky
	if ( ! defined( 'ABSPATH' ) ) {
		require rtrim( $wp_root, '/\\' ) . '/wp-load.php';
	}
}

/**
 * Whitespace-insensitive form of an HTML string: no whitespace between tags, single spaces elsewhere.
 *
 * @param string $html HTML.
 */
function bwe_tb_normalize( string $html ): string {
	$html = preg_replace( '/>\s+</', '><', $html );
	return trim( preg_replace( '/\s+/', ' ', $html ) );
}

/**
 * Renders block markup exactly as the front end does.
 *
 * @param string $block_markup Serialized blocks.
 */
function bwe_tb_render_raw( string $block_markup ): string {
	// Render like a live bwe-h2x page: there bwe_h2x_strip_layout() (BestWebExpert Home, home-2.php) drops the group
	// layout classes at priority 20; in the CLI it is off (no page is queried), which changed what later filters saw.
	$strip = static fn( $html ) => str_replace( ' is-layout-flow wp-block-group-is-layout-flow', '', $html );
	add_filter( 'render_block_core/group', $strip, 20 );
	$html = do_blocks( $block_markup );
	remove_filter( 'render_block_core/group', $strip, 20 );
	return $html;
}

/**
 * Renders block markup and normalizes it.
 *
 * @param string $block_markup Serialized blocks.
 */
function bwe_tb_render( string $block_markup ): string {
	return bwe_tb_normalize( bwe_tb_render_raw( $block_markup ) );
}

/**
 * Expected live HTML for a parity test: the render of the OLD markup, frozen in tests/fixtures/render-<name>.html the
 * first time it runs (the old shapes' render filters were removed once all content was converted, Task 8).
 *
 * @param string $name       Fixture name.
 * @param string $old_markup Old-shape block markup.
 */
function bwe_tb_expected( string $name, string $old_markup ): string {
	$file = __DIR__ . '/tests/fixtures/render-' . sanitize_file_name( $name ) . '.html';
	if ( ! is_file( $file ) ) {
		file_put_contents( $file, bwe_tb_render( $old_markup ) );
	}
	return file_get_contents( $file );
}

$GLOBALS['bwe_tb_results'] = array( 'pass' => 0, 'fail' => 0 );

/**
 * Records one assertion.
 *
 * @param string $expected Expected value.
 * @param string $actual   Actual value.
 * @param string $label    What is being compared.
 */
function bwe_tb_assert_same( string $expected, string $actual, string $label ): void {
	if ( $expected === $actual ) {
		++$GLOBALS['bwe_tb_results']['pass'];
		echo "  ok   $label\n";
		return;
	}
	++$GLOBALS['bwe_tb_results']['fail'];
	$len = min( strlen( $expected ), strlen( $actual ) );
	$at  = 0;
	while ( $at < $len && $expected[ $at ] === $actual[ $at ] ) {
		++$at;
	}
	$from = max( 0, $at - 40 );
	echo "  FAIL $label (first difference at byte $at)\n";
	echo '    expected: …' . substr( $expected, $from, 200 ) . "\n";
	echo '    actual:   …' . substr( $actual, $from, 200 ) . "\n";
}

/**
 * Records a boolean assertion.
 *
 * @param bool   $condition Condition.
 * @param string $label     What is checked.
 */
function bwe_tb_assert_true( bool $condition, string $label ): void {
	bwe_tb_assert_same( 'true', $condition ? 'true' : 'false', $label );
}

/**
 * Builds a parsed-block array for a block whose saved content is only its inner blocks (InnerBlocks.Content),
 * laid out the way the editor serializes it: "\n" + child + "\n\n" + child … + "\n".
 *
 * @param string $name     Block name.
 * @param array  $attrs    Attributes.
 * @param array  $children Parsed inner blocks.
 */
function bwe_tb_block_with_children( string $name, array $attrs, array $children ): array {
	$content = array( "\n" );
	foreach ( array_values( $children ) as $i => $child ) {
		if ( $i ) {
			$content[] = "\n\n";
		}
		$content[] = null;
	}
	$content[] = "\n";
	return array(
		'blockName'    => $name,
		'attrs'        => $attrs,
		'innerBlocks'  => array_values( $children ),
		'innerHTML'    => implode( '', array_filter( $content, 'is_string' ) ),
		'innerContent' => $content,
	);
}

/**
 * Builds a parsed-block array for a self-closing block (no inner blocks, no saved HTML).
 *
 * @param string $name  Block name.
 * @param array  $attrs Attributes.
 */
function bwe_tb_leaf_block( string $name, array $attrs ): array {
	return array(
		'blockName'    => $name,
		'attrs'        => $attrs,
		'innerBlocks'  => array(),
		'innerHTML'    => '',
		'innerContent' => array(),
	);
}

/**
 * Whether two serialized block documents parse to the same block tree (names, attributes, inner HTML).
 *
 * @param string $a Serialized blocks.
 * @param string $b Serialized blocks.
 */
function bwe_tb_same_tree( string $a, string $b ): bool {
	return parse_blocks( $a ) == parse_blocks( $b ); // phpcs:ignore Universal.Operators.StrictComparisons -- deep array equality.
}

/**
 * Whether content can be parsed and re-serialized without changing its block tree.
 *
 * @param string $content Serialized blocks.
 */
function bwe_tb_roundtrip_safe( string $content ): bool {
	return bwe_tb_same_tree( $content, serialize_blocks( parse_blocks( $content ) ) );
}

/**
 * The parts of a live page's <head> that content changes can affect: meta tags (Rank Math description, time to
 * read, og:image …), JSON-LD (FAQPage schema) and the ids of the stylesheets/scripts that are loaded.
 *
 * @param string $html Full page HTML.
 */
function bwe_tb_head_fingerprint( string $html ): string {
	if ( ! preg_match( '#<head[^>]*>(.*?)</head>#s', $html, $m ) ) {
		return '';
	}
	$head = $m[1];
	preg_match_all( '#<meta\s[^>]*>#', $head, $meta );
	preg_match_all( '#<script type="application/ld\+json"[^>]*>.*?</script>#s', $head, $ld );
	preg_match_all( '#<(?:link|script|style)\b[^>]*\bid=["\']([^"\']+)["\']#', $head, $ids );
	$out = implode( "\n", $meta[0] ) . "\n" . implode( "\n", $ld[0] ) . "\nIDS: " . implode( ' ', $ids[1] );
	$out = preg_replace( '/([?&](?:ver|bwe_snap)=)[^"\'&\s]*/', '$1X', $out );
	$out = preg_replace( '/(nonce["\']?\s*[:=]\s*["\']?)[a-f0-9]{8,}/i', '$1X', $out );
	return preg_replace( '/"(datePublished|dateModified|uploadDate)":"[^"]*"|article:modified_time" content="[^"]*"|og:updated_time" content="[^"]*"/', '"$1":"X"', $out );
}

/**
 * Normalized body of a live page: ld+json kept, every other script and version/nonce noise removed.
 *
 * @param string $html Full page HTML.
 */
function bwe_tb_page_fingerprint( string $html ): string {
	if ( preg_match( '#<body[^>]*>(.*)</body>#s', $html, $m ) ) {
		$html = $m[1];
	}
	$html = preg_replace_callback(
		'#<script\b([^>]*)>(.*?)</script>#s',
		static fn( $s ) => false !== strpos( $s[1], 'application/ld+json' ) ? $s[0] : '',
		$html
	);
	$html = preg_replace( '/([?&](?:ver|bwe_snap)=)[^"\'&\s]*/', '$1X', $html );
	$html = preg_replace( '/(nonce["\']?\s*[:=]\s*["\']?)[a-f0-9]{8,}/i', '$1X', $html );
	$html = preg_replace( '/gt-wrapper-\d+/', 'gt-wrapper-X', $html ); // GTranslate: random id per request.
	return bwe_tb_normalize( $html );
}

/**
 * Rendered HTML without the Testimonials slider additions (classes, widths, dots / arrows), which the hand-written
 * originals in the fixtures never had. Product / plain markup is left alone.
 *
 * @param string $html Rendered HTML.
 */
function bwe_tb_without_slider( string $html ): string {
	$html = (string) preg_replace( '#(bwex-quotes) bwe-ms bwe-ms--[^"]*" style="--bwe-ms-[^"]*"#', '$1"', $html );
	return (string) preg_replace( '#<div class="bwe-ms__nav[ "].*?</div>(?:<div class="bwe-ms__arrows">.*?</div>)?</div>#s', '', $html );
}
