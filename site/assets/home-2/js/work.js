/**
 * Portfolio "Selected work" rows (2026-11-22): the hovered row's screenshot follows the cursor.
 * Sets --x / --y (px, relative to the row) on the screenshot; work.css turns them into `translate`.
 * Keeps the preview inside the row's width; vertically centred on the cursor.
 */
( function () {
	if ( ! window.matchMedia || ! window.matchMedia( '(hover: hover) and (pointer: fine)' ).matches ) {
		return;
	}
	var rows = document.querySelectorAll( '.bwex-work__item' );
	Array.prototype.forEach.call( rows, function ( row ) {
		var shot = row.querySelector( '.bwex-work__shot' );
		if ( ! shot ) {
			return;
		}
		var frame = 0;
		var move = function ( e ) {
			if ( frame ) {
				return;
			}
			frame = requestAnimationFrame( function () {
				frame = 0;
				var r = row.getBoundingClientRect();
				var w = shot.offsetWidth;
				var h = shot.offsetHeight;
				var x = e.clientX - r.left + 32; // a little right of the cursor
				if ( x + w > r.width ) {
					x = e.clientX - r.left - w - 32; // flip to the left near the right edge
				}
				x = Math.max( 0, Math.min( x, r.width - w ) );
				var y = e.clientY - r.top - h / 2;
				shot.style.setProperty( '--x', x + 'px' );
				shot.style.setProperty( '--y', y + 'px' );
			} );
		};
		row.addEventListener( 'pointerenter', move );
		row.addEventListener( 'pointermove', move );
	} );
} )();
