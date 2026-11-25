// Editor scenario (nothing is saved): select the first styled block (bwe/section, hero or services), open the
// block sidebar's Styles tab and report what the user sees — editing mode, tabs, panel titles. Where the Styles
// tab exists, drive each kind of control the way a user does (colour swatch, toggle, select, unit input, range)
// and check each one writes its value to the block's bweStyle.
export default async ( { evaluate, sleep } ) => {
	const pick = await evaluate( `(()=>{ const sel = wp.data.select('core/block-editor'); let out = null;
		const walk = (ids, inRef) => ids.forEach((id) => { const n = sel.getBlockName(id); if (!out && ['bwe/section','bwe/hero','bwe/services'].includes(n)) out = { id, name: n, inRef }; walk(sel.getBlockOrder(id), inRef || n === 'core/block'); });
		walk(sel.getBlockOrder(''), false); if (!out) return null;
		out.mode = sel.getBlockEditingMode(out.id);
		wp.data.dispatch('core/block-editor').selectBlock(out.id);
		(wp.data.dispatch('core/edit-post') || {}).openGeneralSidebar && wp.data.dispatch('core/edit-post').openGeneralSidebar('edit-post/block');
		return out; })()` );
	if ( ! pick ) return { ok: false, why: 'no styled block' };
	await sleep( 1500 );
	const ui = await evaluate( `(()=>{ const ins = document.querySelector('.block-editor-block-inspector'); if (!ins) return { inspector: false };
		const tabs = [...ins.querySelectorAll('[role="tab"]')].map((t) => t.getAttribute('aria-label') || t.textContent.trim());
		const styles = [...ins.querySelectorAll('[role="tab"]')].find((t) => /styles/i.test(t.getAttribute('aria-label') || t.textContent));
		if (styles) styles.click();
		return { inspector: true, tabs }; })()` );
	await sleep( 1000 );
	const panels = await evaluate( `[...document.querySelectorAll('.block-editor-block-inspector .components-panel__body-title')].map((t) => t.textContent.trim())` );
	if ( ! ui.tabs?.length ) return { ok: false, why: 'no Settings/Styles tabs (block is ' + pick.mode + ')', ...pick, ...ui, panels };

	const attr = `JSON.stringify(wp.data.select('core/block-editor').getBlockAttributes(${ JSON.stringify( pick.id ) }).bweStyle || {})`;
	// Opens a panel by title and runs a UI action inside it; returns bweStyle afterwards.
	const act = async ( panel, action ) => {
		await evaluate( `(()=>{ const ins = document.querySelector('.block-editor-block-inspector');
			const t = [...ins.querySelectorAll('.components-panel__body-toggle')].find((b) => b.textContent.trim() === ${ JSON.stringify( panel ) });
			if (t && t.getAttribute('aria-expanded') !== 'true') t.click(); return 1; })()` );
		await sleep( 400 );
		const done = await evaluate( `(()=>{ const ins = document.querySelector('.block-editor-block-inspector');
			const body = [...ins.querySelectorAll('.components-panel__body')].find((b) => b.querySelector('.components-panel__body-toggle')?.textContent.trim() === ${ JSON.stringify( panel ) });
			if (!body) return 'no panel';
			const type = (el, value) => { const proto = Object.getPrototypeOf(el); Object.getOwnPropertyDescriptor(proto, 'value').set.call(el, value);
				el.dispatchEvent(new Event('input', { bubbles: true })); el.dispatchEvent(new Event('change', { bubbles: true })); el.dispatchEvent(new Event('blur', { bubbles: true })); };
			${ action } })()` );
		await sleep( 600 );
		return { done, style: await evaluate( attr ) };
	};
	const before = await evaluate( attr );
	const steps = {};
	steps.color = await act( 'Background', `const o = body.querySelector('.components-circular-option-picker__option'); if (!o) return 'no swatch'; o.click(); return 'clicked';` );
	steps.toggle = await act( 'Background', `const o = body.querySelector('.components-form-toggle input'); if (!o) return 'no toggle'; o.click(); return 'clicked';` );
	steps.select = await act( 'Heading', `const o = body.querySelector('select'); if (!o) return 'no select'; type(o, o.options[o.options.length - 1].value); return o.value;` );
	steps.unit = await act( 'Layout', `const o = body.querySelector('.components-unit-control input, input[type="number"]'); if (!o) return 'no unit'; o.focus(); type(o, '50'); return 'typed';` );
	steps.range = await act( 'Heading', `const o = body.querySelector('.components-range-control input[type="number"]'); if (!o) return 'no range'; o.focus(); type(o, '1.2'); return 'typed';` );
	await evaluate( `wp.data.dispatch('core/block-editor').updateBlockAttributes(${ JSON.stringify( pick.id ) }, { bweStyle: {} }); 1` );
	const keys = ( s ) => Object.keys( JSON.parse( s ) );
	let prev = keys( before );
	const wrote = {};
	for ( const [ k, v ] of Object.entries( steps ) ) {
		const now = keys( v.style );
		wrote[ k ] = now.filter( ( x ) => ! prev.includes( x ) ).map( ( x ) => x + '=' + JSON.parse( v.style )[ x ] ).join( ',' ) || 'NOTHING (' + v.done + ')';
		prev = now;
	}
	return { ok: Object.values( wrote ).every( ( w ) => ! w.startsWith( 'NOTHING' ) ), ...pick, tabs: ui.tabs, panels, wrote };
};
