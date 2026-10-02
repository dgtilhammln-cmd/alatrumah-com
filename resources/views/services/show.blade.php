@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

<style>
/* ── TOKENS & RESET ── */
:root {
    --bg-base: #ffffff;
    --bg-surface: #F8FAFC;
    --border-1: #E2E8F0;
    --text-main: #0F172A;
    --text-muted: #64748B;
    --accent: #0EA5E9;
    --accent-dark: #0284C7;
}

/* ── BREADCRUMB ── */
.pd-breadcrumb {
    padding: 1rem 1.5rem 0;
    max-width: 1200px;
    margin: 5.5rem auto 0;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--text-muted);
    flex-wrap: wrap;
}
.pd-breadcrumb a { color: var(--text-muted); text-decoration: none; transition: 0.2s; }
.pd-breadcrumb a:hover { color: var(--accent); }
.pd-breadcrumb span { color: var(--text-main); font-weight: 600; }

.pd-layout {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem 1.5rem 2.5rem;
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 2rem;
    align-items: start;
}

.pd-card {
    background: var(--bg-base);
    border: 1px solid var(--border-1);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}

.pd-card-hover:hover {
    border-color: var(--accent);
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(14,165,233,0.08);
}

/* ── GALLERY (COMPACT & PROPORTIONAL) ── */
.pd-gallery-main {
    width: 100%;
    max-width: 400px;
    aspect-ratio: 1/1;
    border-radius: 16px;
    overflow: hidden;
    background: var(--bg-surface);
    border: 1px solid var(--border-1);
    margin: 0 auto 0.75rem;
    position: relative;
}
.pd-gallery-main .swiper-wrapper,
.pd-gallery-main .swiper-slide {
    width: 100% !important;
    height: 100% !important;
}
.pd-gallery-main .swiper-slide a {
    display: block;
    width: 100%;
    height: 100%;
}
.pd-gallery-main img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.pd-gallery-main .swiper-button-next,
.pd-gallery-main .swiper-button-prev {
    color: var(--text-main);
    background: rgba(255,255,255,0.9);
    width: 32px; height: 32px;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.pd-gallery-main .swiper-button-next::after,
.pd-gallery-main .swiper-button-prev::after { font-size: 12px; font-weight: 800; }

.pd-thumbs {
    display: flex; gap: 0.5rem; width: 100%; max-width: 400px; margin: 0 auto; overflow: hidden;
}
.pd-thumb-item {
    width: 54px; height: 54px;
    border-radius: 10px; overflow: hidden;
    border: 2px solid transparent;
    cursor: pointer; opacity: 0.6; transition: 0.2s;
    flex-shrink: 0;
}
.pd-thumb-item.swiper-slide-thumb-active {
    opacity: 1; border-color: var(--accent);
}
.pd-thumb-item img {
    width: 100%; height: 100%; object-fit: cover; display: block;
}

/* ── INFO ── */
.pd-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--text-main);
    line-height: 1.35;
    margin-bottom: 0.5rem;
    letter-spacing: -0.01em;
    font-family: 'Montserrat', sans-serif;
}
.pd-desc-short {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.5;
    margin-bottom: 1rem;
}

