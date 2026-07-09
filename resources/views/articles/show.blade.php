@extends('layouts.app')
@section('content')

<style>
/* ═══════════════════════════════════════
   DESIGN TOKENS — seragam dengan /about /products /gallery /articles
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
    --font:      'Montserrat', sans-serif;
    --ease:      cubic-bezier(0.22, 1, 0.36, 1);
}
*, *::before, *::after { box-sizing: border-box; }
body { background: var(--c-bg); font-family: var(--font); color: var(--c-text); -webkit-font-smoothing: antialiased; }
img { display: block; }
a { text-decoration: none; color: inherit; }

/* ════ HERO — identik dengan semua page lain ════ */
.sv-hero-premium {
    position: relative;
    padding: 9rem 1.5rem 4rem;
    background: var(--c-surface);
    overflow: hidden;
    border-bottom: 1px solid var(--c-border);
}
.sv-hero-premium::before {
    content:''; position:absolute; top:-150px; right:-100px;
    width:500px; height:500px; border-radius:50%;
    background:radial-gradient(circle,rgba(14,165,233,0.06) 0%,transparent 70%);
    pointer-events:none;
}
.sv-hero-premium::after {
    content:''; position:absolute; bottom:-150px; left:-100px;
    width:600px; height:600px; border-radius:50%;
    background:radial-gradient(circle,rgba(14,165,233,0.04) 0%,transparent 70%);
    pointer-events:none;
}
.sv-hero-inner {
    max-width: 860px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

/* Breadcrumb — 100% identik */
.sv-breadcrumb {
    display:flex; align-items:center; gap:0.5rem;
    font-size:0.75rem; font-weight:500;
    color:var(--c-muted); margin-bottom:2rem; font-family:var(--font);
    flex-wrap: wrap;
}
.sv-breadcrumb a { color:var(--c-muted); text-decoration:none; transition:color 0.2s; }
.sv-breadcrumb a:hover { color:var(--c-accent); }
.sv-breadcrumb-sep { font-size:0.6rem; color:var(--c-muted); opacity:0.5; }
.sv-breadcrumb-current { color:var(--c-text); font-weight:600; }

/* Category badge */
.ar-cat-badge {
    display:inline-flex; align-items:center; gap:0.375rem;
    font-size:0.65rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase;
    background:rgba(14,165,233,0.08); color:var(--c-accent);
    padding:0.3rem 0.875rem; border-radius:50px;
    border:1px solid rgba(14,165,233,0.15);
    font-family:var(--font); margin-bottom:1.25rem;
}

/* Meta row */
.ar-meta-row {
    display:flex; align-items:center; gap:0.625rem;
    font-size:0.8rem; color:var(--c-muted);
    font-family:var(--font); margin-bottom:1.5rem;
    flex-wrap:wrap;
}
.ar-meta-sep { opacity:0.4; }

/* Hero title */
.ar-hero-title {
    font-size:clamp(1.75rem,4vw,2.75rem);
    font-weight:700; line-height:1.25;
    letter-spacing:-0.02em; color:var(--c-text);
    margin-bottom:1.25rem; font-family:var(--font);
}

/* Hero excerpt */
.ar-hero-excerpt {
    font-size:1rem; font-weight:400;
    color:var(--c-muted); line-height:1.75;
    max-width:720px;
}

/* Author row */
.ar-author-row {
    display:flex; align-items:center; gap:0.875rem;
    margin-top:2rem; padding-top:2rem;
    border-top:1px solid var(--c-border);
}
.ar-author-avatar {
    width:42px; height:42px;
    background:var(--c-accent);
    display:flex; align-items:center; justify-content:center;
    border-radius:50%; font-weight:800; color:#fff;
    font-size:1rem; flex-shrink:0; font-family:var(--font);
}
.ar-author-name {
    font-size:0.875rem; font-weight:700; color:var(--c-text);
    font-family:var(--font); margin-bottom:0.125rem;
}
.ar-author-company {
    font-size:0.75rem; color:var(--c-muted); font-family:var(--font);
}

/* ════ FEATURED IMAGE ════ */
.ar-featured-img {
    max-width: 960px;
    margin: 0 auto;
    padding: 0 1.5rem;
}
.ar-featured-img img {
    width:100%; height:auto; max-width:100%;
    border-radius:16px;
    border:1px solid var(--c-border);
    display:block;
    margin-top: 2.5rem;
}

/* ════ BODY LAYOUT ════ */
.ar-body-section {
    padding: 3.5rem 1.5rem 5rem;
    max-width: 860px;
    margin: 0 auto;
}

/* ════ TOC — elegant like FAQ ════ */
.ar-toc {
    background: var(--c-surface);
    border: 1.5px solid var(--c-border);
    border-radius: 16px;
    padding: 0;
    margin-bottom: 2.5rem;
    overflow: hidden;
    transition: border-color 0.3s;
}
.ar-toc:hover { border-color: rgba(14,165,233,0.3); }
.ar-toc-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.125rem 1.5rem;
    border-bottom: 1px solid var(--c-border);
    cursor: pointer; user-select: none;
}
.ar-toc-title {
    font-size:0.7rem; font-weight:700; text-transform:uppercase;
    letter-spacing:0.15em; color:var(--c-accent);
    display:flex; align-items:center; gap:0.5rem;
    font-family:var(--font); margin:0;
}
.ar-toc-title::before {
    content:''; width:4px; height:4px; background:var(--c-accent); border-radius:50%;
}
.ar-toc-body { padding: 1.25rem 1.5rem; }
.ar-toc ol {
    margin:0; padding-left:1.25rem;
    display:flex; flex-direction:column; gap:0.5rem;
}
.ar-toc li { list-style:decimal; }
.ar-toc a {
    font-size:0.875rem; font-weight:500; color:var(--c-muted);
    text-decoration:none; transition:color 0.2s; font-family:var(--font);
    display:flex; align-items:center; gap:0.375rem;
}
.ar-toc a:hover { color:var(--c-accent); }

