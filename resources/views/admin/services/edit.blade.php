@extends('layouts.admin')
@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan')
@section('content')
  @php $s = $service; @endphp

  {{-- PAGE HEADER --}}
  <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;">
    <a href="{{ route('admin.services.index') }}"
      style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:#fff;border:1.5px solid #E4E7F0;border-radius:10px;color:#64748B;text-decoration:none;flex-shrink:0;transition:all .2s;"
      onmouseover="this.style.borderColor='#3B82F6';this.style.color='#3B82F6'"
      onmouseout="this.style.borderColor='#E4E7F0';this.style.color='#64748B'">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="15 18 9 12 15 6" />
      </svg>
    </a>
    <div style="flex:1;">
      <h1 style="font-size:1.375rem;font-weight:800;color:#1E293B;margin:0 0 .1rem;letter-spacing:-.02em;">Edit Layanan
      </h1>
      <p style="font-size:.8rem;color:#94A3B8;margin:0;">Perbarui informasi dan konten: <strong
          style="color:#3B82F6;">{{ $s->name }}</strong></p>
    </div>
    <a href="{{ url('/services/' . $s->slug) }}" target="_blank"
      style="display:inline-flex;align-items:center;gap:.375rem;font-size:.8rem;font-weight:700;color:#8B5CF6;background:rgba(139,92,246,0.08);padding:.5rem 1rem;border-radius:10px;text-decoration:none;transition:all .2s;"
      onmouseover="this.style.background='rgba(139,92,246,0.15)'"
      onmouseout="this.style.background='rgba(139,92,246,0.08)'">
      <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6" />
        <polyline points="15 3 21 3 21 9" />
        <line x1="10" y1="14" x2="21" y2="3" />
      </svg>
      Preview
    </a>
  </div>

  <form method="POST" action="{{ route('admin.services.update', $s) }}" enctype="multipart/form-data" id="svc-form">
    @csrf @method('PUT')

    @if($errors->any())
      <div
        style="background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;color:#991B1B;font-size:.875rem;line-height:1.6;">
        <strong style="display:block;margin-bottom:.5rem;">⚠️ DOUBLE CEK DIBUTUHKAN:</strong>
        <ul style="margin:0;padding-left:1.25rem;">
          @foreach($errors->all() as $error)
            <li style="margin-bottom:.25rem;">{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div id="validation-alert"
      style="display:none;background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;color:#991B1B;font-size:.875rem;line-height:1.6;">
    </div>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:1.75rem;align-items:start;">

      {{-- ═══════════════ LEFT COLUMN ═══════════════ --}}
      <div style="display:flex;flex-direction:column;gap:1.5rem;">

        {{-- Informasi Layanan --}}
        <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
          <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.5rem;">
            <div
              style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
              <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24">
                <path
                  d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" />
              </svg>
            </div>
            <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Informasi Layanan</h3>
          </div>
          <div style="display:flex;flex-direction:column;gap:1.125rem;">
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Nama
                Produk/Layanan <span style="color:#EF4444;">*</span></label>
              <input type="text" name="name" id="svc-name" value="{{ old('name', $s->name) }}" required
                oninput="svcAutoSlug()"
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;transition:border-color .2s;"
                onfocus="this.style.borderColor='#3B82F6';this.style.background='#fff'"
                onblur="this.style.borderColor='#E4E7F0';this.style.background='#F8FAFC'"
                placeholder="Contoh: Alat Rumah CV-60">
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">
                Slug (URL) <span style="font-weight:500;color:#94A3B8;font-size:.75rem;">— Kosongkan untuk otomatis</span>
              </label>
              <div
                style="display:flex;align-items:center;gap:0;border:1.5px solid #E4E7F0;border-radius:10px;overflow:hidden;background:#F8FAFC;transition:border-color .2s;"
                id="slug-wrapper">
                <span
                  style="padding:.75rem .875rem;font-size:.8rem;color:#94A3B8;background:#F1F5F9;border-right:1px solid #E4E7F0;white-space:nowrap;">/services/</span>
                <input type="text" name="slug" id="svc-slug" value="{{ old('slug', $s->slug) }}" pattern="[a-z0-9\-]*"
                  style="flex:1;padding:.75rem .875rem;background:transparent;border:none;font-size:.9rem;color:#1E293B;font-family:inherit;outline:none;"
                  onfocus="document.getElementById('slug-wrapper').style.borderColor='#3B82F6'"
                  onblur="document.getElementById('slug-wrapper').style.borderColor='#E4E7F0'"
                  placeholder="contoh-slug-url">
              </div>
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Deskripsi
                Singkat <span style="font-weight:500;color:#94A3B8;font-size:.75rem;">max 500 karakter</span></label>
              <textarea name="short_desc" rows="3" maxlength="500"
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;font-family:inherit;outline:none;resize:vertical;box-sizing:border-box;transition:border-color .2s;"
                onfocus="this.style.borderColor='#3B82F6';this.style.background='#fff'"
                onblur="this.style.borderColor='#E4E7F0';this.style.background='#F8FAFC'"
                placeholder="Deskripsi singkat tampil di halaman listing...">{{ old('short_desc', $s->short_desc) }}</textarea>
            </div>
          </div>
        </div>

        {{-- Rich Text Editor --}}
        <div style="background:#fff;border-radius:20px;box-shadow:0 2px 20px rgba(0,0,0,0.04);overflow:hidden;">
          <div
            style="padding:1.25rem 1.75rem;border-bottom:1px solid #F1F5F9;display:flex;align-items:center;gap:.625rem;">
            <div
              style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
              <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
              </svg>
            </div>
            <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Deskripsi Lengkap</h3>
          </div>
          <div style="padding:1.25rem 1.75rem;">
            @include('admin.partials.rich-editor', ['name' => 'description', 'value' => old('description', $s->description ?? ''), 'height' => '320px'])
          </div>
        </div>

        {{-- Data E-Commerce / Harga --}}
        <div
          style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04); margin-bottom:1.5rem;">
          <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.5rem;">
            <div
              style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
              <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="9" cy="21" r="1" />
                <circle cx="20" cy="21" r="1" />
                <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6" />
              </svg>
            </div>
            <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Data E-Commerce / Harga</h3>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.125rem;">
            <div style="grid-column: span 2;">
              <label
                style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Kategori</label>
              <select name="product_category_id" required
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
                <option value="">-- Pilih Kategori Produk (Contoh: Elektronik Rumah) --</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ old('product_category_id', $s->product_category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Harga Utama
                (Rp)</label>
              <input type="number" name="price" value="{{ old('price', $s->price) }}" min="0"
                placeholder="Contoh: 1500000"
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
              <p style="font-size:.7rem;color:#94A3B8;margin-top:.25rem;">Kosongkan/0 jika variasi punya harga berbeda
                atau layanan konsultasi</p>
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Harga Diskon
                (Rp)</label>
              <input type="number" name="sale_price" value="{{ old('sale_price', $s->sale_price) }}" min="0"
                placeholder="Contoh: 1250000 (Opsional)"
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Stok <span
                  style="color:#EF4444;">*</span></label>
              <input type="number" name="stock" value="{{ old('stock', $s?->stock ?? 0) }}" min="0"
                placeholder="Contoh: 100" required
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Minimum
                Order</label>
              <input type="number" name="min_order" value="{{ old('min_order', $s?->min_order ?? 1) }}" min="1"
                placeholder="Contoh: 1"
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Berat
                (Gram)</label>
              <input type="number" name="weight" value="{{ old('weight', $s?->weight ?? 0) }}" min="0"
                placeholder="Contoh: 1500 (untuk 1.5 kg)"
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Rating
                Bintang <span style="color:#EF4444;">*</span></label>
              <input type="number" step="0.1" name="rating" value="{{ old('rating', $s?->rating ?? 0) }}" min="0" max="5"
                placeholder="Contoh: 4.9" required
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Jumlah
                Terjual <span style="color:#EF4444;">*</span></label>
              <input type="number" name="sold_count" value="{{ old('sold_count', $s?->sold_count ?? 0) }}" min="0"
                placeholder="Contoh: 1250" required
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
            </div>
            <div style="grid-column:1 / -1;">
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">SKU Produk
                (Opsional)</label>
              <input type="text" name="sku" value="{{ old('sku', $s->sku ?? '') }}" placeholder="Contoh: SKU-CV60-MAIN"
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
            </div>
          </div>
        </div>

        {{-- ═══ VARIAN PRODUK (SHOPEE-STYLE THEME BLUE) ═══ --}}
        <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);"
          id="variants-section">

          <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.25rem;">
            <div
              style="width:32px;height:32px;background:rgba(27,111,232,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="16" height="16" fill="none" stroke="#1B6FE8" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="7" width="20" height="14" rx="2" />
                <path d="M16 3h-8l-2 4h12l-2-4z" />
              </svg>
            </div>
            <div>
              <h3 style="font-size:.9rem;font-weight:800;color:#1E293B;margin:0;line-height:1.2;">Varian Produk <span
                  style="font-size:.75rem;font-weight:500;color:#94A3B8;">(Opsional)</span></h3>
              <p style="font-size:.72rem;color:#94A3B8;margin:.1rem 0 0;">Maks. 2 variasi. Setiap kombinasi punya harga &
                stok tersendiri.</p>
            </div>
          </div>

          {{-- Variant Groups --}}
          <div id="vg-list" style="display:flex;flex-direction:column;gap:.75rem;margin-bottom:1rem;"></div>

          {{-- Add variant group button (max 2) --}}
          <button type="button" id="btn-add-vg" onclick="addVarGroup()"
            style="display:inline-flex;align-items:center;gap:.35rem;background:#F8FAFC;color:#1B6FE8;border:1.5px dashed rgba(27,111,232,0.45);padding:.5rem 1.1rem;border-radius:10px;font-size:.8rem;font-weight:700;cursor:pointer;transition:all .2s;"
            onmouseover="this.style.background='rgba(27,111,232,0.06)'" onmouseout="this.style.background='#F8FAFC'">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <line x1="12" y1="5" x2="12" y2="19" />
              <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            + Tambah Variasi
          </button>

          {{-- Combination Matrix Table --}}
          <div id="combo-section" style="display:none;margin-top:1.5rem;">
            <div
              style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;flex-wrap:wrap;gap:.5rem;">
              <div style="font-size:.8rem;font-weight:800;color:#1E293B;letter-spacing:.03em;">DAFTAR VARIASI</div>
              <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
                <span style="font-size:.72rem;color:#64748B;flex-shrink:0;">Terapkan ke semua:</span>
                <div
                  style="display:flex;align-items:center;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;overflow:hidden;width:120px;">
                  <span
                    style="font-size:.7rem;color:#64748B;padding:0 .4rem;background:#F1F5F9;height:32px;display:flex;align-items:center;border-right:1px solid #E4E7F0;font-weight:600;">Rp</span>
                  <input type="number" id="bulk-price" placeholder="Harga" min="0" step="1000"
                    style="width:100%;padding:.3rem .5rem;border:none;font-size:.78rem;font-family:inherit;outline:none;height:32px;"
                    onfocus="this.parentElement.style.borderColor='#1B6FE8'"
                    onblur="this.parentElement.style.borderColor='#E4E7F0'">
                </div>
                <input type="number" id="bulk-stock" placeholder="Stok" min="0"
                  style="width:75px;padding:.35rem .6rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.78rem;font-family:inherit;outline:none;"
                  onfocus="this.style.borderColor='#1B6FE8'" onblur="this.style.borderColor='#E4E7F0'">
                <div
                  style="display:flex;align-items:center;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;overflow:hidden;width:100px;">
                  <input type="number" id="bulk-ship" placeholder="Kirim" min="1" value="2"
                    style="width:100%;padding:.3rem .4rem;border:none;font-size:.78rem;font-family:inherit;outline:none;height:32px;"
                    onfocus="this.parentElement.style.borderColor='#1B6FE8'"
                    onblur="this.parentElement.style.borderColor='#E4E7F0'">
                  <span
                    style="font-size:.68rem;color:#64748B;padding:0 .35rem;background:#F1F5F9;height:32px;display:flex;align-items:center;border-left:1px solid #E4E7F0;white-space:nowrap;">hari</span>
                </div>
                <input type="text" id="bulk-sku" placeholder="Kode Variasi"
                  style="width:110px;padding:.35rem .6rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.78rem;font-family:inherit;outline:none;"
                  onfocus="this.style.borderColor='#1B6FE8'" onblur="this.style.borderColor='#E4E7F0'">
                <button type="button" onclick="applyBulk()"
                  style="padding:.35rem .8rem;background:#1B6FE8;color:#fff;border:none;border-radius:8px;font-size:.75rem;font-weight:700;cursor:pointer;white-space:nowrap;">
                  Terapkan
                </button>
              </div>
            </div>

            {{-- Info box --}}
            <div
              style="background:#FFFBEB;border:1px solid #FCD34D;border-radius:10px;padding:.7rem 1rem;margin-bottom:.875rem;font-size:.76rem;color:#92400E;line-height:1.5;">
              <strong>Dikirim Dalam</strong> default 2 hari kerja. Kolom wajib <span style="color:#EF4444;">*</span> harus
              diisi — jika kosong akan ditandai merah saat simpan.
            </div>

            <div style="overflow-x:auto;border-radius:12px;border:1.5px solid #E4E7F0;">
              <table style="width:100%;border-collapse:collapse;font-size:.8rem;" id="combo-table">
                <thead>
                  <tr style="background:#F8FAFC;">
                    <th id="th-v1"
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;">
                    </th>
                    <th id="th-v2"
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;display:none;">
                    </th>
                    <th
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:110px;">
                      Harga (Rp) <span style="color:#EF4444;">*</span></th>
                    <th
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:75px;">
                      Stok <span style="color:#EF4444;">*</span></th>
                    <th
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:95px;">
                      Dikirim Dalam <span style="color:#EF4444;">*</span></th>
                    <th
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:100px;">
                      Kode Variasi</th>
                    <th
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:100px;">
                      GTIN</th>
                    <th
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:140px;">
                      Foto Variasi</th>
                  </tr>
                </thead>
                <tbody id="combo-tbody"></tbody>
              </table>
            </div>
          </div>

        </div>

        {{-- Spesifikasi Produk --}}
        @php
          $specs = old('spec_keys', is_array($s->specifications) ? array_column($s->specifications, 'key') : []);
          $specVals = old('spec_values', is_array($s->specifications) ? array_column($s->specifications, 'value') : []);
        @endphp
        <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
            <div style="display:flex;align-items:center;gap:.625rem;">
              <div
                style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24">
                  <line x1="8" y1="6" x2="21" y2="6" />
                  <line x1="8" y1="12" x2="21" y2="12" />
                  <line x1="8" y1="18" x2="21" y2="18" />
                  <line x1="3" y1="6" x2="3.01" y2="6" />
                  <line x1="3" y1="12" x2="3.01" y2="12" />
                  <line x1="3" y1="18" x2="3.01" y2="18" />
                </svg>
              </div>
              <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Spesifikasi Produk</h3>
            </div>
            <button type="button" onclick="addSpec()"
              style="display:inline-flex;align-items:center;gap:.375rem;font-size:.78rem;font-weight:700;color:#3B82F6;background:rgba(59,130,246,0.08);border:none;border-radius:8px;padding:.4rem .875rem;cursor:pointer;transition:background .2s;"
              onmouseover="this.style.background='rgba(59,130,246,0.15)'"
              onmouseout="this.style.background='rgba(59,130,246,0.08)'">
              <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Tambah Baris
            </button>
          </div>
          <div id="specs-container" style="display:flex;flex-direction:column;gap:.625rem;">
            @forelse($specs as $idx => $k)
              <div class="spec-row" style="display:flex;gap:.625rem;align-items:center;">
                <input type="text" name="spec_keys[]" value="{{ $k }}" placeholder="Label (misal: Dimensi)"
                  style="flex:1;padding:.625rem .875rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;"
                  onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
                <input type="text" name="spec_values[]" value="{{ $specVals[$idx] ?? '' }}"
                  placeholder="Nilai (misal: 24 inch)"
                  style="flex:2;padding:.625rem .875rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;"
                  onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
                <button type="button" onclick="this.parentElement.remove()"
                  style="flex-shrink:0;width:32px;height:32px;background:rgba(239,68,68,0.08);border:none;border-radius:8px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;"
                  onmouseover="this.style.background='rgba(239,68,68,0.16)'"
                  onmouseout="this.style.background='rgba(239,68,68,0.08)'">
                  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                  </svg>
                </button>
              </div>
            @empty
              <div id="specs-empty"
                style="text-align:center;padding:2rem;color:#94A3B8;font-size:.875rem;border:2px dashed #E4E7F0;border-radius:10px;">
                Belum ada spesifikasi. Klik "Tambah Baris" untuk mulai.
              </div>
            @endforelse
          </div>
        </div>

        {{-- FAQ --}}
        @php
          $faqs = old('faq_qs', is_array($s->faqs) ? array_column($s->faqs, 'q') : []);
          $faqAs = old('faq_as', is_array($s->faqs) ? array_column($s->faqs, 'a') : []);
        @endphp
        <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
            <div style="display:flex;align-items:center;gap:.625rem;">
              <div
                style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24">
                  <circle cx="12" cy="12" r="10" />
                  <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3" />
                  <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
              </div>
              <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Tanya Jawab (FAQ)</h3>
            </div>
            <button type="button" onclick="addFaq()"
              style="display:inline-flex;align-items:center;gap:.375rem;font-size:.78rem;font-weight:700;color:#3B82F6;background:rgba(59,130,246,0.08);border:none;border-radius:8px;padding:.4rem .875rem;cursor:pointer;transition:background .2s;"
              onmouseover="this.style.background='rgba(59,130,246,0.15)'"
              onmouseout="this.style.background='rgba(59,130,246,0.08)'">
              <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Tambah FAQ
            </button>
          </div>
          <div id="faq-container" style="display:flex;flex-direction:column;gap:.875rem;">
            @forelse($faqs as $idx => $q)
              <div class="faq-row"
                style="display:flex;flex-direction:column;gap:.5rem;padding:1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:12px;position:relative;">
                <button type="button" onclick="this.parentElement.remove()"
                  style="position:absolute;top:.625rem;right:.625rem;width:24px;height:24px;background:rgba(239,68,68,0.08);border:none;border-radius:6px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;"
                  onmouseover="this.style.background='rgba(239,68,68,0.16)'"
                  onmouseout="this.style.background='rgba(239,68,68,0.08)'">
                  <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                  </svg>
                </button>
                <input type="text" name="faq_qs[]" value="{{ $q }}" placeholder="Pertanyaan?"
                  style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;padding-right:2.5rem;"
                  onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
                <textarea name="faq_as[]" rows="2" placeholder="Jawaban lengkap..."
                  style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;resize:vertical;box-sizing:border-box;"
                  onfocus="this.style.borderColor='#3B82F6'"
                  onblur="this.style.borderColor='#E4E7F0'">{{ $faqAs[$idx] ?? '' }}</textarea>
              </div>
            @empty
              <div
                style="text-align:center;padding:2rem;color:#94A3B8;font-size:.875rem;border:2px dashed #E4E7F0;border-radius:10px;">
                Belum ada FAQ. Klik "Tambah FAQ" untuk mulai.</div>
            @endforelse
          </div>
        </div>

        @include('admin.partials.seo-fields', ['item' => $s])
      </div>

      {{-- ═══════════════ RIGHT COLUMN ═══════════════ --}}
      <div style="display:flex;flex-direction:column;gap:1.5rem;position:sticky;top:1.5rem;">

        {{-- Tombol Simpan --}}
        <div style="background:#fff;border-radius:20px;padding:1.25rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
          <button type="submit"
            style="width:100%;display:flex;align-items:center;justify-content:center;gap:.5rem;background:#3B82F6;color:#fff;font-size:.9rem;font-weight:700;padding:.875rem 1.5rem;border-radius:12px;border:none;cursor:pointer;transition:all .2s;box-shadow:0 4px 14px rgba(59,130,246,0.3);"
            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 20px rgba(59,130,246,0.4)'"
            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 14px rgba(59,130,246,0.3)'">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
              <polyline points="17 21 17 13 7 13 7 21" />
            </svg>
            Update Layanan
          </button>
          <a href="{{ route('admin.services.index') }}"
            style="display:flex;align-items:center;justify-content:center;margin-top:.625rem;font-size:.85rem;font-weight:600;color:#64748B;text-decoration:none;padding:.625rem;border-radius:10px;transition:background .2s;"
            onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">Batal</a>
        </div>

        {{-- Status & Urutan --}}
        <div style="background:#fff;border-radius:20px;padding:1.5rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
          <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.25rem;">
            <div
              style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
              <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12" />
              </svg>
            </div>
            <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">Status Publikasi</h3>
          </div>
          <div style="display:flex;flex-direction:column;gap:1rem;">
            <label
              style="display:flex;align-items:center;justify-content:space-between;cursor:pointer;padding:.875rem 1rem;background:#F8FAFC;border-radius:12px;border:1.5px solid #E4E7F0;">
              <div>
                <div style="font-size:.875rem;font-weight:700;color:#1E293B;">Aktif</div>
                <div style="font-size:.75rem;color:#94A3B8;margin-top:.1rem;">Tampil di website publik</div>
              </div>
              <div style="position:relative;">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $s->is_active) ? 'checked' : '' }}
                  id="is_active_toggle" style="position:absolute;opacity:0;width:0;height:0;"
                  onchange="updateToggle(this)">
                <div id="toggle-track" onclick="document.getElementById('is_active_toggle').click()"
                  style="width:44px;height:24px;border-radius:100px;cursor:pointer;transition:background .2s;position:relative;background:{{ old('is_active', $s->is_active) ? '#3B82F6' : '#E4E7F0' }};">
                  <div id="toggle-thumb"
                    style="position:absolute;top:3px;left:{{ old('is_active', $s->is_active) ? '23px' : '3px' }};width:18px;height:18px;background:#fff;border-radius:50%;transition:left .2s;box-shadow:0 1px 4px rgba(0,0,0,0.15);">
                  </div>
                </div>
              </div>
            </label>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Icon
                (opsional)</label>
              <input type="text" name="icon" value="{{ old('icon', $s->icon) }}" placeholder="crane, hoist, lift..."
                style="width:100%;padding:.625rem .875rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;"
                onfocus="this.style.borderColor='#3B82F6';this.style.background='#fff'"
                onblur="this.style.borderColor='#E4E7F0';this.style.background='#F8FAFC'">
              <p style="font-size:.72rem;color:#94A3B8;margin:.375rem 0 0;">Nama ikon atau SVG path identifier</p>
            </div>
          </div>
        </div>

        {{-- Foto Utama --}}
        @include('admin.partials.image-upload', ['item' => $s, 'field' => 'image', 'label' => 'Foto Utama Layanan', 'aspectRatio' => '1:1'])

        {{-- OG Image --}}
        @include('admin.partials.image-upload', ['item' => $s, 'field' => 'og_image', 'label' => 'OG Image (Share Preview)'])

        {{-- Brosur --}}
        <div style="background:#fff;border-radius:20px;padding:1.5rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
          <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.25rem;">
            <div
              style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
              <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                <polyline points="14 2 14 8 20 8" />
              </svg>
            </div>
            <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">File Brosur</h3>
          </div>
          @if($s->brochure)
            <a href="{{ asset('storage/' . $s->brochure) }}" target="_blank"
              style="display:inline-flex;align-items:center;gap:.375rem;font-size:.78rem;font-weight:700;color:#3B82F6;background:rgba(59,130,246,0.08);padding:.4rem .875rem;border-radius:8px;text-decoration:none;margin-bottom:.875rem;transition:background .2s;"
              onmouseover="this.style.background='rgba(59,130,246,0.15)'"
              onmouseout="this.style.background='rgba(59,130,246,0.08)'">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6" />
                <polyline points="15 3 21 3 21 9" />
                <line x1="10" y1="14" x2="21" y2="3" />
              </svg>
              Lihat Brosur Saat Ini
            </a>
          @endif
          <label
            style="display:flex;flex-direction:column;align-items:center;gap:.5rem;padding:1.25rem;border:2px dashed #E4E7F0;border-radius:12px;cursor:pointer;transition:all .2s;text-align:center;"
            onmouseover="this.style.borderColor='#3B82F6';this.style.background='#F8FAFF'"
            onmouseout="this.style.borderColor='#E4E7F0';this.style.background='transparent'">
            <svg width="24" height="24" fill="none" stroke="#94A3B8" stroke-width="1.5" viewBox="0 0 24 24">
              <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
              <polyline points="17 8 12 3 7 8" />
              <line x1="12" y1="3" x2="12" y2="15" />
            </svg>
            <span
              style="font-size:.8rem;color:#64748B;font-weight:600;">{{ $s->brochure ? 'Ganti Brosur' : 'Upload Brosur' }}</span>
            <span style="font-size:.72rem;color:#94A3B8;">PDF, JPG, PNG — Maks 10MB</span>
            <input type="file" name="brochure" accept=".pdf,image/*" style="display:none;">
          </label>
        </div>

        {{-- Gallery --}}
        <div style="background:#fff;border-radius:20px;padding:1.5rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.125rem;">
            <div style="display:flex;align-items:center;gap:.625rem;">
              <div
                style="width:28px;height:28px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <svg width="14" height="14" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24">
                  <rect x="3" y="3" width="18" height="18" rx="2" />
                  <circle cx="8.5" cy="8.5" r="1.5" />
                  <polyline points="21 15 16 10 5 21" />
                </svg>
              </div>
              <h3 style="font-size:.8rem;font-weight:800;color:#1E293B;margin:0;">Foto Gallery</h3>
            </div>
            <span id="gallery-count-badge"
              style="display:none;font-size:.7rem;font-weight:700;color:#3B82F6;background:rgba(59,130,246,0.1);padding:.2rem .6rem;border-radius:20px;"></span>
          </div>

          {{-- Container hidden file inputs --}}
          <div id="gallery-file-inputs"></div>

          {{-- Existing saved gallery images --}}
          @if($s && is_array($s->gallery) && count($s->gallery) > 0)
            <div style="font-size:.72rem;font-weight:700;color:#64748B;margin-bottom:.4rem;">Foto Tersimpan saat ini:</div>
            <div id="gallery-saved-grid"
              style="display:grid;grid-template-columns:repeat(auto-fill, minmax(85px, 1fr));gap:.625rem;margin-bottom:1rem;">
              @foreach($s->gallery as $g)
                <div class="gallery-saved-item" data-path="{{ $g }}"
                  style="position:relative;border-radius:10px;overflow:hidden;border:1.5px solid #E2E8F0;aspect-ratio:1/1;">
                  <img src="{{ asset('storage/' . $g) }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                  {{-- Trash button (AJAX delete) --}}
                  <button type="button" onclick="deleteGalleryImage(this, '{{ $g }}', {{ $s->id }})" title="Hapus foto ini"
                    style="position:absolute;top:4px;right:4px;width:22px;height:22px;background:rgba(239,68,68,0.92);border:none;border-radius:6px;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 4px rgba(239,68,68,0.4);padding:0;">
                    {{-- Trash icon --}}
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                      <line x1="18" y1="6" x2="6" y2="18" />
                      <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                  </button>
                  {{-- Label badge --}}
                  <div
                    style="position:absolute;bottom:0;left:0;right:0;background:rgba(15,23,42,0.6);padding:.2rem .3rem;font-size:.62rem;color:rgba(255,255,255,0.9);font-weight:600;text-align:center;">
                    Tersimpan</div>
                </div>
              @endforeach
            </div>
          @else
            <div id="gallery-saved-grid"
              style="display:grid;grid-template-columns:repeat(auto-fill, minmax(85px, 1fr));gap:.625rem;margin-bottom:1rem;">
            </div>
          @endif

          {{-- New gallery file previews (before save) --}}
          <div id="gallery-new-previews"
            style="display:grid;grid-template-columns:repeat(auto-fill, minmax(85px, 1fr));gap:.625rem;margin-bottom:.75rem;">
          </div>

          {{-- Upload Actions --}}
          <div style="display:flex;flex-direction:column;gap:.5rem;">
            <button type="button" onclick="addGalleryFileSlot(true)"
              style="width:100%;padding:.75rem 1rem;background:#F0F9FF;color:#0284C7;border:1.5px dashed #0284C7;border-radius:12px;font-size:.8rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:all .2s;"
              onmouseover="this.style.background='#E0F2FE'" onmouseout="this.style.background='#F0F9FF'">
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14" />
              </svg>
              + Tambah Foto Gallery (1 Per 1)
            </button>

            <button type="button" onclick="addGalleryFileSlot(false)"
              style="width:100%;padding:.5rem 1rem;background:#F8FAFC;color:#64748B;border:1px solid #E2E8F0;border-radius:10px;font-size:.75rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.4rem;transition:all .2s;"
              onmouseover="this.style.background='#F1F5F9';this.style.color='#1E293B'"
              onmouseout="this.style.background='#F8FAFC';this.style.color='#64748B'">
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <circle cx="8.5" cy="8.5" r="1.5" />
                <polyline points="21 15 16 10 5 21" />
              </svg>
              Atau Pilih Banyak Foto Sekaligus
            </button>
            <p style="font-size:.68rem;color:#94A3B8;margin:.5rem 0 0;text-align:center;">Foto baru yang ditambah 1 per 1
              akan terakumulasi &amp; tersimpan saat simpan produk.</p>
          </div>

        </div>
      </div>
  </form>

  {{-- CONFIRMATION MODAL --}}
  <div id="confirmModal"
    style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(15,23,42,0.6);z-index:9999;align-items:center;justify-content:center;opacity:0;transition:opacity 0.2s;">
    <div
      style="background:#fff;border-radius:24px;width:90%;max-width:400px;padding:2rem;text-align:center;box-shadow:0 10px 40px rgba(0,0,0,0.1);transform:scale(0.95);transition:transform 0.2s;"
      id="confirmModalBox">
      <div
        style="width:64px;height:64px;background:rgba(59,130,246,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
        <svg width="32" height="32" fill="none" stroke="#3B82F6" stroke-width="2.5" viewBox="0 0 24 24">
          <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
          <polyline points="22 4 12 14.01 9 11.01" />
        </svg>
      </div>
      <h3 style="font-size:1.25rem;font-weight:800;color:#1E293B;margin:0 0 .5rem;">Cek Kembali Data Anda</h3>
      <p style="font-size:.9rem;color:#64748B;margin:0 0 1.5rem;line-height:1.5;">Apakah Anda yakin semua data (kategori,
        harga, spek produk, FAQ, dan foto) sudah terisi dengan benar sesuai tema?</p>
      <div style="display:flex;gap:.75rem;">
        <button type="button" onclick="closeConfirmModal()"
          style="flex:1;padding:.75rem;background:#F1F5F9;color:#64748B;font-weight:700;border:none;border-radius:12px;cursor:pointer;transition:background .2s;"
          onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">Cek Lagi</button>
        <button type="button" onclick="submitRealForm()"
          style="flex:1;padding:.75rem;background:#3B82F6;color:#fff;font-weight:700;border:none;border-radius:12px;cursor:pointer;transition:background .2s;box-shadow:0 4px 12px rgba(59,130,246,0.3);"
          onmouseover="this.style.background='#2563EB'" onmouseout="this.style.background='#3B82F6'">Ya, Simpan</button>
      </div>
    </div>
  </div>

  {{-- Toast notification --}}
  <div id="gallery-toast"
    style="display:none;position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;background:#0F172A;color:#fff;padding:.75rem 1.25rem;border-radius:12px;font-size:.82rem;font-weight:600;box-shadow:0 8px 30px rgba(0,0,0,0.3);display:flex;align-items:center;gap:.5rem;opacity:0;transition:opacity .3s;">
    <span id="gallery-toast-icon">✅</span>
    <span id="gallery-toast-msg">Foto berhasil dihapus.</span>
  </div>

  <script>
    /* ─── AJAX: Hapus foto gallery tersimpan ─────────────────────── */
    function deleteGalleryImage(btn, path, serviceId) {
      if (!confirm('Hapus foto ini sekarang?\nTindakan tidak bisa dibatalkan.')) return;

      // Loading state
      btn.disabled = true;
      btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-dasharray="31.4" stroke-dashoffset="10"><animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur=".7s" repeatCount="indefinite"/></circle></svg>';

      fetch('/admin/services/' + serviceId + '/gallery-image', {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ path: path })
      })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (data.ok) {
            // Animasi hilang
            var card = btn.closest('.gallery-saved-item');
            card.style.transition = 'all .35s cubic-bezier(.4,0,.2,1)';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.8)';
            setTimeout(function () { card.remove(); }, 360);
            showGalleryToast('✅', 'Foto berhasil dihapus.');
          } else {
            btn.disabled = false;
            btn.innerHTML = trashIcon();
            showGalleryToast('❌', data.message || 'Gagal menghapus foto.');
          }
        })
        .catch(function () {
          btn.disabled = false;
          btn.innerHTML = trashIcon();
          showGalleryToast('❌', 'Terjadi kesalahan. Coba lagi.');
        });
    }

    function trashIcon() {
      return '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>';
    }

    function showGalleryToast(icon, msg) {
      var t = document.getElementById('gallery-toast');
      document.getElementById('gallery-toast-icon').textContent = icon;
      document.getElementById('gallery-toast-msg').textContent = msg;
      t.style.display = 'flex';
      t.style.opacity = '1';
      setTimeout(function () {
        t.style.opacity = '0';
        setTimeout(function () { t.style.display = 'none'; }, 300);
      }, 2800);
    }

    /* ─── Preview foto baru sebelum disimpan ─────────────────────── */
    var galleryFileCounter = 0;

    function addGalleryFileSlot(isSingle) {
      var container = document.getElementById('gallery-file-inputs');
      galleryFileCounter++;
      var inputId = 'g-file-input-' + galleryFileCounter;

      var newInput = document.createElement('input');
      newInput.type = 'file';
      newInput.name = 'gallery_images[]';
      newInput.id = inputId;
      newInput.accept = 'image/*';
      if (!isSingle) {
        newInput.multiple = true;
      }
      newInput.style.display = 'none';

      newInput.onchange = function () {
        if (!this.files || this.files.length === 0) {
          newInput.remove();
          return;
        }
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

      inputs.forEach(function (input) {
        if (input.files && input.files.length > 0) {
          Array.from(input.files).forEach(function (file, fileIdx) {
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
          Array.from(input.files).forEach(function (file, idx) {
            if (idx !== fileIndex) dt.items.add(file);
          });
          input.files = dt.files;
        } catch (e) {
          input.remove();
        }
        if (input.files.length === 0) {
          input.remove();
        }
      }
      renderGalleryPreviews();
    }



    var svcSlugManual = true; // edit mode: slug sudah ada
    document.getElementById('svc-slug').addEventListener('input', () => svcSlugManual = true);
    function svcAutoSlug() {
      if (svcSlugManual) return;
      document.getElementById('svc-slug').value = document.getElementById('svc-name').value.toLowerCase().replace(/[^a-z0-9\s\-]/g, '').trim().replace(/\s+/g, '-');
    }
    let isConfirmed = false;
    document.getElementById('svc-form').addEventListener('submit', function (e) {
      if (isConfirmed) return true;

      // Sync hidden textareas
      document.querySelectorAll('textarea[style*="display:none"]').forEach(t => t.style.display = 'block');

      // ── Double-check validasi ──
      const errors = [];
      const name = document.getElementById('svc-name').value.trim();
      if (!name) errors.push('❌  Nama Produk/Layanan wajib diisi.');

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
      document.getElementById('toggle-track').style.background = chk.checked ? '#3B82F6' : '#E4E7F0';
      document.getElementById('toggle-thumb').style.left = chk.checked ? '23px' : '3px';
    }
    function addSpec() {
      const empty = document.getElementById('specs-empty');
      if (empty) empty.remove();
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

    /* ─── Shopee-Style Varian Produk Engine (Theme Blue) ─────────────────── */
    let VGS = [];
    let nextGid = 1;
    let nextVid = 1;

    window._savedCombos = {};

    function initEditVariants() {
      const rawOptions = @json($s->variantOptions()->with('values')->get());
      const rawCombos = @json($s->variantCombinations);

      if (rawCombos && rawCombos.length > 0) {
        rawCombos.forEach(c => {
          const key1 = `${c.option1_value_id}_${c.option2_value_id || 'x'}`;
          window._savedCombos[key1] = { price: c.price, stock: c.stock, ship: c.ship_days || 2, sku: c.sku || '', gtin: c.gtin || '', image: c.image || '', id: c.id };
        });
      }

      if (rawOptions && rawOptions.length > 0) {
        rawOptions.forEach(group => {
          const gid = nextGid++;
          const valList = [];
          if (group.values) {
            group.values.forEach(v => {
              valList.push({ vid: v.id, label: v.value, existingId: v.id });
              if (v.id >= nextVid) nextVid = v.id + 1;
            });
          }
          VGS.push({ gid, name: group.name, values: valList, existingId: group.id });
        });
      }

      renderVGS();
    }

    function addVarGroup(initialName = '', existingId = null) {
      if (VGS.length >= 2) return;
      const gid = nextGid++;
      VGS.push({ gid, name: initialName, values: [], existingId });
      renderVGS();
    }

    function removeVarGroup(gid) {
      VGS = VGS.filter(g => g.gid !== gid);
      renderVGS();
    }

    function onGroupNameChange(gid, val) {
      const g = VGS.find(x => x.gid === gid);
      if (g) g.name = val.trim();
      renderMatrix();
    }

    function addTagValue(gid) {
      const inp = document.getElementById(`tag-inp-${gid}`);
      if (!inp) return;
      const raw = inp.value.trim();
      if (!raw) return;

      const labels = raw.split(',').map(s => s.trim()).filter(Boolean);
      const g = VGS.find(x => x.gid === gid);
      if (!g) return;

      labels.forEach(lbl => {
        if (!g.values.some(v => v.label.toLowerCase() === lbl.toLowerCase())) {
          g.values.push({ vid: nextVid++, label: lbl, existingId: null });
        }
      });

      inp.value = '';
      renderVGS();
    }

    function removeTagValue(gid, vid) {
      const g = VGS.find(x => x.gid === gid);
      if (g) {
        g.values = g.values.filter(v => v.vid !== vid);
        renderVGS();
      }
    }

    function renderVGS() {
      const list = document.getElementById('vg-list');
      const btnAdd = document.getElementById('btn-add-vg');
      if (!list || !btnAdd) return;

      btnAdd.style.display = VGS.length >= 2 ? 'none' : 'inline-flex';

      if (VGS.length === 0) {
        list.innerHTML = `<div style="font-size:.78rem;color:#94A3B8;padding:.5rem 0;">Belum ada variasi. Klik <strong>+ Tambah Variasi</strong> untuk membuat varian seperti Warna, Ukuran, dll.</div>`;
        renderMatrix();
        return;
      }

      const placeholders = [
        ['Warna', 'Merah, Biru, Hijau (Tekan Enter atau klik + Tambah)'],
        ['Ukuran', 'S, M, L, XL (Pisahkan dengan koma)']
      ];

      list.innerHTML = VGS.map((g, idx) => {
        const ph = placeholders[idx] || ['Variasi', 'Nilai variasi...'];
        return `
          <div style="border:1.5px solid #E2E8F0;border-radius:14px;padding:1.1rem;background:#F8FAFC;">
            ${renderVGContent(g, ph, idx + 1)}
          </div>
        `;
      }).join('');

      renderMatrix();
    }

    function renderVGContent(g, placeholders, groupNum) {
      const groupLabel = `VARIASI ${groupNum}`;
      const tagsHTML = g.values.map(v => `
        <span style="display:inline-flex;align-items:center;gap:.35rem;background:#EFF6FF;color:#1D4ED8;border:1px solid #BFDBFE;padding:.3rem .65rem;border-radius:20px;font-size:.78rem;font-weight:600;">
          ${escHtml(v.label)}
          <button type="button" onclick="removeTagValue(${g.gid}, ${v.vid})" style="background:none;border:none;color:#1D4ED8;cursor:pointer;padding:0;font-size:.85rem;line-height:1;font-weight:700;">×</button>
        </span>
      `).join('');

      const hiddenInputs = g.values.map((v) => `
        <input type="hidden" name="variant_options[g${g.gid}][values][v${v.vid}][value]" value="${escHtml(v.label)}">
        ${v.existingId ? `<input type="hidden" name="variant_options[g${g.gid}][values][v${v.vid}][existing_id]" value="${v.existingId}">` : ''}
      `).join('');

      return `
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;">
          <span style="font-size:.72rem;font-weight:800;color:#1B6FE8;letter-spacing:.06em;text-transform:uppercase;">${groupLabel}</span>
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
            onfocus="this.style.borderColor='#1B6FE8'" onblur="this.style.borderColor='#E4E7F0'">
        </div>
        <div style="margin-bottom:.6rem;">
          <label style="font-size:.72rem;font-weight:700;color:#64748B;display:block;margin-bottom:.35rem;">Opsi Nilai *</label>
          <div style="display:flex;gap:.4rem;align-items:center;">
            <input id="tag-inp-${g.gid}" type="text" placeholder="${placeholders[1]}"
              style="flex:1;padding:.5rem .75rem;border:1.5px solid #E4E7F0;border-radius:9px;font-size:.82rem;color:#1E293B;font-family:inherit;outline:none;"
              onkeydown="if(event.key==='Enter'){event.preventDefault();addTagValue(${g.gid});}"
              onfocus="this.style.borderColor='#1B6FE8'" onblur="this.style.borderColor='#E4E7F0'">
            <button type="button" onclick="addTagValue(${g.gid})"
              style="padding:.5rem .85rem;background:#1B6FE8;color:#fff;border:none;border-radius:9px;font-size:.78rem;font-weight:700;cursor:pointer;white-space:nowrap;">
              + Tambah
            </button>
          </div>
        </div>
        <div id="tags-${g.gid}" style="display:flex;flex-wrap:wrap;gap:.35rem;min-height:20px;">${tagsHTML}</div>
        ${hiddenInputs}
        ${g.existingId ? `<input type="hidden" name="variant_options[g${g.gid}][existing_id]" value="${g.existingId}">` : ''}
      `;
    }

    function escHtml(str) {
      return String(str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function renderMatrix() {
      const sec = document.getElementById('combo-section');
      const tbody = document.getElementById('combo-tbody');
      const thV1 = document.getElementById('th-v1');
      const thV2 = document.getElementById('th-v2');

      if (!sec || !tbody) return;

      const g1 = VGS[0];
      const g2 = VGS[1] || null;

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

      const v2list = (g2 && g2.values.length > 0) ? g2.values : [null];
      let rowIndex = 0;
      let html = '';

      g1.values.forEach(v1 => {
        v2list.forEach(v2 => {
          const savedKey = `${v1.vid}_${v2 ? v2.vid : 'x'}`;
          const saved = window._savedCombos && window._savedCombos[savedKey];
          const price = saved ? saved.price : '';
          const stock = saved ? saved.stock : '';
          const ship = saved ? (saved.ship || 2) : 2;
          const sku = saved ? (saved.sku || '') : '';
          const gtin = saved ? (saved.gtin || '') : '';
          const img = saved ? (saved.image || '') : '';
          const combId = saved ? saved.id : '';
          const isEven = rowIndex % 2 === 0;

          html += `<tr style="background:${isEven ? '#fff' : '#FAFBFF'};" data-row="${rowIndex}">
            <td style="padding:.55rem .75rem;color:#1E293B;font-weight:600;font-size:.8rem;white-space:nowrap;border-bottom:1px solid #F1F5F9;">
              <span style="display:inline-block;background:#EFF6FF;color:#1D4ED8;padding:.2rem .55rem;border-radius:20px;font-size:.73rem;">${escHtml(v1.label)}</span>
            </td>
            ${v2 ? `<td style="padding:.55rem .75rem;color:#1E293B;font-weight:600;font-size:.8rem;white-space:nowrap;border-bottom:1px solid #F1F5F9;">
              <span style="display:inline-block;background:#F0F9FF;color:#0369A1;padding:.2rem .55rem;border-radius:20px;font-size:.73rem;">${escHtml(v2.label)}</span>
            </td>` : ''}
            <td style="padding:.4rem .6rem;border-bottom:1px solid #F1F5F9;">
              <input type="number" name="variant_options[combinations][${rowIndex}][price]"
                value="${escHtml(price)}" placeholder="0" min="0" step="500"
                style="width:100%;min-width:100px;padding:.4rem .55rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.8rem;font-family:inherit;outline:none;"
                onfocus="this.style.borderColor='#1B6FE8'" onblur="validateRequired(this)" required>
            </td>
            <td style="padding:.4rem .6rem;border-bottom:1px solid #F1F5F9;">
              <input type="number" name="variant_options[combinations][${rowIndex}][stock]"
                value="${escHtml(stock)}" placeholder="0" min="0"
                style="width:100%;min-width:70px;padding:.4rem .55rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.8rem;font-family:inherit;outline:none;"
                onfocus="this.style.borderColor='#1B6FE8'" onblur="validateRequired(this)" required>
            </td>
            <td style="padding:.4rem .6rem;border-bottom:1px solid #F1F5F9;">
              <div style="display:flex;align-items:center;border:1.5px solid #E4E7F0;border-radius:8px;overflow:hidden;min-width:85px;">
                <input type="number" name="variant_options[combinations][${rowIndex}][ship_days]"
                  value="${escHtml(ship)}" placeholder="2" min="1" max="30"
                  style="width:100%;padding:.4rem .4rem;border:none;font-size:.8rem;font-family:inherit;outline:none;"
                  onfocus="this.parentElement.style.borderColor='#1B6FE8'" onblur="this.parentElement.style.borderColor='#E4E7F0';validateRequired(this)" required>
                <span style="font-size:.7rem;color:#64748B;padding:0 .35rem;background:#F1F5F9;height:34px;display:flex;align-items:center;border-left:1px solid #E4E7F0;white-space:nowrap;">hari</span>
              </div>
            </td>
            <td style="padding:.4rem .6rem;border-bottom:1px solid #F1F5F9;">
              <input type="text" name="variant_options[combinations][${rowIndex}][sku]"
                value="${escHtml(sku)}" placeholder="SKU (opsional)"
                style="width:100%;min-width:90px;padding:.4rem .55rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.8rem;font-family:inherit;outline:none;"
                onfocus="this.style.borderColor='#1B6FE8'" onblur="this.style.borderColor='#E4E7F0'">
            </td>
            <td style="padding:.4rem .6rem;border-bottom:1px solid #F1F5F9;">
              <input type="text" name="variant_options[combinations][${rowIndex}][gtin]"
                value="${escHtml(gtin)}" placeholder="GTIN (opsional)"
                style="width:100%;min-width:95px;padding:.4rem .55rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.8rem;font-family:inherit;outline:none;"
                onfocus="this.style.borderColor='#1B6FE8'" onblur="this.style.borderColor='#E4E7F0'">
            </td>
            <td style="padding:.4rem .6rem;border-bottom:1px solid #F1F5F9;">
              <div style="display:flex;align-items:center;gap:.4rem;">
                ${img ? `
                  <div style="position:relative;width:34px;height:34px;border-radius:6px;overflow:hidden;border:1px solid #CBD5E1;flex-shrink:0;">
                    <img src="/storage/${img}" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                  <input type="hidden" name="variant_options[combinations][${rowIndex}][existing_image]" value="${escHtml(img)}">
                ` : ''}
                <input type="file" name="variant_options[combinations][${rowIndex}][image]" accept="image/*" style="font-size:.7rem;width:130px;">
              </div>
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

    function validateRequired(inp) {
      if (inp.hasAttribute('required') && !inp.value.trim()) {
        inp.style.borderColor = '#EF4444';
        inp.style.background = '#FFF5F5';
      } else {
        inp.style.borderColor = '#E4E7F0';
        inp.style.background = '';
      }
    }

    function applyBulk() {
      const price = document.getElementById('bulk-price')?.value;
      const stock = document.getElementById('bulk-stock')?.value;
      const ship = document.getElementById('bulk-ship')?.value;
      const sku = document.getElementById('bulk-sku')?.value;
      const tbody = document.getElementById('combo-tbody');
      if (!tbody) return;
      if (price) tbody.querySelectorAll('input[name*="[price]"]').forEach(i => i.value = price);
      if (stock) tbody.querySelectorAll('input[name*="[stock]"]').forEach(i => i.value = stock);
      if (ship) tbody.querySelectorAll('input[name*="[ship_days]"]').forEach(i => i.value = ship);
      if (sku) tbody.querySelectorAll('input[name*="[sku]"]').forEach(i => i.value = sku);
    }

    document.addEventListener('DOMContentLoaded', initEditVariants);
  </script>
@endsection