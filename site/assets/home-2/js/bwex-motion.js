/* BWE Motion: GSAP + ScrollTrigger animations set from Elementor's Advanced tab. */
( function () {
	'use strict';

	var reduced = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* Starting state for each effect (GSAP animates from this to the element's natural state). */
	function fromVars( o ) {
		var d = o.distance;
		switch ( o.effect ) {
			case 'fade-up': return { autoAlpha: 0, y: d };
			case 'fade-down': return { autoAlpha: 0, y: -d };
			case 'fade': return { autoAlpha: 0 };
			case 'slide-left': return { autoAlpha: 0, x: -d };
			case 'slide-right': return { autoAlpha: 0, x: d };
			case 'scale': return { autoAlpha: 0, scale: 0.92 };
			case 'blur': return { autoAlpha: 0, filter: 'blur(12px)' };
			case 'clip': return { clipPath: 'inset(0 0 100% 0)' };
			case 'stagger': return { autoAlpha: 0, y: d };
			default: return null;
		}
	}

	/* Children animated by "Stagger children": list items, a container's widgets, or direct children. */
	function staggerTargets( el ) {
		var list = el.querySelectorAll( '.bwex-num__item, .bwex-faq__item, li' );
		if ( list.length ) { return list; }
		var inner = el.querySelector( '.e-con-inner' ) || el;
		var kids = inner.querySelectorAll( ':scope > .elementor-element' );
		if ( kids.length ) { return kids; }
		var w = el.querySelector( '.elementor-widget-container' ) || el;
		return w.children;
	}

	function setup( el ) {
		var o;
		try { o = JSON.parse( el.getAttribute( 'data-bwex-motion' ) ); } catch ( e ) { return; }
		if ( ! o || ! o.effect ) { return; }
		if ( ! o.mobile && window.matchMedia( '(max-width: 767px)' ).matches ) { return; }

		if ( el._bwexMotion ) { el._bwexMotion.forEach( function ( t ) { t.kill(); } ); }
		el._bwexMotion = [];

		var st = {
			trigger: el,
			start: o.start || 'top 85%',
			toggleActions: o.once ? 'play none none none' : 'play none none reverse',
			once: !! o.once && ! o.scrub
		};
		if ( o.scrub ) { st.scrub = true; st.end = 'bottom 30%'; }

		if ( o.effect === 'parallax' ) {
			el._bwexMotion.push( window.gsap.fromTo( el, { y: o.distance }, {
				y: -o.distance, ease: 'none',
				scrollTrigger: { trigger: el, start: 'top bottom', end: 'bottom top', scrub: true }
			} ) );
			return;
		}

		var from = fromVars( o );
		if ( ! from ) { return; }
		var targets = o.effect === 'stagger' ? staggerTargets( el ) : el;
		var vars = { duration: o.duration, delay: o.delay, ease: o.ease, scrollTrigger: st, clearProps: o.once && ! o.scrub ? 'transform,filter,clipPath' : '' };
		if ( o.effect === 'stagger' ) { vars.stagger = o.stagger; }
		if ( o.effect === 'clip' ) { vars.clipPath = 'inset(0 0 0% 0)'; }
		el._bwexMotion.push( window.gsap.from( targets, Object.assign( from, vars ) ) );
	}

	function run( scope ) {
		if ( reduced || ! window.gsap || ! window.ScrollTrigger ) { return; }
		window.gsap.registerPlugin( window.ScrollTrigger );
		var root = scope || document;
		var els = root.matches && root.matches( '[data-bwex-motion]' ) ? [ root ] : [];
		els = els.concat( Array.prototype.slice.call( root.querySelectorAll( '[data-bwex-motion]' ) ) );
		els.forEach( setup );
		window.ScrollTrigger.refresh();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function () { run( document ); } );
	} else {
		run( document );
	}

	/* Editor preview: re-run when an element is re-rendered after a control change. */
	window.addEventListener( 'elementor/frontend/init', function () {
		if ( ! window.elementorFrontend || ! window.elementorFrontend.isEditMode() ) { return; }
		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function ( $el ) {
			if ( $el && $el[ 0 ] ) { run( $el[ 0 ] ); }
		} );
	} );
}() );