/* ════ ARTICLE CONTENT ════ */
.ar-content {
    font-size:0.9625rem; line-height:1.9;
    color:#334155; font-family:var(--font);
}
.ar-content h2 {
    font-size:1.375rem; font-weight:700; color:var(--c-text);
    margin:2.75rem 0 1rem; letter-spacing:-0.02em;
    padding-top:0.5rem;
}
.ar-content h3 {
    font-size:1.1rem; font-weight:700; color:var(--c-text);
    margin:2rem 0 0.875rem; letter-spacing:-0.01em;
}
.ar-content p { margin:0 0 1.375rem; }
.ar-content ul, .ar-content ol {
    margin:0 0 1.375rem; padding-left:1.5rem;
}
.ar-content li { margin-bottom:0.4rem; }
.ar-content a { color:var(--c-accent); text-decoration:underline; text-underline-offset:3px; }
.ar-content blockquote {
    border-left:3px solid var(--c-accent);
    padding:1rem 1.375rem;
    background:rgba(14,165,233,0.04);
    margin:2rem 0; border-radius:0 12px 12px 0;
    color:var(--c-muted); font-style:italic;
}
.ar-content code {
    background:rgba(14,165,233,0.06);
    border:1px solid rgba(14,165,233,0.15);
    padding:0.125rem 0.4rem; border-radius:4px;
    font-size:0.85em; color:var(--c-accent);
    font-family:'Fira Code', monospace;
}
.ar-content img {
    max-width:100%; border-radius:12px;
    margin:1.75rem 0; border:1px solid var(--c-border);
}
.ar-content strong { color:var(--c-text); font-weight:700; }

/* ════ FAQ ════ */
.ar-faq { margin-top:3rem; padding-top:2.5rem; border-top:1px solid var(--c-border); }
.ar-faq-title {
    font-size:1.125rem; font-weight:700; color:var(--c-text);
    margin:0 0 1.5rem; display:flex; align-items:center; gap:0.625rem;
    letter-spacing:-0.015em; font-family:var(--font);
}
.ar-faq-list { display:flex; flex-direction:column; gap:0.625rem; }
.ar-faq-item {
    background:var(--c-surface);
    border:1.5px solid var(--c-border);
    border-radius:12px; overflow:hidden;
    transition:border-color 0.3s;
}
.ar-faq-item:hover { border-color:rgba(14,165,233,0.3); }
.ar-faq-item[open] { border-color:var(--c-accent); }
.ar-faq-item summary {
    padding:1rem 1.25rem;
    font-size:0.9rem; font-weight:600; color:var(--c-text);
    cursor:pointer; list-style:none;
    display:flex; justify-content:space-between; align-items:center;
    gap:1rem; user-select:none; font-family:var(--font);
}
.ar-faq-item summary::-webkit-details-marker { display:none; }
.ar-faq-chevron { flex-shrink:0; transition:transform 0.3s var(--ease); color:var(--c-accent); }
.ar-faq-item[open] .ar-faq-chevron { transform:rotate(180deg); }
.ar-faq-answer {
    padding:0.875rem 1.25rem 1.25rem;
    border-top:1px solid var(--c-border);
    font-size:0.875rem; color:var(--c-muted);
    line-height:1.75; font-family:var(--font);
}

/* ════ CTA INLINE ════ */
.ar-cta-box {
    margin-top:3rem;
    background:linear-gradient(135deg,#0EA5E9,#0284C7);
    padding:2.5rem 2rem; border-radius:20px;
    text-align:center; position:relative; overflow:hidden;
}
.ar-cta-box::before {
    content:''; position:absolute; top:-60px; right:-60px;
    width:200px; height:200px;
    background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 70%);
    pointer-events:none;
}
.ar-cta-box h3 {
    font-size:1.25rem; font-weight:700; color:#fff;
    margin-bottom:0.75rem; font-family:var(--font);
    position:relative; z-index:1;
}
.ar-cta-box p {
    font-size:0.9rem; color:rgba(255,255,255,0.85);
    margin:0 0 1.5rem; line-height:1.6;
    position:relative; z-index:1; font-family:var(--font);
}
.ar-cta-btn {
    display:inline-flex; align-items:center; gap:0.5rem;
    background:#fff; color:var(--c-accent);
    font-size:0.9rem; font-weight:700; padding:0.875rem 2rem;
    border-radius:50px; border:none; cursor:pointer;
    text-decoration:none !important; transition:all 0.3s;
    font-family:var(--font); position:relative; z-index:1;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
}
.ar-cta-btn:hover { transform:translateY(-2px); box-shadow:0 12px 25px rgba(0,0,0,0.2); }

/* ════ TAGS & SHARE ════ */
.ar-tags {
    margin-top:2.5rem; padding-top:2rem;
    border-top:1px solid var(--c-border);
    display:flex; gap:0.5rem; flex-wrap:wrap; align-items:center;
}
.ar-tags-label {
    font-size:0.7rem; font-weight:700; color:var(--c-muted);
    text-transform:uppercase; letter-spacing:0.14em; font-family:var(--font);
}
.ar-tag {
    font-size:0.75rem; font-weight:500;
    background:var(--c-surface); border:1.5px solid var(--c-border);
    color:var(--c-muted); padding:0.3rem 0.875rem; border-radius:50px;
    transition:all 0.2s; font-family:var(--font);
}
.ar-tag:hover { border-color:var(--c-accent); color:var(--c-accent); }
.ar-share {
    margin-top:2rem; padding-top:2rem;
    border-top:1px solid var(--c-border);
    display:flex; align-items:center; gap:0.875rem; flex-wrap:wrap;
}
.ar-share-label {
    font-size:0.75rem; font-weight:700; color:var(--c-muted);
    text-transform:uppercase; letter-spacing:0.1em; font-family:var(--font);
}
.ar-share-btn {
    display:inline-flex; align-items:center; gap:0.4rem;
    font-size:0.8rem; font-weight:600;
    border:1.5px solid; padding:0.45rem 0.875rem;
    border-radius:50px; cursor:pointer; text-decoration:none !important;
    transition:all 0.25s; font-family:var(--font); white-space:nowrap;
}
.ar-share-btn:hover { opacity:0.8; transform:translateY(-1px); }

