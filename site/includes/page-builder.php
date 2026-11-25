<?php
/**
 * Page builder for the service, pricing, about and portfolio pages.
 *
 * Each page is a data file in content/pages/<slug>.php. The functions here turn that data into core block
 * markup in the home page's design system, so every page stays consistent and editable in Gutenberg.
 * Pages carry the bwe-pb class; service pages also get Service and FAQPage schema from their data.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/*
 * ---------- Block primitives ----------
 */

/**
 * Block comment attributes, with "--" escaped the way the editor saves it.
 *
 * @param array $attrs Block attributes.
 * @return string
 */
function bwe_pb_attrs( $attrs ) {
	return $attrs ? ' ' . serialize_block_attributes( $attrs ) : '';
}

/**
 * @param string $inner     Inner block markup.
 * @param string $classname Extra classes.
 * @param string $tag       Wrapper tag.
 * @param string $anchor    Element id.
 * @param array  $extra     Extra block attributes, such as align.
 * @return string
 */
function bwe_pb_group( $inner, $classname = '', $tag = 'div', $anchor = '', $extra = array() ) {
	$attrs = $extra;
	if ( 'div' !== $tag ) {
		$attrs = array( 'tagName' => $tag ) + $attrs;
	}
	if ( $classname ) {
		$attrs['className'] = $classname;
	}
	if ( $anchor ) {
		$attrs['anchor'] = $anchor;
	}

	$class = trim( 'wp-block-group ' . ( isset( $extra['align'] ) ? 'align' . $extra['align'] . ' ' : '' ) . $classname );
	$id    = $anchor ? ' id="' . esc_attr( $anchor ) . '"' : '';

	return '<!-- wp:group' . bwe_pb_attrs( $attrs ) . " -->\n<" . $tag . $id . ' class="' . esc_attr( $class ) . '">' . $inner . '</' . $tag . ">\n<!-- /wp:group -->";
}

/**
 * @param string $html      Paragraph HTML.
 * @param string $classname Paragraph class.
 * @return string
 */
function bwe_pb_p( $html, $classname = '' ) {
	$attrs = $classname ? array( 'className' => $classname ) : array();
	$class = $classname ? ' class="' . esc_attr( $classname ) . '"' : '';

	return '<!-- wp:paragraph' . bwe_pb_attrs( $attrs ) . " -->\n<p" . $class . '>' . $html . "</p>\n<!-- /wp:paragraph -->";
}

/**
 * @param string $html      Heading HTML; <em> becomes the highlight marker.
 * @param int    $level     Heading level.
 * @param string $classname Extra class.
 * @param string $anchor    Heading id.
 * @return string
 */
function bwe_pb_h( $html, $level = 2, $classname = '', $anchor = '' ) {
	$attrs = array();
	if ( 2 !== $level ) {
		$attrs['level'] = $level;
	}
	if ( $classname ) {
		$attrs['className'] = $classname;
	}
	if ( $anchor ) {
		$attrs['anchor'] = $anchor;
	}

	$id = $anchor ? ' id="' . esc_attr( $anchor ) . '"' : '';

	return '<!-- wp:heading' . bwe_pb_attrs( $attrs ) . " -->\n<h" . $level . ' class="' . esc_attr( trim( 'wp-block-heading ' . $classname ) ) . '"' . $id . '>' . $html . '</h' . $level . ">\n<!-- /wp:heading -->";
}

/**
 * @param string[] $items     List item HTML.
 * @param string   $classname List class.
 * @param bool     $ordered   Numbered list.
 * @return string
 */
function bwe_pb_list( $items, $classname = 'bwe-checks', $ordered = false ) {
	$attrs = $ordered ? array( 'ordered' => true ) : array();
	if ( $classname ) {
		$attrs['className'] = $classname;
	}

	$tag = $ordered ? 'ol' : 'ul';
	$lis = array();
	foreach ( $items as $item ) {
		$lis[] = "<!-- wp:list-item -->\n<li>" . $item . "</li>\n<!-- /wp:list-item -->";
	}

	return '<!-- wp:list' . bwe_pb_attrs( $attrs ) . " -->\n<" . $tag . ' class="' . esc_attr( trim( 'wp-block-list ' . $classname ) ) . '">' . implode( "\n\n", $lis ) . '</' . $tag . ">\n<!-- /wp:list -->";
}

