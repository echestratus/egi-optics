#!/usr/bin/env node
/**
 * Copies the self-hosted variable fonts (OFL licensed) from the fontsource npm packages
 * into the theme so no request ever goes to Google Fonts.
 *
 * Usage: node scripts/dev/sync-fonts.mjs   (re-run after bumping a @fontsource-variable/* package)
 */
import { copyFileSync, existsSync, mkdirSync, readdirSync, writeFileSync } from 'node:fs';
import { join } from 'node:path';

const ROOT = process.cwd();
const DEST = join( ROOT, 'wp-content', 'themes', 'egi-optics', 'assets', 'fonts' );

const FONTS = [
	{ pkg: '@fontsource-variable/space-grotesk', files: [ 'space-grotesk-latin-wght-normal.woff2', 'space-grotesk-latin-ext-wght-normal.woff2' ] },
	{ pkg: '@fontsource-variable/dm-sans', files: [ 'dm-sans-latin-wght-normal.woff2', 'dm-sans-latin-ext-wght-normal.woff2', 'dm-sans-latin-wght-italic.woff2' ] },
	{ pkg: '@fontsource-variable/jetbrains-mono', files: [ 'jetbrains-mono-latin-wght-normal.woff2', 'jetbrains-mono-latin-ext-wght-normal.woff2' ] },
];

mkdirSync( DEST, { recursive: true } );

const licenseNotes = [ '# Font licences', '', 'All fonts are variable WOFF2 files distributed under the SIL Open Font License 1.1 and copied from the fontsource packages listed below with `node scripts/dev/sync-fonts.mjs`.', '' ];

for ( const font of FONTS ) {
	const pkgDir = join( ROOT, 'node_modules', ...font.pkg.split( '/' ) );
	if ( ! existsSync( pkgDir ) ) {
		console.error( `✖ ${ font.pkg } is not installed. Run: npm install` );
		process.exit( 1 );
	}
	for ( const file of font.files ) {
		copyFileSync( join( pkgDir, 'files', file ), join( DEST, file ) );
		console.log( `✔ ${ file }` );
	}
	const licenseFile = readdirSync( pkgDir ).find( ( f ) => /^LICENSE/i.test( f ) );
	if ( licenseFile ) {
		const target = `LICENSE-${ font.pkg.split( '/' )[ 1 ] }.txt`;
		copyFileSync( join( pkgDir, licenseFile ), join( DEST, target ) );
		licenseNotes.push( `- ${ font.pkg } -> ${ target }` );
	}
}

writeFileSync( join( DEST, 'README.md' ), licenseNotes.join( '\n' ) + '\n' );
console.log( `\nFonts synced to ${ DEST }` );
