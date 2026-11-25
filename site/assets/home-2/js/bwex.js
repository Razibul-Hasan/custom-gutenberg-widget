/* BWE Extension front-end. No dependencies. */
( function () {
	'use strict';
	document.documentElement.classList.add( 'bwex-js' );

	var inits = [];

	/* Runs every widget initialiser inside a scope (document or one Elementor element). */
	window.bwexInit = function ( scope ) {
		inits.forEach( function ( fn ) {
			fn( scope || document );
		} );
	};
	window.bwexInit.add = function ( fn ) {
		inits.push( fn );
	};

	/* FAQ: "Show N more" toggle. Extra questions are only hidden when this script runs (html.bwex-js). */
	window.bwexInit.add( function ( scope ) {
		scope.querySelectorAll( '.bwex-faq__toggle' ).forEach( function ( btn ) {
			if ( btn.dataset.bwexReady ) {
				return;
			}
			btn.dataset.bwexReady = '1';
			var list = document.getElementById( btn.getAttribute( 'aria-controls' ) );
			btn.addEventListener( 'click', function () {
				var open = btn.getAttribute( 'aria-expanded' ) !== 'true';
				btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
				btn.textContent = open ? btn.dataset.less : btn.dataset.more;
				if ( list ) {
					list.classList.toggle( 'is-open', open );
				}
				if ( window.ScrollTrigger ) {
					window.ScrollTrigger.refresh();
				}
			} );
		} );
	} );

	/* Hero background: the spotlight follows the cursor (desktop, motion allowed). */
	window.bwexInit.add( function ( scope ) {
		var still = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce), (hover: none)' ).matches;
		scope.querySelectorAll( '.bwex-herobg[data-pointer="1"]' ).forEach( function ( bg ) {
			var host = bg.closest( '.e-con' ) || bg.parentNode;
			if ( still || bg.dataset.bwexReady ) {
				return;
			}
			bg.dataset.bwexReady = '1';
			var raf = 0;
			host.addEventListener( 'pointermove', function ( e ) {
				if ( raf ) {
					return;
				}
				raf = window.requestAnimationFrame( function () {
					raf = 0;
					var r = bg.getBoundingClientRect();
					bg.style.setProperty( '--bwex-hb-x', ( e.clientX - r.left ) + 'px' );
					bg.style.setProperty( '--bwex-hb-y', ( e.clientY - r.top ) + 'px' );
					bg.classList.add( 'is-pointing' );
				} );
			} );
			host.addEventListener( 'pointerleave', function () {
				bg.classList.remove( 'is-pointing' );
			} );
		} );
	} );

	document.addEventListener( 'DOMContentLoaded', function () {
		window.bwexInit( document );
	} );

	/* Inside the Elementor editor, widgets are re-rendered one by one. */
	window.addEventListener( 'elementor/frontend/init', function () {
		if ( ! window.elementorFrontend || ! window.elementorFrontend.isEditMode() ) {
			return;
		}
		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function ( $el ) {
			var el = $el && $el[ 0 ];
			if ( el && el.className && String( el.className ).indexOf( 'elementor-widget-bwex-' ) !== -1 ) {
				window.bwexInit( el );
			}
		} );
	} );
}() );
