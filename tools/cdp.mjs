// Minimal headless-Edge driver for the front-end checks: open(url, { width }) → { evaluate, close }.
import { spawn } from 'node:child_process';
import { mkdtempSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { join } from 'node:path';

const EDGE = 'C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe';
export const sleep = ( ms ) => new Promise( ( r ) => setTimeout( r, ms ) );

export async function open( url, { width = 1440, height = 900 } = {} ) {
	const port = 9400 + Math.floor( Math.random() * 90 );
	const browser = spawn( EDGE, [ '--headless=new', '--disable-gpu', `--remote-debugging-port=${ port }`, `--user-data-dir=${ mkdtempSync( join( tmpdir(), 'bwe-fr-' ) ) }`, 'about:blank' ], { stdio: 'ignore' } );
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
		setTimeout( () => pending.has( i ) && ( pending.delete( i ), r( { timeout: true } ) ), 60000 );
	} );
	ws.addEventListener( 'message', ( e ) => {
		const m = JSON.parse( e.data );
		if ( m.id && pending.has( m.id ) ) {
			pending.get( m.id )( m.result ?? m );
			pending.delete( m.id );
		}
	} );
	const evaluate = async ( expression ) => {
		const r = await send( 'Runtime.evaluate', { expression, returnByValue: true, awaitPromise: true } );
		return r.result?.value ?? ( r.exceptionDetails ? { error: r.exceptionDetails.exception?.description } : undefined );
	};
	await send( 'Page.enable' );
	await send( 'Emulation.setDeviceMetricsOverride', { width, height, deviceScaleFactor: 1, mobile: width < 800 } );
	await send( 'Page.navigate', { url } );
	for ( let i = 0; i < 60; i++ ) {
		await sleep( 500 );
		if ( ( await evaluate( 'document.readyState' ) ) === 'complete' ) break;
	}
	await sleep( 1500 );
	return { send, evaluate, close: () => ( ws.close(), browser.kill() ) };
}
