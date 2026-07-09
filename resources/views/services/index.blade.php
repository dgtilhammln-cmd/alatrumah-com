@extends('layouts.app')
@section('content')

<style>
    /* ═══════════════════════════════════════
       DESIGN TOKENS — Premium Light (About Section Style)
    ═══════════════════════════════════════ */
    :root {
        --c-bg:      #ffffff;
        --c-surface: #F8FAFC;
        --c-card:    #ffffff;
        --c-border:  #E2E8F0;
        --c-text:    #0F172A;
        --c-muted:   #64748B;
        --c-accent:  #0EA5E9;
        --c-accent-hover: #0284C7;
        --c-white:   #ffffff;
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 24px;
        --font:      'Montserrat', sans-serif;
        --ease:      cubic-bezier(0.22, 1, 0.36, 1);
    }

    body {
        background-color: var(--c-bg);
    }

    /* ═══════════════════════════════════════
       PAGE HERO
    ═══════════════════════════════════════ */
    .sv-hero-premium {
        position: relative;
        padding: 9rem 1.5rem 5rem;
        background: var(--c-surface);
        overflow: hidden;
        border-bottom: 1px solid var(--c-border);
    }

    /* Decorative Glows */
    .sv-hero-premium::before {
        content: '';
        position: absolute;
        top: -150px; right: -100px;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(14,165,233,0.06) 0%, transparent 70%);
        pointer-events: none;
        border-radius: 50%;
    }
    .sv-hero-premium::after {
        content: '';
        position: absolute;
        bottom: -150px; left: -100px;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(14,165,233,0.04) 0%, transparent 70%);
        pointer-events: none;
        border-radius: 50%;
    }

    .sv-hero-inner {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
        text-align: center;
    }

    /* breadcrumb */
    .sv-breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--c-muted);
        margin-bottom: 2.5rem;
        font-family: var(--font);
    }
    .sv-breadcrumb a {
        color: var(--c-muted);
        text-decoration: none;
        transition: color 0.2s;
    }
    .sv-breadcrumb a:hover { color: var(--c-accent); }
    .sv-breadcrumb-sep {
        font-size: 0.6rem;
        color: var(--c-muted);
        opacity: 0.5;
    }
    .sv-breadcrumb-current { color: var(--c-text); font-weight: 600; }

    /* label */
    .sv-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--c-muted);
        margin-bottom: 1.25rem;
        font-family: var(--font);
    }
    .sv-label::before {
        content: '';
        display: block;
        width: 5px; height: 5px;
        background: var(--c-accent);
        border-radius: 50%;
    }

    /* title */
    .sv-title {
        font-size: clamp(2rem, 4vw, 3.5rem);
        font-weight: 500;
        color: var(--c-text);
        line-height: 1.15;
        letter-spacing: -0.03em;
        font-family: var(--font);
        margin-bottom: 1.5rem;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    /* intro text */
    .sv-intro {
        margin: 0 auto;
        max-width: 650px;
        font-size: 1rem;
        font-weight: 400;
        color: var(--c-muted);
        line-height: 1.7;
        font-family: var(--font);
    }

    /* ═══════════════════════════════════════
       SERVICES GRID
    ═══════════════════════════════════════ */
    .sv-section {
        padding: 5rem 1.5rem 7rem;
        max-width: 1200px;
        margin: 0 auto;
        background: var(--c-bg);
    }

    .sv-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    /* service card */
    .sv-card {
        display: flex;
        flex-direction: column;
        background: var(--c-card);
        border: 1.5px solid var(--c-border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        text-decoration: none !important;
        transition: all 0.4s var(--ease);
        position: relative;
    }
    .sv-card * {
        text-decoration: none !important;
    }

    .sv-card:hover {
        border-color: var(--c-accent);
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(14, 165, 233, 0.08);
    }

    .sv-card-img {
        width: 100%;
        aspect-ratio: 16/10;
        overflow: hidden;
        position: relative;
        background: var(--c-surface);
    }

    .sv-card-img img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.6s var(--ease);
    }

    .sv-card:hover .sv-card-img img {
        transform: scale(1.08);
    }

    .sv-card-body { 
        padding: 1.75rem; 
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .sv-card-num {
        display: inline-flex;
        align-items: center;
        background: rgba(14, 165, 233, 0.08);
        color: var(--c-accent);
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        margin-bottom: 1rem;
        align-self: flex-start;
        font-family: var(--font);
    }

    .sv-card-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--c-text);
        margin-bottom: 0.75rem;
        line-height: 1.4;
        font-family: var(--font);
        transition: color 0.3s;
    }

    .sv-card-desc {
        font-size: 0.9375rem;
        font-weight: 400;
        color: var(--c-muted);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-family: var(--font);
        flex-grow: 1;
    }

    .sv-card-link {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--c-accent);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: var(--font);
        transition: gap 0.3s;
        border-top: 1px solid var(--c-border);
        padding-top: 1.25rem;
        margin-top: auto;
    }
    .sv-card:hover .sv-card-link {
        gap: 0.75rem;
    }

    /* ═══════════════════════════════════════
       CTA BANNER (Light Style)
    ═══════════════════════════════════════ */
    .sv-cta-premium {
        background: var(--c-surface);
        padding: 5rem 1.5rem;
        border-top: 1px solid var(--c-border);
        position: relative;
        overflow: hidden;
    }

    .sv-cta-glow {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 800px; height: 800px;
        background: radial-gradient(circle, rgba(14,165,233,0.06) 0%, transparent 60%);
        pointer-events: none;
    }

    .sv-cta-inner {
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .sv-cta-h2 {
        font-size: clamp(1.75rem, 3vw, 2.5rem);
        font-weight: 500;
        line-height: 1.2;
        letter-spacing: -0.02em;
        color: var(--c-text);
        margin-bottom: 1rem;
        font-family: var(--font);
    }

    .sv-cta-sub {
        font-size: 1rem;
        font-weight: 400;
        color: var(--c-muted);
        max-width: 600px;
        margin: 0 auto 2.5rem;
        line-height: 1.6;
        font-family: var(--font);
    }

    .sv-cta-btns { 
        display: flex; 
        gap: 1rem; 
        justify-content: center;
        flex-wrap: wrap; 
    }

    /* buttons */
    .btn-primary-v2 {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--c-accent);
        color: var(--c-white);
        font-family: var(--font);
        font-size: 0.9375rem;
        font-weight: 600;
        padding: 1rem 2rem;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        text-decoration: none !important;
        transition: all 0.3s;
        box-shadow: 0 8px 20px rgba(14,165,233,0.25);
    }
    .btn-primary-v2:hover {
        background: var(--c-accent-hover);
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(14,165,233,0.35);
        color: var(--c-white) !important;
    }

    .btn-outline-v2 {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: transparent;
        color: var(--c-text);
        font-family: var(--font);
        font-size: 0.9375rem;
        font-weight: 600;
        padding: 1rem 2rem;
        border-radius: 50px;
        border: 1.5px solid var(--c-border);
        cursor: pointer;
        text-decoration: none !important;
        transition: all 0.3s;
    }
    .btn-outline-v2:hover {
        border-color: var(--c-text);
        color: var(--c-text) !important;
    }

    /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */
    @media (max-width: 1024px) {
        .sv-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 640px) {
        .sv-grid { grid-template-columns: 1fr; }
        .sv-hero-premium { padding: 7rem 1rem 4rem; }
        .sv-section { padding: 3rem 1rem 5rem; }
        .sv-cta-premium { padding: 4rem 1rem; }
        .sv-cta-btns { flex-direction: column; width: 100%; }
        .btn-primary-v2, .btn-outline-v2 { width: 100%; justify-content: center; }
    }
