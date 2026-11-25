// Editor scenario: every Styles-tab setting of every styled block on the target (bwe/hero, bwe/services,
// bwe/section…) is applied one at a time through the block store — the same path the controls use — and judged
// by what visibly changes in the canvas (see tools/control-audit-page.js). Nothing is saved.
// Full report: %TEMP%/bwe-control-audit-editor.json. ok = no setting is dead everywhere it is used and no conflicts.
import { readFileSync, readdirSync, existsSync, writeFileSync } from 'node:fs';
import { join, dirname } from 'node:path';
import { tmpdir } from 'node:os';
import { fileURLToPath } from 'node:url';
import { summarizeAudit } from '../control-audit-summary.mjs';

const TOOLS = dirname( dirname( fileURLToPath( import.meta.url ) ) );
const BUILD = join( TOOLS, '..', 'build', 'blocks' );

export function styleMaps() {
	const maps = {};
	readdirSync( BUILD ).forEach( ( dir ) => {
		const file = join( BUILD, dir, 'block.json' );
		if ( ! existsSync( file ) ) return;
		const json = JSON.parse( readFileSync( file, 'utf8' ) );
		if ( Array.isArray( json.bweStyleMap ) ) maps[ json.name ] = json.bweStyleMap;
	} );
	return maps;
}

export function auditSource() {
	const engine = readFileSync( join( TOOLS, '..', 'src', 'blocks', 'shared', 'style-engine.js' ), 'utf8' ).replace( /^export /gm, '' );
	return engine + '\n' + readFileSync( join( TOOLS, 'control-audit-page.js' ), 'utf8' );
}

export default async ( { evaluate, sleep } ) => {
	const maps = styleMaps();
	const blocks = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); const out = []; const names = ${ JSON.stringify( Object.keys( maps ) ) };
		const walk = (ids) => ids.forEach((id) => { const n = sel.getBlockName(id); if (names.includes(n)) { const a = sel.getBlockAttributes(id); out.push({ id, name: n, label: (a.metadata || {}).name || a.classes || n }); } walk(sel.getBlockOrder(id)); });
		walk(sel.getBlockOrder('')); return out; })()` );
	const report = [];
	const only = process.env.BWE_AUDIT_ONLY ? process.env.BWE_AUDIT_ONLY.split( ',' ) : null; // e.g. "0" or "bwe/hero"
	const limit = Number( process.env.BWE_AUDIT_LIMIT || 0 ); // debug: first N settings per block
	for ( const [ index, block ] of ( blocks || [] ).entries() ) {
		if ( only && ! only.includes( String( index ) ) && ! only.includes( block.name ) ) continue;
		const map = limit ? maps[ block.name ].slice( 0, limit ) : maps[ block.name ];
		const t0 = Date.now();
		// The editor now and then stalls for longer than one CDP call allows: wait and ask again (up to 3 times).
		const ev = async ( expr ) => {
			for ( let attempt = 0; attempt < 3; attempt++ ) {
				const r = await evaluate( `(async () => { try { return await (${ expr }); } catch (e) { return { error: String(e && e.stack || e) }; } })()`, true );
				if ( r !== undefined ) return r;
				await sleep( 5000 );
			}
			return { error: 'no answer (CDP timeout, 3 tries) for ' + expr.slice( 0, 60 ) };
		};
		await evaluate( `${ auditSource() }; window.bweAudit = bweAudit; 1` );
		const started = await ev( `(() => { const f = document.querySelector('iframe[name="editor-canvas"]'); const d = f.contentDocument; const W = f.contentWindow;
			const id = ${ JSON.stringify( block.id ) };
			const frame = () => new Promise((r) => W.requestAnimationFrame(() => W.requestAnimationFrame(r)));
			const apply = async (vals) => { wp.data.dispatch('core/block-editor').updateBlockAttributes(id, { bweStyle: vals }); await new Promise((r) => setTimeout(r, 120)); await frame(); };
			return bweAudit.start({ W, d, map: ${ JSON.stringify( map ) }, root: () => d.querySelector('[data-block="' + id + '"]'), apply }); })()` );
		const entry = { ...block, elements: started, settings: [] };
		if ( started?.error ) entry.error = started.error;
		else {
			for ( const s of map ) {
				const r = await ev( `bweAudit.one(${ JSON.stringify( s.key ) })` );
				if ( r?.error ) {
					entry.error = s.key + ': ' + r.error;
					break;
				}
				entry.settings.push( r );
				if ( process.env.BWE_AUDIT_VERBOSE ) console.error( block.label.slice( 0, 30 ), s.key, r.tried.map( ( t ) => t.ms + 'ms n=' + t.n ).join( ' ' ) );
			}
			if ( ! entry.error ) entry.conflicts = await ev( 'bweAudit.conflicts()' );
		}
		entry.sec = Math.round( ( Date.now() - t0 ) / 1000 );
		report.push( entry );
	}
	writeFileSync( join( tmpdir(), 'bwe-control-audit-editor.json' ), JSON.stringify( report, null, 1 ) );
	const summary = summarizeAudit( report );
	return { ok: blocks?.length > 0 && summary.dead.length === 0 && summary.conflicts.length === 0 && ! summary.errors.length, blocks: blocks?.length, ...summary };
};
