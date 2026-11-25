// Layout anomaly scan, evaluated inside a document. Expects d (document), W (window) and ROOT (element) in scope;
// defines `anomalies` (array of strings). Used by editor-check.mjs.
const anomalies = [];
{
	const vw = d.documentElement.clientWidth;
	const label = ( e ) => e.tagName.toLowerCase() + '.' + String( e.className || '' ).split( /\s+/ ).filter( ( c ) => c && ! /^(block-editor|wp-block|is-|has-|elementor-element-|e-con|e-flex|e-child|rich-text$)/.test( c ) ).slice( 0, 3 ).join( '.' );
	for ( const e of ROOT.querySelectorAll( '*' ) ) {
		const r = e.getBoundingClientRect();
		if ( ! r.width || ! r.height ) continue;
		const c = W.getComputedStyle( e );
		const own = [ ...e.childNodes ].filter( ( n ) => n.nodeType === 3 ).map( ( n ) => n.textContent ).join( '' ).trim();
		if ( own.length > 12 && r.width < 90 && r.height > parseFloat( c.lineHeight || 20 ) * 3.5 ) anomalies.push( 'NARROW ' + label( e ) + ' ' + Math.round( r.width ) + 'x' + Math.round( r.height ) + ' "' + own.slice( 0, 30 ) + '"' );
		if ( r.right > vw + 4 && c.position !== 'fixed' && ! e.closest( '[aria-hidden=true],.bwe-work__art,.prs-block,iframe' ) ) anomalies.push( 'OVERFLOW ' + label( e ) + ' right=' + Math.round( r.right ) + ' vw=' + vw );
		if ( parseFloat( c.borderTopWidth ) > 0 && parseFloat( c.borderTopLeftRadius ) > 4 ) {
			let a = e.parentElement;
			for ( let k = 0; k < 3 && a; k++, a = a.parentElement ) {
				const ac = W.getComputedStyle( a ); const ar = a.getBoundingClientRect();
				if ( parseFloat( ac.borderTopWidth ) > 0 && parseFloat( ac.borderTopLeftRadius ) > 4 && Math.abs( ar.width - r.width ) < 90 && ar.width > 0 ) { anomalies.push( 'NESTED-CARD ' + label( a ) + ' > ' + label( e ) ); break; }
			}
		}
	}
}
