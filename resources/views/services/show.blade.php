@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
/* ── RESET ── */
*, *::before, *::after { box-sizing: border-box; }
html, body { overflow-x: hidden; max-width: 100%; }
.sh-hero, .sh-layout, .sh-adv-section, .sh-app-section, .sh-coverage-section, .sh-related { overflow-x: hidden; }

/* ── TOKENS ── */
:root {
    --bg:      #ffffff;
    --surface: #F8FAFC;
    --bg-gray: #EAEBED;
    --border:  #E2E8F0;
    --text:    #0F172A;
    --muted:   #64748B;
    --accent:  #0EA5E9;
    --accent2: #0284C7;
    --font:    'Montserrat', sans-serif;
    --ease:    cubic-bezier(0.22,1,0.36,1);
}
body { background: var(--bg); color: var(--text); font-family: var(--font); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; font-weight: 400; line-height: 1.6; }

/* ── BREADCRUMB BAR (replaces hero) ── */
.sh-hero {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 5.5rem 0 0.875rem;
    position: relative;
    overflow: hidden;
}
.sh-hero-inner { max-width:1200px; padding:0 1.5rem; margin:0 auto; position:relative; z-index:2; }

.sh-breadcrumb {
    display:flex; align-items:center; flex-wrap:wrap; gap:.375rem;
    font-size:.75rem; font-weight:500; color:var(--muted);
    margin-bottom:0;
}
.sh-breadcrumb a { color:var(--muted); text-decoration:none; transition:color .2s; }
.sh-breadcrumb a:hover { color:var(--accent); }
.sh-breadcrumb-sep { opacity:.4; font-size:.6rem; }
.sh-breadcrumb-current { color:var(--text); font-weight:600; }

