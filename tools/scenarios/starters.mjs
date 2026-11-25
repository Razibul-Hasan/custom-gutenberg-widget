// Editor scenario (nothing saved): every bwe/* block has a default "starter" variation, and inserting each
// root-level block from its real inserter item (as the inserter does) gives a filled, valid block.
// Saves a screenshot when BWE_SHOTS=<dir>. BWE_SAVE=1 replaces the page content with every widget and saves it.
import { writeFileSync } from 'node:fs';

// These are filled without a starter variation: own defaults (starting prices) or the Section's starter template.
const NO_STARTER_NEEDED = [ 'bwe/section', 'bwe/starting-prices' ];

export default async ( { evaluate, send, sleep } ) => {
	const out = await evaluate( `(()=>{ const B = wp.blocks, S = wp.data.select('core/block-editor'), D = wp.data.dispatch('core/block-editor');
		const types = B.getBlockTypes().filter((t) => t.name.startsWith('bwe/'));
		const noStarter = types.filter((t) => !${ JSON.stringify( NO_STARTER_NEEDED ) }.includes(t.name) && !wp.data.select('core/blocks').getDefaultBlockVariation(t.name, 'inserter')).map((t) => t.name);
		const made = [];
		if (${ JSON.stringify( !! process.env.BWE_SAVE ) }) D.resetBlocks([]); // BWE_SAVE=1: a clean page of every widget, saved (test pages only).
		S.getInserterItems().filter((i) => i.name.startsWith('bwe/')).forEach((i) => {
			const b = B.createBlock(i.name, i.initialAttributes, B.createBlocksFromInnerBlocksTemplate(i.innerBlocks || []));
			D.insertBlocks(b);
			made.push({ name: i.name, id: b.clientId });
		});
		return { noStarter, made }; })()` );
	if ( ! out || out.error ) {
		return { ok: false, step: 'insert', error: out };
	}
	await sleep( 4000 );
	const res = await evaluate( `(()=>{ const S = wp.data.select('core/block-editor'); const d = document.querySelector('iframe[name="editor-canvas"]').contentDocument;
		const KEYS = /^(title|lead|eyebrow|intro|name|text|question|desc|tag|who|label|price|btnText|btn1Text|content|service|amount|chip|more|aside)$/;
		const words = (b) => Object.entries(b.attributes).filter(([k, v]) => typeof v === 'string' && KEYS.test(k) && v.replace(/<[^>]+>/g, '').trim()).length
			+ (Array.isArray(b.attributes.items) ? b.attributes.items.length : 0) + b.innerBlocks.reduce((n, c) => n + words(c), 0);
		return ${ JSON.stringify( out.made ) }.map((m) => { const b = S.getBlock(m.id); const el = d.getElementById('block-' + m.id);
			return { name: m.name, valid: !! b && b.isValid !== false, filled: b ? words(b) : 0, children: b ? b.innerBlocks.length : 0, text: el ? el.innerText.replace(/\\s+/g, ' ').trim().slice(0, 60) : null }; }); })()` );
	if ( process.env.BWE_SAVE ) {
		await evaluate( "wp.data.dispatch('core/editor').savePost(); 1" );
		await sleep( 6000 );
	}
	if ( ! Array.isArray( res ) ) {
		return { ok: false, step: 'check', error: res };
	}
	if ( process.env.BWE_SHOTS ) {
		const s = await send( 'Page.captureScreenshot', { format: 'png' } );
		if ( s.data ) writeFileSync( process.env.BWE_SHOTS + '/starters.png', Buffer.from( s.data, 'base64' ) );
	}
	const empty = res.filter( ( r ) => ! r.valid || r.filled === 0 ).map( ( r ) => r.name );
	return { ok: out.noStarter.length === 0 && empty.length === 0 && res.length > 0, noStarter: out.noStarter, inserted: res.length, empty, res };
};
