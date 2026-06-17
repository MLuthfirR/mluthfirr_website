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
                    <svg class="ab__skull" viewBox="0 0 400 500" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="chr" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0" stop-color="#f4f7fa"/><stop offset=".42" stop-color="#c4cdd7"/>
                                <stop offset=".72" stop-color="#7c8794"/><stop offset="1" stop-color="#39414c"/>
                            </linearGradient>
                            <linearGradient id="chrH" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0" stop-color="#576069"/><stop offset=".5" stop-color="#eaeff4"/><stop offset="1" stop-color="#576069"/>
                            </linearGradient>
                            <radialGradient id="eyeG" cx=".5" cy=".5" r=".5">
                                <stop offset="0" stop-color="#fff"/><stop offset=".22" stop-color="#ffd98a"/>
                                <stop offset=".5" stop-color="#ff7d1a"/><stop offset=".82" stop-color="#e21d00"/>
                                <stop offset="1" stop-color="#e21d00" stop-opacity="0"/>
                            </radialGradient>
                            <radialGradient id="sok" cx=".5" cy=".42" r=".75">
                                <stop offset="0" stop-color="#070809"/><stop offset="1" stop-color="#2a313a"/>
                            </radialGradient>
                        </defs>
                        <path d="M200 30 C128 30 80 86 78 168 C77 202 83 226 99 248 C103 288 118 320 140 346 C158 374 178 394 200 398 C222 394 242 374 260 346 C282 320 297 288 301 248 C317 226 323 202 322 168 C320 86 272 30 200 30 Z" fill="url(#chr)" stroke="#2b323b" stroke-width="2"/>
                        <path d="M200 34 C140 34 92 84 90 162 C90 150 150 120 200 120 C250 120 310 150 310 162 C308 84 260 34 200 34 Z" fill="url(#chrH)" opacity=".55"/>
                        <path d="M96 150 C140 118 260 118 304 150" fill="none" stroke="#39414b" stroke-width="3" stroke-linecap="round"/>
                        <path d="M200 36 L200 120" stroke="#39414b" stroke-width="2"/>
                        <path d="M104 170 C140 154 176 156 190 176 L190 188 C168 174 138 176 112 192 Z" fill="#4a525d"/>
                        <path d="M296 170 C260 154 224 156 210 176 L210 188 C232 174 262 176 288 192 Z" fill="#4a525d"/>
                        <path d="M112 178 L186 190 L180 220 L122 226 C110 212 108 194 112 178 Z" fill="url(#sok)"/>
                        <path d="M288 178 L214 190 L220 220 L278 226 C290 212 292 194 288 178 Z" fill="url(#sok)"/>
                        <circle class="eye" cx="150" cy="202" r="22" fill="url(#eyeG)"/>
                        <circle class="eye" cx="250" cy="202" r="22" fill="url(#eyeG)"/>
                        <circle cx="150" cy="202" r="6" fill="#fff"/>
                        <circle cx="250" cy="202" r="6" fill="#fff"/>
                        <path d="M200 230 C195 252 189 264 182 276 L200 286 L218 276 C211 264 205 252 200 230 Z" fill="url(#sok)"/>
                        <path d="M120 232 C120 260 132 286 150 304" fill="none" stroke="#39414b" stroke-width="2"/>
                        <path d="M280 232 C280 260 268 286 250 304" fill="none" stroke="#39414b" stroke-width="2"/>
                        <path d="M150 300 C168 308 232 308 250 300 L246 330 C228 340 172 340 154 330 Z" fill="url(#chrH)" stroke="#2b323b" stroke-width="1.5"/>
                        <path d="M152 315 L248 315" stroke="#2b323b" stroke-width="1.5"/>
                        <path d="M166 302 L164 338 M180 302 L179 339 M194 302 L194 340 M208 302 L207 340 M222 302 L223 339 M236 302 L237 338" stroke="#2b323b" stroke-width="1.4"/>
                        <path d="M154 332 C166 364 184 386 200 388 C216 386 234 364 246 332 C228 342 172 342 154 332 Z" fill="url(#chr)" stroke="#2b323b" stroke-width="1.5"/>
                        <circle cx="104" cy="250" r="7" fill="#5b636e" stroke="#2b323b" stroke-width="1.5"/>
                        <circle cx="296" cy="250" r="7" fill="#5b636e" stroke="#2b323b" stroke-width="1.5"/>
                        <circle cx="120" cy="150" r="3.5" fill="#6b7480"/>
                        <circle cx="280" cy="150" r="3.5" fill="#6b7480"/>
                        <circle cx="138" cy="330" r="3" fill="#6b7480"/>
                        <circle cx="262" cy="330" r="3" fill="#6b7480"/>
                    </svg>
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
