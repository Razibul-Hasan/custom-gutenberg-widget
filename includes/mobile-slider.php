<?php
/**
 * Phone slider: a block's list of cards becomes a swipe row on phones (optionally tablets too) instead of a stack.
 * Attributes (block.json): phoneLayout ("list" | "slider"), sliderTablet, slideWidth (% of the row), sliderDots,
 * sliderArrows. Optional desktop slider (Testimonials): desktopSlider + desktopSlides - a slider on wider screens
 * once there are more cards than fit in view. The list keeps its own markup and classes; the slider only adds classes, a CSS variable and the
 * dots/arrows row after it. Styles: assets/css/blocks.css ("Phone slider"). Script: assets/js/mobile-slider.js
 * (dots, arrows, edge-to-edge row); without it the row still swipes.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether the block's phone layout is the slider.
 *
 * @param array $attributes Block attributes.
 */
function bwe_gw_slider_on( array $attributes ) {
	return 'slider' === ( $attributes['phoneLayout'] ?? 'list' );
}

/**
 * Cards in view of the desktop slider (2-4).
 *
 * @param array $attributes Block attributes.
 */
function bwe_gw_slider_desktop_slides( array $attributes ) {
	return max( 2, min( 4, (int) ( $attributes['desktopSlides'] ?? 3 ) ) );
}

/**
 * Whether wider screens get the slider: switched on, and more cards than fit in view.
 *
 * @param array $attributes Block attributes.
 * @param int   $count      Number of cards.
 */
function bwe_gw_slider_desktop_on( array $attributes, $count ) {
	return ! empty( $attributes['desktopSlider'] ) && $count > bwe_gw_slider_desktop_slides( $attributes );
}

/**
 * Extra classes and inline style for the list element ('' / '' for the normal list).
 *
 * @param array $attributes Block attributes.
 * @param int   $count      Number of cards (only the desktop slider depends on it).
 * @return array{0: string, 1: string} [ classes, style attribute value ]
 */
function bwe_gw_slider_list_attrs( array $attributes, $count = 0 ) {
	$classes = array();
	$styles  = array();
	if ( bwe_gw_slider_on( $attributes ) ) {
		$width     = (int) ( $attributes['slideWidth'] ?? 85 );
		$width     = max( 50, min( 100, $width ? $width : 85 ) );
		$classes[] = 'bwe-ms--' . ( empty( $attributes['sliderTablet'] ) ? 'm' : 't' );
		$styles[]  = '--bwe-ms-w:' . $width . '%';
	}
	if ( bwe_gw_slider_desktop_on( $attributes, $count ) ) {
		$classes[] = 'bwe-ms--d';
		$styles[]  = '--bwe-ms-n:' . bwe_gw_slider_desktop_slides( $attributes );
	}
	if ( ! $classes ) {
		return array( '', '' );
	}
	return array( 'bwe-ms ' . implode( ' ', $classes ), implode( ';', $styles ) );
}

/**
 * The dots / arrows row printed after the list ('' when off or there is nothing to switch between).
 * Also loads the slider script.
 *
 * @param array $attributes Block attributes.
 * @param int   $count      Number of cards.
 */
function bwe_gw_slider_nav( array $attributes, $count ) {
	$phone   = bwe_gw_slider_on( $attributes );
	$desktop = bwe_gw_slider_desktop_on( $attributes, $count );
	if ( ( ! $phone && ! $desktop ) || bwe_gw_readers_mode() ) {
		return '';
	}
	wp_enqueue_script( 'bwe-gw-mobile-slider' );
	$dots   = ( $attributes['sliderDots'] ?? true ) && $count > 1;
	$arrows = ( $attributes['sliderArrows'] ?? true ) && $count > 1;
	if ( ! $dots && ! $arrows ) {
		return '';
	}
	$classes = 'bwe-ms__nav';
	if ( $phone ) {
		$classes .= ' bwe-ms__nav--' . ( empty( $attributes['sliderTablet'] ) ? 'm' : 't' );
	}
	if ( $desktop ) {
		$classes .= ' bwe-ms__nav--d';
	}
	$html = '<div class="' . $classes . '">';
	if ( $dots ) {
		$html .= '<div class="bwe-ms__dots" role="group" aria-label="' . esc_attr__( 'Choose a card', 'bestwebexpert' ) . '">';
		for ( $i = 1; $i <= $count; $i++ ) {
			/* translators: 1: card number, 2: number of cards. */
			$label = sprintf( __( 'Card %1$d of %2$d', 'bestwebexpert' ), $i, $count );
			$html .= '<button type="button" class="bwe-ms__dot" aria-label="' . esc_attr( $label ) . '"' . ( 1 === $i ? ' aria-current="true"' : '' ) . '></button>';
		}
		$html .= '</div>';
	}
	if ( $arrows ) {
		$html .= '<div class="bwe-ms__arrows">'
			. '<button type="button" class="bwe-ms__arrow bwe-ms__arrow--prev" aria-label="' . esc_attr__( 'Previous card', 'bestwebexpert' ) . '" disabled><span aria-hidden="true">←</span></button>'
			. '<button type="button" class="bwe-ms__arrow bwe-ms__arrow--next" aria-label="' . esc_attr__( 'Next card', 'bestwebexpert' ) . '"><span aria-hidden="true">→</span></button>'
			. '</div>';
	}
	return $html . '</div>';
}

/**
 * Registers the slider script (loaded by bwe_gw_slider_nav only on pages that use the slider).
 */
function bwe_gw_slider_register_script() {
	$file = BWE_GW_DIR . '/assets/js/mobile-slider.js';
	if ( is_file( $file ) ) {
		wp_register_script(
			'bwe-gw-mobile-slider',
			plugins_url( 'assets/js/mobile-slider.js', BWE_GW_DIR . '/bestwebexpert-gutenberg-widget.php' ),
			array(),
			(string) filemtime( $file ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}
}
add_action( 'init', 'bwe_gw_slider_register_script' );
