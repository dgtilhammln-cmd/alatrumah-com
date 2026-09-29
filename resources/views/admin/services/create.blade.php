@extends('layouts.admin')
@section('title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')
@section('page-title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')
@section('content')
@php $s = $service ?? null; @endphp

{{-- PAGE HEADER --}}
<div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;">
  <a href="{{ route('admin.services.index') }}" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:#fff;border:1.5px solid #E4E7F0;border-radius:10px;color:#64748B;text-decoration:none;flex-shrink:0;transition:all .2s;" onmouseover="this.style.borderColor='#3B82F6';this.style.color='#3B82F6'" onmouseout="this.style.borderColor='#E4E7F0';this.style.color='#64748B'">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  </a>
  <div>
    <h1 style="font-size:1.375rem;font-weight:800;color:#1E293B;margin:0 0 .1rem;letter-spacing:-.02em;">{{ $s ? 'Edit Layanan' : 'Tambah Layanan Baru' }}</h1>
    <p style="font-size:.8rem;color:#94A3B8;margin:0;">{{ $s ? 'Perbarui informasi dan konten layanan' : 'Isi detail lengkap layanan/produk baru' }}</p>
  </div>
</div>

<form method="POST" action="{{ $s ? route('admin.services.update',$s) : route('admin.services.store') }}" enctype="multipart/form-data" id="svc-form">
@csrf @if($s) @method('PUT') @endif

