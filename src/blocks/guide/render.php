<?php
/**
 * Guide / checklist: header, numbered step cards (bwe/step) and an optional button + note.
 *
 * Same dark look as "How it works" (it carries .bwex-process, so every site rule for those cards applies), plus:
 * items per row per screen size, a centred or left header, and a centred incomplete last row (assets/css/blocks.css,
 * "Guide").
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered steps.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_classes, $bwe_style ] = bwe_gw_section_style( __DIR__, $attributes );

// Header (centre | left), cards (left | center | right | stretch) and button (header's | left | center | right).
$bwe_pick   = static fn( $value, array $allowed, $fallback ) => in_array( (string) $value, $allowed, true ) ? (string) $value : $fallback;
$bwe_mods   = array( 'bwex-guide' );
$bwe_mods[] = 'left' === ( $attributes['headAlign'] ?? 'center' ) ? 'bwex-guide--left' : 'bwex-guide--center';
$bwe_mods[] = 'bwex-guide--last-' . $bwe_pick( $attributes['lastRow'] ?? 'center', array( 'left', 'center', 'right', 'stretch' ), 'center' );
$bwe_btn_al = $bwe_pick( $attributes['btnAlign'] ?? '', array( 'left', 'center', 'right' ), '' );
if ( '' !== $bwe_btn_al ) {
	$bwe_mods[] = 'bwex-guide--btn-' . $bwe_btn_al;
}

$bwe_btn  = bwe_gw_attr( $attributes, 'btnText' );
$bwe_note = bwe_gw_attr( $attributes, 'note' );
$bwe_foot = '';
if ( '' !== $bwe_btn || '' !== $bwe_note ) {
	$bwe_btn_class = 'outline' === ( $attributes['btnStyle'] ?? 'fill' ) ? 'bwex-btn' : 'bwex-btn bwex-btn--fill';
	$bwe_foot      = bwe_gw_group(
		'bwex-guide__foot',
		( '' !== $bwe_btn ? '<div class="wp-block-buttons bwe-btns-raw">' . bwe_gw_button( 'elementor-element ' . $bwe_btn_class . ' elementor-widget elementor-widget-button', bwe_gw_attr( $attributes, 'btnUrl' ), $bwe_btn, ! empty( $attributes['btnNewTab'] ) ) . '</div>' : '' )
		. ( '' !== $bwe_note ? bwe_gw_p( 'bwex-guide__note', $bwe_note ) : '' )
	);
}

echo $bwe_style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS built from cleaned values.
	. '<section' . bwe_gw_id_attr( $attributes ) . ' class="' . esc_attr( trim( 'wp-block-group elementor-element e-con-full bwex-section bwex-section--dark bwex-process ' . implode( ' ', $bwe_mods ) . ' e-flex e-con e-child ' . $bwe_classes ) ) . '">'
	. bwe_gw_group(
		'elementor-element e-con-full bwex-wrap e-flex e-con e-child',
		bwe_gw_head_widget( $attributes )
		. bwe_gw_group( 'elementor-element elementor-widget elementor-widget-bwex-numbered-list', bwe_gw_group( 'elementor-widget-container', '<ol class="bwex-num bwex-num--row bwex-num--dark bwex-guide__list" start="1">' . $content . '</ol>' ) )
		. $bwe_foot
	)
	. '</section>';
