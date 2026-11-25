// Editor scenario for bwe/faq-item (run on a FAQ pattern, e.g. b1347, where the block is editable):
//  1. layout: the question is a wide grid cell next to the number and a 20px "+" (no letter-by-letter squeeze)
//  2. moving question 3 up renumbers all questions 01, 02, 03 …
//  3. typing in a question (incl. Space) edits it and does not toggle the open answer
export default async ( { inCanvas, send, sleep } ) => {
	const out = { ok: false };
	const q = `const sel = wp.data.select('core/block-editor');
		const items = (() => { const all = []; const walk = (ids) => ids.forEach((id) => { if (sel.getBlockName(id) === 'bwe/faq-item') all.push(id); walk(sel.getBlockOrder(id)); }); walk(sel.getBlockOrder('')); return all; })();`;

	out.layout = await inCanvas( `const s = d.querySelector('[data-type="bwe/faq-item"] summary'); if (!s) return null;
		const r = (e) => e ? Math.round(e.getBoundingClientRect().width) + 'x' + Math.round(e.getBoundingClientRect().height) : '-';
		return { display: W.getComputedStyle(s).display, n: r(s.querySelector('.bwex-faq__n')), q: r(s.querySelector('.bwex-faq__q')), icon: r(s.querySelector('.bwex-faq__icon')) };` );
	const qWidth = parseInt( String( out.layout?.q ).split( 'x' )[ 0 ], 10 );
	const layoutOk = out.layout?.display === 'grid' && qWidth > 250 && out.layout?.icon === '20x20';

	out.before = await inCanvas( `${ q } return items.map((id) => sel.getBlockAttributes(id).n).join(',');` );
	await inCanvas( `${ q } const third = items[2]; wp.data.dispatch('core/block-editor').moveBlocksUp([third], sel.getBlockRootClientId(third)); return 1;` );
	await sleep( 800 );
	out.after = await inCanvas( `${ q } return items.map((id) => sel.getBlockAttributes(id).n).join(',');` );
	const expected = out.after ? out.after.split( ',' ).map( ( _, i ) => String( i + 1 ).padStart( 2, '0' ) ).join( ',' ) : '?';
	const renumberOk = out.after === expected;

	// Select question 1, put the caret at the end of its text, type " X" then press Space.
	await inCanvas( `${ q } wp.data.dispatch('core/block-editor').selectBlock(items[0]); return 1;` );
	await sleep( 500 );
	await inCanvas( `const el = d.querySelector('[data-type="bwe/faq-item"] .bwex-faq__q[contenteditable="true"]'); el.focus();
		const range = d.createRange(); range.selectNodeContents(el); range.collapse(false); const s = W.getSelection(); s.removeAllRanges(); s.addRange(range); return 1;` );
	await send( 'Input.insertText', { text: ' X' } );
	await send( 'Input.dispatchKeyEvent', { type: 'keyDown', key: ' ', code: 'Space', text: ' ', windowsVirtualKeyCode: 32 } );
	await send( 'Input.dispatchKeyEvent', { type: 'keyUp', key: ' ', code: 'Space', windowsVirtualKeyCode: 32 } );
	await sleep( 500 );
	out.typed = await inCanvas( `${ q } const det = d.querySelector('[data-type="bwe/faq-item"]'); return { question: sel.getBlockAttributes(items[0]).question.slice(-12), open: det.open };` );
	const typingOk = /X(\s|&nbsp;| )$/.test( out.typed?.question || '' ) && out.typed?.open === true;

	out.checks = { layoutOk, renumberOk, typingOk };
	out.ok = layoutOk && renumberOk && typingOk;
	return out;
};
