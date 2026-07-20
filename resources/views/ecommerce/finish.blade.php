@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h2>Selesaikan Pembayaran Anda</h2>
    <p>Order ID: <strong>{{ $order->order_number }}</strong></p>
    <p>Total: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>

    @if($order->payment && $order->payment->status === \App\Enums\PaymentStatus::Pending)
        <button id="pay-button" class="btn btn-primary btn-lg mt-3">Bayar Sekarang</button>
        
        <!-- Midtrans Snap Script -->
        <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
        
        <script>
            document.getElementById('pay-button').onclick = function(){
                snap.pay('{{ $order->payment->midtrans_token }}', {
                    onSuccess: function(result){
                        window.location.href = "{{ route('home.id') }}";
                        alert("Pembayaran berhasil!");
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran Anda!");
                    },
                    onError: function(result){
                        alert("Pembayaran gagal!");
                    },
                    onClose: function(){
                        alert('Anda menutup popup sebelum menyelesaikan pembayaran');
                    }
                });
            };
        </script>
    @else
        <div class="alert alert-info mt-3">
            Status Pesanan: {{ $order->status->value }}<br>
            Status Pembayaran: {{ $order->payment->status->value ?? 'Tidak ada' }}
        </div>
        <a href="{{ route('home.id') }}" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
    @endif
</div>
@endsection
