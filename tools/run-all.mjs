// Developer commands (run from the plugin folder):
//   npm test                     PHP tests (tools/tests)
//   npm run verify               build + tests + live HTML vs baseline + editor check of all 31 pages
//   npm run editor -- 1104 b1347  editor check of chosen targets
// PHP defaults to Local's PHP 8.5; override with BWE_PHP. Snapshots/backups live in app/backups/blocks-migration-2026-11-22.
import { spawnSync } from 'node:child_process';
import { mkdirSync, writeFileSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { join, resolve, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const TOOLS = dirname( fileURLToPath( import.meta.url ) );
const PLUGIN = resolve( TOOLS, '..' );
const WP = resolve( PLUGIN, '../../..' );
const BACKUPS = resolve( WP, '../backups/blocks-migration-2026-11-22' );
const PHP = process.env.BWE_PHP || 'C:/Users/razib/AppData/Roaming/Local/lightning-services/php-8.5.12+0/bin/win64/php.exe';
const PHP_ARGS = process.env.BWE_PHP ? [] : [ '-c', 'C:/Users/razib/AppData/Roaming/Local/run/MtgBfORRm/conf/php/php.ini' ];
const PAGES = [ 1104, 512, 513, 514, 519, 521, 544, 547, 754, 761, 762, 763, 822, 826, 830, 831, 832, 833, 834, 835, 836, 837, 838, 839, 840, 841, 842, 843, 844, 941, 1115 ];

const run = ( cmd, args, opts = {} ) => {
	const r = spawnSync( cmd, args, { stdio: opts.capture ? [ 'ignore', 'pipe', 'inherit' ] : 'inherit', encoding: 'utf8', shell: opts.shell || false } );
	return opts.capture ? { status: r.status, out: r.stdout } : r.status;
};
const php = ( script, ...args ) => run( PHP, [ ...PHP_ARGS, join( TOOLS, script ), ...args ] );
const step = ( name, status ) => {
	console.log( `\n== ${ name }: ${ status === 0 ? 'OK' : 'FAILED' }` );
	if ( status !== 0 ) process.exit( status || 1 );
};
const cookies = () => {
	const r = run( PHP, [ ...PHP_ARGS, join( TOOLS, 'cookie.php' ), WP ], { capture: true } );
	const file = join( tmpdir(), 'bwe-cookies.txt' ); // secret: kept out of the web root
	writeFileSync( file, r.out.split( /\r?\n/ ).filter( ( l ) => l.startsWith( 'wordpress_' ) ).join( '\n' ) );
	return file;
};
const editor = ( targets ) => run( 'node', [ join( TOOLS, 'editor-check.mjs' ), '--cookies', cookies(), ...targets.map( String ) ] );

const [ cmd = 'tests', ...rest ] = process.argv.slice( 2 );
if ( cmd === 'tests' ) {
	process.exit( php( 'run-tests.php', WP, ...rest ) );
} else if ( cmd === 'editor' ) {
	process.exit( editor( rest.length ? rest : PAGES ) );
} else if ( cmd === 'verify' ) {
	step( 'build', run( 'npm', [ 'run', 'build', '--silent' ], { shell: true } ) );
	step( 'PHP tests', php( 'run-tests.php', WP ) );
	const snap = join( BACKUPS, 'verify-' + new Date().toISOString().replace( /[:.]/g, '-' ) );
	mkdirSync( snap, { recursive: true } );
	step( 'snapshot live pages', php( 'snapshot-front.php', WP, snap ) );
	step( 'live HTML identical to baseline', php( 'compare-front.php', join( BACKUPS, 'baseline' ), snap ) );
	step( 'editor check (31 pages)', editor( PAGES ) );
	console.log( '\nAll checks passed.' );
} else {
	console.error( `unknown command "${ cmd }" (tests | editor | verify)` );
	process.exit( 2 );
}
