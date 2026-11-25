// Editor scenario for bwe/spec-card: name, text and tag are stacked like on the site, and no card sits inside a card.
export default async ( { inCanvas } ) => {
	const r = await inCanvas( `const li = d.querySelector('[data-type="bwe/spec-card"]'); if (!li) return null;
		const top = (sel) => { const e = li.querySelector(sel); return e ? Math.round(e.getBoundingClientRect().top) : null; };
		return { name: top('.bwex-spec__name'), text: top('.bwex-spec__text'), chip: top('code'), display: W.getComputedStyle(li).display };` );
	const ok = !! r && r.name < r.text && ( r.chip === null || r.text < r.chip );
	return { ok, ...r };
};
