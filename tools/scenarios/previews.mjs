// Editor scenario: every Best Web Expert block shown in the inserter has an example, and hovering it shows its
// preview picture (not "No preview available"). Saves one screenshot per hovered block when BWE_SHOTS=<dir>.
import { writeFileSync } from 'node:fs';

export default async ( { evaluate, send, sleep } ) => {
	const types = await evaluate( `wp.blocks.getBlockTypes().filter((t) => t.name.startsWith('bwe/')).map((t) => ({ name: t.name, title: t.title, example: !!(t.example && t.example.attributes && t.example.attributes.bwePreview), parent: t.parent || null }))` );
	await evaluate( "wp.data.dispatch('core/editor').setIsInserterOpened(true); 1" );
	await sleep( 2500 );
	const results = [];
	// Root-level blocks are listed in the main inserter; hover each one.
	for ( const t of types.filter( ( x ) => ! x.parent ) ) {
		const hovered = await evaluate( `(()=>{ const item = [...document.querySelectorAll('.block-editor-block-types-list__item')].find((e) => e.querySelector('.block-editor-block-types-list__item-title')?.textContent.trim() === ${ JSON.stringify( t.title ) } && e.closest('.block-editor-inserter__panel-content') && [...document.querySelectorAll('.block-editor-inserter__panel-title')].some(() => true));
			if (!item) return false; item.scrollIntoView({ block: 'center' }); item.dispatchEvent(new MouseEvent('mouseover', { bubbles: true })); item.dispatchEvent(new MouseEvent('mouseenter', { bubbles: true })); item.focus(); return true; })()` );
		await sleep( 1500 );
		const preview = await evaluate( `(()=>{ const box = document.querySelector('.block-editor-inserter__preview-container'); if (!box) return { box: false };
			const none = /No preview available/i.test(box.textContent);
			const frame = box.querySelector('iframe'); const doc = frame && frame.contentDocument;
			const img = doc ? doc.querySelector('img[src*="/assets/previews/"]') : box.querySelector('img[src*="/assets/previews/"]');
			return { box: true, none, img: img ? img.getAttribute('src').replace(/^.*previews\\//, '') : null, loaded: img ? img.complete && img.naturalWidth > 0 : false }; })()` );
		if ( process.env.BWE_SHOTS && hovered ) {
			const r = await evaluate( `(()=>{ const b = document.querySelector('.block-editor-inserter__preview-container'); if (!b) return null; const x = b.getBoundingClientRect(); return { x: x.left, y: x.top, w: x.width, h: x.height }; })()` );
			if ( r && r.w > 0 && r.h > 0 ) {
				const s = await send( 'Page.captureScreenshot', { format: 'png', clip: { x: r.x, y: r.y, width: r.w, height: r.h, scale: 1 } } );
				if ( s.data ) writeFileSync( `${ process.env.BWE_SHOTS }/preview-${ t.name.replace( '/', '-' ) }.png`, Buffer.from( s.data, 'base64' ) );
			}
		}
		results.push( { name: t.name, example: t.example, hovered, ...preview, ok: t.example && hovered && preview.box && ! preview.none && !! preview.img && preview.loaded } );
	}
	// Child blocks (only insertable inside their parent): the example must exist.
	types.filter( ( x ) => x.parent ).forEach( ( t ) => results.push( { name: t.name, child: true, example: t.example, ok: t.example } ) );
	return { ok: results.every( ( r ) => r.ok ), results };
};