@if($errors->any())
  <div style="background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;color:#991B1B;font-size:.875rem;line-height:1.6;">
    <strong style="display:block;margin-bottom:.5rem;">⚠️ DOUBLE CEK DIBUTUHKAN:</strong>
    <ul style="margin:0;padding-left:1.25rem;">
      @foreach($errors->all() as $error)
        <li style="margin-bottom:.25rem;">{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
<div id="validation-alert" style="display:none;background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;color:#991B1B;font-size:.875rem;line-height:1.6;"></div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.75rem;align-items:start;">

{{-- ═══════════════ LEFT COLUMN ═══════════════ --}}
<div style="display:flex;flex-direction:column;gap:1.5rem;">

  {{-- Informasi Layanan --}}
  <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
    <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.5rem;">
      <div style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
        <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
      </div>
      <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Informasi Layanan</h3>
    </div>
    <div style="display:flex;flex-direction:column;gap:1.125rem;">
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Nama Layanan <span style="color:#EF4444;">*</span></label>
        <input type="text" name="name" id="svc-name" value="{{ old('name',$s?->name) }}" required oninput="svcAutoSlug()"
          style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;transition:border-color .2s;"
          onfocus="this.style.borderColor='#3B82F6';this.style.background='#fff'" onblur="this.style.borderColor='#E4E7F0';this.style.background='#F8FAFC'"
          placeholder="Contoh: Alat Rumah CV-60">
      </div>
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">
          Slug (URL) <span style="font-weight:500;color:#94A3B8;font-size:.75rem;">— Kosongkan untuk otomatis</span>
        </label>
        <div style="display:flex;align-items:center;gap:0;border:1.5px solid #E4E7F0;border-radius:10px;overflow:hidden;background:#F8FAFC;transition:border-color .2s;" id="slug-wrapper">
          <span style="padding:.75rem .875rem;font-size:.8rem;color:#94A3B8;background:#F1F5F9;border-right:1px solid #E4E7F0;white-space:nowrap;">/services/</span>
          <input type="text" name="slug" id="svc-slug" value="{{ old('slug',$s?->slug) }}" pattern="[a-z0-9\-]*"
            style="flex:1;padding:.75rem .875rem;background:transparent;border:none;font-size:.9rem;color:#1E293B;font-family:inherit;outline:none;"
            onfocus="document.getElementById('slug-wrapper').style.borderColor='#3B82F6'" onblur="document.getElementById('slug-wrapper').style.borderColor='#E4E7F0'"
            placeholder="contoh-slug-url">
        </div>
      </div>
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Deskripsi Singkat <span style="font-weight:500;color:#94A3B8;font-size:.75rem;">max 500 karakter</span></label>
        <textarea name="short_desc" rows="3" maxlength="500"
          style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;font-family:inherit;outline:none;resize:vertical;box-sizing:border-box;transition:border-color .2s;"
          onfocus="this.style.borderColor='#3B82F6';this.style.background='#fff'" onblur="this.style.borderColor='#E4E7F0';this.style.background='#F8FAFC'"
          placeholder="Deskripsi singkat tampil di halaman listing...">{{ old('short_desc',$s?->short_desc) }}</textarea>
      </div>
    </div>
  </div>

  {{-- Rich Text Editor --}}
  <div style="background:#fff;border-radius:20px;box-shadow:0 2px 20px rgba(0,0,0,0.04);overflow:hidden;">
    <div style="padding:1.25rem 1.75rem;border-bottom:1px solid #F1F5F9;display:flex;align-items:center;gap:.625rem;">
      <div style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
        <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      </div>
      <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Deskripsi Lengkap</h3>
    </div>
    <div style="padding:1.25rem 1.75rem;">
      @include('admin.partials.rich-editor', ['name'=>'description','value'=>old('description',$s?->description??''),'height'=>'320px'])
    </div>
  </div>

  {{-- Spesifikasi Produk --}}
  <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04); margin-bottom:1.5rem;">
    <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.5rem;">
      <div style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
        <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
      </div>
      <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Data E-Commerce / Harga</h3>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.125rem;">
      <div style="grid-column: span 2;">
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Kategori</label>
        <select name="product_category_id" required style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
          <option value="">- Tanpa Kategori -</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('product_category_id', $s?->product_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Harga (Rp)</label>
        <input type="number" name="price" value="{{ old('price',$s?->price) }}" min="0" placeholder="0"
          style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
        <p style="font-size:.7rem;color:#94A3B8;margin-top:.25rem;">Kosongkan/0 jika ini layanan jasa (Tanya via WA)</p>
      </div>
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Harga Diskon (Rp)</label>
        <input type="number" name="sale_price" value="{{ old('sale_price',$s?->sale_price) }}" min="0" placeholder="Opsional"
          style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
      </div>
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Stok <span style="color:#EF4444;">*</span></label>
        <input type="number" name="stock" value="{{ old('stock',$s?->stock ?? 0) }}" min="0" required
          style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
      </div>
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Minimum Order</label>
        <input type="number" name="min_order" value="{{ old('min_order',$s?->min_order ?? 1) }}" min="1"
          style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
      </div>
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Berat (Gram)</label>
        <input type="number" name="weight" value="{{ old('weight',$s?->weight ?? 0) }}" min="0"
          style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
      </div>
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Rating Bintang <span style="color:#EF4444;">*</span></label>
        <input type="number" step="0.1" name="rating" value="{{ old('rating', $s?->rating ?? 0) }}" min="0" max="5" placeholder="Cth: 4.8" required
          style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
      </div>
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Jumlah Terjual <span style="color:#EF4444;">*</span></label>
        <input type="number" name="sold_count" value="{{ old('sold_count', $s?->sold_count ?? 0) }}" min="0" placeholder="Cth: 1200" required
          style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
      </div>
      <div style="grid-column:1 / -1;">
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">SKU (Opsional)</label>
        <input type="text" name="sku" value="{{ old('sku',$s?->sku) }}" placeholder="Contoh: SKU-001"
          style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
      </div>
    </div>
  </div>

  {{-- Spesifikasi Produk --}}
  <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
      <div style="display:flex;align-items:center;gap:.625rem;">
        <div style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
          <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        </div>
        <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Spesifikasi Produk</h3>
      </div>
      <button type="button" onclick="addSpec()" style="display:inline-flex;align-items:center;gap:.375rem;font-size:.78rem;font-weight:700;color:#3B82F6;background:rgba(59,130,246,0.08);border:none;border-radius:8px;padding:.4rem .875rem;cursor:pointer;transition:background .2s;" onmouseover="this.style.background='rgba(59,130,246,0.15)'" onmouseout="this.style.background='rgba(59,130,246,0.08)'">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Baris
      </button>
    </div>
    <div id="specs-container" style="display:flex;flex-direction:column;gap:.625rem;">
      @php $specs = old('spec_keys', []); $specVals = old('spec_values', []); @endphp
      @foreach($specs as $idx => $k)
      <div class="spec-row" style="display:flex;gap:.625rem;align-items:center;">
        <input type="text" name="spec_keys[]" value="{{ $k }}" placeholder="Label (misal: Dimensi)" style="flex:1;padding:.625rem .875rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
        <input type="text" name="spec_values[]" value="{{ $specVals[$idx] ?? '' }}" placeholder="Nilai (misal: 24 inch)" style="flex:2;padding:.625rem .875rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
        <button type="button" onclick="this.parentElement.remove()" style="flex-shrink:0;width:32px;height:32px;background:rgba(239,68,68,0.08);border:none;border-radius:8px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;" onmouseover="this.style.background='rgba(239,68,68,0.16)'" onmouseout="this.style.background='rgba(239,68,68,0.08)'">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
      @endforeach
      @if(count($specs) === 0)
      <div id="specs-empty" style="text-align:center;padding:2rem;color:#94A3B8;font-size:.875rem;border:2px dashed #E4E7F0;border-radius:10px;">
        Belum ada spesifikasi. Klik "Tambah Baris" untuk mulai.
      </div>
      @endif
    </div>
  </div>

  {{-- FAQ --}}
  <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
      <div style="display:flex;align-items:center;gap:.625rem;">
        <div style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
          <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Tanya Jawab (FAQ)</h3>
      </div>
      <button type="button" onclick="addFaq()" style="display:inline-flex;align-items:center;gap:.375rem;font-size:.78rem;font-weight:700;color:#3B82F6;background:rgba(59,130,246,0.08);border:none;border-radius:8px;padding:.4rem .875rem;cursor:pointer;transition:background .2s;" onmouseover="this.style.background='rgba(59,130,246,0.15)'" onmouseout="this.style.background='rgba(59,130,246,0.08)'">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah FAQ
      </button>
    </div>
    <div id="faq-container" style="display:flex;flex-direction:column;gap:.875rem;">
      @php $faqs = old('faq_qs', []); $faqAs = old('faq_as', []); @endphp
      @foreach($faqs as $idx => $q)
      <div class="faq-row" style="display:flex;flex-direction:column;gap:.5rem;padding:1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:12px;position:relative;">
        <button type="button" onclick="this.parentElement.remove()" style="position:absolute;top:.625rem;right:.625rem;width:24px;height:24px;background:rgba(239,68,68,0.08);border:none;border-radius:6px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;" onmouseover="this.style.background='rgba(239,68,68,0.16)'" onmouseout="this.style.background='rgba(239,68,68,0.08)'">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <input type="text" name="faq_qs[]" value="{{ $q }}" placeholder="Pertanyaan?" style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;padding-right:2.5rem;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
        <textarea name="faq_as[]" rows="2" placeholder="Jawaban lengkap..." style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;resize:vertical;box-sizing:border-box;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">{{ $faqAs[$idx] ?? '' }}</textarea>
      </div>
      @endforeach
    </div>
  </div>

  @include('admin.partials.seo-fields', ['item'=>$s])

</div>

{{-- ═══════════════ RIGHT COLUMN ═══════════════ --}}
<div style="display:flex;flex-direction:column;gap:1.5rem;position:sticky;top:1.5rem;">

  {{-- Tombol Simpan --}}
  <div style="background:#fff;border-radius:20px;padding:1.25rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
    <button type="submit" style="width:100%;display:flex;align-items:center;justify-content:center;gap:.5rem;background:#3B82F6;color:#fff;font-size:.9rem;font-weight:700;padding:.875rem 1.5rem;border-radius:12px;border:none;cursor:pointer;transition:all .2s;box-shadow:0 4px 14px rgba(59,130,246,0.3);" onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 20px rgba(59,130,246,0.4)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 14px rgba(59,130,246,0.3)'">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
      {{ $s ? 'Update Layanan' : 'Simpan Layanan' }}
    </button>
    <a href="{{ route('admin.services.index') }}" style="display:flex;align-items:center;justify-content:center;margin-top:.625rem;font-size:.85rem;font-weight:600;color:#64748B;text-decoration:none;padding:.625rem;border-radius:10px;transition:background .2s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">Batal</a>
  </div>

  {{-- Status & Urutan --}}
  <div style="background:#fff;border-radius:20px;padding:1.5rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
    <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.25rem;">
      <div style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
        <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Status Publikasi</h3>
    </div>
    <div style="display:flex;flex-direction:column;gap:1rem;">
      {{-- Toggle aktif --}}
      <label style="display:flex;align-items:center;justify-content:space-between;cursor:pointer;padding:.875rem 1rem;background:#F8FAFC;border-radius:12px;border:1.5px solid #E4E7F0;">
        <div>
          <div style="font-size:.875rem;font-weight:700;color:#1E293B;">Aktif</div>
          <div style="font-size:.75rem;color:#94A3B8;margin-top:.1rem;">Tampil di website publik</div>
        </div>
        <div style="position:relative;">
          <input type="hidden" name="is_active" value="0">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active',$s?->is_active??true)?'checked':'' }} id="is_active_toggle" style="sr-only;position:absolute;opacity:0;width:0;height:0;" onchange="updateToggle(this)">
          <div id="toggle-track" onclick="document.getElementById('is_active_toggle').click()" style="width:44px;height:24px;border-radius:100px;cursor:pointer;transition:background .2s;position:relative;background:{{ old('is_active',$s?->is_active??true)?'#3B82F6':'#E4E7F0' }};">
            <div id="toggle-thumb" style="position:absolute;top:3px;left:{{ old('is_active',$s?->is_active??true)?'23px':'3px' }};width:18px;height:18px;background:#fff;border-radius:50%;transition:left .2s;box-shadow:0 1px 4px rgba(0,0,0,0.15);"></div>
          </div>
        </div>
      </label>
      <div>
        <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Icon (opsional)</label>
        <input type="text" name="icon" value="{{ old('icon',$s?->icon) }}" placeholder="crane, hoist, lift..."
          style="width:100%;padding:.625rem .875rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;" onfocus="this.style.borderColor='#3B82F6';this.style.background='#fff'" onblur="this.style.borderColor='#E4E7F0';this.style.background='#F8FAFC'">
        <p style="font-size:.72rem;color:#94A3B8;margin:.375rem 0 0;">Nama ikon atau SVG path identifier</p>
      </div>
    </div>
  </div>

  {{-- Foto Utama --}}
  @include('admin.partials.image-upload', ['item'=>$s,'field'=>'image','label'=>'Foto Utama Layanan','aspectRatio'=>'1:1'])

  {{-- OG Image --}}
  @include('admin.partials.image-upload', ['item'=>$s,'field'=>'og_image','label'=>'OG Image (Share Preview)'])

  {{-- Brosur --}}
  <div style="background:#fff;border-radius:20px;padding:1.5rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
    <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.25rem;">
      <div style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
        <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      </div>
      <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">File Brosur</h3>
    </div>
    <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Upload Brosur/Datasheet</label>
    <label style="display:flex;flex-direction:column;align-items:center;gap:.5rem;padding:1.25rem;border:2px dashed #E4E7F0;border-radius:12px;cursor:pointer;transition:all .2s;text-align:center;" onmouseover="this.style.borderColor='#3B82F6';this.style.background='#F8FAFF'" onmouseout="this.style.borderColor='#E4E7F0';this.style.background='transparent'">
      <svg width="24" height="24" fill="none" stroke="#94A3B8" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
      <span style="font-size:.8rem;color:#64748B;font-weight:600;">Klik untuk upload</span>
      <span style="font-size:.72rem;color:#94A3B8;">PDF, JPG, PNG — Maks 10MB</span>
      <input type="file" name="brochure" accept=".pdf,image/*" style="display:none;">
    </label>
  </div>

  {{-- Gallery --}}
  <div style="background:#fff;border-radius:20px;padding:1.5rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.125rem;">
      <div style="display:flex;align-items:center;gap:.625rem;">
        <div style="width:28px;height:28px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
          <svg width="14" height="14" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
        <h3 style="font-size:.8rem;font-weight:800;color:#1E293B;margin:0;">Foto Gallery</h3>
      </div>
      <span id="gallery-count-badge" style="display:none;font-size:.7rem;font-weight:700;color:#3B82F6;background:rgba(59,130,246,0.1);padding:.2rem .6rem;border-radius:20px;"></span>
    </div>

    {{-- Container hidden file inputs --}}
    <div id="gallery-file-inputs"></div>

    {{-- New gallery file previews --}}
    <div id="gallery-new-previews" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(85px, 1fr));gap:.625rem;margin-bottom:.75rem;"></div>

    {{-- Upload Actions --}}
    <div style="display:flex;flex-direction:column;gap:.5rem;">
      <button type="button" onclick="addGalleryFileSlot(true)" style="width:100%;padding:.75rem 1rem;background:#F0F9FF;color:#0284C7;border:1.5px dashed #0284C7;border-radius:12px;font-size:.8rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:all .2s;" onmouseover="this.style.background='#E0F2FE'" onmouseout="this.style.background='#F0F9FF'">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        + Tambah Foto Gallery (1 Per 1)
      </button>

      <button type="button" onclick="addGalleryFileSlot(false)" style="width:100%;padding:.5rem 1rem;background:#F8FAFC;color:#64748B;border:1px solid #E2E8F0;border-radius:10px;font-size:.75rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.4rem;transition:all .2s;" onmouseover="this.style.background='#F1F5F9';this.style.color='#1E293B'" onmouseout="this.style.background='#F8FAFC';this.style.color='#64748B'">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        Atau Pilih Banyak Foto Sekaligus
      </button>
    </div>
    <p style="font-size:.68rem;color:#94A3B8;margin:.5rem 0 0;text-align:center;">Foto yang ditambah 1 per 1 akan otomatis tersimpan &amp; terakumulasi.</p>
  </div>

  {{-- ═══ VARIAN PRODUK (SHOPEE-STYLE) ═══ --}}
  <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);" id="variants-section">

    <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.25rem;">
      <div style="width:32px;height:32px;background:rgba(139,92,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="16" height="16" fill="none" stroke="#8B5CF6" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3h-8l-2 4h12l-2-4z"/></svg>
      </div>
      <div>
        <h3 style="font-size:.9rem;font-weight:800;color:#1E293B;margin:0;line-height:1.2;">Varian Produk <span style="font-size:.75rem;font-weight:500;color:#94A3B8;">(Opsional)</span></h3>
        <p style="font-size:.72rem;color:#94A3B8;margin:.1rem 0 0;">Maks. 2 variasi. Setiap kombinasi punya harga & stok tersendiri.</p>
      </div>
    </div>

    {{-- Variant Groups --}}
    <div id="vg-list" style="display:flex;flex-direction:column;gap:.75rem;margin-bottom:1rem;"></div>

    {{-- Add variant group button (max 2) --}}
    <button type="button" id="btn-add-vg" onclick="addVarGroup()"
      style="display:inline-flex;align-items:center;gap:.35rem;background:#F8FAFC;color:#7C3AED;border:1.5px dashed rgba(139,92,246,0.45);padding:.5rem 1.1rem;border-radius:10px;font-size:.8rem;font-weight:700;cursor:pointer;transition:all .2s;"
      onmouseover="this.style.background='rgba(139,92,246,0.06)'" onmouseout="this.style.background='#F8FAFC'">
      <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      + Tambah Variasi
    </button>

    {{-- Combination Matrix Table --}}
    <div id="combo-section" style="display:none;margin-top:1.5rem;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;flex-wrap:wrap;gap:.5rem;">
        <div style="font-size:.8rem;font-weight:800;color:#1E293B;letter-spacing:.03em;">DAFTAR VARIASI</div>
        <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
          <span style="font-size:.72rem;color:#64748B;">Terapkan ke semua:</span>
          <input type="number" id="bulk-price" placeholder="Harga" min="0" step="1000"
            style="width:110px;padding:.35rem .6rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.78rem;font-family:inherit;outline:none;"
            onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'">
          <input type="number" id="bulk-stock" placeholder="Stok" min="0"
            style="width:80px;padding:.35rem .6rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.78rem;font-family:inherit;outline:none;"
            onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'">
          <button type="button" onclick="applyBulk()"
            style="padding:.35rem .8rem;background:#7C3AED;color:#fff;border:none;border-radius:8px;font-size:.75rem;font-weight:700;cursor:pointer;">
            Terapkan
          </button>
        </div>
      </div>

      <div style="overflow-x:auto;border-radius:12px;border:1.5px solid #E4E7F0;">
        <table style="width:100%;border-collapse:collapse;font-size:.8rem;" id="combo-table">
          <thead>
            <tr style="background:#F8FAFC;">
              <th id="th-v1" style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;"></th>
              <th id="th-v2" style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;display:none;"></th>
              <th style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;">Harga (Rp) *</th>
              <th style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;">Stok *</th>
              <th style="padding:.6rem .75rpm;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:100px;">Kode SKU</th>
            </tr>
          </thead>
          <tbody id="combo-tbody"></tbody>
        </table>
      </div>
    </div>

  </div>

