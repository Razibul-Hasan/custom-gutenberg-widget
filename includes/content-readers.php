<?php
/**
 * Code that reads a page's raw content — the FAQPage schema (BestWebExpert Home bwe_bwe_details_faq()), Rank Math's
 * <head> (time to read, og:image) and the stylesheet markers — was written for the core-block markup these blocks
 * replaced. Our blocks keep their text in attributes, so for those readers each block is swapped back for markup:
 * - FAQ questions: the exact core Details markup they had (the schema regex and its answer text depend on it);
 * - the other blocks: their rendered HTML (same words and classes).
 * The editor's Rank Math analysis gets the same treatment in JavaScript (text taken from the attributes).
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * Filter for bwe_post_content_expanded (BestWebExpert Home).
 *
 * @param string $content Expanded content.
 */
function bwe_gw_content_for_readers( $content ) {
	if ( false === strpos( (string) $content, '<!-- wp:bwe/' ) ) {
		return $content;
	}
	return serialize_blocks( bwe_gw_readers_tree( parse_blocks( $content ) ) );
}
add_filter( 'bwe_post_content_expanded', 'bwe_gw_content_for_readers' );

/**
 * Replaces our blocks (at any depth) with plain markup.
 *
 * @param array $blocks Parsed blocks.
 */
function bwe_gw_readers_tree( array $blocks ) {
	foreach ( $blocks as $i => $block ) {
		$name = (string) ( $block['blockName'] ?? '' );
		if ( 'bwe/faq-item' === $name ) {
			$html = bwe_gw_faq_core_markup( $block );
		} elseif ( in_array( $name, BWE_GW_READER_SECTIONS, true ) ) {
			$html = bwe_gw_section_reader_markup( $block );
		} elseif ( 'bwe/platforms' === $name ) {
			$html = bwe_gw_platforms_markup( $block );
		} elseif ( in_array( $name, array( 'bwe/section-head', 'bwe/spec-list', 'bwe/price-list', 'bwe/who-list', 'bwe/steps', 'bwe/hero', 'bwe/services' ), true ) ) {
			// A line break between adjacent tags, as the saved block markup had: stripped of tags, "FAQ" and the
			// heading stay two words instead of "FAQFrequently" (Rank Math counts words for the reading time).
			$html = preg_replace( '/>\s*</', ">\n<", render_block( $block ) );
			// Inside a service tile the saved list item had no breaks (Rank Math counted e.g. "WordPressCustom" as
			// one word); keep that, so the reading time stays exactly what it was.
			$html = preg_replace_callback( '#<li class="bwex-svc__item.*?</li>#s', static fn( $m ) => str_replace( "\n", '', $m[0] ), $html );
		} else {
			if ( ! empty( $block['innerBlocks'] ) ) {
				$blocks[ $i ]['innerBlocks'] = bwe_gw_readers_tree( $block['innerBlocks'] );
			}
			continue;
		}
		$blocks[ $i ] = array(
			'blockName'    => null,
			'attrs'        => array(),
			'innerBlocks'  => array(),
			'innerHTML'    => $html,
			'innerContent' => array( $html ),
		);
	}
	return $blocks;
}

/**
 * Home section blocks (and their items) the readers get as markup.
 */
const BWE_GW_READER_SECTIONS = array(
	'bwe/why-us',
	'bwe/spec-card',
	'bwe/testimonials',
	'bwe/video-card',
	'bwe/pricing',
	'bwe/plans',
	'bwe/price-plan',
	'bwe/starting-prices',
	'bwe/cost-panel',
	'bwe/process',
	'bwe/step',
	'bwe/products',
	'bwe/product-card',
	'bwe/faq',
	'bwe/cta',
	'bwe/price-section',
	'bwe/price-card',
	'bwe/work',
	'bwe/work-item',
	'bwe/contact-form',
	'bwe/about',
);

/**
 * A section block as markup for the readers: its own HTML (rendered in readers mode: the video embeds stay plain
 * links and nothing is enqueued), with its items passed through the readers again — so FAQ questions inside keep
 * their core Details markup (FAQPage schema) and lists stay saved markup.
 *
 * @param array $block Parsed block.
 */
