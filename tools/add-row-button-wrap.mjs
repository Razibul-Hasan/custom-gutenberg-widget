// One-off (2026-11-24): with more items per row than the site's default, cards get narrower and the site's
// one-line buttons ("CHOOSE GROWTH →", white-space: nowrap) can stick out of them (seen at 1180–1280px with four
// plans on one row). Every "Items per row" key of the row containers therefore also lets the item buttons wrap
// (same 40px height when the label fits). Only used when a row setting is set; no saved page used one before.
// Idempotent. Usage: node tools/add-row-button-wrap.mjs
import { readFileSync, writeFileSync } from 'node:fs';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const BLOCKS = join( dirname( fileURLToPath( import.meta.url ) ), '../src/blocks' );
const CONTAINERS = [ 'plans', 'services', 'platforms', 'products', 'testimonials', 'process', 'starting-prices', 'cost-panel', 'why-us', 'spec-list', 'who-list', 'steps' ];
const KEYS = [ 'columns', 'columnsTablet', 'columnsMobile', 'oneRow' ];
const BUTTONS = ':is(.wp-block-button__link, .elementor-button, .bwex-card__btn)';
const WRAP = [
	[ 'white-space', 'normal' ],
	[ 'height', 'auto' ],
	[ 'min-height', '40px' ],
	[ 'padding-top', '8px' ],
	[ 'padding-bottom', '8px' ],
	[ 'text-align', 'center' ],
	[ 'line-height', '1.3' ],
];

for ( const block of CONTAINERS ) {
	const file = join( BLOCKS, block, 'block.json' );
	const json = JSON.parse( readFileSync( file, 'utf8' ) );
	let n = 0;
	for ( const setting of json.bweStyleMap || [] ) {
		if ( ! KEYS.includes( setting.key ) ) {
			continue;
		}
		const grid = setting.rules.find( ( r ) => 'grid-template-columns' === r.prop );
		if ( ! grid ) {
			continue;
		}
		const sel = `${ grid.sel || '' } ${ BUTTONS }`;
		if ( setting.rules.some( ( r ) => r.sel === sel ) ) {
			continue;
		}
		WRAP.forEach( ( [ prop, fixed ] ) => setting.rules.push( { sel, prop, fixed, ...( grid.media ? { media: grid.media } : {} ) } ) );
		n++;
	}
	writeFileSync( file, JSON.stringify( json, null, '\t' ) + '\n' );
	console.log( `${ block }: ${ n } setting(s) updated` );
}
