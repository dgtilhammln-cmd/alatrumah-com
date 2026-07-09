<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
/* ── RESET ── */
*, *::before, *::after { box-sizing: border-box; }

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

/* ── HERO ── */
.sh-hero {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 9rem 1.5rem 5rem;
    position: relative;
    overflow: hidden;
}
.sh-hero::before {
    content: '';
    position: absolute;
    top:-150px; right:-100px;
    width:500px; height:500px;
    background: radial-gradient(circle, rgba(14,165,233,.06) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.sh-hero::after {
    content: '';
    position: absolute;
    bottom:-150px; left:-100px;
    width:600px; height:600px;
    background: radial-gradient(circle, rgba(14,165,233,.04) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.sh-hero-inner { max-width:1200px; margin:0 auto; position:relative; z-index:2; text-align:center; }

.sh-breadcrumb {
    display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:.5rem;
    font-size:.75rem; font-weight:500; color:var(--muted); margin-bottom:2.5rem;
}
.sh-breadcrumb a { color:var(--muted); text-decoration:none; transition:color .2s; }
.sh-breadcrumb a:hover { color:var(--accent); }
.sh-breadcrumb-sep { opacity:.45; font-size:.65rem; }
.sh-breadcrumb-current { color:var(--text); font-weight:700; }

/* label */
.sh-label {
    display:inline-flex; align-items:center; justify-content:center; gap:.5rem;
    font-size:.75rem; font-weight:700; letter-spacing:.15em; text-transform:uppercase;
    color:var(--muted); margin-bottom:1.25rem;
}
.sh-label::before {
    content:''; display:block; width:5px; height:5px;
    background:var(--accent); border-radius:50%;
}

.sh-h1 {
    font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 400; color: var(--text);
    line-height:1.15; letter-spacing:-.03em; margin-bottom:1.5rem;
    max-width:800px; margin-left:auto; margin-right:auto;
}
.sh-short-desc { font-size:1rem; color:var(--muted); line-height:1.7; max-width:650px; margin:0 auto; }

.sh-layout {
    max-width:1200px; margin:0 auto;
    padding:3rem 1.5rem 6rem;
    display:grid; grid-template-columns:1fr 360px;
    gap:3.5rem; align-items:start;
}
@media (max-width: 1024px) {
    .sh-layout { grid-template-columns: 1fr; padding-bottom: 3rem; }
}

/* ── GALLERY SLIDER 1:1 ── */
.sh-gallery { margin-bottom:2.5rem; }

.sh-swiper-main {
    width:100%;
    border-radius:16px;
    overflow:hidden;
    background:var(--surface);
    border:1px solid var(--border);
    margin-bottom:.75rem;
    /* Force 4:3 to align with sidebar height */
    position: relative;
    padding-bottom: 75%;
    height: 0;
}
.sh-swiper-main .swiper-wrapper {
    position: absolute;
    inset: 0;
    height: 100%;
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
    width:38px !important; height:38px !important;
    background:rgba(255,255,255,.95);
    border-radius:50%;
    box-shadow:0 2px 10px rgba(15,23,42,.12);
    color:var(--accent) !important;
}
.sh-swiper-main .swiper-button-next::after,
.sh-swiper-main .swiper-button-prev::after { font-size:14px !important; font-weight:900; }

/* Thumb strip */
.sh-swiper-thumbs { width:100%; }
.sh-swiper-thumbs .swiper-wrapper { gap:8px; }
.sh-swiper-thumbs .swiper-slide {
    width:80px !important; height:64px;
    border-radius:8px; overflow:hidden; cursor:pointer;
    border:2px solid transparent; opacity:.5;
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
    position:sticky; top:90px;
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
    .sh-hero { padding:7rem 1.25rem 2.5rem; }
    .sh-layout { padding:2rem 1.25rem 4rem; }
    .sh-adv-section,.sh-app-section,.sh-coverage-section,.sh-related { padding:3.5rem 1.25rem; }
    .sh-adv-cards,.sh-app-grid,.sh-related-grid { grid-template-columns:1fr; }
    .sh-stats-grid { grid-template-columns:repeat(2,1fr); gap:1rem; }
    .sh-stat-val { font-size:2.5rem; }
    .sh-cities-grid { grid-template-columns:repeat(2,1fr); }
    .sh-glass-box { padding:1.75rem 1.25rem; margin-top:3rem; }
    .sh-coverage-section { padding:4rem 1.25rem; }
    .sh-adv-header { flex-direction:column; align-items:flex-start; }
}
</style>


<section class="sh-hero">
    <div class="sh-hero-inner">
        <nav class="sh-breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo e(route('home')); ?>">Beranda</a>
            <span class="sh-breadcrumb-sep">/</span>
            <a href="<?php echo e(route('products')); ?>">Produk &amp; Layanan</a>
            <span class="sh-breadcrumb-sep">/</span>
            <span class="sh-breadcrumb-current"><?php echo e($service->name); ?></span>
        </nav>

        <div class="sh-label">Detail Produk</div>
        <h1 class="sh-h1">Turbine Ventilator <?php echo e($service->name); ?> Non-Electric</h1>
        <?php if($service->short_desc): ?>
            <p class="sh-short-desc"><?php echo e($service->short_desc); ?></p>
        <?php endif; ?>
    </div>
</section>


<section class="sh-layout">
    
    <div>
        <?php
            $imgs = [];
            if ($service->image) $imgs[] = asset('storage/'.$service->image);
            else $imgs[] = asset('images/service-default.jpg');
            if (is_array($service->gallery)) {
                foreach ($service->gallery as $g) $imgs[] = asset('storage/'.$g);
            }
        ?>

        <div class="sh-gallery">
            <div class="sh-swiper-main swiper" id="sh-swiper-main">
                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $imgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <img src="<?php echo e($img); ?>" alt="<?php echo e($service->name); ?>">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if(count($imgs) > 1): ?>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                <?php endif; ?>
            </div>

            <?php if(count($imgs) > 1): ?>
                <div class="sh-swiper-thumbs swiper" id="sh-swiper-thumbs">
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $imgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide"><img src="<?php echo e($img); ?>" alt="thumb"></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="sh-content">
            <?php echo $service->description ?? '<p>Belum ada deskripsi untuk produk ini.</p>'; ?>

        </div>

        
        <?php if(is_array($service->specifications) && count($service->specifications) > 0): ?>
        <div style="margin-top:3rem;">
            <h2 style="font-size:1.5rem; font-weight:700; color:var(--text); margin-bottom:1.25rem;">Spesifikasi Teknis Lengkap</h2>
            <div style="overflow-x:auto; -webkit-overflow-scrolling: touch;">
                <table style="width:100%; border-collapse:collapse; text-align:left; font-size:.9rem; color:var(--muted);">
                    <tbody>
                        <?php $__currentLoopData = $service->specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="border-bottom:1px solid var(--border);">
                            <td style="padding:1rem; width:35%; font-weight:600; color:var(--text); background:var(--surface);"><?php echo e($spec['key']); ?></td>
                            <td style="padding:1rem;"><?php echo e($spec['value']); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>

    
    <aside>
        <div class="sh-sidebar-card">
            <div class="sh-sidebar-badge">Konsultasi Gratis</div>
            <h3 class="sh-sidebar-title">Tertarik dengan <?php echo e($service->name); ?>?</h3>
            <p class="sh-sidebar-desc">Tim ahli kami siap membantu Anda mendapatkan informasi lengkap dan penawaran terbaik.</p>

            <div class="sh-info-row">
                <div class="sh-info-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.9a16 16 0 006.18 6.18l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                </div>
                <span>Konsultasi via telepon tersedia</span>
            </div>
            <div class="sh-info-row">
                <div class="sh-info-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <span>Respons cepat di jam kerja</span>
            </div>
            <div class="sh-info-row">
                <div class="sh-info-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <span>Garansi kualitas 15 tahun</span>
            </div>

            <?php if($wa): ?>
                <a href="javascript:void(0)" onclick="openOrderModal('Produk: <?php echo e(addslashes($service->name)); ?>')" class="sh-btn-primary">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Chat via WhatsApp
                </a>
            <?php endif; ?>
            <?php if($service->brochure): ?>
            <a href="<?php echo e(asset('storage/'.$service->brochure)); ?>" target="_blank" class="sh-btn-outline" style="margin-bottom:1.5rem;">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Unduh Brosur/Datasheet
            </a>
            <?php endif; ?>

            
            <div style="background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:1.25rem;">
                <h4 style="font-size:.875rem; font-weight:700; color:var(--text); margin-bottom:.75rem;">Standar Kualitas &amp; Sertifikasi</h4>
                <ul style="margin:0; padding-left:1.25rem; font-size:.8rem; color:var(--muted); line-height:1.6;">
                    <li>Material plat Zincalume/Stainless anti karat</li>
                    <li>Desain standar USA teruji cuaca ekstrem</li>
                    <li>Sertifikasi uji coba kelayakan pakai</li>
                    <li>Garansi resmi pabrik 15 tahun</li>
                </ul>
            </div>
        </div>
    </aside>
</section>



<section class="sh-adv-section" id="keunggulan">
    <div class="sh-adv-inner">
        <div class="sh-adv-header">
            <div>
                <div class="cv-section-label">KEUNGGULAN</div>
                <h2 class="cv-section-title" style="margin-top:.75rem;">Mengapa Pilih<br>Cyclevent?</h2>
            </div>
            <p class="sh-adv-header-desc">Didesain untuk iklim tropis Indonesia, dibuktikan oleh ratusan proyek dari Sabang sampai Merauke.</p>
        </div>

        <div class="sh-adv-cards">
            
            <div class="sh-adv-card accent">
                <div class="sh-adv-card-icon white-bg">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="sh-adv-num white">15+</div>
                <div class="sh-adv-title white">Garansi 15 Tahun</div>
                <div class="sh-adv-desc white">Garansi tidak berkarat &amp; tidak rusak. Instalasi 5 tahun dan sparepart 5 tahun.</div>
            </div>
            
            <div class="sh-adv-card">
                <div class="sh-adv-card-icon blue-bg">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="sh-adv-num">0W</div>
                <div class="sh-adv-title">Tanpa Listrik</div>
                <div class="sh-adv-desc">Bertenaga sepenuhnya dari angin. Tidak ada tagihan listrik, nol risiko korsleting.</div>
            </div>
            
            <div class="sh-adv-card">
                <div class="sh-adv-card-icon blue-bg">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="sh-adv-num">24/7</div>
                <div class="sh-adv-title">Non-Stop 365 Hari</div>
                <div class="sh-adv-desc">Bebas perawatan dan beroperasi 24 jam sehari, 365 hari setahun tanpa henti.</div>
            </div>
            
            <div class="sh-adv-card accent-dark">
                <div class="sh-adv-card-icon dark-bg">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="sh-adv-num blue">257</div>
                <div class="sh-adv-title light">Kapasitas Hisap Superior</div>
                <div class="sh-adv-desc white">Hingga 257,87 m³/menit — jauh lebih tinggi dari ventilator stasioner manapun.</div>
            </div>
            
            <div class="sh-adv-card">
                <div class="sh-adv-card-icon blue-bg">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="2" x2="12" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                </div>
                <div class="sh-adv-title" style="margin-top:auto;">100% Anti Tampias Hujan</div>
                <div class="sh-adv-desc">Desain khusus memastikan air hujan tidak masuk ke dalam bangunan dalam kondisi apapun.</div>
            </div>
            
            <div class="sh-adv-card">
                <div class="sh-adv-card-icon blue-bg">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                </div>
                <div class="sh-adv-title" style="margin-top:auto;">Cocok Iklim Tropis</div>
                <div class="sh-adv-desc">Dioptimalkan untuk kondisi panas dan lembab Indonesia, efektif bahkan di angin minimum.</div>
            </div>
            
            <div class="sh-adv-card sh-adv-card-span-2" style="grid-column:span 2; flex-direction:row; gap:2rem; align-items:center;">
                <div class="sh-adv-card-icon blue-bg" style="flex-shrink:0; width:56px; height:56px;">
                    <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <div>
                    <div class="sh-adv-title" style="font-size:1.125rem; margin-bottom:.5rem;">Desain Konstruksi USA</div>
                    <div class="sh-adv-desc">Mengikuti standar desain USA dengan powder coating pada rangka dan topi bola untuk ketahanan maksimal di iklim tropis yang ekstrem hingga 15 tahun.</div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="sh-app-section" id="aplikasi">
    <div class="sh-app-inner">
        <div class="sh-app-header">
            <div class="cv-section-label">APLIKASI</div>
            <h2 class="cv-section-title" style="margin-top:.75rem;">Cocok untuk<br>Berbagai Bangunan</h2>
            <p style="margin-top:1rem; font-size:.875rem; color:var(--muted); line-height:1.65;">
                Cyclevent terbukti efektif di berbagai jenis bangunan — dari rumah tinggal hingga pabrik skala besar.
            </p>
        </div>
        <div class="sh-app-grid">
            <?php
                $apps = [
                    [
                        'title' => 'Restaurant',
                        'desc' => 'Sirkulasi udara alami dan berkelanjutan membuat ruangan restaurant lebih nyaman, meningkatkan produktivitas kerja dan kualitas udara melalui sistem ventilasi udara.',
                        'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>',
                        'img' => !empty($settings['app_img_restoran']) ? asset('storage/'.$settings['app_img_restoran']) : asset('images/placeholder-app.jpg')
                    ],
                    [
                        'title' => 'Pabrik & Gudang',
                        'desc' => 'Sebagai ventilator atap pabrik, turbine ventilator mampu menghilangkan udara panas, debu, dan partikel berbahaya secara otomatis tanpa listrik, cocok sebagai exhaust fan pabrik.',
                        'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/></svg>',
                        'img' => !empty($settings['app_img_pabrik']) ? asset('storage/'.$settings['app_img_pabrik']) : asset('images/placeholder-app.jpg')
                    ],
                    [
                        'title' => 'Gedung Olahraga',
                        'desc' => 'Ventilasi yang optimal membantu menjaga udara tetap segar, mendukung performa atlet melalui sistem turbine vent yang efisien.',
                        'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>',
                        'img' => !empty($settings['app_img_gor']) ? asset('storage/'.$settings['app_img_gor']) : asset('images/placeholder-app.jpg')
                    ],
                    [
                        'title' => 'Dapur',
                        'desc' => 'Sistem ventilator turbine menjaga dapur tetap bersih dari asap dan bau, memenuhi standar kesehatan dengan sirkulasi udara optimal.',
                        'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
                        'img' => !empty($settings['app_img_dapur']) ? asset('storage/'.$settings['app_img_dapur']) : asset('images/placeholder-app.jpg')
                    ],
                ];
            ?>
            <?php $__currentLoopData = $apps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="sh-app-card">
                    <div class="sh-app-img-wrapper">
                        <img src="<?php echo e($app['img']); ?>" alt="<?php echo e($app['title']); ?>" loading="lazy">
                    </div>
                    <div class="sh-app-card-body">
                        <div style="display:flex; align-items:center; gap:1rem;">
                            <div class="sh-app-icon"><?php echo $app['icon']; ?></div>
                            <h3 class="sh-app-title"><?php echo e($app['title']); ?></h3>
                        </div>
                        <p class="sh-app-desc"><?php echo e($app['desc']); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="sh-faq-section" id="faq" style="padding:4rem 0; background:var(--surface); margin-top:4rem;">
    <div class="sh-adv-inner" style="max-width:800px;">
        <div class="cv-section-label" style="margin-bottom:.75rem; display:flex; justify-content:center;">PERTANYAAN UMUM</div>
        <h2 class="cv-section-title" style="text-align:center;">FAQ <?php echo e($service->name); ?></h2>
        <div class="ar-faq-list" style="margin-top:2.5rem; display:flex; flex-direction:column; gap:0.75rem;">
            <?php
                $faqs = is_array($service->faqs) && !empty($service->faqs) ? $service->faqs : [
                    ['q' => 'Apakah Cyclevent Turbine Ventilator memerlukan listrik?', 'a' => 'Sama sekali tidak. Cyclevent beroperasi 100% menggunakan tenaga angin dan perbedaan tekanan udara, sehingga bebas biaya listrik selamanya.'],
                    ['q' => 'Berapa lama garansi yang diberikan?', 'a' => 'Kami memberikan garansi resmi untuk produk Cyclevent hingga 15 tahun, mencakup cacat pabrik dan performa putaran mesin.'],
                    ['q' => 'Apakah materialnya tahan karat?', 'a' => 'Ya, Cyclevent terbuat dari material Alumunium atau Stainless Steel berkualitas tinggi yang tahan terhadap cuaca ekstrem dan karat.']
                ];
            ?>
            <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <details class="ar-faq-item" style="background:#fff; border:1px solid var(--border); border-radius:12px; overflow:hidden;">
                <summary style="padding:1.25rem; font-weight:600; cursor:pointer; display:flex; justify-content:space-between; align-items:center; list-style:none;">
                    <?php echo e($f['q'] ?? ''); ?>

                    <svg class="ar-faq-chevron" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="color:#0EA5E9;"><polyline points="6 9 12 15 18 9"/></svg>
                </summary>
                <div class="ar-faq-answer" style="padding:0 1.25rem 1.25rem; color:var(--muted); font-size:0.95rem; line-height:1.6; border-top:1px solid var(--border); margin-top:0.5rem; padding-top:1rem;">
                    <?php echo e($f['a'] ?? ''); ?>

                </div>
            </details>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <?php if(count($faqs) > 0): ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        {
          "@type": "Question",
          "name": "<?php echo e(addslashes(strip_tags($f['q'] ?? ''))); ?>",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<?php echo e(addslashes(strip_tags($f['a'] ?? ''))); ?>"
          }
        }<?php echo e($idx < count($faqs) - 1 ? ',' : ''); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      ]
    }
    </script>
    <?php endif; ?>
</section>
<style>
.ar-faq-item[open] .ar-faq-chevron { transform:rotate(180deg); }
.ar-faq-chevron { transition:transform 0.3s; }
.ar-faq-item summary::-webkit-details-marker { display:none; }
</style>


<?php echo $__env->make('components.testimonials', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


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
                    <div class="sh-stat-val"><span class="count-up" data-target="<?php echo e(\App\Models\Setting::get('founding_year') ?? '2013'); ?>">0</span></div>
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
        </div>

        
        <?php $coverageMap = \App\Models\Setting::get('coverage_map'); ?>
        <?php if($coverageMap): ?>
            <div style="position:relative; width:100%; margin-top:-6rem;">
                <img src="<?php echo e(asset('storage/'.$coverageMap)); ?>" alt="Peta Jangkauan Indonesia"
                     style="display:block; width:100%; height:auto;" loading="lazy">
            </div>
        <?php endif; ?>
    </div>
    
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


<?php if($related->count() > 0): ?>
<section class="sh-related">
    <div class="sh-related-inner">
        <div class="cv-section-label" style="margin-bottom:.75rem;">Produk Lainnya</div>
        <h3 class="sh-related-title">Produk &amp; Layanan Lainnya</h3>
        <div class="sh-related-grid">
            <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('products.show', $r->slug)); ?>" class="sh-related-card">
                    <img src="<?php echo e($r->image_url); ?>" alt="<?php echo e($r->name); ?>" class="sh-related-img" loading="lazy">
                    <div class="sh-related-body">
                        <div class="sh-related-name"><?php echo e($r->name); ?></div>
                        <p class="sh-related-desc"><?php echo e($r->short_desc); ?></p>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>