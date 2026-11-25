// Editor scenario for bwe/section (nothing is saved): background + heading colour applied in the editor change
// the canvas immediately and clearing them restores it; the section shows its List View name.
export default async ( { inCanvas, evaluate, sleep } ) => {
	const info = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); let id = null;
		const walk = (ids) => ids.forEach((i) => { if (!id && sel.getBlockName(i) === 'bwe/section') id = i; walk(sel.getBlockOrder(i)); }); walk(sel.getBlockOrder(''));
		return id ? { id, name: (sel.getBlockAttributes(id).metadata || {}).name, inner: sel.getBlockOrder(id).length } : null; })()` );
	if ( ! info ) return { ok: false, why: 'no section block' };
	const probe = `const s = d.querySelector('[data-type="bwe/section"]'); const h = s && s.querySelector('.bwex-h2 :is(h2, .elementor-heading-title)');
		return s ? { bg: W.getComputedStyle(s).backgroundColor, title: h ? W.getComputedStyle(h).color : null } : null;`;
	const before = await inCanvas( probe );
	await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ JSON.stringify( info.id ) }, { bweStyle: { bgColor: '#123456', titleColor: '#ff0000' } }); 1` );
	await sleep( 800 );
	const changed = await inCanvas( probe );
	await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ JSON.stringify( info.id ) }, { bweStyle: {} }); 1` );
	await sleep( 800 );
	const restored = await inCanvas( probe );
	const ok = changed.bg === 'rgb(18, 52, 86)' && ( ! before.title || changed.title === 'rgb(255, 0, 0)' ) && JSON.stringify( restored ) === JSON.stringify( before ) && info.inner > 0 && !! info.name;
	return { ok, name: info.name, inner: info.inner, before, changed, restored };
};
