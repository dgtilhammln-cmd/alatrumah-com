@extends('layouts.app')

@section('content')
    @push('styles')
        @if(isset($heroSlides) && $heroSlides->count() > 0)
            <link rel="preload" as="image" href="{{ asset('storage/' . $heroSlides->first()->image) }}">
        @elseif(!empty($settings['hero_main_image']))
            <link rel="preload" as="image" href="{{ asset('storage/' . $settings['hero_main_image']) }}">
        @else
            <link rel="preload" as="image" href="{{ asset('images/amn/hero-main.png') }}">
        @endif
    @endpush
    {{-- ════════════════════════════════════════════════
      HOME PAGE — PT. Airlangga Merapi Nusantara
      Eksportir Arang Briket Premium | Surabaya, Indonesia
    ════════════════════════════════════════════════ --}}

    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" media="print" onload="this.media='all'" />
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /></noscript>
    <style>
    /* ── NEW HERO ────────────────────────────────── */
    .cv-hero-modern {
        background-color: #F8FAFC;
        min-height: 100vh;
        padding-top: calc(46px + 2.5rem);
        padding-bottom: 3rem;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    @media (max-width: 768px) {
        .cv-hero-modern {
            padding-top: calc(80px + 2.5rem);
            padding-bottom: 2.5rem;
            align-items: flex-start;
        }
    }
    @media (max-width: 480px) {
        .cv-hero-modern {
            padding-top: calc(90px + 2rem);
        }
    }
    .cv-hero-bg-layer {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.18;
        z-index: 0;
        mix-blend-mode: multiply;
    }
    .cv-hero-grid {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1.4fr 0.9fr;
        gap: 2rem;
        align-items: center;
        position: relative;
        z-index: 1;
    }
    /* Left Column */
    .cv-hero-left {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .cv-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #fff;
        padding: 0.4rem 0.875rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 600;
        color: #0369a1;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        margin-bottom: 1.25rem;
        letter-spacing: 0.04em;
    }
    .cv-hero-badge::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: #38BDF8;
    }
    .cv-hero-title {
        font-size: clamp(2rem, 3.2vw, 3.25rem);
        font-weight: 400;
        color: #1e293b;
        line-height: 1.12;
        margin-bottom: 1.25rem;
        letter-spacing: -0.02em;
    }
    .cv-hero-pill-text {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background: #E0F2FE;
        color: #0284C7;
        padding: 0.2rem 1.25rem 0.2rem 0.4rem;
        border-radius: 999px;
        margin: 0.15rem 0;
        font-weight: 500;
    }
    .cv-hero-pill-icon {
        width: 40px; height: 40px;
        background: #0EA5E9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        flex-shrink: 0;
    }
    .cv-hero-icons {
        display: flex;
        gap: 0.6rem;
        margin-bottom: 1.25rem;
    }
    .cv-hero-icon-circle {
        width: 38px; height: 38px;
        background: #fff;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #0EA5E9;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }
    .cv-hero-desc {
        font-size: 0.8125rem;
        font-weight: 400;
        color: #64748b;
        line-height: 1.7;
        margin-bottom: 1.75rem;
        max-width: 95%;
        position: relative;
        padding-left: 1.25rem;
    }
    .cv-hero-desc::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 2px;
        background: #cbd5e1;
        border-radius: 2px;
    }
    .cv-hero-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }
    .cv-btn-solid {
        background: #0369a1;
        color: #fff;
        padding: 0.75rem 1.75rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(14,165,233,0.25);
        white-space: nowrap;
    }
    .cv-btn-solid:hover { background: #075985; transform: translateY(-2px); }
    .cv-btn-outline {
        background: #fff;
        color: #0EA5E9;
        padding: 0.75rem 1.75rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
        border: 1.5px solid rgba(14,165,233,0.2);
        white-space: nowrap;
    }
    .cv-btn-outline:hover { background: #F0F9FF; }

    /* Center Column */
    .cv-hero-center {
        position: relative;
        height: 520px;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(0,0,0,0.08);
    }
    .cv-hero-img-main {
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .hero-swiper { width:100%; height:100%; }
    .hero-swiper-slide { width:100%; height:100%; }
    .hero-swiper-pagination .swiper-pagination-bullet { background: #fff; opacity: 0.5; }
    .hero-swiper-pagination .swiper-pagination-bullet-active { background: #38BDF8; opacity: 1; }
    .cv-glass-badge {
        position: absolute;
        background: rgba(255,255,255,0.18);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.35);
        padding: 0.4rem 0.875rem;
        border-radius: 999px;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .cv-glass-badge::before {
        content: ''; width: 5px; height: 5px; border-radius: 50%; background: #38BDF8;
    }
    .cv-glass-card {
        position: absolute;
        bottom: 1.25rem;
        right: 1.25rem;
        background: rgba(15,23,42,0.7);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.08);
        padding: 1.25rem;
        border-radius: 18px;
        color: #fff;
    }
    .cv-glass-num { font-size: 2.25rem; font-weight: 300; line-height: 1; margin-bottom: 0.375rem; }
    .cv-glass-text { font-size: 0.65rem; color: rgba(255,255,255,0.65); max-width: 110px; line-height: 1.4; }

    /* Right Column */
    .cv-hero-right {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    .cv-hero-r-title {
        font-size: 1.5rem;
        font-weight: 400;
        color: #1e293b;
        line-height: 1.2;
    }
    .cv-hero-r-desc {
        font-size: 0.78rem;
        font-weight: 400;
        color: #64748b;
        line-height: 1.6;
    }
    .cv-hero-r-card {
        position: relative;
        height: 260px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }
    .cv-hero-img-sec {
        width: 100%; height: 100%;
        object-fit: cover;
    }

    /* ── MARQUEE CLIENTS BAR ──────────── */
    .cv-clients-bar {
        background: #F8FAFF;
        border-top: 1px solid rgba(56,189,248,0.1);
        border-bottom: 1px solid rgba(56,189,248,0.1);
        padding: 1.5rem 0;
        overflow: hidden;
    }
    .cv-clients-label {
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #94A3B8;
        white-space: nowrap;
        flex-shrink: 0;
        padding-right: 2rem;
    }
    .cv-client-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #fff;
        border: 1px solid rgba(56,189,248,0.15);
        border-radius: 6px;
        padding: 0.5rem 1.125rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: #334155;
        white-space: nowrap;
        margin: 0 0.5rem;
    }
    .cv-client-chip::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #38BDF8;
        flex-shrink: 0;
    }

    /* ── EXPLAINER ────────────────────── */
    .cv-explainer { background: var(--bg-1); }
    .cv-explainer-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5rem;
        align-items: center;
    }
    .cv-explainer-steps {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .cv-explainer-step {
        display: flex;
        gap: 1.25rem;
        align-items: flex-start;
    }
    .cv-step-num {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #0EA5E9, #38BDF8);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 900;
        color: #fff;
        flex-shrink: 0;
    }
    .cv-step-title {
        font-size: 0.9375rem;
        font-weight: 300;
        color: var(--text-1);
        margin-bottom: 0.25rem;
    }
    .cv-step-desc {
        font-size: 0.8125rem;
        font-weight: 300;
        color: var(--text-3);
        line-height: 1.6;
    }
    .cv-explainer-visual {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cv-explainer-card {
        background: linear-gradient(135deg, #38BDF8, #0EA5E9);
        border-radius: 20px;
        padding: 2.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 80px rgba(14,165,233,0.25);
    }
    .cv-explainer-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 80% 60% at 50% 20%, rgba(255,255,255,0.15) 0%, transparent 70%);
    }

    /* ── PRODUCTS ─────────────────────── */
    .cv-products { background: var(--bg-base); }
    .cv-products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }
    .cv-product-card {
        background: var(--bg-base);
        border: 1.5px solid var(--border-1);
        border-radius: 16px;
        padding: 2rem 1.75rem;
        text-decoration: none;
        display: block;
        transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(56,189,248,0.05);
    }
    .cv-product-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #0EA5E9, #38BDF8, #7DD3FC);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }
    .cv-product-card:hover {
        border-color: #38BDF8;
        transform: translateY(-8px);
        box-shadow: 0 32px 80px rgba(56,189,248,0.15), 0 0 0 1px rgba(56,189,248,0.1);
    }
    .cv-product-card:hover::after { transform: scaleX(1); }
    .cv-product-type {
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #0EA5E9;
        margin-bottom: 0.375rem;
    }
    .cv-product-name {
        font-size: 1.375rem;
        font-weight: 900;
        color: var(--text-1);
        letter-spacing: -0.02em;
        margin-bottom: 0.25rem;
    }
    .cv-product-size {
        font-size: 0.8125rem;
        font-weight: 400;
        color: var(--text-3);
        margin-bottom: 1.25rem;
    }
    .cv-product-specs {
        border-top: 1px solid var(--border-1);
        padding-top: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
    }
    .cv-spec-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .cv-spec-key {
        font-size: 0.75rem;
        font-weight: 400;
        color: var(--text-3);
    }
    .cv-spec-val {
        font-size: 0.8125rem;
        font-weight: 700;
        color: var(--text-1);
    }
    .cv-spec-val.highlight { color: #0284C7; }
    .cv-product-cta {
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #0EA5E9;
        transition: gap 0.2s;
    }
    .cv-product-card:hover .cv-product-cta { gap: 0.625rem; }

    /* ── ADVANTAGES ───────────────────── */
    .cv-advantages { background: var(--bg-1); }
    .cv-adv-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }
    .cv-adv-card {
        background: var(--bg-base);
        border: 1px solid var(--border-2);
        border-radius: 12px;
        padding: 1.75rem;
        transition: all 0.3s ease;
        color: var(--text-1);
    }
    .cv-adv-card:hover {
        background: var(--bg-2);
        border-color: var(--accent);
        transform: translateY(-4px);
    }
    .cv-adv-icon {
        width: 48px; height: 48px;
        background: var(--bg-2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        color: var(--accent-dark);
    }
    .cv-adv-title {
        font-size: 1rem;
        font-weight: 300;
        color: var(--text-1);
        margin-bottom: 0.5rem;
    }
    .cv-adv-desc {
        font-size: 0.8125rem;
        font-weight: 300;
        color: var(--text-3);
        line-height: 1.65;
    }

    /* ── APPLICATIONS ─────────────────── */
    .cv-apps { background: var(--bg-1); }
    .cv-apps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-top: 3rem;
    }
    .cv-app-card {
        background: var(--bg-base);
        border: 1.5px solid var(--border-1);
        border-radius: 12px;
        padding: 1.75rem 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    .cv-app-card:hover {
        border-color: var(--accent);
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(56,189,248,0.12);
    }
    .cv-app-emoji {
        font-size: 2.25rem;
        display: block;
        margin-bottom: 0.875rem;
        line-height: 1;
    }
    .cv-app-title {
        font-size: 0.9375rem;
        font-weight: 300;
        color: var(--text-1);
        margin-bottom: 0.375rem;
    }
    .cv-app-desc {
        font-size: 0.75rem;
        font-weight: 300;
        color: var(--text-3);
        line-height: 1.5;
    }

    /* ── GALLERY PREVIEW ──────────────── */
    .cv-gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(2, 220px);
        gap: 1rem;
        margin-top: 3rem;
    }
    .cv-gallery-grid .gallery-item:first-child {
        grid-column: span 2;
        grid-row: span 2;
    }
    .cv-gallery-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--bg-2), var(--bg-3));
        border-radius: 10px;
    }
    .cv-gallery-placeholder-inner {
        text-align: center;
        color: var(--text-3);
    }

    /* ── TESTIMONIALS ─────────────────── */
    .cv-testimonials { background: var(--bg-dark); }
    .cv-testi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }
    .cv-testi-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 16px;
        padding: 2rem;
        position: relative;
    }
    .cv-testi-quote {
        font-size: 2.5rem;
        color: #38BDF8;
        opacity: 0.3;
        line-height: 1;
        margin-bottom: 0.5rem;
        font-family: Georgia, serif;
    }
    .cv-testi-text {
        font-size: 0.875rem;
        font-weight: 300;
        color: rgba(255,255,255,0.65);
        line-height: 1.75;
        margin-bottom: 1.5rem;
        font-style: italic;
    }
    .cv-testi-author {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .cv-testi-avatar {
        width: 44px; height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0EA5E9, #38BDF8);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 800;
        color: #fff;
        flex-shrink: 0;
    }
    .cv-testi-name {
        font-size: 0.9375rem;
        font-weight: 300;
        color: #fff;
    }
    .cv-testi-company {
        font-size: 0.75rem;
        font-weight: 300;
        color: rgba(255,255,255,0.45);
    }
    .cv-testi-stars {
        display: flex;
        gap: 2px;
        margin-bottom: 1rem;
    }

    /* ── COVERAGE MAP ─────────────────── */
    .cv-coverage { background: var(--bg-2); }
    .cv-coverage-areas {
        display: flex;
        flex-wrap: wrap;
        gap: 0.625rem;
        margin-top: 2rem;
    }
    .cv-area-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: var(--bg-base);
        border: 1px solid var(--border-1);
        border-radius: 20px;
        padding: 0.4rem 0.875rem;
        font-size: 0.8rem;
        font-weight: 400;
        color: var(--text-2);
        transition: all 0.2s;
    }
    .cv-area-chip:hover {
        border-color: var(--accent);
        color: var(--accent-deep);
        background: var(--accent-glow);
    }
    .cv-area-chip::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: #38BDF8;
        flex-shrink: 0;
    }

    /* ── CTA SECTION ──────────────────── */
    .cv-cta {
        background: linear-gradient(135deg, #38BDF8 0%, #0EA5E9 50%, #0284C7 100%);
        position: relative;
        overflow: hidden;
    }
    .cv-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 80% at 80% 50%, rgba(255,255,255,0.15) 0%, transparent 70%);
        pointer-events: none;
    }
    .cv-cta-inner {
        max-width: 860px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    /* ── ARTICLES ─────────────────────── */
    .cv-articles { background: var(--bg-1); }
    .cv-articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }
    .cv-article-card {
        background: var(--bg-base);
        border: 1.5px solid var(--border-1);
        border-radius: 14px;
        overflow: hidden;
        text-decoration: none;
        display: block;
        transition: all 0.3s ease;
    }
    .cv-article-card:hover {
        border-color: var(--accent);
        transform: translateY(-6px);
        box-shadow: 0 20px 56px rgba(56,189,248,0.12);
    }
    .cv-article-thumb {
        height: 180px;
        background: linear-gradient(135deg, var(--bg-2), var(--bg-3));
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-4);
        font-size: 0.8rem;
    }
    .cv-article-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .cv-article-card:hover .cv-article-thumb img { transform: scale(1.06); }
    .cv-article-body { padding: 1.5rem; }
    .cv-article-cat {
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #0EA5E9;
        margin-bottom: 0.5rem;
    }
    .cv-article-title {
        font-size: 1rem;
        font-weight: 300;
        color: var(--text-1);
        line-height: 1.4;
        margin-bottom: 0.625rem;
    }
    .cv-article-excerpt {
        font-size: 0.8125rem;
        font-weight: 300;
        color: var(--text-3);
        line-height: 1.65;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cv-article-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.75rem;
        color: var(--text-4);
    }

    /* ── PREMIUM CLIENT BAR ──────────── */
    .cv-clients-section {
        background: #ffffff;
        padding: 3.5rem 0;
        border-top: 1px solid rgba(14,165,233,0.08);
        border-bottom: 1px solid rgba(14,165,233,0.08);
        overflow: hidden;
        position: relative;
    }
    .cv-clients-header {
        max-width: 1200px;
        margin: 0 auto 2.5rem;
        padding: 0 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 0.5rem;
    }
    .cv-clients-label {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #64748B;
    }
    .cv-clients-count {
        font-size: 0.7rem;
        font-weight: 600;
        color: #0EA5E9;
        background: #F0F9FF;
        padding: 0.35rem 1rem;
        border-radius: 20px;
        border: 1px solid rgba(14,165,233,0.15);
    }

    /* Marquee Container */
    .cv-marquee-container {
        width: 100%;
        overflow: hidden;
        position: relative;
        display: flex;
    }
    /* Fade edges */
    .cv-marquee-container::before,
    .cv-marquee-container::after {
        content: '';
        position: absolute;
        top: 0; bottom: 0;
        width: 150px;
        z-index: 2;
        pointer-events: none;
    }
    .cv-marquee-container::before {
        left: 0;
        background: linear-gradient(to right, #ffffff, transparent);
    }
    .cv-marquee-container::after {
        right: 0;
        background: linear-gradient(to left, #ffffff, transparent);
    }

    /* Infinite Animation */
    @keyframes scrollLeft {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .cv-marquee-track {
        display: flex;
        gap: 2rem;
        padding: 1.5rem 1rem;
        width: max-content;
        animation: scrollLeft 40s linear infinite;
    }
    .cv-marquee-container:hover .cv-marquee-track {
        animation-play-state: paused;
    }

    /* Card Design */
    .cv-client-logo-card {
        background: #F8FAFC;
        border: 1.5px solid #E2E8F0;
        border-radius: 16px;
        padding: 1rem 1.75rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        min-width: 180px;
        max-width: 220px;
        height: 110px;
        transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .cv-client-logo-card:hover {
        border-color: #38BDF8;
        background: #ffffff;
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 12px 30px rgba(14,165,233,0.12);
    }
    .cv-client-logo-img {
        max-height: 52px;
        max-width: 160px;
        width: auto;
        height: auto;
        object-fit: contain;
        filter: grayscale(80%) opacity(0.8);
        transition: all 0.3s;
        display: block;
    }
    .cv-client-logo-card:hover .cv-client-logo-img { filter: grayscale(0%) opacity(1); }
    .cv-client-logo-name {
        font-size: 0.7rem;
        font-weight: 600;
        color: #64748B;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 130px;
    }
    /* Text-only chip */
    .cv-client-chip-v2 {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: #F8FAFC;
        border: 1.5px solid #E2E8F0;
        border-radius: 16px;
        padding: 0 2rem;
        height: 100px;
        min-width: 160px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
        transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .cv-client-chip-v2::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #38BDF8;
        flex-shrink: 0;
    }
    .cv-client-chip-v2:hover {
        border-color: #38BDF8;
        background: #ffffff;
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 12px 30px rgba(14,165,233,0.12);
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .cv-hero-grid { grid-template-columns: 1fr 1fr; }
        .cv-hero-right { display: none; }
        .cv-hero-center { height: 420px; }
        .cv-explainer-grid { grid-template-columns: 1fr; }
        .cv-gallery-grid { grid-template-columns: repeat(2, 1fr); grid-template-rows: auto; }
        .cv-gallery-grid .gallery-item:first-child { grid-column: 1; grid-row: 1; }
    }
    @media (max-width: 640px) {
        .cv-hero-modern { padding-top: calc(46px + 1.5rem); }
        .cv-hero-grid { grid-template-columns: 1fr; }
        .cv-hero-center { height: 320px; }
        .cv-gallery-grid { grid-template-columns: 1fr; }
        .cv-products-grid, .cv-adv-grid, .cv-apps-grid { grid-template-columns: 1fr; }
    }
    </style>

    {{-- ════ NEW MODERN HERO ════ --}}
    <section class="cv-hero-modern" id="home" itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="PT. Airlangga Merapi Nusantara">
        <meta itemprop="description" content="{{ __('home.meta_desc') }}">
        <meta itemprop="address" content="Surabaya, Jawa Timur, Indonesia">
        @if(!empty($settings['hero_bg_image']))
            <div class="cv-hero-bg-layer" style="background-image:url('{{ asset('storage/' . $settings['hero_bg_image']) }}')"></div>
        @else
            <div class="cv-hero-bg-layer" style="background-image:url('{{ asset('images/amn/hero-main.png') }}')"></div>
        @endif
        <div class="cv-hero-grid">
            {{-- Left Column --}}
            <div class="cv-hero-left">
                <div class="cv-hero-badge">{{ __('home.hero_badge') }}</div>
                <h1 class="cv-hero-title">
                    {{ __('home.hero_title_1') }}<br>
                    <span class="cv-hero-pill-text">
                        <span class="cv-hero-pill-icon">
                            {{-- Fire / Charcoal icon --}}
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14.5c-2.49 0-4.5-2.01-4.5-4.5S9.51 7.5 12 7.5s4.5 2.01 4.5 4.5-2.01 4.5-4.5 4.5z"/></svg>
                        </span>
                        {{ __('home.hero_pill') }}
                    </span><br>
                    {{ __('home.hero_title_3') }}
                </h1>
                <div class="cv-hero-icons">
                    <div class="cv-hero-icon-circle" title="Export Certified">
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <div class="cv-hero-icon-circle" title="FSC Certified">
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <div class="cv-hero-icon-circle" title="On-Time Delivery">
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                </div>
                <div class="cv-hero-desc">
                    {{ __('home.hero_desc') }}
                </div>
                <div class="cv-hero-actions">
                    <a href="#produk" class="cv-btn-solid">{{ __('home.hero_cta_primary') }}</a>
                    <a href="{{ route_locale('about') }}" class="cv-btn-outline">{{ __('home.hero_cta_secondary') }}</a>
                </div>
            </div>

            {{-- Center Column --}}
            <div class="cv-hero-center">
                @if(isset($heroSlides) && $heroSlides->count() > 0)
                    <div class="swiper hero-swiper">
                        <div class="swiper-wrapper">
                            @foreach($heroSlides as $slide)
                                <div class="swiper-slide hero-swiper-slide">
                                    <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title }}" class="cv-hero-img-main" width="800" height="800" fetchpriority="high">
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination hero-swiper-pagination"></div>
                    </div>
                @elseif(!empty($settings['hero_main_image']))
                    <img src="{{ asset('storage/' . $settings['hero_main_image']) }}" alt="{{ __('home.hero_badge') }}" class="cv-hero-img-main" width="800" height="800" fetchpriority="high">
                @else
                    <img src="{{ asset('images/amn/hero-main.png') }}" alt="Arang Briket Premium PT. Airlangga Merapi Nusantara Surabaya" class="cv-hero-img-main" width="800" height="800" fetchpriority="high">
                @endif
                <div class="cv-glass-badge" style="top:1.5rem;left:1.5rem;">{{ __('home.hero_badge_1') }}</div>
                <div class="cv-glass-badge" style="bottom:7.5rem;left:1.5rem;">{{ __('home.hero_badge_2') }}</div>
                <div class="cv-glass-card">
                    <div class="cv-glass-num">{{ $settings['stat_years'] ?? '10' }}+</div>
                    <div class="cv-glass-text">{{ __('home.hero_stat_label') }}</div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="cv-hero-right">
                <h2 class="cv-hero-r-title">{!! nl2br(e(__('home.hero_right_title'))) !!}</h2>
                <div class="cv-hero-r-desc">{{ __('home.hero_right_desc') }}</div>
                <div class="cv-hero-r-card">
                    @if(!empty($settings['hero_secondary_image']))
                        <img src="{{ asset('storage/' . $settings['hero_secondary_image']) }}" alt="{{ __('home.hero_right_title') }}" class="cv-hero-img-sec" width="600" height="600" loading="lazy">
                    @else
                        <img src="{{ asset('images/amn/hero-secondary.png') }}" alt="Ekspor Arang Briket AMN ke seluruh dunia" class="cv-hero-img-sec" width="600" height="600" loading="lazy">
                    @endif
                    <div class="cv-glass-card" style="bottom:1rem;right:1rem;padding:1rem;">
                        <div class="cv-glass-num" style="font-size:1.5rem;">{{ $settings['stat_clients'] ?? '50' }}+</div>
                        <div class="cv-glass-text">{{ __('home.hero_right_stat_label') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ════ PREMIUM CLIENTS BAR ════ --}}
    @if($clients->count())
        <section class="cv-clients-section">
            <div class="cv-clients-header">
                <span class="cv-clients-label">{{ __('home.clients_label') }}</span>
            </div>

            <div class="cv-marquee-container">
                <div class="cv-marquee-track">
                    {{-- Loop twice to create seamless infinite scroll effect --}}
                    @foreach([1, 2] as $loopGroup)
                        @foreach($clients as $client)
                            @if($client->logo)
                                <div class="cv-client-logo-card">
                                    <img
                                        src="{{ asset('storage/' . $client->logo) }}"
                                        alt="{{ $client->alt_text ?: $client->name }}"
                                        class="cv-client-logo-img"
                                        title="{{ $client->name }}"
                                        loading="lazy"
                                    >
                                </div>
                            @else
                                <div class="cv-client-chip-v2">{{ $client->name }}</div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ════ ABOUT SECTION (PREMIUM 4 CARDS) ════ --}}
    <section class="cv-about-premium section-pad" id="tentang" style="background:#ffffff; color:#0f172a; position:relative; z-index:2;">
        <div class="container">
            {{-- Section Header --}}
            <div style="text-align:center; max-width:800px; margin:0 auto 4rem;">
                <div style="font-size:0.75rem; font-weight:700; letter-spacing:0.15em; text-transform:uppercase; color:#64748b; margin-bottom:1.5rem; display:flex; align-items:center; justify-content:center; gap:0.5rem;">
                    <span style="width:4px; height:4px; background:#0ea5e9; border-radius:50%;"></span>
                    {{ __('home.about_label') }}
                </div>

                {{-- Dynamic Heading with Icons --}}
                <h2 style="font-size:clamp(2rem, 4vw, 3.5rem); font-weight:500; line-height:1.15; letter-spacing:-0.03em; color:#0f172a;" class="about-premium-heading">
                    {!! __('home.about_heading') !!}
                </h2>
            </div>

            {{-- 4 Cards Grid --}}
            <div class="about-cards-grid">

                {{-- Card 1: Light Gray (Keywords pattern) --}}
                <div class="ab-card ab-card-gray" data-aos="fade-up" data-aos-delay="0">
                    <div class="ab-card-bg-pattern">
                        <span class="ab-chip" style="top:10%;left:5%;">{{ __('home.about_c1_chip1') }}</span>
                        <span class="ab-chip" style="top:15%;left:45%;">{{ __('home.about_c1_chip2') }}</span>
                        <span class="ab-chip" style="top:12%;left:80%;">{{ __('home.about_c1_chip3') }}</span>
                        <span class="ab-chip" style="top:35%;left:15%;">{{ __('home.about_c1_chip4') }}</span>
                        <span class="ab-chip" style="top:38%;left:50%;">{{ __('home.about_c1_chip5') }}</span>
                        <span class="ab-chip" style="top:60%;left:5%;">{{ __('home.about_c1_chip6') }}</span>
                        <span class="ab-chip" style="top:65%;left:40%;">{{ __('home.about_c1_chip7') }}</span>
                        <span class="ab-chip" style="top:62%;left:75%;">{{ __('home.about_c1_chip8') }}</span>
                    </div>
                    <div class="ab-card-content">
                        <div class="ab-card-label">{{ __('home.about_c1_label') }}</div>
                        <div class="ab-card-value">{{ __('home.about_c1_value') }}</div>
                    </div>
                </div>

                {{-- Card 2: Solid Accent (Blue) --}}
                <div class="ab-card ab-card-accent" data-aos="fade-up" data-aos-delay="100">
                    <div class="ab-card-content" style="height: 100%; display: flex; flex-direction: column;">
                        <div class="ab-card-label" style="color:rgba(255,255,255,0.9);">{{ __('home.about_c2_label') }}</div>
                        <div class="ab-card-value" style="color:#ffffff;">{{ __('home.about_c2_value') }}</div>
                        <div class="ab-card-desc" style="margin-top:auto; color:rgba(255,255,255,0.9);">
                            {{ __('home.about_c2_desc') }}
                        </div>
                    </div>
                </div>

                {{-- Card 3: Image Background --}}
                <div class="ab-card ab-card-image" data-aos="fade-up" data-aos-delay="200">
                    @if(!empty($settings['about_c3_image']))
                        <img src="{{ asset('storage/' . $settings['about_c3_image']) }}" alt="Ekspor Arang Briket" class="ab-card-img" width="400" height="400" loading="lazy">
                    @else
                        <img src="{{ asset('images/amn/factory.png') }}" alt="Fasilitas Produksi AMN Surabaya" class="ab-card-img" width="400" height="400" loading="lazy">
                    @endif
                    <div class="ab-card-overlay"></div>
                    <div class="ab-card-content" style="position:relative; z-index:2; height:100%; display:flex; flex-direction:column; justify-content:flex-end;">
                        <div class="ab-card-value" style="color:#ffffff; margin-bottom:0.5rem;">{{ __('home.about_c3_value') }}</div>
                        <div class="ab-card-desc" style="color:rgba(255,255,255,0.9);">
                            {{ __('home.about_c3_desc') }}
                        </div>
                    </div>
                </div>

                {{-- Card 4: Light Gray --}}
                <div class="ab-card ab-card-gray" data-aos="fade-up" data-aos-delay="300">
                    <div class="ab-card-content" style="height: 100%; display: flex; flex-direction: column;">
                        <div class="ab-card-label">{{ __('home.about_c4_label') }}</div>
                        <div class="ab-card-value">{{ __('home.about_c4_value') }}</div>
                        <div class="ab-card-desc" style="margin-top:auto;">
                            {{ __('home.about_c4_desc') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
    /* CSS FOR PREMIUM ABOUT SECTION */
    .about-premium-heading {
        /* Style specifically for the heading */
    }
    .about-premium-heading strong {
        font-weight: 600;
    }
    .about-premium-heading .ab-icon-blue,
    .about-premium-heading .ab-icon-green {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1em;
        height: 1em;
        border-radius: 50%;
        vertical-align: middle;
        margin: 0 0.1em;
        transform: translateY(-0.1em);
    }
    .about-premium-heading .ab-icon-blue {
        background: #0ea5e9; /* blue to match hero */
        color: #fff;
        padding: 0.2em;
    }
    .about-premium-heading .ab-icon-green {
        background: #10b981; /* accent color */
        color: #fff;
        padding: 0.2em;
    }

    .about-cards-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }
    @media (min-width: 768px) {
        .about-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 1024px) {
        .about-cards-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .ab-card {
        border-radius: 24px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        min-height: 320px;
        display: flex;
        flex-direction: column;
    }
    .ab-card-gray {
        background: #f1f5f9;
    }
    .ab-card-accent {
        background: #0ea5e9; /* matching hero blue */
    }
    .ab-card-image {
        padding: 2rem;
    }
    .ab-card-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
    }
    .ab-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 60%);
        z-index: 1;
    }

    .ab-card-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #64748b;
        margin-bottom: 1rem;
    }
    .ab-card-value {
        font-size: 3rem;
        font-weight: 400;
        line-height: 1;
        color: #0f172a;
        letter-spacing: -0.05em;
    }
    .ab-card-desc {
        font-size: 0.95rem;
        line-height: 1.5;
        color: #475569;
        font-weight: 400;
    }

    /* Pattern for Card 1 */
    .ab-card-bg-pattern {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        opacity: 0.6;
    }
    .ab-chip {
        position: absolute;
        background: #ffffff;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 600;
        color: #94a3b8;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        white-space: nowrap;
    }
    .ab-card-gray .ab-card-content {
        position: relative;
        z-index: 1;
        margin-top: auto; /* push text to bottom for card 1 */
    }
    </style>

    {{-- ════ PRODUCTS (CATALOG STYLE) ════ --}}
    <style>
        /* ── PRODUCT CATALOG SECTION ─────────────────── */
        .cv-catalog-section {
            background: #F8FAFC;
            padding: 5rem 0;
        }
        .cv-catalog-header {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }
        .cv-catalog-title {
            font-size: clamp(1.75rem, 3.5vw, 3rem);
            font-weight: 500;
            color: #0F172A;
            line-height: 1.15;
            letter-spacing: -0.02em;
            max-width: 420px;
        }
        .cv-catalog-right-info {
            max-width: 260px;
            text-align: right;
        }
        .cv-catalog-right-info p {
            font-size: 0.875rem;
            color: #64748B;
            line-height: 1.6;
            margin-bottom: 0.5rem;
        }
        .cv-catalog-right-info small {
            font-size: 0.75rem;
            color: #94A3B8;
        }

        /* Horizontal scroll track */
        .cv-catalog-track-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            position: relative;
        }
        .cv-catalog-scroll {
            display: grid;
            grid-template-columns: repeat(5, calc(25% - 0.75rem));
            gap: 1rem;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .cv-catalog-scroll::-webkit-scrollbar { display: none; }

        /* Product Card */
        .cv-cat-card {
            scroll-snap-align: start;
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            min-height: 300px;
            text-decoration: none;
            display: block;
            flex-shrink: 0;
            background: #e2e8f0;
            cursor: pointer;
            transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s;
        }
        .cv-cat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(14, 165, 233, 0.15);
        }
        .cv-cat-card img {
            width: 100%; height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
            transition: transform 0.5s ease;
        }
        .cv-cat-card:hover img { transform: scale(1.06); }

        /* Dark gradient overlay at bottom */
        .cv-cat-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.15) 55%, transparent 100%);
            z-index: 1;
        }
        .cv-cat-card-placeholder {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 0.5rem;
            color: #94a3b8;
        }
        .cv-cat-card-body {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 1.25rem;
            z-index: 2;
        }
        .cv-cat-card-name {
            font-size: 0.9375rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }
        .cv-cat-card-spec {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.7);
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }
        .cv-cat-card-spec span {
            background: rgba(14,165,233,0.85);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-weight: 600;
            color: #fff;
        }

        /* Bottom Controls: Button left, Nav arrows right */
        .cv-catalog-footer {
            max-width: 1200px;
            margin: 2rem auto 0;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .cv-catalog-btn-all {
            background: #1E293B;
            color: #fff;
            padding: 0.875rem 2rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }
        .cv-catalog-btn-all:hover {
            background: #0EA5E9;
            transform: translateY(-2px);
        }
        .cv-catalog-nav {
            display: flex;
            gap: 0.5rem;
        }
        .cv-catalog-nav-btn {
            width: 42px; height: 42px;
            border-radius: 50%;
            background: #fff;
            border: 1.5px solid #E2E8F0;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: #334155;
            transition: all 0.2s;
        }
        .cv-catalog-nav-btn:hover {
            background: #0EA5E9;
            border-color: #0EA5E9;
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cv-catalog-scroll { grid-template-columns: repeat(5, 280px); }
        }
        @media (max-width: 640px) {
            .cv-catalog-section { padding: 3.5rem 0; }
            .cv-catalog-header { flex-direction: column; }
            .cv-catalog-right-info { text-align: left; max-width: 100%; }
            .cv-catalog-scroll { grid-template-columns: repeat(5, 80vw); }
            .cv-cat-card { min-height: 260px; }
        }
    </style>

    <section class="cv-catalog-section" id="produk">

        {{-- Header: Title left, description right --}}
        <div class="cv-catalog-header">
            <h2 class="cv-catalog-title">{!! nl2br(e(__('home.catalog_title'))) !!}</h2>
            <div class="cv-catalog-right-info">
                <p>{{ __('home.catalog_desc') }}</p>
                <small>{{ __('home.catalog_note') }}</small>
            </div>
        </div>

        {{-- Cards Track --}}
        <div class="cv-catalog-track-wrapper">
            <div class="cv-catalog-scroll" id="cv-catalog-scroll">
                @php
                    $productData = [
                        ['type' => 'CV-45', 'size' => '18"', 'diameter' => '45 cm', 'capacity' => '52,47', 'slug' => 'cv-45-18'],
                        ['type' => 'CV-60', 'size' => '24"', 'diameter' => '60 cm', 'capacity' => '98,79', 'slug' => 'cv-60-24'],
                        ['type' => 'CV-75', 'size' => '30"', 'diameter' => '75 cm', 'capacity' => '147,95', 'slug' => 'cv-75-30'],
                        ['type' => 'CV-90', 'size' => '36"', 'diameter' => '90 cm', 'capacity' => '215,79', 'slug' => 'cv-90-36'],
                        ['type' => 'CV-105', 'size' => '42"', 'diameter' => '105 cm', 'capacity' => '257,87', 'slug' => 'cv-105-42'],
                    ];
                @endphp

                @if($products->count())
                    @foreach($products as $i => $product)
                        @php $pd = $productData[$i] ?? ['type' => 'CV', 'size' => '', 'diameter' => '', 'capacity' => '', 'slug' => $product->slug]; @endphp
                        <a href="{{ route_locale('products.show', $product->slug) }}" class="cv-cat-card">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="cv-cat-card-placeholder">
                                    <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    <span style="font-size:.7rem;">Upload di Admin</span>
                                </div>
                            @endif
                            <div class="cv-cat-card-overlay"></div>
                            <div class="cv-cat-card-body">
                                <div class="cv-cat-card-name">{{ $product->name }}</div>
                                <div class="cv-cat-card-spec">
                                    <span>{{ $pd['type'] }}</span>
                                    Ø {{ $pd['diameter'] }} — {{ $pd['capacity'] }} m³/mnt
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    @foreach($productData as $i => $pd)
                        <a href="{{ route_locale('products') }}" class="cv-cat-card">
                            <div class="cv-cat-card-placeholder">
                                <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <span style="font-size:.7rem;">Upload di Admin</span>
                            </div>
                            <div class="cv-cat-card-overlay"></div>
                            <div class="cv-cat-card-body">
                                <div class="cv-cat-card-name">Turbine Ventilator {{ $pd['type'] }}</div>
                                <div class="cv-cat-card-spec">
                                    <span>{{ $pd['type'] }}</span>
                                    Ø {{ $pd['diameter'] }} — {{ $pd['capacity'] }} m³/mnt
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Footer: Button left, Arrows right --}}
        <div class="cv-catalog-footer">
            <a href="{{ route_locale('products') }}" class="cv-catalog-btn-all">
                {{ __('home.catalog_btn_all') }}
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            <div class="cv-catalog-nav">
                <button class="cv-catalog-nav-btn" id="cv-scroll-prev" aria-label="Sebelumnya">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <button class="cv-catalog-nav-btn" id="cv-scroll-next" aria-label="Berikutnya">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        </div>
    </section>

    <script>
    (function() {
        var track = document.getElementById('cv-catalog-scroll');
        var prev = document.getElementById('cv-scroll-prev');
        var next = document.getElementById('cv-scroll-next');
        if (!track || !prev || !next) return;
        var scrollAmt = function() {
            var card = track.querySelector('.cv-cat-card');
            return card ? card.offsetWidth + 16 : 260;
        };
        next.addEventListener('click', function() { track.scrollBy({ left: scrollAmt(), behavior: 'smooth' }); });
        prev.addEventListener('click', function() { track.scrollBy({ left: -scrollAmt(), behavior: 'smooth' }); });
    })();
    </script>


    {{-- ════ ADVANTAGES (PREMIUM REDESIGN) ════ --}}
    <style>
    /* ── KEUNGGULAN ───────────────────────────── */
    .cv-adv-premium {
        background: #ffffff;
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
    }
    .cv-adv-premium::before {
        content: '';
        position: absolute;
        top: -200px; right: -200px;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(14,165,233,0.04) 0%, transparent 70%);
        pointer-events: none;
    }
    .cv-adv-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    /* Header row: label + title left, CTA right */
    .cv-adv-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 2rem;
        margin-bottom: 3.5rem;
        flex-wrap: wrap;
    }
    .cv-adv-section-label {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #64748B;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .cv-adv-section-label::before {
        content: '';
        width: 4px; height: 4px;
        border-radius: 50%;
        background: #0EA5E9;
    }
    .cv-adv-section-title {
        font-size: clamp(2rem, 3.5vw, 3rem);
        font-weight: 500;
        color: #0F172A;
        line-height: 1.15;
        letter-spacing: -0.025em;
    }

    /* Premium 7-card grid — matches about section */
    .cv-adv-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }
    /* Special first card: full-height accent (like about card-2) */
    .cv-adv-card-v2 {
        background: #F1F5F9;
        border-radius: 22px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 240px;
        transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s;
    }
    .cv-adv-card-v2:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(14,165,233,0.1);
    }
    .cv-adv-card-v2.accent {
        background: #0EA5E9;
    }
    .cv-adv-card-v2.accent-dark {
        background: #0F172A;
    }
    .cv-adv-card-icon-wrap {
        width: 48px; height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        flex-shrink: 0;
    }
    .cv-adv-card-icon-wrap.blue-bg { background: #E0F2FE; color: #0EA5E9; }
    .cv-adv-card-icon-wrap.white-bg { background: rgba(255,255,255,0.2); color: #fff; }
    .cv-adv-card-icon-wrap.dark-bg { background: rgba(255,255,255,0.06); color: #38BDF8; }
    .cv-adv-card-num {
        font-size: 2.75rem;
        font-weight: 400;
        line-height: 1;
        letter-spacing: -0.04em;
        color: #0F172A;
        margin-bottom: 0.5rem;
    }
    .cv-adv-card-num.white { color: #fff; }
    .cv-adv-card-num.blue { color: #38BDF8; }
    .cv-adv-card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #0F172A;
        margin-bottom: 0.5rem;
    }
    .cv-adv-card-title.white { color: #fff; }
    .cv-adv-card-title.light { color: rgba(255,255,255,0.9); }
    .cv-adv-card-desc {
        font-size: 0.8125rem;
        line-height: 1.65;
        color: #64748B;
        margin-top: auto;
    }
    .cv-adv-card-desc.white { color: rgba(255,255,255,0.75); }

    /* Responsive */
    @media (max-width: 1024px) { .cv-adv-cards { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .cv-adv-premium { padding: 3.5rem 0; }
        .cv-adv-cards { 
            grid-template-columns: none !important;
            grid-auto-flow: column;
            grid-auto-columns: 78vw;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-bottom: 1.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            gap: 1rem;
        }
        .cv-adv-cards::-webkit-scrollbar { display: none; }
        .cv-adv-cards > * { scroll-snap-align: start; }
        .cv-adv-card-v2 { min-height: 180px; }
        .cv-adv-card-span-2 { 
            grid-column: auto !important; 
            flex-direction: column !important; 
            align-items: flex-start !important; 
        }
    }

    /* ── APLIKASI ─────────────────────────────── */
    .cv-apps-premium {
        background: #F8FAFC;
        padding: 5rem 0;
    }
    .cv-apps-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    .cv-apps-header {
        max-width: 600px;
        margin-bottom: 3rem;
    }
    /* Horizontal scroll row of app cards */
    .cv-apps-grid-v2 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }
    .cv-app-card-v2 {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
        overflow: hidden;
    }
    .cv-app-img-wrapper-v2 {
        width: 100%;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #F8FAFC;
    }
    .cv-app-img-wrapper-v2 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .cv-app-card-v2:hover .cv-app-img-wrapper-v2 img { transform: scale(1.05); }
    .cv-app-card-body-v2 {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        flex: 1;
    }
    .cv-app-card-v2:hover {
        border-color: #0EA5E9;
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(14,165,233,0.1);
    }
    .cv-app-icon-circle {
        width: 50px; height: 50px;
        background: #F0F9FF;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0EA5E9;
        flex-shrink: 0;
        transition: all 0.3s;
    }
    .cv-app-card-v2:hover .cv-app-icon-circle {
        background: #0EA5E9;
        color: #fff;
    }
    .cv-app-card-title-v2 {
        font-size: 1.05rem;
        font-weight: 600;
        color: #0F172A;
        margin: 0;
    }
    .cv-app-card-desc-v2 {
        font-size: 0.8125rem;
        color: #64748B;
        line-height: 1.65;
        margin: 0;
    }
    
    @media (max-width: 1024px) { .cv-apps-grid-v2 { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .cv-apps-premium { padding: 3.5rem 0; }
        .cv-apps-grid-v2 { 
            grid-template-columns: none !important;
            grid-auto-flow: column;
            grid-auto-columns: 78vw;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-bottom: 1.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            gap: 1rem;
        }
        .cv-apps-grid-v2::-webkit-scrollbar { display: none; }
        .cv-apps-grid-v2 > * { scroll-snap-align: start; }
    }
    </style>

    <section class="cv-adv-premium" id="keunggulan">
        <div class="cv-adv-inner">
            {{-- Section Header --}}
            <div class="cv-adv-header">
                <div>
                    <div class="cv-adv-section-label">{{ __('home.adv_label') }}</div>
                    <h2 class="cv-adv-section-title">{!! nl2br(e(__('home.adv_title'))) !!}</h2>
                </div>
                <p style="max-width:320px;font-size:0.875rem;color:#64748B;line-height:1.65;text-align:right;">
                    {{ __('home.adv_subtitle') }}
                </p>
            </div>

            {{-- Premium Cards Grid --}}
            <div class="cv-adv-cards">

                {{-- Card 1: Export Countries — Blue Accent --}}
                <div class="cv-adv-card-v2 accent" data-aos="fade-up" data-aos-delay="0">
                    <div class="cv-adv-card-icon-wrap white-bg">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                    </div>
                    <div class="cv-adv-card-num white">{{ __('home.adv_c1_num') }}</div>
                    <div class="cv-adv-card-title white">{{ __('home.adv_c1_title') }}</div>
                    <div class="cv-adv-card-desc white">{{ __('home.adv_c1_desc') }}</div>
                </div>

                {{-- Card 2: Premium Grade --}}
                <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="80">
                    <div class="cv-adv-card-icon-wrap blue-bg">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <div class="cv-adv-card-num">{{ __('home.adv_c2_num') }}</div>
                    <div class="cv-adv-card-title">{{ __('home.adv_c2_title') }}</div>
                    <div class="cv-adv-card-desc">{{ __('home.adv_c2_desc') }}</div>
                </div>

                {{-- Card 3: 24/7 Support --}}
                <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="160">
                    <div class="cv-adv-card-icon-wrap blue-bg">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="cv-adv-card-num">{{ __('home.adv_c3_num') }}</div>
                    <div class="cv-adv-card-title">{{ __('home.adv_c3_title') }}</div>
                    <div class="cv-adv-card-desc">{{ __('home.adv_c3_desc') }}</div>
                </div>

                {{-- Card 4: Production Capacity — Dark --}}
                <div class="cv-adv-card-v2 accent-dark" data-aos="fade-up" data-aos-delay="240">
                    <div class="cv-adv-card-icon-wrap dark-bg">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <div class="cv-adv-card-num blue">{{ __('home.adv_c4_num') }}</div>
                    <div class="cv-adv-card-title light">{{ __('home.adv_c4_title') }}</div>
                    <div class="cv-adv-card-desc white">{{ __('home.adv_c4_desc') }}</div>
                </div>

                {{-- Card 5: Eco-Friendly --}}
                <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="0">
                    <div class="cv-adv-card-icon-wrap blue-bg">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 1 10 10c0 5.52-4.48 10-10 10S2 17.52 2 12c0-2.76 1.12-5.26 2.93-7.07M12 2v10"/></svg>
                    </div>
                    <div class="cv-adv-card-title" style="margin-top:auto;">{{ __('home.adv_c5_title') }}</div>
                    <div class="cv-adv-card-desc">{{ __('home.adv_c5_desc') }}</div>
                </div>

                {{-- Card 6: On-Time Delivery --}}
                <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="80">
                    <div class="cv-adv-card-icon-wrap blue-bg">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="cv-adv-card-title" style="margin-top:auto;">{{ __('home.adv_c6_title') }}</div>
                    <div class="cv-adv-card-desc">{{ __('home.adv_c6_desc') }}</div>
                </div>

                {{-- Card 7: International Certifications — spans 2 columns --}}
                <div class="cv-adv-card-v2 cv-adv-card-span-2" data-aos="fade-up" data-aos-delay="160" style="grid-column: span 2; flex-direction: row; gap: 2rem; align-items: center;">
                    <div class="cv-adv-card-icon-wrap blue-bg" style="flex-shrink:0; width:60px; height:60px;">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div>
                        <div class="cv-adv-card-title" style="font-size:1.125rem; margin-bottom:0.5rem;">{{ __('home.adv_c7_title') }}</div>
                        <div class="cv-adv-card-desc">{{ __('home.adv_c7_desc') }}</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ════ APPLICATIONS (PREMIUM REDESIGN) ════ --}}
    <section class="cv-apps-premium" id="pasar-ekspor">
        <div class="cv-apps-inner">
            <div class="cv-apps-header">
                <div class="cv-adv-section-label">{{ __('home.apps_label') }}</div>
                <h2 class="cv-adv-section-title" style="margin-top:0.75rem;">{!! nl2br(e(__('home.apps_title'))) !!}</h2>
                <p style="margin-top:1rem;font-size:0.875rem;color:#64748B;line-height:1.65;">
                    {{ __('home.apps_desc') }}
                </p>
            </div>

            <div class="cv-apps-grid-v2">
                @php
                    $apps = [
                        [
                            'title' => __('home.app1_title'),
                            'desc'  => __('home.app1_desc'),
                            'icon'  => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
                            'img'   => !empty($settings['app_img_asia']) ? asset('storage/'.$settings['app_img_asia']) : asset('images/amn/quality-lab.png')
                        ],
                        [
                            'title' => __('home.app2_title'),
                            'desc'  => __('home.app2_desc'),
                            'icon'  => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
                            'img'   => !empty($settings['app_img_middleeast']) ? asset('storage/'.$settings['app_img_middleeast']) : asset('images/amn/hero-secondary.png')
                        ],
                        [
                            'title' => __('home.app3_title'),
                            'desc'  => __('home.app3_desc'),
                            'icon'  => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
                            'img'   => !empty($settings['app_img_europe']) ? asset('storage/'.$settings['app_img_europe']) : asset('images/amn/factory.png')
                        ],
                        [
                            'title' => __('home.app4_title'),
                            'desc'  => __('home.app4_desc'),
                            'icon'  => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
                            'img'   => !empty($settings['app_img_america']) ? asset('storage/'.$settings['app_img_america']) : asset('images/amn/product.png')
                        ],
                    ];
                @endphp
                @foreach($apps as $i => $app)
                    <div class="cv-app-card-v2" data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
                        <div class="cv-app-img-wrapper-v2">
                            <img src="{{ $app['img'] }}" alt="{{ $app['title'] }} - PT. Airlangga Merapi Nusantara" loading="lazy">
                        </div>
                        <div class="cv-app-card-body-v2">
                            <div style="display:flex; align-items:center; gap:1rem;">
                                <div class="cv-app-icon-circle">{!! $app['icon'] !!}</div>
                                <h3 class="cv-app-card-title-v2">{{ $app['title'] }}</h3>
                            </div>
                            <p class="cv-app-card-desc-v2">{{ $app['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ════ PREMIUM GALLERY & TESTIMONIALS CSS ════ --}}
    <style>
    /* ── GALERI ─────────────────────────────── */
    .cv-gallery-premium {
        background: #ffffff;
        padding: 5rem 0;
    }
    .cv-gallery-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    .cv-gallery-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 2rem;
        margin-bottom: 3.5rem;
        flex-wrap: wrap;
    }
    .cv-gallery-grid-v2 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }
    .cv-gallery-card-v2 {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        aspect-ratio: 4/3;
        display: block;
        background: #F1F5F9;
    }
    .cv-gallery-img-v2 {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.22,1,0.36,1);
    }
    .cv-gallery-card-v2:hover .cv-gallery-img-v2 {
        transform: scale(1.08);
    }
    .cv-gallery-overlay-v2 {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15,23,42,0.85) 0%, rgba(15,23,42,0) 60%);
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
        transition: background 0.3s;
    }
    .cv-gallery-card-v2:hover .cv-gallery-overlay-v2 {
        background: linear-gradient(to top, rgba(14,165,233,0.9) 0%, rgba(15,23,42,0) 70%);
    }
    .cv-gallery-meta-v2 {
        color: #fff;
        transform: translateY(10px);
        transition: transform 0.3s cubic-bezier(0.22,1,0.36,1);
    }
    .cv-gallery-card-v2:hover .cv-gallery-meta-v2 {
        transform: translateY(0);
    }
    .cv-gallery-title-v2 {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .cv-gallery-client-v2 {
        font-size: 0.8125rem;
        color: rgba(255,255,255,0.75);
    }

    /* ── TESTIMONI ──────────────────────────── */
    .cv-testi-premium {
        background: #F8FAFC;
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
    }
    .cv-testi-premium::before {
        content: '';
        position: absolute;
        bottom: -200px; left: -200px;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(14,165,233,0.04) 0%, transparent 70%);
        pointer-events: none;
    }
    .cv-testi-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    .cv-testi-grid-v2 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }
    .cv-testi-card-v2 {
        background: #ffffff;
        border: 1.5px solid #E2E8F0;
        border-radius: 20px;
        padding: 2.25rem;
        position: relative;
        transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
    }
    .cv-testi-card-v2:hover {
        border-color: #0EA5E9;
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(14,165,233,0.1);
    }
    .cv-testi-quote-icon {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        color: #F1F5F9;
        width: 48px;
        height: 48px;
        transition: color 0.3s;
    }
    .cv-testi-card-v2:hover .cv-testi-quote-icon {
        color: #E0F2FE;
    }
    .cv-testi-stars-v2 {
        display: flex;
        gap: 0.25rem;
        color: #F59E0B;
        margin-bottom: 1.25rem;
    }
    .cv-testi-text-v2 {
        font-size: 0.9375rem;
        line-height: 1.7;
        color: #475569;
        margin-bottom: 2rem;
        position: relative;
        z-index: 1;
    }
    .cv-testi-author-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        border-top: 1px solid #F1F5F9;
        padding-top: 1.25rem;
    }
    .cv-testi-avatar-v2 {
        width: 44px; height: 44px;
        border-radius: 50%;
        background: #F1F5F9;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        font-weight: 600;
        object-fit: cover;
    }
    .cv-testi-name-v2 {
        font-size: 0.9375rem;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 0.15rem;
    }
    .cv-testi-pos-v2 {
        font-size: 0.75rem;
        color: #64748B;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .cv-gallery-grid-v2 { grid-template-columns: repeat(2, 1fr); }
        .cv-testi-grid-v2 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .cv-gallery-premium, .cv-testi-premium { padding: 3.5rem 0; }
        .cv-gallery-grid-v2, .cv-testi-grid-v2 { 
            grid-template-columns: none !important;
            grid-auto-flow: column;
            grid-auto-columns: 78vw;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-bottom: 1.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            gap: 1rem;
        }
        .cv-gallery-grid-v2::-webkit-scrollbar, .cv-testi-grid-v2::-webkit-scrollbar { display: none; }
        .cv-gallery-grid-v2 > *, .cv-testi-grid-v2 > * { scroll-snap-align: start; }
    }
    </style>

    {{-- ════ GALLERY PREVIEW (PREMIUM) ════ --}}
    @if($gallery->count())
        <section class="cv-gallery-premium" id="galeri">
            <div class="cv-gallery-inner">
                <div class="cv-gallery-header">
                    <div>
                        <div class="cv-adv-section-label">{{ __('home.gallery_label') }}</div>
                        <h2 class="cv-adv-section-title" style="margin-top:0.75rem;">{!! nl2br(e(__('home.gallery_title'))) !!}</h2>
                    </div>
                    <a href="{{ route_locale('gallery') }}" class="btn-ghost" style="color:#0F172A; border-color:#E2E8F0; background:#F8FAFC;">
                        {{ __('home.gallery_link') }}
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </div>

                <div class="cv-gallery-grid-v2">
                    @foreach($gallery->take(6) as $item)
                        <a href="{{ asset('storage/' . $item->image) }}" class="cv-gallery-card-v2 glightbox" data-gallery="home-gallery" data-title="{{ $item->title }}" data-description="{{ $item->client }}">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->alt_text ?? $item->title }}" class="cv-gallery-img-v2" loading="lazy">
                            @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;color:#94A3B8;">
                                    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    <span style="font-size:0.7rem;margin-top:0.5rem;">Upload Foto</span>
                                </div>
                            @endif
                            <div class="cv-gallery-overlay-v2">
                                <div class="cv-gallery-meta-v2">
                                    <div class="cv-gallery-title-v2">{{ $item->title }}</div>
                                    @if($item->client)<div class="cv-gallery-client-v2">{{ $item->client }}</div>@endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ════ TESTIMONIALS (PREMIUM) ════ --}}
    @include('components.testimonials')

    {{-- ════ PREMIUM COVERAGE CSS ════ --}}
    <style>
    .cv-coverage-premium {
        background: #EAEBED;
        padding: 6rem 0 0;
        position: relative;
    }
    .cv-coverage-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
        position: relative;
        z-index: 2;
    }
    .cv-coverage-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
        margin-bottom: 3rem;
    }
    .cv-coverage-title-v2 {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 600;
        color: #0F172A;
        line-height: 1.1;
        letter-spacing: -0.04em;
        flex-shrink: 0;
        min-width: 220px;
    }
    .cv-coverage-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        flex: 1;
    }
    .cv-stat-card-v2 {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        transition: transform 0.3s;
    }
    .cv-stat-card-v2:hover {
        transform: translateY(-5px);
    }
    .cv-stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    .cv-stat-label {
        font-size: 0.65rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .cv-stat-icon {
        color: #0F172A;
        opacity: 0.8;
    }
    .cv-stat-val {
        font-size: 4rem;
        font-weight: 400;
        color: #0EA5E9;
        line-height: 1;
        letter-spacing: -0.05em;
        display: flex;
        align-items: baseline;
        gap: 0.1em;
    }
    .cv-stat-val span {
        color: #0EA5E9;
        font-size: 2rem;
        font-weight: 600;
        line-height: 1;
    }

    /* Abstract Map BG */
    .cv-coverage-map-bg {
        position: absolute;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120%;
        min-width: 1000px;
        opacity: 0.6;
        z-index: 1;
        pointer-events: none;
    }

    /* Glassmorphism Bottom Box */
    .cv-coverage-glass-box {
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.7);
        border-radius: 24px;
        padding: 3rem;
        margin-top: 8rem;
    }
    .cv-glass-box-title {
        font-size: 2.2rem;
        font-weight: 500;
        color: #0F172A;
        margin-bottom: 2rem;
        letter-spacing: -0.04em;
    }
    .cv-cities-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }
    .cv-city-item {
        font-size: 0.9rem;
        color: #1E293B;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .cv-city-item::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: transparent;
        border: 1.5px solid #94A3B8;
    }
    .cv-city-item.active::before {
        background: #0EA5E9;
        border-color: #0EA5E9;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .cv-coverage-header-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 2rem;
        }
    }
    @media (max-width: 1024px) {
        .cv-coverage-stats-grid { grid-template-columns: repeat(2, 1fr); }
        .cv-cities-grid { grid-template-columns: repeat(3, 1fr); }
        .cv-coverage-glass-box { margin-top: 4rem; }
    }
    @media (max-width: 640px) {
        .cv-coverage-premium { padding: 4rem 0; }
        .cv-coverage-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
        .cv-stat-card-v2 { padding: 1.25rem; }
        .cv-stat-val { font-size: 2.5rem; }
        .cv-stat-val span { font-size: 1.5rem; }
        .cv-cities-grid { grid-template-columns: repeat(2, 1fr); }
        .cv-coverage-glass-box { padding: 2rem 1.5rem; margin-top: 3rem; }
    }
    .cv-coverage-map-wrapper {
        position: relative;
        width: 100%;
        margin-top: -6rem;
    }
    @media (max-width: 1024px) {
        .cv-coverage-map-wrapper { margin-top: -2rem; }
    }
    @media (max-width: 640px) {
        .cv-coverage-map-wrapper { margin-top: 1rem; }
    }
    </style>

    {{-- ════ COVERAGE (PREMIUM REDESIGN) ════ --}}
    <section class="cv-coverage-premium" id="jangkauan">


        <style>
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.5); opacity: 0; }
            100% { transform: scale(1); opacity: 0; }
        }
        </style>

        <div class="cv-coverage-inner">
            <div class="cv-coverage-header-row">
                <h2 class="cv-coverage-title-v2">{!! nl2br(e(__('home.apps_title'))) !!}</h2>

                <div class="cv-coverage-stats-grid">
                    {{-- Card 1: Years --}}
                    <div class="cv-stat-card-v2" data-aos="fade-up" data-aos-delay="0">
                        <div class="cv-stat-top">
                            <span class="cv-stat-label">{{ __('home.about_c1_label') }}</span>
                            <svg class="cv-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 22h20M12 2v20M5 22V10l7-8 7 8v12M8 14h8M8 18h8"/></svg>
                        </div>
                        <div class="cv-stat-val"><span class="count-up" data-target="10">0</span><span>+</span></div>
                    </div>

                    {{-- Card 2: Export Countries --}}
                    <div class="cv-stat-card-v2" data-aos="fade-up" data-aos-delay="100">
                        <div class="cv-stat-top">
                            <span class="cv-stat-label">{{ __('home.adv_c1_title') }}</span>
                            <svg class="cv-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <div class="cv-stat-val"><span class="count-up" data-target="50">0</span><span>+</span></div>
                    </div>

                    {{-- Card 3: Production Capacity --}}
                    <div class="cv-stat-card-v2" data-aos="fade-up" data-aos-delay="200">
                        <div class="cv-stat-top">
                            <span class="cv-stat-label">{{ __('home.adv_c4_title') }}</span>
                            <svg class="cv-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        </div>
                        <div class="cv-stat-val"><span class="count-up" data-target="1000">0</span><span>+</span></div>
                    </div>

                    {{-- Card 4: Certifications --}}
                    <div class="cv-stat-card-v2" data-aos="fade-up" data-aos-delay="300">
                        <div class="cv-stat-top">
                            <span class="cv-stat-label">Sertifikasi</span>
                            <svg class="cv-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <div class="cv-stat-val"><span class="count-up" data-target="8">0</span><span>+</span></div>
                    </div>
                </div>
            </div>

        {{-- MAP: from admin upload --}}
        @php $coverageMap = \App\Models\Setting::get('coverage_map'); @endphp
        @if($coverageMap)
            <div class="cv-coverage-map-wrapper">
                <img src="{{ asset('storage/'.$coverageMap) }}" alt="Peta Jangkauan Indonesia"
                     style="display:block; width:100%; height:auto;" loading="lazy">
            </div>
        @endif

        </div>{{-- end cv-coverage-inner --}}
        
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.count-up');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
                        const el = entry.target;
                        if (el.classList.contains('counted')) return;
                        el.classList.add('counted');
                        const target = +el.getAttribute('data-target');
                        const duration = 2000;
                        const frameRate = 30;
                        const totalFrames = Math.round((duration / 1000) * frameRate);
                        let frame = 0;
                        const counter = setInterval(() => {
                            frame++;
                            const progress = frame / totalFrames;
                            // Ease out quad
                            const easeOut = progress * (2 - progress);
                            const current = Math.round(target * easeOut);
                            el.innerText = current;
                            if (frame === totalFrames) {
                                clearInterval(counter);
                                el.innerText = target;
                            }
                        }, 1000 / frameRate);
                    }
                });
            }, { threshold: 0.5 });
            
            counters.forEach(c => observer.observe(c));
        });
        </script>
    </section>

    {{-- ════ PREMIUM CTA & ARTICLES CSS ════ --}}
    <style>
    /* ── CTA PREMIUM ────────────────────────── */
    .cv-cta-premium {
        background: #0F172A;
        position: relative;
        overflow: hidden;
        padding: 6rem 0;
        color: #ffffff;
    }
    .cv-cta-bg-glow {
        position: absolute;
        width: 800px;
        height: 800px;
        background: radial-gradient(circle, rgba(14,165,233,0.15) 0%, transparent 60%);
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }
    .cv-cta-inner-v2 {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        padding: 0 1.5rem;
    }
    .cv-cta-title-v2 {
        font-size: clamp(2rem, 4vw, 3.5rem);
        font-weight: 500;
        letter-spacing: -0.03em;
        line-height: 1.15;
        margin-bottom: 1.5rem;
        color: #ffffff !important;
    }
    .cv-cta-desc-v2 {
        font-size: 1.125rem;
        color: rgba(255,255,255,0.7);
        line-height: 1.6;
        margin-bottom: 3rem;
    }
    .cv-cta-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .cv-cta-btn-primary {
        background: #0EA5E9;
        color: #ffffff;
        padding: 1.125rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s;
        box-shadow: 0 10px 25px rgba(14,165,233,0.3);
        text-decoration: none !important;
    }
    .cv-cta-btn-primary:hover {
        background: #0284C7;
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(14,165,233,0.4);
    }
    .cv-cta-btn-outline {
        background: transparent;
        color: #ffffff;
        border: 1.5px solid rgba(255,255,255,0.3);
        padding: 1.125rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s;
        text-decoration: none !important;
    }
    .cv-cta-btn-outline:hover {
        border-color: #ffffff;
        background: rgba(255,255,255,0.1);
        transform: translateY(-3px);
    }
    .cv-cta-info {
        margin-top: 4rem;
        display: flex;
        justify-content: center;
        gap: 3rem;
        flex-wrap: wrap;
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 3rem;
    }
    .cv-cta-info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: rgba(255,255,255,0.6);
        font-size: 0.875rem;
    }
    .cv-cta-info-icon {
        color: #0EA5E9;
    }

    /* ── ARTIKEL PREMIUM ────────────────────── */
    .cv-articles-premium {
        background: #ffffff;
        padding: 6rem 0;
    }
    .cv-articles-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    .cv-articles-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 2rem;
        margin-bottom: 3.5rem;
        flex-wrap: wrap;
    }
    .cv-articles-grid-v2 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }
    .cv-article-card-v2 {
        background: #F8FAFC;
        border: 1.5px solid #E2E8F0;
        border-radius: 24px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
        text-decoration: none !important;
    }
    .cv-article-card-v2 * {
        text-decoration: none !important;
    }
    .cv-article-card-v2:hover {
        border-color: #0EA5E9;
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(14,165,233,0.08);
    }
    .cv-article-img-wrap {
        width: 100%;
        aspect-ratio: 16/10;
        overflow: hidden;
        position: relative;
    }
    .cv-article-img-v2 {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.22,1,0.36,1);
    }
    .cv-article-card-v2:hover .cv-article-img-v2 {
        transform: scale(1.08);
    }
    .cv-article-cat-badge {
        position: absolute;
        top: 1.25rem; left: 1.25rem;
        background: rgba(15,23,42,0.85);
        backdrop-filter: blur(8px);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.4rem 1rem;
        border-radius: 50px;
    }
    .cv-article-content-v2 {
        padding: 1.75rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .cv-article-title-v2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0F172A !important;
        line-height: 1.4;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cv-article-excerpt-v2 {
        font-size: 0.9375rem;
        color: #64748B !important;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }
    .cv-article-meta-v2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #E2E8F0;
        padding-top: 1.25rem;
        font-size: 0.8125rem;
        font-weight: 600;
    }
    .cv-article-date-v2 {
        color: #94A3B8;
    }
    .cv-article-read-v2 {
        color: #0EA5E9;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .cv-article-read-v2 svg {
        transition: transform 0.3s;
    }
    .cv-article-card-v2:hover .cv-article-read-v2 svg {
        transform: translateX(4px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .cv-articles-grid-v2 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .cv-cta-premium, .cv-articles-premium { padding: 4rem 0; }
        .cv-cta-info { gap: 1.5rem; flex-direction: column; align-items: center; }
        .cv-articles-grid-v2 { 
            grid-template-columns: none !important;
            grid-auto-flow: column;
            grid-auto-columns: 78vw;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-bottom: 1.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            gap: 1rem;
        }
        .cv-articles-grid-v2::-webkit-scrollbar { display: none; }
        .cv-articles-grid-v2 > * { scroll-snap-align: start; }
    }
    </style>

    {{-- ════ CTA STRIP (PREMIUM) ════ --}}
    <section class="cv-cta-premium">
        <div class="cv-cta-bg-glow"></div>
        <div class="cv-cta-inner-v2" data-aos="zoom-in">
            <div style="font-size:0.75rem; font-weight:700; letter-spacing:0.15em; text-transform:uppercase; color:#38BDF8; margin-bottom:1rem; display:flex; align-items:center; justify-content:center; gap:0.5rem;">
                <span style="width:4px; height:4px; background:#38BDF8; border-radius:50%;"></span>
                {{ __('home.cta_title') }}
            </div>
            <h2 class="cv-cta-title-v2" style="margin-top:1rem;">{!! nl2br(e(__('home.cta_title'))) !!}</h2>
            <p class="cv-cta-desc-v2">{{ __('home.cta_desc') }}</p>
            
            <div class="cv-cta-buttons">
                @if($wa)
                    <a href="javascript:void(0)" onclick="openOrderModal('Bottom CTA WA')"
                       class="cv-cta-btn-primary" data-track="Bottom CTA WA">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ __('home.cta_btn_wa') }}
                    </a>
                @endif
                <a href="{{ route_locale('contact') }}" class="cv-cta-btn-outline">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                    {{ __('home.cta_btn') }}
                </a>
            </div>
            
            <div class="cv-cta-info">
                <div class="cv-cta-info-item">
                    <svg class="cv-cta-info-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.5 12.05a19.79 19.79 0 01-3.07-8.67A2 2 0 012.41 1.5h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 9.4a16 16 0 006.69 6.69l1.27-.76a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    {{ $settings['phone'] ?? '+62 31-XXXX-XXXX' }}
                </div>
                <div class="cv-cta-info-item">
                    <svg class="cv-cta-info-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $settings['office_hours'] ?? 'Senin–Jumat 08.00–17.00 WIB' }}
                </div>
                <div class="cv-cta-info-item">
                    <svg class="cv-cta-info-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $settings['address'] ?? 'Surabaya, Jawa Timur, Indonesia' }}
                </div>
            </div>
        </div>
    </section>


    {{-- ════ ARTICLES (PREMIUM) ════ --}}
    @if($articles->count())
        <section class="cv-articles-premium" id="artikel">
            <div class="cv-articles-inner">
                <div class="cv-articles-header">
                    <div>
                        <div style="font-size:0.75rem; font-weight:700; letter-spacing:0.15em; text-transform:uppercase; color:#64748b; margin-bottom:1.5rem; display:flex; align-items:center; gap:0.5rem;">
                            <span style="width:4px; height:4px; background:#0ea5e9; border-radius:50%;"></span>
                            ARTIKEL &amp; TIPS
                        </div>
                        <h2 style="font-size:clamp(2rem, 4vw, 3.5rem); font-weight:500; line-height:1.15; letter-spacing:-0.03em; color:#0f172a !important; margin-top:0; margin-bottom:0;">
                            Panduan Ventilasi Udara
                        </h2>
                    </div>
                    <a href="{{ route_locale('articles') }}" class="btn-ghost" style="color:#0F172A !important; border-color:#E2E8F0; background:#F8FAFC; text-decoration:none !important;">
                        Semua Artikel 
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </div>

                <div class="cv-articles-grid-v2">
                    @foreach($articles as $i => $article)
                        <a href="{{ route_locale('articles.show', $article->slug) }}" class="cv-article-card-v2" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                            <div class="cv-article-img-wrap">
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="cv-article-img-v2" loading="lazy">
                                @else
                                    <div style="width:100%;height:100%;background:#E2E8F0;display:flex;align-items:center;justify-content:center;flex-direction:column;color:#94A3B8;">
                                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                        <span style="font-size:0.75rem;margin-top:0.5rem;font-weight:600;">Artikel AMN</span>
                                    </div>
                                @endif
                                <div class="cv-article-cat-badge">{{ $article->category ?? __('home.articles_label') }}</div>
                            </div>
                            
                            <div class="cv-article-content-v2">
                                <h3 class="cv-article-title-v2">{{ $article->title }}</h3>
                                <p class="cv-article-excerpt-v2">{{ $article->excerpt }}</p>
                                
                                <div class="cv-article-meta-v2">
                                    <span class="cv-article-date-v2">{{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}</span>
                                    <span class="cv-article-read-v2">
                                        {{ __('articles.read_more', [], null) ?: 'Baca' }}
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@include('components.lightbox-assets')

<script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(document.querySelector('.hero-swiper')) {
            new Swiper('.hero-swiper', {
                loop: true,
                effect: 'fade',
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.hero-swiper-pagination',
                    clickable: true,
                },
            });
        }
    });
</script>

@endsection
