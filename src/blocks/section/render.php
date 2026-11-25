<?php
/**
 * Section: the same <section> the core group printed (its inner blocks render as before), plus a scoped <style>
 * when Styles-tab settings are used.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered inner blocks.
 */

defined( 'ABSPATH' ) || exit;

[ $bwe_scope, $bwe_style ] = bwe_gw_style_for_block( __DIR__, $attributes );
// Eyebrow icon (Eyebrow icon panel): replaces the drawn label icon; none set = exactly the old markup.
[ $bwe_icon_class, $bwe_icon_style ] = bwe_gw_icon_for_block( $attributes, ' :is(.bwex-eyebrow p, p.bwe-eyebrow)::before', '#0b0b0c' );

$bwe_id      = empty( $attributes['anchor'] ) ? '' : ' id="' . esc_attr( $attributes['anchor'] ) . '"';
$bwe_classes = trim( 'wp-block-group ' . ( $attributes['classes'] ?? '' ) . ( $bwe_scope ? ' ' . $bwe_scope : '' ) . ( $bwe_icon_class ? ' ' . $bwe_icon_class : '' ) );

// HTML tag (SEO / accessibility): section by default; aside for side notes like the demo bar, article, header …
$bwe_tag = in_array( (string) ( $attributes['tagName'] ?? '' ), array( 'section', 'div', 'aside', 'article', 'header', 'footer', 'main', 'nav' ), true ) ? $attributes['tagName'] : 'section';

echo $bwe_style . $bwe_icon_style . '<' . $bwe_tag . $bwe_id . ' class="' . esc_attr( $bwe_classes ) . '">' . $content . '</' . $bwe_tag . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS from cleaned values; inner blocks rendered by core.
