// Editor scenario for bwe/hero + bwe/services style settings (run on b1352 or b1353; nothing is saved):
// a style value applied in the editor changes the canvas immediately, and clearing it restores the original.
export default async ( { inCanvas, evaluate, sleep } ) => {
	const pick = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); const out = {};
		const walk = (ids) => ids.forEach((id) => { const n = sel.getBlockName(id); if (n === 'bwe/hero' || n === 'bwe/services') out[n] = id; walk(sel.getBlockOrder(id)); });
		walk(sel.getBlockOrder('')); return out; })()` );
	const id = pick && ( pick[ 'bwe/hero' ] || pick[ 'bwe/services' ] );
	if ( ! id ) return { ok: false, why: 'no hero/services block', pick };
	const isHero = !! pick[ 'bwe/hero' ];
	const probe = isHero
		? `const el = d.querySelector('[data-type="bwe/hero"] .bwe-hero__title'); return el ? W.getComputedStyle(el).color : null;`
		: `const el = d.querySelector('[data-type="bwe/services"] .bwex-svc__grid'); return el ? W.getComputedStyle(el).gridTemplateColumns.split(' ').length : null;`;
	const before = await inCanvas( probe );
	const style = isHero ? { titleColor: '#ff0000' } : { columns: '4' };
	await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ JSON.stringify( id ) }, { bweStyle: ${ JSON.stringify( style ) } }); 1` );
	await sleep( 800 );
	const changed = await inCanvas( probe );
	await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ JSON.stringify( id ) }, { bweStyle: {} }); 1` );
	await sleep( 800 );
	const restored = await inCanvas( probe );
	const expected = isHero ? 'rgb(255, 0, 0)' : 4;
	return { ok: changed === expected && restored === before && before !== expected, block: isHero ? 'hero' : 'services', before, changed, restored };
};
