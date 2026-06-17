@php
    $nameWords = preg_split('/\s+/', trim($p['name']));
    $kw = ['Artificial Intelligence','IoT','Logistics','Fullstack','Robotics','Research','Strategy','Leadership'];
    $aboutParts = preg_split('/(?<=\.)\s+/', trim($p['about']), 2);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <script>try{if(!matchMedia('(prefers-reduced-motion: reduce)').matches)document.documentElement.classList.add('is-animating');}catch(e){}</script>
    <script>try{if(localStorage.getItem('mk-theme')==='light')document.documentElement.classList.add('light');}catch(e){}</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $p['name'] }} · {{ $p['role'] }}</title>
    <meta name="description" content="{{ $p['tagline'] }}">
    <meta name="theme-color" content="#08080b">
    <meta property="og:title" content="{{ $p['name'] }} — {{ $p['role'] }}">
    <meta property="og:description" content="{{ $p['tagline'] }}">
    <meta property="og:image" content="{{ asset('img/hero.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mark-64.png') }}">
    <link rel="stylesheet" href="{{ asset('css/mockup.css') }}?v={{ @filemtime(public_path('css/mockup.css')) ?: '1' }}">
</head>
<body>

{{-- ===== Loader ===== --}}
<div class="loader" id="loader">
    <div class="loader__inner">
        <img class="loader__logo" src="{{ asset('img/logo-mark.png') }}" alt="">
        <span class="loader__count" id="loaderCount">0</span>
    </div>
    <div class="loader__bar"><span id="loaderBar"></span></div>
</div>

{{-- ===== Custom cursor (desktop) ===== --}}
<div class="cursor" id="cursorDot" aria-hidden="true"></div>
<div class="cursor cursor--ring" id="cursorRing" aria-hidden="true"></div>

{{-- ===== Scroll progress ===== --}}
<div class="progress" id="progress" aria-hidden="true"></div>

{{-- ===== Grain + glow background ===== --}}
<div class="bg" aria-hidden="true"><span class="bg__glow bg__glow--1"></span><span class="bg__glow bg__glow--2"></span><span class="bg__grain"></span></div>

{{-- ===== Nav ===== --}}
<header class="nav" id="nav">
    <a href="#top" class="nav__logo" data-cursor="link"><img src="{{ asset('img/logo-mark.png') }}" alt="{{ $p['initials'] }}"></a>
    <nav class="nav__menu">
        <a href="#about" data-cursor="link">About</a>
        <a href="#work" data-cursor="link">Work</a>
        <a href="#portfolio" data-cursor="link">Portfolio</a>
        <a href="#contact" data-cursor="link">Contact</a>
    </nav>
    <div class="nav__actions">
        <button class="nav__theme" id="themeToggle" type="button" data-cursor="link" aria-label="Toggle light / dark theme">
            <svg class="ic ic--moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
            <svg class="ic ic--sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4.2"/><path d="M12 2v2.5M12 19.5V22M4.9 4.9l1.8 1.8M17.3 17.3l1.8 1.8M2 12h2.5M19.5 12H22M4.9 19.1l1.8-1.8M17.3 6.7l1.8-1.8"/></svg>
        </button>
        <a href="#contact" class="nav__cta" data-cursor="link"><span>Get in touch</span></a>
    </div>
</header>

<main id="top">

{{-- ===== HERO ===== --}}
<section class="hero" id="hero">
    <div class="hero__bgname" aria-hidden="true"><span data-marq>{{ strtoupper($p['last']) }} &nbsp;/&nbsp; {{ strtoupper($p['last']) }} &nbsp;/&nbsp; </span></div>
    <div class="hero__grid">
        <div class="hero__text">
            <div class="hero__meta">
                <span class="hero__status"><i></i> Available for Collaboration &amp; Partnership</span>
                <span class="hero__metasep"></span>
                <span>{{ $p['location'] }}</span>
            </div>
            <h1 class="hero__name">
                @foreach ($nameWords as $i => $w)
                    <span class="line" style="--i:{{ $i }}"><span class="line__in">{{ strtoupper($w) }}</span></span>
                @endforeach
            </h1>
            <p class="hero__role">{{ $p['role'] }}</p>
            <p class="hero__lead">{{ $p['tagline'] }}</p>
            <div class="hero__cta">
                <a href="#contact" class="btn btn--solid" data-cursor="link"><span>Let’s talk</span></a>
                <a href="#work" class="btn btn--line" data-cursor="link"><span>View work</span></a>
            </div>
        </div>
        <div class="hero__media">
            <div class="hero__photo" data-cursor="view">
                <span class="hero__livery" aria-hidden="true"></span>
                <img src="{{ asset('img/hero.jpg') }}" alt="{{ $p['name'] }}">
                <span class="hero__photo-tag">{{ $p['location'] }}</span>
            </div>
        </div>
    </div>
    <div class="hero__strip">
        @foreach ($p['stats'] as $s)
        <div class="hero__cell">
            <span class="hero__cellnum">{{ $s['value'] }}</span>
            <span class="hero__celllbl">{{ $s['label'] }}</span>
        </div>
        @endforeach
    </div>
</section>