/**
 * @param array  $buttons   [label, url, style] triples; style is accent, primary or ghost.
 * @param string $classname Buttons class.
 * @return string
 */
function bwe_pb_buttons( $buttons, $classname = 'bwe-actions' ) {
	$out = array();
	foreach ( $buttons as $button ) {
		$class = 'bwe-btn bwe-btn--' . ( isset( $button[2] ) ? $button[2] : 'accent' );
		$out[] = '<!-- wp:button' . bwe_pb_attrs( array( 'className' => $class ) ) . " -->\n"
			. '<div class="wp-block-button ' . $class . '"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $button[1] ) . '">' . $button[0] . "</a></div>\n<!-- /wp:button -->";
	}

	return '<!-- wp:buttons' . bwe_pb_attrs( array( 'className' => $classname ) ) . " -->\n<div class=\"wp-block-buttons " . esc_attr( $classname ) . '">' . implode( "\n\n", $out ) . "</div>\n<!-- /wp:buttons -->";
}

/**
 * @param string[]   $head  Header cells.
 * @param string[][] $rows  Body rows.
 * @return string
 */
function bwe_pb_table( $head, $rows ) {
	$html = '<thead><tr><th>' . implode( '</th><th>', $head ) . '</th></tr></thead><tbody>';
	foreach ( $rows as $row ) {
		$html .= '<tr><td>' . implode( '</td><td>', $row ) . '</td></tr>';
	}

	return "<!-- wp:table {\"className\":\"bwe-table bwe-wpx-table\"} -->\n<figure class=\"wp-block-table bwe-table bwe-wpx-table\"><table class=\"has-fixed-layout\">" . $html . "</tbody></table></figure>\n<!-- /wp:table -->";
}

/**
 * Joins sibling blocks the way the editor does.
 *
 * @param string[] $blocks Block markup.
 * @return string
 */
function bwe_pb_join( $blocks ) {
	return implode( "\n\n", array_filter( $blocks ) );
}

/*
 * ---------- Sections ----------
 */

/**
 * Section heading: eyebrow, H2 and lead.
 *
 * @param array $d eyebrow, h2, anchor, lead.
 * @param bool  $center Centered heading.
 * @return string
 */
function bwe_pb_head( $d, $center = true ) {
	return bwe_pb_group(
		bwe_pb_join(
			array(
				bwe_pb_p( $d['eyebrow'], 'bwe-eyebrow' ),
				bwe_pb_h( $d['h2'], 2, '', isset( $d['anchor'] ) ? $d['anchor'] : '' ),
				! empty( $d['lead'] ) ? bwe_pb_p( $d['lead'], 'bwe-lead' ) : '',
			)
		),
		$center ? 'bwe-head bwe-head--center' : 'bwe-head'
	);
}

/**
 * Dark hero with a price card.
 *
 * @param array $d pill [text, url], kicker, h1, lead, buttons, jump [[label, #id]], num, label, checks, sticker_a, sticker_b.
 * @return string
 */
function bwe_pb_hero( $d ) {
	$jump = array();
	foreach ( $d['jump'] as $link ) {
		$jump[] = '<a href="' . esc_attr( $link[1] ) . '">' . $link[0] . '</a>';
	}

	$copy = bwe_pb_group(
		bwe_pb_join(
			array(
				bwe_pb_p( '<a href="' . esc_url( $d['pill'][1] ) . '">' . $d['pill'][0] . '</a>', 'bwe-pill' ),
				bwe_pb_p( $d['kicker'], 'bwe-kicker' ),
				bwe_pb_h( $d['h1'], 1, 'bwe-hero__title' ),
				bwe_pb_p( $d['lead'], 'bwe-lead' ),
				bwe_pb_buttons( $d['buttons'] ),
				$jump ? bwe_pb_list( $jump, 'bwe-jump' ) : '',
			)
		),
		'bwe-hero__copy'
	);

	$card = bwe_pb_group(
		bwe_pb_join(
			array(
				bwe_pb_p( $d['num'], 'bwe-years__num' ),
				bwe_pb_p( $d['label'], 'bwe-years__label' ),
				bwe_pb_list( $d['checks'] ),
				bwe_pb_p( 'FREE<br>quote', 'bwe-burst' ),
				bwe_pb_p( $d['sticker_a'], 'bwe-sticker bwe-sticker--a' ),
				bwe_pb_p( $d['sticker_b'], 'bwe-sticker bwe-sticker--b' ),
			)
		),
		'bwe-years'
	);

	return bwe_pb_group( $copy . "\n\n" . $card, 'bwe-section bwe-dark bwe-hero bwe-svc-hero', 'section' );
}

