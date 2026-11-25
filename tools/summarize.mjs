// Pipes editor-check.mjs JSON lines into a short table: target, invalid blocks, bwe/* counts, anomalies.
let s = '';
process.stdin.on( 'data', ( d ) => ( s += d ) ).on( 'end', () => {
	for ( const line of s.trim().split( '\n' ) ) {
		let j;
		try { j = JSON.parse( line ); } catch { console.log( line ); continue; }
		const bwe = Object.entries( j.counts || {} ).filter( ( [ k ] ) => k.startsWith( 'bwe/' ) ).map( ( [ k, v ] ) => k.slice( 4 ) + ':' + v ).join( ' ' );
		const total = Object.values( j.counts || {} ).reduce( ( a, b ) => a + b, 0 );
		const anom = ( j.anomalies || [] ).filter( ( a ) => ! /bwe-final__chat|bwex-card__btn|mmbb-|prs-/.test( a ) );
		console.log( [ j.target, ( j.ready === false ? 'NOT-READY' : 'ready' ) + ' ' + j.loadSec + 's', 'blocks ' + total, 'invalid ' + ( j.invalid || [ '?' ] ).length, bwe, anom.length ? 'ANOM ' + anom.slice( 0, 3 ).join( ' ; ' ) : '', j.scenario ? 'scenario ' + JSON.stringify( j.scenario ) : '', j.error || '' ].filter( Boolean ).join( ' | ' ) );
	}
} );
