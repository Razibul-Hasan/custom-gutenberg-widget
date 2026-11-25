/**
 * Phone slider (includes/mobile-slider.php): dots and arrows for a card row that swipes on phones, and the
 * edge-to-edge row — sets --bwe-ms-bleed-l / -r to the distance between the row and the screen edges, so cards
 * slide in from the edge while the first one still lines up with the page text. Only works while the row actually
 * scrolls; where the list is the normal grid the nav stays hidden.
 */
( function () {
	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	function setup( track ) {
		var nav = track.nextElementSibling;
		if ( ! nav || ! nav.classList.contains( 'bwe-ms__nav' ) ) {
			nav = null;
		}
		var dots = nav ? Array.prototype.slice.call( nav.querySelectorAll( '.bwe-ms__dot' ) ) : [];
		var prev = nav && nav.querySelector( '.bwe-ms__arrow--prev' );
		var next = nav && nav.querySelector( '.bwe-ms__arrow--next' );
		var frame = 0;
		var current = -1;

		// Cards shown at this width (a card hidden on phones with the Visibility setting has no box).
		function slides() {
			return Array.prototype.filter.call( track.children, function ( el ) {
				return el.getClientRects().length > 0;
			} );
		}

		function scrolls() {
			return 'auto' === getComputedStyle( track ).overflowX && track.scrollWidth > track.clientWidth + 2;
		}

		function bleed() {
			var parent = track.parentElement;
			var ps = getComputedStyle( parent );
			var r = parent.getBoundingClientRect();
			var vw = document.documentElement.clientWidth;
			var left = Math.max( 0, Math.round( r.left + parseFloat( ps.paddingLeft ) + parseFloat( ps.borderLeftWidth ) ) );
			var right = Math.max( 0, Math.round( vw - ( r.right - parseFloat( ps.paddingRight ) - parseFloat( ps.borderRightWidth ) ) ) );
			track.style.setProperty( '--bwe-ms-bleed-l', left + 'px' );
			track.style.setProperty( '--bwe-ms-bleed-r', right + 'px' );
			// The desktop slider sizes its cards around the row's own gap ("Space between items").
			track.style.setProperty( '--bwe-ms-gap', ( parseFloat( getComputedStyle( track ).columnGap ) || 0 ) + 'px' );
		}

		// Number of places the row can stop at: with several cards in view (desktop) the last ones share the end.
		function stops( list ) {
			var max = track.scrollWidth - track.clientWidth - 2;
			for ( var i = 1; i < list.length; i++ ) {
				if ( list[ i ].offsetLeft - list[ 0 ].offsetLeft >= max ) {
					return i + 1;
				}
			}
			return list.length;
		}

		// Index of the card nearest the row's start (the last stop once the row is scrolled to the end).
		function activeIndex( list ) {
			if ( track.scrollLeft >= track.scrollWidth - track.clientWidth - 2 ) {
				return stops( list ) - 1;
			}
			var start = track.getBoundingClientRect().left + parseFloat( getComputedStyle( track ).paddingLeft );
			var best = 0;
			var bestDist = Infinity;
			list.forEach( function ( el, i ) {
				var d = Math.abs( el.getBoundingClientRect().left - start );
				if ( d < bestDist ) {
					bestDist = d;
					best = i;
				}
			} );
			return best;
		}

		function update() {
			frame = 0;
			if ( ! nav ) {
				return;
			}
			var on = scrolls();
			nav.classList.toggle( 'is-ready', on );
			if ( ! on ) {
				return;
			}
			var list = slides();
			var i = activeIndex( list );
			var count = stops( list );
			dots.forEach( function ( dot, n ) {
				dot.hidden = n >= count;
				if ( n === i ) {
					dot.setAttribute( 'aria-current', 'true' );
				} else {
					dot.removeAttribute( 'aria-current' );
				}
			} );
			if ( prev ) {
				prev.disabled = track.scrollLeft <= 2;
			}
			if ( next ) {
				next.disabled = track.scrollLeft >= track.scrollWidth - track.clientWidth - 2;
			}
			if ( i !== current ) {
				current = i;
				list.forEach( function ( el, n ) {
					el.classList.toggle( 'is-active', n === i );
				} );
			}
		}

		function queue() {
			if ( ! frame ) {
				frame = requestAnimationFrame( update );
			}
		}

		function goTo( i ) {
			var list = slides();
			var el = list[ Math.max( 0, Math.min( i, list.length - 1 ) ) ];
			if ( ! el ) {
				return;
			}
			var start = track.getBoundingClientRect().left + parseFloat( getComputedStyle( track ).paddingLeft );
			track.scrollTo( { left: track.scrollLeft + el.getBoundingClientRect().left - start, behavior: reduce ? 'auto' : 'smooth' } );
		}

		dots.forEach( function ( dot, n ) {
			dot.addEventListener( 'click', function () {
				goTo( n );
			} );
		} );
		if ( prev ) {
			prev.addEventListener( 'click', function () {
				goTo( activeIndex( slides() ) - 1 );
			} );
		}
		if ( next ) {
			next.addEventListener( 'click', function () {
				goTo( activeIndex( slides() ) + 1 );
			} );
		}
		track.addEventListener( 'scroll', queue, { passive: true } );
		window.addEventListener( 'resize', function () {
			bleed();
			queue();
		} );
		window.addEventListener( 'load', function () {
			bleed();
			queue();
		} );
		bleed();
		update();
	}

	function init() {
		Array.prototype.forEach.call( document.querySelectorAll( '.bwe-ms' ), setup );
	}
	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
