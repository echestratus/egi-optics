#!/usr/bin/env node
/**
 * Converts CRLF line endings to LF in all tracked text files.
 * Windows editors sometimes write CRLF; the repository (and the Linux server) expect LF.
 *
 * Usage: node scripts/dev/normalize-eol.mjs
 */
import { execSync } from 'node:child_process';
import { readFileSync, writeFileSync } from 'node:fs';

const BINARY = /\.(png|jpe?g|gif|webp|avif|ico|woff2?|ttf|otf|eot|pdf|mp4|webm|zip)$/i;

const files = execSync( 'git ls-files --cached --others --exclude-standard', { encoding: 'utf8' } )
	.split( /\r?\n/ )
	.filter( ( f ) => f && ! BINARY.test( f ) );

let changed = 0;
for ( const file of files ) {
	let buf;
	try {
		buf = readFileSync( file );
	} catch {
		continue;
	}
	if ( ! buf.includes( 0x0d ) ) {
		continue;
	}
	const text = buf.toString( 'utf8' ).replace( /\r\n/g, '\n' ).replace( /\r/g, '\n' );
	writeFileSync( file, text );
	changed++;
}
console.log( `Normalised ${ changed } file(s) to LF.` );
