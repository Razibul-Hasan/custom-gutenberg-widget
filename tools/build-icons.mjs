// Builds the icon library the editor's icon picker loads on demand: build/icons/lucide.json
//   { version, icons: { name: [ innerSvg, "search words" ] } }
// Source: lucide-static (ISC licence, https://lucide.dev) — the same outline style as the site's own icons.
// Run by `npm run build` / `npm run icons`.
import { readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const ROOT = join( dirname( fileURLToPath( import.meta.url ) ), '..' );
const PKG = join( ROOT, 'node_modules', 'lucide-static' );
const version = JSON.parse( readFileSync( join( PKG, 'package.json' ), 'utf8' ) ).version;
const nodes = JSON.parse( readFileSync( join( PKG, 'icon-nodes.json' ), 'utf8' ) );
const tags = JSON.parse( readFileSync( join( PKG, 'tags.json' ), 'utf8' ) );

const esc = ( v ) => String( v ).replace( /&/g, '&amp;' ).replace( /"/g, '&quot;' ).replace( /</g, '&lt;' );
const icons = {};
Object.keys( nodes ).sort().forEach( ( name ) => {
	const inner = nodes[ name ].map( ( [ tag, attrs ] ) => `<${ tag } ${ Object.entries( attrs ).map( ( [ k, v ] ) => `${ k }="${ esc( v ) }"` ).join( ' ' ) }/>` ).join( '' );
	icons[ name ] = [ inner, ( tags[ name ] || [] ).slice( 0, 8 ).join( ' ' ) ];
} );
mkdirSync( join( ROOT, 'build', 'icons' ), { recursive: true } );
writeFileSync( join( ROOT, 'build', 'icons', 'lucide.json' ), JSON.stringify( { version, icons } ) );
writeFileSync( join( ROOT, 'build', 'icons', 'LICENSE-lucide.txt' ), readFileSync( join( PKG, 'LICENSE' ), 'utf8' ) );
console.log( `build/icons/lucide.json: ${ Object.keys( icons ).length } icons (lucide ${ version })` );
