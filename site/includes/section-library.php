<?php
/**
 * Home-style section library (2026-11-21).
 *
 * Every function returns block markup for ONE self-contained section built from normal, editable core
 * blocks with Home's exact classes. Each section carries its own root wrappers (bwe-h2x / bwe-home bwex),
 * so it can be inserted anywhere, moved, duplicated or deleted as one block. The same functions build:
 * - the block patterns in the "BestWebExpert" pattern category (see bwe_sl_register_patterns()),
 * - the redesigned pages (tools/home-2/redesign-pages.php).
 *
 * Text arguments are trusted HTML (inline tags allowed). Section-specific front-end markup comes from
 * includes/block-markup.php (spec cards, numbered steps, buttons, FAQ toggle).
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * JSON for a block comment ("--" escaped like WordPress does).
 *
 * @param array $attrs Attributes.
 */
function bwe_sl_json( $attrs ) {
	return str_replace( '--', '--', wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
}

/**
 * Group block.
 *
 * @param string $class Class names.
 * @param string $inner Inner markup.
 * @param string $tag   Tag (div|section).
 * @param string $id    Anchor.
 */
function bwe_sl_group( $class, $inner, $tag = 'div', $id = '' ) {
	$a = array( 'className' => $class );
	if ( 'div' !== $tag ) {
		$a = array( 'tagName' => $tag ) + $a;
	}
	if ( $id ) {
		$a['anchor'] = $id;
	}
	return '<!-- wp:group ' . bwe_sl_json( $a ) . " -->\n<" . $tag . ( $id ? ' id="' . esc_attr( $id ) . '"' : '' ) . ' class="wp-block-group ' . $class . '">' . $inner . '</' . $tag . ">\n<!-- /wp:group -->";
}

/**
 * Paragraph block.
 *
 * @param string $html  Inner HTML.
 * @param string $class Class.
 */
function bwe_sl_p( $html, $class = '' ) {
	return '<!-- wp:paragraph' . ( $class ? ' ' . bwe_sl_json( array( 'className' => $class ) ) : '' ) . " -->\n<p" . ( $class ? ' class="' . $class . '"' : '' ) . '>' . $html . "</p>\n<!-- /wp:paragraph -->";
}

/**
 * Heading block.
 *
 * @param string $html  Inner HTML.
 * @param int    $level Level.
 * @param string $class Class.
 * @param string $id    Anchor.
 */
function bwe_sl_h( $html, $level = 2, $class = 'elementor-heading-title bwe-h2x-plain', $id = '' ) {
	$a = array();
	if ( 2 !== $level ) {
		$a['level'] = $level;
	}
	if ( $class ) {
		$a['className'] = $class;
	}
	if ( $id ) {
		$a['anchor'] = $id;
	}
	return '<!-- wp:heading' . ( $a ? ' ' . bwe_sl_json( $a ) : '' ) . " -->\n<h" . $level . ( $id ? ' id="' . esc_attr( $id ) . '"' : '' ) . ' class="wp-block-heading' . ( $class ? ' ' . $class : '' ) . '">' . $html . '</h' . $level . ">\n<!-- /wp:heading -->";
}

/**
 * List block.
 *
 * @param array  $items Item HTML.
 * @param string $class Class.
 */
function bwe_sl_list( $items, $class = 'bwex-checks' ) {
	$li = array();
	foreach ( $items as $it ) {
		$li[] = "<!-- wp:list-item -->\n<li>" . $it . "</li>\n<!-- /wp:list-item -->";
	}
	return '<!-- wp:list ' . bwe_sl_json( array( 'className' => $class ) ) . " -->\n" . '<ul class="wp-block-list ' . $class . '">' . implode( "\n\n", $li ) . "</ul>\n<!-- /wp:list -->";
}

/**
 * One button inside a raw buttons wrapper (prints Home's elementor button markup).
 *
 * @param string $text  Text.
 * @param string $href  Link.
 * @param string $class Wrapper class (bwex-btn, bwex-btn bwex-btn--fill, bwex-card__btn, bwex-faq__toggle, bwe-btn …).
 */
function bwe_sl_button( $text, $href, $class = 'bwex-btn' ) {
	$ext = 0 === strpos( $href, 'http' ) && false === strpos( $href, wp_parse_url( home_url(), PHP_URL_HOST ) );
	$a   = array( 'className' => $class );
	$x   = '';
	if ( $ext ) {
		$a['linkTarget'] = '_blank';
		$a['rel']        = 'noreferrer noopener';
		$x               = ' target="_blank" rel="noreferrer noopener"';
	}
	return '<!-- wp:buttons {"className":"bwe-btns-raw"} -->' . "\n" . '<div class="wp-block-buttons bwe-btns-raw"><!-- wp:button ' . bwe_sl_json( $a ) . " -->\n"
		. '<div class="wp-block-button ' . $class . '"><a class="wp-block-button__link wp-element-button" href="' . esc_attr( $href ) . '"' . $x . '>' . $text . "</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->";
}

/**
 * Root wrappers every section sits in (Home's page root + container), so Home's CSS applies anywhere.
 *
 * @param string $inner Section markup.
 * @param string $extra Extra root class.
 */
function bwe_sl_root( $inner, $extra = '' ) {
	return '<!-- wp:group ' . bwe_sl_json( array( 'align' => 'full', 'className' => trim( 'elementor elementor-517 bwe-h2x bwe-sec ' . $extra ) ) ) . " -->\n"
		. '<div class="wp-block-group alignfull ' . trim( 'elementor elementor-517 bwe-h2x bwe-sec ' . $extra ) . '">'
		. bwe_sl_group( 'elementor-element elementor-element-1001dd3 e-con-full bwe-home bwex e-flex e-con e-parent', $inner )
		. "</div>\n<!-- /wp:group -->";
}

/**
 * Section heading block (eyebrow, H2, intro) — Home's "section head" widget.
 *
 * @param array $a eyebrow, title, intro, split (bool), h2id (heading anchor).
 */
function bwe_sl_head( $a ) {
	// "Section header" block from the Best Web Expert Gutenberg Widget plugin (same nested markup as before).
	$attrs = array(
		'eyebrow' => $a['eyebrow'] ?? '',
		'title'   => $a['title'] ?? '',
	);
	if ( ! empty( $a['h2id'] ) ) {
		$attrs['headingId'] = $a['h2id'];
	}
	if ( ! empty( $a['intro'] ) ) {
		$attrs['intro'] = $a['intro'];
	}
	if ( isset( $a['split'] ) && ! $a['split'] ) {
		$attrs['split'] = false;
	}
	return bwe_sl_group(
		'elementor-element elementor-widget elementor-widget-bwex-section-head',
		bwe_sl_group( 'elementor-widget-container', '<!-- wp:bwe/section-head ' . serialize_block_attributes( $attrs ) . ' /-->' )
	);
}

/**
 * Hero (Home's dark hero; background from Customizer → Hero Background).
 *
 * @param array $a pill [text, href] (optional), kicker, title (em = highlighted), lead, buttons [[text, href], [text, href]], scroll (#id).
 */
function bwe_sl_hero( $a ) {
	$copy = '';
	if ( ! empty( $a['pill'][0] ) ) {
		$copy .= bwe_sl_p( '<a href="' . esc_attr( $a['pill'][1] ?? '#' ) . '">' . $a['pill'][0] . '</a>', 'bwe-pill' ) . "\n\n";
	}
	if ( ! empty( $a['kicker'] ) ) {
		$copy .= bwe_sl_p( $a['kicker'], 'bwe-kicker' ) . "\n\n";
	}
	$copy .= bwe_sl_h( $a['title'], 1, 'elementor-heading-title bwe-hero__title' ) . "\n\n";
	if ( ! empty( $a['lead'] ) ) {
		$copy .= bwe_sl_p( $a['lead'], 'bwe-lead' ) . "\n\n";
	}
	$btns = array();
	foreach ( array_values( $a['buttons'] ?? array() ) as $i => $b ) {
		$cls    = $i ? 'bwe-btn bwex-hero__link bwex-hero__btn2' : 'bwe-btn bwe-btn--primary';
		$ext    = 0 === strpos( $b[1], 'http' ) && false === strpos( $b[1], wp_parse_url( home_url(), PHP_URL_HOST ) );
		$attrs  = array( 'className' => $cls ) + ( $ext ? array( 'linkTarget' => '_blank', 'rel' => 'noreferrer noopener' ) : array() );
		$btns[] = '<!-- wp:button ' . bwe_sl_json( $attrs ) . " -->\n" . '<div class="wp-block-button ' . $cls . '"><a class="wp-block-button__link wp-element-button" href="' . esc_attr( $b[1] ) . '"' . ( $ext ? ' target="_blank" rel="noreferrer noopener"' : '' ) . '>' . $b[0] . "</a></div>\n<!-- /wp:button -->";
	}
	if ( $btns ) {
		$copy .= '<!-- wp:buttons {"className":"bwe-actions"} -->' . "\n" . '<div class="wp-block-buttons bwe-actions">' . implode( "\n\n", $btns ) . "</div>\n<!-- /wp:buttons -->";
	}
	if ( ! empty( $a['extra'] ) ) {
		$copy .= "\n\n" . $a['extra']; // Serialized blocks under the buttons (e.g. jump links, a meta line).
	}
	$section = bwe_sl_group( 'bwe-hero__copy', $copy );
	if ( ! empty( $a['scroll'] ) ) {
		$section .= "\n\n" . bwe_sl_p( '<a href="' . esc_attr( $a['scroll'] ) . '">Scroll</a>', 'bwex-scroll-wrap' );
	}
	$hero = bwe_sl_group( 'bwe-section bwe-hero bwe-hero--no-visual bwe-hero--paper bwex-hero bwe-hero--night', $section, 'section' );
	return '<!-- wp:group ' . bwe_sl_json( array( 'align' => 'full', 'className' => 'elementor elementor-517 bwe-h2x bwe-page-hero' ) ) . " -->\n"
		. '<div class="wp-block-group alignfull elementor elementor-517 bwe-h2x bwe-page-hero">' . bwe_sl_group( 'bwe-home bwex bwex-hero-scope', $hero ) . "</div>\n<!-- /wp:group -->";
}

/**
 * Card grid (Home's "why us" bento): name, text, optional chip per card.
 *
 * @param array $a anchor, eyebrow, title, intro, items [[name, text, chip]], foot (HTML line under the grid), soft (bool).
 */
function bwe_sl_cards( $a ) {
	// "Spec cards" + "Spec card" blocks from the Best Web Expert Gutenberg Widget plugin (same <ul>/<li> markup).
	$cards = array();
	foreach ( $a['items'] as $it ) {
		$attrs = array(
			'name' => $it[0],
			'text' => $it[1],
		);
		if ( ! empty( $it[2] ) ) {
			$attrs['chip'] = $it[2];
		}
		$cards[] = '<!-- wp:bwe/spec-card ' . serialize_block_attributes( $attrs ) . ' /-->';
	}
	$body = "<!-- wp:bwe/spec-list -->\n" . implode( "\n\n", $cards ) . "\n<!-- /wp:bwe/spec-list -->";
	if ( ! empty( $a['foot'] ) ) {
		$body .= "\n\n" . bwe_sl_group( 'bwex-spec__foot', bwe_sl_p( $a['foot'], 'bwex-spec__aside' ) );
	}
	$head  = bwe_sl_head( $a );
	$soft  = ! isset( $a['soft'] ) || $a['soft'];
	$inner = bwe_sl_group( 'bwex-wrap', $head . "\n\n" . bwe_sl_group( 'bwex-spec__body', $body ) );
	$sec   = bwe_sl_group( 'bwex-section bwex-spec' . ( $soft ? ' bwex-section--soft' : '' ), $inner, 'section', $a['anchor'] ?? '' );
	return bwe_sl_root(
		bwe_sl_group( 'elementor-element elementor-element-ce6cb54 elementor-widget elementor-widget-bwex-spec', bwe_sl_group( 'elementor-widget-container', bwe_sl_group( 'bwex bwex-specw' . ( $soft ? ' bwex-specw--soft' : '' ), $sec ) ) )
	);
}

/**
 * Price plans (Home's #pricing cards).
 *
 * @param array $a anchor, eyebrow, title, intro, plans [[title, price, per, desc, [items], btn_text, btn_href, featured(bool), badge]], note (HTML).
 */
function bwe_sl_plans( $a ) {
	$ids   = array( 'e382fb3', '20cd1e3', 'e6a1073', 'e6a1074' );
	$cards = array();
	foreach ( array_values( $a['plans'] ) as $i => $p ) {
		$feat  = ! empty( $p[7] );
		$inner = $feat ? bwe_sl_group( 'bwex-plan__badgewrap', bwe_sl_p( $p[8] ?? 'Most popular', 'bwex-plan__badge' ) ) . "\n\n" : '';
		$inner .= bwe_sl_group( 'bwex-h3', bwe_sl_h( $p[0], 3 ) ) . "\n\n";
		$inner .= bwe_sl_p( $p[1] . ( $p[2] ? ' <em>' . $p[2] . '</em>' : '' ), 'bwex-plan__price' ) . "\n\n";
		$inner .= bwe_sl_p( $p[3], 'bwex-plan__desc' ) . "\n\n";
		$inner .= bwe_sl_group( 'bwex-plan__list', bwe_sl_list( $p[4] ) ) . "\n\n";
		$cls    = $feat ? 'bwe-btn bwe-btn--primary' : 'bwe-btn';
		$inner .= '<!-- wp:buttons {"className":"bwex-plan__btns"} -->' . "\n" . '<div class="wp-block-buttons bwex-plan__btns"><!-- wp:button ' . bwe_sl_json( array( 'className' => $cls ) ) . " -->\n"
			. '<div class="wp-block-button ' . $cls . '"><a class="wp-block-button__link wp-element-button" href="' . esc_attr( $p[6] ) . '">' . $p[5] . "</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->";
		$id      = $ids[ $i ] ?? 'e6a1074';
		$cards[] = bwe_sl_group(
			'elementor-element elementor-element-' . $id . ' elementor-widget elementor-widget-bwex-pricing-plan',
			bwe_sl_group( 'elementor-widget-container', bwe_sl_group( 'bwex bwex-planw', bwe_sl_group( 'bwex-plan' . ( $feat ? ' bwex-plan--featured' : '' ), $inner ) ) )
		);
	}
	$wrap = bwe_sl_head( $a ) . "\n\n" . bwe_sl_group( 'elementor-element elementor-element-e077279 e-con-full bwex-plans e-flex e-con e-child', implode( "\n\n", $cards ) );
	if ( ! empty( $a['note'] ) ) {
		$wrap .= "\n\n" . bwe_sl_p( $a['note'], 'bwex-more' );
	}
	return bwe_sl_root(
		bwe_sl_group( 'elementor-element elementor-element-74d01ef e-con-full bwex-section bwex-pricing e-flex e-con e-child', bwe_sl_group( 'elementor-element elementor-element-d60292a e-con-full bwex-wrap e-flex e-con e-child', $wrap ), 'section', $a['anchor'] ?? 'pricing' )
	);
}

/**
 * How it works (Home's dark numbered steps).
 *
 * @param array $a anchor, eyebrow, title, steps [[title, text]].
 */
function bwe_sl_steps( $a ) {
	// "Numbered steps" + "Step" blocks from the Best Web Expert Gutenberg Widget plugin (same <ol>/<li> markup).
	$items = array();
	foreach ( array_values( $a['steps'] ) as $i => $s ) {
		$items[] = '<!-- wp:bwe/step ' . serialize_block_attributes(
			array(
				'n'     => sprintf( '%02d', $i + 1 ),
				'title' => $s[0],
				'text'  => $s[1],
			)
		) . ' /-->';
	}
	$steps = "<!-- wp:bwe/steps -->\n" . implode( "\n\n", $items ) . "\n<!-- /wp:bwe/steps -->";
	$list  = bwe_sl_group( 'elementor-element elementor-element-847773d elementor-widget elementor-widget-bwex-numbered-list', bwe_sl_group( 'elementor-widget-container', $steps ) );
	$head = bwe_sl_head( array( 'split' => false ) + $a );
	return bwe_sl_root(
		bwe_sl_group( 'elementor-element elementor-element-8fdfd26 e-con-full bwex-section bwex-section--dark bwex-process e-flex e-con e-child', bwe_sl_group( 'elementor-element elementor-element-de37328 e-con-full bwex-wrap e-flex e-con e-child', $head . "\n\n" . $list ), 'section', $a['anchor'] ?? 'process' )
	);
}

/**
 * FAQ (Home's split FAQ: intro + questions; more than 6 → "Show N more").
 *
 * @param array $a anchor, eyebrow, title, intro, button [text, href], items [[question, answer HTML]], list_id.
 */
function bwe_sl_faq( $a ) {
	$list_id = $a['list_id'] ?? 'bwex-faq-' . substr( md5( $a['title'] ), 0, 7 );
	$shown   = 6;
	$items   = array();
	foreach ( array_values( $a['items'] ) as $i => $q ) {
		// "FAQ question" block from the Best Web Expert Gutenberg Widget plugin (prints the same Details markup).
		$attrs = array(
			'n'        => sprintf( '%02d', $i + 1 ),
			'question' => $q[0],
		);
		if ( $i >= $shown ) {
			$attrs['extra'] = true;
		}
		$answer  = preg_match( '/^\s*<!-- wp:/', $q[1] ) ? $q[1] : bwe_sl_p( $q[1] );
		$items[] = '<!-- wp:bwe/faq-item ' . serialize_block_attributes( $attrs ) . " -->\n" . $answer . "\n<!-- /wp:bwe/faq-item -->";
	}
	$more  = count( $items ) - $shown;
	$list  = bwe_sl_group( 'bwex-faq', implode( "\n\n", $items ), 'div', $list_id );
	$list .= $more > 0 ? "\n\n" . bwe_sl_button( 'Show ' . $more . ' more question' . ( 1 === $more ? '' : 's' ), '#' . $list_id, 'bwex-faq__toggle' ) : '';
	$intro = bwe_sl_head( array( 'split' => false, 'intro' => $a['intro'] ?? '' ) + $a );
	if ( ! empty( $a['button'] ) ) {
		$intro .= "\n\n" . bwe_sl_button( $a['button'][0], $a['button'][1], 'elementor-element elementor-element-90a6427 bwex-btn elementor-widget elementor-widget-button' );
	}
	$grid = bwe_sl_group( 'elementor-element elementor-element-9e568fa e-con-full bwex-faq__intro e-flex e-con e-child', $intro ) . "\n\n"
		. bwe_sl_group( 'elementor-element elementor-element-5eb4cba elementor-widget elementor-widget-bwex-faq', bwe_sl_group( 'elementor-widget-container', $list ) );
	return bwe_sl_root(
		bwe_sl_group(
			'elementor-element elementor-element-bfd7b46 e-con-full bwex-section bwex-faq-section e-flex e-con e-child',
			bwe_sl_group( 'elementor-element elementor-element-4652c6c e-con-full bwex-wrap e-flex e-con e-child', bwe_sl_group( 'elementor-element elementor-element-17f5218 e-con-full bwex-faq__grid e-flex e-con e-child', $grid ) ),
			'section',
			$a['anchor'] ?? 'faq'
		)
	);
}

/**
 * About (Home's text + checklist card).
 *
 * @param array $a anchor, eyebrow, title, lead, paras [HTML], card_title, checks [HTML], button [text, href].
 */
function bwe_sl_about( $a ) {
	$copy = bwe_sl_group( 'elementor-element elementor-element-5fa24d3 bwex-eyebrow elementor-widget elementor-widget-text-editor', bwe_sl_p( $a['eyebrow'] ) ) . "\n\n"
		. bwe_sl_group( 'elementor-element elementor-element-e4e543b bwex-h2 elementor-widget elementor-widget-heading', bwe_sl_h( $a['title'], 2, 'elementor-heading-title elementor-size-default bwe-h2x-plain' ) ) . "\n\n"
		. bwe_sl_group( 'elementor-element elementor-element-5d9fa0f bwex-about__lead elementor-widget elementor-widget-text-editor', bwe_sl_p( $a['lead'] ) );
	if ( ! empty( $a['paras'] ) ) {
		$ps    = implode( "\n\n", array_map( static fn( $p ) => bwe_sl_p( $p, 'bwex-about__text' ), $a['paras'] ) );
		$copy .= "\n\n" . bwe_sl_group( 'elementor-element elementor-element-b6a1f79 bwex-about__more elementor-widget elementor-widget-bwex-read-more', bwe_sl_group( 'elementor-widget-container', bwe_sl_group( 'bwex bwex-readmorew', $ps ) ) );
	}
	if ( ! empty( $a['images'] ) ) {
		$copy .= "\n\n" . bwe_sl_group( 'bwex-about__shots', $a['images'] );
	}
	$card = bwe_sl_group( 'elementor-element elementor-element-5ea19df bwex-h3 elementor-widget elementor-widget-heading', bwe_sl_h( $a['card_title'], 3, 'elementor-heading-title elementor-size-default bwe-h2x-plain' ) ) . "\n\n"
		. bwe_sl_group( 'elementor-element elementor-element-fd2f254 elementor-widget elementor-widget-bwex-check-list', bwe_sl_group( 'elementor-widget-container', bwe_sl_group( 'bwex bwex-checksw', bwe_sl_list( $a['checks'] ) ) ) );
	if ( ! empty( $a['button'] ) ) {
		$card .= "\n\n" . bwe_sl_button( $a['button'][0], $a['button'][1], 'elementor-element elementor-element-46d77b3 bwex-btn bwex-btn--fill elementor-widget elementor-widget-button' );
	}
	$grid = bwe_sl_group( 'elementor-element elementor-element-929d0d7 e-con-full bwex-about__copy e-flex e-con e-child', $copy ) . "\n\n"
		. bwe_sl_group( 'elementor-element elementor-element-90925e9 e-con-full bwex-about__card e-flex e-con e-child', $card );
	return bwe_sl_root(
		bwe_sl_group(
			'elementor-element elementor-element-84190b5 e-con-full bwex-section bwex-section--soft bwex-about e-flex e-con e-child',
			bwe_sl_group( 'elementor-element elementor-element-2f9aa12 e-con-full bwex-wrap e-flex e-con e-child', bwe_sl_group( 'elementor-element elementor-element-44e1935 e-con-full bwex-about__grid e-flex e-con e-child', $grid ) ),
			'section',
			$a['anchor'] ?? 'about'
		)
	);
}

/**
 * Platform cards (Home's "WordPress & Shopify experts" cards): chip, title link, text, link list, price, button.
 *
 * @param array $a anchor, eyebrow, title, intro, cards [[chip, title, href, text, [links HTML], price HTML, btn_text, btn_href, img_id]], soft.
 */
function bwe_sl_platforms( $a ) {
	$cards = array();
	foreach ( array_values( $a['cards'] ) as $i => $c ) {
		$inner = '';
		if ( ! empty( $c[8] ) ) {
			$src    = wp_get_attachment_image_url( (int) $c[8], 'large' );
			$alt    = (string) get_post_meta( (int) $c[8], '_wp_attachment_image_alt', true );
			$inner .= bwe_sl_group( 'bwex-plat__img', '<!-- wp:image ' . bwe_sl_json( array( 'id' => (int) $c[8], 'sizeSlug' => 'large', 'linkDestination' => 'none', 'className' => 'bwe-raw-img' ) ) . " -->\n" . '<figure class="wp-block-image size-large bwe-raw-img"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" class="wp-image-' . (int) $c[8] . "\"/></figure>\n<!-- /wp:image -->" ) . "\n\n";
		}
		$inner .= bwe_sl_group( 'bwex-plat__chipwrap', bwe_sl_p( $c[0], 'bwex-plat__chip' ) ) . "\n\n";
		$inner .= bwe_sl_group( 'bwex-h3', bwe_sl_h( $c[2] ? '<a href="' . esc_attr( $c[2] ) . '">' . $c[1] . '</a>' : $c[1], 3 ) ) . "\n\n";
		$inner .= bwe_sl_group( 'bwex-plat__text', bwe_sl_p( $c[3] ) ) . "\n\n";
		if ( ! empty( $c[4] ) ) {
			$inner .= bwe_sl_group( 'bwex-plat__list', bwe_sl_list( $c[4] ) ) . "\n\n";
		}
		$foot    = ( $c[5] ? bwe_sl_p( $c[5], 'bwex-plat__price' ) . "\n\n" : '' ) . ( $c[6] ? bwe_sl_button( $c[6], $c[7], 'bwex-btn' ) : '' );
		$inner  .= bwe_sl_group( 'bwex-plat__foot', $foot );
		$cards[] = bwe_sl_group( 'elementor-element elementor-element-plat' . $i . ' elementor-widget elementor-widget-bwex-platform-card', bwe_sl_group( 'elementor-widget-container', bwe_sl_group( 'bwex bwex-platw', bwe_sl_group( 'bwex-plat', $inner ) ) ) );
	}
	$n    = count( $cards );
	$wrap = bwe_sl_head( $a ) . "\n\n" . bwe_sl_group( 'elementor-element elementor-element-1de90ac e-con-full bwex-plats' . ( 0 === $n % 3 ? ' bwex-plats--3' : '' ) . ' e-flex e-con e-child', implode( "\n\n", $cards ) );
	if ( ! empty( $a['foot'] ) ) {
		$wrap .= "\n\n" . bwe_sl_p( $a['foot'], 'bwex-more' );
	}
	return bwe_sl_root(
		bwe_sl_group( 'elementor-element elementor-element-0334ad8 e-con-full bwex-section bwex-services e-flex e-con e-child', bwe_sl_group( 'elementor-element elementor-element-b51609b e-con-full bwex-wrap e-flex e-con e-child', $wrap ), 'section', $a['anchor'] ?? 'experts' )
	);
}

/**
 * Text section (legal pages, long copy): Home's wrap + readable prose; inner blocks are kept as they are.
 *
 * @param array $a anchor, blocks (serialized core blocks).
 */
function bwe_sl_text( $a ) {
	$inner = ! empty( $a['title'] ) ? bwe_sl_head( $a ) . "\n\n" : '';
	$inner .= bwe_sl_group( 'bwex-prose__body', $a['blocks'] );
	if ( ! empty( $a['foot'] ) ) {
		$inner .= "\n\n" . bwe_sl_p( $a['foot'], 'bwex-more' );
	}
	$soft  = ! empty( $a['soft'] ) ? ' bwex-section--soft' : '';
	$extra = ! empty( $a['class'] ) ? ' ' . $a['class'] : '';
	return bwe_sl_root( bwe_sl_group( 'bwex-section bwex-prose' . $soft . $extra, bwe_sl_group( 'bwex-wrap', $inner ), 'section', $a['anchor'] ?? 'content' ) );
}

/**
 * Media section: one or more large images (product screenshots) under a hero or between sections.
 *
 * @param array $a anchor, blocks (serialized image blocks).
 */
function bwe_sl_media( $a ) {
	return bwe_sl_root( bwe_sl_group( 'bwex-section bwex-media', bwe_sl_group( 'bwex-wrap', bwe_sl_group( 'bwex-media__body', $a['blocks'] ) ), 'section', $a['anchor'] ?? '' ) );
}

/**
 * Who it's for (Home's "Who we build for" link cards: title, text, tag, arrow).
 *
 * @param array $a anchor, eyebrow, title, intro, items [[title, text, tag, href]], soft (bool, default true).
 */
function bwe_sl_who( $a ) {
	// "Who we build for" + "Who card" blocks from the Best Web Expert Gutenberg Widget plugin (same <ol>/<li> markup).
	$items = array();
	foreach ( $a['items'] as $it ) {
		$items[] = '<!-- wp:bwe/who-card ' . serialize_block_attributes(
			array(
				'url'   => $it[3],
				'title' => $it[0],
				'text'  => $it[1],
				'tag'   => $it[2],
			)
		) . ' /-->';
	}
	$list = "<!-- wp:bwe/who-list -->\n" . implode( "\n\n", $items ) . "\n<!-- /wp:bwe/who-list -->";
	$list = bwe_sl_group( 'elementor-element elementor-element-538735e elementor-widget elementor-widget-bwex-who-list', bwe_sl_group( 'elementor-widget-container', bwe_sl_group( 'bwex bwex-whow', bwe_sl_group( 'bwex-who__body', $list ) ) ) );
	$soft = ! isset( $a['soft'] ) || $a['soft'];
	return bwe_sl_root(
		bwe_sl_group(
			'elementor-element elementor-element-1eb77b6 e-con-full bwex-section' . ( $soft ? ' bwex-section--soft' : '' ) . ' bwex-who e-flex e-con e-child',
			bwe_sl_group( 'elementor-element elementor-element-051d390 e-con-full bwex-wrap e-flex e-con e-child', bwe_sl_head( $a ) . "\n\n" . $list ),
			'section',
			$a['anchor'] ?? 'who'
		)
	);
}

/**
 * Screenshot tour: tabs on the left, one framed screenshot on the right (the tab picks it).
 * Pure core blocks: each tab is a group (number, name, text); each screenshot is an image block
 * in the same order. bwe_sl_tour_script() below wires them up.
 *
 * @param array $a anchor, eyebrow, title, intro, bar (URL bar prefix), items [[name, text, attachment id]], soft (bool).
 */
function bwe_sl_tour( $a ) {
	$tabs  = array();
	$shots = array();
	foreach ( array_values( $a['items'] ) as $i => $it ) {
		$tabs[] = bwe_sl_group( 'bwex-tour__tab', bwe_sl_p( sprintf( '%02d', $i + 1 ), 'bwex-tour__num' ) . "\n\n" . bwe_sl_p( $it[0], 'bwex-tour__name' ) . "\n\n" . bwe_sl_p( $it[1], 'bwex-tour__text' ) );
		$id     = (int) $it[2];
		$src    = wp_get_attachment_image_url( $id, 'large' );
		$full   = wp_get_attachment_image_url( $id, 'full' );
		$alt    = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
		if ( ! $src ) {
			continue;
		}
		$shots[] = '<!-- wp:image ' . bwe_sl_json( array( 'id' => $id, 'sizeSlug' => 'large', 'linkDestination' => 'media', 'className' => 'bwex-tour__shot' ) ) . " -->\n"
			. '<figure class="wp-block-image size-large bwex-tour__shot"><a href="' . esc_url( $full ) . '"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" class="wp-image-' . $id . "\"/></a></figure>\n<!-- /wp:image -->";
	}
	$frame = bwe_sl_p( $a['bar'] ?? 'wp-admin', 'bwex-tour__bar' ) . "\n\n" . implode( "\n\n", $shots );
	$tour  = bwe_sl_group( 'bwex-tour__tabs', implode( "\n\n", $tabs ) ) . "\n\n" . bwe_sl_group( 'bwex-tour__stage', bwe_sl_group( 'bwex-tour__frame', $frame ) );
	$soft  = ! isset( $a['soft'] ) || $a['soft'];
	return bwe_sl_root(
		bwe_sl_group(
			'bwex-section' . ( $soft ? ' bwex-section--soft' : '' ) . ' bwex-tour-section',
			bwe_sl_group( 'bwex-wrap', bwe_sl_head( $a ) . "\n\n" . bwe_sl_group( 'bwex-tour', $tour ) ),
			'section',
			$a['anchor'] ?? 'screenshots'
		)
	);
}

/**
 * Prints the screenshot-tour script on pages that have one (inline, so no optimizer combines or mangles it).
 * Tab i shows image i; the URL bar gets the tab's name; arrow keys move between tabs.
 */
function bwe_sl_tour_script() {
	if ( ! function_exists( 'bwe_home_is_needed' ) || ! bwe_home_is_needed( 'bwex-tour' ) ) {
		return;
	}
	$js = <<<'JS'
document.querySelectorAll('.bwex-tour').forEach(function (tour) {
	var tabs = tour.querySelectorAll('.bwex-tour__tab'), shots = tour.querySelectorAll('.bwex-tour__shot');
	var bar = tour.querySelector('.bwex-tour__bar'), base = bar ? bar.textContent.trim() : '';
	var row = tour.querySelector('.bwex-tour__tabs');
	if (!tabs.length || !shots.length) { return; }
	tour.classList.add('is-js');
	row.setAttribute('role', 'tablist');
	function pick(i, focus) {
		tabs.forEach(function (t, k) { t.classList.toggle('is-active', k === i); t.setAttribute('aria-selected', k === i ? 'true' : 'false'); t.tabIndex = k === i ? 0 : -1; });
		shots.forEach(function (s, k) { s.classList.toggle('is-active', k === i); });
		var img = shots[i] && shots[i].querySelector('img'); if (img) { img.loading = 'eager'; }
		if (bar) { bar.innerHTML = ''; bar.appendChild(document.createTextNode(base + ' › ')); var b = document.createElement('b'); b.textContent = tabs[i].querySelector('.bwex-tour__name').textContent; bar.appendChild(b); }
		if (focus) { tabs[i].focus(); }
		if (row.scrollWidth > row.clientWidth) { row.scrollTo({ left: tabs[i].offsetLeft - row.offsetLeft - 16, behavior: 'smooth' }); }
	}
	tabs.forEach(function (tab, i) {
		tab.setAttribute('role', 'tab');
		tab.addEventListener('click', function () { pick(i); });
		tab.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); pick(i); return; }
			var d = { ArrowDown: 1, ArrowRight: 1, ArrowUp: -1, ArrowLeft: -1 }[e.key];
			if (!d) { return; }
			e.preventDefault(); pick((i + d + tabs.length) % tabs.length, true);
		});
	});
	pick(0);
});
JS;
	wp_print_inline_script_tag( $js, array( 'id' => 'bwex-tour-js' ) );
}
add_action( 'wp_footer', 'bwe_sl_tour_script', 30 );

