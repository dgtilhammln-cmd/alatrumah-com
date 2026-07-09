@php
    $logo   = \App\Models\Setting::get('logo');
    $waNav  = \App\Models\WaSetting::primary();

    $locale = app()->getLocale();

    // Nav labels per language
    $navLabels = [
        'en' => ['home' => 'Home',    'about' => 'About',   'products' => 'Products', 'gallery' => 'Gallery', 'articles' => 'Articles', 'contact' => 'Contact'],
        'id' => ['home' => 'Beranda', 'about' => 'Tentang', 'products' => 'Produk',   'gallery' => 'Galeri',  'articles' => 'Artikel',  'contact' => 'Kontak'],
        'ar' => ['home' => 'الرئيسية','about' => 'عنّا',   'products' => 'المنتجات', 'gallery' => 'المعرض',  'articles' => 'المقالات', 'contact' => 'اتصل بنا'],
        'ko' => ['home' => '홈',      'about' => '소개',    'products' => '제품',     'gallery' => '갤러리',  'articles' => '아티클',   'contact' => '연락처'],
    ];
    $labels = $navLabels[$locale] ?? $navLabels['en'];

    $navLinks = [
        ['url' => route_locale('home'),     'label' => $labels['home']],
        ['url' => route_locale('about'),    'label' => $labels['about']],
        ['url' => route_locale('products'), 'label' => $labels['products']],
        ['url' => route_locale('gallery'),  'label' => $labels['gallery']],
        ['url' => route_locale('articles'), 'label' => $labels['articles']],
        ['url' => route_locale('contact'),  'label' => $labels['contact']],
    ];

    $currentUrl = url()->current();

    // Language switcher data — native names
    $allLocales = locale_labels(); // from helpers.php

    // If viewing an article, check which locales have is_complete=true
    $viewingArticle = isset($article) && $article instanceof \App\Models\Article ? $article : null;

    // CTA labels
    $ctaLabel = [
        'en' => 'Consultation',
        'id' => 'Konsultasi',
        'ar' => 'استشارة',
        'ko' => '상담',
    ][$locale] ?? 'Consultation';
@endphp

