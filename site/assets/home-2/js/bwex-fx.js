/* BWE FX: small GSAP details for BWE pages (owner 2026-11-12).
 * - Heading highlights: the lime marker under <em> sweeps in when the heading scrolls into view.
 * - Stats: numbers count up once; the lime bar under each one fills.
 * - Proof cards: a soft lime light follows the pointer.
 * Without JS or with reduced motion everything shows in its final state.
 */
( function () {
	'use strict';

	var reduced = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	function marks( gsap ) {
		document.querySelectorAll( '.bwex .bwex-h2 em, .bwex .bwe-hero--paper:not(.bwe-hero--night):not(.bwex-hero) h1 em' ).forEach( function ( em ) {
			em.classList.add( 'bwex-mark' );
			gsap.fromTo( em, { '--bwex-mark': '0%' }, {
				'--bwex-mark': '100%',
				duration: 1.1,
				ease: 'power3.out',
				delay: em.closest( '.bwe-hero--paper' ) ? 0.35 : 0.15,
				scrollTrigger: { trigger: em, start: 'top 88%', once: true }
			} );
		} );
	}

	function counters( gsap ) {
		document.querySelectorAll( '.bwex .bwex-stat' ).forEach( function ( stat, i ) {
			var num = stat.querySelector( '.bwex-stat__num' );
			if ( ! num ) { return; }
			var m = num.textContent.match( /^(\D*)(\d+(?:\.\d+)?)(.*)$/ );
			var st = { trigger: stat, start: 'top 85%', once: true };
			gsap.fromTo( stat, { '--bwex-bar': '0%' }, { '--bwex-bar': '100%', duration: 1.2, ease: 'power2.out', delay: i * 0.12, scrollTrigger: st } );
			if ( ! m || num.children.length ) { return; }
			var end = parseFloat( m[ 2 ] );
			var dec = ( m[ 2 ].split( '.' )[ 1 ] || '' ).length;
			var o = { v: 0 };
			num.setAttribute( 'aria-label', num.textContent );
			gsap.to( o, {
				v: end,
				duration: 1.4,
				ease: 'power2.out',
				delay: i * 0.12,
				scrollTrigger: st,
				onUpdate: function () { num.textContent = m[ 1 ] + o.v.toFixed( dec ) + m[ 3 ]; }
			} );
			num.textContent = m[ 1 ] + ( 0 ).toFixed( dec ) + m[ 3 ];
		} );
	}

	/* Pointer glow on cards. Delegated, so widgets re-rendered in the Elementor editor keep it. */
	function glow() {
		if ( glow.on ) { return; }
		glow.on = true;
		document.addEventListener( 'pointermove', function ( e ) {
			var card = e.target && e.target.closest && e.target.closest( '.bwex .bwex-quote, .bwex .bwex-svc__tile' );
			if ( ! card ) { return; }
			var r = card.getBoundingClientRect();
			card.style.setProperty( '--bwex-gx', ( e.clientX - r.left ) + 'px' );
			card.style.setProperty( '--bwex-gy', ( e.clientY - r.top ) + 'px' );
		}, { passive: true } );
	}

	/* Wraps every word of el (keeping <em> and other inline tags) in a mask span. */
	function splitWords( el ) {
		Array.prototype.slice.call( el.childNodes ).forEach( function ( node ) {
			if ( node.nodeType === 1 ) {
				if ( node.tagName !== 'BR' ) { splitWords( node ); }
				return;
			}
			if ( node.nodeType !== 3 || ! node.textContent.trim() ) { return; }
			var frag = document.createDocumentFragment();
			node.textContent.split( /(\s+)/ ).forEach( function ( part ) {
				if ( ! part ) { return; }
				if ( /^\s+$/.test( part ) ) { frag.appendChild( document.createTextNode( ' ' ) ); return; }
				var w = document.createElement( 'span' );
				var i = document.createElement( 'span' );
				w.className = 'bwex-w';
				i.className = 'bwex-w__i';
				i.textContent = part;
				w.appendChild( i );
				frag.appendChild( w );
			} );
			node.parentNode.replaceChild( frag, node );
		} );
	}

	/* Hero defaults = the hand-built night hero (owner-approved 2026-11-12). The BWE Hero widget
	 * overrides them through its data-bwex-hero JSON (Animation tab). */
	var HERO_DEFAULTS = {
		on: true, speed: 1, delay: 0, stagger: 0.055, words: 'rise',
		header: true, bg: true, pill: true, line: true, lead: true, btns: true, proof: true, cue: true,
		pointer: 1, magnet: 1, fade: [ 70, 0.15 ], swell: 1.35, gx: 50, gy: 30
	};

	function heroOptions( sec ) {
		var o = {};
		var k;
		for ( k in HERO_DEFAULTS ) { o[ k ] = HERO_DEFAULTS[ k ]; }
		var raw = sec.getAttribute( 'data-bwex-hero' );
		if ( raw ) {
			try {
				var d = JSON.parse( raw );
				for ( k in d ) { if ( Object.prototype.hasOwnProperty.call( d, k ) ) { o[ k ] = d[ k ]; } }
			} catch ( e ) { /* bad JSON: keep defaults */ }
		}
		return o;
	}

	function editMode() {
		return !! ( window.elementorFrontend && window.elementorFrontend.isEditMode && window.elementorFrontend.isEditMode() );
	}

	/* Hero: entrance timeline, pointer-led glow + grid, magnetic button, scroll fade.
	 * Runs on the BWE Hero widget (either theme) and on the older hand-built night hero. */
	function hero( gsap, sec ) {
		if ( ! sec || sec.__bwexHero ) { return; }
		sec.__bwexHero = true;
		var o = heroOptions( sec );
		var night = sec.classList.contains( 'bwe-hero--night' );
		var q = function ( s ) { return sec.querySelector( s ); };
		// Drop the pre-hide first, or the scroll tweens below record opacity 0 as their start value.
		document.documentElement.classList.remove( 'bwex-hero-pre' );

		gsap.context( function () {
			var h1 = q( '.bwe-hero__title' ) || q( 'h1' );
			var copy = q( '.bwe-hero__copy' );
			var em = h1 && h1.querySelector( 'em' );
			var lineVar = night ? '--bwex-line' : '--bwex-mark';
			var cue = q( '.bwex-scroll' );
			var t = 1.7 / Math.max( 0.05, o.speed || 1 ); // 1.7 = owner-tuned pace (2026-11-13: 1.0 felt too fast, the old 3-4s too slow)
			var v;

			if ( o.on ) {
				var words = [];
				if ( h1 && o.words ) {
					h1.setAttribute( 'aria-label', h1.textContent.replace( /\s+/g, ' ' ).trim() );
					splitWords( h1 );
					Array.prototype.forEach.call( h1.querySelectorAll( '.bwex-w' ), function ( w ) { w.setAttribute( 'aria-hidden', 'true' ); } );
					words = h1.querySelectorAll( '.bwex-w__i' );
				}
				var header = o.header && ! editMode() ? document.querySelector( '.bwe-hf.is-transparent' ) : null;
				var faces = sec.querySelectorAll( '.bwe-proof__face' );
				var proofText = q( '.bwe-proof .bwe-legacy-text' ) || q( '.bwe-proof p' );

				if ( o.bg ) { gsap.set( sec, { '--bwex-glow-o': 0, '--bwex-glow-s': 0.6, '--bwex-grid-o': 0 } ); }
				if ( em && o.line ) {
					v = {};
					v[ lineVar ] = night ? 0 : '0%';
					gsap.set( em, v );
				}

				// Fast entrance (2026-11-13, owner: "hero loads very slowly"): everything overlaps and the
				// whole hero is in place in about 1s. The word stagger is capped so long headlines stay quick.
				var tl = gsap.timeline( { delay: Math.max( 0, Math.min( o.delay || 0, 2 ) ), defaults: { ease: 'power3.out' } } );
				if ( header ) { tl.from( header, { yPercent: -100, autoAlpha: 0, duration: 0.5 * t, clearProps: 'transform,opacity,visibility' }, 0 ); }
				if ( o.bg ) {
					tl.to( sec, { '--bwex-glow-o': 1, '--bwex-glow-s': 1, duration: 1.1 * t, ease: 'power2.out' }, 0 )
						.to( sec, { '--bwex-grid-o': 1, duration: 0.8 * t, ease: 'power1.out' }, 0.05 * t );
				}
				if ( o.pill && q( '.bwe-pill' ) ) { tl.from( q( '.bwe-pill' ), { y: -12, autoAlpha: 0, duration: 0.4 * t }, 0 ); }
				if ( words.length ) {
					var from;
					if ( 'fade' === o.words ) {
						from = { autoAlpha: 0, y: 8, ease: 'power2.out' };
					} else if ( 'blur' === o.words ) {
						from = { autoAlpha: 0, filter: 'blur(8px)', ease: 'power2.out', clearProps: 'filter' };
					} else {
						from = { yPercent: 110, rotate: 3, ease: 'power4.out' };
					}
					from.duration = 0.6 * t;
					from.stagger = Math.min( o.stagger, 0.3 / words.length ) * t;
					tl.from( words, from, 0.05 * t );
				}
				if ( em && o.line ) {
					v = { duration: 0.45 * t, ease: 'power2.inOut' };
					v[ lineVar ] = night ? 1 : '100%';
					tl.to( em, v, 0.4 * t );
				}
				if ( o.lead && q( '.bwe-lead' ) ) { tl.from( q( '.bwe-lead' ), { y: 14, autoAlpha: 0, duration: 0.5 * t }, 0.25 * t ); }
				var btns = sec.querySelectorAll( '.bwe-actions > *' );
				if ( o.btns && btns.length ) { tl.from( btns, { y: 14, scale: 0.96, autoAlpha: 0, duration: 0.45 * t, stagger: 0.06 * t, ease: 'back.out(1.6)' }, 0.35 * t ); }
				if ( o.proof && q( '.bwe-proof' ) ) {
					tl.from( q( '.bwe-proof' ), { autoAlpha: 0, duration: 0.4 * t }, 0.45 * t );
					if ( faces.length ) { tl.from( faces, { x: -10, autoAlpha: 0, duration: 0.35 * t, stagger: 0.04 * t }, '<' ); }
					if ( proofText ) { tl.from( proofText, { x: 8, autoAlpha: 0, duration: 0.4 * t }, '<' + ( 0.1 * t ) ); }
				}
				if ( o.cue && cue ) { tl.from( cue, { y: -8, autoAlpha: 0, duration: 0.4 * t }, 0.6 * t ); }
			}

			if ( window.matchMedia( '(hover: hover) and (pointer: fine)' ).matches ) {
				// Pointer: the glow drifts toward the cursor, the grid shifts a little the other way.
				if ( o.pointer ) {
					var k = o.pointer;
					var gx = gsap.quickTo( sec, '--bwex-hx', { duration: 1.4, ease: 'power3.out' } );
					var gy = gsap.quickTo( sec, '--bwex-hy', { duration: 1.4, ease: 'power3.out' } );
					var px = gsap.quickTo( sec, '--bwex-px', { duration: 1.2, ease: 'power3.out' } );
					var py = gsap.quickTo( sec, '--bwex-py', { duration: 1.2, ease: 'power3.out' } );
					gsap.set( sec, { '--bwex-hx': o.gx, '--bwex-hy': o.gy, '--bwex-px': 0, '--bwex-py': 0 } );
					sec.addEventListener( 'pointermove', function ( e ) {
						var r = sec.getBoundingClientRect();
						var nx = ( e.clientX - r.left ) / r.width;
						var ny = ( e.clientY - r.top ) / r.height;
						gx( o.gx + ( nx - 0.5 ) * 45 * k );
						gy( o.gy + ( ny - 0.5 ) * 35 * k );
						px( ( nx - 0.5 ) * -24 * k );
						py( ( ny - 0.5 ) * -24 * k );
					} );
					sec.addEventListener( 'pointerleave', function () { gx( o.gx ); gy( o.gy ); px( 0 ); py( 0 ); } );
				}
				// Magnetic primary button: disabled, the hero button must not move.
				var btn = null;
				if ( btn ) {
					var m = o.magnet;
					var bx = gsap.quickTo( btn, 'x', { duration: 0.5, ease: 'power3.out' } );
					var by = gsap.quickTo( btn, 'y', { duration: 0.5, ease: 'power3.out' } );
					btn.addEventListener( 'pointermove', function ( e ) {
						var b = btn.getBoundingClientRect();
						bx( ( e.clientX - b.left - b.width / 2 ) * 0.25 * m );
						by( ( e.clientY - b.top - b.height / 2 ) * 0.35 * m );
					} );
					btn.addEventListener( 'pointerleave', function () { bx( 0 ); by( 0 ); } );
				}
			}

			// Scroll away: copy drifts up, glow swells, cue fades.
			// 2026-11-20 (owner: hero text looked dim/broken): the copy NO LONGER FADES, it stays at full
			// opacity and only drifts up. The old scrubbed ScrollTrigger tween (y -70, opacity .15) could be
			// left in its scrolled-away state with the page at the top. The drift is now computed straight
			// from where the hero sits on screen (every frame + scroll/resize/pageshow), so it can't go stale.
			if ( copy && o.fade ) {
				var setY = gsap.quickSetter( copy, 'y', 'px' );
				gsap.set( copy, { opacity: 1, visibility: 'visible' } );
				var fadeLastTop = null;
				var fadeNow = function () {
					var top = sec.getBoundingClientRect().top;
					if ( top === fadeLastTop ) { return; }
					fadeLastTop = top;
					var p = Math.min( 1, Math.max( 0, -top / ( sec.offsetHeight || 1 ) ) );
					setY( -o.fade[ 0 ] * p );
				};
				window.addEventListener( 'scroll', fadeNow, { passive: true } );
				gsap.ticker.add( fadeNow ); // backstop: a missed scroll event can't leave it stale
				window.addEventListener( 'resize', fadeNow );
				window.addEventListener( 'pageshow', fadeNow );
				window.addEventListener( 'load', fadeNow );
				fadeNow();
			}
			if ( o.swell ) {
				gsap.to( sec, { '--bwex-glow-s': o.swell, ease: 'none', scrollTrigger: { trigger: sec, start: 'top top', end: 'bottom top', scrub: true } } );
			}
			if ( cue ) {
				gsap.to( cue, { autoAlpha: 0, ease: 'none', scrollTrigger: { trigger: sec, start: 'top top', end: '20% top', scrub: true } } );
			}
		}, sec );

		// Scroll cue click: the anchor it names, else the section after the hero.
		var cueLink = q( '.bwex-scroll' );
		if ( cueLink ) {
			cueLink.addEventListener( 'click', function ( e ) {
				var href = cueLink.getAttribute( 'href' ) || '';
				var target = null;
				if ( href.length > 1 && href.charAt( 0 ) === '#' ) {
					try { target = document.querySelector( href ); } catch ( err ) { target = null; }
				}
				if ( ! target ) {
					var host = sec.closest( '.elementor-widget-bwex-hero' ) || sec;
					target = host.nextElementSibling || ( host.parentElement && host.parentElement.nextElementSibling );
				}
				if ( target ) { e.preventDefault(); target.scrollIntoView( { behavior: 'smooth' } ); }
			} );
		}
	}

	function heroes( gsap, scope ) {
		( scope || document ).querySelectorAll( '.bwex-hero, .bwex .bwe-hero--night' ).forEach( function ( sec ) { hero( gsap, sec ); } );
	}

	/* Scrollbar width, so full-bleed widgets (100vw) don't cause sideways scrolling on desktop. */
	function scrollbarVar() {
		var set = function () {
			var d = document.documentElement;
			d.style.setProperty( '--bwex-sbw', Math.max( 0, window.innerWidth - d.clientWidth ) + 'px' );
		};
		set();
		window.addEventListener( 'resize', set, { passive: true } );
		window.addEventListener( 'load', set );
	}

	function run() {
		document.documentElement.classList.add( 'bwex-fx' );
		scrollbarVar();
		glow();
		if ( reduced || ! window.gsap || ! window.ScrollTrigger ) {
			document.documentElement.classList.remove( 'bwex-hero-pre' );
			return;
		}
		window.gsap.registerPlugin( window.ScrollTrigger );
		heroes( window.gsap );
		document.documentElement.classList.remove( 'bwex-hero-pre' );
		marks( window.gsap );
		counters( window.gsap );
	}

	/* Elementor editor: the widget is re-rendered on every change, so run the hero again on the new markup. */
	function editorHooks() {
		var ef = window.elementorFrontend;
		if ( ! ef || ! ef.hooks || ! ef.isEditMode || ! ef.isEditMode() ) { return; }
		ef.hooks.addAction( 'frontend/element_ready/bwex-hero.default', function ( $el ) {
			var el = $el && $el[ 0 ];
			document.documentElement.classList.remove( 'bwex-hero-pre' );
			if ( ! el || reduced || ! window.gsap || ! window.ScrollTrigger ) { return; }
			window.gsap.registerPlugin( window.ScrollTrigger );
			heroes( window.gsap, el );
			window.ScrollTrigger.refresh();
		} );
	}
	if ( window.elementorFrontend && window.elementorFrontend.hooks ) {
		editorHooks();
	} else if ( window.jQuery ) {
		window.jQuery( window ).on( 'elementor/frontend/init', editorHooks );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', run );
	} else {
		run();
	}
}() );
