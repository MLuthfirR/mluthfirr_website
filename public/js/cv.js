/* CV interactions — theme, reveal, nav, count-up, scroll progress,
   hero stagger, mouse parallax, 3D tilt, particle network. */
(function () {
    'use strict';

    var root = document.documentElement;
    var RM = false;
    try { RM = window.matchMedia('(prefers-reduced-motion: reduce)').matches; } catch (e) {}

    /* ---- Theme ---- */
    var toggle = document.getElementById('themeToggle');
    var stored = null;
    try { stored = localStorage.getItem('theme'); } catch (e) {}
    if (stored) root.setAttribute('data-theme', stored);
    if (toggle) {
        toggle.addEventListener('click', function () {
            var next = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
            root.setAttribute('data-theme', next);
            try { localStorage.setItem('theme', next); } catch (e) {}
        });
    }

    /* ---- Nav scrolled state, back-to-top, scroll progress ---- */
    var nav = document.getElementById('nav');
    var toTop = document.getElementById('toTop');
    var prog = document.getElementById('scrollProgress');
    function onScroll() {
        var y = window.scrollY || window.pageYOffset;
        if (nav) nav.classList.toggle('scrolled', y > 24);
        if (toTop) toTop.classList.toggle('show', y > 600);
        if (prog) {
            var sh = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            prog.style.width = (sh > 0 ? (y / sh) * 100 : 0) + '%';
        }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* ---- Mobile menu ---- */
    var burger = document.getElementById('burger');
    if (burger && nav) {
        burger.addEventListener('click', function () { nav.classList.toggle('open'); });
        nav.querySelectorAll('.nav__links a').forEach(function (a) {
            a.addEventListener('click', function () { nav.classList.remove('open'); });
        });
    }

    /* ---- Hero entrance stagger ---- */
    document.querySelectorAll('.hero-in').forEach(function (el, i) {
        el.style.animationDelay = (i * 0.09) + 's';
    });

    /* ---- Reveal on scroll ---- */
    var reveals = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
        reveals.forEach(function (el, i) {
            el.style.transitionDelay = (Math.min(i % 6, 5) * 60) + 'ms';
            io.observe(el);
        });
    } else {
        reveals.forEach(function (el) { el.classList.add('in'); });
    }

    /* ---- Active section in nav ---- */
    var links = Array.prototype.slice.call(document.querySelectorAll('.nav__links a'));
    var sections = links.map(function (l) { return document.querySelector(l.getAttribute('href')); });
    if ('IntersectionObserver' in window) {
        var spy = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) {
                    var id = '#' + en.target.id;
                    links.forEach(function (l) { l.classList.toggle('active', l.getAttribute('href') === id); });
                }
            });
        }, { rootMargin: '-45% 0px -50% 0px' });
        sections.forEach(function (s) { if (s) spy.observe(s); });
    }

    /* ---- Count-up for numeric stats ---- */
    function animateCount(el) {
        var raw = el.getAttribute('data-count') || el.textContent;
        var m = raw.match(/^(\d+)(.*)$/);
        if (!m) return;
        var target = parseInt(m[1], 10), suffix = m[2], cur = 0;
        var step = Math.max(1, Math.ceil(target / 28));
        var t = setInterval(function () {
            cur += step;
            if (cur >= target) { cur = target; clearInterval(t); }
            el.textContent = cur + suffix;
        }, 32);
    }
    var counted = false;
    var statWrap = document.querySelector('.stats');
    if (statWrap && 'IntersectionObserver' in window) {
        new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (en) {
                if (en.isIntersecting && !counted) {
                    counted = true;
                    document.querySelectorAll('.stat__value').forEach(animateCount);
                    obs.disconnect();
                }
            });
        }, { threshold: 0.4 }).observe(statWrap);
    }

    /* ===== Motion flourishes (skipped when reduced-motion) ===== */
    if (RM) return;

    /* ---- Mouse parallax on the aurora background ---- */
    var aurora = document.querySelector('.bg-aurora');
    if (aurora) {
        var mx = 0, my = 0, queued = false;
        function apply() { aurora.style.transform = 'translate3d(' + mx + 'px,' + my + 'px,0)'; queued = false; }
        window.addEventListener('mousemove', function (e) {
            mx = (e.clientX / window.innerWidth - 0.5) * 18;
            my = (e.clientY / window.innerHeight - 0.5) * 18;
            if (!queued) { queued = true; requestAnimationFrame(apply); }
        }, { passive: true });
    }

    /* ---- 3D tilt on [data-tilt] ---- */
    document.querySelectorAll('[data-tilt]').forEach(function (el) {
        var MAX = 8;
        el.addEventListener('mousemove', function (e) {
            var r = el.getBoundingClientRect();
            var px = (e.clientX - r.left) / r.width - 0.5;
            var py = (e.clientY - r.top) / r.height - 0.5;
            el.style.transition = 'transform .08s ease-out';
            el.style.transform = 'perspective(1000px) rotateY(' + (px * MAX) + 'deg) rotateX(' + (-py * MAX) +
                'deg) translateY(-6px)';
        });
        el.addEventListener('mouseleave', function () {
            el.style.transition = '';
            el.style.transform = '';
        });
    });

    /* ---- Particle network in the background ---- */
    var canvas = document.getElementById('particles');
    if (canvas && canvas.getContext) {
        var ctx = canvas.getContext('2d');
        var w, h, dpr, pts, raf;
        function size() {
            dpr = Math.min(window.devicePixelRatio || 1, 2);
            w = canvas.clientWidth; h = canvas.clientHeight;
            canvas.width = w * dpr; canvas.height = h * dpr;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        }
        function make() {
            var n = Math.max(28, Math.min(72, Math.floor(w * h / 17000)));
            pts = [];
            for (var i = 0; i < n; i++) {
                pts.push({ x: Math.random() * w, y: Math.random() * h, vx: (Math.random() - 0.5) * 0.32, vy: (Math.random() - 0.5) * 0.32 });
            }
        }
        function rgb() { return root.getAttribute('data-theme') === 'light' ? '90,70,200' : '150,140,250'; }
        function tick() {
            var col = rgb();
            ctx.clearRect(0, 0, w, h);
            var i, j;
            for (i = 0; i < pts.length; i++) {
                var p = pts[i];
                p.x += p.vx; p.y += p.vy;
                if (p.x < 0 || p.x > w) p.vx *= -1;
                if (p.y < 0 || p.y > h) p.vy *= -1;
                ctx.beginPath(); ctx.arc(p.x, p.y, 1.5, 0, 6.2832);
                ctx.fillStyle = 'rgba(' + col + ',.75)'; ctx.fill();
            }
            for (i = 0; i < pts.length; i++) {
                for (j = i + 1; j < pts.length; j++) {
                    var a = pts[i], b = pts[j], dx = a.x - b.x, dy = a.y - b.y, d = dx * dx + dy * dy;
                    if (d < 15000) {
                        ctx.beginPath(); ctx.moveTo(a.x, a.y); ctx.lineTo(b.x, b.y);
                        ctx.strokeStyle = 'rgba(' + col + ',' + (0.18 * (1 - d / 15000)) + ')';
                        ctx.lineWidth = 1; ctx.stroke();
                    }
                }
            }
            raf = requestAnimationFrame(tick);
        }
        size(); make(); tick();
        var rt;
        window.addEventListener('resize', function () {
            clearTimeout(rt); rt = setTimeout(function () { size(); make(); }, 200);
        }, { passive: true });
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) { cancelAnimationFrame(raf); }
            else { raf = requestAnimationFrame(tick); }
        });
    }
})();
