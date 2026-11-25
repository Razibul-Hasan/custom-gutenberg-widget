// Front-end twin of the editor control audit: on the live page, each styled block's root gets a scope class and
// the CSS the PHP engine would print for one setting (same engine, src/blocks/shared/style-engine.js), then the
// audit counts what visibly changed. Desktop (1440px) judges every setting; phone (390px) re-judges the
// phone-only settings with their real media query.
// Usage: node control-audit-front.mjs [url]   → report in %TEMP%/bwe-control-audit-front.json, summary on stdout.
import { writeFileSync } from 'node:fs';
import { join } from 'node:path';
import { tmpdir } from 'node:os';
import { open } from './cdp.mjs';
import { styleMaps, auditSource } from './scenarios/controls.mjs';
import { summarizeAudit } from './control-audit-summary.mjs';

const url = process.argv[ 2 ] || 'http://bestwebexpert.local/';
// Optional: audit only the given blocks on that page — block=selector … (e.g. bwe/section=section.bwex-section).
const only = process.argv.slice( 3 ).map( ( a ) => a.split( '=' ) );
const maps = styleMaps();
const ROOTS = {
	'bwe/hero': 'section.bwex-hero[data-bwex-hero]',
	'bwe/services': 'section.bwex-svc-band',
	// Home's remaining generic sections (the others have their own blocks since 2026-11-23).
	'bwe/section': 'section#experts, section.bwex-who, section.bwex-about',
	'bwe/platforms': '#experts .bwex-plats',
	'bwe/platform-card': '#experts .bwex-plats > .elementor-widget-bwex-platform-card',
	// Home section blocks: the element that carries the block's scope class.
	'bwe/why-us': 'section#spec',
	'bwe/testimonials': 'section#testimonials',
	'bwe/pricing': 'section#pricing',
	'bwe/plans': '#pricing .bwex-plans',
	'bwe/price-plan': '#pricing .elementor-widget-bwex-pricing-plan',
	'bwe/starting-prices': '#pricing .bwex-pricenote',
	'bwe/cost-panel': '#pricing .bwex-cost',
	'bwe/process': 'section#process',
	'bwe/products': 'section#work',
	'bwe/product-card': '#work .elementor-widget-bwex-plugin-card',
	'bwe/faq': 'section#faq',
	'bwe/cta': 'section.bwe-final',
};
if ( only.length ) {
	Object.keys( ROOTS ).forEach( ( k ) => delete ROOTS[ k ] );
	only.forEach( ( [ k, v ] ) => ( ROOTS[ k ] = v ) );
}
const report = [];
for ( const [ width, mobileOnly ] of [ [ 1440, false ], [ 390, true ] ] ) {
	const b = await open( url, { width } );
	await b.evaluate( `${ auditSource() }; window.bweAudit = bweAudit; 1` );
	for ( const [ name, sel ] of Object.entries( ROOTS ) ) {
		const map = mobileOnly ? maps[ name ].filter( ( s ) => s.rules.some( ( r ) => r.media === 'mobile' ) ) : maps[ name ];
		if ( ! map.length ) continue;
		const count = await b.evaluate( `document.querySelectorAll(${ JSON.stringify( sel ) }).length` );
		for ( let i = 0; i < count; i++ ) {
			const started = await b.evaluate( `(async () => { const root = document.querySelectorAll(${ JSON.stringify( sel ) })[${ i }];
				root.classList.add('bwe-s-audit'); const st = document.createElement('style'); document.head.appendChild(st);
				const map = ${ JSON.stringify( map ) };
				window.__bweLabel = root.id || [...root.classList].filter((c) => /^bwex?-(services|spec|proof|pricing|who|process|work|about|faq-section|final|hero|svc-band|plats)$/.test(c)).join(' ') + (root.matches('.elementor-widget-bwex-platform-card') ? 'card ' + (root.querySelector('.bwex-plat__chip')?.textContent || '') : '');
				const apply = async (vals) => { st.textContent = styleCss(map, vals, 'bwe-s-audit'); };
				return bweAudit.start({ W: window, d: document, map, root: () => root, apply, noPlain: ${ mobileOnly } }); })()` );
			const entry = { name, label: ( await b.evaluate( 'window.__bweLabel' ) ) + ( mobileOnly ? ' @phone' : '' ), elements: started, settings: [] };
			for ( const s of map ) entry.settings.push( await b.evaluate( `bweAudit.one(${ JSON.stringify( s.key ) })` ) );
			entry.conflicts = mobileOnly ? [] : await b.evaluate( 'bweAudit.conflicts()' );
			await b.evaluate( `document.querySelectorAll('.bwe-s-audit').forEach((e) => e.classList.remove('bwe-s-audit')); 1` );
			report.push( entry );
			console.error( entry.label, entry.settings.filter( ( s ) => s.tried.every( ( t ) => t.n === 0 ) ).map( ( s ) => s.key ).join( ' ' ) );
		}
	}
	b.close();
}
writeFileSync( join( tmpdir(), 'bwe-control-audit-front.json' ), JSON.stringify( report, null, 1 ) );
console.log( JSON.stringify( summarizeAudit( report ), null, 1 ) );
process.exit( 0 );
