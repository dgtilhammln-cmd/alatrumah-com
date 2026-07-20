@extends('layouts.app')

@section('content')
<style>
:root{--c-bg:#ffffff;--c-surface:#F8FAFC;--c-card:#ffffff;--c-border:#E2E8F0;--c-text:#0F172A;--c-muted:#64748B;--c-accent:#0EA5E9;--font:'Montserrat',sans-serif;}
body{background:var(--c-bg);}

.cart-layout{max-width:1100px;margin:120px auto 4rem;padding:0 1.5rem;display:grid;grid-template-columns:1fr 340px;gap:2rem;}
@media(max-width:900px){.cart-layout{grid-template-columns:1fr;}}

.cart-title{font-size:1.75rem;font-weight:800;color:var(--c-text);font-family:var(--font);margin-bottom:1.5rem;letter-spacing:-0.02em;}

.cart-items{display:flex;flex-direction:column;gap:1rem;}
.cart-item{display:flex;align-items:center;gap:1.25rem;background:var(--c-card);border:1.5px solid var(--c-border);border-radius:16px;padding:1.25rem;transition:border-color 0.2s;}
.cart-item:hover{border-color:var(--c-accent);}
.cart-item-img{width:90px;height:90px;border-radius:12px;background:var(--c-surface);overflow:hidden;flex-shrink:0;}
.cart-item-img img{width:100%;height:100%;object-fit:cover;}
.cart-item-info{flex:1;}
.cart-item-name{font-size:1rem;font-weight:700;color:var(--c-text);font-family:var(--font);margin:0 0 0.25rem;}
.cart-item-variant{font-size:0.8rem;color:var(--c-muted);font-family:var(--font);margin-bottom:0.5rem;}
.cart-item-price{font-size:0.95rem;font-weight:700;color:var(--c-accent);font-family:var(--font);}
.cart-item-actions{display:flex;align-items:center;gap:1rem;}
.qty-wrap{display:flex;align-items:center;border:1.5px solid var(--c-border);border-radius:8px;overflow:hidden;background:var(--c-surface);}
.qty-btn{width:32px;height:32px;display:flex;align-items:center;justify-content:center;background:none;border:none;cursor:pointer;color:var(--c-text);font-weight:bold;}
.qty-btn:hover{background:var(--c-border);}
.qty-input{width:40px;height:32px;border:none;background:none;text-align:center;font-weight:600;font-family:var(--font);font-size:0.9rem;}
.qty-input:focus{outline:none;}
.btn-remove{background:#FEE2E2;color:#EF4444;border:none;border-radius:8px;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s;}
.btn-remove:hover{background:#EF4444;color:#fff;}

.cart-summary{background:var(--c-surface);border-radius:20px;padding:1.5rem;position:sticky;top:100px;align-self:start;}
.cart-summary h3{font-size:1.25rem;font-weight:800;color:var(--c-text);font-family:var(--font);margin:0 0 1.25rem;}
.summary-row{display:flex;justify-content:space-between;font-size:0.9rem;color:var(--c-muted);font-family:var(--font);margin-bottom:0.75rem;}
.summary-total{display:flex;justify-content:space-between;font-size:1.1rem;font-weight:800;color:var(--c-text);font-family:var(--font);margin:1.25rem 0;padding-top:1.25rem;border-top:1.5px dashed var(--c-border);}
.btn-checkout{display:flex;align-items:center;justify-content:center;width:100%;padding:1rem;background:var(--c-text);color:#fff;border:none;border-radius:12px;font-family:var(--font);font-weight:700;font-size:1rem;cursor:pointer;text-decoration:none;transition:transform 0.2s, background 0.2s;}
.btn-checkout:hover{background:var(--c-accent);transform:translateY(-2px);color:#fff;}

.empty-cart{text-align:center;padding:5rem 2rem;background:var(--c-card);border:1.5px dashed var(--c-border);border-radius:20px;}
.empty-cart svg{color:var(--c-muted2);margin-bottom:1rem;}
</style>

<div class="cart-layout">
    <div class="cart-main">
        <h1 class="cart-title">Keranjang Belanja</h1>

        @if(session('success'))
            <div style="background:#F0FDF4;color:#166534;padding:1rem;border-radius:12px;margin-bottom:1rem;font-family:var(--font);font-size:0.9rem;border:1px solid #BBF7D0;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background:#FEF2F2;color:#991B1B;padding:1rem;border-radius:12px;margin-bottom:1rem;font-family:var(--font);font-size:0.9rem;border:1px solid #FECACA;">{{ session('error') }}</div>
        @endif

        @if($summary['items']->isEmpty())
            <div class="empty-cart">
                <img src="{{ asset('storage/cart-kosong.jpg') }}" alt="Keranjang Kosong" style="width:200px; height:auto; margin:0 auto 1.5rem; display:block;">
                <h3 style="font-size:1.25rem;font-weight:800;color:var(--c-text);font-family:var(--font);margin-bottom:0.5rem;">Keranjang Masih Kosong</h3>
                <p style="color:var(--c-muted);font-family:var(--font);font-size:0.95rem;margin-bottom:1.5rem;">Ayo temukan produk dan layanan terbaik untuk rumahmu.</p>
                <a href="{{ route('products') }}" class="btn-checkout" style="display:inline-flex;width:auto;padding:0.75rem 1.5rem;">Mulai Belanja</a>
            </div>
        @else
            <div class="cart-items">
                @foreach($summary['items'] as $item)
                    <div class="cart-item">
                        <div class="cart-item-img">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}">
                            @else
                                <div style="width:100%;height:100%;background:#E2E8F0;"></div>
                            @endif
                        </div>
                        <div class="cart-item-info">
                            <h4 class="cart-item-name">{{ $item->product->name ?? 'Produk Telah Dihapus' }}</h4>
                            @if($item->variantValue)
                                <div class="cart-item-variant">Varian: {{ $item->variantValue->value }}</div>
                            @endif
                            <div class="cart-item-price">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                        </div>
                        <div class="cart-item-actions">
                            <form action="{{ route('cart.update') }}" method="POST" style="display:flex;align-items:center;gap:0.75rem;">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                <div class="qty-wrap">
                                    <button type="button" class="qty-btn" onclick="this.nextElementSibling.stepDown(); this.form.submit();">-</button>
                                    <input type="number" name="qty" class="qty-input" value="{{ $item->qty }}" min="1" onchange="this.form.submit()">
                                    <button type="button" class="qty-btn" onclick="this.previousElementSibling.stepUp(); this.form.submit();">+</button>
                                </div>
                            </form>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                <button type="submit" class="btn-remove" title="Hapus">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if(!$summary['items']->isEmpty())
        <div class="cart-summary">
            <h3>Ringkasan Belanja</h3>
            <div class="summary-row">
                <span>Total Items ({{ $summary['count'] }})</span>
                <span>Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Total Berat</span>
                <span>{{ $summary['total_weight'] }} gr</span>
            </div>
            <div class="summary-total">
                <span>Total Harga</span>
                <span style="color:var(--c-accent);">Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="btn-checkout">Lanjut Checkout</a>
        </div>
    @endif
</div>
@endsection