/**
 * Keeps SiteGround Optimizer from combining the tour script (its minifier has broken plugin JS live).
 *
 * @param array $excluded Substrings of inline scripts SG must leave alone.
 * @return array
 */
function bwe_sl_tour_sg_exclude( $excluded ) {
	$excluded[] = '.bwex-tour';
	return $excluded;
}
add_filter( 'sgo_javascript_combine_excluded_inline_content', 'bwe_sl_tour_sg_exclude' );

/**
 * Showcase: Home's section head plus any blocks (a live ProductReels widget, an image strip …).
 *
 * @param array $a anchor, eyebrow, title, intro, h2id, blocks (serialized), soft, dark, bleed (blocks run edge to edge),
 *                 side (copy left, blocks right), extra (serialized blocks under the head), foot (HTML line).
 */
function bwe_sl_showcase( $a ) {
	$side  = ! empty( $a['side'] );
	// No title = no head (a block that prints its own heading, like the ProductBoxes builder).
	$head  = ! empty( $a['title'] ) ? bwe_sl_head( ( $side ? array( 'split' => false ) : array() ) + $a ) : '';
	$head .= ! empty( $a['extra'] ) ? "\n\n" . $a['extra'] : '';
	$foot  = ! empty( $a['foot'] ) ? bwe_sl_p( $a['foot'], 'bwex-showcase__best' ) : '';
	$body  = bwe_sl_group( 'bwex-showcase__body', $a['blocks'] );
	if ( $side ) {
		$inner = bwe_sl_group( 'bwex-wrap', bwe_sl_group( 'bwex-showcase__grid', bwe_sl_group( 'bwex-showcase__copy', $head . ( $foot ? "\n\n" . $foot : '' ) ) . "\n\n" . $body ) );
	} elseif ( ! empty( $a['bleed'] ) ) {
		$inner = bwe_sl_group( 'bwex-wrap', $head . ( $foot ? "\n\n" . $foot : '' ) ) . "\n\n" . bwe_sl_group( 'bwex-showcase__body bwex-showcase__body--bleed', $a['blocks'] );
	} else {
		$inner = bwe_sl_group( 'bwex-wrap', $head . "\n\n" . $body . ( $foot ? "\n\n" . $foot : '' ) );
	}
	$cls = 'bwex-section bwex-showcase' . ( ! empty( $a['soft'] ) ? ' bwex-section--soft' : '' ) . ( ! empty( $a['dark'] ) ? ' bwex-showcase--dark' : '' ) . ( $side ? ' bwex-showcase--side' : '' );
	return bwe_sl_root( bwe_sl_group( $cls, $inner, 'section', $a['anchor'] ?? '' ) );
}

