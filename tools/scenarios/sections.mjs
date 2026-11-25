// Editor scenario for the Home section blocks (nothing is saved). For every section block on the target:
// - Styles tab: select it, open the Styles tab, list its panels;
// - styles reach the canvas: set a background + heading colour, check the computed colours in the canvas;
// - items: add one item block, check the count went up, remove it again, check the count is back;
// - a screenshot of the block (BWE_SHOTS=<dir> to save them).
import { writeFileSync } from 'node:fs';

const SECTIONS = {
	'bwe/why-us': { child: 'bwe/spec-card', title: '.bwex-h2 h2' },
	'bwe/testimonials': { child: 'bwe/video-card', title: '.bwex-h2 h2' },
	'bwe/pricing': { child: 'bwe/starting-prices', title: '.bwex-h2 h2' },
	'bwe/plans': { child: 'bwe/price-plan', title: '.bwex-plan h3' },
	'bwe/process': { child: 'bwe/step', title: '.bwex-h2 h2' },
	'bwe/products': { child: 'bwe/product-card', title: '.bwex-h2 h2' },
	'bwe/faq': { child: 'bwe/faq-item', title: '.bwex-h2 h2' },
	'bwe/cta': { child: null, title: '.bwe-final__box > h2' },
	'bwe/starting-prices': { child: null, title: '.bwex-pricenote__label' },
	'bwe/cost-panel': { child: null, title: '.bwex-cost__title h3' },
};

export default async ( { evaluate, send, sleep } ) => {
	const found = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); const out = [];
		const walk = (ids) => ids.forEach((id) => { const n = sel.getBlockName(id); if (${ JSON.stringify( Object.keys( SECTIONS ) ) }.includes(n)) out.push({ id, name: n, mode: sel.getBlockEditingMode(id) }); walk(sel.getBlockOrder(id)); });
		walk(sel.getBlockOrder('')); return out; })()` );
	if ( ! found.length ) return { ok: false, why: 'no section block' };
	// The site animates colours (transition); measure the end state, not a frame of the fade.
	await evaluate( `(()=>{ const doc = document.querySelector('iframe[name="editor-canvas"]')?.contentDocument || document; const s = doc.createElement('style'); s.textContent = '*,*::before,*::after{transition:none!important;animation:none!important}'; doc.head.appendChild(s); return 1; })()` );
	const results = [];
	for ( const block of found ) {
		const conf = SECTIONS[ block.name ];
		const r = { name: block.name, mode: block.mode };
		if ( block.mode === 'disabled' ) {
			// A block inside a nested synced pattern (Home's plans = the shared "Price plans" pattern): edited there.
			results.push( { ...r, ok: true, skipped: 'read-only here (nested synced pattern)' } );
			continue;
		}
		const idj = JSON.stringify( block.id );

		// Styles tab.
		await evaluate( `wp.data.dispatch('core/block-editor').selectBlock(${ idj }); (wp.data.dispatch('core/edit-post') || {}).openGeneralSidebar && wp.data.dispatch('core/edit-post').openGeneralSidebar('edit-post/block'); 1` );
		await sleep( 1200 );
		r.settingsPanels = await evaluate( `[...document.querySelectorAll('.block-editor-block-inspector .components-panel__body-title')].map((t) => t.textContent.trim())` );
		await evaluate( `(()=>{ const t = [...document.querySelectorAll('.block-editor-block-inspector [role="tab"]')].find((e) => /styles/i.test(e.getAttribute('aria-label') || e.textContent)); if (t) t.click(); return !!t; })()` );
		await sleep( 900 );
		r.stylePanels = await evaluate( `[...document.querySelectorAll('.block-editor-block-inspector .components-panel__body-title')].map((t) => t.textContent.trim())` );

		// Styles reach the canvas.
		const keys = block.name === 'bwe/plans' ? { gap: '77px' } : block.name === 'bwe/starting-prices' || block.name === 'bwe/cost-panel' ? { bg: '#ff0000', labelColor: '#00ff00', titleColor: '#00ff00' } : { bgColor: '#ff0000', titleColor: '#00ff00' };
		await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ idj }, { bweStyle: ${ JSON.stringify( keys ) } }); 1` );
		await sleep( 900 );
		r.canvas = await evaluate( `(()=>{ const doc = document.querySelector('iframe[name="editor-canvas"]')?.contentDocument || document;
			const el = doc.getElementById('block-' + ${ idj }); if (!el) return 'no element';
			const scoped = el.matches('[class*="bwe-s-e"]') ? el : el.querySelector('[class*="bwe-s-e"]'); if (!scoped) return 'no scope class';
			const cs = getComputedStyle(scoped); const t = scoped.querySelector(${ JSON.stringify( conf.title ) });
			return { bg: cs.backgroundColor, gap: cs.columnGap, title: t ? getComputedStyle(t).color : 'no title' }; })()` );
		r.stylesOk = typeof r.canvas === 'object' && ( block.name === 'bwe/plans' ? r.canvas.gap === '77px' : r.canvas.bg === 'rgb(255, 0, 0)' && r.canvas.title === 'rgb(0, 255, 0)' );
		await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ idj }, { bweStyle: {} }); 1` );

		// Add + remove an item.
		if ( conf.child ) {
			r.items = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); const d = wp.data.dispatch('core/block-editor');
				const count = () => sel.getBlockOrder(${ idj }).filter((c) => sel.getBlockName(c) === ${ JSON.stringify( conf.child ) }).length;
				const before = count(); const can = sel.canInsertBlockType(${ JSON.stringify( conf.child ) }, ${ idj });
				const nb = wp.blocks.createBlock(${ JSON.stringify( conf.child ) }); d.insertBlock(nb, undefined, ${ idj }, false);
				const added = count(); d.removeBlock(nb.clientId, false); const after = count();
				return { before, can, added, after }; })()` );
			r.itemsOk = r.items.can && r.items.added === r.items.before + 1 && r.items.after === r.items.before;
		}

		// Screenshot.
		if ( process.env.BWE_SHOTS ) {
			await evaluate( `wp.data.dispatch('core/block-editor').clearSelectedBlock(); (document.querySelector('iframe[name="editor-canvas"]')?.contentDocument || document).getElementById('block-' + ${ idj })?.scrollIntoView({ block: 'start' }); 1` );
			await sleep( 1500 );
			const s = await send( 'Page.captureScreenshot', { format: 'png' } );
			writeFileSync( `${ process.env.BWE_SHOTS }/${ block.name.replace( '/', '-' ) }-${ Date.now() }.png`, Buffer.from( s.data, 'base64' ) );
		}
		r.ok = r.stylesOk && ( ! conf.child || r.itemsOk ) && r.stylePanels.length > 0;
		results.push( r );
	}
	return { ok: results.every( ( r ) => r.ok ), results };
};