</div>
</div>
</form>

{{-- CONFIRMATION MODAL --}}
<div id="confirmModal" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(15,23,42,0.6);z-index:9999;align-items:center;justify-content:center;opacity:0;transition:opacity 0.2s;">
  <div style="background:#fff;border-radius:20px;padding:2rem;max-width:420px;width:90%;box-shadow:0 25px 60px rgba(0,0,0,0.2);">
    <div style="font-size:1.5rem;margin-bottom:.75rem;">⚠️</div>
    <h3 style="font-size:1rem;font-weight:800;color:#1E293B;margin:0 0 .5rem;">Konfirmasi Simpan</h3>
    <p id="confirmMsg" style="font-size:.875rem;color:#475569;margin:0 0 1.5rem;line-height:1.6;"></p>
    <div style="display:flex;gap:.75rem;justify-content:flex-end;">
      <button onclick="closeConfirm()" style="padding:.6rem 1.25rem;background:#F1F5F9;color:#475569;border:none;border-radius:10px;font-size:.85rem;font-weight:700;cursor:pointer;">Batal</button>
      <button id="confirmOk" style="padding:.6rem 1.25rem;background:#3B82F6;color:#fff;border:none;border-radius:10px;font-size:.85rem;font-weight:700;cursor:pointer;">Simpan</button>
    </div>
  </div>