/**
 * Split: copy (eyebrow, H2, lead, optional list and button) beside one image — Home's About grid.
 *
 * @param array $a anchor, eyebrow, title, h2id, lead, list (serialized list block), button [text, href], image (serialized image block), soft.
 */
function bwe_sl_split( $a ) {
	$copy  = bwe_sl_group( 'bwex-eyebrow', bwe_sl_p( $a['eyebrow'] ) ) . "\n\n" . bwe_sl_group( 'bwex-h2', bwe_sl_h( $a['title'], 2, 'elementor-heading-title bwe-h2x-plain', $a['h2id'] ?? '' ) );
	$copy .= ! empty( $a['lead'] ) ? "\n\n" . bwe_sl_p( $a['lead'], 'bwex-split__lead' ) : '';
	$copy .= ! empty( $a['list'] ) ? "\n\n" . $a['list'] : '';
	$copy .= ! empty( $a['button'] ) ? "\n\n" . bwe_sl_button( $a['button'][0], $a['button'][1], 'bwex-btn bwex-btn--fill' ) : '';
	$grid  = bwe_sl_group( 'bwex-split__copy', $copy ) . "\n\n" . bwe_sl_group( 'bwex-split__media', $a['image'] );
	$cls   = 'bwex-section bwex-split' . ( ! empty( $a['soft'] ) ? ' bwex-section--soft' : '' );
	return bwe_sl_root( bwe_sl_group( $cls, bwe_sl_group( 'bwex-wrap', bwe_sl_group( 'bwex-split__grid', $grid ) ), 'section', $a['anchor'] ?? '' ) );
}