function bwe_gw_section_reader_markup( array $block ) {
	$mark = '<!--bwe-gw-readers-children-->';
	$was  = $GLOBALS['bwe_gw_readers'] ?? null;

	$GLOBALS['bwe_gw_readers'] = true;
	$shell                     = $block;
	if ( ! empty( $block['innerBlocks'] ) ) {
		$shell['innerContent'] = array( $mark ); // Children stay in innerBlocks (the FAQ counts its hidden ones) but are not rendered.
		$shell['innerHTML']    = $mark;
	}
	$html                      = preg_replace( '/>\s*</', ">\n<", render_block( $shell ) );
	$GLOBALS['bwe_gw_readers'] = $was;

	if ( ! empty( $block['innerBlocks'] ) ) {
		$html = str_replace( $mark, "\n" . serialize_blocks( bwe_gw_readers_tree( $block['innerBlocks'] ) ) . "\n", $html );
	}
	return $html;
}

/**
 * The core Details markup a FAQ question was saved as before it became bwe/faq-item.
 *
 * @param array $block Parsed bwe/faq-item block.
 */
function bwe_gw_faq_core_markup( array $block ) {
	$class  = 'bwex-faq__item' . ( empty( $block['attrs']['extra'] ) ? '' : ' bwex-faq__item--extra' );
	$answer = '';
	$child  = 0;
	foreach ( $block['innerContent'] as $chunk ) {
		$answer .= is_string( $chunk ) ? $chunk : serialize_block( $block['innerBlocks'][ $child++ ] );
	}
	return '<!-- wp:details {"className":"' . $class . '"} -->' . "\n"
		. '<details class="wp-block-details ' . $class . '"><summary><span class="bwex-faq__n" aria-hidden="true">' . esc_html( $block['attrs']['n'] ?? '01' ) . '</span>'
		. '<span class="bwex-faq__q">' . ( $block['attrs']['question'] ?? '' ) . '</span><span class="bwex-faq__icon" aria-hidden="true"></span></summary>'
		. '<!-- wp:group {"className":"bwex-faq__a"} -->' . "\n" . '<div class="wp-block-group bwex-faq__a">' . $answer . "</div>\n<!-- /wp:group --></details>\n<!-- /wp:details -->";
}

/**
 * Platform cards as plain markup for the readers, built without rendering the core Image / List / Button blocks
 * inside them: rendering those while the <head> is being built would queue their stylesheets earlier and change
 * the order of the page's CSS. Same words, links and image as the live cards.
 *
 * @param array $block Parsed bwe/platforms block.
 */
function bwe_gw_platforms_markup( array $block ) {
	$group = static fn( string $class, string $inner ): string => '<div class="wp-block-group ' . esc_attr( $class ) . '">' . $inner . '</div>';
	$cards = '';
	foreach ( $block['innerBlocks'] as $card ) {
		$a     = $card['attrs'] ?? array();
		$get   = static fn( string $key ): string => (string) ( $a[ $key ] ?? '' );
		$inner = '';
		if ( '' !== $get( 'imageUrl' ) ) {
			$id     = (int) ( $a['imageId'] ?? 0 );
			$inner .= $group( 'bwex-plat__img', '<img src="' . esc_url( $get( 'imageUrl' ) ) . '" alt="' . esc_attr( $get( 'imageAlt' ) ) . '"' . ( $id ? ' class="wp-image-' . $id . '"' : '' ) . '/>' );
		}
		if ( '' !== $get( 'chip' ) ) {
			$inner .= $group( 'bwex-plat__chipwrap', '<p class="bwex-plat__chip">' . $get( 'chip' ) . '</p>' );
		}
		$title  = '' !== $get( 'titleUrl' ) ? '<a href="' . esc_url( $get( 'titleUrl' ) ) . '">' . $get( 'title' ) . '</a>' : $get( 'title' );
		$inner .= $group( 'bwex-h3', '<h3 class="elementor-heading-title">' . $title . '</h3>' );
		if ( '' !== $get( 'text' ) ) {
			$inner .= $group( 'bwex-plat__text', '<p>' . $get( 'text' ) . '</p>' );
		}
		if ( ! empty( $card['innerBlocks'] ) ) {
			$inner .= $group( 'bwex-plat__list', serialize_blocks( $card['innerBlocks'] ) ); // The list's saved markup, not rendered.
		}
		$foot = ( '' !== $get( 'price' ) ? '<p class="bwex-plat__price">' . $get( 'price' ) . '</p>' : '' )
			. ( '' !== $get( 'btnText' ) ? '<div class="bwex-btn"><a href="' . esc_url( $get( 'btnUrl' ) ) . '">' . $get( 'btnText' ) . '</a></div>' : '' );
		if ( '' !== $foot ) {
			$inner .= $group( 'bwex-plat__foot', $foot );
		}
		$cards .= $group( (string) ( $a['wrapClasses'] ?? 'elementor-element elementor-widget elementor-widget-bwex-platform-card' ), $group( 'bwex-plat', $inner ) );
	}
	// A line break between adjacent tags, as for the other blocks (keeps words apart for Rank Math's word count).
	return preg_replace( '/>\s*</', ">\n<", $group( (string) ( $block['attrs']['classes'] ?? 'bwex-plats bwex-plats--3' ), $cards ) );
}

