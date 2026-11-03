/* =========================================================
   IBAN International - front-end behaviour
   Ported mechanisms: offcanvas nav, dropdown tap fallback, business carousel,
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
			hero.classList.add('has-advanced');
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

	var sectorShell = document.getElementById('ib-sector-carousel');
	var sectorTrack = document.getElementById('ib-sector-track');
	var sectorPrev = document.getElementById('ib-sector-prev');
	var sectorNext = document.getElementById('ib-sector-next');
	if (sectorShell && sectorTrack && sectorPrev && sectorNext) {
		var sectorCards = Array.prototype.slice.call(sectorTrack.children);
		var sectorIndex = 0;
		var sectorVisible = 0;
		var sectorTimer = null;
		var sectorMoving = false;
		var sectorPaused = reducedMotion;
		var sectorTouchX = null;
		var getSectorVisible = function () { return window.innerWidth < 640 ? 1 : (window.innerWidth < 1120 ? 2 : 3); };
		var sectorPosition = function () {
			var gap = parseFloat(window.getComputedStyle(sectorTrack).gap) || 0;
			sectorTrack.style.transform = 'translateX(' + (-(sectorCards[0].getBoundingClientRect().width + gap) * sectorIndex) + 'px)';
		};
		var stopSector = function () { if (sectorTimer) { window.clearInterval(sectorTimer); sectorTimer = null; } };
		var startSector = function () {
			if (sectorTimer || sectorPaused || document.hidden || sectorCards.length <= sectorVisible || sectorShell.matches(':hover') || sectorShell.contains(document.activeElement)) { return; }
			sectorTimer = window.setInterval(function () { moveSector(1); }, 6000);
		};
		var moveSector = function (direction) {
			if (sectorMoving || sectorCards.length <= sectorVisible) { return; }
			if (reducedMotion) {
				sectorIndex += direction;
				if (sectorIndex >= sectorCards.length + sectorVisible) { sectorIndex = sectorVisible; }
				if (sectorIndex < sectorVisible) { sectorIndex = sectorCards.length + sectorVisible - 1; }
				sectorPosition();
				return;
			}
			sectorMoving = true;
			sectorIndex += direction;
			sectorPosition();
		};
		var rebuildSector = function () {
			stopSector();
			Array.prototype.slice.call(sectorTrack.querySelectorAll('.ib-sector-clone')).forEach(function (clone) { clone.remove(); });
			sectorVisible = getSectorVisible();
			for (var i = sectorVisible - 1; i >= 0; i--) {
				var before = sectorCards[sectorCards.length - sectorVisible + i].cloneNode(true);
				before.classList.add('ib-sector-clone'); before.setAttribute('aria-hidden', 'true'); before.inert = true;
				sectorTrack.prepend(before);
			}
			for (var j = 0; j < sectorVisible; j++) {
				var after = sectorCards[j].cloneNode(true);
				after.classList.add('ib-sector-clone'); after.setAttribute('aria-hidden', 'true'); after.inert = true;
				sectorTrack.appendChild(after);
			}
			sectorIndex = sectorVisible;
			sectorMoving = false;
			sectorTrack.style.transition = 'none';
			sectorPosition();
			window.requestAnimationFrame(function () { sectorTrack.style.transition = ''; startSector(); });
		};
		sectorTrack.addEventListener('transitionend', function (event) {
			if (event.propertyName !== 'transform') { return; }
			if (sectorIndex >= sectorCards.length + sectorVisible) { sectorIndex = sectorVisible; }
			if (sectorIndex < sectorVisible) { sectorIndex = sectorCards.length + sectorVisible - 1; }
			sectorTrack.style.transition = 'none';
			sectorPosition();
			window.requestAnimationFrame(function () { sectorTrack.style.transition = ''; sectorMoving = false; });
		});
		sectorPrev.addEventListener('click', function () { moveSector(-1); });
		sectorNext.addEventListener('click', function () { moveSector(1); });
		sectorShell.addEventListener('mouseenter', stopSector);
		sectorShell.addEventListener('mouseleave', startSector);
		sectorShell.addEventListener('focusin', stopSector);
		sectorShell.addEventListener('focusout', function () { window.setTimeout(startSector, 0); });
		sectorShell.addEventListener('touchstart', function (event) { if (event.touches.length === 1) { sectorTouchX = event.touches[0].clientX; stopSector(); } }, { passive: true });
		sectorShell.addEventListener('touchend', function (event) {
			if (sectorTouchX !== null && event.changedTouches.length) {
				var dx = event.changedTouches[0].clientX - sectorTouchX;
				if (Math.abs(dx) > 55) { moveSector(dx < 0 ? 1 : -1); }
			}
			sectorTouchX = null;
			startSector();
		}, { passive: true });
		document.addEventListener('visibilitychange', function () { if (document.hidden) { stopSector(); } else { startSector(); } });
		window.addEventListener('resize', rebuildSector);
		if (sectorCards.length) { rebuildSector(); }
	}

	/* Animate sections when they enter view without hiding their content beforehand. */
	if (!reducedMotion && 'IntersectionObserver' in window) {
		var motionTargets = document.querySelectorAll('.ib-reveal, .ib-about-copy, .ib-why-copy, .ib-sectors-heading, .ib-audience .ib-head-center, .ib-intro-copy, .ib-sector-detail-copy, .ib-contact-cards');
		var motionObserver = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) { entry.target.classList.add('ib-entered'); motionObserver.unobserve(entry.target); }
			});
		}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
		Array.prototype.forEach.call(motionTargets, function (target) { motionObserver.observe(target); });
	}

	/* -------------------------------------------------------
	   Desktop dropdown touch handling and mobile drawer accordion
	   ------------------------------------------------------- */
	var menuItems = Array.prototype.slice.call(document.querySelectorAll('.menu-item-has-children'));
	var closeAll = function () {
		menuItems.forEach(function (li) {
			li.classList.remove('submenu-open');
			var link = li.querySelector(':scope > a');
			var toggle = li.querySelector(':scope > .ib-sub-toggle');
			if (link) { link.setAttribute('aria-expanded', 'false'); }
			if (toggle) {
				toggle.setAttribute('aria-expanded', 'false');
				toggle.setAttribute('aria-label', 'Show ' + link.textContent.trim() + ' submenu');
			}
		});
	};
	menuItems.forEach(function (li, index) {
		var link = li.querySelector(':scope > a');
		if (!link) { return; }
		if (li.closest('.ib-offcanvas')) {
			var submenu = li.querySelector(':scope > .sub-menu');
			if (!submenu) { return; }
			var label = link.textContent.trim();
			var toggle = document.createElement('button');
			submenu.id = submenu.id || 'ib-mobile-submenu-' + index;
			toggle.type = 'button';
			toggle.className = 'ib-sub-toggle';
			toggle.setAttribute('aria-controls', submenu.id);
			toggle.setAttribute('aria-expanded', 'false');
			toggle.setAttribute('aria-label', 'Show ' + label + ' submenu');
			link.setAttribute('aria-expanded', 'false');
			var setExpanded = function (open) {
				if (open) { closeAll(); }
				li.classList.toggle('submenu-open', open);
				link.setAttribute('aria-expanded', open ? 'true' : 'false');
				toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
				toggle.setAttribute('aria-label', (open ? 'Hide ' : 'Show ') + label + ' submenu');
			};
			toggle.addEventListener('click', function () { setExpanded(!li.classList.contains('submenu-open')); });
			link.addEventListener('click', function (e) {
				if (!li.classList.contains('submenu-open')) {
					e.preventDefault();
					setExpanded(true);
				}
			});
			li.insertBefore(toggle, submenu);
			return;
		}
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
		if (!open) { closeAll(); }
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