/**
 * Closing call to action with its own copy (Home's dark CTA box). Pages that share Home's copy use bwe_sl_cta().
 *
 * @param array $a eyebrow, title, lead, primary [text, href], ghost [text, href], chat (bool), note.
 */
function bwe_sl_final( $a ) {
	$btn = static function ( $b, $cls ) {
		$ext   = 0 === strpos( $b[1], 'http' ) && false === strpos( $b[1], wp_parse_url( home_url(), PHP_URL_HOST ) );
		$attrs = array( 'className' => $cls ) + ( $ext ? array( 'linkTarget' => '_blank', 'rel' => 'noreferrer noopener' ) : array() );
		return '<!-- wp:buttons {"className":"bwe-btns-raw"} -->' . "\n" . '<div class="wp-block-buttons bwe-btns-raw"><!-- wp:button ' . bwe_sl_json( $attrs ) . " -->\n"
			. '<div class="wp-block-button ' . $cls . '"><a class="wp-block-button__link wp-element-button" href="' . esc_attr( $b[1] ) . '"' . ( $ext ? ' target="_blank" rel="noreferrer noopener"' : '' ) . '>' . $b[0] . "</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->";
	};
	$acts = $btn( $a['primary'], 'bwe-btn bwe-btn--primary' ) . ( ! empty( $a['ghost'] ) ? "\n\n" . $btn( $a['ghost'], 'bwe-btn bwe-btn--ghost' ) : '' );
	$box  = bwe_sl_group( 'bwex-cta__eyebrow', bwe_sl_p( $a['eyebrow'], 'bwe-eyebrow' ) ) . "\n\n"
		. bwe_sl_h( $a['title'], 2, '' ) . "\n\n"
		. bwe_sl_p( $a['lead'], 'bwe-lead' ) . "\n\n"
		. bwe_sl_group( 'bwe-actions', $acts );
	if ( ! empty( $a['chat'] ) ) {
		$box .= "\n\n" . bwe_sl_p( 'Prefer to chat? I\'m on <strong>live chat 24/7</strong>. <a href="/contact/">Start a chat →</a>', 'bwe-final__chat' );
	}
	if ( ! empty( $a['note'] ) ) {
		$box .= "\n\n" . bwe_sl_p( $a['note'], 'bwe-final__note' );
	}
	$sec = bwe_sl_group( 'bwe-section bwe-final', bwe_sl_group( 'bwe-final__box', $box ), 'section' );
	return bwe_sl_root( bwe_sl_group( 'elementor-element elementor-element-f672073 elementor-widget elementor-widget-bwex-cta', bwe_sl_group( 'elementor-widget-container', bwe_sl_group( 'bwe-home bwex bwex-ctaw', $sec ) ) ) );
}

