// Editor scenario (nothing saved): one screenshot per top-level block of the editor canvas, so each widget can be
// compared with the live page. BWE_SHOTS=<dir> (required), BWE_DEVICE=Desktop|Tablet|Mobile (default Desktop).
// Files: <dir>/ed-<device>-<nn>-<block>.png. Uses a very tall window so most blocks fit in one capture.
import { writeFileSync } from 'node:fs';

export default async ( { evaluate, send, sleep } ) => {
	const dir = process.env.BWE_SHOTS;
	const device = process.env.BWE_DEVICE || 'Desktop';
	if ( ! dir ) return { ok: false, error: 'set BWE_SHOTS' };
	await send( 'Emulation.setDeviceMetricsOverride', { width: 1440, height: 5000, deviceScaleFactor: 1, mobile: false } );
	await send( 'Emulation.setEmulatedMedia', { features: [ { name: 'prefers-reduced-motion', value: 'reduce' } ] } );
	await evaluate( `(()=>{ const I = wp.data.dispatch('core/interface'); I && I.disableComplementaryArea && (I.disableComplementaryArea('core'), I.disableComplementaryArea('core/edit-post'));
		const E = wp.data.dispatch('core/editor'); E.setDeviceType ? E.setDeviceType(${ JSON.stringify( device ) }) : wp.data.dispatch('core/edit-post').__experimentalSetPreviewDeviceType(${ JSON.stringify( device ) });
		E.setIsListViewOpened && E.setIsListViewOpened(false); wp.data.dispatch('core/block-editor').clearSelectedBlock(); return 1; })()` );
	await sleep( 4000 );
	// Tablet / Mobile previews are a short framed iframe: stretch it (capture only) so tall blocks fit in one shot.
	if ( device !== 'Desktop' ) {
		await evaluate( `(()=>{ const f = document.querySelector('iframe[name="editor-canvas"]'); f.style.height = '4800px'; f.style.maxHeight = 'none';
			for (let p = f.parentElement; p && p !== document.body; p = p.parentElement) { p.style.height = 'auto'; p.style.maxHeight = 'none'; p.style.overflow = 'visible'; } return 1; })()` );
		await sleep( 2000 );
	}
	// Server-rendered previews (product mockups) arrive after the canvas: wait until none is empty (max 20 s).
	for ( let t = 0; t < 40; t++ ) {
		const pending = await evaluate( `(()=>{ const d = document.querySelector('iframe[name="editor-canvas"]').contentDocument;
			return [...d.querySelectorAll('div[style*="position: relative"] > div')].filter((x) => ! x.children.length).length + d.querySelectorAll('.components-spinner').length; })()` );
		if ( ! pending ) break;
		await sleep( 500 );
	}
	const ids = await evaluate( `wp.data.select('core/block-editor').getBlockOrder('').map((id) => [id, wp.data.select('core/block-editor').getBlockName(id)])` );
	const shots = [];
	for ( let i = 0; i < ids.length; i++ ) {
		const [ id, name ] = ids[ i ];
		const r = await evaluate( `(async()=>{ const f = document.querySelector('iframe[name="editor-canvas"]'); const d = f.contentDocument; const el = d.getElementById('block-${ id }');
			if (!el) return null; el.scrollIntoView({block:'start'}); await new Promise((r)=>setTimeout(r,700));
			const fr = f.getBoundingClientRect(), b = el.getBoundingClientRect();
			const top = Math.max(fr.top + b.top, fr.top), bottom = Math.min(fr.top + b.bottom, fr.bottom);
			return { x: fr.left + Math.max(b.left, 0), y: top, w: Math.min(b.width, fr.width), h: bottom - top, full: b.height, top: b.top + f.contentWindow.scrollY }; })()`, true );
		if ( ! r || r.h < 2 ) {
			shots.push( { i, name, missing: true } );
			continue;
		}
		const s = await send( 'Page.captureScreenshot', { format: 'png', clip: { x: r.x, y: r.y, width: r.w, height: r.h, scale: 1 } } );
		const file = `${ dir }/ed-${ device }-${ String( i ).padStart( 2, '0' ) }-${ name.replace( /\W+/g, '-' ) }.png`;
		if ( s.data ) writeFileSync( file, Buffer.from( s.data, 'base64' ) );
		shots.push( { i, name, w: Math.round( r.w ), h: Math.round( r.h ), top: Math.round( r.top ), cut: r.full > r.h + 2 } );
	}
	return { ok: true, device, shots };
};
