@php
    $first = strtoupper($p['first']);
    $lastWords = preg_split('/\s+/', trim(strtoupper($p['last'])));
    $kw = ['Programmer','Project Manager','Researcher','CEO','AI','IoT','Logistics','Robotics'];
    $num = '97';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <script>try{if(!matchMedia('(prefers-reduced-motion: reduce)').matches)document.documentElement.classList.add('is-animating');}catch(e){}</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $p['name'] }} · {{ $p['role'] }}</title>
    <meta name="description" content="{{ $p['tagline'] }}">
    <meta name="theme-color" content="#0c0d0a">
    <meta property="og:title" content="{{ $p['name'] }} — {{ $p['role'] }}">
    <meta property="og:description" content="{{ $p['tagline'] }}">
    <meta property="og:image" content="{{ asset('img/hero.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mark-64.png') }}">
    <link rel="stylesheet" href="{{ asset('css/sport.css') }}?v={{ @filemtime(public_path('css/sport.css')) ?: '1' }}">
</head>
<body>

{{-- ===== Loader ===== --}}
<div class="ld" id="loader">
    <span class="ld__num" id="loaderCount">0</span>
    <div class="ld__bar"><span id="loaderBar"></span></div>
    <span class="ld__tag">{{ strtoupper($p['name']) }}</span>
</div>

{{-- ===== Custom cursor ===== --}}
<div class="cur" id="cursorDot" aria-hidden="true"></div>
<div class="cur cur--ring" id="cursorRing" aria-hidden="true"></div>

{{-- ===== Scroll progress ===== --}}
<div class="prog" id="progress" aria-hidden="true"></div>

{{-- ===== Nav ===== --}}
<header class="nav" id="nav">
    <a href="#top" class="nav__logo" data-cur="link"><img src="{{ asset('img/logo-mark.png') }}" alt="{{ $p['initials'] }}"></a>
    <nav class="nav__menu">
        <a href="#about" data-cur="link">About</a>
        <a href="#career" data-cur="link">Career</a>
        <a href="#work" data-cur="link">Work</a>
        <a href="#contact" data-cur="link">Contact</a>
    </nav>
    <div class="nav__right">
        <a href="{{ url('/') }}" class="nav__alt" data-cur="link">Main site ↗</a>
        <a href="#contact" class="btn btn--acc" data-cur="link"><span>Get in touch</span></a>
    </div>
</header>

<main id="top">

{{-- ===== HERO ===== --}}
<section class="hero" id="hero">
    <span class="hero__num" aria-hidden="true">{{ $num }}</span>
    <div class="hero__inner">
        <div class="hero__head">
            <p class="hero__kicker"><span class="dot"></span>{{ $p['role'] }}</p>
            <h1 class="hero__name">
                <span class="hero__first"><span class="ln"><span class="ln__in">{{ $first }}</span></span></span>
                @foreach ($lastWords as $w)
                <span class="hero__last"><span class="ln"><span class="ln__in">{{ $w }}</span></span></span>
                @endforeach
            </h1>
        </div>
        <div class="hero__media" data-cur="view">
            <div class="hero__photo"><img src="{{ asset('img/hero.jpg') }}" alt="{{ $p['name'] }}"></div>
            <span class="hero__badge">{{ $p['location'] }}</span>
        </div>
        <div class="hero__foot">
            <p class="hero__lead">{{ $p['tagline'] }}</p>
            <a href="#about" class="hero__scroll" data-cur="link"><span>Scroll</span><i></i></a>
        </div>
    </div>
</section>

{{-- ===== Marquee ===== --}}
<section class="mq" aria-hidden="true">
    <div class="mq__row" data-marq>
        @for ($i = 0; $i < 2; $i++)
            @foreach ($kw as $k)<span>{{ $k }}</span><i>✱</i>@endforeach
        @endfor
    </div>
</section>

{{-- ===== ABOUT ===== --}}
<section class="ab" id="about">
    <p class="lbl reveal"><span>01</span> About</p>
    <div class="ab__grid">
        <h2 class="ab__lead" data-splitwords>{{ $p['about'] }}</h2>
        <div class="ab__side reveal">
            <div class="ab__photo" id="abPhoto">
                <img class="ab__face" src="{{ asset('img/photo.jpg') }}" alt="{{ $p['name'] }}" loading="lazy">
                <div class="ab__robot" aria-hidden="true">
                    <img src="{{ asset('img/photo.jpg') }}" alt="" loading="lazy">
                    <span class="ab__chrome"></span>
                    <span class="ab__circuit"></span>
                    <span class="ab__eyes"></span>
                    <span class="ab__scan"></span>
                </div>
                <span class="ab__ring" aria-hidden="true"></span>
                <span class="ab__hint" aria-hidden="true">◉ Robot mode — hover to reveal</span>
            </div>
            <ul class="ab__facts">
                <li><span>Role</span><b>CEO · PT Logilink Global Utama</b></li>
                <li><span>Focus</span><b>Digital Platforms · AI · IoT</b></li>
                <li><span>Based</span><b>{{ $p['location'] }}</b></li>
            </ul>
        </div>
    </div>
