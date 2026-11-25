<?php
/**
 * Why us: header, spec cards (bwe/spec-card) and the line under them — the markup of the old Home pattern.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered spec cards.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );
$bwe_aside                   = ( $attributes['showAside'] ?? true ) ? bwe_gw_attr( $attributes, 'aside' ) : '';

// Background: soft beige (Home, most pages) or white. Header: Home's prints it bare; the other pages' copies
// wrap it like their other sections (section-head widget wrapper + .bwex-headw).
$bwe_soft = 'white' !== ( $attributes['tone'] ?? 'soft' );
$bwe_head = empty( $attributes['headWrap'] )
	? bwe_gw_head( $attributes, false )
	: bwe_gw_head_widget( $attributes );

// The other pages' copies also keep the line under the cards inside the cards' box.
$bwe_foot = '' !== $bwe_aside ? bwe_gw_group( 'bwex-spec__foot', bwe_gw_p( 'bwex-spec__aside', $bwe_aside ) ) : '';

$bwe_inner = bwe_gw_group(
	'bwex-wrap',
	$bwe_head
	. ( empty( $attributes['headWrap'] )
		? bwe_gw_group( 'bwex-spec__body', '<ul class="wp-block-list bwex-spec__list">' . $content . '</ul>' ) . $bwe_foot
		: bwe_gw_group( 'bwex-spec__body', '<ul class="wp-block-list bwex-spec__list">' . $content . '</ul>' . $bwe_foot ) )
);

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. bwe_gw_group(
		'elementor-element elementor-element-ce6cb54 elementor-widget elementor-widget-bwex-spec',
		bwe_gw_group(
			'elementor-widget-container',
			bwe_gw_group(
				'bwex bwex-specw' . ( $bwe_soft ? ' bwex-specw--soft' : '' ),
				'<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( trim( 'wp-block-group bwex-section bwex-spec ' . ( $bwe_soft ? 'bwex-section--soft ' : '' ) . $bwe_classes ) ) . '">' . $bwe_inner . '</section>'
			)
		)
	);
