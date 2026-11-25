// Editor scenario (nothing saved): insert a fresh Section like a user does. It must fill with the starter layout
// (content wrap → section head, paragraph, buttons), show the "Section style" picker, and switching to Dark must
// turn the canvas section dark. Saves a screenshot when BWE_SHOTS=<dir>.
import { writeFileSync } from 'node:fs';
export default async ( { evaluate, send, sleep } ) => {
	const id = await evaluate( `(()=>{ const b = wp.blocks.createBlock('bwe/section'); wp.data.dispatch('core/block-editor').insertBlocks(b, 0); wp.data.dispatch('core/block-editor').selectBlock(b.clientId); (wp.data.dispatch('core/edit-post') || {}).openGeneralSidebar && wp.data.dispatch('core/edit-post').openGeneralSidebar('edit-post/block'); return b.clientId; })()` );
	await sleep( 2500 );
	const idj = JSON.stringify( id );
	const tree = await evaluate( `(()=>{ const t = (b) => b.name + (b.innerBlocks.length ? '[' + b.innerBlocks.map(t).join(',') + ']' : ''); return t(wp.data.select('core/block-editor').getBlock(${ idj })); })()` );
	const picker = await evaluate( `(()=>{ const l = [...document.querySelectorAll('.block-editor-block-inspector label')].find((x) => x.textContent.trim() === 'Section style'); const s = l && document.getElementById(l.htmlFor); if (!s) return null;
		Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype, 'value').set.call(s, 'bwe-gw-tone--dark'); s.dispatchEvent(new Event('change', { bubbles: true })); return [...s.options].map((o) => o.text); })()` );
	await sleep( 1500 );
	const canvas = await evaluate( `(()=>{ const d = document.querySelector('iframe[name="editor-canvas"]').contentDocument; const s = d.getElementById('block-' + ${ idj }); if (!s) return null; const h = s.querySelector('.bwex-h2 h2'); const eb = s.querySelector('.bwex-eyebrow p'); return { cls: s.className.replace(/block-editor\S*|wp-block\b|is-\S*/g, '').trim(), bg: getComputedStyle(s).backgroundColor, h2: h && getComputedStyle(h).color, eyebrowChip: eb && getComputedStyle(eb, '::before').backgroundColor }; })()` );
	const classes = await evaluate( `wp.data.select('core/block-editor').getBlockAttributes(${ idj }).classes` );
	if ( process.env.BWE_SHOTS ) {
		await evaluate( `wp.data.dispatch('core/block-editor').clearSelectedBlock(); 1` );
		await sleep( 800 );
		const s = await send( 'Page.captureScreenshot', { format: 'png' } );
		if ( s.data ) writeFileSync( process.env.BWE_SHOTS + '/new-section.png', Buffer.from( s.data, 'base64' ) );
	}
	const ok = tree.startsWith( 'bwe/section[core/group[bwe/section-head,core/paragraph,core/buttons[core/button]]]' ) && !! picker && classes === 'bwex-section bwe-gw-tone--dark' && canvas && canvas.bg === 'rgb(11, 13, 12)' && canvas.h2 === 'rgb(244, 244, 240)';
	return { ok, tree, picker, classes, canvas };
};
