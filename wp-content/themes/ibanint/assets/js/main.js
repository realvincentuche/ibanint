/* =========================================================
   Iban International - front-end behaviour
   Ported mechanisms: hero slider with autoplay + dots,
   offcanvas nav, dropdown tap fallback, reveal-on-scroll,
   audience carousel, back-to-top, sticky header shadow.
   ========================================================= */
(function () {
	'use strict';

	var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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
	   Hero slider
	   ------------------------------------------------------- */
	var hero = document.getElementById('ib-hero');
	if (hero) {
		var slides = Array.prototype.slice.call(hero.querySelectorAll('.ib-slide'));
		var dotsWrap = document.getElementById('ib-hero-dots');
		var prev = document.getElementById('ib-hero-prev');
		var next = document.getElementById('ib-hero-next');
		var current = Math.max(0, slides.findIndex(function (s) { return s.classList.contains('active'); }));
		var timer = null;
		var DELAY = 9000;

		var dots = [];
		if (dotsWrap) {
			slides.forEach(function (_, i) {
				var b = document.createElement('button');
				b.type = 'button';
				b.className = 'ib-dot' + (i === current ? ' active' : '');
				b.setAttribute('aria-label', 'Go to slide ' + (i + 1));
				b.addEventListener('click', function () { go(i); });
				dotsWrap.appendChild(b);
				dots.push(b);
			});
		}

		var go = function (index) {
			if (!slides[index]) { return; }
			slides[current].classList.remove('active');
			if (dots[current]) { dots[current].classList.remove('active'); }
			current = (index + slides.length) % slides.length;
			slides[current].classList.add('active');
			if (dots[current]) { dots[current].classList.add('active'); }
			restart();
		};

		var restart = function () {
			if (timer) { window.clearInterval(timer); }
			if (!reducedMotion && slides.length > 1) {
				timer = window.setInterval(function () { go(current + 1); }, DELAY);
			}
		};

		if (prev) { prev.addEventListener('click', function () { go(current - 1); }); }
		if (next) { next.addEventListener('click', function () { go(current + 1); }); }

		['mouseenter', 'focusin', 'touchstart'].forEach(function (evt) {
			hero.addEventListener(evt, function () {
				if (timer) { window.clearInterval(timer); timer = null; }
			}, { passive: true });
		});
		['mouseleave', 'focusout'].forEach(function (evt) {
			hero.addEventListener(evt, restart);
		});
		if (document.visibilityState) {
			document.addEventListener('visibilitychange', function () {
				if (document.visibilityState === 'visible') { restart(); }
				else if (timer) { window.clearInterval(timer); timer = null; }
			});
		}

		/* Keyboard arrows over the hero region */
		hero.setAttribute('tabindex', '0');
		hero.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowRight') { go(current + 1); }
			if (e.key === 'ArrowLeft') { go(current - 1); }
		});

		restart();
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

		if (dotsWrap) {
			cards.forEach(function (_, i) {
				var b = document.createElement('button');
				b.type = 'button';
				b.className = 'ib-dot' + (i === 0 ? ' active' : '');
				b.setAttribute('aria-label', 'Show group ' + (Math.floor(i / perView()) + 1));
				b.addEventListener('click', function () { go(i); });
				dotsWrap.appendChild(b);
				dots.push(b);
			});
		}

		var go = function (i) {
			var per = perView();
			var maxIndex = Math.max(0, cards.length - per);
			index = i < 0 ? maxIndex : (i > maxIndex ? 0 : i);
			track.style.transform = 'translateX(' + (-(100 / per) * index) + '%)';
			dots.forEach(function (d, di) {
				d.classList.toggle('active', Math.floor(di / per) === Math.floor(index / per));
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

		window.addEventListener('resize', function () { go(index); });

		go(0);
		start();
	};

	buildCarousel('ib-audience-carousel', 'ib-audience-track', 'ib-audience-dots', 3);

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
	   Reveal on scroll
	   ------------------------------------------------------- */
	if ('IntersectionObserver' in window && !reducedMotion) {
		document.documentElement.classList.add('ib-js');
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('ib-revealed');
					io.unobserve(entry.target);
				}
			});
		}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

		Array.prototype.slice.call(document.querySelectorAll('.ib-reveal')).forEach(function (el) {
			io.observe(el);
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
