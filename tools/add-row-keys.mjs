// One-off (2026-11-24): adds the "Items per row" style keys (columns per device + "all on one row") to the container
// blocks that miss them. Existing keys are never changed, so saved settings keep their exact CSS. Idempotent.
// Usage: node tools/add-row-keys.mjs
import { readFileSync, writeFileSync } from 'node:fs';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const BLOCKS = join( dirname( fileURLToPath( import.meta.url ) ), '../src/blocks' );

// Block => [ list selector (relative to the block), keys to add, max columns per device ].
const PLAN = {
	plans: [ '', [ 'columnsMobile', 'oneRow' ] ],
	services: [ ' .bwex-svc__grid', [ 'oneRow' ] ],
	platforms: [ '', [ 'oneRow' ] ],
	products: [ ' .bwex-cards', [ 'oneRow' ] ],
	testimonials: [ ' .bwex-quotes', [ 'oneRow' ] ],
	process: [ ' .bwex-num', [ 'oneRow' ] ],
	'starting-prices': [ ' .bwex-pricenote__list', [ 'columnsTablet', 'oneRow' ] ],
	'cost-panel': [ ' .bwex-cost__grid', [ 'columnsTablet', 'oneRow' ] ],
	'why-us': [ ' .bwex-spec__list', [ 'columns', 'columnsTablet', 'columnsMobile', 'oneRow' ] ],
	'spec-list': [ '', [ 'columns', 'columnsTablet', 'columnsMobile', 'oneRow' ] ],
	'who-list': [ '', [ 'columns', 'columnsTablet', 'columnsMobile', 'oneRow' ] ],
	steps: [ '', [ 'columns', 'columnsTablet', 'columnsMobile', 'oneRow' ] ],
};

const MEDIA = { columns: 'desktop', columnsTablet: 'tablet', columnsMobile: 'mobile' };
const LABEL = { columns: 'Items per row (desktop)', columnsTablet: 'Items per row (tablet)', columnsMobile: 'Items per row (phone)' };
const MAX = { columns: 6, columnsTablet: 4, columnsMobile: 3 };

// A set count also clears the site's own spans (bento spec cards, a full-width last card …), so it is exact.
const columnsKey = ( key, sel ) => ( {
	key,
	label: LABEL[ key ],
	panel: 'Layout',
	control: 'range',
	min: 1,
	max: MAX[ key ],
	rules: [
		{ sel, prop: 'display', fixed: 'grid', media: MEDIA[ key ] },
		{ sel, prop: 'grid-template-columns', tpl: 'repeat({v}, minmax(0, 1fr))', media: MEDIA[ key ] },
		{ sel: `${ sel } > *`, prop: 'grid-column', fixed: 'auto', media: MEDIA[ key ] },
		{ sel: `${ sel } > *`, prop: 'width', fixed: 'auto', media: MEDIA[ key ] },
	],
} );
// Every item on one row (desktop) while each stays at least 200px wide; more items than fit wrap instead of overflowing.
const oneRowKey = ( sel ) => ( {
	key: 'oneRow',
	label: 'All items on one row (desktop, while they fit)',
	panel: 'Layout',
	control: 'toggle',
	rules: [
		{ sel, prop: 'display', fixed: 'grid', media: 'desktop' },
		{ sel, prop: 'grid-template-columns', fixed: 'repeat(auto-fit, minmax(min(100%, 200px), 1fr))', media: 'desktop' },
		{ sel: `${ sel } > *`, prop: 'grid-column', fixed: 'auto', media: 'desktop' },
		{ sel: `${ sel } > *`, prop: 'width', fixed: 'auto', media: 'desktop' },
	],
} );

for ( const [ block, [ sel, keys ] ] of Object.entries( PLAN ) ) {
	const file = join( BLOCKS, block, 'block.json' );
	const json = JSON.parse( readFileSync( file, 'utf8' ) );
	json.attributes = json.attributes || {};
	json.attributes.bweStyle = json.attributes.bweStyle || { type: 'object', default: {} };
	json.bweStyleMap = json.bweStyleMap || [];
	const added = [];
	for ( const key of keys ) {
		if ( json.bweStyleMap.some( ( s ) => s.key === key ) ) {
			continue;
		}
		const setting = 'oneRow' === key ? oneRowKey( sel ) : columnsKey( key, sel );
		// Keep device order: desktop, tablet, phone, then "one row" (later rules win in the CSS).
		const order = [ 'columns', 'columnsTablet', 'columnsMobile', 'oneRow' ];
		const after = json.bweStyleMap.map( ( s ) => s.key ).filter( ( k ) => order.indexOf( k ) > -1 && order.indexOf( k ) < order.indexOf( key ) ).pop();
		const at = after ? json.bweStyleMap.findIndex( ( s ) => s.key === after ) + 1 : 0;
		json.bweStyleMap.splice( at, 0, setting );
		added.push( key );
	}
	writeFileSync( file, JSON.stringify( json, null, '\t' ) + '\n' );
	console.log( `${ block }: ${ added.length ? 'added ' + added.join( ', ' ) : 'nothing to add' }` );
}
