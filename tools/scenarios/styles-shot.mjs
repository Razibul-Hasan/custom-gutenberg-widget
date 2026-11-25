// Selects the hero/services block, opens the block sidebar's Styles tab and saves a screenshot of the editor.
import { writeFileSync } from 'node:fs';
export default async ( { evaluate, send, sleep } ) => {
	const id = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); let f = null; const walk = (ids) => ids.forEach((i) => { if (!f && ['bwe/hero', 'bwe/services', 'bwe/section'].includes(sel.getBlockName(i))) f = i; walk(sel.getBlockOrder(i)); }); walk(sel.getBlockOrder('')); return f; })()` );
	await evaluate( `wp.data.dispatch('core/block-editor').selectBlock(${ JSON.stringify( id ) }); wp.data.dispatch('core/edit-post') && wp.data.dispatch('core/edit-post').openGeneralSidebar && wp.data.dispatch('core/edit-post').openGeneralSidebar('edit-post/block'); 1` );
	await sleep( 1500 );
	const tab = await evaluate( `(()=>{ const t = [...document.querySelectorAll('[role="tab"]')].find((e) => /^Styles$/i.test(e.textContent.trim()) || e.getAttribute('aria-label') === 'Styles'); if (t) { t.click(); return true; } return false; })()` );
	await sleep( 1200 );
	const panels = await evaluate( `[...document.querySelectorAll('.components-panel__body-title')].map((e) => e.textContent.trim())` );
	const s = await send( 'Page.captureScreenshot', { format: 'png' } );
	writeFileSync( 'C:/Users/razib/AppData/Local/Temp/claude/fc52fee2e69757a3/dec2143a-4759-4ed0-a5b2-bedd06625d77/scratchpad/styles-' + Date.now() + '.png', Buffer.from( s.data, 'base64' ) );
	return { ok: tab && panels.length > 0, tab, panels };
};
