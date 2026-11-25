<?php
/**
 * Selected work (bwe/work + bwe/work-item, 2026-11-23), the Portfolio page's project list:
 * - the converted pattern renders exactly like the original;
 * - the converter keeps every project, link, screenshot and the heading ID;
 * - fresh blocks render cleanly; empty parts are left out; style settings produce their CSS.
 *
 * @package BWE_Gutenberg_Widget
 */

require_once dirname( __DIR__ ) . '/converters/work.php';

/**
 * Converts Selected work at any depth of a block document (as convert.php does).
 *
 * @param string $markup Serialized blocks.
 * @return array{0: string, 1: int} [ new markup, converted count ]
 */
function bwe_tb_work_convert_doc( string $markup ): array {
	$count = 0;
	$walk  = static function ( array $blocks ) use ( &$walk, &$count ): array {
		foreach ( $blocks as $i => $block ) {
			if ( empty( $block['blockName'] ) ) {
				continue;
			}
			$new = bwe_tb_convert_work( $block );
			if ( is_array( $new ) ) {
				$blocks[ $i ] = $new;
				++$count;
			} elseif ( null === $new && $block['innerBlocks'] ) {
				$blocks[ $i ]['innerBlocks'] = $walk( $block['innerBlocks'] );
			}
		}
		return $blocks;
	};
	return array( serialize_blocks( $walk( parse_blocks( $markup ) ) ), $count );
}

function test_work_renders_like_the_original() {
	$old             = file_get_contents( __DIR__ . '/fixtures/old-work.html' );
	[ $new, $count ] = bwe_tb_work_convert_doc( $old );
	bwe_tb_assert_true( 1 === $count && false !== strpos( $new, '<!-- wp:bwe/work ' ), 'pattern → bwe/work' );
	bwe_tb_assert_same( bwe_tb_expected( 'work', $old ), bwe_tb_render( $new ), 'Selected work renders identically' );
}

function test_work_converter_keeps_items() {
	[ $new ] = bwe_tb_work_convert_doc( file_get_contents( __DIR__ . '/fixtures/old-work.html' ) );
	$work    = null;
	$find    = static function ( array $blocks ) use ( &$find, &$work ) {
		foreach ( $blocks as $b ) {
			if ( 'bwe/work' === $b['blockName'] ) {
				$work = $b;
				return;
			}
			$find( $b['innerBlocks'] );
		}
	};
	$find( parse_blocks( $new ) );
	bwe_tb_assert_true( null !== $work, 'bwe/work found inside the page wrappers' );
	bwe_tb_assert_same( 'work|selected-work', ( $work['attrs']['sectionId'] ?? '' ) . '|' . ( $work['attrs']['headingId'] ?? '' ), 'section and heading IDs kept' );
	bwe_tb_assert_same( '10', (string) count( $work['innerBlocks'] ), 'all 10 projects' );
	$first = $work['innerBlocks'][0]['attrs'];
	bwe_tb_assert_same( '01|BestWebExpert|Website|1851|http://bestwebexpert.local/', implode( '|', array( $first['num'], $first['title'], $first['tag'], $first['imageId'], $first['url'] ) ), 'first project: number, title, tag, screenshot, link' );
	bwe_tb_assert_same( '10', (string) $work['innerBlocks'][9]['attrs']['num'], 'last project number' );
}

function test_work_fresh_blocks_render_cleanly() {
	$problems = array();
	set_error_handler(
		static function ( $no, $msg, $file, $line ) use ( &$problems ) {
			$problems[] = "$msg ($file:$line)";
			return true;
		}
	);
	try {
		$html = bwe_tb_render( '<!-- wp:bwe/work --><!-- wp:bwe/work-item {"num":"01","title":"A","url":"/a/","imageUrl":"https://example.com/a.png","tag":"T","text":"X"} /--><!-- wp:bwe/work-item {"title":"B"} /--><!-- /wp:bwe/work -->' );
	} finally {
		restore_error_handler();
	}
	bwe_tb_assert_same( '', implode( ' | ', $problems ), 'fresh section: no PHP warnings' );
	bwe_tb_assert_true( false !== strpos( $html, '<section id="work" class="wp-block-group bwex-section bwex-work">' ) && false !== strpos( $html, 'bwex-work__grid' ), 'fresh section prints its section and list' );
	bwe_tb_assert_true( false !== strpos( $html, '<figure class="wp-block-image size-full bwex-work__shot"><a href="/a/"><img src="https://example.com/a.png" alt=""/></a></figure>' ), 'screenshot linked, no wp-image class without a media ID' );
	bwe_tb_assert_true( false !== strpos( $html, '<div class="wp-block-group bwex-work__meta"><h3 class="wp-block-heading bwex-work__title">B</h3></div>' ), 'project without link, number, tag or text: title only' );
	bwe_tb_assert_true( false === strpos( $html, '<h2 id=' ), 'no heading ID unless set' );
}

function test_work_styles_and_new_tab() {
	$html = bwe_tb_render( '<!-- wp:bwe/work {"bweStyle":{"workTitleColor":"#ff0000","noFade":true,"hideNum":true}} --><!-- wp:bwe/work-item {"title":"A","url":"/a/","newTab":true} /--><!-- /wp:bwe/work -->' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwex-work__title{color:#ff0000!important}' ), 'project title colour' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwex-work__grid:hover .bwex-work__item{opacity:1!important}' ), 'rows don\'t fade' );
	bwe_tb_assert_true( false !== strpos( $html, ' .bwex-work__num{display:none!important}' ), 'numbers hidden' );
	bwe_tb_assert_true( false !== strpos( $html, '<a href="/a/" target="_blank" rel="noreferrer noopener">A</a>' ), 'link opens in a new tab' );
}

function test_work_registered_with_starters() {
	$registry = WP_Block_Type_Registry::get_instance();
	foreach ( array( 'bwe/work', 'bwe/work-item' ) as $name ) {
		$type = $registry->get_registered( $name );
		bwe_tb_assert_true( $type && is_callable( $type->render_callback ), "$name is registered" );
		$starter = $type ? ( $type->variations[0] ?? array() ) : array();
		bwe_tb_assert_true( ! empty( $starter['isDefault'] ), "$name has a starter" );
	}
}
