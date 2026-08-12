@extends('layouts.admin')

@section('title', 'Tambah Voucher')

@section('content')
<div class="mb-4 d-flex align-items-center gap-3">
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <h1 class="h3 mb-0 text-gray-800">Tambah Voucher Baru</h1>
</div>

<div class="card shadow mb-4 max-w-4xl">
    <div class="card-body p-4">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Kode Voucher <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control text-uppercase @error('code') is-invalid @enderror" value="{{ old('code') }}" required placeholder="Contoh: MERDEKA20">
                    <div class="form-text">Kode unik yang dimasukkan pembeli, tanpa spasi.</div>
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                        <option value="product" {{ old('category') == 'product' ? 'selected' : '' }}>Diskon Produk</option>
                        <option value="shipping" {{ old('category') == 'shipping' ? 'selected' : '' }}>Gratis Ongkir</option>
                        <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Event Spesial</option>
                        <option value="member" {{ old('category') == 'member' ? 'selected' : '' }}>Member Khusus</option>
                        <option value="referral" {{ old('category') == 'referral' ? 'selected' : '' }}>Referral</option>
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Deskripsi Pendek</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" placeholder="Contoh: Spesial Hari Kemerdekaan">
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Teks Badge / Label</label>
                    <input type="text" name="badge" class="form-control @error('badge') is-invalid @enderror" value="{{ old('badge') }}" placeholder="Contoh: 17 Agustus">
                    @error('badge')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <hr class="my-2">

                <div class="col-md-6">
                    <label class="form-label fw-bold">Tipe Diskon <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required id="discount-type">
                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold" id="value-label">Nilai Diskon (%) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" required>
                    @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Minimal Pembelian (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="min_purchase" class="form-control @error('min_purchase') is-invalid @enderror" value="{{ old('min_purchase', 0) }}" required>
                    <div class="form-text">Isi 0 jika tanpa minimal belanja.</div>
                    @error('min_purchase')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Maksimal Potongan Harga (Rp)</label>
                    <input type="number" name="max_discount" class="form-control @error('max_discount') is-invalid @enderror" value="{{ old('max_discount') }}" placeholder="Opsional (Berguna untuk tipe persen)">
                    <div class="form-text">Batas maksimal nominal diskon jika pakai persentase. Kosongkan jika tidak ada batas.</div>
                    @error('max_discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <hr class="my-2">

                <div class="col-md-4">
                    <label class="form-label fw-bold">Batas Pemakaian (Kuota)</label>
                    <input type="number" name="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" value="{{ old('usage_limit') }}" placeholder="Opsional">
                    <div class="form-text">Total voucher ini bisa dipakai berapa kali. Kosongkan jika unlimited.</div>
                    @error('usage_limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal Mulai Berlaku</label>
                    <input type="datetime-local" name="started_at" class="form-control @error('started_at') is-invalid @enderror" value="{{ old('started_at') }}">
                    @error('started_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal Berakhir Berlaku</label>
                    <input type="datetime-local" name="expired_at" class="form-control @error('expired_at') is-invalid @enderror" value="{{ old('expired_at') }}">
                    @error('expired_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 mt-4">
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActive" {{ old('is_active', true) ? 'checked' : '' }} value="1">
                        <label class="form-check-label ms-2" for="isActive">Voucher Aktif & Bisa Digunakan</label>
                    </div>
                </div>

            </div>

            <div class="mt-5 text-end">
                <button type="submit" class="btn btn-primary btn-lg px-5">Simpan Voucher</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSel = document.getElementById('discount-type');
    const valLbl = document.getElementById('value-label');
    
    function updateLabel() {
        if (typeSel.value === 'percentage') {
            valLbl.innerHTML = 'Nilai Diskon (%) <span class="text-danger">*</span>';
        } else {
            valLbl.innerHTML = 'Nominal Potongan (Rp) <span class="text-danger">*</span>';
        }
    }
    
    typeSel.addEventListener('change', updateLabel);
    updateLabel();
});
</script>
@endsection