/* ════ RELATED ARTICLES ════ */
.ar-related {
    padding:4.5rem 1.5rem;
    background:var(--c-surface);
    border-top:1px solid var(--c-border);
}
.ar-related-inner { max-width:1200px; margin:0 auto; }
.ar-related-header {
    display:flex; align-items:flex-end; justify-content:space-between;
    flex-wrap:wrap; gap:1rem; margin-bottom:2.5rem;
}
.ar-related-label {
    font-size:0.75rem; font-weight:700; letter-spacing:0.15em;
    text-transform:uppercase; color:var(--c-muted);
    display:flex; align-items:center; gap:0.5rem; margin-bottom:0.75rem;
    font-family:var(--font);
}
.ar-related-label::before {
    content:''; width:4px; height:4px; background:var(--c-accent); border-radius:50%;
}
.ar-related-title {
    font-size:clamp(1.5rem,2.5vw,2.25rem); font-weight:500;
    color:var(--c-text); letter-spacing:-0.025em; font-family:var(--font);
}
.ar-related-link {
    display:inline-flex; align-items:center; gap:0.375rem;
    font-size:0.875rem; font-weight:600; color:var(--c-muted);
    border:1.5px solid var(--c-border); border-radius:50px;
    padding:0.625rem 1.25rem; transition:all 0.25s;
    font-family:var(--font); white-space:nowrap;
}
.ar-related-link:hover { border-color:var(--c-text); color:var(--c-text); }
.ar-related-grid {
    display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem;
}
.ar-related-card {
    background:var(--c-card); border:1.5px solid var(--c-border);
    border-radius:20px; overflow:hidden; display:block;
    text-decoration:none !important; transition:all 0.35s var(--ease);
}
.ar-related-card:hover {
    border-color:var(--c-accent);
    transform:translateY(-5px);
    box-shadow:0 16px 40px rgba(14,165,233,0.09);
}
.ar-related-card-img { aspect-ratio:16/10; overflow:hidden; background:var(--c-surface); }
.ar-related-card-img img {
    width:100%; height:100%; object-fit:cover;
    transition:transform 0.55s var(--ease);
}
.ar-related-card:hover .ar-related-card-img img { transform:scale(1.07); }
.ar-related-card-body { padding:1.25rem; }
.ar-related-cat {
    font-size:0.62rem; font-weight:700; letter-spacing:0.1em;
    text-transform:uppercase; color:var(--c-accent);
    margin-bottom:0.5rem; font-family:var(--font);
}
.ar-related-card-title {
    font-size:0.9375rem; font-weight:700; color:var(--c-text);
    line-height:1.45; font-family:var(--font);
    display:-webkit-box; -webkit-line-clamp:2;
    -webkit-box-orient:vertical; overflow:hidden;
}

/* ════ RESPONSIVE ════ */
@media (max-width:860px) {
    .ar-related-grid { grid-template-columns:repeat(2,1fr); }
}
@media (max-width:640px) {
    .sv-hero-premium { padding:7rem 1rem 3rem; }
    .ar-body-section { padding:2.5rem 1rem 4rem; }
    .ar-related { padding:3rem 1rem; }
    .ar-related-grid { grid-template-columns:1fr; }
    .ar-related-header { flex-direction:column; align-items:flex-start; }
    .ar-featured-img { padding:0 1rem; }
    .ar-cta-box { padding:2rem 1.25rem; }
}
</style>

{{-- ════ HERO ════ --}}
<section class="sv-hero-premium">
    <div class="sv-hero-inner">

        {{-- Breadcrumb --}}
        <nav class="sv-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route_locale('home') }}">Beranda</a>
            <span class="sv-breadcrumb-sep">/</span>
            <a href="{{ $seo['canonical'] ?? route_locale('articles') }}">Artikel &amp; Tips</a>
            <span class="sv-breadcrumb-sep">/</span>
            <span class="sv-breadcrumb-current">{{ Str::limit($trans?->title ?? $article->slug, 50) }}</span>
        </nav>

        @if($article->category)
        <div class="ar-cat-badge">{{ $article->category }}</div>
        @endif

        <div class="ar-meta-row">
            <span>{{ $article->formatted_date }}</span>
            <span class="ar-meta-sep">·</span>
            <span>{{ $readTime ?? $article->read_time }} menit baca</span>
            <span class="ar-meta-sep">·</span>
            <span>{{ number_format($article->views) }} views</span>
        </div>

        <h1 class="ar-hero-title">{{ $trans?->title ?? $article->slug }}</h1>
        <p class="ar-hero-excerpt">{{ $trans?->excerpt }}</p>

        @if(isset($article->authorRel) && $article->authorRel->slug)
        <a href="{{ url("/{$locale}/author/" . $article->authorRel->slug) }}" class="ar-author-row" style="text-decoration:none; display:inline-flex; transition:all .2s; padding-right:1rem; border-radius:12px; margin-left:-0.5rem; padding-left:0.5rem; border-top:none; margin-top:1.5rem; padding-top:0.5rem; border:1px solid transparent;" onmouseover="this.style.background='rgba(14,165,233,0.05)';this.style.borderColor='rgba(14,165,233,0.1)'" onmouseout="this.style.background='transparent';this.style.borderColor='transparent'">
        @else
        <div class="ar-author-row" style="border-top:none; margin-top:1.5rem; padding-top:0.5rem;">
        @endif
            <div class="ar-author-avatar" style="background:transparent; width:42px; height:42px; overflow:hidden;">
            @if(isset($article->authorRel) && $article->authorRel->getRawOriginal('photo'))
                <img src="{{ asset('storage/'.$article->authorRel->getRawOriginal('photo')) }}" alt="{{ $article->authorRel->name }}" style="width:100%; height:100%; object-fit:cover;">
            @elseif(!empty($settings['logo']))
                <img src="{{ asset('storage/'.$settings['logo']) }}" alt="Cyclevent" style="width:100%; height:100%; object-fit:contain;">
            @else
                <span style="background:var(--c-accent); width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:1rem; border-radius:50%;">C</span>
            @endif
            </div>
            <div>
                <div class="ar-author-name" style="transition:color .2s; {{ isset($article->authorRel) && $article->authorRel->slug ? 'color:var(--c-accent);' : '' }}">{{ isset($article->authorRel) ? $article->authorRel->name : ($article->author ?? 'Tim Cyclevent') }}</div>
                <div class="ar-author-company">Cyclevent — Turbine Ventilator Indonesia</div>
            </div>
        @if(isset($article->authorRel) && $article->authorRel->slug)
        </a>
        @else
        </div>
        @endif
    </div>
