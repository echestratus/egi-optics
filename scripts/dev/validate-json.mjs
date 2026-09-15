#!/usr/bin/env node
/**
 * Validates every JSON file that WordPress will parse at runtime
 * (theme.json, block.json, .wp-env.json, package.json, composer.json)
 * and checks a few structural invariants of theme.json so a bad merge
 * cannot silently break global styles in production.
 *
 * Usage: node scripts/dev/validate-json.mjs
 */
import { existsSync, readFileSync, readdirSync, statSync } from 'node:fs';
import { join, relative, sep } from 'node:path';

const ROOT = process.cwd();
const IGNORED_DIRS = new Set( [ 'node_modules', 'vendor', '.git', '.wp-env', 'build' ] );

function walk( dir, out = [] ) {
	if ( ! existsSync( dir ) ) {
		return out;
	}
	for ( const entry of readdirSync( dir ) ) {
		if ( IGNORED_DIRS.has( entry ) ) {
			continue;
		}
		const full = join( dir, entry );
		const st = statSync( full );
		if ( st.isDirectory() ) {
			walk( full, out );
		} else if ( entry.endsWith( '.json' ) ) {
			out.push( full );
		}
	}
	return out;
}

const targets = [
	...walk( join( ROOT, 'wp-content', 'themes', 'egi-optics' ) ),
	...walk( join( ROOT, 'wp-content', 'plugins', 'egi-optics-core' ) ),
	join( ROOT, '.wp-env.json' ),
	join( ROOT, 'package.json' ),
	join( ROOT, 'composer.json' ),
];

let failures = 0;

for ( const file of targets ) {
	const rel = relative( ROOT, file ).split( sep ).join( '/' );
	let data;
	try {
		data = JSON.parse( readFileSync( file, 'utf8' ) );
	} catch ( error ) {
		failures++;
		console.error( `✖ ${ rel }: invalid JSON - ${ error.message }` );
		continue;
	}

	if ( rel.endsWith( '/theme.json' ) ) {
		const problems = [];
		if ( data.version !== 3 ) {
			problems.push( 'theme.json "version" must be 3' );
		}
		if ( ! data.settings?.color?.palette?.length ) {
			problems.push( 'settings.color.palette is empty' );
		}
		const slugs = new Set();
		for ( const c of data.settings?.color?.palette ?? [] ) {
			if ( slugs.has( c.slug ) ) {
				problems.push( `duplicate palette slug "${ c.slug }"` );
			}
			slugs.add( c.slug );
			if ( ! /^#([0-9a-f]{3}|[0-9a-f]{6}|[0-9a-f]{8})$/i.test( c.color ) ) {
				problems.push( `palette "${ c.slug }" colour "${ c.color }" is not a hex value` );
			}
		}
		for ( const f of data.settings?.typography?.fontFamilies ?? [] ) {
			for ( const face of f.fontFace ?? [] ) {
				for ( const src of face.src ?? [] ) {
					if ( ! src.startsWith( 'file:./' ) ) {
						problems.push( `font "${ f.slug }" src "${ src }" must be self-hosted (file:./…)` );
					}
				}
			}
		}
		if ( problems.length ) {
			failures++;
			console.error( `✖ ${ rel }:` );
			problems.forEach( ( p ) => console.error( `    - ${ p }` ) );
			continue;
		}
	}

	if ( rel.endsWith( '/block.json' ) && ! data.name?.startsWith( 'egi/' ) ) {
		failures++;
		console.error( `✖ ${ rel }: block name must be namespaced "egi/…"` );
		continue;
	}

	console.log( `✔ ${ rel }` );
}

if ( failures ) {
	console.error( `\n${ failures } file(s) failed validation.` );
	process.exit( 1 );
}
console.log( `\nAll ${ targets.length } JSON files are valid.` );
