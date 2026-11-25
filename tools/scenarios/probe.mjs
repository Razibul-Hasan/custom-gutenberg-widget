// Editor scenario (nothing saved): runs the JS file BWE_PROBE in the editor page and returns its value.
// The file is the body of an async function with d = canvas document, W = canvas window, S = block-editor store.
// Optional BWE_DEVICE=Desktop|Tablet|Mobile switches the preview first.
import { readFileSync } from 'node:fs';

export default async ( { evaluate, sleep } ) => {
	const file = process.env.BWE_PROBE;
	if ( ! file ) return { ok: false, error: 'set BWE_PROBE' };
	if ( process.env.BWE_DEVICE ) {
		await evaluate( `(()=>{ const E = wp.data.dispatch('core/editor'); E.setDeviceType(${ JSON.stringify( process.env.BWE_DEVICE ) }); return 1; })()` );
		await sleep( 3000 );
	}
	const body = readFileSync( file, 'utf8' );
	const value = await evaluate( `(async()=>{ const f = document.querySelector('iframe[name="editor-canvas"]'); const d = f.contentDocument; const W = f.contentWindow; const S = wp.data.select('core/block-editor'); ${ body } })()`, true );
	return { ok: value !== undefined && ! ( value && value.error ), value };
};
