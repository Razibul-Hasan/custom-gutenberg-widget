<?php
/**
 * Spec card: the same <li><strong/><span/><code/></li> the group-based card printed. The tag is left out when empty.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$bwe_chip = (string) ( $attributes['chip'] ?? '' );
echo '<li><strong class="bwex-spec__name">' . wp_kses_post( $attributes['name'] ?? '' ) . "</strong>\n\n"
	. '<span class="bwex-spec__text">' . wp_kses_post( $attributes['text'] ?? '' ) . '</span>'
	. ( '' !== $bwe_chip ? "\n\n<code>" . wp_kses_post( $bwe_chip ) . '</code>' : '' )
	. '</li>';
