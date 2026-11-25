// Editor scenario for bwe/price-row (price right-aligned on the row's first line) and bwe/who-card (no card in a card).
export default async ( { inCanvas } ) => {
	const r = await inCanvas( `const out = {};
		const row = d.querySelector('[data-type="bwe/price-row"]');
		if (row) { const rr = row.getBoundingClientRect(), a = row.querySelector('.bwe-prx__amt').getBoundingClientRect();
			out.price = { rightGap: Math.round(rr.right - a.right), topOffset: Math.round(a.top - rr.top), rowH: Math.round(rr.height) }; }
		const card = d.querySelector('[data-type="bwe/who-card"]');
		if (card) { const a = card.querySelector('a'); const cs = W.getComputedStyle(card); const as = W.getComputedStyle(a);
			out.who = { liBorder: cs.borderTopWidth, liPadding: cs.paddingTop, aBorder: as.borderTopWidth, aRadius: as.borderTopLeftRadius }; }
		return out;` );
	// Live /pricing/ row (1425px): rightGap 0, price vertically centred (topOffset 22 in a 73px row).
	const priceOk = ! r?.price || ( Math.abs( r.price.rightGap ) <= 1 && r.price.topOffset <= r.price.rowH / 2 );
	const whoOk = ! r?.who || ( r.who.liBorder === '0px' && r.who.aBorder !== '0px' );
	return { ok: !! r && priceOk && whoOk, ...r };
};