/**
 * Guide (docs layout): Home head, then a sticky numbered contents list beside the article, which is split into
 * numbered chapters (one per H2). The script below marks the chapter being read in the list.
 *
 * @param array $a anchor, eyebrow, title, h2id, intro, chapters [[anchor, title HTML, blocks]], more [text, #href] (extra last link, e.g. the FAQ).
 */
function bwe_sl_guide( $a ) {
	$links = array();
	$chaps = array();
	foreach ( array_values( $a['chapters'] ) as $i => $c ) {
		$n       = sprintf( '%02d', $i + 1 );
		$links[] = '<a href="#' . esc_attr( $c[0] ) . '"><span>' . $n . '</span>' . wp_strip_all_tags( $c[1] ) . '</a>';
		$chaps[] = bwe_sl_group(
			'bwex-chapter',
			bwe_sl_p( $n, 'bwex-chapter__num' ) . "\n\n" . bwe_sl_h( $c[1], 2, 'bwex-chapter__title', $c[0] ) . "\n\n" . bwe_sl_group( 'bwex-chapter__body', $c[2] )
		);
	}
	if ( ! empty( $a['more'] ) ) {
		$links[] = '<a href="' . esc_attr( $a['more'][1] ) . '"><span>' . sprintf( '%02d', count( $links ) + 1 ) . '</span>' . $a['more'][0] . '</a>';
	}
	$list = str_replace(
		array( '<!-- wp:list {"className":"bwex-guide__toc"} -->' . "\n" . '<ul', "</ul>\n<!-- /wp:list -->" ),
		array( '<!-- wp:list {"ordered":true,"className":"bwex-guide__toc"} -->' . "\n" . '<ol', "</ol>\n<!-- /wp:list -->" ),
		bwe_sl_list( $links, 'bwex-guide__toc' )
	);
	$nav  = bwe_sl_group( 'bwex-guide__nav', bwe_sl_p( 'On this page', 'bwex-guide__navtitle' ) . "\n\n" . $list );
	$grid = bwe_sl_group( 'bwex-guide__grid', $nav . "\n\n" . bwe_sl_group( 'bwex-guide__body', implode( "\n\n", $chaps ) ) );
	return bwe_sl_root(
		bwe_sl_group( 'bwex-section bwex-section--soft bwex-guide', bwe_sl_group( 'bwex-wrap', bwe_sl_head( $a ) . "\n\n" . $grid ), 'section', $a['anchor'] ?? 'guide' )
	);
}

