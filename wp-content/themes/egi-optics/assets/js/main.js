/**
 * EGI Optics theme - progressive enhancements.
 *
 * Everything here is optional: the site is fully usable without JavaScript.
 * 1. Scroll-reveal for elements with .egi-reveal / .egi-reveal-stagger
 * 2. Header state after scrolling
 * 3. Pause videos that scroll out of view
 * 4. Auto-fill "Product" subject when a CTA links to the contact form with ?product=
 */
( function () {
	'use strict';

	const reduceMotion =
		window.matchMedia &&
		window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* 1. Scroll reveal ------------------------------------------------- */
	const revealTargets = document.querySelectorAll(
		'.egi-reveal, .egi-reveal-stagger'
	);

	if ( revealTargets.length ) {
		if ( reduceMotion || ! ( 'IntersectionObserver' in window ) ) {
			revealTargets.forEach( ( el ) => el.classList.add( 'is-visible' ) );
		} else {
			const io = new IntersectionObserver(
				( entries, observer ) => {
					entries.forEach( ( entry ) => {
						if ( entry.isIntersecting ) {
							entry.target.classList.add( 'is-visible' );
							observer.unobserve( entry.target );
						}
					} );
				},
				{ rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
			);
			revealTargets.forEach( ( el ) => io.observe( el ) );
		}
	}

	/* 2. Header state ---------------------------------------------------- */
	const header = document.querySelector( '.egi-header' );
	if ( header ) {
		let ticking = false;
		const update = () => {
			header.classList.toggle( 'is-scrolled', window.scrollY > 24 );
			ticking = false;
		};
		window.addEventListener(
			'scroll',
			() => {
				if ( ! ticking ) {
					window.requestAnimationFrame( update );
					ticking = true;
				}
			},
			{ passive: true }
		);
		update();
	}

	/* 3. Pause off-screen videos ---------------------------------------- */
	const videos = document.querySelectorAll( '.egi-video video' );
	if ( videos.length && 'IntersectionObserver' in window ) {
		const vio = new IntersectionObserver(
			( entries ) => {
				entries.forEach( ( entry ) => {
					const video = entry.target;
					if ( ! entry.isIntersecting && ! video.paused ) {
						video.pause();
					}
				} );
			},
			{ threshold: 0.2 }
		);
		videos.forEach( ( v ) => vio.observe( v ) );
	}

	/* 4. Contact form pre-fill ------------------------------------------- */
	const params = new URLSearchParams( window.location.search );
	const product = params.get( 'product' );
	if ( product ) {
		const field = document.querySelector(
			'.egi-form-wrap textarea, .egi-form-wrap [name*="message" i]'
		);
		if ( field && ! field.value ) {
			field.value = 'I would like more information about: ' + product;
		}
	}
} )();
