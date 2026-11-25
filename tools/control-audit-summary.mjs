// Turns a control-audit report (one entry per block instance) into the findings that matter:
//  dead      = block type + setting that changed nothing in ANY instance (the control does nothing),
//  deadValue = a select option / range end that changed nothing anywhere,
//  conflicts = a setting that another setting overrides when both are used,
//  unscoped  = the block never got its scope class (the settings never reached the page).
export function summarizeAudit( report ) {
	const byKey = {};
	const errors = [];
	const unscoped = new Set();
	const conflicts = new Map();
	report.forEach( ( b ) => {
		if ( b.error ) return errors.push( `${ b.label }: ${ b.error }` );
		b.settings.forEach( ( s ) => {
			const k = `${ b.name } ${ s.key }`;
			byKey[ k ] = byKey[ k ] || { panel: s.panel, label: s.label, works: [], dead: [], values: {} };
			const any = s.tried.some( ( t ) => t.n > 0 );
			( any ? byKey[ k ].works : byKey[ k ].dead ).push( b.label );
			s.tried.forEach( ( t ) => {
				const v = String( t.v );
				byKey[ k ].values[ v ] = byKey[ k ].values[ v ] || 0;
				if ( t.n > 0 ) byKey[ k ].values[ v ]++;
				if ( ! t.scoped && v !== '' ) unscoped.add( `${ b.label } ${ s.key }` );
			} );
		} );
		( b.conflicts || [] ).forEach( ( c ) => {
			const k = `${ b.name } ${ c.key } (${ c.prop } on${ c.sel || ' the block' })`;
			conflicts.set( k, [ ...( conflicts.get( k ) || [] ), b.label ] );
		} );
	} );
	const dead = [];
	const deadValue = [];
	const partly = [];
	Object.entries( byKey ).forEach( ( [ k, r ] ) => {
		if ( ! r.works.length ) dead.push( `${ k } [${ r.panel } › ${ r.label }]` );
		else {
			Object.entries( r.values ).forEach( ( [ v, n ] ) => n === 0 && v !== '' && deadValue.push( `${ k } = ${ v }` ) );
			if ( r.dead.length ) partly.push( `${ k }: no effect in ${ r.dead.join( ', ' ) }` );
		}
	} );
	return { dead, deadValue, conflicts: [ ...conflicts ].map( ( [ k, v ] ) => `${ k } — in ${ v.length } block(s)` ), unscoped: [ ...unscoped ].slice( 0, 20 ), errors, partly };
}
