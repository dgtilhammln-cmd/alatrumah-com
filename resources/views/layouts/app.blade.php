<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @php
        // Single cached DB call for ALL settings — prevents N+1 queries per page load
        $layoutSettings = \App\Models\Setting::getAllAsArray();
        $favicon        = !empty($layoutSettings['favicon']) ? asset('storage/'.$layoutSettings['favicon']) : asset('favicon.ico');
        $tAccent        = $layoutSettings['color_accent'] ?? null;
        $tMain          = $layoutSettings['color_main']   ?? null;
        $tText          = $layoutSettings['color_text']   ?? null;
        $breadcrumbBg   = $layoutSettings['breadcrumb_bg'] ?? null;
        $preloaderLogo  = $layoutSettings['logo'] ?? null;
        $headScripts    = $layoutSettings['head_scripts']  ?? '';
        $bodyScripts    = $layoutSettings['body_scripts']  ?? '';
    @endphp

    {{-- SEO Component --}}
    @include('components.seo')

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ $favicon }}">
    <link rel="shortcut icon" href="{{ $favicon }}">
    <link rel="apple-touch-icon" href="{{ $favicon }}">

    {{-- Google Fonts: Montserrat — Non-blocking --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&display=swap" rel="stylesheet"></noscript>

    {{-- AOS Animate on Scroll — Non-blocking --}}
    <link rel="preload" as="style" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></noscript>

    {{-- Swiper — preconnect for faster CDN lookup --}}
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    {{-- App CSS (Inlined for 99+ Lighthouse Score) --}}
    @if(file_exists(public_path('build/assets')) && count(glob(public_path('build/assets/*.css'))) > 0)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @if(file_exists(public_path('css/app.css')))
            <style>
                {!! file_get_contents(public_path('css/app.css')) !!}
            </style>
        @else
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @endif
    @endif

    {{-- Dynamic Theme Colors --}}
    @if($tAccent || $tMain || $tText)
    <style>
        :root {
            @if($tAccent) --accent: {{ $tAccent }} !important; --accent-dark: {{ $tAccent }} !important; @endif
            @if($tMain)   --bg-base: {{ $tMain }} !important; --bg-1: {{ $tMain }} !important; @endif
            @if($tText)   --text-1: {{ $tText }} !important; @endif
        }
    </style>
    @endif

    {{-- Breadcrumb / Page Hero Background --}}
    @if($breadcrumbBg)
    <style>
        .page-hero {
            background-image: url('{{ asset('storage/'.$breadcrumbBg) }}') !important;
            background-size: cover !important;
            background-position: center center !important;
            position: relative;
        }
        .page-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(12,26,58, 0.75);
            z-index: 0;
        }
        .page-hero::after {
            content: "";
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 100px;
            background: linear-gradient(to bottom, transparent, var(--bg-base));
            z-index: 1;
            pointer-events: none;
        }
        .page-hero > div,
        .page-hero .sv-hero-inner,
        .page-hero .article-hero-inner {
            position: relative;
            z-index: 2;
        }
    </style>
    @endif

    @stack('styles')

    {{-- Custom Head Scripts (e.g. GTM, Analytics) --}}
    {!! $headScripts !!}
</head>
<body>
    {{-- Preloader --}}
    <style>
        #cv-preloader {
            position: fixed; inset: 0; background: #ffffff; z-index: 99999;
            display: flex; align-items: center; justify-content: center;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        
        .cv-preloader-logo {
            max-width: 160px;
            max-height: 80px;
            filter: grayscale(100%) opacity(0.6);
            animation: wind-sway 2s ease-in-out infinite;
            position: relative;
        }

        /* Wind lines effect container */
        .cv-wind-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 250px;
            height: 150px;
            overflow: hidden;
        }

        /* The wind lines */
        .cv-wind-line {
            position: absolute;
            height: 2px;
            background: linear-gradient(90deg, transparent, #0EA5E9, transparent);
            border-radius: 50%;
            opacity: 0;
            animation: wind-blow 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }

        .cv-wind-line-1 { top: 20%; width: 120px; animation-delay: 0s; }
        .cv-wind-line-2 { top: 50%; width: 180px; animation-delay: 0.3s; }
        .cv-wind-line-3 { top: 80%; width: 140px; animation-delay: 0.6s; }

        @keyframes wind-sway {
            0%, 100% { transform: skewX(0deg) translateX(0); }
            50% { transform: skewX(-6deg) translateX(8px); }
        }

        @keyframes wind-blow {
            0% { transform: translateX(-150px); opacity: 0; }
            50% { opacity: 0.8; }
            100% { transform: translateX(150px); opacity: 0; }
        }

        body.loaded #cv-preloader { opacity: 0; visibility: hidden; }
    </style>
    <div id="cv-preloader">
        <div class="cv-wind-container">
            <div class="cv-wind-line cv-wind-line-1"></div>
            <div class="cv-wind-line cv-wind-line-2"></div>
            <div class="cv-wind-line cv-wind-line-3"></div>
            
            @if($preloaderLogo)
                <img src="{{ asset('storage/'.$preloaderLogo) }}" alt="Loading..." class="cv-preloader-logo">
            @else
                <div class="cv-preloader-logo" style="font-family:'Montserrat', sans-serif; font-size:1.5rem; font-weight:800; color:#333;">AMN</div>
            @endif
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.body.classList.add('loaded');
            }, 300); // Small delay to ensure smooth transition
        });
    </script>    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Floating WA Button --}}
    @include('components.wa-button')

    {{-- Request Order Modal (global) --}}
    @include('components.order-modal')

    {{-- AOS — Defer --}}
    <script>
    (function() {
        var style = document.createElement('style');
        style.textContent = '[data-aos]{opacity:1!important;transform:none!important;}';
        style.id = 'aos-fallback';
        document.head.appendChild(style);
    })();
    </script>
    <script defer src="https://unpkg.com/aos@2.3.1/dist/aos.js" onload="
        var fb = document.getElementById('aos-fallback');
        if(fb) fb.remove();
        AOS.init({ duration: 700, once: true, offset: 80, easing: 'ease-out-cubic', disable: function(){ return window.innerWidth < 768; } });
    "></script>

    {{-- Global WA Link Interceptor --}}
    <script>
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link) return;
        if (link.href && (link.href.includes('wa.me') || link.href.includes('api.whatsapp.com/send') || link.href.includes('whatsapp.com') || link.href.includes('wa.link'))) {
            e.preventDefault();
            let trackName = link.getAttribute('data-track') ? link.getAttribute('data-track') : 'In-Text Link';
            if (typeof openOrderModal === 'function') {
                window.pendingWaUrl = link.href;
                openOrderModal('WhatsApp CTA: ' + trackName);
            } else {
                window.open(link.href, '_blank', 'noopener,noreferrer');
            }
        }
    });
    </script>

    @stack('scripts')

    {{-- Custom Body Scripts --}}
    {!! $bodyScripts !!}
</body>
</html>
