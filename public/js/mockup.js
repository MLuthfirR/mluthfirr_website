/* Redesign mockup — Lenis + GSAP scroll choreography, loader, cursor, marquee. */
(function () {
    'use strict';
    var root = document.documentElement;
    var reduce = false;
    try { reduce = matchMedia('(prefers-reduced-motion: reduce)').matches; } catch (e) {}
    var hasGsap = !!(window.gsap && window.ScrollTrigger);

    var loader = document.getElementById('loader');
    function showAll() {
        root.classList.remove('is-animating');
        if (loader) loader.style.display = 'none';
    }

    /* ---- Fallback: no GSAP or reduced motion → static, readable ---- */
    if (!hasGsap || reduce) {
        showAll();
        // minimal niceties without GSAP
        var navEl = document.getElementById('nav');
        var prog = document.getElementById('progress');
        addEventListener('scroll', function () {
            var y = scrollY, h = document.body.scrollHeight - innerHeight;
            if (navEl) navEl.classList.toggle('scrolled', y > 40);
            if (prog) prog.style.width = (h > 0 ? y / h * 100 : 0) + '%';
        }, { passive: true });
        return;
    }

    gsap.registerPlugin(ScrollTrigger);

    /* ---- Smooth scroll (Lenis) wired into GSAP/ScrollTrigger ---- */
    var lenis = null;
    if (window.Lenis) {
        lenis = new Lenis({ lerp: 0.1, smoothWheel: true, wheelMultiplier: 1 });
        lenis.on('scroll', ScrollTrigger.update);
        gsap.ticker.add(function (t) { lenis.raf(t * 1000); });
        gsap.ticker.lagSmoothing(0);
    }

    /* ---- Nav + scroll progress ---- */
    var nav = document.getElementById('nav');
    var progress = document.getElementById('progress');
    function onScroll(scroll, limit) {
        if (nav) nav.classList.toggle('scrolled', scroll > 40);
        if (progress) progress.style.width = (limit > 0 ? scroll / limit * 100 : 0) + '%';
    }
    if (lenis) { lenis.on('scroll', function (e) { onScroll(e.scroll, e.limit); }); }
    else { addEventListener('scroll', function () { onScroll(scrollY, document.body.scrollHeight - innerHeight); }, { passive: true }); }

    /* ---- Anchor links through Lenis ---- */
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            var id = a.getAttribute('href');
            if (id.length < 2) return;
            var t = document.querySelector(id);
            if (!t) return;
            e.preventDefault();
            if (lenis) lenis.scrollTo(t, { offset: -10 }); else t.scrollIntoView({ behavior: 'smooth' });
        });
    });

    /* ---- Custom cursor (fine pointers only) ---- */
    (function cursor() {
        var fine = false;
        try { fine = matchMedia('(hover:hover) and (pointer:fine)').matches; } catch (e) {}
        var dot = document.getElementById('cursorDot'), ring = document.getElementById('cursorRing');
        if (!fine || !dot || !ring) return;
        document.body.classList.add('cursor-on');
        var mx = innerWidth / 2, my = innerHeight / 2, rx = mx, ry = my;
        addEventListener('mousemove', function (e) {
            mx = e.clientX; my = e.clientY; dot.style.opacity = ring.style.opacity = 1;
        }, { passive: true });
        gsap.ticker.add(function () {
            rx += (mx - rx) * 0.18; ry += (my - ry) * 0.18;
            dot.style.transform = 'translate(' + mx + 'px,' + my + 'px) translate(-50%,-50%)';
            ring.style.transform = 'translate(' + rx + 'px,' + ry + 'px) translate(-50%,-50%)';
        });
        document.querySelectorAll('[data-cursor]').forEach(function (el) {
            var view = el.getAttribute('data-cursor') === 'view';
            el.addEventListener('mouseenter', function () { ring.classList.add(view ? 'is-view' : 'is-hover'); });
            el.addEventListener('mouseleave', function () { ring.classList.remove('is-view', 'is-hover'); });
        });
    })();

    /* ---- Hero initial states (explicit, so dropping is-animating won't flash) ---- */
    gsap.set('.hero__name .line__in', { yPercent: 110 });
    gsap.set('.hero__photo img', { scale: 1.25 });
    gsap.set(['.hero__lead', '.hero__cta'], { opacity: 0, y: 26 });

    /* ---- Reveals on scroll ---- */
    function reveal(sel, vars) {
        gsap.utils.toArray(sel).forEach(function (el) {
            gsap.from(el, Object.assign({
                opacity: 0, y: 44, duration: 0.95, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 86%' }
            }, vars || {}));
        });
    }
    reveal('.reveal');
    reveal('.stat', { y: 60, stagger: 0.08 });
    reveal('.work__item', { y: 30 });
    reveal('.skill', { y: 30 });
    reveal('.edu__card', { y: 40 });

    /* ---- About: word-by-word highlight on scroll ---- */
    (function aboutWords() {
        var at = document.querySelector('.about__text');
        if (!at) return;
        var words = at.textContent.trim().split(/\s+/);
        at.innerHTML = words.map(function (w) { return '<span class="w">' + w + '</span>'; }).join(' ');
        gsap.set(at, { opacity: 1 });
        gsap.to(at.querySelectorAll('.w'), {
            color: '#f4f4f7', stagger: 1, ease: 'none',
            scrollTrigger: { trigger: at, start: 'top 78%', end: 'bottom 62%', scrub: 0.5 }
        });
    })();

    /* ---- Count-up stats ---- */
    gsap.utils.toArray('[data-count]').forEach(function (el) {
        var m = (el.getAttribute('data-count') || '').match(/^(\d+)(.*)$/);
        if (!m) return;
        var target = +m[1], suf = m[2], o = { v: 0 };
        ScrollTrigger.create({
            trigger: el, start: 'top 88%', once: true,
            onEnter: function () {
                gsap.to(o, { v: target, duration: 1.5, ease: 'power2.out', onUpdate: function () { el.textContent = Math.round(o.v) + suf; } });
            }
        });
    });

    /* ---- Marquees (seamless: markup is duplicated) ---- */
    gsap.utils.toArray('[data-marq]').forEach(function (el, i) {
        gsap.to(el, { xPercent: -50, repeat: -1, ease: 'none', duration: i === 0 ? 34 : 24 });
    });

    /* ---- Parallax background glows ---- */
    gsap.to('.bg__glow--1', { yPercent: 26, ease: 'none', scrollTrigger: { start: 0, end: 'max', scrub: true } });
    gsap.to('.bg__glow--2', { yPercent: -22, ease: 'none', scrollTrigger: { start: 0, end: 'max', scrub: true } });

    /* ---- Portfolio horizontal scroll (desktop) ---- */
    (function horizontal() {
        var pin = document.getElementById('pfPin'), track = document.getElementById('pfTrack');
        if (!pin || !track || innerWidth <= 760) return;
        var getX = function () { return -(track.scrollWidth - document.documentElement.clientWidth + 64); };
        gsap.to(track, {
            x: getX, ease: 'none',
            scrollTrigger: {
                trigger: pin, start: 'top top', pin: true, scrub: 1, invalidateOnRefresh: true,
                end: function () { return '+=' + (track.scrollWidth - innerWidth + 240); }
            }
        });
    })();

    /* ---- Loader → hero entrance ---- */
    var heroTl = gsap.timeline({ paused: true });
    heroTl.to('.hero__name .line__in', { yPercent: 0, duration: 1.05, ease: 'power4.out', stagger: 0.12 })
        .to('.hero__photo img', { scale: 1, duration: 1.5, ease: 'power3.out' }, 0)
        .to(['.hero__lead', '.hero__cta'], { opacity: 1, y: 0, duration: 0.85, ease: 'power2.out', stagger: 0.12 }, 0.5);

    root.classList.remove('is-animating'); // GSAP now owns initial states (set above)

    var lc = document.getElementById('loaderCount'), lb = document.getElementById('loaderBar'), o = { v: 0 };
    var loadTl = gsap.timeline();
    loadTl.to(o, { v: 100, duration: 1.25, ease: 'power2.inOut', onUpdate: function () { if (lc) lc.textContent = Math.round(o.v); } }, 0)
        .to(lb, { width: '100%', duration: 1.25, ease: 'power2.inOut' }, 0)
        .to(loader, {
            yPercent: -100, duration: 0.9, ease: 'power4.inOut',
            onComplete: function () { if (loader) loader.style.display = 'none'; ScrollTrigger.refresh(); }
        }, 1.35)
        .add(function () { heroTl.play(0); }, 1.55);

    /* keep pinned layout correct after images/fonts settle */
    addEventListener('load', function () { ScrollTrigger.refresh(); });
})();