</section>

{{-- ════ FEATURED IMAGE ════ --}}
@if($article->image)
<div class="ar-featured-img">
    <img src="{{ asset('storage/' . $article->image) }}"
         alt="{{ $trans?->thumbnail_alt ?? ($article->alt_text ?? ($trans?->title ?? $article->title)) }}"
         loading="eager">
</div>
@endif

{{-- ════ ARTICLE BODY ════ --}}
<section class="ar-body-section">

    {{-- TOC — elegant premium style ════ --}}
    @if($article->show_toc && count($article->toc) > 0)
    <details class="ar-toc" open>
        <summary class="ar-toc-header" style="list-style:none; outline:none;">
            <div class="ar-toc-title">
                Daftar Isi
            </div>
            <svg style="color:var(--c-accent); flex-shrink:0; transition:transform 0.3s;" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </summary>
        <div class="ar-toc-body">
            <ol>
                @foreach($article->toc as $item)
                <li style="padding-left:{{ ($item['level'] - 2) * 0.875 }}rem;">
                    <a href="#{{ $item['id'] }}">{{ $item['text'] }}</a>
                </li>
                @endforeach
            </ol>
        </div>
    </details>
    @endif

    {{-- Article Content --}}
    <article class="ar-content" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
        @if(!empty($trans?->featured_snippet))
        <div class="featured-snippet-box" style="padding:1.5rem; background:#F8FAFC; border-left:4px solid var(--c-accent); border-radius:8px; margin-bottom:2rem;">
            <strong style="color:var(--c-accent); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.05em; display:block; margin-bottom:0.5rem;">{{ $locale === 'ar' ? 'ملخص سريع' : ($locale === 'en' ? 'Quick Summary' : ($locale === 'ko' ? '요약' : 'Ringkasan Cepat')) }}</strong>
            <span style="font-size:1.05rem; line-height:1.6; color:#0F172A; font-weight:500;">{{ $trans->featured_snippet }}</span>
        </div>
        @endif
        @php
            // Inject TOC IDs into headings
            $renderedContent = preg_replace_callback('/<h([23])([^>]*)>(.*?)<\/h[23]>/i', function($m) {
                $text = strip_tags($m[3]);
                $id   = \Illuminate\Support\Str::slug($text);
                if (str_contains($m[2], 'id=')) return $m[0];
                return "<h{$m[1]} id=\"{$id}\"{$m[2]}>{$m[3]}</h{$m[1]}>";
            }, $trans?->content ?? '');
        @endphp
        {!! $renderedContent !!}
    </article>

    {{-- Author Bio --}}
    @if(isset($article->authorRel))
        @php
            $authorTrans = $article->authorRel->translations->where('locale', $locale)->first();
        @endphp
        @if($authorTrans && !empty($authorTrans->bio))
        <div class="ar-author-bio-box" style="margin-top:3.5rem; padding:2rem; background:#ffffff; border:1px solid #E2E8F0; border-radius:16px; display:flex; gap:1.5rem; align-items:flex-start; box-shadow:0 10px 25px rgba(0,0,0,0.02);" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
            <div style="width:72px; height:72px; border-radius:50%; overflow:hidden; flex-shrink:0; background:#F1F5F9;">
                @if($article->authorRel->getRawOriginal('photo'))
                    <img src="{{ asset('storage/'.$article->authorRel->getRawOriginal('photo')) }}" alt="{{ $article->authorRel->name }}" style="width:100%; height:100%; object-fit:cover;">
                @else
                    <span style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:1.5rem; font-weight:700; color:#94A3B8;">{{ substr($article->authorRel->name, 0, 1) }}</span>
                @endif
            </div>
            <div>
                <h4 style="margin:0 0 0.5rem; font-size:1.125rem; font-weight:700; color:#0F172A; font-family:var(--font);">
                    @if($article->authorRel->slug)
                        <a href="{{ url("/{$locale}/author/" . $article->authorRel->slug) }}" style="color:inherit; transition:color .2s;" onmouseover="this.style.color='var(--c-accent)'" onmouseout="this.style.color='inherit'">{{ $article->authorRel->name }}</a>
                    @else
                        {{ $article->authorRel->name }}
                    @endif
                </h4>
                <p style="margin:0; font-size:0.95rem; color:#475569; line-height:1.6; font-family:var(--font);">{{ $authorTrans->bio }}</p>
                @if(!empty($article->authorRel->social_links))
                    <div style="margin-top:1rem; display:flex; gap:0.75rem;">
                        @foreach($article->authorRel->social_links as $sname => $surl)
                            @if(!empty($surl))
                            <a href="{{ $surl }}" target="_blank" rel="noopener noreferrer" style="font-size:0.8rem; font-weight:600; color:var(--c-accent); text-decoration:none;">{{ ucfirst($sname) }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @endif
    @endif

    {{-- Internal Link CTA to Products --}}
    <div style="position:relative; overflow:hidden; background:linear-gradient(135deg, #ffffff 0%, #F8FAFC 100%); border:1px solid #E2E8F0; padding:2rem 2.5rem; margin:2.5rem 0; border-radius:16px; box-shadow:0 12px 32px rgba(15,23,42,0.04); display:flex; flex-direction:column; gap:1.25rem;">
        <div style="position:absolute; top:-50px; right:-50px; width:150px; height:150px; background:radial-gradient(circle, rgba(14,165,233,0.1) 0%, transparent 70%); border-radius:50%; pointer-events:none;"></div>
        <div style="position:absolute; bottom:-30px; right:10%; width:100px; height:100px; background:radial-gradient(circle, rgba(14,165,233,0.05) 0%, transparent 70%); border-radius:50%; pointer-events:none;"></div>
        
        <div style="display:flex; align-items:center; gap:1rem;">
            <div style="width:42px; height:42px; border-radius:12px; background:rgba(14,165,233,0.08); color:#0EA5E9; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h4 style="margin:0; font-size:1.15rem; color:#0F172A; font-weight:700; letter-spacing:-0.01em;">Butuh Solusi Sirkulasi Udara Pabrik?</h4>
        </div>
        
        <p style="margin:0; color:#475569; font-size:0.95rem; line-height:1.65; max-width:95%;">Tingkatkan produktivitas kerja dengan Cyclevent Turbine Ventilator. Bergaransi resmi, tahan lama, dan 100% bebas biaya listrik.</p>
        
        <a href="{{ url('/products') }}" style="align-self:flex-start; margin-top:0.25rem; display:inline-flex; align-items:center; gap:0.5rem; background:#0EA5E9; color:#fff; padding:0.75rem 1.75rem; border-radius:50px; font-weight:600; text-decoration:none; font-size:0.925rem; transition:all 0.3s; box-shadow:0 4px 12px rgba(14,165,233,0.2);" onmouseover="this.style.background='#0284C7'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(14,165,233,0.3)';" onmouseout="this.style.background='#0EA5E9'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(14,165,233,0.2)';">
            Lihat Spesifikasi Produk
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>

    {{-- FAQ --}}
    @php $articleFaqs = $trans?->faqs ?? []; @endphp
    @if(!empty($articleFaqs))
    <div class="ar-faq">
        <h2 class="ar-faq-title">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--c-accent);">
                <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/>
            </svg>
            Pertanyaan Umum (FAQ)
        </h2>
        <div class="ar-faq-list">
            @foreach($articleFaqs as $faq)
            @if(!empty($faq['q']))
            <details class="ar-faq-item">
                <summary>
                    {{ $faq['q'] }}
                    <svg class="ar-faq-chevron" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </summary>
                <div class="ar-faq-answer">{{ $faq['a'] ?? '' }}</div>
            </details>
            @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- CTA Box --}}
    @php $articleCta = $trans?->cta_button ?? null; @endphp
    @if($articleCta && !empty($articleCta['text']))
    @php
        $cta = $articleCta;
        $ctaWa = \App\Models\WaSetting::primary();
    @endphp
    <div class="ar-cta-box">
        <h3>Tertarik Pasang Turbine Ventilator?</h3>
        <p>Tim teknis Cyclevent siap membantu Anda memilih dan memasang solusi ventilasi yang tepat secara gratis.</p>
        <button onclick="openOrderModal('Artikel CTA: {{ addslashes($trans?->title ?? $article->slug) }}')" class="ar-cta-btn">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            {{ $cta['text'] }}
        </button>
    </div>
    @endif

    {{-- Tags --}}
    @if($article->tags)
    <div class="ar-tags">
        <span class="ar-tags-label">Tags:</span>
        @foreach($article->tags as $tag)
        <span class="ar-tag">{{ $tag }}</span>
        @endforeach
    </div>
    @endif

    {{-- Share — all social media --}}
    <div class="ar-share">
        <span class="ar-share-label">Bagikan:</span>

        {{-- Share --}}
    @php
        $shareUrl   = urlencode($seo['canonical'] ?? url()->current());
        $shareTitle = urlencode($trans?->title ?? $article->slug);
    @endphp
        <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener" class="ar-share-btn" style="color:#25D366;background:rgba(37,211,102,0.08);border-color:rgba(37,211,102,0.25);">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            WA
        </a>

        {{-- Facebook --}}
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" class="ar-share-btn" style="color:#1877F2;background:rgba(24,119,242,0.08);border-color:rgba(24,119,242,0.25);">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
            FB
        </a>

        {{-- Twitter / X --}}
        <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener" class="ar-share-btn" style="color:#000;background:rgba(0,0,0,0.05);border-color:rgba(0,0,0,0.12);">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.259 5.632zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            X
        </a>

        {{-- LinkedIn --}}
        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" class="ar-share-btn" style="color:#0A66C2;background:rgba(10,102,194,0.08);border-color:rgba(10,102,194,0.25);">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
            LinkedIn
        </a>

        {{-- Telegram --}}
        <a href="https://t.me/share/url?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener" class="ar-share-btn" style="color:#229ED9;background:rgba(34,158,217,0.08);border-color:rgba(34,158,217,0.25);">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
            Telegram
        </a>

        {{-- Copy Link --}}
        <button id="copyBtn" class="ar-share-btn" style="color:var(--c-muted);background:var(--c-surface);border-color:var(--c-border); cursor:pointer;"
                onclick="navigator.clipboard.writeText(window.location.href);this.innerHTML='<svg width=&quot;14&quot; height=&quot;14&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; viewBox=&quot;0 0 24 24&quot;><polyline points=&quot;20 6 9 17 4 12&quot;/></svg> Tersalin!';setTimeout(()=>this.innerHTML='<svg width=&quot;14&quot; height=&quot;14&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; viewBox=&quot;0 0 24 24&quot;><path d=&quot;M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71&quot;/><path d=&quot;M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71&quot;/></svg> Salin Link',2000)">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
            Salin Link
        </button>
    </div>

