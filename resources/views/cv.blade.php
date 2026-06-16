<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $p['name'] }} — {{ $p['role'] }}</title>
    <meta name="description" content="{{ $p['name'] }} · {{ $p['role'] }}. {{ $p['tagline'] }}">
    <meta name="author" content="{{ $p['name'] }}">

    <meta property="og:type" content="profile">
    <meta property="og:title" content="{{ $p['name'] }} — {{ $p['role'] }}">
    <meta property="og:description" content="{{ $p['tagline'] }}">
    <meta property="og:image" content="{{ asset('img/logo-full.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('img/logo-mark-64.png') }}">
    <link rel="stylesheet" href="{{ asset('css/cv.css') }}">
</head>
<body>

<div class="scroll-progress" id="scrollProgress" aria-hidden="true"></div>

<div class="bg-aurora" aria-hidden="true">
    <span class="blob blob-1"></span>
    <span class="blob blob-2"></span>
    <span class="blob blob-3"></span>
    <span class="blob blob-4"></span>
    <canvas class="particles" id="particles"></canvas>
    <span class="grid-overlay"></span>
</div>

{{-- ============ NAV ============ --}}
<header class="nav" id="nav">
    <a href="#hero" class="nav__brand" aria-label="{{ $p['name'] }}">
        <img class="nav__logo logo-img" src="{{ asset('img/logo-mark.png') }}" alt="{{ $p['initials'] }}" width="320" height="151">
    </a>
    <nav class="nav__links">
        <a href="#about">About</a>
        <a href="#experience">Experience</a>
        <a href="#portfolio">Portfolio</a>
        <a href="#skills">Skills</a>
        <a href="#education">Education</a>
        <a href="#contact">Contact</a>
    </nav>
    <div class="nav__actions">
        <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme" title="Toggle theme">
            <svg class="icon-sun" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M19.1 4.9l-1.4 1.4M6.3 17.7l-1.4 1.4"/></svg>
            <svg class="icon-moon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
        </button>
        <a href="#contact" class="btn btn--ghost nav__cta">Get in touch</a>
    </div>
    <button class="nav__burger" id="burger" aria-label="Menu"><span></span><span></span></button>
</header>

<main>
{{-- ============ HERO ============ --}}
<section class="hero" id="hero">
    <div class="hero__inner">
        <div class="hero__text">
            <span class="eyebrow hero-in"><span class="dot"></span> Available for collaboration · {{ $p['location'] }}</span>
            <h1 class="hero__title">
                <span class="hero__hi hero-in">Hi, I’m</span>
                <span class="grad-text hero-in">{{ $p['first'] }}</span>
                <span class="hero-in">{{ $p['last'] }}</span>
            </h1>
            <p class="hero__role hero-in">{{ $p['role'] }}</p>
            <p class="hero__lead hero-in">{{ $p['tagline'] }}</p>
            <div class="hero__cta hero-in">
                <a href="#contact" class="btn btn--primary btn--shine">Let’s talk <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                <a href="#experience" class="btn btn--ghost">View experience</a>
            </div>
            <div class="hero__socials hero-in">
                <a href="mailto:{{ $p['email'] }}" title="Email">{{ $p['email'] }}</a>
                <span class="sep">·</span>
                <a href="{{ $p['website_url'] }}" target="_blank" rel="noopener" title="Website">{{ $p['website'] }}</a>
            </div>
        </div>
        <div class="hero__card hero-in">
            <div class="avatar-card" data-tilt>
                <div class="avatar-card__glow"></div>
                <div class="avatar">
                    <span class="avatar__ring"></span>
                    <span class="avatar__ring avatar__ring--2"></span>
                    <span class="avatar__disc">
                        <img class="avatar__logo logo-img" src="{{ asset('img/logo-mark.png') }}" alt="{{ $p['initials'] }}">
                    </span>
                </div>
                <p class="avatar-card__name">{{ $p['name'] }}</p>
                <p class="avatar-card__title">Chief Executive Officer<br><small>PT Logilink Global Utama</small></p>
                <div class="avatar-card__chips">
                    <span>AI</span><span>IoT</span><span>Logistics</span><span>Fullstack</span>
                </div>
            </div>
        </div>
    </div>

    {{-- stats --}}
    <div class="stats reveal">
        @foreach ($p['stats'] as $s)
        <div class="stat">
            <span class="stat__value" data-count="{{ $s['value'] }}">{{ $s['value'] }}</span>
            <span class="stat__label">{{ $s['label'] }}</span>
        </div>
        @endforeach
    </div>
