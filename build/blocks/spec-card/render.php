<?php
/**
 * Spec card: the same <li><strong/><span/><code/></li> the group-based card printed. The tag is left out when empty.
 *
 * Whole card clickable (Card link panel, on by default): the card links to its URL, or, with no URL, to the link at
 * the end of its text when that link ends in an arrow ("Open the demo →"). A transparent link then covers the card;
 * links inside the text stay clickable on their own. A card with no link, a mid-sentence link, or a link in its
 * name prints exactly as before.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$bwe_name  = (string) ( $attributes['name'] ?? '' );
$bwe_text  = (string) ( $attributes['text'] ?? '' );
$bwe_chip  = (string) ( $attributes['chip'] ?? '' );
$bwe_cover = bwe_gw_spec_card_cover( $attributes, $bwe_name, $bwe_text );

echo '<li' . ( '' !== $bwe_cover ? ' class="bwex-spec__item--link"' : '' ) . '>'
	. '<strong class="bwex-spec__name">' . wp_kses_post( $bwe_name ) . "</strong>\n\n"
	. '<span class="bwex-spec__text">' . wp_kses_post( $bwe_text ) . '</span>'
	. ( '' !== $bwe_chip ? "\n\n<code>" . wp_kses_post( $bwe_chip ) . '</code>' : '' )
	. $bwe_cover // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in bwe_gw_spec_card_cover().
	. '</li>';
