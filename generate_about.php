<?php
$homePath = __DIR__ . '/resources/views/home/index.blade.php';
$servicesPath = __DIR__ . '/resources/views/services/index.blade.php';
$aboutPath = __DIR__ . '/resources/views/about/index.blade.php';

$home = file_get_contents($homePath);
$services = file_get_contents($servicesPath);

// Extract Breadcrumb CSS from services
preg_match('/(\/\* breadcrumb \*\/.*?\.sv-breadcrumb-current \{.*?\})/s', $services, $breadcrumbCssMatches);
$breadcrumbCss = $breadcrumbCssMatches[1] ?? '';

// Extract sections from Home
preg_match('/<section class="cv-adv-premium" id="keunggulan">.*?<\/section>/s', $home, $advMatches);
$adv = $advMatches[0] ?? '';
preg_match('/<style>\s*\/\* ── KEUNGGULAN ──.*?<\/style>/s', $home, $advCssMatches);
$advCss = $advCssMatches[0] ?? '';

preg_match('/<section class="cv-testi-premium" id="testimoni">.*?<\/section>/s', $home, $testiMatches);
$testi = $testiMatches[0] ?? '';
preg_match('/<style>\s*\/\* ── GALERI ──.*?<\/style>/s', $home, $testiCssMatches);
$testiCss = $testiCssMatches[0] ?? ''; // includes testi CSS

preg_match('/<section class="cv-coverage-premium" id="jangkauan">.*?<\/section>/s', $home, $covMatches);
$cov = $covMatches[0] ?? '';
preg_match('/<style>\s*\.cv-coverage-premium \{.*?<\/style>/s', $home, $covCssMatches);
$covCss = $covCssMatches[0] ?? '';

preg_match('/<section class="cv-cta-premium">.*?<\/section>/s', $home, $ctaMatches);
$cta = $ctaMatches[0] ?? '';
preg_match('/<style>\s*\/\* ── CTA PREMIUM ──.*?<\/style>/s', $home, $ctaCssMatches);
$ctaCss = $ctaCssMatches[0] ?? '';

$final = <<<EOT
@extends('layouts.app')

@section('content')

<style>
/* ── PREMIUM STYLING ADAPTED FROM HOMEPAGE ── */
:root {
    --cv-bg: #ffffff;
    --cv-surface: #f8fafc;
    --cv-surface-dark: #f1f5f9;
    --cv-border: #e2e8f0;
    --cv-text: #0f172a;
    --cv-muted: #64748b;
    --cv-accent: #0ea5e9;
    --cv-accent-green: #10b981;
    --c-muted: #64748B;
    --c-accent: #0EA5E9;
    --c-text: #0F172A;
    --font: 'Montserrat', sans-serif;
}

body { background: var(--cv-bg); color: var(--cv-text); }
.cv-section-pad { padding: 6rem 1.5rem; }
.container { max-width: 1200px; margin: 0 auto; }

$breadcrumbCss

.cv-label {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase;
    color: var(--cv-muted); margin-bottom: 1.5rem; display: flex; align-items: center;
    justify-content: center; gap: 0.5rem;
}
.cv-label::before { content: ''; width: 4px; height: 4px; background: var(--cv-accent); border-radius: 50%; }

.cv-heading {
    font-size: clamp(2rem, 4vw, 3.5rem); font-weight: 500; line-height: 1.15;
    letter-spacing: -0.03em; color: var(--cv-text);
}
.cv-heading strong { font-weight: 600; }
.cv-heading .ab-icon-blue, .cv-heading .ab-icon-green {
    display: inline-flex; align-items: center; justify-content: center; width: 1em; height: 1em;
    border-radius: 50%; vertical-align: middle; margin: 0 0.1em; transform: translateY(-0.1em);
}
.cv-heading .ab-icon-blue { background: var(--cv-accent); color: #fff; padding: 0.2em; }
.cv-heading .ab-icon-green { background: var(--cv-accent-green); color: #fff; padding: 0.2em; }

.cv-desc { font-size: 1rem; color: var(--cv-muted); line-height: 1.7; margin-top: 1.5rem; }

/* ── CARDS GRID ── */
.cv-cards-grid { display: grid; grid-template-columns: repeat(1, 1fr); gap: 1.5rem; margin-top: 4rem; }
@media (min-width: 768px) { .cv-cards-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .cv-cards-grid { grid-template-columns: repeat(4, 1fr); } }

.cv-card {
    border-radius: 24px; padding: 2rem; position: relative; overflow: hidden;
    min-height: 320px; display: flex; flex-direction: column; text-decoration: none;
    transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
}
.cv-card:hover { transform: translateY(-5px); }
.cv-card-gray { background: var(--cv-surface-dark); border: 1px solid var(--cv-border); }
.cv-card-accent { background: var(--cv-accent); color: #fff; }
.cv-card-image { padding: 2rem; }
.cv-card-image .cv-card-img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0; }
.cv-card-image .cv-card-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 60%); z-index: 1; }

