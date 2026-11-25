// Opens the block inserter, scrolls to the "Best Web Expert" category and saves a screenshot of the panel.
import { writeFileSync } from 'node:fs';
export default async ( { evaluate, send, sleep } ) => {
	await evaluate( "wp.data.dispatch('core/editor').setIsInserterOpened(true)" );
	await sleep( 2500 );
	const rect = await evaluate( `(()=>{ const h = [...document.querySelectorAll('.block-editor-inserter__panel-title, h2')].find((e) => /Best Web Expert/.test(e.textContent));
		if (!h) return null; h.scrollIntoView({ block: 'center' }); const p = h.closest('.block-editor-inserter__panel-header, div').parentElement.getBoundingClientRect(); return { x: Math.max(0, p.left - 8), y: Math.max(0, p.top - 8), w: p.width + 16, h: Math.min(420, p.height + 16) }; })()` );
	await sleep( 800 );
	const r2 = await evaluate( `(()=>{ const h = [...document.querySelectorAll('.block-editor-inserter__panel-title, h2')].find((e) => /Best Web Expert/.test(e.textContent)); const hr = h.getBoundingClientRect(); const p = h.parentElement.parentElement.getBoundingClientRect(); return { x: Math.max(0, p.left - 8), y: Math.max(0, hr.top - 24), w: p.width + 16, h: 300 }; })()` );
	if ( ! r2 ) return { ok: false, why: 'category panel not found' };
	const s = await send( 'Page.captureScreenshot', { format: 'png', clip: { x: r2.x, y: r2.y, width: r2.w, height: r2.h, scale: 1 } } );
	writeFileSync( 'C:/Users/razib/AppData/Local/Temp/claude/fc52fee2e69757a3/dec2143a-4759-4ed0-a5b2-bedd06625d77/scratchpad/inserter-category.png', Buffer.from( s.data, 'base64' ) );
	return { ok: true, rect: r2 };
};
