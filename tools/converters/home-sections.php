<?php
/**
 * Converter: Home's sections (2026-11-23) from bwe/section + core blocks to their own section blocks —
 * Why us, Testimonials, Pricing (+ Starting prices, Cost explainer), How it works, Our products, FAQ, Call to
 * action — and the shared "Price plans" pattern to bwe/plans + bwe/price-plan.
 * Spec cards, steps, FAQ questions and the plans' feature lists move over unchanged.
 * Usage: php convert.php <wp-root> home-sections [--dry-run] [--ids=1228,1355,…]
 *
 * @package BWE_Gutenberg_Widget
 */

/**
 * True when the block's className (or bwe/section "classes") has every given class.
 *
 * @param array  $block   Parsed block.
 * @param string $classes Space-separated classes.
 */
function bwe_tb_hs_has( array $block, string $classes ): bool {
	$have = ' ' . ( $block['attrs']['className'] ?? $block['attrs']['classes'] ?? '' ) . ' ';
	foreach ( explode( ' ', $classes ) as $class ) {
		if ( false === strpos( $have, ' ' . $class . ' ' ) ) {
			return false;
		}
	}
	return true;
}

/**
 * First block (depth-first, the block itself included) that matches.
 *
 * @param array    $block Parsed block.
 * @param callable $test  fn( array $block ): bool.
 */
function bwe_tb_hs_find( array $block, callable $test ): ?array {
	if ( $test( $block ) ) {
		return $block;
	}
	foreach ( $block['innerBlocks'] ?? array() as $child ) {
		$found = bwe_tb_hs_find( $child, $test );
		if ( $found ) {
			return $found;
		}
	}
	return null;
}

/**
 * Every block (depth-first) that matches; matches are not searched inside.
 *
 * @param array    $block Parsed block.
 * @param callable $test  fn( array $block ): bool.
 */
function bwe_tb_hs_all( array $block, callable $test ): array {
	$out = array();
	foreach ( $block['innerBlocks'] ?? array() as $child ) {
		if ( $test( $child ) ) {
			$out[] = $child;
		} else {
			$out = array_merge( $out, bwe_tb_hs_all( $child, $test ) );
		}
	}
	return $out;
}

/**
 * Block by name and classes, inside $block.
 *
 * @param array  $block   Parsed block.
 * @param string $name    Block name.
 * @param string $classes Classes ('' = any).
 */
function bwe_tb_hs_get( array $block, string $name, string $classes = '' ): ?array {
	return bwe_tb_hs_find( $block, static fn( $b ) => $name === ( $b['blockName'] ?? '' ) && ( '' === $classes || bwe_tb_hs_has( $b, $classes ) ) );
}

/**
 * Inner HTML of a paragraph / heading / list item ('' when missing).
 *
 * @param array|null $block Parsed block.
 */
function bwe_tb_hs_inner( ?array $block ): string {
	if ( ! $block || ! preg_match( '#^\s*<(p|h[1-6]|li)\b[^>]*>(.*)</\1>\s*$#s', $block['innerHTML'], $m ) ) {
		return '';
	}
	return $m[2];
}

/**
 * [ href, text ] of a core/button.
 *
 * @param array|null $block Parsed core/button.
 */
