// Browser side of the Styles-tab control audit (injected by tools/scenarios/controls.mjs and tools/control-audit-front.mjs).
// Needs `styleCss` (src/blocks/shared/style-engine.js, injected before this) in scope.
//
// For every setting of a block's style map it applies ONE value, then counts how many elements in the block
// visibly changed (computed colour, size, spacing, layout, display, also on ::before/::after) against the
// untouched block. 0 changed elements = the control does nothing there. Hover and phone/tablet rules are also
// tried as plain rules (copy without :hover / media), so they are judged on what they would do.
// Then every setting is applied at once to find settings that a stronger setting silently overrides.
const AUDIT_PROPS = [ 'color', 'background-color', 'background-image', 'border-top-color', 'border-left-color', 'border-top-width', 'border-top-left-radius', 'box-shadow', 'font-size', 'font-weight', 'line-height', 'letter-spacing', 'padding-top', 'padding-bottom', 'padding-left', 'margin-top', 'margin-bottom', 'max-width', 'min-height', 'text-align', 'display', 'grid-template-columns', 'column-gap', 'row-gap', 'width', 'height', 'opacity', 'text-decoration-color', 'fill', 'stroke', 'outline-color', 'transform' ];
const AUDIT_IMAGE = location.origin + '/wp-content/uploads/2026/11/774-1024x538.png';

// A different test colour per setting, so the all-at-once pass can tell which setting won.
function auditColor( key ) {
	let h = 0;
	for ( const c of key ) h = ( h * 31 + c.charCodeAt( 0 ) ) >>> 0;
	return '#' + ( 0x200000 + ( h % 0xc00000 ) ).toString( 16 ).padStart( 6, '0' );
}

function auditValues( setting ) {
	switch ( setting.control ) {
		case 'color':
			return [ auditColor( setting.key ) ];
		case 'unit':
			return [ '37px' ];
		case 'range':
			return [ String( setting.max ), String( setting.min ) ];
		case 'select':
			return setting.options.map( ( o ) => o.value );
		case 'toggle':
			return [ true ];
		case 'image':
			return [ AUDIT_IMAGE ];
	}
	return [];
}

function auditSnapshot( W, root ) {
	const els = [ root, ...root.querySelectorAll( '*' ) ].slice( 0, 2500 );
	const out = new Map();
	els.forEach( ( el ) => {
		[ '', '::before', '::after' ].forEach( ( pseudo ) => {
			const cs = W.getComputedStyle( el, pseudo || null );
			if ( pseudo && ( cs.content === 'none' || cs.content === 'normal' ) ) return;
			out.set( el, out.get( el ) || {} );
			out.get( el )[ pseudo ] = AUDIT_PROPS.map( ( p ) => cs.getPropertyValue( p ) ).join( '|' );
		} );
	} );
	return out;
}

function auditDiff( a, b ) {
	let n = 0;
	const props = new Set();
	b.forEach( ( v, el ) => {
		const o = a.get( el );
		if ( ! o ) return;
		Object.keys( v ).forEach( ( pseudo ) => {
			if ( o[ pseudo ] === undefined || o[ pseudo ] === v[ pseudo ] ) return;
			n++;
			const x = o[ pseudo ].split( '|' );
			const y = v[ pseudo ].split( '|' );
			AUDIT_PROPS.forEach( ( p, i ) => x[ i ] !== y[ i ] && props.add( pseudo + p ) );
		} );
	} );
	return { n, props: [ ...props ].slice( 0, 6 ) };
}

// A copy of a setting's rules as plain desktop rules (no :hover, no media), to judge hover/phone rules.
function auditPlain( setting ) {
	const rules = setting.rules.filter( ( r ) => r.media || /:hover/.test( r.sel || '' ) );
	return rules.length ? { ...setting, rules: rules.map( ( r ) => ( { ...r, sel: ( r.sel || '' ).replace( /:hover/g, '' ), media: undefined } ) ) } : null;
}

// The computed value a rule sets on a target. Unitless line-height follows the font size and column widths follow
// the gap, so those are compared as ratio / track count.
function auditValue( W, t, r ) {
	const pseudo = ( r.sel || '' ).match( /::?(before|after)$/ )?.[ 0 ] || null;
	const cs = W.getComputedStyle( t, pseudo );
	const v = cs.getPropertyValue( r.prop );
	if ( r.prop === 'line-height' ) return ( parseFloat( v ) / parseFloat( cs.fontSize ) ).toFixed( 2 );
	if ( r.prop === 'grid-template-columns' ) return String( v.split( ' ' ).length );
	return v;
}

