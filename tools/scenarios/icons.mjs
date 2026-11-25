// Editor scenario (nothing is saved): on the first service tile / step / section, open its Icon panel, pick
// "Icon library", search the library, click an icon, and check the canvas draws it on the block's icon spot.
// Then "No icon" hides it and "Site icon" restores the original.
const SPOTS = {
	'bwe/service-tile': [ '.bwex-svc__top', '::before', 'Icon' ],
	'bwe/step': [ null, '::after', 'Icon' ],
	'bwe/section': [ ':is(.bwex-eyebrow p, p.bwe-eyebrow)', '::before', 'Eyebrow icon' ],
};

export default async ( { evaluate, inCanvas, sleep } ) => {
	const blocks = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); const out = {};
		const walk = (ids) => ids.forEach((id) => { const n = sel.getBlockName(id); if (${ JSON.stringify( Object.keys( SPOTS ) ) }.includes(n) && !out[n]) out[n] = id; walk(sel.getBlockOrder(id)); });
		walk(sel.getBlockOrder('')); return out; })()` );
	const results = {};
	for ( const [ name, id ] of Object.entries( blocks || {} ) ) {
		const [ inner, pseudo, panel ] = SPOTS[ name ];
		const probe = `const b = d.querySelector('[data-block="${ id }"]'); const el = ${ inner ? `b && b.querySelector(${ JSON.stringify( inner ) })` : 'b' };
			if (!el) return null; const cs = W.getComputedStyle(el, '${ pseudo }'); return { img: cs.backgroundImage.slice(0, 60), display: cs.display };`;
		const before = await inCanvas( probe );
		await evaluate( `wp.data.dispatch('core/block-editor').selectBlock(${ JSON.stringify( id ) }); wp.data.dispatch('core/edit-post').openGeneralSidebar('edit-post/block'); 1` );
		await sleep( 1200 );
		const r = {};
		r.panel = await evaluate( `(()=>{ const ins = document.querySelector('.block-editor-block-inspector');
			const settings = [...ins.querySelectorAll('[role="tab"]')].find((t) => /settings/i.test(t.getAttribute('aria-label') || t.textContent)); if (settings) settings.click();
			const t = [...ins.querySelectorAll('.components-panel__body-toggle')].find((b) => b.textContent.trim() === ${ JSON.stringify( panel ) });
			if (!t) return 'no panel'; if (t.getAttribute('aria-expanded') !== 'true') t.click(); return 'open'; })()` );
		await sleep( 500 );
		r.choose = await evaluate( `(()=>{ const body = [...document.querySelectorAll('.block-editor-block-inspector .components-panel__body')].find((b) => b.querySelector('.components-panel__body-toggle')?.textContent.trim() === ${ JSON.stringify( panel ) });
			const s = body && [...body.querySelectorAll('select')].find((x) => [...x.options].some((o) => o.value === 'library')); if (!s) return 'no source select';
			Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype, 'value').set.call(s, 'library'); s.dispatchEvent(new Event('change', { bubbles: true })); return 'library'; })()` );
		// The library modal opens and loads lucide.json.
		let modal = null;
		for ( let i = 0; i < 20 && ! modal?.count; i++ ) {
			await sleep( 500 );
			modal = await evaluate( `(()=>{ const m = document.querySelector('.components-modal__frame'); if (!m) return null; return { count: m.querySelectorAll('.bwe-icon-pick').length }; })()` );
		}
		r.modalIcons = modal?.count || 0;
		await evaluate( `(()=>{ const i = document.querySelector('.components-modal__frame input[type="search"]'); if (!i) return 0;
			Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value').set.call(i, 'rocket'); i.dispatchEvent(new Event('input', { bubbles: true })); return 1; })()` );
		await sleep( 600 );
		r.found = await evaluate( `[...document.querySelectorAll('.components-modal__frame .bwe-icon-pick')].map((b) => b.getAttribute('aria-label')).slice(0, 5).join(',')` );
		r.picked = await evaluate( `(()=>{ const b = [...document.querySelectorAll('.components-modal__frame .bwe-icon-pick')].find((x) => x.getAttribute('aria-label') === 'rocket'); if (!b) return 'no rocket'; b.click(); return 'rocket'; })()` );
		await sleep( 800 );
		r.attr = await evaluate( `JSON.stringify(Object.keys(wp.data.select('core/block-editor').getBlockAttributes(${ JSON.stringify( id ) }).bweIcon || {}))` );
		r.drawn = await inCanvas( probe );
		await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ JSON.stringify( id ) }, { bweIcon: { source: 'none' } }); 1` );
		await sleep( 600 );
		r.none = await inCanvas( probe );
		await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ JSON.stringify( id ) }, { bweIcon: {} }); 1` );
		await sleep( 600 );
		r.restored = await inCanvas( probe );
		r.ok = r.modalIcons > 100 && r.picked === 'rocket' && /data:image\/svg/.test( r.drawn?.img || '' ) && r.none?.display === 'none' && JSON.stringify( r.restored ) === JSON.stringify( before );
		r.before = before;
		results[ name ] = r;
	}
	return { ok: Object.keys( results ).length > 0 && Object.values( results ).every( ( r ) => r.ok ), results };
};