<style>
    /* ═══════════════════════════════════
       NAVBAR ENTRY ANIMATIONS (Premium)
    ═══════════════════════════════════ */
    @keyframes navDropIn {
        0%   { opacity: 0; transform: translateY(-24px) scale(0.97); filter: blur(4px); }
        100% { opacity: 1; transform: translateY(0)     scale(1);    filter: blur(0); }
    }
    @keyframes navFadeIn {
        0%   { opacity: 0; transform: translateY(-18px) scale(0.98); }
        100% { opacity: 1; transform: translateY(0)     scale(1); }
    }

    /* ═══════════════════════════════════
       NAVBAR LAYOUT
    ═══════════════════════════════════ */
    .pill-navbar-wrapper {
        position: fixed;
        top: 1rem;
        left: 0;
        width: 100%;
        z-index: 999;
        pointer-events: none;
    }
    .pill-navbar-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        pointer-events: auto;
    }

    /* Shared pill container */
    .nav-pill-box {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 999px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.07), 0 1px 3px rgba(0,0,0,0.04);
        display: flex;
        align-items: center;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    /* Scrolled State */
    .pill-navbar-inner.navbar-scrolled {
        background: #ffffff;
        border-radius: 999px;
        padding: 0.25rem 0.75rem;
        box-shadow: 0 10px 40px rgba(14, 165, 233, 0.12), 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid rgba(14, 165, 233, 0.1);
        gap: 0.5rem;
    }
    .pill-navbar-inner.navbar-scrolled .nav-pill-box {
        box-shadow: none;
        border: none;
        background: transparent;
    }

    /* ── Logo Pill ── */
    .nav-pill-logo {
        padding: 0.25rem 1rem 0.25rem 0.25rem;
        height: 50px;
        text-decoration: none;
        gap: 0.75rem;
        animation: navDropIn 0.9s cubic-bezier(0.22, 1, 0.36, 1) both;
        animation-delay: 0.05s;
    }
    .nav-logo-img-wrap {
        width: 42px; height: 42px;
        border-radius: 50%;
        overflow: hidden;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .nav-logo-img-wrap img { width: 100%; height: 100%; object-fit: contain; padding: 4px; }
    .nav-logo-text { font-family: 'Montserrat', sans-serif; font-size: 0.72rem; font-weight: 700; color: #1e293b; line-height: 1.25; letter-spacing: 0.01em; }
    .nav-logo-sub  { font-family: 'Montserrat', sans-serif; font-size: 0.58rem; font-weight: 400; color: #94a3b8; letter-spacing: 0.02em; }

    /* ── Menu Links Pill ── */
    .nav-pill-menu {
        padding: 0.3rem; gap: 0.1rem;
        animation: navFadeIn 0.95s cubic-bezier(0.22, 1, 0.36, 1) both;
        animation-delay: 0.2s;
    }
    .pill-link {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8rem; font-weight: 500; color: #475569;
        text-decoration: none; padding: 0.45rem 0.9rem;
        border-radius: 999px; transition: color 0.2s, background 0.2s;
        white-space: nowrap;
    }
    .pill-link:hover { color: #0EA5E9; background: rgba(14,165,233,0.07); }
    .pill-link.active { background: #0369a1; color: #fff; font-weight: 600; }

    /* ── Language Switcher ── */
    .lang-switcher-pill {
        position: relative;
        animation: navFadeIn 1s cubic-bezier(0.22, 1, 0.36, 1) both;
        animation-delay: 0.28s;
    }
    .lang-trigger {
        display: flex; align-items: center; gap: 0.4rem;
        padding: 0.45rem 0.85rem;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8rem; font-weight: 600; color: #475569;
        cursor: pointer; border-radius: 999px;
        transition: background 0.2s, color 0.2s;
        user-select: none; white-space: nowrap;
    }
    .lang-trigger:hover { background: rgba(14,165,233,0.07); color: #0EA5E9; }
    .lang-trigger svg { transition: transform 0.2s; }
    .lang-trigger.open svg { transform: rotate(180deg); }

    .lang-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        box-shadow: 0 16px 48px rgba(0,0,0,0.12), 0 4px 12px rgba(0,0,0,0.06);
        min-width: 180px;
        padding: 0.5rem;
        z-index: 9999;
        flex-direction: column;
        gap: 0.2rem;
        animation: navDropIn 0.25s ease both;
    }
    .lang-dropdown.open { display: flex; }

    .lang-option {
        display: flex; align-items: center; gap: 0.75rem;
        padding: 0.65rem 0.85rem;
        border-radius: 12px;
        text-decoration: none;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem; font-weight: 600;
        color: #475569;
        transition: all 0.15s ease;
        cursor: pointer;
    }
    .lang-option:hover:not(.lang-option--disabled) {
        background: rgba(14,165,233,0.07);
        color: #0EA5E9;
    }
    .lang-option--active { color: #0369a1; }
    .lang-option--active .lang-checkmark { display: flex; }
    .lang-option--disabled { opacity: 0.45; }
    .lang-flag { font-size: 1.15rem; line-height: 1; flex-shrink: 0; }
    .lang-name { flex: 1; }
    .lang-checkmark {
        display: none; align-items: center; justify-content: center;
        width: 18px; height: 18px; border-radius: 50%;
        background: #0369a1; flex-shrink: 0;
    }
    .lang-checkmark svg { color: #fff; }
    .lang-lock { margin-left: auto; color: #CBD5E1; flex-shrink: 0; }

    .lang-divider {
        height: 1px; background: #F1F5F9; margin: 0.25rem 0.5rem;
        border-radius: 999px;
    }

    /* ── Action Buttons Pill ── */
    .nav-pill-actions {
        padding: 0.3rem; gap: 0.3rem;
        animation: navFadeIn 1s cubic-bezier(0.22, 1, 0.36, 1) both;
        animation-delay: 0.35s;
    }
    .pill-btn {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8rem; font-weight: 600; text-decoration: none;
        padding: 0.45rem 1.1rem; border-radius: 999px;
        transition: all 0.2s ease; white-space: nowrap;
    }
    .pill-btn-solid {
        background: #0369a1; color: #fff;
        box-shadow: 0 2px 10px rgba(14,165,233,0.28);
    }
    .pill-btn-solid:hover {
        background: #075985; transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(14,165,233,0.35);
    }

    /* ── Mobile ── */
    .mobile-menu-btn {
        display: none;
        background: #fff; border: none; border-radius: 999px;
        width: 46px; height: 46px;
        align-items: center; justify-content: center;
        cursor: pointer; box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        color: #0EA5E9; pointer-events: auto;
        animation: navDropIn 0.9s cubic-bezier(0.22, 1, 0.36, 1) both;
        animation-delay: 0.05s;
    }
    #mobile-drawer.open { transform: translateX(0) !important; }

    @media (max-width: 991px) {
        .nav-pill-menu, .nav-pill-actions, .lang-switcher-pill { display: none; }
        .mobile-menu-btn { display: flex; }
    }

    /* RTL support */
    [dir="rtl"] .pill-navbar-inner { flex-direction: row-reverse; }
    [dir="rtl"] .lang-dropdown { right: auto; left: 0; }
    [dir="rtl"] .lang-option { flex-direction: row-reverse; }
    [dir="rtl"] .lang-checkmark { margin-left: 0; margin-right: auto; }
</style>

<div class="pill-navbar-wrapper" id="mainNavbar">
    <div class="pill-navbar-inner">

        {{-- ── Logo Pill ── --}}
        <a href="{{ route_locale('home') }}" class="nav-pill-box nav-pill-logo">
            <div class="nav-logo-img-wrap">
                @if($logo)
                    <img src="{{ asset('storage/'.$logo) }}" alt="Logo">
                @else
                    <span style="font-weight:900;color:#0EA5E9;font-size:1rem;">C</span>
                @endif
            </div>
            <div>
                <div class="nav-logo-text">AMN</div>
                <div class="nav-logo-sub">Charcoal Briquettes</div>
            </div>
        </a>

        {{-- ── Navigation Links ── --}}
        <nav class="nav-pill-box nav-pill-menu">
            @foreach($navLinks as $link)
                <a href="{{ $link['url'] }}" class="pill-link {{ $currentUrl == $link['url'] ? 'active' : '' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- ── Language Switcher ── --}}
        <div class="nav-pill-box lang-switcher-pill" id="langSwitcherPill">
            <div class="lang-trigger" id="langTrigger" onclick="toggleLangDropdown()" aria-haspopup="listbox" aria-expanded="false">
                {!! $allLocales[$locale]['flag'] !!}
                <span style="font-weight:700; font-size:0.78rem;">{{ $allLocales[$locale]['code'] }}</span>
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </div>

            <div class="lang-dropdown" id="langDropdown" role="listbox">
                @foreach($allLocales as $lc => $ldata)
                    @php
                        // Build target URL: swap locale prefix in current URL
                        $switchUrl = switch_locale_url($lc);
                        $isActive = $locale === $lc;
                    @endphp

                    @if(!$loop->first)
                        <div class="lang-divider"></div>
                    @endif

                    <a href="javascript:void(0)"
                       onclick="switchLanguage('{{ $lc }}', '{{ $switchUrl }}')"
                       class="lang-option {{ $isActive ? 'lang-option--active' : '' }}"
                       role="option"
                       aria-selected="{{ $isActive ? 'true' : 'false' }}">
                        <span class="lang-flag">{!! $ldata['flag'] !!}</span>
                        <span class="lang-name">{{ $ldata['name'] }}</span>
                        @if($isActive)
                            <span class="lang-checkmark">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        {{-- ── CTA Actions ── --}}
        <div class="nav-pill-box nav-pill-actions">
            @if($waNav)
                @php
                    $waNumber = preg_replace('/[^0-9]/', '', $waNav->nomor_wa ?? '');
                    if(str_starts_with($waNumber, '0')) {
                        $waNumber = '62' . substr($waNumber, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="pill-btn pill-btn-solid" style="display:flex;align-items:center;gap:0.4rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    {{ $ctaLabel }}
                </a>
            @else
                <a href="{{ route_locale('contact') }}" class="pill-btn pill-btn-solid">{{ $ctaLabel }}</a>
            @endif
        </div>

        {{-- ── Mobile Toggle ── --}}
        <button class="mobile-menu-btn" onclick="document.getElementById('mobile-drawer').classList.add('open')" aria-label="Menu">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
</div>

{{-- ── Mobile Drawer ── --}}
<div id="mobile-drawer" style="position:fixed;inset:0;background:rgba(255,255,255,0.98);backdrop-filter:blur(16px);z-index:9999;display:flex;flex-direction:column;padding:2rem;transform:translateX(100%);transition:transform 0.4s cubic-bezier(0.22,1,0.36,1);">
    <button aria-label="Close Menu" onclick="document.getElementById('mobile-drawer').classList.remove('open')" style="position:absolute;top:1.25rem;right:1.25rem;background:transparent;border:none;color:#475569;cursor:pointer;">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
    </button>
    <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:2.5rem;">
        @if($logo)
            <img src="{{ asset('storage/'.$logo) }}" alt="Logo" style="height:38px;object-fit:contain;">
        @else
            <span style="font-weight:900;color:#0EA5E9;font-size:1.4rem;">AMN</span>
        @endif
    </div>
    <nav style="display:flex;flex-direction:column;gap:1.25rem;">
        @foreach($navLinks as $link)
            <a href="{{ $link['url'] }}" style="font-family:'Montserrat',sans-serif;font-size:1.1rem;font-weight:600;color:{{ $currentUrl == $link['url'] ? '#0EA5E9' : '#1e293b' }};text-decoration:none;transition:color .2s;">
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- Mobile Language Switcher --}}
    <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid #F1F5F9;">
        <p style="font-family:'Montserrat',sans-serif;font-size:0.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.75rem;">Language</p>
        <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
            @foreach($allLocales as $lc => $ldata)
                @php
                    $switchUrlMobile = switch_locale_url($lc);
                    $isActiveMobile  = $locale === $lc;
                @endphp
                <a href="javascript:void(0)"
                   onclick="switchLanguage('{{ $lc }}', '{{ $switchUrlMobile }}')"
                   style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.45rem 1rem;border-radius:999px;font-family:'Montserrat',sans-serif;font-size:0.85rem;font-weight:600;text-decoration:none;border:2px solid {{ $isActiveMobile ? '#0369a1' : '#E2E8F0' }};color:{{ $isActiveMobile ? '#0369a1' : '#475569' }};background:{{ $isActiveMobile ? 'rgba(3,105,161,0.06)' : 'transparent' }};">
                    {!! $ldata['flag'] !!} <span>{{ $ldata['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <div style="margin-top:auto;">
        @if($waNav)
            @php
                $waNumberMobile = preg_replace('/[^0-9]/', '', $waNav->nomor_wa ?? '');
                if(str_starts_with($waNumberMobile, '0')) {
                    $waNumberMobile = '62' . substr($waNumberMobile, 1);
                }
            @endphp
            <a href="https://wa.me/{{ $waNumberMobile }}" target="_blank" style="display:block;background:#0EA5E9;color:#fff;text-align:center;padding:.875rem;border-radius:999px;font-family:'Montserrat',sans-serif;font-weight:600;text-decoration:none;box-shadow:0 4px 14px rgba(14,165,233,.3);">
                {{ $ctaLabel }}
            </a>
        @endif
    </div>
</div>

<script>
function toggleLangDropdown() {
    const dropdown = document.getElementById('langDropdown');
    const trigger  = document.getElementById('langTrigger');
    const isOpen   = dropdown.classList.contains('open');

    if (isOpen) {
        dropdown.classList.remove('open');
        trigger.classList.remove('open');
        trigger.setAttribute('aria-expanded', 'false');
    } else {
        dropdown.classList.add('open');
        trigger.classList.add('open');
        trigger.setAttribute('aria-expanded', 'true');
    }
}

/**
 * switchLanguage — save cookie FIRST, then redirect.
 * This ensures middleware reads the cookie on the very next request.
 */
function switchLanguage(locale, targetUrl) {
    // 1. Save to cookie (365 days) — must be set BEFORE redirect
    const expires = new Date();
    expires.setFullYear(expires.getFullYear() + 1);
    document.cookie = 'preferred_locale=' + locale +
        '; path=/; expires=' + expires.toUTCString() + '; SameSite=Lax';

    // 2. Save to localStorage as backup
    try { localStorage.setItem('preferred_locale', locale); } catch(e) {}

    // 3. Navigate to target URL
    window.location.href = targetUrl;
}

document.addEventListener('DOMContentLoaded', function() {
    // Scroll effect
    const navbar = document.querySelector('.pill-navbar-inner');
    if (navbar) {
        window.addEventListener('scroll', function() {
            navbar.classList.toggle('navbar-scrolled', window.scrollY > 50);
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const pill     = document.getElementById('langSwitcherPill');
        const dropdown = document.getElementById('langDropdown');
        const trigger  = document.getElementById('langTrigger');
        if (pill && !pill.contains(e.target)) {
            if (dropdown) dropdown.classList.remove('open');
            if (trigger) {
                trigger.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const dropdown = document.getElementById('langDropdown');
            const trigger  = document.getElementById('langTrigger');
            if (dropdown) dropdown.classList.remove('open');
            if (trigger) {
                trigger.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }
        }
    });
});
</script>