/**
 * Scrolling ribbon of keywords.
 *
 * @param string[] $items Words.
 * @return string
 */
function bwe_pb_marquee( $items ) {
	// The ribbon was removed from every page by design; the page data files still pass their words in.
	return '';
}

/**
 * Four big numbers.
 *
 * @param array $stats [number, label] pairs.
 * @return string
 */
function bwe_pb_stats( $stats ) {
	$cells = array();
	foreach ( $stats as $stat ) {
		$cells[] = bwe_pb_group( bwe_pb_p( $stat[0], 'bwe-stat__num' ) . "\n\n" . bwe_pb_p( $stat[1], 'bwe-stat__label' ), 'bwe-stat' );
	}

	return bwe_pb_group( bwe_pb_group( bwe_pb_join( $cells ), 'bwe-stats__grid' ), 'bwe-section bwe-stats', 'section' );
}

/**
 * Grid of cards, each with an optional tag above the title.
 *
 * @param array  $d      Heading data plus cards [[tag, title, text]] and an optional 'more' paragraph.
 * @param string $extra  Extra section class.
 * @param string $anchor Section id.
 * @return string
 */
function bwe_pb_cards( $d, $extra = '', $anchor = '' ) {
	$cards = array();
	foreach ( $d['cards'] as $card ) {
		$cards[] = bwe_pb_group(
			bwe_pb_join(
				array(
					$card[0] ? bwe_pb_p( $card[0], 'bwe-wpx-from' ) : '',
					bwe_pb_h( $card[1], 3 ),
					bwe_pb_p( $card[2] ),
				)
			),
			'bwe-ind bwe-reveal'
		);
	}

	return bwe_pb_group(
		bwe_pb_join(
			array(
				bwe_pb_head( $d ),
				bwe_pb_group( bwe_pb_join( $cards ), $d['grid'] ?? 'bwe-grid bwe-grid--3' ),
				! empty( $d['more'] ) ? bwe_pb_p( $d['more'], 'bwe-more' ) : '',
			)
		),
		trim( 'bwe-section bwe-wpx-services ' . $extra ),
		'section',
		$anchor
	);
}

/**
 * Dark numbered list of problems.
 *
 * @param array $d eyebrow, h2, anchor, lead, cta [label, url], items [[bold, text]].
 * @return string
 */
function bwe_pb_signs( $d ) {
	$items = array();
	foreach ( $d['items'] as $item ) {
		$items[] = '<strong>' . $item[0] . '</strong> ' . $item[1];
	}

	$intro = bwe_pb_group(
		bwe_pb_join(
			array(
				bwe_pb_p( $d['eyebrow'], 'bwe-eyebrow' ),
				bwe_pb_h( $d['h2'], 2, '', $d['anchor'] ),
				bwe_pb_p( $d['lead'], 'bwe-lead' ),
				bwe_pb_buttons( array( array( $d['cta'][0], $d['cta'][1], 'accent' ) ) ),
			)
		),
		'bwe-mistakes__intro'
	);

	return bwe_pb_group( $intro . "\n\n" . bwe_pb_list( $items, 'bwe-mistakes__list', true ), 'bwe-section bwe-dark bwe-mistakes', 'section' );
}

/**
 * Pricing plans, with an optional table and note under them.
 *
 * @param array $d Heading data plus plans [[name, price, unit, desc, checks[], featured, cta label, cta url]], table, note.
 * @return string
 */