</div>

<script>
/* ═══════════════════════════════════════════════════════════
   HELPER FUNCTIONS (Slug, Specs, FAQs)
═══════════════════════════════════════════════════════════ */
function generateSlug(v){return v.toLowerCase().replace(/[^a-z0-9\s-]/g,'').trim().replace(/\s+/g,'-').replace(/-+/g,'-');}
function syncSlug(){
  const n=document.getElementById('name_input'), s=document.getElementById('slug_input');
  if(s&&!s.dataset.manual&&n) s.value=generateSlug(n.value);
}
function addSpecRow() {
  const c=document.getElementById('specs-container');
  const d=document.createElement('div');
  d.className='spec-row';d.style.cssText='display:grid;grid-template-columns:1fr 2fr auto;gap:.5rem;align-items:center;';
  d.innerHTML=`<input type="text" name="spec_keys[]" placeholder="Spesifikasi" style="padding:.5rem .75rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.82rem;color:#1E293B;font-family:inherit;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
  <input type="text" name="spec_values[]" placeholder="Nilai" style="padding:.5rem .75rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.82rem;color:#1E293B;font-family:inherit;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
  <button type="button" onclick="this.closest('.spec-row').remove()" style="width:30px;height:30px;background:rgba(239,68,68,0.08);border:none;border-radius:6px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </button>`;
  c.appendChild(d);
}
function addFaqRow(){
  const c=document.getElementById('faqs-container');
  c.insertAdjacentHTML('beforeend',`<div style="background:#F8FAFC;border-radius:10px;padding:.875rem;border:1px solid #E4E7F0;position:relative;">
    <button type="button" onclick="this.closest('div').remove()" style="position:absolute;top:.5rem;right:.5rem;width:26px;height:26px;background:rgba(239,68,68,0.08);border:none;border-radius:6px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;">
      <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div style="margin-bottom:.5rem;"><input type="text" name="faq_qs[]" placeholder="Pertanyaan?" style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;padding-right:2.5rem;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'"></div>
    <textarea name="faq_as[]" rows="2" placeholder="Jawaban lengkap..." style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;resize:vertical;box-sizing:border-box;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'"></textarea>
  </div>`);
}

/* ═══════════════════════════════════════════════════════════
   GALLERY HELPERS
═══════════════════════════════════════════════════════════ */
function addGalleryFileSlot(single){
  const c=document.getElementById('new-gallery-slots');
  const input=document.createElement('input');
  input.type='file';input.name='gallery_images[]';input.accept='image/*';
  if(!single)input.multiple=true;
  input.style.cssText='display:block;width:100%;font-size:.78rem;color:#475569;margin-bottom:.35rem;';
  const wrap=document.createElement('div');
  wrap.style.cssText='display:flex;align-items:center;gap:.5rem;';
  const btn=document.createElement('button');
  btn.type='button';btn.textContent='×';
  btn.style.cssText='background:rgba(239,68,68,0.1);border:none;border-radius:6px;color:#EF4444;width:24px;height:24px;cursor:pointer;font-size:1rem;line-height:1;flex-shrink:0;';
  btn.onclick=function(){wrap.remove();};
  wrap.appendChild(input);wrap.appendChild(btn);
  c.appendChild(wrap);
}