</section>

{{-- ===== STATS ===== --}}
<section class="st">
    @foreach ($p['stats'] as $s)
    <div class="st__cell reveal">
        <span class="st__num" data-count="{{ $s['value'] }}">{{ $s['value'] }}</span>
        <span class="st__lbl">{{ $s['label'] }}</span>
    </div>
    @endforeach
</section>

{{-- ===== CAREER ===== --}}
<section class="cr" id="career">
    <div class="cr__head">
        <p class="lbl reveal"><span>02</span> Career</p>
        <h2 class="sec-title reveal">The track record.</h2>
    </div>
    <ul class="cr__list">
        @foreach ($p['experiences'] as $i => $exp)
        <li class="cr__row reveal" data-cur="link">
            <span class="cr__idx">{{ sprintf('%02d', $i + 1) }}</span>
            <div class="cr__role">
                <h3>{{ $exp['role'] }}</h3>
                <p>{{ $exp['company'] }}</p>
            </div>
            <p class="cr__sum">{{ $exp['summary'] }}</p>
            <span class="cr__yr">{{ $exp['period'] }}</span>
        </li>
        @endforeach
    </ul>
</section>

{{-- ===== WORK ===== --}}
<section class="wk" id="work">
    <div class="wk__head">
        <p class="lbl reveal"><span>03</span> Work</p>
        <h2 class="sec-title reveal">Products in the field.</h2>
    </div>
    <div class="wk__grid">
        @foreach ($p['portfolio'] as $item)
        <a class="wk__card reveal" href="{{ $item['url'] }}" target="_blank" rel="noopener" data-cur="view">
            @if (!empty($item['preview']))
            <div class="wk__shot"><img src="{{ asset($item['preview']) }}" alt="{{ $item['name'] }}" loading="lazy"></div>
            @endif
            <div class="wk__meta">
                <span class="wk__cat">{{ $item['category'] }}</span>
                <h3 class="wk__name">{{ $item['name'] }}</h3>
                <p class="wk__desc">{{ $item['desc'] }}</p>
                <span class="wk__go">{{ $item['cta'] }} ↗</span>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- ===== EXPERTISE ===== --}}
<section class="ex">
    <p class="lbl reveal"><span>04</span> Expertise</p>
    <div class="ex__wrap">
        @foreach ($p['skills'] as $sk)
        <span class="ex__tag reveal">{{ $sk['name'] }}</span>
        @endforeach
    </div>
</section>

{{-- ===== EDUCATION ===== --}}
<section class="ed">
    <p class="lbl reveal"><span>05</span> Education</p>
    <div class="ed__grid">
        @foreach ($p['education'] as $ed)
        <div class="ed__card reveal">
            <span class="ed__yr">{{ $ed['period'] }}</span>
            <h3 class="ed__deg">{{ $ed['degree'] }}</h3>
            <p class="ed__sch">{{ $ed['school'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ===== CONTACT ===== --}}
<section class="ct" id="contact">
    <p class="lbl reveal"><span>06</span> Contact</p>
    <h2 class="ct__big">
        <span class="ln"><span class="ln__in">LET’S BUILD</span></span>
        <span class="ln"><span class="ln__in">SOMETHING <em>FAST</em></span></span>
    </h2>
    <a href="mailto:{{ $p['email'] }}" class="ct__mail" data-cur="link">{{ $p['email'] }}</a>
    <div class="ct__row reveal">
        <a href="https://wa.me/{{ $p['phone_raw'] }}" target="_blank" rel="noopener" data-cur="link">WhatsApp</a>
        <a href="{{ $p['website_url'] }}" target="_blank" rel="noopener" data-cur="link">{{ $p['website'] }}</a>
        <span>{{ $p['location'] }}</span>
    </div>
</section>

</main>

<footer class="ft">
    <img class="ft__logo" src="{{ asset('img/logo-full.png') }}" alt="{{ $p['name'] }}">
    <div class="ft__bar">
        <span>© {{ date('Y') }} {{ $p['name'] }}</span>
        <a href="#top" data-cur="link">Back to top ↑</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lenis@1.1.14/dist/lenis.min.js"></script>
<script src="{{ asset('js/sport.js') }}?v={{ @filemtime(public_path('js/sport.js')) ?: '1' }}"></script>
</body>
</html>
