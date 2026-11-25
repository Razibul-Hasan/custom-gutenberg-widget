<?php
/**
 * Settings-tab options do what their labels say on the live page (hero animation/buttons/scroll cue, services
 * bottom line, section-head layout, step reveal, service-tile icon + colours).
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * Hero settings JSON printed for the front script.
 *
 * @param array $attrs Hero attributes.
 */
function bwe_tb_hero_settings( array $attrs ): array {
	$html = bwe_tb_render_raw( serialize_blocks( array( bwe_tb_leaf_block( 'bwe/hero', $attrs + array( 'title' => 'T', 'btn1Text' => 'A', 'btn2Text' => 'B' ) ) ) ) );
	preg_match( '/data-bwex-hero="([^"]*)"/', $html, $m );
	return array( (array) json_decode( html_entity_decode( $m[1] ?? '' ), true ), $html );
}

function test_hero_animation_settings() {
	[ $on ] = bwe_tb_hero_settings( array() );
	bwe_tb_assert_true( true === $on['on'] && 1 == $on['speed'] && 0 == $on['delay'], 'defaults: animated, speed 1, no delay' );
	[ $off ] = bwe_tb_hero_settings( array( 'animate' => false ) );
	bwe_tb_assert_true( false === $off['on'], 'Animate off → on:false' );
	[ $s ] = bwe_tb_hero_settings( array( 'animSpeed' => 1.5, 'animDelay' => 1.2 ) );
	bwe_tb_assert_true( 1.5 == $s['speed'] && 1.2 == $s['delay'], 'speed and delay reach the script' );
	$fx = file_get_contents( WP_PLUGIN_DIR . '/bestwebexpert-home/assets/home-2/js/bwex-fx.js' );
	bwe_tb_assert_true( false === strpos( $fx, 'Math.min( o.delay || 0, 0.2 )' ) && false !== strpos( $fx, 'Math.min( o.delay || 0, 2 )' ), 'hero script honours delays up to the 2 s the control offers' );
}

function test_hero_buttons_and_scroll_cue() {
	[ , $both ] = bwe_tb_hero_settings( array( 'showBtn2' => true, 'showScroll' => true, 'scrollText' => 'Scroll' ) );
	bwe_tb_assert_true( false !== strpos( $both, 'bwex-hero__btn2' ) && false !== strpos( $both, 'bwex-scroll' ), 'second button + scroll cue shown' );
	[ , $none ] = bwe_tb_hero_settings( array( 'showBtn2' => false, 'showScroll' => false ) );
	bwe_tb_assert_true( false === strpos( $none, 'bwex-hero__btn2' ) && false === strpos( $none, 'bwex-scroll' ), 'second button + scroll cue hidden' );
}

function test_services_bottom_line_toggle() {
	$tile = bwe_tb_leaf_block( 'bwe/service-tile', array( 'name' => 'N' ) );
	$on   = bwe_tb_render_raw( serialize_blocks( array( bwe_tb_block_with_children( 'bwe/services', array( 'title' => 'T', 'more' => 'More here', 'showMore' => true ), array( $tile ) ) ) ) );
	$off  = bwe_tb_render_raw( serialize_blocks( array( bwe_tb_block_with_children( 'bwe/services', array( 'title' => 'T', 'more' => 'More here', 'showMore' => false ), array( $tile ) ) ) ) );
	bwe_tb_assert_true( false !== strpos( $on, 'bwex-more' ) && false === strpos( $off, 'bwex-more' ), 'Show bottom line toggles .bwex-more' );
}

function test_section_head_split_and_step_reveal() {
	$split = bwe_tb_render_raw( serialize_blocks( array( bwe_tb_leaf_block( 'bwe/section-head', array( 'title' => 'T', 'split' => true ) ) ) ) );
	$stack = bwe_tb_render_raw( serialize_blocks( array( bwe_tb_leaf_block( 'bwe/section-head', array( 'title' => 'T', 'split' => false ) ) ) ) );
	bwe_tb_assert_true( false !== strpos( $split, 'bwex-head--split' ) && false === strpos( $stack, 'bwex-head--split' ), 'section head side-by-side toggle' );
	$reveal = bwe_tb_render_raw( serialize_blocks( array( bwe_tb_leaf_block( 'bwe/step', array( 'reveal' => false ) ) ) ) );
	bwe_tb_assert_true( false === strpos( $reveal, 'bwex-reveal' ), 'step reveal off' );
}

function test_service_tile_icon_and_platform() {
	$html = bwe_tb_render_raw( serialize_blocks( array( bwe_tb_leaf_block( 'bwe/service-tile', array( 'icon' => 'speed', 'platform' => 'shopify' ) ) ) ) );
	bwe_tb_assert_true( false !== strpos( $html, 'bwex-svc__item--speed' ) && false !== strpos( $html, 'bwex-svc__tile--shopify' ), 'site icon + platform colours classes' );
}

function test_style_maps_have_no_dead_selectors_listed() {
	// Settings the audit found had nothing to act on were removed; keep them out.
	$services = json_decode( (string) file_get_contents( dirname( __DIR__, 2 ) . '/build/blocks/services/block.json' ), true );
	bwe_tb_assert_true( ! in_array( 'hideGlow', array_column( $services['bweStyleMap'], 'key' ), true ), 'services: no "Hide the lime glow" (the band has no glow)' );
}
