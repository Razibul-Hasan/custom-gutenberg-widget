// Editor scenario: the "Best Web Expert" category is first in the inserter and holds all our blocks; the
// top-level ones (not children like Step) are offered there, and a search for "best web expert" finds them.
export default async ( { evaluate } ) => {
	const r = await evaluate( `(()=>{ const cats = wp.blocks.getCategories(); const ours = wp.blocks.getBlockTypes().filter((b) => b.name.startsWith('bwe/'));
		const items = wp.data.select('core/block-editor').getInserterItems().filter((i) => i.category === 'bestwebexpert').map((i) => i.title);
		return { firstCategory: cats[0] && cats[0].slug + ' / ' + cats[0].title, ours: ours.length, inCategory: ours.filter((b) => b.category === 'bestwebexpert').length,
			inserter: items, keyword: ours.filter((b) => (b.keywords || []).includes('best web expert')).length,
			icon: !! (cats[0] && cats[0].icon && ((cats[0].icon.type || (cats[0].icon.src && cats[0].icon.src.type)) === 'svg')) }; })()` );
	return { ok: !! r && r.firstCategory === 'bestwebexpert / Best Web Expert' && r.ours === r.inCategory && r.keyword === r.ours && r.inserter.length >= 6 && r.icon, ...r };
};
