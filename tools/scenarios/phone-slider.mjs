// Editor scenario (nothing saved): selects the first "Our products" block, checks its "Phone layout" panel
// (List / Slider + slider options) and, in the Mobile preview, that the cards are a swipe row with dots and arrows.
// BWE_SHOTS=<dir> (optional): saves phone-slider-panel.png and phone-slider-canvas.png there.
import { writeFileSync } from 'node:fs';

export default async ( { evaluate, send, sleep } ) => {
	const dir = process.env.BWE_SHOTS;
	await send( 'Emulation.setDeviceMetricsOverride', { width: 1440, height: 1100, deviceScaleFactor: 1, mobile: false } );
	const id = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor');
		const find = (ids) => { for (const cid of ids) { if (sel.getBlockName(cid) === 'bwe/products') return cid; const f = find(sel.getBlockOrder(cid)); if (f) return f; } return null; };
		const cid = find(sel.getBlockOrder('')); if (!cid) return null;
		wp.data.dispatch('core/block-editor').selectBlock(cid);
		const I = wp.data.dispatch('core/interface'); I && I.enableComplementaryArea && I.enableComplementaryArea('core', 'edit-post/block');
		const E = wp.data.dispatch('core/editor'); E.setDeviceType ? E.setDeviceType('Mobile') : wp.data.dispatch('core/edit-post').__experimentalSetPreviewDeviceType('Mobile');
		return cid; })()` );
	if ( ! id ) return { ok: false, error: 'no bwe/products block' };
	await sleep( 4000 );
	const panel = await evaluate( `(()=>{ const side = document.querySelector('.interface-complementary-area, .editor-sidebar'); if (!side) return { error: 'no sidebar' };
		const body = [...side.querySelectorAll('.components-panel__body')].find((p) => /Phone layout/.test(p.querySelector('.components-panel__body-title')?.textContent || ''));
		if (!body) return { error: 'no Phone layout panel' };
		if (!body.classList.contains('is-opened')) body.querySelector('.components-panel__body-toggle').click();
		body.scrollIntoView({ block: 'start' });
		const r = body.getBoundingClientRect();
		return { text: body.textContent.replace(/\\s+/g, ' ').trim().slice(0, 400), x: r.left, y: r.top, w: r.width, h: Math.min(r.height, 900) }; })()` );
	if ( panel.error ) return { ok: false, error: panel.error };
	await sleep( 600 );
	const canvas = await evaluate( `(async()=>{ const f = document.querySelector('iframe[name="editor-canvas"]'); const d = f.contentDocument;
		const t = d.querySelector('#block-${ id } .bwe-ms'); if (!t) return { error: 'no .bwe-ms in canvas' };
		t.closest('section').scrollIntoView({ block: 'start' }); await new Promise((r) => setTimeout(r, 800));
		const cs = f.contentWindow.getComputedStyle(t); const nav = t.nextElementSibling;
		const fr = f.getBoundingClientRect(), b = t.closest('section').getBoundingClientRect();
		return { display: cs.display, overflowX: cs.overflowX, slides: [...t.children].filter((c) => c.getClientRects().length).map((c) => Math.round(c.getBoundingClientRect().width)),
			nav: nav && nav.classList.contains('bwe-ms__nav') ? f.contentWindow.getComputedStyle(nav).display : 'missing',
			x: fr.left + Math.max(b.left, 0), y: Math.max(fr.top + b.top, fr.top), w: Math.min(b.width, fr.width), h: Math.min(b.height, fr.bottom - Math.max(fr.top + b.top, fr.top)) }; })()`, true );
	if ( canvas.error ) return { ok: false, error: canvas.error };
	if ( dir ) {
		for ( const [ name, r ] of [ [ 'panel', panel ], [ 'canvas', canvas ] ] ) {
			const s = await send( 'Page.captureScreenshot', { format: 'png', clip: { x: r.x, y: r.y, width: r.w, height: r.h, scale: 1 } } );
			if ( s.data ) writeFileSync( `${ dir }/phone-slider-${ name }.png`, Buffer.from( s.data, 'base64' ) );
		}
	}
	const ok = /List/.test( panel.text ) && /Slider/.test( panel.text ) && canvas.display === 'flex' && canvas.overflowX === 'auto' && canvas.nav === 'flex';
	return { ok, panel: panel.text, canvas: { display: canvas.display, overflowX: canvas.overflowX, slides: canvas.slides, nav: canvas.nav } };
};
