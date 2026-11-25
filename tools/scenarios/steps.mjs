// Editor scenario for bwe/step (run on a steps pattern, e.g. b1346): moving step 3 up renumbers 01, 02, 03 …
export default async ( { inCanvas, sleep } ) => {
	const q = `const sel = wp.data.select('core/block-editor'); const items = []; const walk = (ids) => ids.forEach((id) => { if (sel.getBlockName(id) === 'bwe/step') items.push(id); walk(sel.getBlockOrder(id)); }); walk(sel.getBlockOrder(''));`;
	const before = await inCanvas( `${ q } return items.map((id) => sel.getBlockAttributes(id).n).join(',');` );
	await inCanvas( `${ q } wp.data.dispatch('core/block-editor').moveBlocksUp([items[2]], sel.getBlockRootClientId(items[2])); return 1;` );
	await sleep( 800 );
	const after = await inCanvas( `${ q } return items.map((id) => sel.getBlockAttributes(id).n).join(',');` );
	const expected = ( after || '' ).split( ',' ).map( ( _, i ) => String( i + 1 ).padStart( 2, '0' ) ).join( ',' );
	return { ok: !! after && after === expected, before, after };
};