{{-- ===== Marquee ===== --}}
<section class="marquee" aria-hidden="true">
    <div class="marquee__track" data-marq>
        @for ($i = 0; $i < 2; $i++)
            @foreach ($kw as $k)<span>{{ $k }}</span><i>✦</i>@endforeach
        @endfor
    </div>
</section>

{{-- ===== ABOUT ===== --}}
<section class="about" id="about">
    <p class="sec-label reveal"><span>01</span> About</p>
    <h2 class="about__lead" data-splitwords>{{ $aboutParts[0] }}</h2>
    <div class="about__grid">
        <aside class="about__aside">
            <div class="about__card reveal">
                <span class="about__k">Currently</span>
                <span class="about__v">{{ $p['experiences'][0]['role'] }}</span>
                <span class="about__s">{{ $p['experiences'][0]['company'] }}</span>
            </div>
            <div class="about__card reveal">
                <span class="about__k">Focus</span>
                <span class="about__v">Digital Platforms · AI · IoT</span>
            </div>
            <div class="about__card reveal">
                <span class="about__k">Based in</span>
                <span class="about__v">{{ $p['location'] }}</span>
            </div>
        </aside>
        <div class="about__main">
            <p class="about__body reveal">{{ $aboutParts[1] ?? '' }}</p>
        </div>
    </div>
</section>

{{-- ===== EXPERIENCE ===== --}}
<section class="work" id="work">
    <div class="sec-head">
        <p class="sec-label reveal"><span>02</span> Experience</p>
        <h2 class="sec-title reveal">Where I’ve built &amp; led.</h2>
    </div>
    <ul class="work__list">
        @foreach ($p['experiences'] as $i => $exp)
        <li class="work__item" data-cursor="link">
            <span class="work__idx">{{ sprintf('%02d', $i + 1) }}</span>
            <div class="work__role"><h3>{{ $exp['role'] }}</h3><p class="work__co">{{ $exp['company'] }}</p></div>
            <p class="work__sum">{{ $exp['summary'] }}</p>
            <span class="work__period">{{ $exp['period'] }}</span>
        </li>
        @endforeach
    </ul>
</section>

{{-- ===== PORTFOLIO ===== --}}
<section class="pf" id="portfolio">
    <div class="sec-head">
        <p class="sec-label reveal"><span>03</span> Portfolio</p>
        <h2 class="sec-title reveal">Products I’ve shipped &amp; lead.</h2>
    </div>
    <div class="pf__grid">
        @foreach ($p['portfolio'] as $item)
        <a class="pf__card reveal" href="{{ $item['url'] }}" target="_blank" rel="noopener" data-cursor="view">
            @if (!empty($item['preview']))
            <div class="pf__shot"><img src="{{ asset($item['preview']) }}" alt="{{ $item['name'] }}" loading="lazy"></div>
            @endif
            <div class="pf__meta">
                <span class="pf__cat">{{ $item['category'] }}</span>
                <h3 class="pf__name">{{ $item['name'] }}</h3>
                <p class="pf__desc">{{ $item['desc'] }}</p>
                <span class="pf__go">{{ $item['cta'] }} ↗</span>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- ===== SKILLS ===== --}}
<section class="skills" id="skills">
    <p class="sec-label reveal"><span>04</span> Expertise</p>
    <div class="skills__grid">
        @foreach ($p['skills'] as $sk)
        <div class="skill reveal"><span>{{ $sk['name'] }}</span></div>
        @endforeach
    </div>
</section>

{{-- ===== EDUCATION ===== --}}
<section class="edu">
    <p class="sec-label reveal"><span>05</span> Education</p>
    <div class="edu__grid">
        @foreach ($p['education'] as $ed)
        <div class="edu__card reveal">
            <span class="edu__period">{{ $ed['period'] }}</span>
            <h3 class="edu__degree">{{ $ed['degree'] }}</h3>
            <p class="edu__school">{{ $ed['school'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ===== CONTACT ===== --}}
<section class="contact" id="contact">
    <p class="sec-label reveal"><span>06</span> Contact</p>
    <h2 class="contact__big reveal">
        <span class="line"><span class="line__in">LET’S BUILD</span></span>
        <span class="line"><span class="line__in">SOMETHING <em>REAL</em></span></span>
    </h2>
    <a href="mailto:{{ $p['email'] }}" class="contact__mail" data-cursor="link">{{ $p['email'] }}</a>
    <div class="contact__row reveal">
        <a href="https://wa.me/{{ $p['phone_raw'] }}" target="_blank" rel="noopener" data-cursor="link">WhatsApp</a>
        <a href="{{ $p['website_url'] }}" target="_blank" rel="noopener" data-cursor="link">{{ $p['website'] }}</a>
        <span>{{ $p['location'] }}</span>
    </div>
</section>

</main>

<footer class="foot">
    <img class="foot__logo" src="{{ asset('img/logo-full.png') }}" alt="{{ $p['name'] }}">
    <div class="foot__bar">
        <span>© {{ date('Y') }} {{ $p['name'] }}</span>
        <a href="{{ url('/') }}" data-cursor="link">← Classic version</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lenis@1.1.14/dist/lenis.min.js"></script>
<script src="{{ asset('js/mockup.js') }}?v={{ @filemtime(public_path('js/mockup.js')) ?: '1' }}"></script>
</body>
</html>
