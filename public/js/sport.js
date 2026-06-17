/* Sport-brand concept (/mockup) — Lenis + GSAP, with fail-safe CSS reveals. */
(function () {
    'use strict';
    var root = document.documentElement;
    var reduce = false;
    try { reduce = matchMedia('(prefers-reduced-motion: reduce)').matches; } catch (e) {}
    var hasGsap = !!(window.gsap && window.ScrollTrigger);
    var loader = document.getElementById('loader');

    function showAll() { root.classList.remove('is-animating'); if (loader) loader.style.display = 'none'; }

    /* ---- About: robot-mask reveal that follows the cursor (runs in all paths) ---- */
    (function () {
        var pf = document.getElementById('abPhoto'); if (!pf) return;
        var fine = true; try { fine = matchMedia('(hover:hover) and (pointer:fine)').matches; } catch (e) {}
        if (!fine) return;
        function move(e) {
            var r = pf.getBoundingClientRect();
            pf.style.setProperty('--mx', (e.clientX - r.left) + 'px');
            pf.style.setProperty('--my', (e.clientY - r.top) + 'px');
        }
        pf.addEventListener('pointerenter', function (e) { move(e); pf.classList.add('is-revealing'); });
        pf.addEventListener('pointermove', move);
        pf.addEventListener('pointerleave', function () { pf.classList.remove('is-revealing'); });
    })();

    /* ---- Reveal on scroll (robust; works with or without GSAP) ---- */
    function setupReveals() {
        var grids = ['.st', '.wk__grid', '.ex__wrap', '.ed__grid', '.ce__grid', '.cr__list'];
        grids.forEach(function (g) {
            var p = document.querySelector(g);
            if (!p) return;
            Array.prototype.forEach.call(p.children, function (c, i) { c.style.transitionDelay = (i % 4 * 0.06) + 's'; });
        });
        var items = document.querySelectorAll('.reveal,.ct__big');
        if (!('IntersectionObserver' in window)) { items.forEach(function (el) { el.classList.add('in'); }); return; }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (!en.isIntersecting) return;
                en.target.classList.add('in');
                io.unobserve(en.target);
                countUp(en.target);
            });
        }, { threshold: 0.16, rootMargin: '0px 0px -8% 0px' });
        items.forEach(function (el) { io.observe(el); });
    }
    function countUp(scope) {
        var el = scope.querySelector ? scope.querySelector('[data-count]') : null;
        if (scope.matches && scope.matches('[data-count]')) el = scope;
        if (!el || el.dataset.done) return;
        var m = (el.getAttribute('data-count') || '').match(/^(\d+)(.*)$/);
        if (!m) return;
        el.dataset.done = '1';
        var target = +m[1], suf = m[2], cur = 0, step = Math.max(1, Math.ceil(target / 26));
        var t = setInterval(function () { cur += step; if (cur >= target) { cur = target; clearInterval(t); } el.textContent = cur + suf; }, 34);
    }

    /* ---- Fallback: no GSAP / reduced motion ---- */
    if (!hasGsap || reduce) {
        showAll();
        setupReveals();
        var nav0 = document.getElementById('nav'), pr0 = document.getElementById('progress');
        addEventListener('scroll', function () {
            var y = scrollY, h = document.body.scrollHeight - innerHeight;
            if (nav0) nav0.classList.toggle('scrolled', y > 40);
            if (pr0) pr0.style.width = (h > 0 ? y / h * 100 : 0) + '%';
        }, { passive: true });
        return;
    }

    gsap.registerPlugin(ScrollTrigger);

    /* ---- Lenis smooth scroll ---- */
    var lenis = null;
    if (window.Lenis) {
        lenis = new Lenis({ lerp: 0.1, smoothWheel: true });
        lenis.on('scroll', ScrollTrigger.update);
        gsap.ticker.add(function (t) { lenis.raf(t * 1000); });
        gsap.ticker.lagSmoothing(0);
    }

    /* ---- Nav + progress ---- */
    var nav = document.getElementById('nav'), progress = document.getElementById('progress');
    function onScroll(s, lim) {
        if (nav) nav.classList.toggle('scrolled', s > 40);
        if (progress) progress.style.width = (lim > 0 ? s / lim * 100 : 0) + '%';
    }
    if (lenis) lenis.on('scroll', function (e) { onScroll(e.scroll, e.limit); });
    else addEventListener('scroll', function () { onScroll(scrollY, document.body.scrollHeight - innerHeight); }, { passive: true });

    /* ---- Anchor links via Lenis ---- */
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            var id = a.getAttribute('href'); if (id.length < 2) return;
            var t = document.querySelector(id); if (!t) return;
            e.preventDefault();
            if (lenis) lenis.scrollTo(t, { offset: -10 }); else t.scrollIntoView({ behavior: 'smooth' });
        });
    });

    /* ---- Custom cursor ---- */
    (function () {
        var fine = false; try { fine = matchMedia('(hover:hover) and (pointer:fine)').matches; } catch (e) {}
        var dot = document.getElementById('cursorDot'), ring = document.getElementById('cursorRing');
        if (!fine || !dot || !ring) return;
        document.body.classList.add('cursor-on');
        var mx = innerWidth / 2, my = innerHeight / 2, rx = mx, ry = my;
        addEventListener('mousemove', function (e) { mx = e.clientX; my = e.clientY; dot.style.opacity = ring.style.opacity = 1; }, { passive: true });
        gsap.ticker.add(function () {
            rx += (mx - rx) * 0.18; ry += (my - ry) * 0.18;
            dot.style.transform = 'translate(' + mx + 'px,' + my + 'px) translate(-50%,-50%)';
            ring.style.transform = 'translate(' + rx + 'px,' + ry + 'px) translate(-50%,-50%)';
        });
        document.querySelectorAll('[data-cur]').forEach(function (el) {
            var view = el.getAttribute('data-cur') === 'view';
            el.addEventListener('mouseenter', function () { ring.classList.add(view ? 'is-view' : 'is-hover'); });
            el.addEventListener('mouseleave', function () { ring.classList.remove('is-view', 'is-hover'); });
        });
    })();

    /* ---- Reveals (IO) ---- */
    setupReveals();

    /* ---- Hero entrance is pure CSS (keyed off html.is-animating) ---- */

    /* ---- Marquees ---- */
    gsap.utils.toArray('[data-marq]').forEach(function (el) {
        gsap.to(el, { xPercent: -50, repeat: -1, ease: 'none', duration: 26 });
    });

    /* ---- Big number parallax ---- */
    gsap.to('.hero__num', { yPercent: 18, ease: 'none', scrollTrigger: { trigger: '.hero', start: 'top top', end: 'bottom top', scrub: true } });

    /* ---- About: word-by-word fill ---- */
    (function () {
        var at = document.querySelector('[data-splitwords]'); if (!at) return;
        var words = at.textContent.trim().split(/\s+/);
        at.innerHTML = words.map(function (w) { return '<span class="w">' + w + '</span>'; }).join(' ');
        gsap.to(at.querySelectorAll('.w'), {
            opacity: 1, stagger: 1, ease: 'none',
            scrollTrigger: { trigger: at, start: 'top 80%', end: 'bottom 60%', scrub: 0.5 }
        });
    })();

    /* ---- Loader → reveal ---- */
    var lc = document.getElementById('loaderCount'), lb = document.getElementById('loaderBar'), o = { v: 0 };
    gsap.timeline()
        .to(o, { v: 100, duration: 1.2, ease: 'power2.inOut', onUpdate: function () { if (lc) lc.textContent = Math.round(o.v); } }, 0)
        .to(lb, { width: '100%', duration: 1.2, ease: 'power2.inOut' }, 0)
        .to(loader, { yPercent: -100, duration: 0.9, ease: 'power4.inOut', onComplete: function () { if (loader) loader.style.display = 'none'; ScrollTrigger.refresh(); } }, 1.3);

    addEventListener('load', function () { ScrollTrigger.refresh(); });

    /* ---- Fail-safe: never leave the contact headline hidden ---- */
    setTimeout(function () {
        var c = document.querySelector('.ct__big'); if (c) c.classList.add('in');
    }, 3500);
})();
