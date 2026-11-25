<?php
/**
 * Selected work: header and the numbered project list (bwe/work-item) — the markup the Portfolio page's
 * "Selected Work" section printed before it became a block. The desktop hover preview and the fading rows come
 * from BestWebExpert Home's work.css; the Styles tab adjusts them.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered projects.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );

$bwe_section = '<section' . bwe_gw_id_attr( $attributes ) . ' class="wp-block-group bwex-section bwex-work">'
	. bwe_gw_group(
		'bwex-wrap',
		bwe_gw_head_widget( $attributes )
		. bwe_gw_group( 'bwex-work__grid', $content )
	)
	. '</section>';

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values; parts escaped above.
	. bwe_gw_group(
		trim( bwe_gw_attr( $attributes, 'wrapClasses' ) . ' ' . $bwe_classes ),
		bwe_gw_group( 'elementor-widget-container', bwe_gw_group( 'bwex bwex-workw', $bwe_section ) )
	);
