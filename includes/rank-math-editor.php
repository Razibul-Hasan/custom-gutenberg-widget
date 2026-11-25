<?php
/**
 * Rank Math's SEO analysis in the editor reads the raw content (BestWebExpert Home adds the synced patterns' raw
 * content to it). Our blocks keep their text in attributes, so their block comments are turned into the HTML the
 * analysis expects: section headings as <h2>, step titles as <h3>, everything else as paragraphs.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * Adds the rank_math_content filter (after BestWebExpert Home's, which appends the synced patterns).
 */
function bwe_gw_rank_math_editor_content() {
	if ( ! wp_script_is( 'wp-hooks', 'registered' ) ) {
		return;
	}
	$js = <<<'JS'
( function () {
	if ( ! window.wp || ! wp.hooks ) {
		return;
	}
	var p = function ( html ) {
		return html ? '<p>' + html + '</p>' : '';
	};
	var toHtml = {
		'section-head': function ( a ) {
			return p( a.eyebrow ) + '<h2>' + ( a.title || '' ) + '</h2>' + p( a.intro );
		},
		'faq-item': function ( a ) {
			return p( a.question );
		},
		'spec-card': function ( a ) {
			return p( [ a.name, a.text, a.chip ].filter( Boolean ).join( ' ' ) );
		},
		'price-row': function ( a ) {
			return p( [ a.service, a.note, a.amount, a.unit ].filter( Boolean ).join( ' ' ) );
		},
		'who-card': function ( a ) {
			return p( ( a.url ? '<a href="' + a.url + '">' + ( a.title || '' ) + '</a>' : a.title || '' ) + ' ' + [ a.text, a.tag ].filter( Boolean ).join( ' ' ) );
		},
		step: function ( a ) {
			return '<h3>' + ( a.title || '' ) + '</h3>' + p( a.text );
		},
		hero: function ( a ) {
			return '<h1>' + ( a.title || '' ) + '</h1>' + p( a.lead ) + p( [ a.btn1Text, a.btn2Text ].filter( Boolean ).join( ' ' ) );
		},
		services: function ( a ) {
			return p( a.eyebrow ) + '<h2>' + ( a.title || '' ) + '</h2>' + p( a.lead ) + p( a.more );
		},
		'service-tile': function ( a ) {
			return '<h3>' + ( a.name || '' ) + '</h3>' + p( [ a.tag, a.desc ].filter( Boolean ).join( ' ' ) );
		},
		'platform-card': function ( a ) {
			// The image counts for Rank Math's image / alt-text checks, as the core Image block did.
			var img = a.imageUrl ? '<img src="' + a.imageUrl + '" alt="' + String( a.imageAlt || '' ).replace( /"/g, '&quot;' ) + '">' : '';
			var title = a.titleUrl ? '<a href="' + a.titleUrl + '">' + ( a.title || '' ) + '</a>' : a.title || '';
			return img + p( a.chip ) + '<h3>' + title + '</h3>' + p( a.text ) + p( a.price ) + p( a.btnUrl ? '<a href="' + a.btnUrl + '">' + ( a.btnText || '' ) + '</a>' : a.btnText ) + p( a.badge );
		},
	};
	// Home section blocks: header as <h2>, items as <h3> + paragraphs (their items are blocks of their own).
	var head = function ( a, extra ) {
		return p( a.eyebrow ) + '<h2>' + ( a.title || '' ) + '</h2>' + p( a.intro ) + p( extra );
	};
	toHtml[ 'why-us' ] = function ( a ) { return head( a, a.aside ); };
	toHtml.testimonials = function ( a ) { return head( a, a.more ); };
	toHtml.pricing = function ( a ) { return head( a ); };
	toHtml.process = function ( a ) { return head( a ); };
	toHtml.products = function ( a ) { return head( a, a.more ); };
	toHtml.faq = function ( a ) { return head( a, a.askText ); };
	toHtml[ 'video-card' ] = function ( a ) { return p( a.who ); };
	toHtml[ 'price-plan' ] = function ( a ) {
		return p( a.featured ? a.badge : '' ) + '<h3>' + ( a.name || '' ) + '</h3>' + p( a.price ) + p( a.desc ) + p( a.btnText );
	};
	toHtml[ 'starting-prices' ] = function ( a ) {
		return p( a.label ) + ( a.items || [] ).map( function ( i ) { return p( ( i.label || '' ) + ' ' + ( i.price || '' ) ); } ).join( '' ) + p( a.note ) + p( a.allText );
	};
	toHtml[ 'cost-panel' ] = function ( a ) {
		return '<h3>' + ( a.title || '' ) + '</h3>' + ( a.items || [] ).map( function ( i ) { return p( i.text ); } ).join( '' );
	};
	toHtml[ 'product-card' ] = function ( a ) {
		var img = 'image' === a.art && a.imageUrl ? '<img src="' + a.imageUrl + '" alt="' + String( a.imageAlt || '' ).replace( /"/g, '&quot;' ) + '">' : '';
		return img + p( a.tag ) + '<h3>' + ( a.name || '' ) + '</h3>' + p( a.text ) + p( ( a.linksLabel || '' ) + ' ' + ( a.links || '' ) ) + p( a.btnUrl ? '<a href="' + a.btnUrl + '">' + ( a.btnText || '' ) + '</a>' : a.btnText );
	};
	toHtml[ 'price-section' ] = function ( a ) { return head( a ); };
	toHtml[ 'price-card' ] = function ( a ) {
		var title = a.titleUrl ? '<a href="' + a.titleUrl + '">' + ( a.title || '' ) + '</a>' : a.title || '';
		return p( a.chip ) + '<h3>' + title + '</h3>' + p( a.text ) + p( a.price ) + p( a.btnUrl ? '<a href="' + a.btnUrl + '">' + ( a.btnText || '' ) + '</a>' : a.btnText );
	};
	toHtml.work = function ( a ) { return head( a ); };
	toHtml[ 'work-item' ] = function ( a ) {
		var img = a.imageUrl ? '<img src="' + a.imageUrl + '" alt="' + String( a.imageAlt || '' ).replace( /"/g, '&quot;' ) + '">' : '';
		var title = a.url ? '<a href="' + a.url + '">' + ( a.title || '' ) + '</a>' : a.title || '';
		return img + p( a.num ) + '<h3>' + title + '</h3>' + p( a.tag ) + p( a.text );
	};
	toHtml[ 'contact-form' ] = function ( a ) {
		return p( a.eyebrow ) + '<h2>' + ( a.title || '' ) + '</h2>' + p( a.intro ) + p( a.note );
	};
	toHtml.about = function ( a ) {
		return p( a.eyebrow ) + '<h2>' + ( a.title || '' ) + '</h2>' + p( a.lead ) + ( a.more || [] ).map( p ).join( '' ) + ( a.cardTitle ? '<h3>' + a.cardTitle + '</h3>' : '' ) + p( a.btnUrl ? '<a href="' + a.btnUrl + '">' + ( a.btnText || '' ) + '</a>' : a.btnText );
	};
	toHtml.cta = function ( a ) {
		return p( a.eyebrow ) + '<h2>' + ( a.title || '' ) + '</h2>' + p( a.lead ) + p( [ a.btn1Text, a.btn2Text ].filter( Boolean ).join( ' ' ) ) + p( a.chat ) + p( a.note );
	};
	wp.hooks.addFilter( 'rank_math_content', 'bestwebexpert/gutenberg-widget', function ( content ) {
		return String( content || '' ).replace( /<!-- wp:bwe\/([a-z-]+) (\{[\s\S]*?\}) ?(\/)?-->/g, function ( match, name, json ) {
			var attrs;
			try {
				attrs = JSON.parse( json );
			} catch ( e ) {
				return match;
			}
			return toHtml[ name ] ? toHtml[ name ]( attrs ) : match;
		} );
	}, 20 );
} )();
JS;
	wp_add_inline_script( 'wp-hooks', $js );
}
add_action( 'enqueue_block_editor_assets', 'bwe_gw_rank_math_editor_content' );