/* ═══════════════════════════════════════════════════════════
   CONFIRM MODAL
═══════════════════════════════════════════════════════════ */
let confirmCallback=null;
function showConfirm(msg,cb){
  document.getElementById('confirmMsg').textContent=msg;
  confirmCallback=cb;
  const m=document.getElementById('confirmModal');
  m.style.display='flex';
  requestAnimationFrame(()=>m.style.opacity='1');
}
function closeConfirm(){
  const m=document.getElementById('confirmModal');
  m.style.opacity='0';
  setTimeout(()=>m.style.display='none',200);
}
document.getElementById('confirmOk').onclick=function(){closeConfirm();if(confirmCallback)confirmCallback();};

function submitProductForm(action){
  const form=document.getElementById('product-form');
  if(!form)return;
  let hi=form.querySelector('input[name="submit_action"]');
  if(!hi){hi=document.createElement('input');hi.type='hidden';hi.name='submit_action';form.appendChild(hi);}
  hi.value=action;
  const activeInputs=form.querySelectorAll('input[required]:not([disabled]),textarea[required]:not([disabled]),select[required]:not([disabled])');
  let missing=[];
  activeInputs.forEach(inp=>{if(!inp.value.trim())missing.push(inp.placeholder||inp.name);});
  if(missing.length){
    showConfirm('Beberapa field wajib belum diisi:\n- '+missing.slice(0,3).join('\n- ')+(missing.length>3?'\n... dan '+(missing.length-3)+' lainnya':''),()=>form.submit());
    return;
  }
  form.submit();
}

/* ═══════════════════════════════════════════════════════════
   VARIAN SHOPEE-STYLE
═══════════════════════════════════════════════════════════ */
// State: max 2 variant groups
// Each group: { gid, name, values:[{vid, label, existingId?}] }
const VGS = []; // max 2 elements
let _gidCounter = 0;
let _vidCounter = 0;

function addVarGroup() {
  if (VGS.length >= 2) { alert('Maksimal 2 variasi.'); return; }
  const gid = ++_gidCounter;
  const idx  = VGS.length;
  VGS.push({ gid, name: '', values: [], existingId: null });
  renderAllGroups();
  renderMatrix();
}

function removeVarGroup(gid) {
  const idx = VGS.findIndex(g => g.gid === gid);
  if (idx === -1) return;
  VGS.splice(idx, 1);
  renderAllGroups();
  renderMatrix();
}

function onGroupNameChange(gid, val) {
  const g = VGS.find(g => g.gid === gid);
  if (g) { g.name = val; renderMatrix(); }
}

function addTagValue(gid) {
  const g = VGS.find(g => g.gid === gid);
  if (!g) return;
  const inp = document.getElementById('tag-inp-' + gid);
  const raw = (inp ? inp.value : '').trim();
  if (!raw) return;
  // Split by comma for bulk entry
  const labels = raw.split(',').map(s => s.trim()).filter(Boolean);
  labels.forEach(label => {
    if (!g.values.find(v => v.label.toLowerCase() === label.toLowerCase())) {
      g.values.push({ vid: ++_vidCounter, label, existingId: null });
    }
  });
  if (inp) inp.value = '';
  renderAllGroups();
  renderMatrix();
}

function removeTagValue(gid, vid) {
  const g = VGS.find(g => g.gid === gid);
  if (!g) return;
  g.values = g.values.filter(v => v.vid !== vid);
  renderAllGroups();
  renderMatrix();
}

function renderAllGroups() {
  const list = document.getElementById('vg-list');
  list.innerHTML = '';
  VGS.forEach((g, idx) => {
    const div = document.createElement('div');
    div.style.cssText = 'border:1.5px solid #E4E7F0;border-radius:14px;padding:1rem 1.125rem;background:#FAFBFF;';
    div.innerHTML = groupHTML(g, idx);
    list.appendChild(div);
    // Re-bind tag input enter key
    const inp = div.querySelector('#tag-inp-' + g.gid);
    if (inp) {
      inp.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); addTagValue(g.gid); } });
    }
  });
  // Show/hide add button
  document.getElementById('btn-add-vg').style.display = VGS.length >= 2 ? 'none' : '';
}

function groupHTML(g, idx) {
  const groupLabel = idx === 0 ? 'Variasi 1' : 'Variasi 2';
  const placeholders = idx === 0
    ? ['Warna, Tipe, Ukuran...', 'Merah, Biru, Hitam — pisah koma atau Enter']
    : ['Model, Kapasitas...', 'S, M, L, XL — pisah koma atau Enter'];

  const tagsHTML = g.values.map(v => `
    <span style="display:inline-flex;align-items:center;gap:.3rem;background:#EDE9FE;color:#6D28D9;padding:.25rem .6rem;border-radius:20px;font-size:.75rem;font-weight:600;cursor:default;">
      ${escHtml(v.label)}
      <button type="button" onclick="removeTagValue(${g.gid},${v.vid})"
        style="background:none;border:none;color:#7C3AED;cursor:pointer;padding:0;line-height:1;font-size:.9rem;display:flex;align-items:center;">&times;</button>
    </span>`).join('');

  // Hidden inputs for form submission (values)
  const hiddenInputs = g.values.map(v => `
    <input type="hidden" name="variant_options[g${g.gid}][values][]" value="${escHtml(v.label)}">
    ${v.existingId ? `<input type="hidden" name="variant_options[g${g.gid}][existing_values][${v.vid}][existing_id]" value="${v.existingId}">` : ''}
  `).join('');

  return `
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;">
      <span style="font-size:.72rem;font-weight:800;color:#7C3AED;letter-spacing:.06em;text-transform:uppercase;">${groupLabel}</span>
      <button type="button" onclick="removeVarGroup(${g.gid})"
        style="width:26px;height:26px;background:rgba(239,68,68,0.08);border:none;border-radius:6px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div style="margin-bottom:.75rem;">
      <label style="font-size:.72rem;font-weight:700;color:#64748B;display:block;margin-bottom:.35rem;">Nama Variasi *</label>
      <input type="text" name="variant_options[g${g.gid}][name]"
        ${g.existingId ? `data-existing="${g.existingId}"` : ''}
        placeholder="${placeholders[0]}" value="${escHtml(g.name)}"
        oninput="onGroupNameChange(${g.gid}, this.value)"
        style="width:100%;padding:.5rem .75rem;border:1.5px solid #E4E7F0;border-radius:9px;font-size:.85rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;"
        onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'">
    </div>
    <div style="margin-bottom:.6rem;">
      <label style="font-size:.72rem;font-weight:700;color:#64748B;display:block;margin-bottom:.35rem;">Opsi Nilai *</label>
      <div style="display:flex;gap:.4rem;align-items:center;">
        <input id="tag-inp-${g.gid}" type="text" placeholder="${placeholders[1]}"
          style="flex:1;padding:.5rem .75rem;border:1.5px solid #E4E7F0;border-radius:9px;font-size:.82rem;color:#1E293B;font-family:inherit;outline:none;"
          onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'">
        <button type="button" onclick="addTagValue(${g.gid})"
          style="padding:.5rem .85rem;background:#7C3AED;color:#fff;border:none;border-radius:9px;font-size:.78rem;font-weight:700;cursor:pointer;white-space:nowrap;">
          + Tambah
        </button>
      </div>
    </div>
    <div id="tags-${g.gid}" style="display:flex;flex-wrap:wrap;gap:.35rem;min-height:20px;">
      ${tagsHTML}
    </div>
    ${hiddenInputs}
    ${g.existingId ? `<input type="hidden" name="variant_options[g${g.gid}][existing_id]" value="${g.existingId}">` : ''}
  `;
}

