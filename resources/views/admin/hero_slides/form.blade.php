@extends('layouts.admin')
@section('title', isset($slide) ? 'Edit Hero Slide' : 'Tambah Hero Slide')
@section('page-title', isset($slide) ? 'Edit Hero Slide' : 'Tambah Hero Slide Baru')
@section('content')
<div style="max-width:680px;">
<form method="POST" action="{{ isset($slide) ? route('admin.hero_slides.update', $slide) : route('admin.hero_slides.store') }}" enctype="multipart/form-data">
    @csrf @if(isset($slide)) @method('PUT') @endif

    @if($errors->any())
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#fca5a5;padding:.875rem 1.25rem;border-radius:10px;margin-bottom:1.5rem;font-size:.875rem;">
        <ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Main Info --}}
        <div class="admin-card">
            <h3 style="font-size:.7rem;font-weight:700;color:#38BDF8;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">Konten Slide</h3>
            <div style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <label class="form-label">Judul Slide <span style="color:#f87171;">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $slide->title ?? '') }}" class="form-input" required placeholder="Pabrik & Manufaktur">
                </div>
                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-input" rows="3" placeholder="Sirkulasi maksimal untuk membuang hawa panas...">{{ old('description', $slide->description ?? '') }}</textarea>
                    <p style="font-size:.7rem;color:rgba(255,255,255,.25);margin:.375rem 0 0;">Maks. 500 karakter.</p>
                </div>
                <div>
                    <label class="form-label">Ikon (Nama SVG / Kode)</label>
                    <input type="text" name="icon" value="{{ old('icon', $slide->icon ?? '') }}" class="form-input" placeholder="building | home | truck | coffee">
                    <p style="font-size:.7rem;color:rgba(255,255,255,.25);margin:.375rem 0 0;">Pilih: building, home, truck, coffee, activity, shield, clock, star</p>
                </div>
            </div>
        </div>

        {{-- Image --}}
        <div class="admin-card">
            <h3 style="font-size:.7rem;font-weight:700;color:#38BDF8;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">Gambar Slide</h3>
            @if(isset($slide) && $slide->image)
                <img src="{{ asset('storage/'.$slide->image) }}" style="height:100px;border-radius:8px;object-fit:cover;margin-bottom:.75rem;display:block;">
            @endif
            <input type="file" name="image" accept="image/*" class="form-input" style="padding:.5rem;">
            <p style="font-size:.7rem;color:rgba(255,255,255,.25);margin:.375rem 0 0;">Disarankan: 400×300px. Auto-konversi ke WebP.</p>
        </div>

        {{-- Button --}}
        <div class="admin-card">
            <h3 style="font-size:.7rem;font-weight:700;color:#38BDF8;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">Tombol (Opsional)</h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div>
                    <label class="form-label">Teks Tombol</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $slide->button_text ?? '') }}" class="form-input" placeholder="Lihat Detail">
                </div>
                <div>
                    <label class="form-label">URL / Link</label>
                    <input type="text" name="button_url" value="{{ old('button_url', $slide->button_url ?? '') }}" class="form-input" placeholder="#produk atau /products">
                </div>
            </div>
        </div>

        {{-- Meta --}}
        <div class="admin-card">
            <h3 style="font-size:.7rem;font-weight:700;color:#38BDF8;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">Pengaturan</h3>
            <div style="display:flex;gap:1.5rem;align-items:center;">
                <div>
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="order" value="{{ old('order', $slide->order ?? 0) }}" class="form-input" min="0" style="width:80px;">
                </div>
                <div style="display:flex;align-items:flex-end;gap:.5rem;padding-bottom:.5rem;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }} style="accent-color:#38BDF8;width:16px;height:16px;">
                    <label for="is_active" style="font-size:.875rem;color:#D4D4D8;">Tampilkan di homepage</label>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn-primary">Simpan Slide</button>
            <a href="{{ route('admin.hero_slides.index') }}" class="btn-outline">Batal</a>
        </div>
    </div>
</form>
</div>
@endsection
