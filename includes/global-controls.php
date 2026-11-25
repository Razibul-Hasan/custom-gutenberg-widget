<?php
/**
 * Settings every block of this plugin shares, without touching each block's own code:
 *
 * - Visibility (attribute "bweHide"): hide the block on desktop (1025px+), tablet (782–1024px) or phone (781px and
 *   less) — the same breakpoints as the Styles tab. Adds bwe-hide-d / -t / -m to the block's first element; the
 *   rules are in assets/css/blocks.css. In the editor a hidden block stays editable, only faded.
 * - Heading tag (attribute "headingTag", SEO): the tag of the block's main heading, e.g. a section heading as h1 when
 *   the page has no hero, a card title as h4 under an h3, or a plain p/div for a decorative title. The classes stay,
 *   so the look stays. Empty = the block's normal tag, i.e. exactly the old markup.
 *
 * Editor side: src/blocks/shared/global-controls.js (keep BWE_GW_HEADING_BLOCKS in step with HEADING_BLOCKS there).
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * Blocks with a main heading: block => [ normal tag, the heading's class or '' (= the first tag of that name) ].
 */
const BWE_GW_HEADING_BLOCKS = array(
	'bwe/hero'          => array( 'h1', 'bwe-hero__title' ),
	'bwe/section-head'  => array( 'h2', 'elementor-heading-title' ),
	'bwe/services'      => array( 'h2', 'elementor-heading-title' ),
	'bwe/why-us'        => array( 'h2', 'elementor-heading-title' ),
	'bwe/testimonials'  => array( 'h2', 'elementor-heading-title' ),
	'bwe/pricing'       => array( 'h2', 'elementor-heading-title' ),
	'bwe/process'       => array( 'h2', 'elementor-heading-title' ),
	'bwe/products'      => array( 'h2', 'elementor-heading-title' ),
	'bwe/faq'           => array( 'h2', 'elementor-heading-title' ),
	'bwe/price-section' => array( 'h2', 'elementor-heading-title' ),
	'bwe/work'          => array( 'h2', 'elementor-heading-title' ),
	'bwe/about'         => array( 'h2', 'elementor-heading-title' ),
	'bwe/contact-form'  => array( 'h2', 'elementor-heading-title' ),
	'bwe/cta'           => array( 'h2', '' ),
	'bwe/step'          => array( 'h3', '' ),
	'bwe/price-plan'    => array( 'h3', '' ),
	'bwe/price-card'    => array( 'h3', '' ),
	'bwe/platform-card' => array( 'h3', '' ),
	'bwe/product-card'  => array( 'h3', '' ),
	'bwe/work-item'     => array( 'h3', '' ),
	'bwe/cost-panel'    => array( 'h3', '' ),
	'bwe/spec-card'     => array( 'strong', 'bwex-spec__name' ),
);

/** Tags a heading may get. */
const BWE_GW_HEADING_TAGS = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span', 'strong' );

/**
 * Adds the shared attributes to every bwe/* block (server side, so the editor gets them too).
 *
 * @param array  $args Block type arguments.
 * @param string $name Block name.
 */
function bwe_gw_global_attributes( $args, $name ) {
	if ( 0 !== strpos( (string) $name, 'bwe/' ) ) {
		return $args;
	}
	$args['attributes']            = $args['attributes'] ?? array();
	$args['attributes']['bweHide'] = array(
		'type'    => 'object',
		'default' => array(),
	);
	if ( isset( BWE_GW_HEADING_BLOCKS[ $name ] ) ) {
		$args['attributes']['headingTag'] = array(
			'type'    => 'string',
			'default' => '',
		);
	}
	return $args;
}
add_filter( 'register_block_type_args', 'bwe_gw_global_attributes', 10, 2 );

/**
 * Visibility classes of a block ('' when shown everywhere).
 *
 * @param array $attributes Block attributes.
 */
function bwe_gw_hide_classes( array $attributes ) {
	$hide    = is_array( $attributes['bweHide'] ?? null ) ? $attributes['bweHide'] : array();
	$classes = array();
	foreach ( array( 'desktop' => 'd', 'tablet' => 't', 'mobile' => 'm' ) as $device => $suffix ) {
		if ( ! empty( $hide[ $device ] ) ) {
			$classes[] = 'bwe-hide-' . $suffix;
		}
	}
	return implode( ' ', $classes );
}

/**
 * Changes the tag of a block's main heading (the first heading of its normal tag, with its class when one is set).
 *
 * @param string $html  Rendered block.
 * @param string $block Block name.
 * @param string $tag   Wanted tag.
 */
function bwe_gw_retag_heading( $html, $block, $tag ) {
	[ $from, $class ] = BWE_GW_HEADING_BLOCKS[ $block ];
	$tag              = strtolower( (string) $tag );
	if ( $tag === $from || ! in_array( $tag, BWE_GW_HEADING_TAGS, true ) ) {
		return $html;
	}
	$class_re = '' === $class ? '' : '(?=[^>]*\bclass="[^"]*\b' . preg_quote( $class, '/' ) . '\b)';
	// A heading printed as p / div / span / strong gets "bwe-gw-tag", so blocks.css can keep the site's heading font
	// on it (the site gives that font to h1–h6 only).
	$plain = in_array( $tag, array( 'p', 'div', 'span', 'strong' ), true ) && 'strong' !== $from;
	return (string) preg_replace_callback(
		'/<' . $from . '(?=[\s>])' . $class_re . '([^>]*)>(.*?)<\/' . $from . '>/s',
		static function ( $m ) use ( $tag, $plain ) {
			$attrs = $m[1];
			if ( $plain ) {
				$attrs = false !== strpos( $attrs, 'class="' ) ? str_replace( 'class="', 'class="bwe-gw-tag ', $attrs ) : $attrs . ' class="bwe-gw-tag"';
			}
			return '<' . $tag . $attrs . '>' . $m[2] . '</' . $tag . '>';
		},
		$html,
		1
	);
}

/**
 * Applies the shared settings to a rendered bwe/* block.
 *
 * @param string $html  Rendered block.
 * @param array  $block Parsed block.
 */
function bwe_gw_global_render( $html, $block ) {
	$name = (string) ( $block['blockName'] ?? '' );
	if ( 0 !== strpos( $name, 'bwe/' ) || '' === trim( (string) $html ) ) {
		return $html;
	}
	$attributes = (array) ( $block['attrs'] ?? array() );
	if ( isset( BWE_GW_HEADING_BLOCKS[ $name ] ) && '' !== (string) ( $attributes['headingTag'] ?? '' ) ) {
		$html = bwe_gw_retag_heading( $html, $name, $attributes['headingTag'] );
	}
	$hide = bwe_gw_hide_classes( $attributes );
	if ( '' !== $hide ) {
		$tags = new WP_HTML_Tag_Processor( $html );
		while ( $tags->next_tag() ) {
			if ( ! in_array( $tags->get_tag(), array( 'STYLE', 'SCRIPT', 'LINK' ), true ) ) {
				foreach ( explode( ' ', $hide ) as $class ) {
					$tags->add_class( $class );
				}
				$html = $tags->get_updated_html();
				break;
			}
		}
	}
	return $html;
}
// After the outer-wrap filter (10), so a hero / services block that draws its own wrappers hides as a whole.
add_filter( 'render_block', 'bwe_gw_global_render', 20, 2 );