function escHtml(str) {
  return String(str||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* ── Matrix Table ── */
function renderMatrix() {
  const sec   = document.getElementById('combo-section');
  const tbody = document.getElementById('combo-tbody');
  const thV1  = document.getElementById('th-v1');
  const thV2  = document.getElementById('th-v2');

  const g1 = VGS[0];
  const g2 = VGS[1] || null;

  // Only show if at least 1 group with values
  const hasData = g1 && g1.values.length > 0;
  sec.style.display = hasData ? '' : 'none';
  if (!hasData) return;

  thV1.textContent = g1.name || 'Variasi 1';
  if (g2 && g2.values.length > 0) {
    thV2.style.display = '';
    thV2.textContent = g2.name || 'Variasi 2';
  } else {
    thV2.style.display = 'none';
  }

  // Build rows: g1.values × (g2.values or [null])
  const v2list = (g2 && g2.values.length > 0) ? g2.values : [null];
  let rowIndex = 0;
  let html = '';

  g1.values.forEach(v1 => {
    v2list.forEach(v2 => {
      // Try to find existing combo data
      const savedKey = `${v1.vid}_${v2 ? v2.vid : 'x'}`;
      const saved = window._savedCombos && window._savedCombos[savedKey];
      const price = saved ? saved.price : '';
      const stock = saved ? saved.stock : '';
      const sku   = saved ? saved.sku : '';
      const combId = saved ? saved.id : '';

      const isEven = rowIndex % 2 === 0;
      html += `<tr style="background:${isEven ? '#fff' : '#FAFBFF'};" data-row="${rowIndex}">
        <td style="padding:.55rem .75rem;color:#1E293B;font-weight:600;font-size:.8rem;white-space:nowrap;border-bottom:1px solid #F1F5F9;">
          <span style="display:inline-block;background:#EDE9FE;color:#6D28D9;padding:.2rem .55rem;border-radius:20px;font-size:.73rem;">${escHtml(v1.label)}</span>
        </td>
        ${v2 ? `<td style="padding:.55rem .75rem;color:#1E293B;font-weight:600;font-size:.8rem;white-space:nowrap;border-bottom:1px solid #F1F5F9;">
          <span style="display:inline-block;background:#E0F2FE;color:#0369A1;padding:.2rem .55rem;border-radius:20px;font-size:.73rem;">${escHtml(v2.label)}</span>
        </td>` : ''}
        <td style="padding:.4rem .75rem;border-bottom:1px solid #F1F5F9;">
          <input type="number" name="variant_options[combinations][${rowIndex}][price]"
            value="${escHtml(price)}" placeholder="0" min="0" step="500"
            style="width:100%;min-width:110px;padding:.4rem .6rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.8rem;font-family:inherit;outline:none;"
            onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'" required>
        </td>
        <td style="padding:.4rem .75rem;border-bottom:1px solid #F1F5F9;">
          <input type="number" name="variant_options[combinations][${rowIndex}][stock]"
            value="${escHtml(stock)}" placeholder="0" min="0"
            style="width:100%;min-width:75px;padding:.4rem .6rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.8rem;font-family:inherit;outline:none;"
            onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'" required>
        </td>
        <td style="padding:.4rem .75rem;border-bottom:1px solid #F1F5F9;">
          <input type="text" name="variant_options[combinations][${rowIndex}][sku]"
            value="${escHtml(sku)}" placeholder="Opsional"
            style="width:100%;min-width:90px;padding:.4rem .6rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.8rem;font-family:inherit;outline:none;"
            onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'">
        </td>
        <input type="hidden" name="variant_options[combinations][${rowIndex}][option1_value_id]" value="${escHtml(v1.vid)}">
        <input type="hidden" name="variant_options[combinations][${rowIndex}][option1_label]" value="${escHtml(v1.label)}">
        ${v2 ? `<input type="hidden" name="variant_options[combinations][${rowIndex}][option2_value_id]" value="${escHtml(v2.vid)}">
        <input type="hidden" name="variant_options[combinations][${rowIndex}][option2_label]" value="${escHtml(v2.label)}">` : ''}
        ${combId ? `<input type="hidden" name="variant_options[combinations][${rowIndex}][existing_combo_id]" value="${combId}">` : ''}
      </tr>`;
      rowIndex++;
    });
  });

  tbody.innerHTML = html;
}

function applyBulk() {
  const price = document.getElementById('bulk-price').value;
  const stock = document.getElementById('bulk-stock').value;
  const tbody = document.getElementById('combo-tbody');
  if (price) tbody.querySelectorAll('input[name*="[price]"]').forEach(i => i.value = price);
  if (stock) tbody.querySelectorAll('input[name*="[stock]"]').forEach(i => i.value = stock);
}

/* Saved combos for pre-fill on edit page */
window._savedCombos = {};
</script>
@endsection
        renderGalleryPreviews();
    };

    container.appendChild(newInput);
    newInput.click();
}

