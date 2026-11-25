// Editor scenario for bwe/platforms + bwe/platform-card (nothing is saved): the sidebar's "+ Add a card (new pack)"
// adds a card with its starter content and list; grid settings (cards per row, card background) apply to every
// card, a card's own colour beats the grid's, and the badge shows.
export default async ( { evaluate, inCanvas, sleep } ) => {
	const ids = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); let id = null;
		const walk = (l) => l.forEach((c) => { if (!id && sel.getBlockName(c) === 'bwe/platforms') id = c; walk(sel.getBlockOrder(c)); }); walk(sel.getBlockOrder(''));
		return id ? { id, cards: sel.getBlockOrder(id) } : null; })()` );
	if ( ! ids ) return { ok: false, why: 'no platforms block' };
	const r = { before: ids.cards.length };
	await evaluate( `wp.data.dispatch('core/block-editor').selectBlock(${ JSON.stringify( ids.id ) }); wp.data.dispatch('core/edit-post').openGeneralSidebar('edit-post/block'); 1` );
	await sleep( 1200 );
	r.clicked = await evaluate( `(()=>{ const b = [...document.querySelectorAll('.block-editor-block-inspector button')].find((x) => /Add a card/.test(x.textContent)); if (!b) return 'no button'; b.click(); return 'clicked'; })()` );
	await sleep( 1000 );
	const after = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); const cards = sel.getBlockOrder(${ JSON.stringify( ids.id ) });
		const last = cards[cards.length - 1]; const a = sel.getBlockAttributes(last); const list = sel.getBlockOrder(last)[0];
		return { count: cards.length, last, chip: a.chip, title: a.title, list: list ? sel.getBlockName(list) + ':' + sel.getBlockOrder(list).length : null }; })()` );
	Object.assign( r, { after: after.count, newChip: after.chip, newTitle: after.title, newList: after.list } );
	await evaluate( `(()=>{ const d = wp.data.dispatch('core/block-editor');
		d.updateBlockAttributes(${ JSON.stringify( ids.id ) }, { bweStyle: { columns: '3', cardBg: '#123456' } });
		d.updateBlockAttributes(${ JSON.stringify( ids.cards[ 1 ] ) }, { bweStyle: { bg: '#00ff00' } });
		d.updateBlockAttributes(${ JSON.stringify( after.last ) }, { badge: 'Popular', bweStyle: { badgeBg: '#ff0000', badgeColor: '#ffffff' } }); return 1; })()` );
	await sleep( 1000 );
	r.canvas = await inCanvas( `const g = d.querySelector('[data-block="${ ids.id }"]'); const bg = (id) => W.getComputedStyle(d.querySelector('[data-block="' + id + '"]')).backgroundColor;
		const badge = d.querySelector('[data-block="${ after.last }"] .bwe-pc-badge');
		return { tracks: W.getComputedStyle(g).gridTemplateColumns.split(' ').length, card0: bg(${ JSON.stringify( ids.cards[ 0 ] ) }), card1: bg(${ JSON.stringify( ids.cards[ 1 ] ) }), badge: badge ? badge.textContent : null, badgeBg: badge ? W.getComputedStyle(badge).backgroundColor : null, badgeColor: badge ? W.getComputedStyle(badge).color : null };` );
	await evaluate( `(()=>{ const d = wp.data.dispatch('core/block-editor'); d.removeBlock(${ JSON.stringify( after.last ) });
		d.updateBlockAttributes(${ JSON.stringify( ids.id ) }, { bweStyle: {} }); d.updateBlockAttributes(${ JSON.stringify( ids.cards[ 1 ] ) }, { bweStyle: {} }); return 1; })()` );
	r.ok = r.clicked === 'clicked' && r.after === r.before + 1 && r.newChip === 'New' && r.newList === 'core/list:2'
		&& r.canvas?.tracks === 3 && r.canvas.card0 === 'rgb(18, 52, 86)' && r.canvas.card1 === 'rgb(0, 255, 0)' && r.canvas.badge === 'Popular' && r.canvas.badgeBg === 'rgb(255, 0, 0)' && r.canvas.badgeColor === 'rgb(255, 255, 255)';
	return r;
};