</section>

{{-- ============ ABOUT ============ --}}
<section class="section" id="about">
    <div class="section__head reveal">
        <span class="section__tag">01 · About</span>
        <h2 class="section__title">A decade turning <span class="grad-text">blueprints</span> into shipped products.</h2>
    </div>
    <p class="about__lead reveal">{{ $p['about'] }}</p>
</section>

{{-- ============ EXPERIENCE ============ --}}
<section class="section" id="experience">
    <div class="section__head reveal">
        <span class="section__tag">02 · Experience</span>
        <h2 class="section__title">Where I’ve <span class="grad-text">built</span> things.</h2>
    </div>
    <div class="timeline">
        @foreach ($p['experiences'] as $exp)
        <article class="tl-item reveal">
            <div class="tl-item__dot">@if(!empty($exp['current']))<span class="ping"></span>@endif</div>
            <div class="tl-item__body card">
                <div class="tl-item__top">
                    <div>
                        <h3 class="tl-item__role">{{ $exp['role'] }}</h3>
                        <p class="tl-item__company">{{ $exp['company'] }}</p>
                    </div>
                    <span class="tl-item__period @if(!empty($exp['current'])) is-current @endif">{{ $exp['period'] }}</span>
                </div>
                <p class="tl-item__summary">{{ $exp['summary'] }}</p>
                <div class="tags">
                    @foreach ($exp['tags'] as $tag)<span class="tag">{{ $tag }}</span>@endforeach
                </div>
            </div>
        </article>
        @endforeach
    </div>
</section>

{{-- ============ PORTFOLIO ============ --}}
<section class="section" id="portfolio">
    <div class="section__head reveal">
        <span class="section__tag">03 · Portfolio</span>
        <h2 class="section__title">Products I’ve <span class="grad-text">shipped</span> &amp; lead.</h2>
    </div>
    <div class="portfolio-grid">
        @foreach ($p['portfolio'] as $item)
        <a href="{{ $item['url'] }}" target="_blank" rel="noopener" class="pf-card pf-card--{{ $item['accent'] }} card reveal" data-tilt>
            @if (!empty($item['preview']))
            <div class="pf-preview">
                <div class="pf-preview__bar" aria-hidden="true">
                    <span></span><span></span><span></span>
                    <em class="pf-preview__url">{{ parse_url($item['url'], PHP_URL_HOST) }}</em>
                </div>
                <div class="pf-preview__shot">
                    <img src="{{ asset($item['preview']) }}" alt="Live preview of {{ $item['name'] }}" loading="lazy">
                </div>
            </div>
            @endif
            <div class="pf-card__top">
                <span class="pf-card__cat">{{ $item['category'] }}</span>
                @if (!empty($item['badge']))
                    <span class="pf-card__badge"><span class="pf-card__badge-dot"></span>{{ $item['badge'] }}</span>
                @endif
            </div>
            <h3 class="pf-card__name">{{ $item['name'] }}</h3>
            <p class="pf-card__desc">{{ $item['desc'] }}</p>
            <div class="tags pf-card__tags">
                @foreach ($item['tags'] as $tag)<span class="tag">{{ $tag }}</span>@endforeach
            </div>
            @if (!empty($item['note']))
                <p class="pf-card__demo pf-card__note">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
                    {{ $item['note'] }}
                </p>
            @endif
            <span class="pf-card__cta">{{ $item['cta'] }}
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M9 7h8v8"/></svg>
            </span>
        </a>
        @endforeach
    </div>