function bwe_pb_plans( $d ) {
	$plans = array();
	foreach ( $d['plans'] as $plan ) {
		$featured = ! empty( $plan[5] );
		$plans[]  = bwe_pb_group(
			bwe_pb_join(
				array(
					$featured ? bwe_pb_p( 'Most popular', 'bwe-badge' ) : '',
					bwe_pb_h( $plan[0], 3 ),
					bwe_pb_p( $plan[1] . ( $plan[2] ? ' <em>' . $plan[2] . '</em>' : '' ), 'bwe-price' ),
					bwe_pb_p( $plan[3], 'bwe-plan__desc' ),
					bwe_pb_list( $plan[4] ),
					bwe_pb_buttons( array( array( $plan[6], $plan[7], $featured ? 'accent' : 'ghost' ) ) ),
				)
			),
			$featured ? 'bwe-plan bwe-plan--featured' : 'bwe-plan'
		);
	}

	return bwe_pb_group(
		bwe_pb_join(
			array(
				bwe_pb_head( $d ),
				$plans ? bwe_pb_group( bwe_pb_join( $plans ), 'bwe-grid bwe-plans' ) : '',
				! empty( $d['table'] ) ? bwe_pb_table( $d['table'][0], $d['table'][1] ) : '',
				! empty( $d['note'] ) ? bwe_pb_p( $d['note'], 'bwe-more' ) : '',
			)
		),
		'bwe-section bwe-tint bwe-pricing bwe-wpx-pricing',
		'section',
		isset( $d['id'] ) ? $d['id'] : 'pricing'
	);
}

/**
 * Plain section with a heading and a table.
 *
 * @param array $d Heading data plus table [head, rows], note, id, tint.
 * @return string
 */
function bwe_pb_table_section( $d ) {
	return bwe_pb_group(
		bwe_pb_join(
			array(
				bwe_pb_head( $d ),
				bwe_pb_table( $d['table'][0], $d['table'][1] ),
				! empty( $d['note'] ) ? bwe_pb_p( $d['note'], 'bwe-more' ) : '',
			)
		),
		'bwe-section bwe-compare bwe-wpx-compare' . ( ! empty( $d['tint'] ) ? ' bwe-tint' : '' ),
		'section',
		isset( $d['id'] ) ? $d['id'] : ''
	);
}

/**
 * Four numbered steps.
 *
 * @param array $d eyebrow, h2, anchor, steps [[title, text]].
 * @return string
 */
function bwe_pb_steps( $d ) {
	$steps = array();
	foreach ( $d['steps'] as $i => $step ) {
		$steps[] = bwe_pb_group(
			bwe_pb_join( array( bwe_pb_p( sprintf( '%02d', $i + 1 ), 'bwe-step__num' ), bwe_pb_h( $step[0], 3 ), bwe_pb_p( $step[1] ) ) ),
			'bwe-step bwe-reveal'
		);
	}

	return bwe_pb_group(
		bwe_pb_head( $d, false ) . "\n\n" . bwe_pb_group( bwe_pb_join( $steps ), 'bwe-grid bwe-grid--4' ),
		'bwe-section bwe-process',
		'section',
		'process'
	);
}

/**
 * Copy on the left, checklist card on the right.
 *
 * @param array $d eyebrow, h2, anchor, paragraphs[], image [key, alt], card_title, checks[], cta [label, url].
 * @return string
 */
function bwe_pb_split( $d ) {
	$copy = array( bwe_pb_p( $d['eyebrow'], 'bwe-eyebrow' ), bwe_pb_h( $d['h2'], 2, '', $d['anchor'] ) );
	foreach ( $d['paragraphs'] as $paragraph ) {
		$copy[] = bwe_pb_p( $paragraph );
	}
	if ( ! empty( $d['image'] ) ) {
		$copy[] = bwe_home_image( $d['image'][0], 'bwe-shot', $d['image'][1] );
	}

	$card = bwe_pb_join(
		array(
			bwe_pb_h( $d['card_title'], 3 ),
			bwe_pb_list( $d['checks'] ),
			bwe_pb_buttons( array( array( $d['cta'][0], $d['cta'][1], 'primary' ) ) ),
		)
	);

	return bwe_pb_group(
		bwe_pb_group( bwe_pb_join( $copy ), 'bwe-about__copy' ) . "\n\n" . bwe_pb_group( $card, 'bwe-about__card' ),
		'bwe-section bwe-tint bwe-about',
		'section'
	);
}

/**
 * FAQ accordion. The home page's FAQPage schema code reads these core Details blocks.
 *
 * @param array $d h2, anchor, lead, cta url, items [[question, answer HTML]].
 * @return string
 */
