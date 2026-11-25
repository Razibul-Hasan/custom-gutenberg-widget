// Editor scenario: the content Rank Math analyses (rank_math_content filter) contains the text of our blocks —
// section headings as <h2>, FAQ questions, spec card names and step titles — not just their block comments.
export default async ( { evaluate, sleep } ) => {
	await sleep( 3000 );
	const r = await evaluate( `(()=>{ if (!window.wp || !wp.hooks) return null;
		const c = wp.hooks.applyFilters('rank_math_content', '');
		const sel = wp.data.select('core/block-editor'); const pick = {};
		const walk = (ids) => ids.forEach((id) => { const b = sel.getBlock(id); if (!b) return;
			if (b.name === 'bwe/section-head' && !pick.head) pick.head = b.attributes.title.replace(/<[^>]+>/g, '');
			if (b.name === 'bwe/faq-item' && !pick.faq) pick.faq = b.attributes.question.replace(/<[^>]+>/g, '');
			if (b.name === 'bwe/spec-card' && !pick.spec) pick.spec = b.attributes.name.replace(/<[^>]+>/g, '');
			if (b.name === 'bwe/step' && !pick.step) pick.step = b.attributes.title.replace(/<[^>]+>/g, '');
			walk(sel.getBlockOrder(id)); });
		walk(sel.getBlockOrder(''));
		const text = c.replace(/<!--[\\s\\S]*?-->/g, ' ').replace(/<[^>]+>/g, ' ').replace(/&amp;/g, '&').replace(/\\s+/g, ' ');
		const has = (s) => !!s && text.includes(s.replace(/&amp;/g, '&').replace(/\\s+/g, ' ').trim());
		const h2 = (c.match(/<h2[^>]*>/g) || []).length;
		return { length: c.length, h2, pick, found: { head: has(pick.head), faq: has(pick.faq), spec: has(pick.spec), step: has(pick.step) } };
	})()` );
	const ok = !! r && r.h2 > 0 && Object.values( r.found ).every( Boolean );
	return { ok, ...r };
};