/**
 * Marks the chapter being read in a guide's contents list (inline, like the tour script).
 */
function bwe_sl_guide_script() {
	if ( ! function_exists( 'bwe_home_is_needed' ) || ! bwe_home_is_needed( 'bwex-guide__toc' ) ) {
		return;
	}
	$js = <<<'JS'
document.querySelectorAll('.bwex-guide__grid').forEach(function (grid) {
	var links = [].slice.call(grid.querySelectorAll('.bwex-guide__toc a[href^="#"]'));
	var heads = links.map(function (a) { return document.getElementById(a.getAttribute('href').slice(1)); });
	if (!('IntersectionObserver' in window)) { return; }
	function mark(i) { links.forEach(function (a, k) { a.classList.toggle('is-active', k === i); if (k === i) { a.setAttribute('aria-current', 'true'); } else { a.removeAttribute('aria-current'); } }); }
	function update() {
		var line = window.innerHeight * 0.3, cur = -1;
		heads.forEach(function (h, i) { if (h && h.getBoundingClientRect().top <= line) { cur = i; } });
		mark(cur < 0 ? 0 : cur);
	}
	var io = new IntersectionObserver(update, { rootMargin: '0px 0px -60% 0px' });
	heads.forEach(function (h) { if (h) { io.observe(h); } });
	window.addEventListener('scroll', function () { window.requestAnimationFrame(update); }, { passive: true });
	update();
});
JS;
	wp_print_inline_script_tag( $js, array( 'id' => 'bwex-guide-js' ) );
}
add_action( 'wp_footer', 'bwe_sl_guide_script', 30 );