function bwe_pb_faq( $d ) {
	$items = array();
	foreach ( $d['items'] as $item ) {
		$items[] = "<!-- wp:details {\"className\":\"bwe-faq__item\"} -->\n<details class=\"wp-block-details bwe-faq__item\"><summary>" . $item[0] . '</summary>' . bwe_pb_p( $item[1] ) . "</details>\n<!-- /wp:details -->";
	}

	$intro = bwe_pb_group(
		bwe_pb_join(
			array(
				bwe_pb_p( 'FAQ', 'bwe-eyebrow' ),
				bwe_pb_h( $d['h2'], 2, '', $d['anchor'] ),
				bwe_pb_p( $d['lead'], 'bwe-lead' ),
				bwe_pb_buttons( array( array( 'Ask a question →', $d['cta'], 'ghost' ) ) ),
			)
		),
		'bwe-faq__intro'
	);

	return bwe_pb_group( $intro . "\n\n" . bwe_pb_group( bwe_pb_join( $items ), 'bwe-faq__list' ), 'bwe-section bwe-faq', 'section', 'faq' );
}

/**
 * Closing call to action.
 *
 * @param array $d h2, anchor, lead, buttons, note.
 * @return string
 */
function bwe_pb_final( $d ) {
	return bwe_pb_group(
		bwe_pb_group(
			bwe_pb_join(
				array(
					bwe_pb_p( 'Ready when you are', 'bwe-eyebrow' ),
					bwe_pb_h( $d['h2'], 2, '', $d['anchor'] ),
					bwe_pb_p( $d['lead'], 'bwe-lead' ),
					bwe_pb_buttons( $d['buttons'] ),
					bwe_pb_p( $d['note'], 'bwe-final__note' ),
				)
			),
			'bwe-final__box'
		),
		'bwe-section bwe-final',
		'section'
	);
}

/**
 * Wraps sections in the page container.
 *
 * @param string[] $sections Section markup.
 * @return string
 */
function bwe_pb_page( $sections ) {
	return bwe_pb_group( bwe_pb_join( $sections ), 'bwe-home bwe-services bwe-pb', 'div', '', array( 'align' => 'full' ) );
}

/*
 * ---------- Service pages ----------
 */

/**
 * Loads a page's data file.
 *
 * @param string $slug Page slug, matching content/pages/<slug>.php.
 * @return array|null
 */
function bwe_pb_data( $slug ) {
	$file = BWE_HOME_DIR . '/content/pages/' . sanitize_file_name( $slug ) . '.php';

	return is_readable( $file ) ? include $file : null;
}

/**
 * Slugs of the generated pages, in menu order, grouped by type.
 *
 * @return array<string, string[]>
 */
function bwe_pb_slugs() {
	return array(
		'wordpress' => array( 'wordpress-speed-optimization', 'wordpress-malware-removal', 'wordpress-migration', 'wordpress-maintenance', 'woocommerce-development' ),
		'shopify'   => array( 'shopify-store-setup', 'shopify-theme-customization', 'shopify-speed-optimization', 'migrate-to-shopify' ),
		'other'     => array( 'pricing', 'about', 'portfolio' ),
	);
}

/**
 * Builds a service page from its data: hero, problems, what's included, packages, process, why us, FAQ, CTA.
 *
 * @param array $d Service data from content/pages/<slug>.php.
 * @return string Block markup.
 */