</section>

{{-- ════ KEUNGGULAN + APLIKASI + COVERAGE — from homepage ════ --}}
@php
    // Reuse the CSS & HTML classes already defined in home/index
    // We include the styles inline here for standalone use
@endphp
<style>
/* ─── shared section styles (same as homepage) ─── */
.cv-adv-premium { background:#ffffff; padding:5rem 0; position:relative; overflow:hidden; }
.cv-adv-premium::before { content:''; position:absolute; top:-200px; right:-200px; width:600px; height:600px; background:radial-gradient(circle,rgba(14,165,233,0.04) 0%,transparent 70%); pointer-events:none; }
.cv-adv-inner { max-width:1200px; margin:0 auto; padding:0 1.5rem; }
.cv-adv-header { display:flex; align-items:flex-end; justify-content:space-between; gap:2rem; margin-bottom:3.5rem; flex-wrap:wrap; }
.cv-adv-section-label { font-size:0.75rem; font-weight:700; letter-spacing:0.15em; text-transform:uppercase; color:#64748B; display:flex; align-items:center; gap:0.5rem; margin-bottom:1rem; }
.cv-adv-section-label::before { content:''; width:4px; height:4px; border-radius:50%; background:#0EA5E9; }
.cv-adv-section-title { font-size:clamp(2rem,3.5vw,3rem); font-weight:500; color:#0F172A; line-height:1.15; letter-spacing:-0.025em; }
.cv-adv-cards { display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; }
.cv-adv-card-v2 { background:#F1F5F9; border-radius:22px; padding:2rem; position:relative; overflow:hidden; display:flex; flex-direction:column; min-height:240px; transition:transform 0.3s cubic-bezier(0.22,1,0.36,1),box-shadow 0.3s; }
.cv-adv-card-v2:hover { transform:translateY(-6px); box-shadow:0 20px 50px rgba(14,165,233,0.1); }
.cv-adv-card-v2.accent { background:#0EA5E9; }
.cv-adv-card-v2.accent-dark { background:#0F172A; }
.cv-adv-card-icon-wrap { width:48px; height:48px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-bottom:1.5rem; flex-shrink:0; }
.cv-adv-card-icon-wrap.blue-bg { background:#E0F2FE; color:#0EA5E9; }
.cv-adv-card-icon-wrap.white-bg { background:rgba(255,255,255,0.2); color:#fff; }
.cv-adv-card-icon-wrap.dark-bg { background:rgba(255,255,255,0.06); color:#38BDF8; }
.cv-adv-card-num { font-size:2.75rem; font-weight:400; line-height:1; letter-spacing:-0.04em; color:#0F172A; margin-bottom:0.5rem; }
.cv-adv-card-num.white { color:#fff; } .cv-adv-card-num.blue { color:#38BDF8; }
.cv-adv-card-title { font-size:1rem; font-weight:600; color:#0F172A; margin-bottom:0.5rem; }
.cv-adv-card-title.white { color:#fff; } .cv-adv-card-title.light { color:rgba(255,255,255,0.9); }
.cv-adv-card-desc { font-size:0.8125rem; line-height:1.65; color:#64748B; margin-top:auto; }
.cv-adv-card-desc.white { color:rgba(255,255,255,0.75); }

/* APPS */
.cv-apps-premium { background:#F8FAFC; padding:5rem 0; }
.cv-apps-inner { max-width:1200px; margin:0 auto; padding:0 1.5rem; }
.cv-apps-header { max-width:600px; margin-bottom:3rem; }
.cv-apps-grid-v2 { display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; }
.cv-app-card-v2 { background:#ffffff; border:1.5px solid #E2E8F0; border-radius:20px; padding:1.75rem 1.5rem; display:flex; flex-direction:column; gap:1rem; transition:all 0.3s cubic-bezier(0.22,1,0.36,1); }
.cv-app-card-v2:hover { border-color:#0EA5E9; transform:translateY(-6px); box-shadow:0 16px 40px rgba(14,165,233,0.1); }
.cv-app-icon-circle { width:50px; height:50px; background:#F0F9FF; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#0EA5E9; flex-shrink:0; transition:all 0.3s; }
.cv-app-card-v2:hover .cv-app-icon-circle { background:#0EA5E9; color:#fff; }
.cv-app-card-title-v2 { font-size:0.9375rem; font-weight:700; color:#0F172A; margin:0; font-family:var(--font); }
.cv-app-card-desc-v2 { font-size:0.8125rem; color:#64748B; line-height:1.65; margin:0; font-family:var(--font); }

/* COVERAGE */
.cv-coverage-ar { background:#EAEBED; padding:5rem 0 6rem; position:relative; overflow:hidden; }
.cv-coverage-ar-inner { max-width:1200px; margin:0 auto; padding:0 1.5rem; position:relative; z-index:2; }
.cv-coverage-title-v2 { font-size:clamp(2rem,4vw,3.5rem); font-weight:500; color:#0F172A; line-height:1.1; letter-spacing:-0.04em; max-width:500px; margin-bottom:3rem; font-family:var(--font); }
.cv-coverage-stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; margin-bottom:2rem; }
.cv-stat-card-v2 { background:#ffffff; border-radius:16px; padding:1.5rem; box-shadow:0 10px 40px rgba(0,0,0,0.04); display:flex; flex-direction:column; transition:transform 0.3s; }
.cv-stat-card-v2:hover { transform:translateY(-5px); }
.cv-stat-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem; }
.cv-stat-label { font-size:0.65rem; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:0.1em; font-family:var(--font); }
.cv-stat-icon { color:#0F172A; opacity:0.8; }
.cv-stat-val { font-size:3.5rem; font-weight:400; color:#0F172A; line-height:1; letter-spacing:-0.05em; font-family:var(--font); }
.cv-stat-val span { color:#0EA5E9; font-size:2rem; vertical-align:super; font-weight:500; }

/* Responsive */
@media (max-width:1024px) {
    .cv-adv-cards { grid-template-columns:repeat(2,1fr); }
    .cv-apps-grid-v2 { grid-template-columns:repeat(2,1fr); }
    .cv-coverage-stats-grid { grid-template-columns:repeat(2,1fr); }
}
@media (max-width:640px) {
    .cv-adv-premium, .cv-apps-premium, .cv-coverage-ar { padding:3.5rem 0; }
    .cv-adv-cards { grid-template-columns:1fr; gap:1rem; }
    .cv-adv-card-v2 { min-height:180px; }
    .cv-apps-grid-v2 { grid-template-columns:1fr; gap:1rem; }
    .cv-coverage-stats-grid { grid-template-columns:repeat(2,1fr); gap:1rem; }
    .cv-stat-val { font-size:2.5rem; }
    .cv-adv-card-v2[style*="grid-column"] { grid-column:span 1 !important; flex-direction:column !important; }
}
</style>

{{-- KEUNGGULAN --}}
<section class="cv-adv-premium" id="keunggulan">
    <div class="cv-adv-inner">
        <div class="cv-adv-header">
            <div>
                <div class="cv-adv-section-label">KEUNGGULAN</div>
                <h2 class="cv-adv-section-title">Mengapa Pilih<br>Cyclevent?</h2>
            </div>
            <p style="max-width:320px;font-size:0.875rem;color:#64748B;line-height:1.65;text-align:right;font-family:var(--font);">Didesain untuk iklim tropis Indonesia, dibuktikan oleh ratusan proyek dari Sabang sampai Merauke.</p>
        </div>
        <div class="cv-adv-cards">
            <div class="cv-adv-card-v2 accent" data-aos="fade-up">
                <div class="cv-adv-card-icon-wrap white-bg"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <div class="cv-adv-card-num white">15+</div>
                <div class="cv-adv-card-title white">Garansi 15 Tahun</div>
                <div class="cv-adv-card-desc white">Garansi tidak berkarat & tidak rusak. Garansi instalasi 5 tahun dan sparepart 5 tahun.</div>
            </div>
            <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="80">
                <div class="cv-adv-card-icon-wrap blue-bg"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                <div class="cv-adv-card-num">0W</div>
                <div class="cv-adv-card-title">Tanpa Listrik</div>
                <div class="cv-adv-card-desc">Bertenaga sepenuhnya dari angin. Tidak ada tagihan listrik, nol risiko korsleting.</div>
            </div>
            <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="160">
                <div class="cv-adv-card-icon-wrap blue-bg"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div class="cv-adv-card-num">24/7</div>
                <div class="cv-adv-card-title">Non-Stop 365 Hari</div>
                <div class="cv-adv-card-desc">Bebas perawatan dan beroperasi 24 jam sehari, 365 hari setahun tanpa henti.</div>
            </div>
            <div class="cv-adv-card-v2 accent-dark" data-aos="fade-up" data-aos-delay="240">
                <div class="cv-adv-card-icon-wrap dark-bg"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                <div class="cv-adv-card-num blue">257</div>
                <div class="cv-adv-card-title light">Kapasitas Hisap Superior</div>
                <div class="cv-adv-card-desc white">Hingga 257,87 m³/menit — jauh lebih tinggi dari ventilator tipe stasioner manapun.</div>
            </div>
            <div class="cv-adv-card-v2" data-aos="fade-up">
                <div class="cv-adv-card-icon-wrap blue-bg"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
                <div class="cv-adv-card-title" style="margin-top:auto;">100% Anti Tampias Hujan</div>
                <div class="cv-adv-card-desc">Desain khusus memastikan air hujan tidak masuk ke dalam bangunan dalam kondisi apapun.</div>
            </div>
            <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="80">
                <div class="cv-adv-card-icon-wrap blue-bg"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg></div>
                <div class="cv-adv-card-title" style="margin-top:auto;">Cocok Iklim Tropis</div>
                <div class="cv-adv-card-desc">Dioptimalkan untuk kondisi panas dan lembab Indonesia, efektif bahkan di angin minimum.</div>
            </div>
            <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="160" style="grid-column:span 2; flex-direction:row; gap:2rem; align-items:center;">
                <div class="cv-adv-card-icon-wrap blue-bg" style="flex-shrink:0; width:60px; height:60px;"><svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
                <div>
                    <div class="cv-adv-card-title" style="font-size:1.125rem; margin-bottom:0.5rem;">Desain Konstruksi USA</div>
                    <div class="cv-adv-card-desc">Mengikuti standar desain USA dengan powder coating pada rangka bola dan topi bola untuk ketahanan dan keawetan maksimal di iklim tropis yang ekstrem.</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- APLIKASI --}}
<section class="cv-apps-premium" id="aplikasi">
    <div class="cv-apps-inner">
        <div class="cv-apps-header">
            <div class="cv-adv-section-label">APLIKASI</div>
            <h2 class="cv-adv-section-title" style="margin-top:0.75rem;">Cocok untuk<br>Berbagai Bangunan</h2>
            <p style="margin-top:1rem;font-size:0.875rem;color:#64748B;line-height:1.65;font-family:var(--font);">Cyclevent terbukti efektif di berbagai jenis bangunan — dari rumah tinggal hingga pabrik skala besar.</p>
        </div>
        <div class="cv-apps-grid-v2">
            @foreach([
                ['<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/></svg>', 'Pabrik & Industri', 'Membuang udara panas, debu, dan partikel berbahaya secara otomatis.'],
                ['<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>', 'Gudang', 'Sirkulasi udara besar-besaran tanpa biaya listrik tambahan.'],
                ['<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>', 'Restoran & Dapur', 'Menghilangkan asap, bau memasak, dan menjaga kenyamanan.'],
                ['<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>', 'Rumah Tinggal', 'Mencegah plafon lembab, jamur, dan retak akibat kondensasi.'],
                ['<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>', 'Gedung Olahraga', 'Udara segar konstan untuk mendukung performa optimal.'],
                ['<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>', 'Perkantoran', 'Ventilasi alami yang nyaman tanpa suara bising mesin.'],
                ['<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>', 'Tempat Ibadah', 'Sirkulasi tenang dan efisien, cocok untuk suasana ibadah.'],
                ['<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 17l4-8 4 5 3-3 4 6"/><circle cx="17" cy="8" r="2"/></svg>', 'Peternakan & Pertanian', 'Menjaga sirkulasi kandang dan greenhouse tetap optimal dan nyaman.'],
            ] as $i => $app)
            <div class="cv-app-card-v2" data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
                <div class="cv-app-icon-circle">{!! $app[0] !!}</div>
                <div>
                    <p class="cv-app-card-title-v2">{{ $app[1] }}</p>
                    <p class="cv-app-card-desc-v2">{{ $app[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- MELAYANI SELURUH INDONESIA --}}
<section class="cv-coverage-ar" id="jangkauan-artikel">
    <style>
    @keyframes pulse-ar { 0%{transform:scale(1);opacity:0.6;} 50%{transform:scale(1.5);opacity:0;} 100%{transform:scale(1);opacity:0;} }
    </style>
    <div style="position:absolute;top:45%;left:50%;transform:translate(-50%,-50%);width:100%;max-width:1100px;z-index:1;pointer-events:none;">
        <img src="https://www.amcharts.com/lib/3/maps/svg/indonesiaLow.svg" alt="Peta Indonesia" style="width:100%;height:auto;filter:grayscale(100%) brightness(0.85) contrast(1.1) opacity(0.5);">
        <div style="position:absolute;top:71%;left:30.5%;width:20px;height:20px;"><div style="position:absolute;inset:0;background:#EF4444;border-radius:50%;opacity:0.6;animation:pulse-ar 2s infinite;"></div><div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:8px;height:8px;background:#EF4444;border-radius:50%;"></div></div>
        <div style="position:absolute;top:75.5%;left:40.5%;width:16px;height:16px;"><div style="position:absolute;inset:0;background:#EF4444;border-radius:50%;opacity:0.5;animation:pulse-ar 2.2s infinite;"></div><div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:6px;height:6px;background:#EF4444;border-radius:50%;"></div></div>
        <div style="position:absolute;top:24%;left:10%;width:16px;height:16px;"><div style="position:absolute;inset:0;background:#EF4444;border-radius:50%;opacity:0.5;animation:pulse-ar 2.5s infinite;"></div><div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:6px;height:6px;background:#EF4444;border-radius:50%;"></div></div>
        <div style="position:absolute;top:65%;left:58.5%;width:16px;height:16px;"><div style="position:absolute;inset:0;background:#EF4444;border-radius:50%;opacity:0.5;animation:pulse-ar 2.1s infinite;"></div><div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:6px;height:6px;background:#EF4444;border-radius:50%;"></div></div>
    </div>
    <div class="cv-coverage-ar-inner">
        <h2 class="cv-coverage-title-v2">Melayani<br>seluruh Indonesia</h2>
        <div class="cv-coverage-stats-grid">
            <div class="cv-stat-card-v2" data-aos="fade-up">
                <div class="cv-stat-top"><span class="cv-stat-label">Berdiri Sejak</span><svg class="cv-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 22h20M12 2v20M5 22V10l7-8 7 8v12M8 14h8M8 18h8"/></svg></div>
                <div class="cv-stat-val">{{ \App\Models\Setting::get('founding_year') ?? '2013' }}</div>
            </div>
            <div class="cv-stat-card-v2" data-aos="fade-up" data-aos-delay="100">
                <div class="cv-stat-top"><span class="cv-stat-label">Klien Aktif</span><svg class="cv-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg></div>
                <div class="cv-stat-val">500<span>+</span></div>
            </div>
            <div class="cv-stat-card-v2" data-aos="fade-up" data-aos-delay="200">
                <div class="cv-stat-top"><span class="cv-stat-label">Kota Dilayani</span><svg class="cv-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                <div class="cv-stat-val">50<span>+</span></div>
            </div>
            <div class="cv-stat-card-v2" data-aos="fade-up" data-aos-delay="300">
                <div class="cv-stat-top"><span class="cv-stat-label">Tahun Garansi</span><svg class="cv-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg></div>
                <div class="cv-stat-val">15<span>+</span></div>
            </div>
        </div>
    </div>
</section>

{{-- ════ RELATED ARTICLES ════ --}}
@if($related->count())
<section class="ar-related">
    <div class="ar-related-inner">
        <div class="ar-related-header">
            <div>
                <div class="ar-related-label">Baca Juga</div>
                <h2 class="ar-related-title">Artikel Terkait</h2>
            </div>
            <a href="{{ route_locale('articles') }}" class="ar-related-link">
                Semua Artikel
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        <div class="ar-related-grid">
            @foreach($related as $r)
            <a href="{{ route_locale('articles.show', $r->slug) }}" class="ar-related-card" data-aos="fade-up">
                <div class="ar-related-card-img">
                    @if($r->image)
                        <img src="{{ asset('storage/' . $r->image) }}" alt="{{ $r->title }}" loading="lazy">
                    @else
                        <div style="width:100%;height:100%;min-height:160px;background:linear-gradient(135deg,#E2E8F0,#CBD5E1);display:flex;align-items:center;justify-content:center;">
                            <svg width="28" height="28" fill="none" stroke="#94A3B8" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                    @endif
                </div>
                <div class="ar-related-card-body">
                    @if($r->category)
                    <div class="ar-related-cat">{{ $r->category }}</div>
                    @endif
                    <h3 class="ar-related-card-title">{{ $r->title }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
