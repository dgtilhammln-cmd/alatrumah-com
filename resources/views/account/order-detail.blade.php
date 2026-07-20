@extends('account.layout')
@section('title', 'Detail Pesanan #' . $order->order_number . ' – Akun')

@section('acc_page')
<style>
.od-card { background: #fff; border: 1px solid var(--c-border); border-radius: 12px; margin-bottom: 1.5rem; overflow: hidden; }
.od-header { background: var(--c-surface); padding: 1rem 1.5rem; border-bottom: 1px solid var(--c-border); display: flex; justify-content: space-between; align-items: center; }
.od-body { padding: 1.5rem; }
.od-title { font-size: 1rem; font-weight: 700; color: var(--c-text); margin: 0; }
.od-meta { font-size: 0.85rem; color: var(--c-muted); }
.od-status { font-size: 0.85rem; font-weight: 700; padding: 0.4rem 1rem; border-radius: 999px; }

.od-item { display: flex; gap: 1rem; padding: 1rem 0; border-bottom: 1px dashed var(--c-border); }
.od-item:last-child { border-bottom: none; padding-bottom: 0; }
.od-item-img { width: 70px; height: 70px; border-radius: 8px; object-fit: cover; background: #F1F5F9; }
.od-item-info { flex: 1; }
.od-item-title { font-size: 0.95rem; font-weight: 600; color: var(--c-text); margin-bottom: 0.25rem; }
.od-item-meta { font-size: 0.85rem; color: var(--c-muted); }
.od-item-price { font-size: 0.95rem; font-weight: 700; color: var(--c-text); }

.summary-row { display: flex; justify-content: space-between; font-size: 0.9rem; color: var(--c-muted); margin-bottom: 0.5rem; }
.summary-row.total { font-size: 1.1rem; font-weight: 800; color: var(--c-accent); margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--c-border); }

.timeline { position: relative; padding-left: 1.5rem; }
.timeline::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 2px; background: #E2E8F0; }
.tl-item { position: relative; margin-bottom: 1.5rem; }
.tl-item::before { content: ''; position: absolute; left: -1.8rem; top: 0.2rem; width: 12px; height: 12px; border-radius: 50%; background: var(--c-accent); border: 2px solid #fff; box-shadow: 0 0 0 2px var(--c-accent); }
.tl-date { font-size: 0.75rem; color: var(--c-muted); margin-bottom: 0.25rem; font-weight: 600; }
.tl-desc { font-size: 0.9rem; color: var(--c-text); }
.tl-city { font-size: 0.8rem; color: var(--c-muted); margin-top: 0.25rem; }
</style>

<div class="mb-4">
    <a href="{{ route('account.orders') }}" style="color: var(--c-muted); font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
        &larr; Kembali ke Daftar Pesanan
    </a>
</div>

<div class="od-card">
    <div class="od-header">
        <div>
            <h2 class="od-title">No. Pesanan: #{{ $order->order_number }}</h2>
            <div class="od-meta">{{ $order->created_at->format('d M Y, H:i') }} WIB</div>
        </div>
        <div class="od-status" style="background-color: {{ $order->status->color() === 'yellow' ? '#FEF3C7' : ($order->status->color() === 'green' ? '#D1FAE5' : ($order->status->color() === 'blue' ? '#DBEAFE' : '#F1F5F9')) }}; color: {{ $order->status->color() === 'yellow' ? '#D97706' : ($order->status->color() === 'green' ? '#059669' : ($order->status->color() === 'blue' ? '#2563EB' : '#475569')) }}; border: 1px solid currentColor;">
            {{ $order->status->label() }}
        </div>
    </div>
    
    <div class="od-body" style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
        
        {{-- KIRI: PRODUK & TRACKING --}}
        <div>
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: var(--c-text);">Daftar Produk</h3>
            <div style="margin-bottom: 2rem;">
                @foreach($order->items as $item)
                <div class="od-item">
                    @if($item->product && !empty($item->product->image))
                        <img src="{{ asset('storage/'.$item->product->image) }}" class="od-item-img">
                    @else
                        <div class="od-item-img"></div>
                    @endif
                    <div class="od-item-info">
                        <div class="od-item-title">{{ $item->product_name }}</div>
                        <div class="od-item-meta">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="od-item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>

            @if($order->shipment)
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: var(--c-text);">Informasi Pengiriman</h3>
            <div style="background: #F8FAFC; padding: 1.25rem; border-radius: 10px; border: 1px solid #E2E8F0; margin-bottom: 2rem;">
                <div style="margin-bottom: 1rem; display: flex; justify-content: space-between;">
                    <div>
                        <div style="font-size: 0.8rem; color: var(--c-muted);">Kurir</div>
                        <div style="font-weight: 700; color: var(--c-text);">{{ strtoupper($order->shipment->courier_name) }} {{ strtoupper($order->shipment->courier_service ?? '') }}</div>
                    </div>
                    @if($order->shipment->tracking_number)
                    <div style="text-align: right;">
                        <div style="font-size: 0.8rem; color: var(--c-muted);">No. Resi</div>
                        <div style="font-weight: 700; color: var(--c-accent); font-family: monospace; font-size: 1.1rem;">{{ $order->shipment->tracking_number }}</div>
                    </div>
                    @endif
                </div>

                @if($tracking && !empty($tracking['manifest']))
                    <div style="margin-top: 1.5rem; border-top: 1px dashed #CBD5E1; padding-top: 1.5rem;">
                        <div class="timeline">
                            @foreach($tracking['manifest'] as $tl)
                            <div class="tl-item">
                                <div class="tl-date">{{ $tl['date'] }}</div>
                                <div class="tl-desc">{{ $tl['desc'] }}</div>
                                @if(!empty($tl['city']))
                                <div class="tl-city">📍 {{ $tl['city'] }}</div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($order->shipment->tracking_number)
                    <div style="font-size: 0.85rem; color: var(--c-muted); text-align: center; padding: 1rem 0;">
                        Tracking belum tersedia dari ekspedisi. Coba beberapa saat lagi.
                    </div>
                @else
                    <div style="font-size: 0.85rem; color: var(--c-muted); text-align: center; padding: 1rem 0;">
                        Nomor resi belum diinput oleh admin.
                    </div>
                @endif
            </div>
            @endif

        </div>

        {{-- KANAN: RINGKASAN & ALAMAT --}}
        <div>
            @if($order->status->value === 'pending' && $order->payment && $order->payment->status->value === 'pending')
                <div style="background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 10px; padding: 1.25rem; margin-bottom: 1.5rem;">
                    <div style="font-size: 0.9rem; font-weight: 700; color: #92400E; margin-bottom: 0.5rem;">Belum Dibayar</div>
                    <div style="font-size: 0.8rem; color: #B45309; margin-bottom: 1rem;">Selesaikan pembayaran Anda agar pesanan dapat diproses.</div>
                    
                    @if($order->shipping_cost > 0)
                        <a href="{{ route('checkout.finish', $order->order_number) }}" style="display: block; width: 100%; text-align: center; background: #059669; color: #fff; text-decoration: none; padding: 0.75rem; border-radius: 8px; font-weight: 700; font-size: 0.9rem;">Bayar Sekarang</a>
                    @else
                        <button disabled style="display: block; width: 100%; text-align: center; background: #94A3B8; color: #fff; border: none; padding: 0.75rem; border-radius: 8px; font-weight: 700; font-size: 0.9rem; cursor: not-allowed;">Menunggu Info Ongkir</button>
                    @endif
                </div>
            @endif

            <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--c-text);">Ringkasan Pembayaran</h3>
            <div style="margin-bottom: 2rem;">
                <div class="summary-row">
                    <span>Total Harga Barang</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Ongkos Kirim</span>
                    <span>
                        @if($order->shipping_cost > 0)
                            Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                        @else
                            <span style="color:#D97706; font-size:0.8rem; font-weight:600;">Menunggu Konfirmasi Admin</span>
                        @endif
                    </span>
                </div>
                @if($order->discount > 0)
                <div class="summary-row" style="color: #10B981;">
                    <span>Diskon</span>
                    <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="summary-row total">
                    <span>Total Belanja</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--c-text);">Alamat Pengiriman</h3>
            <div style="background: var(--c-surface); padding: 1rem; border-radius: 10px; font-size: 0.85rem; color: var(--c-text); line-height: 1.5;">
                <div style="font-weight: 700; margin-bottom: 0.25rem;">{{ $order->shipping_address['receiver_name'] ?? '-' }}</div>
                <div style="color: var(--c-muted); margin-bottom: 0.5rem;">{{ $order->shipping_address['phone'] ?? '-' }}</div>
                <div>{{ $order->shipping_address['full_address'] ?? '-' }}</div>
                <div style="color: var(--c-muted); margin-top: 0.5rem;">
                    {{ $order->shipping_address['district'] ?? '' }}, {{ $order->shipping_address['city'] ?? '' }}<br>
                    {{ $order->shipping_address['province'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}
                </div>
            </div>
            
        </div>

    </div>
</div>

<style>
@media(max-width: 768px) {
    .od-body { grid-template-columns: 1fr !important; }
}
</style>
@endsection