.cv-card-content { position: relative; z-index: 2; display: flex; flex-direction: column; height: 100%; }
.cv-card-label { font-size: 0.875rem; font-weight: 500; color: var(--cv-muted); margin-bottom: 1rem; }
.cv-card-accent .cv-card-label { color: rgba(255,255,255,0.9); }
.cv-card-value { font-size: 3rem; font-weight: 400; line-height: 1; color: var(--cv-text); letter-spacing: -0.05em; }
.cv-card-accent .cv-card-value, .cv-card-image .cv-card-value { color: #fff; }
.cv-card-desc { font-size: 0.95rem; line-height: 1.5; color: #475569; font-weight: 400; margin-top: auto; }
.cv-card-accent .cv-card-desc, .cv-card-image .cv-card-desc { color: rgba(255,255,255,0.9); }

.cv-card-bg-pattern { position: absolute; inset: 0; z-index: 0; pointer-events: none; opacity: 0.6; }
.cv-chip {
    position: absolute; background: #ffffff; padding: 0.4rem 0.8rem; border-radius: 999px;
    font-size: 0.7rem; font-weight: 600; color: #94a3b8; box-shadow: 0 4px 10px rgba(0,0,0,0.03); white-space: nowrap;
}
.cv-card-gray .cv-card-content.push-bottom { margin-top: auto; }

/* Marquee */
.cv-clients-bar { background: var(--cv-surface); border-top: 1px solid var(--cv-border); border-bottom: 1px solid var(--cv-border); padding: 2.5rem 0; overflow: hidden; margin-top: 0; }
.cv-marquee-container { width: 100%; overflow: hidden; position: relative; display: flex; }
.cv-marquee-container::before, .cv-marquee-container::after { content: ''; position: absolute; top: 0; bottom: 0; width: 150px; z-index: 2; pointer-events: none; }
.cv-marquee-container::before { left: 0; background: linear-gradient(to right, var(--cv-surface), transparent); }
.cv-marquee-container::after { right: 0; background: linear-gradient(to left, var(--cv-surface), transparent); }
@keyframes scrollLeft { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
.cv-marquee-track { display: flex; gap: 1.5rem; padding: 0 1rem; width: max-content; animation: scrollLeft 30s linear infinite; }
.cv-marquee-container:hover .cv-marquee-track { animation-play-state: paused; }
.cv-client-chip {
    display: flex; align-items: center; gap: 0.5rem; background: var(--cv-bg); border: 1px solid var(--cv-border);
    border-radius: 12px; padding: 0.75rem 1.5rem; font-size: 0.85rem; font-weight: 600; color: var(--cv-text); white-space: nowrap;
}
.cv-client-chip::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--cv-accent); flex-shrink: 0; }

</style>

{{-- ════ 1. HERO / TENTANG KAMI ════ --}}
<section class="cv-section-pad" style="padding-top: 10rem;">
    <div class="container">
        
        {{-- BREADCRUMB --}}
        <nav class="sv-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sv-breadcrumb-sep">/</span>
            <span class="sv-breadcrumb-current">Tentang Kami</span>
        </nav>

        <div style="text-align:center; max-width:800px; margin:0 auto;">
            <div class="cv-label">ABOUT US</div>
            <h1 class="cv-heading">
                {!! \$settings['about_heading'] ?? 'Mitra terpercaya industri dalam membangun bangunan yang <span class="ab-icon-blue"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg></span> lebih sejuk dan <span class="ab-icon-green"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3c-4.97 0-9 4.03-9 9 0 3.18 1.66 6.02 4.14 7.69.41.27.68.73.68 1.22V22h8.36v-1.09c0-.49.27-.95.68-1.22 2.48-1.67 4.14-4.51 4.14-7.69 0-4.97-4.03-9-9-9zM12 18h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg></span> lebih efisien' !!}
            </h1>
            <p class="cv-desc" style="max-width: 650px; margin: 2rem auto 0;">
                {{ str_replace('CV. Karya Perdana Teknik', 'Cyclevent', \$settings['about_text'] ?? 'Cyclevent berdiri sejak 2013, bergerak di bidang penyediaan dan instalasi turbine ventilator non-electric.') }}
            </p>
        </div>

        <div class="cv-cards-grid">
            <div class="cv-card cv-card-gray" data-aos="fade-up">
                <div class="cv-card-bg-pattern">
                    <span class="cv-chip" style="top:10%;left:5%;">Tanpa Listrik</span>
                    <span class="cv-chip" style="top:15%;left:45%;">Bebas Perawatan</span>
                    <span class="cv-chip" style="top:12%;left:80%;">0 Watt</span>
                    <span class="cv-chip" style="top:35%;left:15%;">Anti Karat</span>
                    <span class="cv-chip" style="top:38%;left:50%;">Sejuk Alami</span>
                    <span class="cv-chip" style="top:60%;left:5%;">Tahan Lama</span>
                    <span class="cv-chip" style="top:65%;left:40%;">Efisien</span>
                    <span class="cv-chip" style="top:62%;left:75%;">Hemat Biaya</span>
                </div>
                <div class="cv-card-content push-bottom">
                    <div class="cv-card-label">Continents</div>
                    <div class="cv-card-value">20+</div>
                </div>
            </div>

            <div class="cv-card cv-card-accent" data-aos="fade-up" data-aos-delay="100">
                <div class="cv-card-content">
                    <div class="cv-card-label">Commitment to measurable</div>
                    <div class="cv-card-value">100%</div>
                    <div class="cv-card-desc">Komitmen terhadap kualitas terukur 15 Tahun &rarr; "Garansi jangka panjang dengan material aluminium & stainless steel premium."</div>
                </div>
            </div>

            <div class="cv-card cv-card-image" data-aos="fade-up" data-aos-delay="200">
                @php
                    \$aboutImgFallback = !empty(\$settings['logo']) ? asset('storage/'.\$settings['logo']) : asset('images/logo.png');
                @endphp
                <img src="{{ !empty(\$settings['about_image']) ? asset('storage/'.\$settings['about_image']) : \$aboutImgFallback }}" alt="Tim Cyclevent" class="cv-card-img" loading="lazy">
                <div class="cv-card-overlay"></div>
                <div class="cv-card-content" style="justify-content: flex-end;">
                    <div class="cv-card-value">120+</div>
                    <div class="cv-card-desc">Mitra industri nasional yang berdedikasi membangun sistem ventilasi yang lebih cerdas dan lebih tahan lama.</div>
                </div>
            </div>

            <div class="cv-card cv-card-gray" data-aos="fade-up" data-aos-delay="300">
                <div class="cv-card-content">
                    <div class="cv-card-label">Data Points</div>
                    <div class="cv-card-value">520k+</div>
                    <div class="cv-card-desc" style="margin-top:auto;">Unit ventilator aktif bekerja 24 jam non-stop tanpa listrik.</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════ 2. VISI & MISI ════ --}}
