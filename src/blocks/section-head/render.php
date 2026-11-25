<?php
/**
 * Section header: the same nested markup the 8 core groups printed (CSS in BestWebExpert Home).
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$bwe_group = static fn( string $class, string $inner ): string => '<div class="wp-block-group ' . $class . '">' . $inner . '</div>';
$bwe_id    = (string) ( $attributes['headingId'] ?? '' );
$bwe_intro = (string) ( $attributes['intro'] ?? '' );

$bwe_main = $bwe_group( 'bwex-head__main', $bwe_group( 'bwex-eyebrow', '<p class="wp-block-paragraph">' . wp_kses_post( $attributes['eyebrow'] ?? '' ) . '</p>' )
	. $bwe_group( 'bwex-h2', '<h2' . ( '' !== $bwe_id ? ' id="' . esc_attr( $bwe_id ) . '"' : '' ) . ' class="elementor-heading-title">' . wp_kses_post( $attributes['title'] ?? '' ) . '</h2>' ) );
$bwe_head = $bwe_main . ( '' !== $bwe_intro ? $bwe_group( 'bwex-intro', '<p class="wp-block-paragraph">' . wp_kses_post( $bwe_intro ) . '</p>' ) : '' );

echo $bwe_group( 'bwex bwex-headw', $bwe_group( ( $attributes['split'] ?? true ) ? 'bwex-head bwex-head--split' : 'bwex-head', $bwe_head ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- parts escaped above.
