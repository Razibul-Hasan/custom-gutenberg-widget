// Editor scenario (nothing saved): a product card set to "My own image" shows the Image fit / position / space
// controls, and changing them changes the picture in the canvas.
export default async ( { evaluate, sleep } ) => {
	const id = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); let f = null; const walk = (ids) => ids.forEach((i) => { if (!f && sel.getBlockName(i) === 'bwe/product-card') f = i; walk(sel.getBlockOrder(i)); }); walk(sel.getBlockOrder('')); return f; })()` );
	if ( ! id ) return { ok: false, why: 'no product card' };
	const idj = JSON.stringify( id );
	await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ idj }, { art: 'image', imageUrl: location.origin + '/wp-content/uploads/2026/11/774-1024x538.png' }); wp.data.dispatch('core/block-editor').selectBlock(${ idj }); (wp.data.dispatch('core/edit-post') || {}).openGeneralSidebar && wp.data.dispatch('core/edit-post').openGeneralSidebar('edit-post/block'); 1` );
	await sleep( 1500 );
	const labels = await evaluate( `[...document.querySelectorAll('.block-editor-block-inspector label')].map((l) => l.textContent.trim()).filter((t) => /Image fit|Image position|Space around/.test(t))` );
	// Drive the real select like a user.
	const changed = await evaluate( `(()=>{ const l = [...document.querySelectorAll('.block-editor-block-inspector label')].find((x) => x.textContent.trim() === 'Image fit'); const s = l && document.getElementById(l.htmlFor); if (!s) return 'no select';
		Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype, 'value').set.call(s, 'contain'); s.dispatchEvent(new Event('change', { bubbles: true })); return 'ok'; })()` );
	await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ idj }, { imagePosition: 'center top', imagePadding: 20 }); 1` );
	await sleep( 1000 );
	const canvas = await evaluate( `(()=>{ const doc = document.querySelector('iframe[name="editor-canvas"]')?.contentDocument || document; const img = doc.querySelector('#block-' + ${ idj } + ' .bwe-work__art--image img'); if (!img) return null; const c = getComputedStyle(img); return { fit: c.objectFit, pos: c.objectPosition, pad: c.paddingTop }; })()` );
	const attrs = await evaluate( `(({ imageFit, imagePosition, imagePadding }) => ({ imageFit, imagePosition, imagePadding }))(wp.data.select('core/block-editor').getBlockAttributes(${ idj }))` );
	return { ok: labels.length === 3 && changed === 'ok' && attrs.imageFit === 'contain' && canvas && canvas.fit === 'contain' && canvas.pos === '50% 0%' && canvas.pad === '20px', labels, changed, attrs, canvas };
};
