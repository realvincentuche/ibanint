/* =========================================================
   Iban International - front-end behaviour
   Ported mechanisms: offcanvas nav, dropdown tap fallback, audience carousel,
   back-to-top, sticky header shadow.
   ========================================================= */
(function () {
	'use strict';

	var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* Hero slider: buttons, dots, keyboard and horizontal touch swipe. */
	var hero = document.getElementById('ib-hero');
	if (hero) {
		var slides = Array.prototype.slice.call(hero.querySelectorAll('.ib-hero-slide'));
		var prev = document.getElementById('ib-hero-prev');
		var next = document.getElementById('ib-hero-next');
		var pause = document.getElementById('ib-hero-pause');
		var active = 0;
		var paused = reducedMotion;
		var timer = null;
		var touchStart = null;
		var showSlide = function (index) {
			active = (index + slides.length) % slides.length;
			slides.forEach(function (slide, i) {
				var selected = i === active;
				slide.classList.toggle('is-active', selected);
				slide.setAttribute('aria-hidden', selected ? 'false' : 'true');
				slide.inert = !selected;
			});
		};
		var stopHero = function () { if (timer) { window.clearInterval(timer); timer = null; } };
		var startHero = function () {
			if (timer || paused || document.hidden || slides.length < 2) { return; }
			timer = window.setInterval(function () { showSlide(active + 1); }, 8000);
		};
		var changeSlide = function (index) { showSlide(index); stopHero(); startHero(); };
		if (prev) { prev.addEventListener('click', function () { changeSlide(active - 1); }); }
		if (next) { next.addEventListener('click', function () { changeSlide(active + 1); }); }
		if (pause) {
			pause.addEventListener('click', function () {
				paused = !paused;
				pause.setAttribute('aria-label', paused ? 'Play slides' : 'Pause slides');
				pause.querySelector('i').className = paused ? 'ph ph-play' : 'ph ph-pause';
				if (paused) { stopHero(); } else { startHero(); }
			});
			if (paused) { pause.setAttribute('aria-label', 'Play slides'); pause.querySelector('i').className = 'ph ph-play'; }
		}
		hero.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
				event.preventDefault();
				changeSlide(active + (event.key === 'ArrowRight' ? 1 : -1));
			}
		});
		hero.addEventListener('touchstart', function (event) {
			if (event.touches.length === 1) { touchStart = { x: event.touches[0].clientX, y: event.touches[0].clientY }; }
		}, { passive: true });
		hero.addEventListener('touchend', function (event) {
			if (!touchStart || !event.changedTouches.length) { return; }
			var dx = event.changedTouches[0].clientX - touchStart.x;
			var dy = event.changedTouches[0].clientY - touchStart.y;
			if (Math.abs(dx) > 55 && Math.abs(dx) > Math.abs(dy) * 1.25) { changeSlide(active + (dx < 0 ? 1 : -1)); }
			touchStart = null;
		}, { passive: true });
		hero.addEventListener('mouseenter', stopHero);
		hero.addEventListener('mouseleave', startHero);
		hero.addEventListener('focusin', stopHero);
		hero.addEventListener('focusout', function () { window.setTimeout(function () { if (!hero.contains(document.activeElement)) { startHero(); } }, 0); });
		document.addEventListener('visibilitychange', function () { if (document.hidden) { stopHero(); } else { startHero(); } });
		startHero();
	}

	/* -------------------------------------------------------
	   Sticky header shadow
	   ------------------------------------------------------- */
	var header = document.getElementById('ib-header');
	if (header) {
		var onScrollHeader = function () {
			if (window.scrollY > 10) {
				header.classList.add('ib-scrolled');
			} else {
				header.classList.remove('ib-scrolled');
			}
		};
		window.addEventListener('scroll', onScrollHeader, { passive: true });
		onScrollHeader();
	}

	/* -------------------------------------------------------
	   Audience carousel  (port of the industries mechanism)
	   ------------------------------------------------------- */
	var buildCarousel = function (rootId, trackId, dotsId, perViewLg) {
		var root = document.getElementById(rootId);
		var track = document.getElementById(trackId);
		var dotsWrap = document.getElementById(dotsId);
		if (!root || !track) { return; }

		var cards = Array.prototype.slice.call(track.children);
		if (!cards.length) { return; }

		var perView = function () {
			var w = window.innerWidth;
			if (w < 640) { return 1; }
			if (w < 1120) { return 2; }
			return perViewLg;
		};

		var index = 0;
		var dots = [];
		var buildDots = function () {
			if (!dotsWrap) { return; }
			dotsWrap.innerHTML = '';
			dots = [];
			var positions = Math.max(1, cards.length - perView() + 1);
			for (var i = 0; i < positions; i++) {
				var b = document.createElement('button');
				b.type = 'button';
				b.className = 'ib-dot';
				b.setAttribute('aria-label', 'Show group ' + (i + 1));
				b.addEventListener('click', (function (position) { return function () { go(position); }; }(i)));
				dotsWrap.appendChild(b);
				dots.push(b);
			}
		};

		var go = function (i) {
			var per = perView();
			var maxIndex = Math.max(0, cards.length - per);
			index = i < 0 ? maxIndex : (i > maxIndex ? 0 : i);
			var gap = parseFloat(window.getComputedStyle(track).gap) || 0;
			track.style.transform = 'translateX(' + (-(cards[0].getBoundingClientRect().width + gap) * index) + 'px)';
			dots.forEach(function (d, di) {
				d.classList.toggle('active', di === index);
				d.setAttribute('aria-current', di === index ? 'true' : 'false');
			});
		};

		var timer = null;
		var start = function () {
			if (timer || reducedMotion || cards.length <= perView()) { return; }
			timer = window.setInterval(function () { go(index + 1); }, 7000);
		};
		var stop = function () {
			if (timer) { window.clearInterval(timer); timer = null; }
		};

		root.addEventListener('mouseenter', stop);
		root.addEventListener('mouseleave', start);
		root.addEventListener('focusin', stop);
		root.addEventListener('focusout', start);
		root.addEventListener('touchstart', stop, { passive: true });

		window.addEventListener('resize', function () { buildDots(); go(Math.min(index, Math.max(0, cards.length - perView()))); });

		buildDots();
		go(0);
		start();
	};

	buildCarousel('ib-audience-carousel', 'ib-audience-track', 'ib-audience-dots', 3);

	var sectorTrack = document.getElementById('ib-sector-track');
	var sectorNext = document.getElementById('ib-sector-next');
	if (sectorTrack && sectorNext && sectorTrack.children.length) {
		var sectorIndex = 0;
		var sectorCards = Array.prototype.slice.call(sectorTrack.children);
		var moveSector = function () {
			var visible = window.innerWidth < 640 ? 1 : (window.innerWidth < 1120 ? 2 : 3);
			var max = Math.max(0, sectorCards.length - visible);
			sectorIndex = sectorIndex >= max ? 0 : sectorIndex + 1;
			var gap = parseFloat(window.getComputedStyle(sectorTrack).gap) || 0;
			sectorTrack.style.transform = 'translateX(' + (-(sectorCards[0].getBoundingClientRect().width + gap) * sectorIndex) + 'px)';
		};
		sectorNext.addEventListener('click', moveSector);
		window.addEventListener('resize', function () { sectorIndex = 0; sectorTrack.style.transform = 'translateX(0)'; });
	}

	/* -------------------------------------------------------
	   Dropdown tap fallback (touch + Escape + click-outside)
	   ------------------------------------------------------- */
	var menuItems = Array.prototype.slice.call(document.querySelectorAll('.menu-item-has-children'));
	var closeAll = function () {
		menuItems.forEach(function (li) { li.classList.remove('submenu-open'); });
	};
	menuItems.forEach(function (li) {
		var link = li.querySelector(':scope > a');
		if (!link) { return; }
		link.addEventListener('click', function (e) {
			/* First tap opens the dropdown on touch/small screens */
			if (window.innerWidth <= 920 && !li.classList.contains('submenu-open')) {
				e.preventDefault();
				closeAll();
				li.classList.add('submenu-open');
			}
		});
	});
	document.addEventListener('click', function (e) {
		if (!e.target.closest('.menu-item-has-children')) { closeAll(); }
	});
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') { closeAll(); }
	});

	/* -------------------------------------------------------
	   Offcanvas
	   ------------------------------------------------------- */
	var burger = document.getElementById('ib-burger');
	var offcanvas = document.getElementById('ib-offcanvas');
	var closeBtn = document.getElementById('ib-offcanvas-close');
	var scrim = document.getElementById('ib-scrim');

	var setOffcanvas = function (open) {
		document.body.classList.toggle('ib-offcanvas-open', open);
		document.body.classList.toggle('ib-lock', open);
		if (scrim) { scrim.hidden = false; }
		if (offcanvas) { offcanvas.setAttribute('aria-hidden', open ? 'false' : 'true'); }
		if (burger) { burger.setAttribute('aria-expanded', open ? 'true' : 'false'); }
		if (!open && scrim) { scrim.hidden = true; }
	};

	if (burger && offcanvas) {
		burger.addEventListener('click', function () { setOffcanvas(true); });
		if (closeBtn) { closeBtn.addEventListener('click', function () { setOffcanvas(false); }); }
		if (scrim) {
			scrim.addEventListener('click', function () { setOffcanvas(false); });
			scrim.hidden = false;
			setOffcanvas(false);
		}
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && document.body.classList.contains('ib-offcanvas-open')) { setOffcanvas(false); }
		});
	}

	/* -------------------------------------------------------
	   Back to top
	   ------------------------------------------------------- */
	var totop = document.getElementById('ib-totop');
	if (totop) {
		var onScrollTotop = function () {
			totop.classList.toggle('ib-visible', window.scrollY > 600);
		};
		window.addEventListener('scroll', onScrollTotop, { passive: true });
		onScrollTotop();
		totop.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: reducedMotion ? 'auto' : 'smooth' });
		});
	}
}());