<section class="cv-section-pad" style="background: var(--cv-surface); border-top: 1px solid var(--cv-border);">
    <div class="container">
        <div style="text-align:center; max-width:800px; margin:0 auto;">
            <div class="cv-label">Visi &amp; Misi</div>
            <h2 class="cv-heading" style="font-size:clamp(1.75rem,3vw,2.5rem);">Fondasi Kami</h2>
        </div>
        <div class="cv-cards-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); margin-top:3rem;">
            <div class="cv-card cv-card-gray" style="min-height:auto;" data-aos="fade-up">
                <div class="cv-card-content">
                    <div class="cv-card-label" style="color:var(--cv-accent); font-weight:700;">Visi Perusahaan</div>
                    <h3 style="font-size:1.5rem; font-weight:600; color:var(--cv-text); margin-bottom:1rem;">Menjadi Pelopor</h3>
                    <p class="cv-desc" style="margin-top:0;">{{ str_replace('CV. Karya Perdana Teknik', 'Cyclevent', \$settings['visi'] ?? 'Menjadi pelopor penyedia sirkulasi udara hemat energi yang profesional dan terpercaya di Indonesia.') }}</p>
                </div>
            </div>
            <div class="cv-card cv-card-gray" style="min-height:auto;" data-aos="fade-up" data-aos-delay="100">
                <div class="cv-card-content">
                    <div class="cv-card-label" style="color:var(--cv-accent); font-weight:700;">Misi Perusahaan</div>
                    <h3 style="font-size:1.5rem; font-weight:600; color:var(--cv-text); margin-bottom:1rem;">Solusi Menyeluruh</h3>
                    <p class="cv-desc" style="margin-top:0;">{{ str_replace('CV. Karya Perdana Teknik', 'Cyclevent', \$settings['misi'] ?? 'Menciptakan solusi menyeluruh dengan kualitas terbaik dalam pengadaan ventilator atap untuk meningkatkan efisiensi dan kenyamanan pelanggan.') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════ INJECT STYLES AND SECTIONS FROM HOME ════ --}}
$advCss
$adv

@if(\$testimonials->count())
$testiCss
$testi
@endif

$covCss
$cov

{{-- MARQUEE KLIEN --}}
@if(\$clients->count())
<section class="cv-clients-bar">
    <div class="container" style="margin-bottom:1.5rem; text-align:center;">
        <div class="cv-label">Klien Aktif</div>
        <h2 class="cv-heading" style="font-size:clamp(1.5rem,2.5vw,2rem);">Dipercaya oleh Perusahaan Terkemuka</h2>
    </div>
    <div class="cv-marquee-container">
        <div class="cv-marquee-track">
            @foreach([1, 2] as \$loopGroup)
                @foreach(\$clients as \$c)
                    <div class="cv-client-chip">{{ \$c->name }}</div>
                @endforeach
            @endforeach
        </div>
    </div>
</section>
@endif

$ctaCss
$cta

@endsection
EOT;

file_put_contents($aboutPath, $final);
echo "Done replacing about template.";