</section>

{{-- ============ SKILLS ============ --}}
<section class="section" id="skills">
    <div class="section__head reveal">
        <span class="section__tag">04 · Expertise</span>
        <h2 class="section__title">Tools & <span class="grad-text">domains</span> I work across.</h2>
    </div>
    <div class="skills-grid">
        @foreach ($p['skills'] as $skill)
        <div class="skill-card card reveal">
            <span class="skill-card__icon">@include('icons.'.$skill['icon'])</span>
            <span class="skill-card__name">{{ $skill['name'] }}</span>
        </div>
        @endforeach
    </div>
</section>

{{-- ============ EDUCATION ============ --}}
<section class="section" id="education">
    <div class="section__head reveal">
        <span class="section__tag">05 · Education</span>
        <h2 class="section__title">Computer Science, <span class="grad-text">twice over</span>.</h2>
    </div>
    <div class="edu-grid">
        @foreach ($p['education'] as $edu)
        <div class="edu-card card reveal">
            <span class="edu-card__cap">
                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1 2.7 2.5 6 2.5s6-1.5 6-2.5v-5"/></svg>
            </span>
            <div>
                <span class="edu-card__period">{{ $edu['period'] }}</span>
                <h3 class="edu-card__degree">{{ $edu['degree'] }}</h3>
                <p class="edu-card__school">{{ $edu['school'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ============ CONTACT ============ --}}
<section class="section section--contact" id="contact">
    <div class="contact card reveal">
        <div class="contact__main">
            <span class="section__tag">06 · Contact</span>
            <h2 class="section__title">Let’s build something <span class="grad-text">that ships</span>.</h2>
            <p class="contact__lead">Open to leadership, research and engineering collaborations across AI, IoT and logistics.</p>
            <div class="contact__links">
                <a class="contact-link" href="mailto:{{ $p['email'] }}">
                    <span class="contact-link__ic"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span>
                    <span><small>Email</small>{{ $p['email'] }}</span>
                </a>
                <a class="contact-link" href="https://wa.me/{{ $p['phone_raw'] }}" target="_blank" rel="noopener">
                    <span class="contact-link__ic"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg></span>
                    <span><small>Phone / WhatsApp</small>{{ $p['phone'] }}</span>
                </a>
                <a class="contact-link" href="{{ $p['website_url'] }}" target="_blank" rel="noopener">
                    <span class="contact-link__ic"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18z"/></svg></span>
                    <span><small>Website</small>{{ $p['website'] }}</span>
                </a>
                <div class="contact-link contact-link--static">
                    <span class="contact-link__ic"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-5.7-7-11a7 7 0 0 1 14 0c0 5.3-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg></span>
                    <span><small>Location</small>{{ $p['location'] }}</span>
                </div>
            </div>
        </div>
        <div class="contact__ref">
            <span class="ref__label">Reference</span>
            <p class="ref__name">{{ $p['reference']['name'] }}</p>
            <p class="ref__title">{{ $p['reference']['title'] }}</p>
            <div class="ref__contact">
                <a href="mailto:{{ $p['reference']['email'] }}">{{ $p['reference']['email'] }}</a>
                <span>{{ $p['reference']['phone'] }}</span>
            </div>
        </div>
    </div>
</section>
</main>

<footer class="footer">
    <div class="footer__brand reveal">
        <img class="footer__logo logo-img" src="{{ asset('img/logo-full.png') }}" alt="{{ $p['name'] }}" width="760" height="475">
    </div>
    <div class="footer__bar">
        <span>© {{ date('Y') }} {{ $p['name'] }}</span>
        <span class="footer__made">Designed &amp; built with Laravel</span>
    </div>
</footer>

<a href="#hero" class="to-top" id="toTop" aria-label="Back to top">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</a>

<script src="{{ asset('js/cv.js') }}"></script>
</body>
</html>