function renderGalleryPreviews() {
    var previewsContainer = document.getElementById('gallery-new-previews');
    previewsContainer.innerHTML = '';

    var inputsContainer = document.getElementById('gallery-file-inputs');
    var inputs = inputsContainer.querySelectorAll('input[type="file"]');
    var totalFiles = 0;

    inputs.forEach(function(input) {
        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach(function(file, fileIdx) {
                totalFiles++;
                var url = URL.createObjectURL(file);
                var div = document.createElement('div');
                div.style.cssText = 'position:relative;border-radius:10px;overflow:hidden;border:1.5px solid #3B82F6;aspect-ratio:1/1;background:#F8FAFC;box-shadow:0 2px 8px rgba(0,0,0,0.06);';
                div.innerHTML = '<img src="' + url + '" style="width:100%;height:100%;object-fit:cover;display:block;">'
                    + '<button type="button" onclick="removeSingleGalleryFile(\'' + input.id + '\', ' + fileIdx + ')" title="Hapus foto ini" style="position:absolute;top:4px;right:4px;width:22px;height:22px;background:rgba(239,68,68,0.95);border:none;border-radius:6px;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 4px rgba(0,0,0,0.3);padding:0;">'
                    + '<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
                    + '</button>'
                    + '<div style="position:absolute;bottom:0;left:0;right:0;background:rgba(15,23,42,0.75);padding:.2rem .3rem;font-size:.65rem;color:#fff;font-weight:700;text-align:center;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Foto #' + totalFiles + '</div>';
                previewsContainer.appendChild(div);
            });
        }
    });

    var counterBadge = document.getElementById('gallery-count-badge');
    if (counterBadge) {
        if (totalFiles > 0) {
            counterBadge.style.display = 'inline-block';
            counterBadge.innerText = totalFiles + ' foto baru siap';
        } else {
            counterBadge.style.display = 'none';
        }
    }
}

function removeSingleGalleryFile(inputId, fileIndex) {
    var input = document.getElementById(inputId);
    if (!input) return;

    if (input.files.length === 1) {
        input.remove();
    } else {
        try {
            var dt = new DataTransfer();
            Array.from(input.files).forEach(function(file, idx) {
                if (idx !== fileIndex) dt.items.add(file);
            });
            input.files = dt.files;
        } catch(e) {
            input.remove();
        }
        if (input.files.length === 0) {
            input.remove();
        }
    }
    renderGalleryPreviews();
}


var svcSlugManual = {{ $s ? 'true' : 'false' }};
document.getElementById('svc-slug').addEventListener('input',()=>svcSlugManual=true);
function svcAutoSlug() {
  if(svcSlugManual) return;
  document.getElementById('svc-slug').value = document.getElementById('svc-name').value.toLowerCase().replace(/[^a-z0-9\s\-]/g,'').trim().replace(/\s+/g,'-');
}

let isConfirmed = false;
document.getElementById('svc-form').addEventListener('submit', function(e) {
  if(isConfirmed) return true;

  // Sync hidden textareas
  document.querySelectorAll('textarea[style*="display:none"]').forEach(t => t.style.display='block');

  // ── Double-check validasi ──
  const errors = [];
  const name = document.getElementById('svc-name').value.trim();
  if (!name) errors.push('❌  Nama Layanan wajib diisi.');

  const category = document.querySelector('select[name="product_category_id"]').value;
  if (!category) errors.push('❌  Kategori wajib dipilih.');

  const desc = document.querySelector('textarea[name="description"]');
  if (desc && desc.value.trim().length < 20) errors.push('❌  Deskripsi Lengkap minimal 20 karakter.');

  const stock = document.querySelector('input[name="stock"]');
  if (!stock || stock.value === '') errors.push('❌  Stok wajib diisi.');

  const rating = document.querySelector('input[name="rating"]');
  if (!rating || rating.value === '') errors.push('❌  Rating Bintang wajib diisi.');

  const soldCount = document.querySelector('input[name="sold_count"]');
  if (!soldCount || soldCount.value === '') errors.push('❌  Jumlah Terjual wajib diisi.');

  const specKeys = document.querySelectorAll('input[name="spec_keys[]"]');
  const specValues = document.querySelectorAll('input[name="spec_values[]"]');
  if (specKeys.length === 0) {
    errors.push('❌  Spesifikasi Produk minimal harus ada 1 baris.');
  } else {
    let specValid = false;
    for (let i = 0; i < specKeys.length; i++) {
      if (specKeys[i].value.trim() !== '' && specValues[i].value.trim() !== '') { specValid = true; break; }
    }
    if (!specValid) errors.push('❌  Spesifikasi Produk wajib diisi (Label & Nilai minimal 1 baris).');
  }

  const faqQs = document.querySelectorAll('input[name="faq_qs[]"]');
  const faqAs = document.querySelectorAll('textarea[name="faq_as[]"]');
  if (faqQs.length === 0) {
    errors.push('❌  Tanya Jawab (FAQ) minimal harus ada 1 baris.');
  } else {
    let faqValid = false;
    for (let i = 0; i < faqQs.length; i++) {
      if (faqQs[i].value.trim() !== '' && faqAs[i].value.trim() !== '') { faqValid = true; break; }
    }
    if (!faqValid) errors.push('❌  Tanya Jawab (FAQ) wajib diisi (Pertanyaan & Jawaban minimal 1 baris).');
  }

  const metaTitle = document.querySelector('input[name="meta_title"]');
  if (!metaTitle || metaTitle.value.trim() === '') errors.push('❌  Meta Title (SEO Settings) wajib diisi.');

  const metaDesc = document.querySelector('textarea[name="meta_desc"]');
  if (!metaDesc || metaDesc.value.trim() === '') errors.push('❌  Meta Description (SEO Settings) wajib diisi.');

  const metaKeywords = document.querySelector('input[name="meta_keywords"]');
  if (!metaKeywords || metaKeywords.value.trim() === '') errors.push('❌  Meta Keywords (SEO Settings) wajib diisi.');

  if (errors.length > 0) {
    e.preventDefault();
    const box = document.getElementById('validation-alert');
    box.innerHTML = '<strong>Mohon perbaiki sebelum menyimpan:</strong><ul style="margin:.5rem 0 0;padding-left:1.25rem;">' +
      errors.map(err => `<li style="margin-bottom:.25rem;">${err}</li>`).join('') + '</ul>';
    box.style.display = 'block';
    box.scrollIntoView({ behavior: 'smooth', block: 'start' });
    return false;
  }

  e.preventDefault();
  const modal = document.getElementById('confirmModal');
  const box = document.getElementById('confirmModalBox');
  modal.style.display = 'flex';
  setTimeout(() => {
    modal.style.opacity = '1';
    box.style.transform = 'scale(1)';
  }, 10);
});

function closeConfirmModal() {
  const modal = document.getElementById('confirmModal');
  const box = document.getElementById('confirmModalBox');
  modal.style.opacity = '0';
  box.style.transform = 'scale(0.95)';
  setTimeout(() => { modal.style.display = 'none'; }, 200);
}

function submitRealForm() {
  isConfirmed = true;
  document.getElementById('svc-form').submit();
}

