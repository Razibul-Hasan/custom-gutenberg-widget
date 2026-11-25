// Inserter preview images: a screenshot of each block as it looks on the live site, saved to
// assets/previews/<block>.webp (shown when the block is hovered in the inserter, see includes/previews.php).
// Usage: node tools/make-previews.mjs [block …]   (no args = all). Re-run after a block's look changes.
import { mkdirSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
import { open, sleep } from './cdp.mjs';

const OUT = join( dirname( fileURLToPath( import.meta.url ) ), '..', 'assets', 'previews' );
const SITE = 'http://bestwebexpert.local';
const HOME = SITE + '/';
// block → [ page, selector, max height (css px), padding around (css px) ]
const SHOTS = {
	hero: [ HOME, 'section.bwex-hero', 900, 0 ],
	services: [ HOME, '#services', 1100, 0 ],
	'service-tile': [ HOME, '#services .bwex-svc__item', 0, 24 ],
	section: [ HOME, '#experts', 1100, 0 ],
	'section-head': [ HOME, '#testimonials .bwex-headw', 0, 32 ],
	platforms: [ HOME, '#experts .bwex-plats', 1100, 24 ],
	'platform-card': [ HOME, '#experts .elementor-widget-bwex-platform-card', 1100, 24 ],
	'who-list': [ HOME, 'section.bwex-who .bwex-who__list', 1000, 24 ],
	'who-card': [ HOME, 'section.bwex-who .bwex-who__list > li', 0, 24 ],
	'why-us': [ HOME, 'section#spec', 1100, 0 ],
	'spec-list': [ SITE + '/best-wordpress-expert/', '.bwex-spec__list', 900, 24 ],
	'spec-card': [ HOME, '#spec .bwex-spec__list > li', 0, 24 ],
	testimonials: [ HOME, 'section#testimonials', 1100, 0 ],
	'video-card': [ HOME, '#testimonials .bwex-vt', 0, 24 ],
	pricing: [ HOME, 'section#pricing', 1300, 0 ],
	plans: [ HOME, '#pricing .bwex-plans', 1000, 24 ],
	'price-plan': [ HOME, '#pricing .elementor-widget-bwex-pricing-plan:has(.bwex-plan--featured)', 0, 24 ],
	'starting-prices': [ HOME, '#pricing .bwex-pricenote', 0, 24 ],
	'cost-panel': [ HOME, '#pricing .bwex-cost', 0, 24 ],
	'price-list': [ SITE + '/pricing/', '.bwe-prx__list', 900, 24 ],
	'price-row': [ SITE + '/pricing/', '.bwe-prx__list > li', 0, 24 ],
	'price-section': [ SITE + '/pricing/', 'section#prices', 1300, 0 ],
	'price-card': [ SITE + '/pricing/', '#prices .elementor-widget-bwex-platform-card', 1100, 24 ],
	work: [ SITE + '/portfolio/', 'section#work', 1300, 0 ],
	'work-item': [ SITE + '/portfolio/', '#work .bwex-work__item', 0, 24 ],
	'contact-form': [ SITE + '/contact/', 'section#form', 1300, 0 ],
	about: [ SITE + '/contact/', 'section#about', 1300, 0 ],
	process: [ HOME, 'section#process', 1000, 0 ],
	steps: [ SITE + '/best-wordpress-expert/', 'ol.bwex-num', 900, 24 ],
	step: [ HOME, '#process .bwex-num__item', 0, 24 ],
	products: [ HOME, 'section#work', 1200, 0 ],
	'product-card': [ HOME, '#work .elementor-widget-bwex-plugin-card', 0, 24 ],
	faq: [ HOME, 'section#faq', 1100, 0 ],
	'faq-item': [ HOME, '#faq details.bwex-faq__item', 560, 24 ],
	cta: [ HOME, 'section.bwe-final', 0, 24 ],
};
const MAX_W = 480; // output image width (px)

const only = process.argv.slice( 2 );
const byPage = {};
Object.entries( SHOTS ).forEach( ( [ block, shot ] ) => {
	if ( ! only.length || only.includes( block ) ) ( byPage[ shot[ 0 ] ] = byPage[ shot[ 0 ] ] || [] ).push( [ block, ...shot.slice( 1 ) ] );
} );
mkdirSync( OUT, { recursive: true } );

for ( const [ url, list ] of Object.entries( byPage ) ) {
	const b = await open( url, { width: 1440, height: 1000 } );
	await b.send( 'Emulation.setEmulatedMedia', { features: [ { name: 'prefers-reduced-motion', value: 'reduce' } ] } );
	await b.send( 'Page.reload', {} );
	await sleep( 6000 );
	// No sticky header / chat bubble over the shots; no animations half-way; the first FAQ answer open.
	await b.evaluate( `(()=>{ const s = document.createElement('style'); s.textContent = '*,*::before,*::after{transition:none!important;animation-play-state:paused!important} #bwe-hf,#bwe-hf *,.crisp-client{display:none!important;visibility:hidden!important}'; document.head.appendChild(s);
		document.querySelectorAll('body *').forEach((e) => { const p = getComputedStyle(e).position; if (p === 'fixed' || p === 'sticky') e.style.setProperty('display', 'none', 'important'); });
		document.querySelectorAll('.bwex-reveal, [data-bwex-pre]').forEach((e) => { e.style.setProperty('opacity', '1', 'important'); e.style.setProperty('transform', 'none', 'important'); });
		const d = document.querySelector('#faq details.bwex-faq__item'); if (d) d.open = true; return 1; })()` );
	for ( const [ block, , maxH, pad ] of list ) {
		const rect = await b.evaluate( `(()=>{ const e = document.querySelector(${ JSON.stringify( SHOTS[ block ][ 1 ] ) }); if (!e) return null; e.scrollIntoView({ block: 'center' }); const r = e.getBoundingClientRect(); return { x: r.left + scrollX, y: r.top + scrollY, w: r.width, h: r.height }; })()` );
		if ( ! rect ) {
			console.log( 'MISSING', block );
			continue;
		}
		await sleep( 900 );
		const w = rect.w + pad * 2;
		const h = Math.min( rect.h + pad * 2, maxH || 99999 );
		const s = await b.send( 'Page.captureScreenshot', { format: 'webp', quality: 45, captureBeyondViewport: true, clip: { x: Math.max( 0, rect.x - pad ), y: Math.max( 0, rect.y - pad ), width: w, height: h, scale: Math.min( 1, MAX_W / w ) } } );
		if ( ! s.data ) {
			console.log( 'FAILED', block, JSON.stringify( s ).slice( 0, 300 ), JSON.stringify( rect ) );
			continue;
		}
		writeFileSync( join( OUT, block + '.webp' ), Buffer.from( s.data, 'base64' ) );
		console.log( block, Math.round( w ) + 'x' + Math.round( h ) );
	}
	b.close();
}
process.exit( 0 );