function auditTargets( root, sel ) {
	// A leading ":not(#…)" is attached to the block itself (extra weight), not a descendant selector.
	const s = ( sel || '' ).replace( /::?(before|after)$/, '' ).replace( /:hover/g, '' ).replace( /^(:not\([^)]*\))+/, '' ).trim();
	try {
		return s ? [ ...root.querySelectorAll( s ) ] : [ root ];
	} catch ( e ) {
		return [];
	}
}

/**
 * Step-by-step audit so the runner can time each setting: start(spec), then one(key) per setting, then conflicts().
 * spec = { W, d, map, root(): Element, apply( values ): Promise }.
 */
const bweAudit = {
	async start( spec ) {
		this.spec = spec;
		this.alone = {};
		this.extra = spec.d.createElement( 'style' );
		spec.d.head.appendChild( this.extra );
		// Colour/size transitions would be caught half-way; measure end states.
		this.still = spec.d.createElement( 'style' );
		// Four ID-weights + !important: beats the site's own !important transitions.
		const strong = ':not(#bwe-ax):not(#bwe-ay):not(#bwe-az):not(#bwe-aw)';
		// Only inside the measured block: on the whole editor document this rule stalls the editor.
		spec.root().setAttribute( 'data-bwe-audit', '' );
		const inside = `html body [data-bwe-audit]${ strong }`;
		this.still.textContent = `${ inside }, ${ inside } *${ strong }, ${ inside } *${ strong }::before, ${ inside } *${ strong }::after, ${ inside }::before, ${ inside }::after{transition:none!important;animation:none!important}`;
		spec.d.head.appendChild( this.still );
		await spec.apply( {} );
		this.base = auditSnapshot( spec.W, spec.root() );
		return this.base.size;
	},
	async one( key ) {
		const { W, map, root, apply } = this.spec;
		const setting = map.find( ( s ) => s.key === key );
		const plain = this.spec.noPlain ? null : auditPlain( setting );
		const tried = [];
		for ( const v of auditValues( setting ) ) {
			const t0 = performance.now();
			await apply( { [ setting.key ]: v } );
			const cls = [ ...root().classList ].find( ( c ) => /^bwe-s-/.test( c ) ) || '';
			this.extra.textContent = plain && cls ? styleCss( [ plain ], { [ setting.key ]: v }, cls ) : '';
			const snap = auditSnapshot( W, root() );
			tried.push( { v, scoped: !! cls, ms: Math.round( performance.now() - t0 ), ...auditDiff( this.base, snap ) } );
			if ( tried.length === 1 ) {
				this.alone[ setting.key ] = setting.rules.map( ( r ) => ( r.media || /:hover/.test( r.sel || '' ) || /^--/.test( r.prop ) ? null : auditTargets( root(), r.sel ).map( ( t ) => auditValue( W, t, r ) ) ) );
			}
			this.extra.textContent = '';
		}
		await apply( {} );
		return { key: setting.key, panel: setting.panel, label: setting.label, control: setting.control, targets: setting.rules.map( ( r ) => auditTargets( root(), r.sel ).length ), tried };
	},
	// Everything at once: does each setting still win where it applies?
	async conflicts() {
		const { W, map, root, apply } = this.spec;
		const all = {};
		map.forEach( ( s ) => ( all[ s.key ] = auditValues( s )[ 0 ] ) );
		await apply( all );
		const out = [];
		// "general": true marks a broad setting that the more specific ones are meant to override.
		map.forEach( ( s ) => ! s.general && s.rules.forEach( ( r, i ) => {
			const want = this.alone[ s.key ]?.[ i ];
			// Sizes in px follow the other layout settings (columns, padding), so they are not comparable here.
			if ( ! want || /^(width|height|max-width|min-height)$/.test( r.prop ) ) return;
			const got = auditTargets( root(), r.sel ).map( ( t ) => auditValue( W, t, r ) );
			const lost = got.filter( ( g, j ) => g !== want[ j ] ).length;
			if ( lost ) out.push( { key: s.key, prop: r.prop, sel: r.sel, lost, of: got.length, want: want[ 0 ], got: got.find( ( g, j ) => g !== want[ j ] ) } );
		} ) );
		await apply( {} );
		this.extra.remove();
		this.still.remove();
		root().removeAttribute( 'data-bwe-audit' );
		return out;
	},
};