function updateToggle(chk) {
  const track = document.getElementById('toggle-track');
  const thumb = document.getElementById('toggle-thumb');
  track.style.background = chk.checked ? '#3B82F6' : '#E4E7F0';
  thumb.style.left = chk.checked ? '23px' : '3px';
}

function addSpec() {
  const empty = document.getElementById('specs-empty');
  if(empty) empty.remove();
  document.getElementById('specs-container').insertAdjacentHTML('beforeend', `
    <div class="spec-row" style="display:flex;gap:.625rem;align-items:center;">
      <input type="text" name="spec_keys[]" placeholder="Label (misal: Dimensi)" style="flex:1;padding:.625rem .875rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
      <input type="text" name="spec_values[]" placeholder="Nilai (misal: 24 inch)" style="flex:2;padding:.625rem .875rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
      <button type="button" onclick="this.parentElement.remove()" style="flex-shrink:0;width:32px;height:32px;background:rgba(239,68,68,0.08);border:none;border-radius:8px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;" onmouseover="this.style.background='rgba(239,68,68,0.16)'" onmouseout="this.style.background='rgba(239,68,68,0.08)'">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>`);
}

function addFaq() {
  document.getElementById('faq-container').insertAdjacentHTML('beforeend', `
    <div class="faq-row" style="display:flex;flex-direction:column;gap:.5rem;padding:1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:12px;position:relative;">
      <button type="button" onclick="this.parentElement.remove()" style="position:absolute;top:.625rem;right:.625rem;width:24px;height:24px;background:rgba(239,68,68,0.08);border:none;border-radius:6px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
      <input type="text" name="faq_qs[]" placeholder="Pertanyaan?" style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;padding-right:2.5rem;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
      <textarea name="faq_as[]" rows="2" placeholder="Jawaban lengkap..." style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;resize:vertical;box-sizing:border-box;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'"></textarea>
    </div>`);
}

/* ─── Varian Produk ─────────────────────────────────── */
var variantGroupCounter = 0;

function addVariantGroup() {
  const empty = document.getElementById('variant-empty');
  if(empty) empty.style.display = 'none';

  variantGroupCounter++;
  const gid = variantGroupCounter;
  const container = document.getElementById('variant-groups-container');

  const html = `
  <div class="variant-group" id="vg-${gid}" style="border:1.5px solid #E4E7F0;border-radius:14px;padding:1.25rem;margin-bottom:1rem;background:#FAFBFF;">
    <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1rem;">
      <div style="flex:1;">
        <label style="display:block;font-size:.75rem;font-weight:700;color:#475569;margin-bottom:.35rem;">Nama Grup Varian *</label>
        <input type="text" name="variant_options[${gid}][name]" placeholder="Contoh: Ukuran, Merek, Kapasitas, Tipe"
          style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;"
          onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'" required>
      </div>
      <button type="button" onclick="document.getElementById('vg-${gid}').remove(); checkVariantEmpty()" style="flex-shrink:0;margin-top:1.3rem;width:34px;height:34px;background:rgba(239,68,68,0.08);border:none;border-radius:8px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;" title="Hapus grup varian ini">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>

    <div style="font-size:.75rem;font-weight:700;color:#7C3AED;margin-bottom:.5rem;letter-spacing:.03em;">NILAI VARIAN</div>
    <div class="variant-values-${gid}" style="display:flex;flex-direction:column;gap:.5rem;margin-bottom:.75rem;"></div>

    <button type="button" onclick="addVariantValue(${gid})" style="width:100%;padding:.5rem;background:rgba(139,92,246,0.06);color:#7C3AED;border:1.5px dashed rgba(139,92,246,0.4);border-radius:8px;font-size:.78rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.35rem;transition:all .2s;" onmouseover="this.style.background='rgba(139,92,246,0.12)'" onmouseout="this.style.background='rgba(139,92,246,0.06)'">
      <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      + Tambah Nilai
    </button>
  </div>`;

  container.insertAdjacentHTML('beforeend', html);
  addVariantValue(gid);
}

var variantValueCounters = {};
function addVariantValue(gid) {
  variantValueCounters[gid] = (variantValueCounters[gid] || 0) + 1;
  const vid = variantValueCounters[gid];
  const container = document.querySelector('.variant-values-' + gid);

  const html = `
  <div class="variant-value-row" style="display:grid;grid-template-columns:1fr 160px 100px auto;gap:.5rem;align-items:center;">
    <input type="text" name="variant_options[${gid}][values][${vid}][value]" placeholder="Nilai (contoh: CV-45, Bosch, 1 Liter)"
      style="padding:.5rem .75rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.82rem;color:#1E293B;font-family:inherit;outline:none;"
      onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'" required>
    <div style="position:relative;">
      <span style="position:absolute;left:.6rem;top:50%;transform:translateY(-50%);font-size:.75rem;color:#94A3B8;font-weight:600;">Rp</span>
      <input type="number" name="variant_options[${gid}][values][${vid}][price_adjustment]" placeholder="0" value="0" min="-999999999" step="1000"
        style="width:100%;padding:.5rem .5rem .5rem 2.1rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.82rem;color:#1E293B;font-family:inherit;outline:none;"
        onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'"
        title="Selisih harga dari harga dasar. Bisa negatif (diskon) atau positif (tambah).">
    </div>
    <input type="number" name="variant_options[${gid}][values][${vid}][stock]" placeholder="Stok" min="0"
      style="width:100%;padding:.5rem .75rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.82rem;color:#1E293B;font-family:inherit;outline:none;"
      onfocus="this.style.borderColor='#8B5CF6'" onblur="this.style.borderColor='#E4E7F0'"
      title="Stok khusus varian ini. Kosongkan untuk pakai stok produk utama.">
    <button type="button" onclick="this.closest('.variant-value-row').remove()" style="flex-shrink:0;width:30px;height:30px;background:rgba(239,68,68,0.08);border:none;border-radius:6px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;">
      <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  </div>
  <div style="display:grid;grid-template-columns:1fr 160px 100px auto;gap:.5rem;padding:0 0 .25rem;">
    <div style="font-size:.65rem;color:#94A3B8;padding-left:.25rem;">Nama/Label Nilai</div>
    <div style="font-size:.65rem;color:#94A3B8;padding-left:.25rem;">+/- Harga (dari harga dasar)</div>
    <div style="font-size:.65rem;color:#94A3B8;padding-left:.25rem;">Stok (opsional)</div>
    <div></div>
  </div>`;

}
</script>
@endsection
