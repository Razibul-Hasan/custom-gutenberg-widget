<?php
/**
 * One price plan card: optional badge, name, price (italic = the small "/ project" part), short text, the feature
 * list (a normal List block inside) and a button.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered feature list.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );
$bwe_featured              = ! empty( $attributes['featured'] );
$bwe_badge                 = $bwe_featured ? bwe_gw_attr( $attributes, 'badge' ) : '';
$bwe_desc                  = bwe_gw_attr( $attributes, 'desc' );
$bwe_btn                   = bwe_gw_attr( $attributes, 'btnText' );
$bwe_btn_style             = (string) ( $attributes['btnStyle'] ?? 'auto' );
$bwe_primary               = 'primary' === $bwe_btn_style || ( 'auto' === $bwe_btn_style && $bwe_featured );

$bwe_plan = ( '' !== $bwe_badge ? bwe_gw_group( 'bwex-plan__badgewrap', bwe_gw_p( 'bwex-plan__badge', $bwe_badge ) ) : '' )
	. bwe_gw_group( 'bwex-h3', '<h3 class="elementor-heading-title">' . wp_kses_post( bwe_gw_attr( $attributes, 'name' ) ) . '</h3>' )
	. bwe_gw_p( 'bwex-plan__price', bwe_gw_attr( $attributes, 'price' ) )
	. ( '' !== $bwe_desc ? bwe_gw_p( 'bwex-plan__desc', $bwe_desc ) : '' )
	. ( '' !== trim( $content ) ? bwe_gw_group( 'bwex-plan__list', $content ) : '' )
	. ( '' !== $bwe_btn ? '<div class="wp-block-buttons bwex-plan__btns is-layout-flex wp-block-buttons-is-layout-flex">' . bwe_gw_button( $bwe_primary ? 'bwe-btn bwe-btn--primary' : 'bwe-btn', bwe_gw_attr( $attributes, 'btnUrl' ), $bwe_btn, ! empty( $attributes['btnNewTab'] ) ) . '</div>' : '' );

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. bwe_gw_group(
		trim( bwe_gw_attr( $attributes, 'wrapClasses' ) . ' ' . $bwe_scope ),
		bwe_gw_group( 'elementor-widget-container', bwe_gw_group( 'bwex bwex-planw', bwe_gw_group( $bwe_featured ? 'bwex-plan bwex-plan--featured' : 'bwex-plan', $bwe_plan ) ) )
	);