/**
 * Keeps SiteGround Optimizer from combining the guide script.
 *
 * @param array $excluded Substrings of inline scripts SG must leave alone.
 * @return array
 */
function bwe_sl_guide_sg_exclude( $excluded ) {
	$excluded[] = '.bwex-guide__grid';
	return $excluded;
}
add_filter( 'sgo_javascript_combine_excluded_inline_content', 'bwe_sl_guide_sg_exclude' );

/**
 * Demo bar: slim dark strip above a demo store page (label, demo tabs, download link).
 *
 * @param array $a label (HTML), tabs [[text, href, current(bool)]], cta [text, href].
 */
function bwe_sl_demobar( $a ) {
	$tabs = '';
	foreach ( $a['tabs'] as $t ) {
		$tabs .= '<a href="' . esc_attr( $t[1] ) . '"' . ( ! empty( $t[2] ) ? ' aria-current="page"' : '' ) . '>' . $t[0] . '</a>';
	}
	$inner = bwe_sl_p( $a['label'], 'bwex-demobar__label' ) . "\n\n" . bwe_sl_p( $tabs, 'bwex-demobar__tabs' ) . "\n\n"
		. bwe_sl_p( '<a href="' . esc_attr( $a['cta'][1] ) . '" target="_blank" rel="noreferrer noopener">' . $a['cta'][0] . '</a>', 'bwex-demobar__cta' );
	return bwe_sl_root( bwe_sl_group( 'bwex-demobar', bwe_sl_group( 'bwex-wrap', $inner ), 'aside' ) );
}

/**
 * A section kept in its own design (product showcases with no Home equivalent): the original block,
 * wrapped in the classes its stylesheet expects.
 *
 * @param array $a block (serialized), classes (wrapper classes, e.g. "bwe-home bwe-services bwe-ml").
 */
function bwe_sl_legacy( $a ) {
	return bwe_sl_group( 'alignfull ' . $a['classes'] . ' bwe-sec-legacy', $a['block'] );
}

/**
 * The closing call to action: one synced pattern shared by every page (edit it once).
 */
function bwe_sl_cta() {
	$id = (int) get_option( 'bwe_sl_cta_block' );
	return $id && get_post( $id ) ? '<!-- wp:block {"ref":' . $id . '} /-->' : '';
}


