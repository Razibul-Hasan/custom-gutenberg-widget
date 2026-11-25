<?php
/**
 * Grid / columns: one <div> around the inner blocks; the column counts, ratio, alignment and card look are classes
 * (assets/css/blocks.css), the Styles-tab settings a scoped <style>.
 *
 * @package BWE_Gutenberg_Widget
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered inner blocks.
 */

defined( 'ABSPATH' ) || exit;

if ( '' === trim( (string) $content ) ) {
	return;
}

echo bwe_gw_grid_open( __DIR__, $attributes ) . $content . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from whitelisted classes / cleaned CSS; inner blocks rendered by core.
