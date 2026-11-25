<?php
/**
 * Price list: the same <ul> the core List printed (CSS: BestWebExpert Home assets/home-2/pricing.css).
 *
 * @package BWE_Gutenberg_Widget
 * @var string $content Rendered price rows.
 */

defined( 'ABSPATH' ) || exit;

echo '<ul class="wp-block-list bwe-prx__list">' . $content . '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks.
