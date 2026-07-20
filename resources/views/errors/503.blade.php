@extends('layouts.app')
@section('title', 'Layanan Tidak Tersedia — 503 | Alat Rumah')
@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
    --c-bg:     #ffffff;
    --c-surface:#F8FAFC;
    --c-border: #E2E8F0;
    --c-text:   #0F172A;
    --c-muted:  #64748B;
    --c-accent: #0EA5E9;
    --font:     'Montserrat', sans-serif;
}
body { background: var(--c-bg); font-family: var(--font); }
.err-page {
    min-height: 80vh; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 6rem 1.5rem; text-align: center;
    position: relative; overflow: hidden; background: var(--c-surface);
}
.err-page::before {
    content: ''; position: absolute; top: -150px; right: -100px;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(249,115,22,0.05) 0%, transparent 70%);
    border-radius: 50%; pointer-events: none;
}
.err-page::after {
    content: ''; position: absolute; bottom: -150px; left: -100px;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(14,165,233,0.04) 0%, transparent 70%);
    border-radius: 50%; pointer-events: none;
}
.err-inner { position: relative; z-index: 2; max-width: 600px; }
.err-breadcrumb {
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    font-size: 0.75rem; font-weight: 500; color: #64748B;
    margin-bottom: 3rem; font-family: 'Montserrat', sans-serif;
}
.err-breadcrumb a { color: #64748B; text-decoration: none; transition: color 0.2s; }
.err-breadcrumb a:hover { color: #0EA5E9; }
.err-breadcrumb-sep { font-size: 0.6rem; opacity: 0.5; }
.err-breadcrumb-current { color: #0F172A; font-weight: 600; }
.err-code {
    font-size: clamp(5rem, 15vw, 9rem); font-weight: 800;
    letter-spacing: -0.05em; line-height: 1;
    background: linear-gradient(135deg, #F97316, #EA580C);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text; margin-bottom: 1.5rem; font-family: 'Montserrat', sans-serif;
}
.err-label {
    display: inline-flex; align-items: center; gap: 0.5rem;
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.15em;
    text-transform: uppercase; color: #64748B; margin-bottom: 1rem;
}
.err-label::before { content: ''; display: block; width: 5px; height: 5px; background: #F97316; border-radius: 50%; }
.err-title {
    font-size: clamp(1.5rem, 4vw, 2.25rem); font-weight: 700; color: #0F172A;
    line-height: 1.2; letter-spacing: -0.02em; margin-bottom: 1rem; font-family: 'Montserrat', sans-serif;
}
.err-desc { font-size: 1rem; color: #64748B; line-height: 1.7; margin-bottom: 2.5rem; font-family: 'Montserrat', sans-serif; }
.err-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
.err-btn-primary {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: #0EA5E9; color: #fff; font-family: 'Montserrat', sans-serif;
    font-size: 0.9375rem; font-weight: 600; padding: 0.875rem 2rem;
    border-radius: 50px; text-decoration: none !important; transition: all 0.3s;
    box-shadow: 0 8px 20px rgba(14,165,233,0.25);
}
.err-btn-primary:hover { background: #0284C7; transform: translateY(-2px); color: #fff !important; }
.err-btn-outline {
    display: inline-flex; align-items: center; gap: 0.5rem; background: transparent;
    color: #0F172A; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;
    font-weight: 600; padding: 0.875rem 2rem; border-radius: 50px;
    border: 1.5px solid #E2E8F0; text-decoration: none !important; transition: all 0.3s;
}
.err-btn-outline:hover { border-color: #0EA5E9; color: #0EA5E9 !important; }
.err-illustration { margin-bottom: 2rem; opacity: 0.12; }
</style>

<section class="err-page">
    <div class="err-inner">

        <nav class="err-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route_locale('home') }}">Beranda</a>
            <span class="err-breadcrumb-sep">›</span>
            <span class="err-breadcrumb-current">Error 503</span>
        </nav>

        <svg class="err-illustration" width="120" height="120" fill="none" stroke="#F97316" stroke-width="1" viewBox="0 0 24 24">
            <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
        </svg>

        <div class="err-code">503</div>
        <div class="err-label">Dalam Pemeliharaan</div>
        <h1 class="err-title">Website Sedang<br>Dalam Perbaikan.</h1>
        <p class="err-desc">
            Kami sedang melakukan pemeliharaan untuk meningkatkan pengalaman Anda.
            Website akan kembali tersedia dalam waktu dekat.
        </p>

        <div class="err-btns">
            <a href="{{ route_locale('home') }}" class="err-btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/>
                </svg>
                Coba Lagi
            </a>
            <a href="https://wa.me/{{ optional(\App\Models\WaSetting::primary())->number ?? '0' }}" target="_blank" class="err-btn-outline">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Hubungi via WhatsApp
            </a>
        </div>

    </div>
</section>

@endsection
