// Headless block-editor check. Each target gets its own fresh Edge (state left by a previous editor — open
// connections, media, workers — slowed the next one so much that its synced patterns never finished loading).
// Usage: node editor-check.mjs --cookies <file> [--scenario <name>] [--timeout <sec per target>] <target>...
//   target = page/post ID, or b<ID> for a synced pattern (wp_block).
// Prints one JSON line per target: { target, ready, loadSec, invalid, counts, anomalies, scenario? }.
// Exit 1 if a target never became ready, has invalid blocks, or fails its scenario.
import { spawn } from 'node:child_process';
import { readFileSync, mkdtempSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const args = process.argv.slice( 2 );
const opt = ( name ) => {
	const i = args.indexOf( name );
	if ( i < 0 ) return null;
	const v = args[ i + 1 ];
	args.splice( i, 2 );
	return v;
};
const cookieFile = opt( '--cookies' );
const scenario = opt( '--scenario' );
const perTarget = Number( opt( '--timeout' ) || 180 ); // seconds per target before the hard stop
const targets = args;
if ( ! cookieFile || ! targets.length ) {
	console.error( 'usage: editor-check.mjs --cookies <file> [--scenario name] <target>...' );
	process.exit( 2 );
}

const SITE = 'http://bestwebexpert.local';
const EDGE = 'C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe';
const sleep = ( ms ) => new Promise( ( r ) => setTimeout( r, ms ) );
const ANOMALIES = readFileSync( join( dirname( fileURLToPath( import.meta.url ) ), 'anomalies.js' ), 'utf8' );
const COOKIES = readFileSync( cookieFile, 'utf8' ).trim().split( /\r?\n/ ).filter( Boolean );
const scenarios = scenario ? ( await import( `./scenarios/${ scenario }.mjs` ) ).default : null;
setTimeout( () => {
	console.error( 'HARD TIMEOUT' );
	process.exit( 3 );
}, ( perTarget * targets.length + 30 ) * 1000 );

// Ready = right post loaded, no spinner, every synced pattern (core/block) has its inner blocks in the store, and
// the store holds at least as many blocks as are rendered. Returns the store's block total, or 0 when not ready.
// When not ready it returns the reason (a string), which is reported if the page never becomes ready.
const READY = ( postId ) => `if(!window.wp||!wp.data)return 'no wp.data';
	const spin=d.querySelector('.components-spinner'); if(spin)return 'spinner in '+(spin.closest('[data-type]')?.dataset.type||'?');
	if(String(wp.data.select('core/editor').getCurrentPostId())!==${ JSON.stringify( postId ) })return 'previous post still loaded';
	const sel=wp.data.select('core/block-editor'); let total=0, pendingRefs=0;
	const walk=(ids)=>ids.forEach((cid)=>{total++; const order=sel.getBlockOrder(cid);
		if(sel.getBlockName(cid)==='core/block'&&(!order.length||(sel.getBlockName(order[0])==='core/group'&&!sel.getBlockOrder(order[0]).length)))pendingRefs++;
		walk(order);});
	walk(sel.getBlockOrder(''));
	const rendered=[...d.querySelectorAll('[data-block]')].filter((e)=>!e.parentElement.closest('.wp-block-post-template')).length; /* a Query Loop repeats its template per post */
	if(pendingRefs)return pendingRefs+' synced pattern(s) still loading';
	if(!total)return 'no blocks';
	return total<rendered?'store '+total+' < rendered '+rendered:total;`;

const MEASURE = `const sel = wp.data.select('core/block-editor'); const invalid = []; const counts = {};
	const walk = (ids) => ids.forEach((cid) => { const b = sel.getBlock(cid); if (!b) return; counts[b.name] = (counts[b.name] || 0) + 1;
		if (b.isValid === false) invalid.push(b.name + ' ' + (b.attributes.className || '')); walk(sel.getBlockOrder(cid)); });
	walk(sel.getBlockOrder(''));
	const ROOT = d.body; ${ ANOMALIES }
	return { invalid, counts, anomalies };`;

async function openBrowser() {
	const port = 9300 + Math.floor( Math.random() * 90 );
	const browser = spawn( EDGE, [ '--headless=new', '--disable-gpu', `--remote-debugging-port=${ port }`, `--user-data-dir=${ mkdtempSync( join( tmpdir(), 'bwe-ed-' ) ) }`, 'about:blank' ], { stdio: 'ignore' } );
	let list;
	for ( let i = 0; i < 50; i++ ) {
		try {
			list = await ( await fetch( `http://127.0.0.1:${ port }/json` ) ).json();
			if ( list.length ) break;
		} catch {}
		await sleep( 200 );
	}
	const ws = new WebSocket( list.find( ( t ) => t.type === 'page' ).webSocketDebuggerUrl );
	await new Promise( ( r ) => ws.addEventListener( 'open', r ) );
	let id = 0;
	const pending = new Map();
	const send = ( method, params = {} ) => new Promise( ( r ) => {
		const i = ++id;
		pending.set( i, r );
		ws.send( JSON.stringify( { id: i, method, params } ) );
		setTimeout( () => {
			if ( pending.has( i ) ) {
				pending.delete( i );
				r( { timeout: true } );
			}
		}, 30000 );
	} );
	ws.addEventListener( 'message', ( e ) => {
		const m = JSON.parse( e.data );
		if ( m.method === 'Page.javascriptDialogOpening' ) send( 'Page.handleJavaScriptDialog', { accept: true } );
		if ( m.id && pending.has( m.id ) ) {
			pending.get( m.id )( m.result ?? m );
			pending.delete( m.id );
		}
	} );
	const evaluate = async ( expression, awaitPromise = false ) => {
		const r = await send( 'Runtime.evaluate', { expression, returnByValue: true, awaitPromise } );
		return r.result?.value ?? ( r.exceptionDetails ? { error: r.exceptionDetails.exception?.description } : undefined );
	};
	// Runs a function body inside the editor canvas: d = canvas document, W = its window.
	// Right after the editor settles, a call can come back empty (CDP times out while the page is busy); retry.
	const inCanvas = async ( body ) => {
		for ( let attempt = 0; attempt < 4; attempt++ ) {
			const value = await evaluate( `(async()=>{const f=document.querySelector('iframe[name="editor-canvas"]');const d=f&&f.contentDocument;if(!d)return null;const W=f.contentWindow;${ body }})()`, true );
			if ( value !== undefined ) return value;
			await sleep( 2000 );
		}
		return undefined;
	};
	const close = () => {
		ws.close();
		try {
			browser.kill();
		} catch {}
	};
	await send( 'Network.enable' );
	await send( 'Page.enable' );
	for ( const line of COOKIES ) {
		const i = line.indexOf( '=' );
		await send( 'Network.setCookie', { name: line.slice( 0, i ), value: line.slice( i + 1 ), domain: 'bestwebexpert.local', path: '/' } );
	}
	await send( 'Emulation.setDeviceMetricsOverride', { width: 1440, height: 900, deviceScaleFactor: 1, mobile: false } );
	return { send, evaluate, inCanvas, close };
}

let failed = false;
for ( const target of targets ) {
	const postId = target.replace( /^b/, '' );
	const b = await openBrowser();
	const t0 = Date.now();
	await b.send( 'Page.navigate', { url: `${ SITE }/wp-admin/post.php?post=${ postId }&action=edit` } );
	let last = -1;
	let stable = 0;
	let ready = false;
	let notReadyBecause = "";
	for ( let i = 0; i < 150; i++ ) {
		await sleep( 1000 );
		if ( i === 5 && String( await b.evaluate( 'location.href' ) ).includes( 'wp-login.php' ) ) {
			console.error( 'Not logged in: the login cookies have expired (they last 6 hours). Regenerate them with tools/cookie.php, or use npm run editor / npm run verify, which do it for you.' );
			process.exit( 4 );
		}
		const n = await b.inCanvas( READY( postId ) );
		if ( typeof n === 'number' && n > 0 && n === last ) {
			if ( ++stable >= 3 ) {
				ready = true;
				break;
			}
		} else {
			stable = 0;
		}
		last = n;
		if ( typeof n === "string" ) notReadyBecause = n;
	}
	// Just after the editor settles the measurement can come back as {} — retry until it has the block counts.
	let result;
	for ( let attempt = 0; attempt < 6; attempt++ ) {
		result = await b.inCanvas( MEASURE );
		if ( result && result.counts ) break;
		await sleep( 2000 );
	}
	const line = { target, ready, ...( ready ? {} : { notReadyBecause } ), loadSec: Math.round( ( Date.now() - t0 ) / 1000 ), ...( result || { error: "editor canvas not found" } ) };
	if ( ! ready || ! result?.counts || result.error || line.invalid?.length ) failed = true;
	if ( scenarios && ready ) {
		line.scenario = await scenarios( { inCanvas: b.inCanvas, evaluate: b.evaluate, send: b.send, sleep } );
		if ( line.scenario?.ok !== true ) failed = true;
	}
	console.log( JSON.stringify( line ) );
	b.close();
}
process.exit( failed ? 1 : 0 );