/**
 * Rank Math builds the <head> (time to read, og:image …) from the raw post_content. BestWebExpert Home swaps in the
 * expanded content (with our blocks as markup, above) while wp_head runs — but only on pages made of synced
 * patterns (<!-- wp:block -->). A page built straight from our blocks (no patterns) kept its raw content there, and
 * our blocks keep their text in attributes, so their words and images were invisible to Rank Math. This does the
 * same swap for those pages; pages with synced patterns are left to BestWebExpert Home. In memory only.
 *
 * @param bool $expand True to expand, false to restore.
 */
function bwe_gw_head_content( $expand ) {
	static $saved = array();
	if ( ! $expand ) {
		foreach ( $saved as $item ) {
			$item[0]->post_content = $item[1];
		}
		$saved = array();
		remove_filter( 'post_content', 'bwe_gw_head_content_field', 10 );
		return;
	}
	if ( ! is_singular() || ! function_exists( 'bwe_post_content_expanded' ) ) {
		return;
	}
	$id = (int) get_queried_object_id();
	global $wp_query, $post;
	$objects = array_merge( array( get_queried_object(), $post, $wp_query->post ?? null ), (array) ( $wp_query->posts ?? array() ) );
	// The same post object is usually reached several ways (queried object, $post, the query's posts): swap each
	// object once, or its second visit would save the already-swapped content as the "original" to restore.
	foreach ( $objects as $obj ) {
		if ( ! $obj instanceof WP_Post || (int) $obj->ID !== $id || isset( $saved[ spl_object_id( $obj ) ] ) || ! bwe_gw_needs_head_content( $obj->post_content ) ) {
			continue;
		}
		$saved[ spl_object_id( $obj ) ] = array( $obj, $obj->post_content );
		$obj->post_content              = bwe_post_content_expanded( $id );
	}
	if ( $saved ) {
		add_filter( 'post_content', 'bwe_gw_head_content_field', 10, 2 );
	}
}
add_action( 'wp_head', fn() => bwe_gw_head_content( true ), -1000 );
add_action( 'wp_head', fn() => bwe_gw_head_content( false ), PHP_INT_MAX );

/**
 * Whether raw content needs the swap: our blocks, and no synced patterns (BestWebExpert Home handles those).
 *
 * @param string $content Raw post_content.
 */
function bwe_gw_needs_head_content( $content ) {
	$content = (string) $content;
	return false !== strpos( $content, '<!-- wp:bwe/' ) && false === strpos( $content, '<!-- wp:block ' );
}

/**
 * The queried page's post_content as Rank Math should read it (fresh get_post() calls, e.g. og:image).
 *
 * @param string $value   Field value.
 * @param int    $post_id Post ID.
 */
function bwe_gw_head_content_field( $value, $post_id ) {
	if ( (int) $post_id === (int) get_queried_object_id() && bwe_gw_needs_head_content( $value ) ) {
		return bwe_post_content_expanded( $post_id );
	}
	return $value;
}