/* Rating / Stats */
.pd-stats {
    display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;
    font-size: 0.85rem; flex-wrap: wrap;
}
.pd-stars { color: #F59E0B; display: flex; align-items: center; gap: 4px; font-weight: 700; }
.pd-stat-divider { width: 1px; height: 14px; background: var(--border-1); }

/* Price Box */
.pd-price-box {
    background: linear-gradient(135deg, #F0F9FF, #ffffff);
    border: 1px solid rgba(14,165,233,0.18);
    border-radius: 14px;
    padding: 1rem 1.125rem;
    margin-bottom: 1rem;
    display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;
}
.pd-price-current {
    font-size: 1.5rem; font-weight: 700; color: var(--accent-dark); line-height: 1;
    letter-spacing: -0.01em; font-family: 'Montserrat', sans-serif;
}
.pd-price-old {
    font-size: 0.9rem; text-decoration: line-through; color: var(--text-muted);
}
.pd-badge-discount {
    background: #EF4444; color: #fff; font-size: 0.7rem; font-weight: 700;
    padding: 0.2rem 0.45rem; border-radius: 6px; text-transform: uppercase;
}

/* Vouchers */
.pd-voucher-scroll {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    padding-bottom: 0.35rem;
    margin-bottom: 1rem;
    scrollbar-width: none;
}
.pd-voucher-scroll::-webkit-scrollbar { display: none; }
.pd-voucher-card {
    background: #ffffff;
    border: 1px solid var(--border-1);
    border-radius: 10px;
    padding: 0.5rem 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: max-content;
    cursor: pointer;
    transition: 0.2s;
}
.pd-voucher-card:hover {
    border-color: var(--accent);
    background: #F0F9FF;
}
.pd-v-icon {
    width: 26px; height: 26px;
    background: linear-gradient(135deg, #0EA5E9, #38BDF8);
    color: #fff;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.75rem;
}
.pd-v-title {
    font-size: 0.75rem; font-weight: 700; color: var(--text-main); line-height: 1.2;
}
.pd-v-desc {
    font-size: 0.675rem; color: var(--text-muted);
}

/* Options / QTY */
.pd-qty-wrap {
    display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;
    background: var(--bg-surface); padding: 0.75rem 1rem; border-radius: 12px; border: 1px solid var(--border-1);
    flex-wrap: wrap;
}
.pd-qty-ctrl {
    display: flex; align-items: center;
    border: 1px solid var(--border-1);
    border-radius: 8px; overflow: hidden;
    background: var(--bg-base);
}
.pd-qty-btn {
    width: 34px; height: 34px;
    border: none; background: transparent; cursor: pointer;
    font-size: 1.1rem; color: var(--text-muted);
    display: flex; align-items: center; justify-content: center;
    transition: 0.2s;
}
.pd-qty-btn:hover { background: #F1F5F9; color: var(--text-main); }
.pd-qty-input {
    width: 42px; height: 34px; border: none; text-align: center;
    font-size: 0.95rem; font-weight: 700; color: var(--text-main);
    border-left: 1px solid var(--border-1); border-right: 1px solid var(--border-1);
}

/* Action Buttons */
.pd-actions {
    display: flex; gap: 0.75rem;
}
.pd-btn {
    flex: 1;
    padding: 0.85rem 1rem; border-radius: 12px; font-weight: 700; font-size: 0.9rem;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem;
    transition: all 0.2s ease; text-decoration: none; border: none;
    font-family: 'Montserrat', sans-serif;
}
.pd-btn-outline {
    background: #F0F9FF; color: var(--accent-dark); border: 1.5px solid rgba(14,165,233,0.35);
}
.pd-btn-outline:hover {
    background: #E0F2FE; border-color: var(--accent);
}
.pd-btn-primary {
    background: linear-gradient(135deg, #0EA5E9, #0284C7);
    color: #fff;
    box-shadow: 0 4px 14px rgba(14,165,233,0.25);
}
.pd-btn-primary:hover {
    box-shadow: 0 6px 18px rgba(14,165,233,0.35);
}
.pd-btn:disabled {
    opacity: 0.6; cursor: not-allowed; transform: none !important; box-shadow: none !important;
}

/* Bottom Content */
.pd-bottom-layout {
    max-width: 1200px; margin: 0 auto; padding: 0 1.5rem 3rem;
    display: grid; grid-template-columns: 1fr 300px; gap: 2rem;
}

.pd-section-title {
    font-size: 1.05rem; font-weight: 700; color: var(--text-main);
    margin-bottom: 1rem; display: flex; align-items: center; gap: 0.4rem;
    font-family: 'Montserrat', sans-serif;
}
.pd-section-title::before {
    content:''; display:block; width:4px; height:16px; background:var(--accent); border-radius:4px;
}

.pd-specs-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; margin-bottom: 1.75rem; }
.pd-specs-table td { padding: 0.75rem 0; border-bottom: 1px solid var(--border-1); }
.pd-specs-table td:first-child { width: 130px; color: var(--text-muted); }
.pd-specs-table td:last-child { color: var(--text-main); font-weight: 600; }

.pd-related-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
}
.pd-related-card {
    padding: 1.25rem;
}
.pd-related-img {
    width: 100%;
    aspect-ratio: 1/1;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 0.75rem;
}
.pd-related-title {
    font-weight: 600;
    color: var(--text-main);
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
    line-height: 1.3;
    font-family: 'Montserrat', sans-serif;
}
.pd-related-desc {
    font-size: 0.8rem;
    color: var(--text-muted);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

/* ── PRODUCT DESCRIPTION CONTENT ── */
.pd-content {
    color: #1E293B !important;
    font-size: 0.9rem;
    line-height: 1.8;
    font-family: 'Montserrat', sans-serif;
}
.pd-content p {
    color: #334155 !important;
    margin-bottom: 0.85rem;
    line-height: 1.8;
}
.pd-content ul, .pd-content ol {
    color: #334155 !important;
    padding-left: 1.5rem;
    margin-bottom: 0.85rem;
}
.pd-content li {
    color: #334155 !important;
    margin-bottom: 0.35rem;
}
.pd-content h1, .pd-content h2, .pd-content h3,
.pd-content h4, .pd-content h5, .pd-content h6 {
    color: #0F172A !important;
    font-weight: 700;
    margin-bottom: 0.5rem;
    margin-top: 1rem;
}
.pd-content strong, .pd-content b {
    color: #0F172A !important;
    font-weight: 700;
}
.pd-content a {
    color: #0EA5E9;
    text-decoration: underline;
}
.pd-content table {
    color: #334155 !important;
}
.pd-content td, .pd-content th {
    color: #334155 !important;
}

@media (max-width: 1024px) {
    .pd-breadcrumb { margin-top: 5rem; }
    .pd-layout { grid-template-columns: 1fr; gap: 1.25rem; }
    .pd-bottom-layout { grid-template-columns: 1fr; gap: 1.5rem; }
    .pd-related-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 768px) {
    .pd-breadcrumb {
        margin-top: 4.75rem;
        padding: 0.5rem 1rem 0;
        font-size: 0.775rem;
        width: 100%;
        box-sizing: border-box;
    }
    .pd-layout {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0.75rem 1rem 1.5rem !important;
        gap: 1.25rem !important;
        box-sizing: border-box !important;
    }
    .pd-layout > div {
        width: 100% !important;
        box-sizing: border-box !important;
    }
    .pd-bottom-layout {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 1rem 2.5rem !important;
        gap: 1.25rem !important;
        box-sizing: border-box !important;
    }
    .pd-bottom-layout > div {
        width: 100% !important;
        box-sizing: border-box !important;
    }
    .pd-gallery-main {
        max-width: 100% !important;
        width: 100% !important;
        aspect-ratio: 1/1;
        border-radius: 16px;
        margin: 0 0 0.75rem !important;
        box-sizing: border-box !important;
    }
    .pd-thumbs { max-width: 100% !important; width: 100% !important; }
    .pd-thumb-item { width: 48px; height: 48px; border-radius: 10px; }
    .pd-title { font-size: 1.2rem; margin-bottom: 0.4rem; line-height: 1.3; }
    .pd-desc-short { font-size: 0.85rem; margin-bottom: 0.85rem; }
    .pd-price-current { font-size: 1.4rem; }
    .pd-card { padding: 1.125rem; border-radius: 16px; width: 100%; box-sizing: border-box; }
    .pd-price-box { padding: 0.85rem 1rem; border-radius: 14px; margin-bottom: 0.85rem; width: 100%; box-sizing: border-box; }
    .pd-specs-table td:first-child { width: 110px; font-size: 0.825rem; }
    .pd-specs-table td:last-child { font-size: 0.825rem; }
    .pd-actions { gap: 0.625rem; width: 100%; display: flex; }
    .pd-btn { padding: 0.85rem 1rem; font-size: 0.875rem; border-radius: 12px; flex: 1; text-align: center; }
    
    .pd-related-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.75rem !important;
        width: 100% !important;
    }
    .pd-related-card {
        padding: 0.85rem !important;
        border-radius: 14px !important;
        box-sizing: border-box !important;
    }
    .pd-related-title {
        font-size: 0.875rem !important;
    }
    .pd-related-desc {
        font-size: 0.775rem !important;
    }
}
</style>

{{-- BREADCRUMB --}}
<div class="pd-breadcrumb">
    <a href="{{ route_locale('home') }}">Beranda</a>
    <span>›</span>
    <a href="{{ route_locale('products') }}">Produk &amp; Layanan</a>
    <span>›</span>
    <span>{{ $service->name }}</span>
</div>

{{-- TOP SECTION --}}
<section class="pd-layout">
    {{-- Left: Gallery --}}
    <div>
        @php
            $imgs = [];
            if ($service->image) $imgs[] = asset('storage/'.$service->image);
            else $imgs[] = asset('images/service-default.jpg');
            if (is_array($service->gallery)) {
                foreach ($service->gallery as $g) $imgs[] = asset('storage/'.$g);
            }
        @endphp

        <div class="pd-gallery-main swiper" id="pd-swiper-main">
            <div class="swiper-wrapper">
                @foreach($imgs as $img)
                <div class="swiper-slide">
                    <a href="{{ $img }}" class="glightbox" data-gallery="product-gallery">
                        <img src="{{ $img }}" alt="{{ $service->name }}" loading="lazy">
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
        <div class="swiper pd-thumbs" id="pd-swiper-thumbs">
            <div class="swiper-wrapper">
                @foreach($imgs as $img)
                <div class="swiper-slide pd-thumb-item">
                    <img src="{{ $img }}" alt="thumb" loading="lazy">
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Right: Product Info --}}
    <div>
        <h1 class="pd-title">{{ $service->name }}</h1>
        
        @if($service->rating > 0 || $service->sold_count > 0)
        <div class="pd-stats">
            @if($service->rating > 0)
            <div class="pd-stars">
                <span>{{ number_format($service->rating, 1) }}</span>
                <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
            @endif
            @if($service->rating > 0 && $service->sold_count > 0)
                <div class="pd-stat-divider"></div>
            @endif
            @if($service->sold_count > 0)
            <div style="color:var(--text-muted);">
                Terjual <span style="font-weight:700; color:var(--text-main);">{{ $service->sold_count >= 1000 ? number_format($service->sold_count/1000, 1, ',', '').'RB' : $service->sold_count }}</span>
            </div>
            @endif
        </div>
        @endif

        @if($service->short_desc)
        <p class="pd-desc-short">{{ $service->short_desc }}</p>
        @endif

        @if($service->price > 0)
            <div class="pd-price-box">
                @if($service->sale_price > 0 && $service->sale_price < $service->price)
                    <div class="pd-price-current">Rp{{ number_format($service->sale_price, 0, ',', '.') }}</div>
                    <div class="pd-price-old">Rp{{ number_format($service->price, 0, ',', '.') }}</div>
                    <div class="pd-badge-discount">Hemat {{ round((($service->price - $service->sale_price)/$service->price)*100) }}%</div>
                @else
                    <div class="pd-price-current">Rp{{ number_format($service->price, 0, ',', '.') }}</div>
                @endif
            </div>

            {{-- Realtime Vouchers --}}
            @if(isset($coupons) && $coupons->count() > 0)
            <div class="pd-voucher-scroll">
                @foreach($coupons as $coupon)
                <div class="pd-voucher-card">
                    <div class="pd-v-icon">
                        @if($coupon->category === 'ongkir')
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        @elseif(is_object($coupon->type) && property_exists($coupon->type, 'value') && $coupon->type->value === 'percentage')
                            %
                        @elseif(is_string($coupon->type) && $coupon->type === 'percentage')
                            %
                        @else
                            Rp
                        @endif
                    </div>
                    <div>
                        <div class="pd-v-title">{{ $coupon->badge ?: ( (is_object($coupon->type) && property_exists($coupon->type, 'value') && $coupon->type->value === 'percentage') || (is_string($coupon->type) && $coupon->type === 'percentage') ? 'Diskon ' . (int)$coupon->value . '%' : 'Diskon Rp' . number_format($coupon->value, 0, ',', '.')) }}</div>
                        <div class="pd-v-desc">{{ $coupon->description ?: ($coupon->min_purchase > 0 ? 'Min. belanja Rp' . number_format($coupon->min_purchase,0,',','.') : 'Kode: ' . $coupon->code) }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <form action="{{ route('cart.add') }}" method="POST" id="form-add-to-cart" onsubmit="return false;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $service->id }}">
                <input type="hidden" name="variant_value_id" id="selected_variant_id" value="">
                <input type="hidden" name="selected_combo_id" id="selected_combo_id" value="">
                <input type="hidden" name="action" id="form_action_input" value="cart">

                @php
                    $vGroups = $service->variantOptions()->with('values')->get();
                    $vCombos = $service->variantCombinations;
                @endphp

                @if($vGroups->count() > 0)
                <div class="pd-variants-box" id="variant-box" style="margin: 1.25rem 0; padding: 1rem; background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 14px; transition: border .2s, background .2s;">
                    @foreach($vGroups as $gIdx => $vGroup)
                    <div style="margin-bottom: 0.85rem;" class="variant-group-selector" data-group-id="{{ $vGroup->id }}" data-group-index="{{ $gIdx }}">
                        <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-main, #1E293B); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.4rem;">
                            <svg width="14" height="14" fill="none" stroke="var(--accent, #1B6FE8)" stroke-width="2.5" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3h-8l-2 4h12l-2-4z"/></svg>
                            Pilih {{ $vGroup->name }}: <span style="color:#EF4444;font-weight:700;">*</span>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                            @foreach($vGroup->values as $vVal)
                            <button type="button" class="variant-chip-btn"
                                data-val-id="{{ $vVal->id }}"
                                data-price-adj="{{ $vVal->price_adjustment }}"
                                data-val-stock="{{ $vVal->stock }}"
                                onclick="selectVariantChip(this, {{ $gIdx }}, {{ $vVal->id }})"
                                style="padding: 0.45rem 0.9rem; font-size: 0.8rem; font-weight: 600; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFFFFF; color: #334155; cursor: pointer; transition: all 0.2s ease;">
                                {{ $vVal->value }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <script>
                (function() {
                    var HAS_VARIANTS = {{ $vGroups->count() > 0 ? 'true' : 'false' }};
                    var TOTAL_GROUPS = {{ $vGroups->count() }};
                    var combos       = @json($vCombos ?? []);
                    var basePrice    = {{ ($service->sale_price > 0 && $service->sale_price < $service->price) ? $service->sale_price : ($service->price ?? 0) }};
                    var selectedVals = {}; // { groupIndex: valId }

                    /* --- Chip selection (main page) --- */
                    window.selectVariantChip = function(btn, groupIdx, valId) {
                        var parent = btn.closest('.variant-group-selector');
                        parent.querySelectorAll('.variant-chip-btn').forEach(function(b) {
                            b.style.borderColor = '#CBD5E1';
                            b.style.background  = '#FFFFFF';
                            b.style.color       = '#334155';
                            b.classList.remove('active');
                        });
                        btn.style.borderColor = 'var(--accent,#1B6FE8)';
                        btn.style.background  = 'rgba(27,111,232,0.09)';
                        btn.style.color       = 'var(--accent,#1B6FE8)';
                        btn.classList.add('active');
                        parent.style.background = '';
                        parent.style.padding    = '';

                        selectedVals[groupIdx] = valId;
                        document.getElementById('selected_variant_id').value = valId;

                        // Sync modal chips too
                        var modalChips = document.querySelectorAll('#vr-modal-body .modal-chip-btn[data-group-index="'+groupIdx+'"]');
                        modalChips.forEach(function(mc) {
                            mc.classList.remove('active');
                            mc.style.borderColor = '#CBD5E1';
                            mc.style.background  = '#fff';
                            mc.style.color       = '#334155';
                            if (mc.getAttribute('data-val-id') == valId) {
                                mc.classList.add('active');
                                mc.style.borderColor = 'var(--accent,#1B6FE8)';
                                mc.style.background  = 'rgba(27,111,232,0.09)';
                                mc.style.color       = 'var(--accent,#1B6FE8)';
                            }
                        });

                        var chosen = 0;
                        for (var k in selectedVals) { if (selectedVals[k]) chosen++; }
                        if (chosen >= TOTAL_GROUPS) {
                            var box  = document.getElementById('variant-box');
                            if (box) { box.style.border = '1.5px solid #22C55E'; box.style.background = '#F0FFF4'; }
                        }
                        updatePriceStock();
                    };

                    /* --- Modal chip selection --- */
                    window.selectModalChip = function(btn, groupIdx, valId) {
                        var container = btn.closest('[data-modal-group]');
                        container.querySelectorAll('.modal-chip-btn').forEach(function(b) {
                            b.classList.remove('active');
                            b.style.borderColor = '#CBD5E1';
                            b.style.background  = '#fff';
                            b.style.color       = '#334155';
                        });
                        btn.classList.add('active');
                        btn.style.borderColor = 'var(--accent,#1B6FE8)';
                        btn.style.background  = 'rgba(27,111,232,0.09)';
                        btn.style.color       = 'var(--accent,#1B6FE8)';

                        selectedVals[groupIdx] = valId;
                        document.getElementById('selected_variant_id').value = valId;

                        // Sync page chips
                        var pageChips = document.querySelectorAll('#variant-box .variant-chip-btn');
                        pageChips.forEach(function(pc) {
                            if (parseInt(pc.closest('.variant-group-selector').getAttribute('data-group-index')) === groupIdx) {
                                pc.classList.remove('active');
                                pc.style.borderColor = '#CBD5E1';
                                pc.style.background  = '#FFFFFF';
                                pc.style.color       = '#334155';
                                if (pc.getAttribute('data-val-id') == valId) {
                                    pc.classList.add('active');
                                    pc.style.borderColor = 'var(--accent,#1B6FE8)';
                                    pc.style.background  = 'rgba(27,111,232,0.09)';
                                    pc.style.color       = 'var(--accent,#1B6FE8)';
                                }
                            }
                        });

                        // Update modal confirm button state
                        var chosen = 0;
                        for (var k in selectedVals) { if (selectedVals[k]) chosen++; }
                        var confirmBtn = document.getElementById('vr-modal-confirm');
                        if (confirmBtn) {
                            confirmBtn.style.opacity = chosen >= TOTAL_GROUPS ? '1' : '0.5';
                            confirmBtn.disabled = chosen < TOTAL_GROUPS;
                        }

                        updatePriceStock();
                    };

                    function updatePriceStock() {
                        var priceEl = document.querySelector('.pd-price-current');
                        var stockEl = document.querySelector('.pd-qty-wrap b');
                        if (!priceEl) return;

                        if (combos && combos.length > 0) {
                            var val1 = selectedVals[0] || null;
                            var val2 = selectedVals[1] || null;
                            var matched = combos.find(function(c) {
                                return (c.option1_value_id == val1 && (!c.option2_value_id || c.option2_value_id == val2)) ||
                                       (c.option2_value_id == val1 && c.option1_value_id == val2);
                            });
                            if (matched && matched.price > 0) {
                                priceEl.textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(matched.price);
                                document.getElementById('selected_combo_id').value = matched.id;
                                if (stockEl && matched.stock != null) stockEl.textContent = matched.stock;
                                if (matched.image) {
                                    var vImgUrl = '/storage/' + matched.image;
                                    var activeSlideImg = document.querySelector('.pd-gallery-main .swiper-slide-active img') || document.querySelector('.pd-gallery-main img');
                                    if (activeSlideImg) {
                                        activeSlideImg.src = vImgUrl;
                                        var parentLink = activeSlideImg.closest('a');
                                        if (parentLink) parentLink.href = vImgUrl;
                                    }
                                }
                                return;
                            }
                        }
                        var chip = document.querySelector('.variant-chip-btn.active');
                        if (chip) {
                            var adj = parseFloat(chip.getAttribute('data-price-adj') || 0);
                            var np  = basePrice + adj;
                            if (np > 0) priceEl.textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(np);
                            var vs = chip.getAttribute('data-val-stock');
                            if (stockEl && vs != null && vs !== '' && vs !== 'null') stockEl.textContent = vs;
                        }
                    }

                    /* =========================================================
                       MAIN GATEKEEPER — opens Shopee-style modal if not selected
                       ========================================================= */
                    window.submitProductForm = function(actionType) {
                        if (HAS_VARIANTS) {
                            var selectedCount = 0;
                            for (var k in selectedVals) {
                                if (selectedVals.hasOwnProperty(k) && selectedVals[k]) selectedCount++;
                            }

                            if (selectedCount < TOTAL_GROUPS) {
                                // Open variant bottom sheet modal
                                openVariantModal(actionType);
                                return;
                            }
                        }

                        // All good — submit the form
                        document.getElementById('form_action_input').value = actionType;
                        document.getElementById('form-add-to-cart').submit();
                    };

                    /* =========================================================
                       VARIANT MODAL (Shopee bottom-sheet style)
                       ========================================================= */
                    var pendingAction = 'cart';

                    window.openVariantModal = function(actionType) {
                        pendingAction = actionType || 'cart';
                        var modal = document.getElementById('variant-modal-overlay');
                        if (modal) {
                            modal.style.pointerEvents = 'auto';
                            modal.style.display = 'flex';
                            requestAnimationFrame(function() {
                                modal.style.opacity = '1';
                                document.getElementById('variant-modal-sheet').style.transform = 'translateY(0)';
                            });
                        }
                        // Update confirm button state
                        var chosen = 0;
                        for (var k in selectedVals) { if (selectedVals[k]) chosen++; }
                        var confirmBtn = document.getElementById('vr-modal-confirm');
                        if (confirmBtn) {
                            confirmBtn.style.opacity = chosen >= TOTAL_GROUPS ? '1' : '0.5';
                            confirmBtn.disabled = chosen < TOTAL_GROUPS;
                            confirmBtn.textContent = actionType === 'buy' ? 'Beli Sekarang' : 'Tambah ke Keranjang';
                        }
                    };

                    window.closeVariantModal = function() {
                        var modal = document.getElementById('variant-modal-overlay');
                        if (modal) {
                            modal.style.opacity = '0';
                            document.getElementById('variant-modal-sheet').style.transform = 'translateY(100%)';
                            setTimeout(function() {
                                modal.style.display = 'none';
                                modal.style.pointerEvents = 'none'; // restore — stop blocking clicks
                            }, 300);
                        }
                    };

                    window.confirmVariantModal = function() {
                        var chosen = 0;
                        for (var k in selectedVals) { if (selectedVals[k]) chosen++; }
                        if (chosen < TOTAL_GROUPS) return;
                        closeVariantModal();
                        document.getElementById('form_action_input').value = pendingAction;
                        document.getElementById('form-add-to-cart').submit();
                    };
                })();
                </script>
                {{-- END variant engine --}}

                <div class="pd-qty-wrap">
                    <span style="font-size:0.875rem; font-weight:700; color:var(--text-main);">Kuantitas:</span>
                    <div class="pd-qty-ctrl">
                        <button type="button" class="pd-qty-btn" onclick="document.getElementById('qty_input').stepDown()">−</button>
                        <input type="number" id="qty_input" class="pd-qty-input" name="qty" 
                               value="{{ $service->min_order ?? 1 }}" min="{{ $service->min_order ?? 1 }}"
                               @if($service->type !== 'service' && $service->stock > 0) max="{{ $service->stock }}" @endif
                               @if($service->type !== 'service' && $service->stock <= 0) disabled @endif>
                        <button type="button" class="pd-qty-btn" onclick="document.getElementById('qty_input').stepUp()">+</button>
                    </div>
                    <span style="font-size:0.85rem; color:var(--text-muted);">
                        @if($service->type === 'service')
                            Jasa / Layanan
                        @elseif($service->stock > 0)
                            Tersisa <b style="color:var(--text-main);">{{ $service->stock }}</b> buah
                        @else
                            <b style="color:#EF4444;">Stok Habis</b>
                        @endif
                    </span>
                </div>

                <div class="pd-actions">
                    <button type="button" onclick="submitProductForm('cart')" class="pd-btn pd-btn-outline"
                            @if($service->type !== 'service' && $service->stock <= 0) disabled @endif>
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 20a1 1 0 100-2 1 1 0 000 2zM20 20a1 1 0 100-2 1 1 0 000 2z"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                        Keranjang
                    </button>
                    <button type="button" onclick="submitProductForm('buy')" class="pd-btn pd-btn-primary"
                            @if($service->type !== 'service' && $service->stock <= 0) disabled @endif>
                        Beli Sekarang
                    </button>
                </div>
            </form>

            {{-- ══ VARIANT BOTTOM SHEET MODAL (Shopee-style) ══ --}}
            @if($vGroups->count() > 0)
            <div id="variant-modal-overlay"
                 onclick="if(event.target === this) closeVariantModal()"
                 style="display:none; pointer-events:none; position:fixed; inset:0; background:rgba(15,23,42,0.55); z-index:9999; align-items:flex-end; justify-content:center; opacity:0; transition:opacity .28s; -webkit-backdrop-filter:blur(3px); backdrop-filter:blur(3px);">
                <div id="variant-modal-sheet"
                     style="background:#fff; width:100%; max-width:520px; border-radius:24px 24px 0 0; padding:0; box-shadow:0 -8px 40px rgba(0,0,0,0.18); transform:translateY(100%); transition:transform .32s cubic-bezier(.32,1,.32,1); overflow:hidden;">

                    {{-- Handle --}}
                    <div style="display:flex; align-items:center; justify-content:center; padding:0.75rem 0 0;">
                        <div style="width:40px; height:4px; background:#E2E8F0; border-radius:4px;"></div>
                    </div>

                    {{-- Header --}}
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:1rem 1.25rem 0.75rem; border-bottom:1px solid #F1F5F9;">
                        <div style="display:flex; align-items:center; gap:0.75rem;">
                            @if($service->image_url)
                            <img src="{{ $service->image_url }}" alt="" style="width:52px; height:52px; border-radius:10px; object-fit:cover; border:1.5px solid #E2E8F0;">
                            @endif
                            <div>
                                <div style="font-size:0.78rem; font-weight:700; color:#94A3B8; text-transform:uppercase; letter-spacing:0.04em;">Pilih Variasi</div>
                                <div style="font-size:0.95rem; font-weight:800; color:#1E293B; line-height:1.3; max-width:240px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $service->name }}</div>
                            </div>
                        </div>
                        <button onclick="closeVariantModal()" style="width:34px; height:34px; background:#F1F5F9; border:none; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#64748B; flex-shrink:0; transition:background .2s;" onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>

                    {{-- Variant Groups --}}
                    <div id="vr-modal-body" style="padding:1rem 1.25rem; max-height:55vh; overflow-y:auto;">
                        @foreach($vGroups as $gIdx => $vGroup)
                        <div data-modal-group="{{ $gIdx }}" style="margin-bottom:1.25rem;">
                            <div style="font-size:0.8rem; font-weight:700; color:#475569; margin-bottom:0.6rem; display:flex; align-items:center; gap:0.35rem;">
                                <svg width="13" height="13" fill="none" stroke="var(--accent,#1B6FE8)" stroke-width="2.5" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3h-8l-2 4h12l-2-4z"/></svg>
                                {{ $vGroup->name }} <span style="color:#EF4444;">*</span>
                            </div>
                            <div style="display:flex; flex-wrap:wrap; gap:0.5rem;">
                                @foreach($vGroup->values as $vVal)
                                <button type="button" class="modal-chip-btn"
                                    data-group-index="{{ $gIdx }}"
                                    data-val-id="{{ $vVal->id }}"
                                    onclick="selectModalChip(this, {{ $gIdx }}, {{ $vVal->id }})"
                                    style="padding:0.5rem 1.1rem; font-size:0.82rem; font-weight:600; border-radius:10px; border:1.5px solid #CBD5E1; background:#fff; color:#334155; cursor:pointer; transition:all 0.18s;">
                                    {{ $vVal->value }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endforeach

                        {{-- Warning if not all selected --}}
                        <div id="modal-warn" style="display:none; font-size:0.78rem; font-weight:600; color:#EF4444; margin-top:0.25rem;">
                            ⚠️ Mohon pilih semua variasi sebelum melanjutkan.
                        </div>
                    </div>

                    {{-- Confirm Button --}}
                    <div style="padding:1rem 1.25rem 1.5rem; border-top:1px solid #F1F5F9;">
                        <button id="vr-modal-confirm" onclick="confirmVariantModal()"
                            style="width:100%; padding:0.9rem; background:var(--accent,#1B6FE8); color:#fff; font-size:0.95rem; font-weight:800; border:none; border-radius:14px; cursor:pointer; opacity:0.5; transition:all .2s; box-shadow:0 4px 16px rgba(27,111,232,0.3);" disabled
                            onmouseover="if(!this.disabled){this.style.background='#1254C0'}" onmouseout="this.style.background='var(--accent,#1B6FE8)'">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
            <style>
            #variant-modal-overlay[style*="flex"] { display:flex !important; }
            </style>
            @endif
        @else
            {{-- Non-ecommerce / Custom Service --}}
            <div class="pd-price-box" style="background: linear-gradient(135deg, #EFF6FF, #ffffff); border-color: #BFDBFE;">
                <div class="pd-price-current" style="color: #2563EB; font-size:1.75rem;">Konsultasi Gratis</div>
                <div style="font-size:0.9rem; color:#1E3A8A; width:100%;">Tim ahli kami siap memberikan penawaran terbaik untuk Anda.</div>
            </div>
            
            <a href="javascript:void(0)" onclick="openOrderModal('Produk: {{ addslashes($service->name) }}')" class="pd-btn pd-btn-primary" style="width:100%;">
                Tanya via WhatsApp
            </a>
        @endif
    </div>
</section>

{{-- BOTTOM CONTENT --}}
<section class="pd-bottom-layout">
    <div class="pd-card">
        @if(is_array($service->specifications) && count($service->specifications) > 0)
            <div class="pd-section-title">Spesifikasi Produk</div>
            <table class="pd-specs-table">
                @foreach($service->specifications as $spec)
                <tr>
                    <td>{{ $spec['key'] }}</td>
                    <td>{{ $spec['value'] }}</td>
                </tr>
                @endforeach
            </table>
        @endif

        <div class="pd-section-title">Deskripsi Produk</div>
        <div class="pd-content">
            {!! $service->description ?? '<p>Belum ada deskripsi untuk produk ini.</p>' !!}
        </div>

        @php
            $faqs = is_array($service->faqs) && !empty($service->faqs) ? $service->faqs : [];
        @endphp
        @if(count($faqs) > 0)
            <div class="pd-section-title" style="margin-top: 2.5rem;">FAQ {{ $service->name }}</div>
            <div style="display:flex; flex-direction:column; gap:1rem;">
                @foreach($faqs as $f)
                <div style="background:var(--bg-surface); padding:1.25rem; border-radius:14px; border:1px solid var(--border-1);">
                    <div style="font-weight:800; color:var(--text-main); margin-bottom:0.5rem; font-size:0.95rem; font-family:'Montserrat',sans-serif;">{{ $f['q'] ?? '' }}</div>
                    <div style="font-size:0.875rem; color:var(--text-muted); line-height:1.6;">{{ $f['a'] ?? '' }}</div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- SIDEBAR --}}
    <div>
        <div class="pd-card" style="position: sticky; top: 100px;">
            <div class="pd-section-title" style="margin-bottom:1.25rem;">Jaminan Belanja</div>
            
            <div style="display:flex; align-items:flex-start; gap:12px; margin-bottom:1rem;">
                <div style="width:38px; height:38px; background:#F0F9FF; color:var(--accent); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                    <div style="font-weight:800; font-size:0.9rem; color:var(--text-main); margin-bottom:0.15rem; font-family:'Montserrat',sans-serif;">100% Original</div>
                    <div style="font-size:0.8rem; color:var(--text-muted); line-height:1.4;">Produk asli dan bergaransi resmi.</div>
                </div>
            </div>
            
            <div style="display:flex; align-items:flex-start; gap:12px; margin-bottom:1rem;">
                <div style="width:38px; height:38px; background:#F0F9FF; color:var(--accent); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                </div>
                <div>
                    <div style="font-weight:800; font-size:0.9rem; color:var(--text-main); margin-bottom:0.15rem; font-family:'Montserrat',sans-serif;">Pengiriman Aman</div>
                    <div style="font-size:0.8rem; color:var(--text-muted); line-height:1.4;">Tepat waktu dengan asuransi pengiriman.</div>
                </div>
            </div>
            
            @if($service->brochure)
            <a href="{{ asset('storage/'.$service->brochure) }}" target="_blank" class="pd-btn pd-btn-outline" style="margin-top:1.5rem; width:100%;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Unduh Brosur/Datasheet
            </a>
            @endif
        </div>
    </div>
</section>

{{-- ═══ MENGAPA ALATRUMAH.COM ═══ --}}
<section style="background:var(--bg-base); padding:3.5rem 1.5rem; border-top:1px solid var(--border-1);">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:2.5rem;">
            <div style="font-size:0.75rem; font-weight:800; letter-spacing:0.15em; color:var(--accent); text-transform:uppercase; margin-bottom:0.4rem;">Mengapa Memilih Kami</div>
            <h2 style="font-size:1.5rem; font-weight:900; color:var(--text-main); line-height:1.2; letter-spacing:-0.03em; font-family:'Montserrat',sans-serif;">Toko Alat Rumah Tangga<br>Terpercaya di Surabaya</h2>
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:1.25rem;">
            <div class="pd-card" style="text-align:center; padding:1.5rem 1rem;">
                <div style="width:48px; height:48px; background:#F0F9FF; color:var(--accent); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 0.875rem;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" /></svg>
                </div>
                <div style="font-weight:800; margin-bottom:0.4rem; color:var(--text-main); font-size:0.95rem; font-family:'Montserrat',sans-serif;">Produk Berkualitas</div>
                <div style="font-size:0.825rem; color:var(--text-muted); line-height:1.5;">Semua produk tersertifikasi dan bergaransi resmi dari produsen.</div>
            </div>
            <div class="pd-card" style="text-align:center; padding:1.5rem 1rem;">
                <div style="width:48px; height:48px; background:#F0F9FF; color:var(--accent); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 0.875rem;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
                </div>
                <div style="font-weight:800; margin-bottom:0.4rem; color:var(--text-main); font-size:0.95rem; font-family:'Montserrat',sans-serif;">Pengiriman Cepat</div>
                <div style="font-size:0.825rem; color:var(--text-muted); line-height:1.5;">Dikirim ke seluruh Indonesia dengan aman dan tepat waktu.</div>
            </div>
            <div class="pd-card" style="text-align:center; padding:1.5rem 1rem;">
                <div style="width:48px; height:48px; background:#F0F9FF; color:var(--accent); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 0.875rem;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><polyline points="12 6 12 12 16 14" /></svg>
                </div>
                <div style="font-weight:800; margin-bottom:0.4rem; color:var(--text-main); font-size:0.95rem; font-family:'Montserrat',sans-serif;">Harga Terbaik</div>
                <div style="font-size:0.825rem; color:var(--text-muted); line-height:1.5;">Harga kompetitif langsung dari distributor resmi. Diskon setiap hari.</div>
            </div>
            <div class="pd-card" style="text-align:center; padding:1.5rem 1rem;">
                <div style="width:48px; height:48px; background:#F0F9FF; color:var(--accent); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 0.875rem;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" /></svg>
                </div>
                <div style="font-weight:800; margin-bottom:0.4rem; color:var(--text-main); font-size:0.95rem; font-family:'Montserrat',sans-serif;">CS Responsif</div>
                <div style="font-size:0.825rem; color:var(--text-muted); line-height:1.5;">Tim customer service kami siap membantu via WhatsApp setiap saat.</div>
            </div>
        </div>
    </div>
</section>

{{-- TESTIMONIALS --}}
@include('components.testimonials')

{{-- RELATED PRODUCTS --}}
@if($related->count() > 0)
<section style="background:var(--bg-surface); padding:2.5rem 1rem; border-top:1px solid var(--border-1);">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="font-size:1.25rem; font-weight:900; color:var(--text-main); margin-bottom:1.25rem; letter-spacing:-0.02em; font-family:'Montserrat',sans-serif;">Produk &amp; Layanan Lainnya</div>
        <div class="pd-related-grid">
            @foreach($related as $r)
                <a href="{{ route_locale('products.show', $r->slug) }}" style="text-decoration:none; display:block;" class="pd-card pd-card-hover pd-related-card">
                    <img src="{{ $r->image_url }}" alt="{{ $r->name }}" class="pd-related-img" loading="lazy">
                    <div class="pd-related-title">{{ $r->name }}</div>
                    @if($r->short_desc)
                    <div class="pd-related-desc">{{ $r->short_desc }}</div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    var thumbsEl = document.getElementById('pd-swiper-thumbs');
    if (thumbsEl && window.Swiper) {
        var swiperThumbs = new Swiper('#pd-swiper-thumbs', {
            spaceBetween: 8,
            slidesPerView: 'auto',
            freeMode: true,
            watchSlidesProgress: true,
        });
        new Swiper('#pd-swiper-main', {
            spaceBetween: 0,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: { swiper: swiperThumbs },
        });
    } else if (window.Swiper) {
        var mainEl = document.getElementById('pd-swiper-main');
        if (mainEl) new Swiper('#pd-swiper-main', { spaceBetween: 0 });
    }
});
</script>

@endsection
