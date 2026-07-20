@extends('account.layout')
@section('title', 'Pesanan – Akun')

@section('acc_page')
<div class="acc-card">
    <div class="acc-card-header">
        <h2>Riwayat Pesanan</h2>
        <p>Semua transaksi pembelian Anda</p>
    </div>
    <div class="acc-card-body" style="padding:0;">
        @if($orders->count())
            <div style="overflow-x:auto;">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr style="cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'" onclick="window.location.href='{{ route('account.orders.show', $order->id) }}'">
                            <td style="font-weight:700; color:#0f172a;">#{{ $order->order_number ?? $order->id }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td style="color:#64748B;">{{ $order->items->count() ?? '-' }} item</td>
                            <td style="font-weight:700;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="order-badge" style="background-color: var(--c-surface); color: {{ $order->status->color() === 'yellow' ? '#D97706' : ($order->status->color() === 'green' ? '#059669' : ($order->status->color() === 'blue' ? '#2563EB' : '#475569')) }}; border: 1px solid currentColor; font-size:0.75rem;">
                                    {{ $order->status->label() }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('account.orders.show', $order->id) }}" style="color:#0EA5E9; font-weight:600; text-decoration:none; font-size:0.85rem;">Detail &rarr;</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:1rem 1.5rem;">
                {{ $orders->links() }}
            </div>
        @else
            <div class="empty-state">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <h3>Belum ada pesanan</h3>
                <p>Temukan produk terbaik untuk kebutuhan rumah Anda.</p>
                <a href="{{ route('products') }}" style="display:inline-flex;align-items:center;gap:0.5rem;margin-top:1rem;background:#0EA5E9;color:#fff;padding:0.6rem 1.25rem;border-radius:10px;font-size:0.85rem;font-weight:700;text-decoration:none;">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