function bwe_pb_service_page( $d ) {
	$contact  = home_url( '/contact/' );
	$wp       = 'wordpress' === $d['platform'];
	$platform = $wp ? 'WordPress' : 'Shopify';
	$expert   = home_url( $wp ? '/best-wordpress-expert/' : '/best-shopify-expert/' );

	$related = array();
	foreach ( $d['related'] as $slug => $label ) {
		$related[] = '<a href="' . esc_url( home_url( '/' . $slug . '/' ) ) . '">' . $label . '</a>';
	}
	$more = sprintf(
		'Part of our <a href="%s">best %s expert</a> services. Also see %s, or compare every price on our <a href="%s">pricing page</a>.',
		esc_url( $expert ),
		$platform,
		implode( ', ', $related ),
		esc_url( home_url( '/pricing/' ) )
	);

	$steps = $wp
		? array(
			array( 'Send your site', 'Share your URL and what’s wrong or what you want. A screenshot or screen recording is plenty.' ),
			array( 'Get a fixed price', 'We review it and reply with the price and delivery time in writing, usually within 2 hours.' ),
			array( 'Backup, then work', 'We take a full backup and work on a staging copy where possible, so your live site stays safe.' ),
			array( 'Check it, then pay', 'You review the result and get a plain-language report. Happy? Then you pay.' ),
		)
		: array(
			array( 'Send your store', 'Share your store URL and what you need. A screenshot or screen recording is plenty.' ),
			array( 'Get a fixed price', 'We review it and reply with the price and delivery time in writing, usually within 2 hours.' ),
			array( 'We work on a copy', 'You add us as a collaborator and we work on a duplicate theme, so your store keeps selling.' ),
			array( 'Preview, publish, pay', 'You preview the result, we publish it and explain what changed. Happy? Then you pay.' ),
		);

	return bwe_pb_page(
		array(
			bwe_pb_hero(
				array(
					'pill'      => array( $d['hero']['pill'], '#pricing' ),
					'kicker'    => $d['hero']['kicker'],
					'h1'        => $d['hero']['h1'],
					'lead'      => $d['hero']['lead'],
					'buttons'   => array( array( $d['hero']['cta'] . ' →', $contact, 'accent' ), array( 'See packages ↓', '#pricing', 'ghost' ) ),
					'jump'      => array( array( 'What’s included', '#included' ), array( 'Packages', '#pricing' ), array( 'How it works', '#process' ), array( 'FAQ', '#faq' ) ),
					'num'       => $d['hero']['num'],
					'label'     => $d['hero']['label'],
					'checks'    => $d['hero']['checks'],
					'sticker_a' => $d['hero']['sticker'],
					'sticker_b' => '✓ No fix, no fee',
				)
			),
			bwe_pb_marquee( $d['marquee'] ),
			bwe_pb_signs( $d['signs'] + array( 'cta' => array( $d['hero']['cta'] . ' →', $contact ) ) ),
			bwe_pb_cards( $d['included'] + array( 'more' => $more ), '', 'included' ),
			bwe_pb_plans( $d['packages'] ),
			bwe_pb_steps(
				array(
					'eyebrow' => 'How it works',
					'h2'      => $d['steps_h2'],
					'anchor'  => '',
					'steps'   => $steps,
				)
			),
			bwe_pb_split( $d['why'] + array( 'cta' => array( 'Get my fixed quote →', $contact ) ) ),
			bwe_pb_faq( $d['faq'] + array( 'cta' => $contact ) ),
			bwe_pb_final(
				array(
					'h2'      => $d['final']['h2'],
					'anchor'  => '',
					'lead'    => $d['final']['lead'],
					'buttons' => array( array( $d['hero']['cta'] . ' →', $contact, 'primary' ), array( 'See packages', '#pricing', 'ghost' ) ),
					'note'    => 'Fixed prices. No fix, no fee. Free follow-up support.',
				)
			),
		)
	);
}

/**
 * Returns a generated page's block markup.
 *
 * @param string $slug Page slug.
 * @return string
 */
function bwe_pb_render( $slug ) {
	$d = bwe_pb_data( $slug );
	if ( ! $d ) {
		return '';
	}

	return isset( $d['platform'] ) ? bwe_pb_service_page( $d ) : bwe_pb_page( $d['sections'] );
}

/**
 * Adds Service and FAQPage schema to service pages.
 *
 * @param array $data JSON-LD graph Rank Math prints.
 * @return array
 */
function bwe_pb_json_ld( $data ) {
	if ( ! bwe_home_is_needed( 'bwe-services bwe-pb' ) && ! bwe_home_is_needed( 'bwe-pb-schema' ) ) {
		return $data;
	}

	$id    = get_queried_object_id();
	$slug  = (string) get_post_field( 'post_name', $id );
	if ( ! in_array( $slug, array_merge( ...array_values( bwe_pb_slugs() ) ), true ) ) {
		return $data;
	}

	$url = get_permalink( $id );
	$faq = bwe_bwe_details_faq( bwe_post_content_expanded( $id ) );
	if ( $faq ) {
		$faq['@id']     = $url . '#faq';
		$data['bweFaq'] = $faq;
	}

	$d = bwe_pb_data( $slug );
	if ( ! empty( $d['schema'] ) ) {
		$data['bwePbService'] = bwe_wpx_service_node( $url, $d['schema'] );
	}

	return $data;
}
add_filter( 'rank_math/json_ld', 'bwe_pb_json_ld', 98 );
