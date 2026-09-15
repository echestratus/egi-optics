#!/usr/bin/env node
/**
 * Full-page screenshots for visual QA (desktop 1440px and mobile 390px).
 * Scrolls through the page first so scroll-reveal sections are visible.
 *
 * Usage: node scripts/dev/screenshot.mjs <url> <out-prefix> [desktop|mobile|both]
 *   e.g. node scripts/dev/screenshot.mjs http://localhost:8888/ /tmp/qa/home both
 */
import { chromium, devices } from 'playwright';

const [ , , url, prefix, mode = 'both' ] = process.argv;
if ( ! url || ! prefix ) {
	console.error( 'Usage: node scripts/dev/screenshot.mjs <url> <out-prefix> [desktop|mobile|both]' );
	process.exit( 1 );
}

const targets = [];
if ( mode === 'desktop' || mode === 'both' ) {
	targets.push( { name: 'desktop', options: { viewport: { width: 1440, height: 900 }, deviceScaleFactor: 1 } } );
}
if ( mode === 'mobile' || mode === 'both' ) {
	targets.push( { name: 'mobile', options: { ...devices[ 'iPhone 13' ], viewport: { width: 390, height: 844 }, deviceScaleFactor: 1 } } );
}

const browser = await chromium.launch();
for ( const target of targets ) {
	const context = await browser.newContext( target.options );
	const page = await context.newPage();
	await page.goto( url, { waitUntil: 'networkidle' } );

	// Scroll through the page to trigger IntersectionObserver reveals and lazy images.
	await page.evaluate( async () => {
		const step = Math.max( 300, Math.floor( window.innerHeight * 0.7 ) );
		for ( let y = 0; y < document.documentElement.scrollHeight; y += step ) {
			window.scrollTo( 0, y );
			await new Promise( ( r ) => setTimeout( r, 120 ) );
		}
		window.scrollTo( 0, 0 );
		// Let the theme's reveal safety-net (4 s) fire so nothing is captured mid-animation.
		await new Promise( ( r ) => setTimeout( r, 4600 ) );
	} );

	const out = `${ prefix }-${ target.name }.png`;
	await page.screenshot( { path: out, fullPage: true } );
	const size = await page.evaluate( () => [ document.documentElement.scrollWidth, document.documentElement.scrollHeight ] );
	console.log( `✔ ${ out } (${ size[ 0 ] }x${ size[ 1 ] })` );
	await context.close();
}
await browser.close();