</style>

{{-- ═══ HERO ═══ --}}
<section class="sv-hero-premium">
    <div class="sv-hero-inner" data-aos="fade-up">

        {{-- Breadcrumb --}}
        <nav class="sv-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route_locale('home') }}">Beranda</a>
            <span class="sv-breadcrumb-sep">/</span>
            <span class="sv-breadcrumb-current">Produk &amp; Layanan</span>
        </nav>

        <div class="sv-label">Produk &amp; Layanan</div>
        <h1 class="sv-title">
            Solusi Ventilasi Udara Terbaik<br>
            Untuk Industri Anda
        </h1>

        <p class="sv-intro">
            Cyclevent menyediakan berbagai jenis ukuran turbine ventilator non-electric untuk
            memenuhi kebutuhan sirkulasi udara di pabrik, gudang, maupun bangunan komersial Anda.
        </p>

    </div>
</section>

{{-- ═══ SERVICES GRID ═══ --}}
<section class="sv-section">
    <div class="sv-grid">
        @foreach($services as $i => $service)
            <a href="{{ route_locale('products.show', $service->slug) }}"
               class="sv-card"
               data-aos="fade-up"
               data-aos-delay="{{ ($i % 3) * 100 }}">

                <div class="sv-card-img">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}"
                             alt="{{ $service->name }} - Cyclevent"
                             loading="{{ $i < 3 ? 'eager' : 'lazy' }}">
                    @else
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#E2E8F0; color:#94A3B8;">
                            <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="sv-card-body">
                    <div class="sv-card-num">Tipe #{{ str_pad($service->order ?? ($i + 1), 2, '0', STR_PAD_LEFT) }}</div>
                    <h2 class="sv-card-name">{{ $service->name }}</h2>
                    <p class="sv-card-desc">{{ Str::limit($service->short_desc, 90) }}</p>
                    <span class="sv-card-link">
                        Lihat Spesifikasi
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </span>
                </div>

            </a>
        @endforeach
    </div>
</section>

{{-- ═══ CTA BANNER ═══ --}}
<section class="sv-cta-premium" data-aos="fade-up">
    <div class="sv-cta-glow"></div>
    <div class="sv-cta-inner">
        <div class="sv-label" style="margin-bottom:1rem;">Butuh Konsultasi?</div>
        <h2 class="sv-cta-h2">
            Tentukan Ukuran yang Tepat
        </h2>
        <p class="sv-cta-sub">
            Tim teknis Cyclevent siap membantu Anda menghitung kebutuhan turbine ventilator
            yang paling optimal untuk bangunan Anda secara gratis.
        </p>
        
        <div class="sv-cta-btns">
            @php $wa = \App\Models\WaSetting::primary(); @endphp
            @if($wa)
                <a href="javascript:void(0)" onclick="openOrderModal('Halaman Produk')" class="btn-primary-v2" data-track="wa">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Konsultasi via WhatsApp
                </a>
            @endif
            <a href="{{ route_locale('contact') }}" class="btn-outline-v2" data-track="phone">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

@endsection