.sh-layout {
    max-width:1200px; margin:0 auto;
    padding:1.5rem 1.5rem 2rem;
    display:grid; grid-template-columns:420px 1fr;
    gap:2.5rem; align-items:start;
    overflow-x: hidden;
    width: 100%;
    box-sizing: border-box;
}
.sh-product-name {
    font-size: 1.5rem;
    font-weight: 500;
    color: var(--text);
    line-height: 1.4;
    margin: 0 0 .5rem;
}
.sh-product-subdesc {
    font-size:.9rem;
    color:var(--muted);
    line-height:1.5;
    margin:0 0 1rem;
}
.sh-rating-row {
    display:flex; align-items:center; gap:1rem; margin-bottom:1rem; font-size:.875rem; color:var(--text);
}
.sh-rating-stars { color:#F59E0B; display:flex; align-items:center; gap:2px; }
.sh-rating-divider { width:1px; height:12px; background:var(--border); }
.sh-price-box {
    background: #FAFAFA;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
}
.sh-price-current {
    font-size: 1.875rem;
    font-weight: 800;
    color: var(--text);
    line-height: 1.2;
}
.sh-price-old {
    font-size: 1rem;
    text-decoration: line-through;
    color: var(--muted);
    margin-right: .5rem;
}
.sh-info-table { width:100%; font-size:.875rem; }
.sh-info-table td { padding:.5rem 0; vertical-align:top; }
.sh-info-table td:first-child { width:100px; color:var(--muted); }

.sh-bottom-section {
    max-width:1200px; margin:0 auto;
    padding: 2rem 1.5rem 6rem;
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 2rem;
}

@media (max-width: 1024px) {
    .sh-layout { grid-template-columns: 1fr; gap:2rem; }
    .sh-bottom-section { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .sh-layout {
        padding: 1rem 1rem 2rem;
        overflow-x: hidden;
        width: 100%;
    }
    .sh-bottom-section { padding: 1rem 1rem 3rem; }
}

/* ── GALLERY SLIDER 1:1 ── */
.sh-gallery { margin-bottom:0; }

.sh-swiper-main {
    width:100%;
    border-radius:16px;
    overflow:hidden;
    background:var(--surface);
    border:1px solid var(--border);
    margin-bottom:.625rem;
    /* Strict 1:1 */
    position: relative;
    aspect-ratio: 1 / 1;
}
@media (max-width:640px) {
    .sh-gallery {
        margin-left:0;
        margin-right:0;
        overflow:hidden;
    }
    .sh-swiper-main {
        width:100%;
        border-radius:12px;
    }
    .sh-swiper-thumbs .swiper-slide {
        width:52px !important;
        height:44px;
    }
}
.sh-swiper-main .swiper-wrapper {
    height: 100%;
    width: 100%;
}
.sh-swiper-main .swiper-slide {
    width: 100%; height: 100%;
    overflow: hidden;
}
.sh-swiper-main .swiper-slide img {
    width:100%; height:100%;
    object-fit:cover; object-position:center; display:block;
}

/* Nav arrows */
.sh-swiper-main .swiper-button-next,
.sh-swiper-main .swiper-button-prev {
    width:28px !important; height:28px !important;
    background:rgba(255,255,255,.95);
    border-radius:50%;
    box-shadow:0 2px 10px rgba(15,23,42,.12);
    color:var(--text) !important;
}
.sh-swiper-main .swiper-button-next::after,
.sh-swiper-main .swiper-button-prev::after { font-size:12px !important; font-weight:900; }

/* Thumb strip */
.sh-swiper-thumbs { width:100%; }
.sh-swiper-thumbs .swiper-wrapper { gap:6px; }
.sh-swiper-thumbs .swiper-slide {
    width:58px !important; height:58px;
    border-radius:8px; overflow:hidden; cursor:pointer;
    border:2px solid transparent; opacity:.55;
    flex-shrink:0;
    transition:opacity .25s, border-color .25s;
}
.sh-swiper-thumbs .swiper-slide img { width:100%; height:100%; object-fit:cover; display:block; }
.sh-swiper-thumbs .swiper-slide-thumb-active { opacity:1; border-color:var(--accent); }

/* ── ARTICLE CONTENT ── */
.sh-content { color:var(--muted); font-size:.9375rem; line-height:1.85; font-weight:400; }
.sh-content h1,.sh-content h2,.sh-content h3,.sh-content h4 {
    color:var(--text); font-weight:600; line-height:1.3;
    margin:2rem 0 .875rem; letter-spacing:-.015em;
}
.sh-content h2 { font-size:1.4rem; }
.sh-content h3 { font-size:1.15rem; }
.sh-content p { margin-bottom:1.1rem; }
.sh-content ul,.sh-content ol { margin:.875rem 0 1.1rem 1.4rem; }
.sh-content li { margin-bottom:.4rem; }
.sh-content strong { color:var(--text); font-weight:600; }
.sh-content img { max-width:100%; border-radius:8px; margin:1.5rem 0; }

/* ── SIDEBAR ── */
.sh-sidebar-card {
    background:var(--bg); border:1.5px solid var(--border);
    border-radius:20px; padding:1.75rem;
    box-shadow:0 8px 24px rgba(15,23,42,.04);
    position:sticky; top:80px;
}
.sh-sidebar-badge {
    display:inline-flex; align-items:center; gap:.5rem;
    font-size:.7rem; font-weight:600; letter-spacing:.12em;
    text-transform:uppercase; color:var(--muted); margin-bottom:1rem;
}
.sh-sidebar-badge::before {
    content:''; display:inline-block;
    width:5px; height:5px; background:var(--accent); border-radius:50%;
}
.sh-sidebar-title { font-size:1.125rem; font-weight:600; color:var(--text); line-height:1.3; margin-bottom:.625rem; }
.sh-sidebar-desc { font-size:.875rem; color:var(--muted); line-height:1.6; margin-bottom:1.25rem; border-bottom:1px solid var(--border); padding-bottom:1.25rem; }

.sh-info-row {
    display:flex; align-items:center; gap:.75rem;
    padding:.55rem 0; font-size:.8rem; color:var(--muted);
    border-bottom:1px solid var(--border);
}
.sh-info-row:last-of-type { border-bottom:none; }
.sh-info-icon {
    flex-shrink:0; width:30px; height:30px;
    display:flex; align-items:center; justify-content:center;
    background:rgba(14,165,233,.08); border-radius:8px; color:var(--accent);
}

.sh-btn-primary {
    display:flex; align-items:center; justify-content:center; gap:.6rem;
    background:var(--accent); color:#fff !important;
    font-size:.9375rem; font-weight:600;
    padding:.875rem 1.5rem; border-radius:50px;
    border:none; cursor:pointer; text-decoration:none !important;
    transition:all .3s var(--ease);
    box-shadow:0 6px 18px rgba(14,165,233,.25);
    width:100%; margin-top:1.5rem; margin-bottom:.625rem;
}
.sh-btn-primary:hover {
    background:var(--accent2); transform:translateY(-2px);
    box-shadow:0 10px 24px rgba(14,165,233,.35);
}
.sh-btn-outline {
    display:flex; align-items:center; justify-content:center; gap:.6rem;
    background:transparent; color:var(--text) !important;
    font-size:.9375rem; font-weight:600;
    padding:.875rem 1.5rem; border-radius:50px;
    border:1.5px solid var(--border); cursor:pointer;
    text-decoration:none !important; transition:all .3s; width:100%;
}
.sh-btn-outline:hover { border-color:var(--accent); color:var(--accent) !important; }

/* ── SECTION SHARED LABELS ── */
.cv-section-label {
    display:inline-flex; align-items:center; gap:.5rem;
    font-size:.72rem; font-weight:600; letter-spacing:.14em;
    text-transform:uppercase; color:var(--muted); margin-bottom:.875rem;
}
.cv-section-label::before {
    content:''; display:inline-block;
    width:5px; height:5px; background:var(--accent); border-radius:50%;
}
.cv-section-title {
    font-size:clamp(1.75rem,3vw,2.5rem);
    font-weight:500; color:var(--text); line-height:1.15;
    letter-spacing:-.03em; margin-bottom:0;
}

/* ── KEUNGGULAN ── */
.sh-adv-section {
    background:var(--bg); padding:5rem 1.5rem;
    border-top:1px solid var(--border);
}
.sh-adv-inner { max-width:1200px; margin:0 auto; }
.sh-adv-header {
    display:flex; align-items:flex-end; justify-content:space-between;
    flex-wrap:wrap; gap:2rem; margin-bottom:3rem;
}
.sh-adv-header-desc { max-width:320px; font-size:.875rem; color:var(--muted); line-height:1.65; text-align:right; }
.sh-adv-cards {
    display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem;
}
.sh-adv-card {
    background:var(--surface); border:1.5px solid var(--border);
    border-radius:20px; padding:1.75rem;
    display:flex; flex-direction:column; gap:.75rem;
    transition:all .35s var(--ease); min-height:200px;
}
.sh-adv-card:hover { border-color:var(--accent); transform:translateY(-6px); box-shadow:0 16px 40px rgba(14,165,233,.08); }
.sh-adv-card.accent { background:var(--accent); border-color:var(--accent); }
.sh-adv-card.accent-dark { background:var(--text); border-color:var(--text); }
.sh-adv-card-icon {
    width:44px; height:44px; border-radius:12px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.sh-adv-card-icon.blue-bg { background:#E0F2FE; color:var(--accent); }
.sh-adv-card-icon.white-bg { background:rgba(255,255,255,.2); color:#fff; }
.sh-adv-card-icon.dark-bg { background:rgba(255,255,255,.08); color:#38BDF8; }
.sh-adv-num { font-size:2.5rem; font-weight:300; line-height:1; letter-spacing:-.04em; color:var(--text); }
.sh-adv-num.white { color:#fff; }
.sh-adv-num.blue { color:#38BDF8; }
.sh-adv-title { font-size:.9375rem; font-weight:600; color:var(--text); }
.sh-adv-title.white { color:#fff; }
.sh-adv-title.light { color:rgba(255,255,255,.9); }
.sh-adv-desc { font-size:.8rem; color:var(--muted); line-height:1.6; margin-top:auto; }
.sh-adv-desc.white { color:rgba(255,255,255,.75); }

@media (max-width: 1024px) { .sh-adv-cards { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .sh-adv-section { padding: 3.5rem 0; }
    .sh-adv-cards { 
        grid-template-columns: none !important;
        grid-auto-flow: column;
        grid-auto-columns: 78vw;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding-bottom: 1.5rem;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        gap: 1rem;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    .sh-adv-cards::-webkit-scrollbar { display: none; }
    .sh-adv-cards > * { scroll-snap-align: start; }
    .sh-adv-card-span-2 {
        grid-column: auto !important;
        flex-direction: column !important;
        align-items: flex-start !important;
    }
}

/* ── APLIKASI ── */
.sh-app-section { background:var(--surface); padding:5rem 1.5rem; border-top:1px solid var(--border); }
.sh-app-inner { max-width:1200px; margin:0 auto; }
.sh-app-header { max-width:600px; margin-bottom:3rem; }
.sh-app-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; }
.sh-app-card {
    background:var(--bg); border:1px solid var(--border);
    border-radius:20px;
    display:flex; flex-direction:column;
    transition:all .3s var(--ease); overflow:hidden;
}
.sh-app-card:hover { border-color:var(--accent); transform:translateY(-6px); box-shadow:0 16px 40px rgba(14,165,233,.08); }
.sh-app-icon {
    width:50px; height:50px; background:#F0F9FF;
    border-radius:14px; display:flex; align-items:center; justify-content:center;
    color:var(--accent); transition:all .3s; flex-shrink:0;
}
.sh-app-card:hover .sh-app-icon { background:var(--accent); color:#fff; }
.sh-app-img-wrapper { width:100%; aspect-ratio:4/3; overflow:hidden; background:var(--surface); }
.sh-app-img-wrapper img { width:100%; height:100%; object-fit:cover; transition:transform 0.5s; }
.sh-app-card:hover .sh-app-img-wrapper img { transform:scale(1.05); }
.sh-app-card-body { padding:1.5rem; display:flex; flex-direction:column; gap:1rem; flex:1; }
.sh-app-title { font-size:1.05rem; font-weight:600; color:var(--text); margin:0; }
.sh-app-desc { font-size:.9rem; color:var(--muted); line-height:1.7; margin:0; }

@media (max-width: 1024px) { .sh-app-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) { 
    .sh-app-section { padding: 3.5rem 0; }
    .sh-app-header { padding: 0 1.5rem; }
    .sh-app-grid { 
        grid-template-columns: none !important;
        grid-auto-flow: column;
        grid-auto-columns: 78vw;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding-bottom: 1.5rem;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        gap: 1rem;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    .sh-app-grid::-webkit-scrollbar { display: none; }
    .sh-app-grid > * { scroll-snap-align: start; }
}

/* ── COVERAGE / MELAYANI ── */
.sh-coverage-section {
    background: #F8FAFC;
    padding: 6rem 0 0;
    position: relative;
}
.sh-coverage-inner { max-width:1200px; margin:0 auto; position:relative; z-index:2; }
.sh-coverage-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    margin-bottom: 3rem;
}
.sh-coverage-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 500; color:var(--text); line-height:1.1;
    letter-spacing:-.04em; flex-shrink:0; min-width:220px;
}
.sh-stats-grid {
    display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; flex:1;
}
.sh-stat-card {
    background:#fff; border-radius:16px; padding:1.5rem;
    box-shadow:0 10px 40px rgba(0,0,0,.04);
    display:flex; flex-direction:column;
    transition:transform .3s;
}
.sh-stat-card:hover { transform:translateY(-5px); }
.sh-stat-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem; }
.sh-stat-label { font-size:.65rem; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.1em; }
.sh-stat-icon { color:var(--text); opacity:.8; }
.sh-stat-val { font-size:3.5rem; font-weight:300; color:var(--text); line-height:1; letter-spacing:-.05em; display:flex; align-items:baseline; gap:0.1em; }
.sh-stat-val span { color:var(--accent); font-size:2rem; font-weight:600; line-height:1; }
.sh-glass-box {
    background:rgba(255,255,255,.4); backdrop-filter:blur(24px);
    -webkit-backdrop-filter:blur(24px);
    border:1px solid rgba(255,255,255,.7); border-radius:24px;
    padding:3rem; margin-top:5rem;
}
.sh-glass-title { font-size:2rem; font-weight:500; color:var(--text); margin-bottom:2rem; letter-spacing:-.04em; }
.sh-cities-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; }
.sh-city-item { font-size:.875rem; color:#1E293B; display:flex; align-items:center; gap:.5rem; }
.sh-city-item::before {
    content:''; width:8px; height:8px; border-radius:50%;
    background:transparent; border:1.5px solid #94A3B8; flex-shrink:0;
}
.sh-city-item.active::before { background:var(--accent); border-color:var(--accent); }

@keyframes pulse-dot {
    0% { transform:scale(1); opacity:.6; }
    50% { transform:scale(1.5); opacity:0; }
    100% { transform:scale(1); opacity:0; }
}

/* ── RELATED ── */
.sh-related {
    background:var(--surface); border-top:1px solid var(--border);
    padding:4rem 1.5rem 6rem;
}
.sh-related-inner { max-width:1200px; margin:0 auto; }
.sh-related-title { font-size:clamp(1.5rem,2.5vw,2rem); font-weight:500; color:var(--text); margin-bottom:2rem; letter-spacing:-.02em; }
.sh-related-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; }
.sh-related-card {
    background:var(--bg); border:1.5px solid var(--border); border-radius:16px;
    overflow:hidden; text-decoration:none !important;
    transition:all .35s var(--ease);
}
.sh-related-card:hover { border-color:var(--accent); transform:translateY(-6px); box-shadow:0 16px 32px rgba(14,165,233,.08); }
.sh-related-img { width:100%; aspect-ratio:4/3; object-fit:cover; display:block; }
.sh-related-body { padding:1.1rem 1.25rem 1.25rem; }
.sh-related-name { font-size:.9375rem; font-weight:600; color:var(--text); margin-bottom:.4rem; line-height:1.3; }
.sh-related-desc { font-size:.8rem; color:var(--muted); line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

/* ── RESPONSIVE ── */
@media (max-width:1200px) {
    .sh-coverage-header-row { flex-direction:column; align-items:flex-start; gap:2rem; }
}
@media (max-width:1024px) {
    .sh-layout { grid-template-columns:1fr; gap:2.5rem; }
    .sh-sidebar-card { position:static; }
    .sh-adv-cards,.sh-app-grid,.sh-stats-grid,.sh-related-grid { grid-template-columns:repeat(2,1fr); }
    .sh-cities-grid { grid-template-columns:repeat(3,1fr); }
    .sh-adv-header-desc { text-align:left; max-width:none; }
}
@media (max-width:640px) {
    .sh-hero { padding:5rem 1rem 0.75rem; }
    .sh-hero-inner { padding:0 .25rem; }
    .sh-layout { padding:1.75rem 1rem 3rem; }
    .sh-adv-section,.sh-app-section,.sh-coverage-section,.sh-related { padding:3.5rem 1rem; }
    .sh-adv-cards,.sh-app-grid,.sh-related-grid { grid-template-columns:1fr; }
    .sh-stats-grid { grid-template-columns:repeat(2,1fr); gap:1rem; }
    .sh-stat-val { font-size:2.5rem; }
    .sh-cities-grid { grid-template-columns:repeat(2,1fr); }
    .sh-glass-box { padding:1.75rem 1rem; margin-top:3rem; }
    .sh-coverage-section { padding:4rem 1rem; }
    .sh-adv-header { flex-direction:column; align-items:flex-start; }
    .sh-h1 { font-size:1.75rem; }
    .sh-short-desc { font-size:.9rem; }
}
</style>

{{-- ═══ BREADCRUMB ONLY ═══ --}}
<section class="sh-hero">
    <div class="sh-hero-inner">
        <nav class="sh-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route_locale('home') }}">Beranda</a>
            <span class="sh-breadcrumb-sep">›</span>
            <a href="{{ route_locale('products') }}">Produk &amp; Layanan</a>
            <span class="sh-breadcrumb-sep">›</span>
            <span class="sh-breadcrumb-current">{{ $service->name }}</span>
        </nav>
    </div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

{{-- ═══ DETAIL LAYOUT ═══ --}}
<section class="sh-layout">
    {{-- LEFT: Gallery --}}
    <div style="min-width:0;overflow:hidden;width:100%;">
        @php
            $imgs = [];
            if ($service->image) $imgs[] = asset('storage/'.$service->image);
            else $imgs[] = asset('images/service-default.jpg');
            if (is_array($service->gallery)) {
                foreach ($service->gallery as $g) $imgs[] = asset('storage/'.$g);
            }
        @endphp

        <div class="sh-gallery">
            <div class="sh-swiper-main swiper" id="sh-swiper-main">
                <div class="swiper-wrapper">
                    @foreach($imgs as $img)
                        <div class="swiper-slide">
                            <a href="{{ $img }}" class="glightbox" data-gallery="gallery">
                                <img src="{{ $img }}" alt="{{ $service->name }}">
                            </a>
                        </div>
                    @endforeach
                </div>
                @if(count($imgs) > 1)
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                @endif
            </div>

            @if(count($imgs) > 1)
                <div class="sh-swiper-thumbs swiper" id="sh-swiper-thumbs">
                    <div class="swiper-wrapper">
                        @foreach($imgs as $img)
                            <div class="swiper-slide"><img src="{{ $img }}" alt="thumb"></div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- RIGHT: Product Info, Price, Add to Cart --}}
    <aside>
        <h1 style="font-size:1.5rem;font-weight:800;color:var(--text);line-height:1.3;margin-bottom:0.5rem;">{{ $service->name }}</h1>
        
        @if($service->rating > 0 || $service->sold_count > 0)
        <div class="sh-rating-row">
            @if($service->rating > 0)
            <div class="sh-rating-stars">
                <span style="color:#EE4D2D;font-weight:500;margin-right:4px;">{{ number_format($service->rating, 1) }}</span>
                @for($i=1; $i<=5; $i++)
                    @if($i <= floor($service->rating))
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @elseif($i == ceil($service->rating) && fmod($service->rating, 1) > 0)
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><defs><linearGradient id="half-{{$i}}"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="#E2E8F0"/></linearGradient></defs><path fill="url(#half-{{$i}})" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @else
                        <svg width="14" height="14" fill="#E2E8F0" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endif
                @endfor
            </div>
            @endif

            @if($service->rating > 0 && $service->sold_count > 0)
                <div class="sh-rating-divider"></div>
            @endif

            @if($service->sold_count > 0)
            <div>
                <span style="font-weight:500;">{{ $service->sold_count >= 1000 ? number_format($service->sold_count/1000, 1, ',', '').'RB' : $service->sold_count }}</span>
                <span style="color:var(--muted)">Terjual</span>
            </div>
            @endif
        </div>
        @endif

        @if($service->short_desc)
            <p class="sh-product-subdesc">{{ $service->short_desc }}</p>
        @endif

        @if($service->price > 0)
            <div class="sh-price-box">
                @if($service->sale_price > 0 && $service->sale_price < $service->price)
                    <div style="display:flex;align-items:center;flex-wrap:wrap;">
                        <span class="sh-price-old">Rp{{ number_format($service->price, 0, ',', '.') }}</span>
                        <span class="sh-price-current">Rp{{ number_format($service->sale_price, 0, ',', '.') }}</span>
                        <span style="margin-left:1rem;background:#FEE2E2;color:#EF4444;font-size:.7rem;font-weight:700;padding:2px 4px;border-radius:2px;">Diskon {{ round((($service->price - $service->sale_price)/$service->price)*100) }}%</span>
                    </div>
                @else
                    <div class="sh-price-current">Rp{{ number_format($service->price, 0, ',', '.') }}</div>
                @endif
            </div>

            <table class="sh-info-table" style="margin-bottom:1.5rem;">
                <tr>
                    <td>Pengiriman</td>
                    <td>
                        <div style="display:flex;align-items:flex-start;gap:8px;">
                            <svg width="20" height="20" fill="none" stroke="#16A34A" stroke-width="2" viewBox="0 0 24 24" style="margin-top:2px;"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                            <div>
                                <div style="color:#1E293B;">Garansi Tiba Tepat Waktu</div>
                                <div style="font-size:.75rem;color:var(--muted);margin-top:4px;">Dapatkan voucher jika pesanan terlambat.</div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $service->id }}">
                
                <table class="sh-info-table" style="margin-bottom:2rem; align-items:center;">
                    <tr>
                        <td style="vertical-align:middle;">Kuantitas</td>
                        <td style="vertical-align:middle;">
                            <div style="display:inline-flex; align-items:center; border:1px solid var(--border); border-radius:4px; overflow:hidden;">
                                <button type="button" onclick="document.getElementById('qty').stepDown()" style="width:32px; height:32px; border:none; background:#fff; border-right:1px solid var(--border); cursor:pointer; color:var(--muted); font-size:1.1rem; line-height:1;">−</button>
                <input type="number" id="qty" name="qty" value="{{ $service->min_order ?? 1 }}" min="{{ $service->min_order ?? 1 }}" 
                    @if($service->type !== 'service' && $service->stock > 0) max="{{ $service->stock }}" @endif
                    style="width:50px; height:32px; text-align:center; border:none; outline:none; font-weight:500; font-size:.9rem; color:var(--text);"
                    @if($service->type !== 'service' && $service->stock <= 0) disabled @endif>
                                <button type="button" onclick="document.getElementById('qty').stepUp()" style="width:32px; height:32px; border:none; background:#fff; border-left:1px solid var(--border); cursor:pointer; color:var(--muted); font-size:1.1rem; line-height:1;">+</button>
                            </div>
                            <span style="font-size:.875rem; color:var(--muted); margin-left:1rem;">
                                @if($service->type === 'service')
                                    Jasa / Layanan
                                @elseif($service->stock > 0)
                                    Tersisa {{ $service->stock }} buah
                                @else
                                    Stok Habis
                                @endif
                            </span>
                        </td>
                    </tr>
                </table>

                <div style="display:flex; gap:0.5rem;">
                    <button type="submit" name="action" value="cart" style="flex:1; padding:.75rem; display:flex; align-items:center; justify-content:center; gap:0.5rem; background:#fff; color:var(--text); border:1px solid var(--border); border-radius:6px; font-weight:600; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='var(--surface)'" onmouseout="this.style.background='#fff'" @if($service->type !== 'service' && $service->stock <= 0) disabled @endif title="Tambah ke Keranjang">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 20a1 1 0 100-2 1 1 0 000 2zM20 20a1 1 0 100-2 1 1 0 000 2z"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                        Masukkan Keranjang
                    </button>
                    <button type="submit" name="action" value="buy" style="flex:1; padding:.75rem; display:flex; align-items:center; justify-content:center; background:var(--accent); color:#fff; border:none; border-radius:6px; font-weight:600; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='var(--accent2)'" onmouseout="this.style.background='var(--accent)'" @if($service->type !== 'service' && $service->stock <= 0) disabled @endif>
                        Beli Sekarang
                    </button>
                </div>
            </form>
        @else
            <div class="sh-price-box" style="background:#FFF8F1; border:1px solid #FFEDD5; margin-bottom:1.5rem;">
                <div style="font-size:1.5rem; font-weight:700; color:#EA580C;">Konsultasi Gratis</div>
                <div style="font-size:.875rem; color:#9A3412; margin-top:.25rem;">Tim ahli kami siap membantu Anda mendapatkan informasi lengkap dan penawaran terbaik.</div>
            </div>
            
            <a href="javascript:void(0)" onclick="openOrderModal('Produk: {{ addslashes($service->name) }}')" style="width:100%; padding:.75rem; display:flex; align-items:center; justify-content:center; background:var(--accent); color:#fff; border:none; border-radius:6px; font-weight:600; cursor:pointer; transition:background 0.2s; text-decoration:none; margin-top:0;" onmouseover="this.style.background='var(--accent2)'" onmouseout="this.style.background='var(--accent)'">
                Konsultasi & Tanya
            </a>
        @endif
    </aside>
</section>

{{-- ═══ BOTTOM LAYOUT (Description, Specs, FAQ) ═══ --}}
<section class="sh-bottom-section">
    <div style="background:#fff; padding:2rem; border:1px solid var(--border); border-radius:4px; box-shadow:0 1px 1px rgba(0,0,0,.05);">
        <div style="background:#FAFAFA; padding:1rem; font-size:1.1rem; font-weight:500; color:var(--text); margin-bottom:1.5rem;">
            Spesifikasi Produk
        </div>
        
        @if(is_array($service->specifications) && count($service->specifications) > 0)
        <table style="width:100%; border-collapse:collapse; text-align:left; font-size:.875rem; color:var(--text); margin-bottom:2rem;">
            <tbody>
                @foreach($service->specifications as $spec)
                <tr>
                    <td style="padding:.5rem 0; width:150px; color:var(--muted);">{{ $spec['key'] }}</td>
                    <td style="padding:.5rem 0;">{{ $spec['value'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <div style="background:#FAFAFA; padding:1rem; font-size:1.1rem; font-weight:500; color:var(--text); margin-bottom:1.5rem;">
            Deskripsi Produk
        </div>
        <div class="sh-content" style="color:var(--text);">
            {!! $service->description ?? '<p>Belum ada deskripsi untuk produk ini.</p>' !!}
        </div>

        {{-- FAQ Table --}}
        @php
            $faqs = is_array($service->faqs) && !empty($service->faqs) ? $service->faqs : [
                ['q' => 'Apakah Alat Rumah memerlukan listrik?', 'a' => 'Sama sekali tidak. Alat Rumah beroperasi 100% menggunakan tenaga angin dan perbedaan tekanan udara, sehingga bebas biaya listrik selamanya.'],
                ['q' => 'Berapa lama garansi yang diberikan?', 'a' => 'Kami memberikan garansi resmi untuk produk Alat Rumah hingga 15 tahun, mencakup cacat pabrik dan performa putaran mesin.'],
                ['q' => 'Apakah materialnya tahan karat?', 'a' => 'Ya, Alat Rumah terbuat dari material Alumunium atau Stainless Steel berkualitas tinggi yang tahan terhadap cuaca ekstrem dan karat.']
            ];
        @endphp
        @if(count($faqs) > 0)
        <div style="background:#FAFAFA; padding:1rem; font-size:1.1rem; font-weight:500; color:var(--text); margin:2rem 0 1.5rem;">
            FAQ {{ $service->name }}
        </div>
        <table style="width:100%; border-collapse:collapse; text-align:left; font-size:.875rem; color:var(--text);">
            <tbody>
                @foreach($faqs as $f)
                <tr>
                    <td style="padding:.75rem 0; width:35%; font-weight:500; border-bottom:1px solid #F1F5F9;">{{ $f['q'] ?? '' }}</td>
                    <td style="padding:.75rem 0; border-bottom:1px solid #F1F5F9; color:var(--muted);">{{ $f['a'] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{-- JSON-LD FAQ Schema --}}
        <script type="application/ld+json">
        {
          "@@context": "https://schema.org",
          "@@type": "FAQPage",
          "mainEntity": [
            @foreach($faqs as $idx => $f)
            {
              "@@type": "Question",
              "name": "{{ addslashes(strip_tags($f['q'] ?? '')) }}",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ addslashes(strip_tags($f['a'] ?? '')) }}"
              }
            }{{ $idx < count($faqs) - 1 ? ',' : '' }}
            @endforeach
          ]
        }
        </script>
        @endif


            @if($service->brochure)
            <a href="{{ asset('storage/'.$service->brochure) }}" target="_blank" class="sh-btn-outline" style="margin-top:1.5rem;">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Unduh Brosur/Datasheet
            </a>
            @endif
        </div>
    </aside>
</section>


{{-- ═══ KEUNGGULAN ═══ --}}
<section class="sh-adv-section" id="keunggulan">
    <div class="sh-adv-inner">
        <div class="sh-adv-header">
            <div>
                <div class="cv-section-label">KEUNGGULAN</div>
                <h2 class="cv-section-title" style="margin-top:.75rem;">Mengapa Pilih<br>Alat Rumah?</h2>
            </div>
            <p class="sh-adv-header-desc">Hadir untuk memenuhi semua kebutuhan rumah tangga Anda dengan kualitas terbaik dan pelayanan terpercaya dari ahlinya.</p>
        </div>

        <div class="sh-adv-cards">
            {{-- Card 1: Produk Berkualitas --}}
            <div class="sh-adv-card accent">
                <div class="sh-adv-card-icon white-bg">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div class="sh-adv-title white" style="margin-top:auto;">Produk Premium</div>
                <div class="sh-adv-desc white">Kami hanya menyediakan produk alat rumah tangga dengan kualitas terbaik dan brand terpercaya.</div>
            </div>
            {{-- Card 2: Garansi Resmi --}}
            <div class="sh-adv-card">
                <div class="sh-adv-card-icon blue-bg">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="sh-adv-title" style="margin-top:auto;">Garansi Resmi</div>
                <div class="sh-adv-desc">Setiap pembelian produk dilengkapi dengan garansi resmi untuk menjamin ketenangan Anda.</div>
            </div>
            {{-- Card 3: Teknisi --}}
            <div class="sh-adv-card">
                <div class="sh-adv-card-icon blue-bg">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 10-16 0"/></svg>
                </div>
                <div class="sh-adv-title" style="margin-top:auto;">Teknisi Profesional</div>
                <div class="sh-adv-desc">Layanan instalasi dan perbaikan dilakukan oleh teknisi bersertifikat dan berpengalaman.</div>
            </div>
            {{-- Card 4: Pengiriman --}}
            <div class="sh-adv-card accent-dark">
                <div class="sh-adv-card-icon dark-bg">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                </div>
                <div class="sh-adv-title light" style="margin-top:auto;">Pengiriman Aman</div>
                <div class="sh-adv-desc white">Proses pengiriman yang cepat, aman, dan berasuransi hingga sampai ke rumah Anda.</div>
            </div>
            {{-- Card 5: Layanan Purna Jual (span 2) --}}
            <div class="sh-adv-card sh-adv-card-span-2" style="grid-column:span 2; flex-direction:row; gap:2rem; align-items:center;">
                <div class="sh-adv-card-icon blue-bg" style="flex-shrink:0; width:56px; height:56px;">
                    <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                </div>
                <div>
                    <div class="sh-adv-title" style="font-size:1.125rem; margin-bottom:.5rem;">Layanan Purna Jual Terpadu</div>
                    <div class="sh-adv-desc">Kami tidak hanya menjual, tetapi memastikan alat rumah Anda beroperasi optimal dengan layanan konsultasi dan customer service responsif 24/7.</div>
                </div>
            </div>
        </div>
    </div>
    {{-- RIGHT SIDEBAR (Bottom) - Removed Grid for Full Width --}}
    <style>
        /* Force bottom section to be 1fr */
        .sh-bottom-section { grid-template-columns: 1fr; }
    </style>
</section>


{{-- ═══ TESTIMONI ═══ --}}
@include('components.testimonials')

{{-- ═══ MELAYANI SELURUH INDONESIA ═══ --}}
<section class="sh-coverage-section" id="jangkauan">


    <div class="sh-coverage-inner">
        <div class="sh-coverage-header-row">
            <h2 class="sh-coverage-title">Melayani<br>seluruh Indonesia</h2>

            <div class="sh-stats-grid">
                <div class="sh-stat-card">
                    <div class="sh-stat-top">
                        <span class="sh-stat-label">Berdiri Sejak</span>
                        <svg class="sh-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 22h20M12 2v20M5 22V10l7-8 7 8v12M8 14h8M8 18h8"/></svg>
                    </div>
                    <div class="sh-stat-val"><span class="count-up" data-target="{{ \App\Models\Setting::get('founding_year') ?? '2013' }}">0</span></div>
                </div>
                <div class="sh-stat-card">
                    <div class="sh-stat-top">
                        <span class="sh-stat-label">Klien Aktif</span>
                        <svg class="sh-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    </div>
                    <div class="sh-stat-val"><span class="count-up" data-target="500">0</span><span>+</span></div>
                </div>
                <div class="sh-stat-card">
                    <div class="sh-stat-top">
                        <span class="sh-stat-label">Kota Dilayani</span>
                        <svg class="sh-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div class="sh-stat-val"><span class="count-up" data-target="50">0</span><span>+</span></div>
                </div>
                <div class="sh-stat-card">
                    <div class="sh-stat-top">
                        <span class="sh-stat-label">Tahun Garansi</span>
                        <svg class="sh-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                    </div>
                    <div class="sh-stat-val"><span class="count-up" data-target="15">0</span><span>+</span></div>
                </div>
            </div>
        </div>{{-- end sh-coverage-header-row --}}

        {{-- MAP: from admin upload --}}
        @php $coverageMap = \App\Models\Setting::get('coverage_map'); @endphp
        @if($coverageMap)
            <div style="position:relative; width:100%; margin-top:-6rem;">
                <img src="{{ asset('storage/'.$coverageMap) }}" alt="Peta Jangkauan Indonesia"
                     style="display:block; width:100%; height:auto;" loading="lazy">
            </div>
        @endif
    </div>{{-- end sh-coverage-inner --}}
    
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

{{-- ═══ RELATED ═══ --}}
@if($related->count() > 0)
<section class="sh-related">
    <div class="sh-related-inner">
        <div class="cv-section-label" style="margin-bottom:.75rem;">Produk Lainnya</div>
        <h3 class="sh-related-title">Produk &amp; Layanan Lainnya</h3>
        <div class="sh-related-grid">
            @foreach($related as $r)
                <a href="{{ route_locale('products.show', $r->slug) }}" class="sh-related-card">
                    <img src="{{ $r->image_url }}" alt="{{ $r->name }}" class="sh-related-img" loading="lazy">
                    <div class="sh-related-body">
                        <div class="sh-related-name">{{ $r->name }}</div>
                        <p class="sh-related-desc">{{ $r->short_desc }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══ SEO AUTO TEXT (MINIMALIST) ═══ --}}
<div style="background:var(--surface); padding:2rem 1.5rem; text-align:center; border-top:1px solid var(--border);">
    <div style="max-width:1200px; margin:0 auto; font-size:0.75rem; color:var(--muted); line-height:1.6;">
        @if($service->price > 0)
            Jual {{ $service->name }} di Indonesia. Distributor, Supplier, Agen, {{ $service->name }}. Kami Menjual {{ $service->name }} terlengkap dengan harga termurah di Surabaya, Jawa Timur, Indonesia.
        @else
            Layanan {{ $service->name }} profesional dan terpercaya. Solusi terbaik untuk kebutuhan {{ $service->name }} Anda di Surabaya, Jawa Timur dan sekitarnya.
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: true
    });

    var thumbsEl = document.getElementById('sh-swiper-thumbs');
    if (thumbsEl) {
        var swiperThumbs = new Swiper('#sh-swiper-thumbs', {
            spaceBetween: 8,
            slidesPerView: 'auto',
            freeMode: true,
            watchSlidesProgress: true,
        });
        new Swiper('#sh-swiper-main', {
            spaceBetween: 0,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: { swiper: swiperThumbs },
        });
    } else {
        var mainEl = document.getElementById('sh-swiper-main');
        if (mainEl) new Swiper('#sh-swiper-main', { spaceBetween: 0 });
    }
});
</script>

@endsection