function bwe_tb_hs_button( ?array $block ): array {
	if ( ! $block || ! preg_match( '#<a\b[^>]*\shref="([^"]*)"[^>]*>(.*?)</a>#s', $block['innerHTML'], $m ) ) {
		return array( '', '' );
	}
	return array( html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' ), $m[2] );
}

/**
 * Header attributes from a bwe/section-head inside $block.
 *
 * @param array $block Parsed block.
 */
function bwe_tb_hs_head( array $block ): ?array {
	$head = bwe_tb_hs_get( $block, 'bwe/section-head' );
	if ( ! $head ) {
		return null;
	}
	$a = $head['attrs'];
	// The section widgets print the header with bwe_gw_head(), which leaves an empty eyebrow out (the header
	// block prints an empty eyebrow group): keep those as they are.
	if ( '' === (string) ( $a['eyebrow'] ?? '' ) ) {
		return null;
	}
	return array(
		'eyebrow' => (string) ( $a['eyebrow'] ?? '' ),
		'title'   => (string) ( $a['title'] ?? '' ),
		'intro'   => (string) ( $a['intro'] ?? '' ),
		'split'   => $a['split'] ?? true,
	) + ( '' !== (string) ( $a['headingId'] ?? '' ) ? array( 'headingId' => (string) $a['headingId'] ) : array() );
}

/**
 * Elementor id on the section-head widget wrapper inside $block ('' when it has none, e.g. the service pages).
 *
 * @param array $block Parsed block.
 */
function bwe_tb_hs_head_element_id( array $block ): string {
	$wrap = bwe_tb_hs_find( $block, static fn( $b ) => 'core/group' === ( $b['blockName'] ?? '' ) && bwe_tb_hs_has( $b, 'elementor-widget-bwex-section-head' ) );
	return $wrap && preg_match( '/(?:^|\s)elementor-element-([a-z0-9]+)(?:\s|$)/', (string) $wrap['attrs']['className'], $m ) ? $m[1] : '';
}

/**
 * Pattern-overrides metadata: the block's text can differ per page.
 *
 * @param string $name Name shown in List View (unique inside the pattern).
 */
function bwe_tb_hs_meta( string $name ): array {
	return array(
		'name'     => $name,
		'bindings' => array( '__default' => array( 'source' => 'core/pattern-overrides' ) ),
	);
}

/**
 * Short plain-text label for List View.
 *
 * @param string $html Text.
 */
function bwe_tb_hs_label( string $html ): string {
	$text = trim( preg_replace( '/\s+/', ' ', html_entity_decode( wp_strip_all_tags( $html ), ENT_QUOTES, 'UTF-8' ) ) );
	return mb_strlen( $text ) > 40 ? rtrim( mb_substr( $text, 0, 40 ) ) . '…' : $text;
}

/**
 * New block attrs: the given values, minus those equal to block.json defaults, plus style values carried over.
 *
 * @param string $slug    Block folder (src/blocks/<slug>).
 * @param array  $values  Attribute values.
 * @param array  $section The old bwe/section (style + icon carried over), or [].
 */
function bwe_tb_hs_attrs( string $slug, array $values, array $section = array() ): array {
	// Text is always saved, even when it equals a default, so a later change of a default never changes a page.
	// Only true booleans that are already the default are left out.
	$json  = json_decode( (string) file_get_contents( dirname( __DIR__, 2 ) . "/src/blocks/$slug/block.json" ), true );
	$attrs = array();
	foreach ( $values as $key => $value ) {
		if ( 'metadata' !== $key && ! isset( $json['attributes'][ $key ] ) ) {
			throw new RuntimeException( "bwe/$slug has no attribute $key" );
		}
		if ( 'metadata' === $key || ! is_bool( $value ) || ( $json['attributes'][ $key ]['default'] ?? null ) !== $value ) {
			$attrs[ $key ] = $value;
		}
	}
	foreach ( array( 'bweStyle', 'bweIcon' ) as $key ) {
		if ( ! empty( $section['attrs'][ $key ] ) ) {
			$attrs[ $key ] = $section['attrs'][ $key ];
		}
	}
	return $attrs;
}

/**
 * Returns the new block for one of Home's sections, false for a known section in an unknown shape, null otherwise.
 *
 * @param array $block Parsed block.
 * @return array|false|null
 */
function bwe_tb_convert_home_sections( array $block ) {
	$name = (string) ( $block['blockName'] ?? '' );

	// Why us: the spec widget wrapper around a bwe/section.bwex-spec.
	if ( 'core/group' === $name && bwe_tb_hs_has( $block, 'elementor-element-ce6cb54 elementor-widget-bwex-spec' ) ) {
		$section = bwe_tb_hs_get( $block, 'bwe/section', 'bwex-spec' );
		$list    = $section ? bwe_tb_hs_get( $section, 'bwe/spec-list' ) : null;
		$headg   = $section ? bwe_tb_hs_find( $section, static fn( $b ) => 'core/group' === $b['blockName'] && bwe_tb_hs_has( $b, 'bwex-head' ) ) : null;
		// The other pages' copies (2026-11-24 rebuild): header block in the section-head widget wrapper, white or soft.
		if ( $section && $list && ! $headg && bwe_tb_hs_get( $section, 'bwe/section-head' ) ) {
			$head = bwe_tb_hs_head( $section );
			$soft = bwe_tb_hs_has( $section, 'bwex-section--soft' );
			if ( ! $head || ! empty( $list['attrs'] ) || $soft !== bwe_tb_hs_has( bwe_tb_hs_get( $block, 'core/group', 'bwex-specw' ) ?? array(), 'bwex-specw--soft' ) ) {
				return false;
			}
			$aside  = bwe_tb_hs_inner( bwe_tb_hs_get( $section, 'core/paragraph', 'bwex-spec__aside' ) );
			$values = $head + array(
				'aside'     => $aside,
				'showAside' => '' !== $aside,
				'tone'      => $soft ? 'soft' : 'white',
				'headWrap'  => true,
				'sectionId' => (string) ( $section['attrs']['anchor'] ?? '' ),
				'metadata'  => array( 'name' => 'Why us' ),
			);
			return bwe_tb_block_with_children( 'bwe/why-us', bwe_tb_hs_attrs( 'why-us', $values, $section ), $list['innerBlocks'] );
		}
		if ( ! $section || ! $list || ! $headg ) {
			return false;
		}
		$values = array(
			'eyebrow'   => bwe_tb_hs_inner( bwe_tb_hs_get( bwe_tb_hs_get( $headg, 'core/group', 'bwex-eyebrow' ) ?? array(), 'core/paragraph' ) ),
			'title'     => bwe_tb_hs_inner( bwe_tb_hs_get( $headg, 'core/heading' ) ),
			'intro'     => bwe_tb_hs_inner( bwe_tb_hs_get( bwe_tb_hs_get( $headg, 'core/group', 'bwex-intro' ) ?? array(), 'core/paragraph' ) ),
			'split'     => bwe_tb_hs_has( $headg, 'bwex-head--split' ),
			'aside'     => bwe_tb_hs_inner( bwe_tb_hs_get( $section, 'core/paragraph', 'bwex-spec__aside' ) ),
			'headingId' => (string) ( bwe_tb_hs_get( $headg, 'core/heading' )['attrs']['anchor'] ?? '' ),
			'sectionId' => (string) ( $section['attrs']['anchor'] ?? '' ),
			'metadata'  => bwe_tb_hs_meta( 'Why us' ),
		);
		return bwe_tb_block_with_children( 'bwe/why-us', bwe_tb_hs_attrs( 'why-us', $values, $section ), $list['innerBlocks'] );
	}

	// Call to action: the CTA widget wrapper around a bwe/section.bwe-final.
	if ( 'core/group' === $name && bwe_tb_hs_has( $block, 'elementor-element-f672073 elementor-widget-bwex-cta' ) ) {
		$section = bwe_tb_hs_get( $block, 'bwe/section', 'bwe-final' );
		if ( ! $section ) {
			return false;
		}
		$b1          = bwe_tb_hs_get( $section, 'core/button', 'bwe-btn--primary' );
		$b2          = bwe_tb_hs_get( $section, 'core/button', 'bwe-btn--ghost' );
		[ $u1, $t1 ] = bwe_tb_hs_button( $b1 );
		[ $u2, $t2 ] = bwe_tb_hs_button( $b2 );
		$newtab      = static fn( ?array $b ): bool => $b && false !== strpos( $b['innerHTML'], ' target="_blank" rel="noreferrer noopener"' );
		$values      = array(
			'btn1NewTab' => $newtab( $b1 ),
			'btn2NewTab' => $newtab( $b2 ),
			'eyebrow'   => bwe_tb_hs_inner( bwe_tb_hs_get( $section, 'core/paragraph', 'bwe-eyebrow' ) ),
			'title'     => bwe_tb_hs_inner( bwe_tb_hs_get( $section, 'core/heading' ) ),
			'lead'      => bwe_tb_hs_inner( bwe_tb_hs_get( $section, 'core/paragraph', 'bwe-lead' ) ),
			'btn1Text'  => $t1,
			'btn1Url'   => $u1,
			'btn2Text'  => $t2,
			'btn2Url'   => $u2,
			'showBtn2'  => '' !== $t2,
			'chat'      => bwe_tb_hs_inner( bwe_tb_hs_get( $section, 'core/paragraph', 'bwe-final__chat' ) ),
			'note'      => bwe_tb_hs_inner( bwe_tb_hs_get( $section, 'core/paragraph', 'bwe-final__note' ) ),
			'sectionId' => (string) ( $section['attrs']['anchor'] ?? '' ),
			'metadata'  => bwe_tb_hs_meta( 'Call to action' ),
		);
		$values['showChat'] = '' !== $values['chat'];
		$values['showNote'] = '' !== $values['note'];
		return bwe_tb_leaf_block( 'bwe/cta', bwe_tb_hs_attrs( 'cta', $values, $section ) );
	}

	// Shared price plans (pattern "Price plans"): group .bwex-plans of plan widgets.
	if ( 'core/group' === $name && bwe_tb_hs_has( $block, 'elementor-element-e077279 bwex-plans' ) ) {
		$plans = array();
		foreach ( $block['innerBlocks'] as $wrap ) {
			$plan = bwe_tb_hs_get( $wrap, 'core/group', 'bwex-plan' );
			$list = $plan ? bwe_tb_hs_get( $plan, 'core/list', 'bwex-checks' ) : null;
			$btn  = $plan ? bwe_tb_hs_get( $plan, 'core/button', 'bwe-btn' ) : null;
			if ( ! bwe_tb_hs_has( $wrap, 'elementor-widget-bwex-pricing-plan' ) || ! $plan || ! $list || ! $btn ) {
				return false;
			}
			$featured      = bwe_tb_hs_has( $plan, 'bwex-plan--featured' );
			$primary       = bwe_tb_hs_has( $btn, 'bwe-btn--primary' );
			[ $url, $text ] = bwe_tb_hs_button( $btn );
			$plan_name     = bwe_tb_hs_inner( bwe_tb_hs_get( $plan, 'core/heading' ) );
			$values        = array(
				'name'        => $plan_name,
				'price'       => bwe_tb_hs_inner( bwe_tb_hs_get( $plan, 'core/paragraph', 'bwex-plan__price' ) ),
				'desc'        => bwe_tb_hs_inner( bwe_tb_hs_get( $plan, 'core/paragraph', 'bwex-plan__desc' ) ),
				'featured'    => $featured,
				'badge'       => $featured ? bwe_tb_hs_inner( bwe_tb_hs_get( $plan, 'core/paragraph', 'bwex-plan__badge' ) ) : 'Most popular',
				'btnText'     => $text,
				'btnUrl'      => $url,
				'btnNewTab'   => false !== strpos( $btn['innerHTML'], ' target="_blank" rel="noreferrer noopener"' ),
				'btnStyle'    => $primary === $featured ? 'auto' : ( $primary ? 'primary' : 'outline' ),
				'wrapClasses' => (string) $wrap['attrs']['className'],
				'metadata'    => array( 'name' => 'Plan: ' . bwe_tb_hs_label( $plan_name ) ),
			);
			$plans[]       = bwe_tb_block_with_children( 'bwe/price-plan', bwe_tb_hs_attrs( 'price-plan', $values ), array( $list ) );
		}
		return bwe_tb_block_with_children( 'bwe/plans', array( 'metadata' => array( 'name' => 'Price plans' ) ), $plans );
	}

	if ( 'bwe/section' !== $name ) {
		return null;
	}

	// Testimonials.
	if ( bwe_tb_hs_has( $block, 'elementor-element-fdfb384 bwex-proof' ) ) {
		$head = bwe_tb_hs_head( $block );
		if ( ! $head ) {
			return false;
		}
		$cards = array();
		foreach ( bwe_tb_hs_all( $block, static fn( $b ) => 'core/group' === $b['blockName'] && bwe_tb_hs_has( $b, 'bwex-vt' ) ) as $vt ) {
			$embed = bwe_tb_hs_get( $vt, 'core/embed' );
			$who   = bwe_tb_hs_inner( bwe_tb_hs_get( $vt, 'core/paragraph', 'bwex-vt__who' ) );
			if ( ! $embed || count( $vt['innerBlocks'] ) !== 2 ) {
				return false;
			}
			$cards[] = bwe_tb_leaf_block(
				'bwe/video-card',
				array(
					'url'      => (string) $embed['attrs']['url'],
					'who'      => $who,
					'metadata' => bwe_tb_hs_meta( 'Video: ' . bwe_tb_hs_label( $who ) ),
				)
			);
		}
		$values = $head + array(
			'more'      => bwe_tb_hs_inner( bwe_tb_hs_get( $block, 'core/paragraph', 'bwex-more' ) ),
			'sectionId' => (string) ( $block['attrs']['anchor'] ?? '' ),
			'metadata'  => bwe_tb_hs_meta( 'Testimonials' ),
		);
		return $cards ? bwe_tb_block_with_children( 'bwe/testimonials', bwe_tb_hs_attrs( 'testimonials', $values, $block ), $cards ) : false;
	}

	// Pricing: header + [plans pattern, starting prices, cost explainer].
	if ( bwe_tb_hs_has( $block, 'elementor-element-74d01ef bwex-pricing' ) ) {
		$head = bwe_tb_hs_head( $block );
		$wrap = $block['innerBlocks'][0] ?? null;
		if ( ! $head || ! $wrap || ! bwe_tb_hs_has( $wrap, 'elementor-element-d60292a bwex-wrap' ) ) {
			return false;
		}
		$children = array();
		$more     = '';
		$parts    = array_slice( $wrap['innerBlocks'], 1 );
		// The service pages' note under the plans (last).
		$last = end( $parts );
		if ( $last && 'core/paragraph' === $last['blockName'] && 'bwex-more' === ( $last['attrs']['className'] ?? '' ) ) {
			$more = bwe_tb_hs_inner( $last );
			array_pop( $parts );
		}
		foreach ( $parts as $part ) {
			if ( in_array( $part['blockName'], array( 'core/block', 'bwe/plans', 'bwe/starting-prices', 'bwe/cost-panel' ), true ) ) {
				$children[] = $part;
			} elseif ( bwe_tb_hs_has( $part, 'bwex-pricenote' ) ) {
				$items = array();
				foreach ( bwe_tb_hs_get( $part, 'core/list', 'bwex-pricenote__list' )['innerBlocks'] ?? array() as $li ) {
					if ( ! preg_match( '#<li><a href="([^"]*)"><span>(.*?)</span>\s*<strong>(.*?)</strong></a></li>#s', $li['innerHTML'], $m ) ) {
						return false;
					}
					$items[] = array(
						'label' => $m[2],
						'price' => $m[3],
						'url'   => html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' ),
					);
				}
				$all = bwe_tb_hs_inner( bwe_tb_hs_get( $part, 'core/paragraph', 'bwex-pricenote__all' ) );
				if ( ! preg_match( '#^<a href="([^"]*)">(.*)</a>$#s', $all, $a ) ) {
					return false;
				}
				$values     = array(
					'label'    => bwe_tb_hs_inner( bwe_tb_hs_get( $part, 'core/paragraph', 'bwex-pricenote__label' ) ),
					'items'    => $items,
					'note'     => bwe_tb_hs_inner( bwe_tb_hs_get( $part, 'core/paragraph', 'bwex-pricenote__note' ) ),
					'allText'  => $a[2],
					'allUrl'   => html_entity_decode( $a[1], ENT_QUOTES, 'UTF-8' ),
					'metadata' => bwe_tb_hs_meta( 'Starting prices' ),
				);
				$children[] = bwe_tb_leaf_block( 'bwe/starting-prices', bwe_tb_hs_attrs( 'starting-prices', $values ) );
			} elseif ( bwe_tb_hs_has( $part, 'elementor-element-fc1d409 bwex-cost' ) ) {
				$grid  = bwe_tb_hs_get( $part, 'core/group', 'bwex-cost__grid' );
				$items = array();
				foreach ( $grid['innerBlocks'] ?? array() as $cell ) {
					$items[] = array(
						'text' => bwe_tb_hs_inner( bwe_tb_hs_get( $cell, 'core/paragraph' ) ),
						'wrap' => (string) $cell['attrs']['className'],
					);
				}
				$values     = array(
					'title'    => bwe_tb_hs_inner( bwe_tb_hs_get( $part, 'core/heading' ) ),
					'items'    => $items,
					'metadata' => bwe_tb_hs_meta( 'Cost explainer' ),
				);
				$children[] = bwe_tb_leaf_block( 'bwe/cost-panel', bwe_tb_hs_attrs( 'cost-panel', $values ) );
			} else {
				return false;
			}
		}
		$values = $head + array(
			'more'          => $more,
			'headElementId' => bwe_tb_hs_head_element_id( $block ),
			'sectionId'     => (string) ( $block['attrs']['anchor'] ?? '' ),
			'metadata'      => bwe_tb_hs_meta( 'Pricing' ),
		);
		return bwe_tb_block_with_children( 'bwe/pricing', bwe_tb_hs_attrs( 'pricing', $values, $block ), $children );
	}

	// How it works.
	if ( bwe_tb_hs_has( $block, 'elementor-element-8fdfd26 bwex-process' ) ) {
		$head  = bwe_tb_hs_head( $block );
		$steps = bwe_tb_hs_get( $block, 'bwe/steps' );
		if ( ! $head || ! $steps || ! empty( $steps['attrs']['modifiers'] ) ) {
			return false;
		}
		$values = $head + array(
			'sectionId'     => (string) ( $block['attrs']['anchor'] ?? '' ),
			'headElementId' => bwe_tb_hs_head_element_id( $block ),
			'metadata'      => bwe_tb_hs_meta( 'How it works' ),
		);
		return bwe_tb_block_with_children( 'bwe/process', bwe_tb_hs_attrs( 'process', $values, $block ), $steps['innerBlocks'] );
	}

	// Our products.
	if ( bwe_tb_hs_has( $block, 'elementor-element-d09262e bwex-work' ) ) {
		$head = bwe_tb_hs_head( $block );
		if ( ! $head ) {
			return false;
		}
		$cards = array();
		foreach ( bwe_tb_hs_all( $block, static fn( $b ) => 'core/group' === $b['blockName'] && bwe_tb_hs_has( $b, 'elementor-widget-bwex-plugin-card' ) ) as $wrap ) {
			$art   = bwe_tb_hs_get( $wrap, 'bwe/product-art' );
			$card  = bwe_tb_hs_get( $wrap, 'core/group', 'bwex-card' );
			$links = bwe_tb_hs_inner( bwe_tb_hs_get( $wrap, 'core/paragraph', 'bwex-card__links' ) );
			if ( ! $art || ! $card || ! preg_match( '#^<span>(.*?)</span>\s*(.*)$#s', $links, $l ) ) {
				return false;
			}
			$variant = (string) ( $art['attrs']['variant'] ?? 'reels' );
			if ( ! bwe_tb_hs_has( $card, 'bwex-card--' . $variant ) ) {
				return false;
			}
			[ $url, $text ] = bwe_tb_hs_button( bwe_tb_hs_get( $wrap, 'core/button', 'bwex-card__btn' ) );
			$card_name     = bwe_tb_hs_inner( bwe_tb_hs_get( $wrap, 'core/heading' ) );
			$values        = array(
				'art'         => $variant,
				'tag'         => bwe_tb_hs_inner( bwe_tb_hs_get( $wrap, 'core/paragraph', 'bwex-card__tag' ) ),
				'name'        => $card_name,
				'text'        => bwe_tb_hs_inner( bwe_tb_hs_get( bwe_tb_hs_get( $wrap, 'core/group', 'bwex-card__text' ) ?? array(), 'core/paragraph' ) ),
				'linksLabel'  => $l[1],
				'links'       => $l[2],
				'btnText'     => $text,
				'btnUrl'      => $url,
				'wrapClasses' => (string) $wrap['attrs']['className'],
				'metadata'    => bwe_tb_hs_meta( 'Product: ' . bwe_tb_hs_label( $card_name ) ),
			);
			$cards[]       = bwe_tb_leaf_block( 'bwe/product-card', bwe_tb_hs_attrs( 'product-card', $values ) );
		}
		$more   = bwe_tb_hs_get( $block, 'core/group', 'elementor-element-6fc4e95 bwex-more' );
		$values = $head + array(
			'more'      => $more ? bwe_tb_hs_inner( bwe_tb_hs_get( $more, 'core/paragraph' ) ) : '',
			'sectionId' => (string) ( $block['attrs']['anchor'] ?? '' ),
			'metadata'  => bwe_tb_hs_meta( 'Our products' ),
		);
		return $cards ? bwe_tb_block_with_children( 'bwe/products', bwe_tb_hs_attrs( 'products', $values, $block ), $cards ) : false;
	}

	// FAQ.
	if ( bwe_tb_hs_has( $block, 'elementor-element-bfd7b46 bwex-faq-section' ) ) {
		$head = bwe_tb_hs_head( $block );
		$list = bwe_tb_hs_get( $block, 'core/group', 'bwex-faq' );
		if ( ! $head || ! $list ) {
			return false;
		}
		$ask_btn                = bwe_tb_hs_get( $block, 'core/button', 'bwex-btn' );
		[ $ask_url, $ask_text ] = bwe_tb_hs_button( $ask_btn );
		[ , $toggle ]           = bwe_tb_hs_button( bwe_tb_hs_get( $block, 'core/button', 'bwex-faq__toggle' ) );
		$hidden                 = count( array_filter( $list['innerBlocks'], static fn( $b ) => ! empty( $b['attrs']['extra'] ) ) );
		$auto                   = sprintf( 1 === $hidden ? 'Show %d more question' : 'Show %d more questions', $hidden );
		$values                 = $head + array(
			'askText'    => $ask_text,
			'askUrl'     => $ask_url,
			'showAsk'    => '' !== $ask_text,
			'askNewTab'  => $ask_btn && false !== strpos( $ask_btn['innerHTML'], ' target="_blank" rel="noreferrer noopener"' ),
			'toggleText' => ( '' === $toggle || $toggle === $auto ) ? '' : $toggle,
			'listId'        => (string) ( $list['attrs']['anchor'] ?? '' ),
			'sectionId'     => (string) ( $block['attrs']['anchor'] ?? '' ),
			'headElementId' => bwe_tb_hs_head_element_id( $block ),
			'metadata'      => bwe_tb_hs_meta( 'FAQ' ),
		);
		return bwe_tb_block_with_children( 'bwe/faq', bwe_tb_hs_attrs( 'faq', $values, $block ), $list['innerBlocks'] );
	}

	return null;
}
