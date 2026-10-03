@extends('layouts.admin')
@section('title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')
@section('page-title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')
@section('content')
  @php $s = $service ?? null; @endphp

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
    <div>
      <h1 style="font-size:1.375rem;font-weight:800;color:#1E293B;margin:0 0 .1rem;letter-spacing:-.02em;">
        {{ $s ? 'Edit Layanan' : 'Tambah Layanan Baru' }}</h1>
      <p style="font-size:.8rem;color:#94A3B8;margin:0;">
        {{ $s ? 'Perbarui informasi dan konten layanan' : 'Isi detail lengkap layanan/produk baru' }}</p>
    </div>
  </div>

  <form method="POST" action="{{ $s ? route('admin.services.update', $s) : route('admin.services.store') }}"
    enctype="multipart/form-data" id="svc-form">
    @csrf @if($s) @method('PUT') @endif

    @if($errors->any())
      <div
        style="background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;color:#991B1B;font-size:.875rem;line-height:1.6;">
        <strong style="display:block;margin-bottom:.5rem;">âš ï¸ DOUBLE CEK DIBUTUHKAN:</strong>
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

      {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• LEFT COLUMN â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
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
              <input type="text" name="name" id="svc-name" value="{{ old('name', $s?->name) }}" required
                oninput="svcAutoSlug()"
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;transition:border-color .2s;"
                onfocus="this.style.borderColor='#3B82F6';this.style.background='#fff'"
                onblur="this.style.borderColor='#E4E7F0';this.style.background='#F8FAFC'"
                placeholder="Contoh: Alat Rumah CV-60">
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">
                Slug (URL) <span style="font-weight:500;color:#94A3B8;font-size:.75rem;">â€” Kosongkan untuk
                  otomatis</span>
              </label>
              <div
                style="display:flex;align-items:center;gap:0;border:1.5px solid #E4E7F0;border-radius:10px;overflow:hidden;background:#F8FAFC;transition:border-color .2s;"
                id="slug-wrapper">
                <span
                  style="padding:.75rem .875rem;font-size:.8rem;color:#94A3B8;background:#F1F5F9;border-right:1px solid #E4E7F0;white-space:nowrap;">/services/</span>
                <input type="text" name="slug" id="svc-slug" value="{{ old('slug', $s?->slug) }}" pattern="[a-z0-9\-]*"
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
                placeholder="Deskripsi singkat tampil di halaman listing...">{{ old('short_desc', $s?->short_desc) }}</textarea>
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
            @include('admin.partials.rich-editor', ['name' => 'description', 'value' => old('description', $s?->description ?? ''), 'height' => '320px'])
          </div>
        </div>

        {{-- Spesifikasi Produk --}}
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
                  <option value="{{ $cat->id }}" {{ old('product_category_id', $s?->product_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Harga Utama
                (Rp)</label>
              <input type="text" inputmode="numeric" class="format-rupiah" name="price" value="{{ old('price', isset($s) && $s->price > 0 ? number_format((float)$s->price, 0, '', '.') : '') }}"
                placeholder="Contoh: 1.500.000"
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
              <p style="font-size:.7rem;color:#94A3B8;margin-top:.25rem;">Kosongkan/0 jika variasi punya harga berbeda
                atau layanan konsultasi</p>
            </div>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Harga Diskon
                (Rp)</label>
              <input type="text" inputmode="numeric" class="format-rupiah" name="sale_price" value="{{ old('sale_price', isset($s) && $s->sale_price > 0 ? number_format((float)$s->sale_price, 0, '', '.') : '') }}"
                placeholder="Contoh: 1.250.000 (Opsional)"
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
              <input type="text" name="sku" value="{{ old('sku', $s?->sku) }}" placeholder="Contoh: SKU-CV60-MAIN"
                style="width:100%;padding:.75rem 1rem;background:#F8FAFC;border:1.5px solid #E4E7F0;border-radius:10px;font-size:.9rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
            </div>
          </div>
        </div>

        {{-- â•â•â• VARIAN PRODUK (SHOPEE-STYLE) â•â•â• --}}
        <div
          style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);margin-bottom:1.5rem;"
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
              <p style="font-size:.72rem;color:#94A3B8;margin:.1rem 0 0;">Maks. 2 variasi. Setiap kombinasi punya harga
                &amp; stok tersendiri.</p>
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
            </div>

            {{-- Bulk Action Bar --}}
            <div
              style="background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:12px;padding:.875rem 1rem;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
              <span style="font-size:.75rem;font-weight:700;color:#475569;flex-shrink:0;">Terapkan ke semua:</span>
              <div
                style="display:flex;align-items:center;background:#fff;border:1.5px solid #CBD5E1;border-radius:8px;overflow:hidden;width:130px;">
                <span
                  style="font-size:.72rem;color:#64748B;padding:0 .45rem;background:#F1F5F9;height:34px;display:flex;align-items:center;border-right:1px solid #CBD5E1;font-weight:600;">Rp</span>
                <input type="text" class="format-rupiah" inputmode="numeric" id="bulk-price" placeholder="Harga (Rp)"
                  style="width:100%;border:none;padding:0 .45rem;font-size:.78rem;outline:none;height:34px;">
              </div>
              <input type="number" id="bulk-stock" placeholder="Stok" min="0"
                style="width:80px;height:34px;border:1.5px solid #CBD5E1;border-radius:8px;padding:0 .5rem;font-size:.78rem;outline:none;">
              <div
                style="display:flex;align-items:center;background:#fff;border:1.5px solid #CBD5E1;border-radius:8px;overflow:hidden;width:120px;">
                <input type="number" id="bulk-ship" placeholder="Dikirim" min="1" value="2"
                  style="width:100%;border:none;padding:0 .45rem;font-size:.78rem;outline:none;height:34px;">
                <span
                  style="font-size:.7rem;color:#64748B;padding:0 .45rem;background:#F1F5F9;height:34px;display:flex;align-items:center;border-left:1px solid #CBD5E1;white-space:nowrap;font-weight:600;">hari</span>
              </div>
              <input type="text" id="bulk-sku" placeholder="Kode Variasi"
                style="width:120px;height:34px;border:1.5px solid #CBD5E1;border-radius:8px;padding:0 .5rem;font-size:.78rem;outline:none;">
              <button type="button" onclick="applyBulk()"
                style="height:34px;padding:0 1rem;background:#1B6FE8;color:#fff;border:none;border-radius:8px;font-size:.78rem;font-weight:700;cursor:pointer;transition:background .2s;"
                onmouseover="this.style.background='#1254C0'" onmouseout="this.style.background='#1B6FE8'">Terapkan
              </button>
            </div>

            {{-- Info box --}}
            <div
              style="background:#FFFBEB;border:1px solid #FCD34D;border-radius:10px;padding:.75rem 1rem;margin-bottom:1rem;font-size:.76rem;color:#92400E;line-height:1.5;">
              <strong>Dikirim Dalam</strong> default 2 hari kerja. Untuk pre-order atur 3-30 hari. Kolom wajib <span
                style="color:#EF4444;">*</span> harus diisi â€” jika kosong akan ditandai merah saat simpan.
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
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:80px;">
                      Stok <span style="color:#EF4444;">*</span></th>
                    <th
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:100px;">
                      Dikirim Dalam <span style="color:#EF4444;">*</span></th>
                    <th
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:110px;">
                      Kode Variasi</th>
                    <th
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:110px;">
                      GTIN</th>
                    <th
                      style="padding:.6rem .75rem;text-align:left;font-weight:700;color:#475569;white-space:nowrap;border-bottom:1.5px solid #E4E7F0;min-width:140px;">
                      Foto Variasi</th>
                  </tr>
                </thead>
                <tbody id="combo-tbody"></tbody>
              </table>
            </div>

            {{-- Min. Jumlah Pembelian --}}
            <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px dashed #E2E8F0;">
              <label style="display:block;font-size:.8rem;font-weight:700;color:#1E293B;margin-bottom:.4rem;">
                <span style="color:#EF4444;">*</span> Min. Jumlah Pembelian
              </label>
              <input type="number" name="min_order_variant" value="{{ old('min_order', $s->min_order ?? 1) }}" min="1"
                style="width:100%;max-width:280px;padding:.55rem .8rem;border:1.5px solid #CBD5E1;border-radius:8px;font-size:.85rem;color:#1E293B;outline:none;"
                onfocus="this.style.borderColor='#1B6FE8'" onblur="this.style.borderColor='#CBD5E1'">
              <p style="font-size:.72rem;color:#94A3B8;margin:.3rem 0 0;line-height:1.4;">Min. jumlah yang harus dipesan
                Pembeli. Pembeli tidak dapat memesan jika stok &lt; min. jumlah pembelian.</p>
            </div>
          </div>

        </div>

        {{-- Spesifikasi Produk --}}
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
            @php $specs = old('spec_keys', []);
            $specVals = old('spec_values', []); @endphp
            @foreach($specs as $idx => $k)
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
            @endforeach
            @if(count($specs) === 0)
              <div id="specs-empty"
                style="text-align:center;padding:2rem;color:#94A3B8;font-size:.875rem;border:2px dashed #E4E7F0;border-radius:10px;">
                Belum ada spesifikasi. Klik "Tambah Baris" untuk mulai.
              </div>
            @endif
          </div>
        </div>

        {{-- FAQ --}}
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
            @php $faqs = old('faq_qs', []);
            $faqAs = old('faq_as', []); @endphp
            @foreach($faqs as $idx => $q)
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
            @endforeach
          </div>
        </div>

        @include('admin.partials.seo-fields', ['item' => $s])

      </div>

      {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• RIGHT COLUMN â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
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
            {{ $s ? 'Update Layanan' : 'Simpan Layanan' }}
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
            {{-- Toggle aktif --}}
            <label
              style="display:flex;align-items:center;justify-content:space-between;cursor:pointer;padding:.875rem 1rem;background:#F8FAFC;border-radius:12px;border:1.5px solid #E4E7F0;">
              <div>
                <div style="font-size:.875rem;font-weight:700;color:#1E293B;">Aktif</div>
                <div style="font-size:.75rem;color:#94A3B8;margin-top:.1rem;">Tampil di website publik</div>
              </div>
              <div style="position:relative;">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $s?->is_active ?? true) ? 'checked' : '' }}
                  id="is_active_toggle" style="sr-only;position:absolute;opacity:0;width:0;height:0;"
                  onchange="updateToggle(this)">
                <div id="toggle-track" onclick="document.getElementById('is_active_toggle').click()"
                  style="width:44px;height:24px;border-radius:100px;cursor:pointer;transition:background .2s;position:relative;background:{{ old('is_active', $s?->is_active ?? true) ? '#3B82F6' : '#E4E7F0' }};">
                  <div id="toggle-thumb"
                    style="position:absolute;top:3px;left:{{ old('is_active', $s?->is_active ?? true) ? '23px' : '3px' }};width:18px;height:18px;background:#fff;border-radius:50%;transition:left .2s;box-shadow:0 1px 4px rgba(0,0,0,0.15);">
                  </div>
                </div>
              </div>
            </label>
            <div>
              <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Icon
                (opsional)</label>
              <input type="text" name="icon" value="{{ old('icon', $s?->icon) }}" placeholder="crane, hoist, lift..."
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
          <label style="display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.5rem;">Upload
            Brosur/Datasheet</label>
          <label
            style="display:flex;flex-direction:column;align-items:center;gap:.5rem;padding:1.25rem;border:2px dashed #E4E7F0;border-radius:12px;cursor:pointer;transition:all .2s;text-align:center;"
            onmouseover="this.style.borderColor='#3B82F6';this.style.background='#F8FAFF'"
            onmouseout="this.style.borderColor='#E4E7F0';this.style.background='transparent'">
            <svg width="24" height="24" fill="none" stroke="#94A3B8" stroke-width="1.5" viewBox="0 0 24 24">
              <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
              <polyline points="17 8 12 3 7 8" />
              <line x1="12" y1="3" x2="12" y2="15" />
            </svg>
            <span style="font-size:.8rem;color:#64748B;font-weight:600;">Klik untuk upload</span>
            <span style="font-size:.72rem;color:#94A3B8;">PDF, JPG, PNG â€” Maks 10MB</span>
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

          {{-- New gallery file previews --}}
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
          </div>
          <p style="font-size:.68rem;color:#94A3B8;margin:.5rem 0 0;text-align:center;">Foto yang ditambah 1 per 1 akan
            otomatis tersimpan &amp; terakumulasi.</p>
        </div>

      </div>
    </div>
  </form>

  {{-- CONFIRMATION MODAL --}}
  <div id="confirmModal"
    style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(15,23,42,0.6);z-index:9999;align-items:center;justify-content:center;opacity:0;transition:opacity 0.2s;">
    <div
      style="background:#fff;border-radius:20px;padding:2rem;max-width:420px;width:90%;box-shadow:0 25px 60px rgba(0,0,0,0.2);">
      <div style="font-size:1.5rem;margin-bottom:.75rem;">âš ï¸</div>
      <h3 style="font-size:1rem;font-weight:800;color:#1E293B;margin:0 0 .5rem;">Konfirmasi Simpan</h3>
      <p id="confirmMsg" style="font-size:.875rem;color:#475569;margin:0 0 1.5rem;line-height:1.6;"></p>
      <div style="display:flex;gap:.75rem;justify-content:flex-end;">
        <button onclick="closeConfirm()"
          style="padding:.6rem 1.25rem;background:#F1F5F9;color:#475569;border:none;border-radius:10px;font-size:.85rem;font-weight:700;cursor:pointer;">Batal</button>
        <button id="confirmOk"
          style="padding:.6rem 1.25rem;background:#3B82F6;color:#fff;border:none;border-radius:10px;font-size:.85rem;font-weight:700;cursor:pointer;">Simpan</button>
      </div>
    </div>
  </div>

  <script>
    /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
       HELPER FUNCTIONS (Slug, Specs, FAQs)
    â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
    function generateSlug(v) { return v.toLowerCase().replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-').replace(/-+/g, '-'); }
    function syncSlug() {
      const n = document.getElementById('name_input'), s = document.getElementById('slug_input');
      if (s && !s.dataset.manual && n) s.value = generateSlug(n.value);
    }
    function addSpecRow() {
      const c = document.getElementById('specs-container');
      const d = document.createElement('div');
      d.className = 'spec-row'; d.style.cssText = 'display:grid;grid-template-columns:1fr 2fr auto;gap:.5rem;align-items:center;';
      d.innerHTML = `<input type="text" name="spec_keys[]" placeholder="Spesifikasi" style="padding:.5rem .75rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.82rem;color:#1E293B;font-family:inherit;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
    <input type="text" name="spec_values[]" placeholder="Nilai" style="padding:.5rem .75rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.82rem;color:#1E293B;font-family:inherit;outline:none;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'">
    <button type="button" onclick="this.closest('.spec-row').remove()" style="width:30px;height:30px;background:rgba(239,68,68,0.08);border:none;border-radius:6px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;">
      <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>`;
      c.appendChild(d);
    }
    function addFaqRow() {
      const c = document.getElementById('faqs-container');
      c.insertAdjacentHTML('beforeend', `<div style="background:#F8FAFC;border-radius:10px;padding:.875rem;border:1px solid #E4E7F0;position:relative;">
      <button type="button" onclick="this.closest('div').remove()" style="position:absolute;top:.5rem;right:.5rem;width:26px;height:26px;background:rgba(239,68,68,0.08);border:none;border-radius:6px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
      <div style="margin-bottom:.5rem;"><input type="text" name="faq_qs[]" placeholder="Pertanyaan?" style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;padding-right:2.5rem;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'"></div>
      <textarea name="faq_as[]" rows="2" placeholder="Jawaban lengkap..." style="width:100%;padding:.625rem .875rem;background:#fff;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.875rem;color:#1E293B;font-family:inherit;outline:none;resize:vertical;box-sizing:border-box;" onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E4E7F0'"></textarea>
    </div>`);
    }

    /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
       GALLERY HELPERS
    â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
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

    /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
       CONFIRM MODAL
    â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
    let confirmCallback = null;
    function showConfirm(msg, cb) {
      document.getElementById('confirmMsg').textContent = msg;
      confirmCallback = cb;
      const m = document.getElementById('confirmModal');
      m.style.display = 'flex';
      requestAnimationFrame(() => m.style.opacity = '1');
    }
    function closeConfirm() {
      const m = document.getElementById('confirmModal');
      m.style.opacity = '0';
      setTimeout(() => m.style.display = 'none', 200);
    }
    document.getElementById('confirmOk').onclick = function () { closeConfirm(); if (confirmCallback) confirmCallback(); };

    function submitProductForm(action) {
      const form = document.getElementById('product-form');
      if (!form) return;
      let hi = form.querySelector('input[name="submit_action"]');
      if (!hi) { hi = document.createElement('input'); hi.type = 'hidden'; hi.name = 'submit_action'; form.appendChild(hi); }
      hi.value = action;
      const activeInputs = form.querySelectorAll('input[required]:not([disabled]),textarea[required]:not([disabled]),select[required]:not([disabled])');
      let missing = [];
      activeInputs.forEach(inp => { if (!inp.value.trim()) missing.push(inp.placeholder || inp.name); });
      if (missing.length) {
        showConfirm('Beberapa field wajib belum diisi:\n- ' + missing.slice(0, 3).join('\n- ') + (missing.length > 3 ? '\n... dan ' + (missing.length - 3) + ' lainnya' : ''), () => form.submit());
        return;
      }
      form.submit();
    }

    /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
       VARIAN SHOPEE-STYLE (UNIFIED - BLUE THEME)
    â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
    let VGS = [];
    let nextGid = 1;
    let nextVid = 1;
    window._savedCombos = {};

    function addVarGroup() {
      if (VGS.length >= 2) { alert('Maksimal 2 variasi.'); return; }
      const gid = nextGid++;
      VGS.push({ gid, name: '', values: [], existingId: null });
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
      const inp = document.getElementById('tag-inp-' + gid);
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
      if (g) { g.values = g.values.filter(v => v.vid !== vid); renderVGS(); }
    }

    function renderVGS() {
      const list = document.getElementById('vg-list');
      const btnAdd = document.getElementById('btn-add-vg');
      if (!list || !btnAdd) return;
      btnAdd.style.display = VGS.length >= 2 ? 'none' : 'inline-flex';
      if (VGS.length === 0) {
        list.innerHTML = '<div style="font-size:.78rem;color:#94A3B8;padding:.5rem 0;">Belum ada variasi. Klik <strong>+ Tambah Variasi</strong> untuk membuat varian.</div>';
        renderMatrix(); return;
      }
      const placeholders = [
        ['Warna', 'Merah, Biru, Hijau (Enter atau + Tambah)'],
        ['Ukuran', 'S, M, L, XL (pisah koma)']
      ];
      list.innerHTML = VGS.map((g, idx) => {
        const ph = placeholders[idx] || ['Variasi', 'Nilai variasi...'];
        return `<div style="border:1.5px solid #E2E8F0;border-radius:14px;padding:1.1rem;background:#F8FAFC;">${renderVGContent(g, ph, idx + 1)}</div>`;
      }).join('');
      VGS.forEach(g => {
        const inp = document.getElementById('tag-inp-' + g.gid);
        if (inp) inp.onkeydown = e => { if (e.key === 'Enter') { e.preventDefault(); addTagValue(g.gid); } };
      });
      renderMatrix();
    }

    function renderVGContent(g, ph, num) {
      const tagsHTML = g.values.map(v => `
      <span style="display:inline-flex;align-items:center;gap:.35rem;background:#EFF6FF;color:#1D4ED8;border:1px solid #BFDBFE;padding:.3rem .65rem;border-radius:20px;font-size:.78rem;font-weight:600;">
        ${escHtml(v.label)}
        <button type="button" onclick="removeTagValue(${g.gid},${v.vid})" style="background:none;border:none;color:#1D4ED8;cursor:pointer;padding:0;font-size:.85rem;line-height:1;font-weight:700;">&times;</button>
      </span>`).join('');
      const hiddenInputs = g.values.map((v) => `
      <input type="hidden" name="variant_options[g${g.gid}][values][v${v.vid}][value]" value="${escHtml(v.label)}">
      ${v.existingId ? `<input type="hidden" name="variant_options[g${g.gid}][values][v${v.vid}][existing_id]" value="${v.existingId}">` : ''}
    `).join('');
      return `
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;">
        <span style="font-size:.72rem;font-weight:800;color:#1B6FE8;letter-spacing:.06em;text-transform:uppercase;">VARIASI ${num}</span>
        <button type="button" onclick="removeVarGroup(${g.gid})" style="width:26px;height:26px;background:rgba(239,68,68,0.08);border:none;border-radius:6px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
      <div style="margin-bottom:.75rem;">
        <label style="font-size:.72rem;font-weight:700;color:#64748B;display:block;margin-bottom:.35rem;">Nama Variasi *</label>
        <input type="text" name="variant_options[g${g.gid}][name]"
          ${g.existingId ? `data-existing="${g.existingId}"` : ''}
          placeholder="${ph[0]}" value="${escHtml(g.name)}"
          oninput="onGroupNameChange(${g.gid}, this.value)"
          style="width:100%;padding:.5rem .75rem;border:1.5px solid #E4E7F0;border-radius:9px;font-size:.85rem;color:#1E293B;font-family:inherit;outline:none;box-sizing:border-box;"
          onfocus="this.style.borderColor='#1B6FE8'" onblur="this.style.borderColor='#E4E7F0'">
      </div>
      <div style="margin-bottom:.6rem;">
        <label style="font-size:.72rem;font-weight:700;color:#64748B;display:block;margin-bottom:.35rem;">Opsi Nilai *</label>
        <div style="display:flex;gap:.4rem;align-items:center;">
          <input id="tag-inp-${g.gid}" type="text" placeholder="${ph[1]}"
            style="flex:1;padding:.5rem .75rem;border:1.5px solid #E4E7F0;border-radius:9px;font-size:.82rem;color:#1E293B;font-family:inherit;outline:none;"
            onfocus="this.style.borderColor='#1B6FE8'" onblur="this.style.borderColor='#E4E7F0'">
          <button type="button" onclick="addTagValue(${g.gid})" style="padding:.5rem .85rem;background:#1B6FE8;color:#fff;border:none;border-radius:9px;font-size:.78rem;font-weight:700;cursor:pointer;white-space:nowrap;">+ Tambah</button>
        </div>
      </div>
      <div style="display:flex;flex-wrap:wrap;gap:.35rem;min-height:20px;">${tagsHTML}</div>
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
      if (g2 && g2.values.length > 0) { thV2.style.display = ''; thV2.textContent = g2.name || 'Variasi 2'; }
      else { thV2.style.display = 'none'; }

      const v2list = (g2 && g2.values.length > 0) ? g2.values : [null];
      let rowIndex = 0, html = '';

      g1.values.forEach(v1 => {
        v2list.forEach(v2 => {
          const savedKey = `${v1.vid}_${v2 ? v2.vid : 'x'}`;
          const saved = window._savedCombos && window._savedCombos[savedKey];
          const price = saved ? saved.price : '';
          const displayPrice = price !== '' ? formatRupiahStr(price) : '';
          const stock = saved ? saved.stock : '';
          const ship = saved ? (saved.ship || 2) : 2;
          const sku = saved ? (saved.sku || '') : '';
          const gtin = saved ? (saved.gtin || '') : '';
          const combId = saved ? saved.id : '';
          const bg = rowIndex % 2 === 0 ? '#fff' : '#FAFBFF';

          html += `<tr style="background:${bg};" data-row="${rowIndex}">
          <td style="padding:.55rem .75rem;border-bottom:1px solid #F1F5F9;">
            <span style="display:inline-block;background:#EFF6FF;color:#1D4ED8;padding:.2rem .55rem;border-radius:20px;font-size:.73rem;font-weight:600;">${escHtml(v1.label)}</span>
          </td>
          ${v2 ? `<td style="padding:.55rem .75rem;border-bottom:1px solid #F1F5F9;">
            <span style="display:inline-block;background:#F0F9FF;color:#0369A1;padding:.2rem .55rem;border-radius:20px;font-size:.73rem;font-weight:600;">${escHtml(v2.label)}</span>
          </td>` : ''}
          <td style="padding:.4rem .6rem;border-bottom:1px solid #F1F5F9;">
            <input type="text" class="format-rupiah" inputmode="numeric" name="variant_options[combinations][${rowIndex}][price]"
              value="${escHtml(displayPrice)}" placeholder="0"
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
            <div style="display:flex;align-items:center;border:1.5px solid #E4E7F0;border-radius:8px;overflow:hidden;min-width:90px;">
              <input type="number" name="variant_options[combinations][${rowIndex}][ship_days]"
                value="${escHtml(ship)}" placeholder="2" min="1" max="30"
                style="width:100%;padding:.4rem .45rem;border:none;font-size:.8rem;font-family:inherit;outline:none;"
                onfocus="this.parentElement.style.borderColor='#1B6FE8'" onblur="this.parentElement.style.borderColor='#E4E7F0';validateRequired(this)" required>
              <span style="font-size:.7rem;color:#64748B;padding:0 .4rem;background:#F1F5F9;height:34px;display:flex;align-items:center;border-left:1px solid #E4E7F0;white-space:nowrap;">hari</span>
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
              style="width:100%;min-width:100px;padding:.4rem .55rem;border:1.5px solid #E4E7F0;border-radius:8px;font-size:.8rem;font-family:inherit;outline:none;"
              onfocus="this.style.borderColor='#1B6FE8'" onblur="this.style.borderColor='#E4E7F0'">
          </td>
          <td style="padding:.4rem .6rem;border-bottom:1px solid #F1F5F9;">
            <div style="display:flex;align-items:center;gap:.4rem;">
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
  </script>
@endsection