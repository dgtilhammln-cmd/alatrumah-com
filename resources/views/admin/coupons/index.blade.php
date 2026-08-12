@extends('layouts.admin')

@section('title', 'Manajemen Voucher (Kupon)')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Voucher / Kupon Diskon</h1>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Voucher
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th>Tipe / Nilai</th>
                        <th>Min. Pembelian</th>
                        <th>Maks. Diskon</th>
                        <th>Batas / Terpakai</th>
                        <th>Masa Berlaku</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                        <tr>
                            <td>
                                <strong>{{ $coupon->code }}</strong>
                                @if($coupon->badge)
                                    <br><span class="badge bg-info text-dark">{{ $coupon->badge }}</span>
                                @endif
                            </td>
                            <td>{{ ucfirst($coupon->category) }}</td>
                            <td>
                                @if($coupon->type->value === 'percentage')
                                    {{ (int)$coupon->value }}%
                                @else
                                    Rp {{ number_format($coupon->value, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>Rp {{ number_format($coupon->min_purchase, 0, ',', '.') }}</td>
                            <td>
                                {{ $coupon->max_discount ? 'Rp '.number_format($coupon->max_discount, 0, ',', '.') : '-' }}
                            </td>
                            <td>
                                {{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}
                            </td>
                            <td>
                                @if($coupon->started_at || $coupon->expired_at)
                                    {{ $coupon->started_at ? $coupon->started_at->format('d/m/y H:i') : 'Awal' }}
                                    <br>s/d<br>
                                    {{ $coupon->expired_at ? $coupon->expired_at->format('d/m/y H:i') : 'Selamanya' }}
                                @else
                                    Selamanya
                                @endif
                            </td>
                            <td>
                                @if($coupon->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus voucher ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Belum ada voucher yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $coupons->links() }}
        </div>
    </div>
</div>
@endsection
