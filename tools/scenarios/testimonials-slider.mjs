// Editor scenario (nothing saved): selects the first Testimonials block, adds videos up to five and checks the
// "Slider" panel, the desktop slider classes and its dots / arrows row in the canvas.
export default async ( { evaluate, send, sleep } ) => {
	await send( 'Emulation.setDeviceMetricsOverride', { width: 1440, height: 1100, deviceScaleFactor: 1, mobile: false } );
	const id = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor');
		const find = (ids) => { for (const cid of ids) { if (sel.getBlockName(cid) === 'bwe/testimonials') return cid; const f = find(sel.getBlockOrder(cid)); if (f) return f; } return null; };
		const cid = find(sel.getBlockOrder('')); if (!cid) return null;
		const D = wp.data.dispatch('core/block-editor');
		for (let n = sel.getBlockCount(cid); n < 5; n++) D.insertBlock(wp.blocks.createBlock('bwe/video-card'), n, cid, false);
		D.selectBlock(cid);
		const I = wp.data.dispatch('core/interface'); I && I.enableComplementaryArea && I.enableComplementaryArea('core', 'edit-post/block');
		return cid; })()` );
	if ( ! id ) return { ok: false, error: 'no bwe/testimonials block' };
	await sleep( 4000 );
	const r = await evaluate( `(()=>{ const side = document.querySelector('.interface-complementary-area, .editor-sidebar');
		const body = side && [...side.querySelectorAll('.components-panel__body')].find((p) => p.querySelector('.components-panel__body-title')?.textContent.trim() === 'Slider');
		if (body && !body.classList.contains('is-opened')) body.querySelector('.components-panel__body-toggle').click();
		const d = document.querySelector('iframe[name="editor-canvas"]').contentDocument; const t = d.querySelector('#block-${ id } .bwex-quotes');
		return { panel: body ? body.textContent.replace(/[ ]+/g, ' ').trim().slice(0, 500) : '', classes: t && t.className, nav: t && t.nextElementSibling && t.nextElementSibling.className }; })()` );
	const ok = /Slider on computers/.test( r.panel ) && /bwe-ms--d/.test( r.classes ) && /bwe-ms__nav--d/.test( r.nav );
	return { ok, ...r };
};
