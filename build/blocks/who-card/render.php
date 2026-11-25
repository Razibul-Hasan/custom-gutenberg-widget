<?php
/**
 * Who card: the same linked <li> the core List item printed.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

// Links to another site (e.g. the plugin docs) open in a new tab; links on this site print as before.
$bwe_url  = (string) ( $attributes['url'] ?? '' );
$bwe_host = wp_parse_url( $bwe_url, PHP_URL_HOST );
$bwe_ext  = $bwe_host && strtolower( $bwe_host ) !== strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) );

printf(
	'<li><a href="%1$s"%5$s><strong>%2$s</strong> <span>%3$s</span> <em>%4$s</em></a></li>',
	esc_attr( $bwe_url ),
	wp_kses_post( $attributes['title'] ?? '' ),
	wp_kses_post( $attributes['text'] ?? '' ),
	wp_kses_post( $attributes['tag'] ?? '' ),
	$bwe_ext ? ' target="_blank" rel="noopener"' : ''
);
