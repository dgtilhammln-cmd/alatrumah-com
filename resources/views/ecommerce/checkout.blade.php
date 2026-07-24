@extends('layouts.app')

@section('content')
<style>
:root{--c-bg:#ffffff;--c-surface:#F8FAFC;--c-card:#ffffff;--c-border:#E2E8F0;--c-text:#0F172A;--c-muted:#64748B;--c-accent:#0EA5E9;--font:'Montserrat',sans-serif;}
body{background:var(--c-bg);}

.co-wrap{max-width:1200px;margin:100px auto 4rem;padding:0 1.5rem;font-family:var(--font);}
.co-grid{display:grid;grid-template-columns:1fr 400px;gap:2rem;align-items:start;}

.co-section{background:var(--c-card);border:1px solid var(--c-border);border-radius:16px;padding:1.75rem;}
.co-section-title{font-size:1.1rem;font-weight:700;color:var(--c-text);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem;}

.form-group{margin-bottom:1.25rem;}
.form-label{display:block;font-size:0.85rem;font-weight:600;color:var(--c-text);margin-bottom:0.5rem;}
.form-input{width:100%;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:0.75rem 1rem;font-size:0.9rem;color:#0F172A;transition:all 0.2s;}
.form-input:focus{outline:none;border-color:#0EA5E9;box-shadow:0 0 0 3px rgba(14,165,233,0.1);background:#fff;}
select.form-input{appearance:none;background-image:url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");background-repeat:no-repeat;background-position:right 1rem center;background-size:1em;}

.summary-item{display:flex;gap:1rem;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px dashed #E2E8F0;}
.summary-img{width:60px;height:60px;border-radius:8px;object-fit:cover;background:#F1F5F9;}
.summary-title{font-size:0.9rem;font-weight:600;color:var(--c-text);line-height:1.3;}
.summary-meta{font-size:0.8rem;color:var(--c-muted);margin-top:0.25rem;}
.summary-price{font-size:0.9rem;font-weight:700;color:var(--c-accent);}

.summary-row{display:flex;justify-content:space-between;font-size:0.9rem;color:var(--c-muted);margin-bottom:0.5rem;}
.summary-total{display:flex;justify-content:space-between;font-size:1.1rem;font-weight:800;color:var(--c-text);margin-top:1rem;padding-top:1rem;border-top:1px solid var(--c-border);}

.btn-pay{display:block;width:100%;background:var(--c-text);color:#fff;border:none;border-radius:999px;padding:1rem;font-size:1rem;font-weight:700;cursor:pointer;transition:all 0.2s;text-align:center;margin-top:1.5rem;}
.btn-pay:hover{background:#000;transform:translateY(-2px);box-shadow:0 10px 20px rgba(0,0,0,0.1);}

@media(max-width:991px){
    .co-grid{grid-template-columns:1fr;}
    .co-wrap{margin-top:80px;}
}

/* SweetAlert2 custom theme */
.swal2-border-radius { border-radius: 20px !important; font-family: 'Montserrat', sans-serif !important; }
.swal2-title { font-family: 'Montserrat', sans-serif !important; }
.swal2-html-container { font-family: 'Montserrat', sans-serif !important; }
.swal2-confirm { border-radius: 999px !important; font-family: 'Montserrat', sans-serif !important; font-weight: 700 !important; padding: 0.75rem 2rem !important; }

@keyframes spin { 100% { transform: rotate(360deg); } }

/* Service card: hilangkan outline/garis kuning bawaan browser */
.service-card { outline: none !important; }
.service-card:focus { outline: none !important; box-shadow: none !important; }
.service-card input[type="radio"]:focus { outline: none !important; box-shadow: none !important; }
</style>

<div class="co-wrap">
    @if(session('error'))
        <div style="background:#FEF2F2;border:1px solid #FCA5A5;color:#B91C1C;padding:1rem;border-radius:10px;margin-bottom:1.5rem;font-size:0.9rem;">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="background:#FEF2F2;border:1px solid #FCA5A5;color:#B91C1C;padding:1rem;border-radius:10px;margin-bottom:1.5rem;font-size:0.9rem;">
            <ul style="margin:0;padding-left:1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="co-grid">
            <div class="co-left">
                
                @guest
                {{-- GUEST CHECKOUT / AUTO REGISTER --}}
                <div class="co-section" style="margin-bottom:1.5rem;">
                    <div class="co-section-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Informasi Akun (Buat Akun Baru)
                    </div>
                    <p style="font-size:0.85rem;color:var(--c-muted);margin-bottom:1rem;">Anda belum masuk. Silakan lengkapi data di bawah ini untuk otomatis membuat akun saat checkout.</p>
                    
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="guest_name" class="form-input" value="{{ old('guest_name') }}" required placeholder="Nama Lengkap">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="guest_email" class="form-input" value="{{ old('guest_email') }}" required placeholder="email@contoh.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. WhatsApp</label>
                            <input type="text" name="guest_phone" class="form-input" value="{{ old('guest_phone') }}" required placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Buat Password</label>
                        <input type="password" name="guest_password" class="form-input" required placeholder="Minimal 6 karakter">
                    </div>
                </div>
                @endguest

                {{-- ALAMAT PENGIRIMAN --}}
                @if($summary['has_physical_product'])
                <div class="co-section" style="margin-bottom:1.5rem;">
                    <div class="co-section-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Alamat Pengiriman
                    </div>
                    
                    @if(auth()->check() && $addresses->count() > 0)
                        <div class="form-group">
                            <label class="form-label">Pilih Alamat Tersimpan</label>
                            <select name="address_id" id="address_id_select" class="form-input" onchange="toggleNewAddress()">
                                @foreach($addresses as $addr)
                                    <option value="{{ $addr->id }}"
                                        data-city="{{ $addr->city }}"
                                        data-province="{{ $addr->province }}">
                                        {{ $addr->label }} - {{ $addr->receiver_name }} ({{ $addr->city }}, {{ $addr->province }})
                                    </option>
                                @endforeach
                                <option value="new">+ Tambah Alamat Baru</option>
                            </select>
                        </div>

                        {{-- City selector for ongkir (shown only when using saved address) --}}
                        <div id="saved_addr_city_wrap" style="margin-top:0;">
                            <div style="background:#FFF9EC;border:1px dashed #F59E0B;border-radius:12px;padding:1rem 1.25rem;">
                                <p style="font-size:0.82rem;font-weight:700;color:#92400E;margin:0 0 0.75rem; display:flex; align-items:center; gap:6px;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 18H3a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2"/><path d="M19 8h-4v6h4l3 3v-5l-3-3z"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                                    Pilih Kota Tujuan untuk Kalkulasi Ongkir
                                </p>
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                                    <div>
                                        <label class="form-label" style="font-size:0.78rem;">Provinsi</label>
                                        <select id="saved_province_select" class="form-input" style="font-size:0.85rem;">
                                            <option value="">Loading...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label" style="font-size:0.78rem;">Kota / Kabupaten</label>
                                        <select id="saved_city_select" class="form-input" style="font-size:0.85rem;">
                                            <option value="">Pilih Provinsi Dulu</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" id="saved_city_id" value="">
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="address_id" id="address_id_select" value="new">
                    @endif

                    <div id="new_address_form" style="{{ (auth()->check() && $addresses->count() > 0) ? 'display:none;margin-top:1.5rem;padding-top:1.5rem;border-top:1px dashed #E2E8F0;' : '' }}">
                        
                        <div style="margin-bottom:1.5rem;background:#F0F9FF;border:1px dashed #BAE6FD;padding:1.25rem;border-radius:12px;display:flex;flex-direction:column;gap:0.75rem;align-items:flex-start;">
                            <div style="font-size:0.9rem;font-weight:600;color:#0369A1;">Opsi Otomatis (Rekomendasi)</div>
                            <div style="font-size:0.8rem;color:#0C4A6E;margin-top:-0.5rem;">Izinkan akses GPS untuk mengisi alamat lengkap Anda secara otomatis (Akurat & Realtime).</div>
                            <button type="button" id="btn_get_location" onclick="getLocation()" style="background:#0EA5E9;color:#fff;border:none;border-radius:8px;padding:0.6rem 1rem;font-size:0.85rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:0.5rem;transition:background 0.2s;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                                Gunakan Lokasi Saat Ini (GPS)
                            </button>
                            <div id="loc_status" style="font-size:0.75rem;font-weight:600;color:var(--c-muted);display:none;"></div>
                        </div>

                        <!-- HIDDEN COORDS -->
                        <input type="hidden" name="new_address_lat" id="new_addr_lat">
                        <input type="hidden" name="new_address_lng" id="new_addr_lng">

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                            <div class="form-group">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" name="new_address_receiver" id="new_addr_receiver" class="form-input" placeholder="Nama penerima paket">
                            </div>
                            <div class="form-group">
                                <label class="form-label">No. Telepon Penerima</label>
                                <input type="text" name="new_address_phone" id="new_addr_phone" class="form-input" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        {{-- Indo Regions API --}}
                        <input type="hidden" name="new_address_province" id="province_name">
                        <input type="hidden" name="new_address_city" id="city_name">

                        <div class="form-group">
                            <label class="form-label">Provinsi</label>
                            <select id="province_select" class="form-input">
                                <option value="">Loading Provinsi...</option>
                            </select>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                            <div class="form-group">
                                <label class="form-label">Kota / Kabupaten</label>
                                <select id="city_select" class="form-input">
                                    <option value="">Pilih Provinsi Dulu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" name="new_address_district" id="district_name" class="form-input" placeholder="Nama kecamatan">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="new_address_postal" id="new_addr_postal" class="form-input" placeholder="Kode Pos">
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label">Alamat Lengkap (Nama Jalan, Gedung, RT/RW)</label>
                            <textarea name="new_address_full" id="new_addr_full" class="form-input" rows="3" placeholder="Masukkan detail alamat lengkap..."></textarea>
                        </div>
                    </div>
                </div>
                @endif

                {{-- ALAMAT JASA --}}
                @if($summary['has_service'])
                <div class="co-section" style="margin-bottom:1.5rem;">
                    <div class="co-section-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 9.36l-7.1 7.1a1 1 0 0 1-1.4 0l-2.8-2.8a1 1 0 0 1 0-1.4l7.1-7.1a6 6 0 0 1 9.36-7.94l-3.77 3.77z"/></svg>
                        Lokasi Pengerjaan Jasa
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Deskripsikan lokasi selengkap-lengkapnya</label>
                        <textarea name="service_address" class="form-input" rows="3" placeholder="Contoh: Gedung A lantai 2, ruang meeting..." {{ $summary['has_physical_product'] ? '' : 'required' }}></textarea>
                    </div>
                </div>
                @endif

                {{-- METODE PENGIRIMAN --}}
                @if($summary['has_physical_product'])
                <div class="co-section" style="margin-bottom:1.5rem;">
                    <div class="co-section-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        Pilih Metode Pengiriman
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Pilih Kurir</label>
                        <select name="courier_name" id="courier_name_select" class="form-input" required>
                            <option value="">Pilih kurir pengiriman...</option>
                            @forelse($couriers ?? [] as $courier)
                                <option value="{{ $courier->code }}">{{ $courier->name }}</option>
                            @empty
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">TIKI</option>
                            @endforelse
                        </select>

                        <div id="ongkir_loading" style="display:none; align-items:center; gap:0.5rem; font-size:0.85rem; color:#0EA5E9; margin-top:1rem; font-weight:600;">
                            <svg style="animation: spin 1s linear infinite;" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path></svg>
                            Menghitung ongkir...
                        </div>

                        <div id="courier_service_container" style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                            <!-- Default empty state -->
                            <div style="padding: 1rem; border: 1px dashed #CBD5E1; border-radius: 10px; background: #F8FAFC; color: #64748B; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Pilih kota dan kurir terlebih dahulu untuk melihat opsi pengiriman.
                            </div>
                        </div>

                        <!-- Hidden input required for form submission -->
                        <input type="hidden" name="courier_service" id="courier_service_hidden" required>
                    </div>
                </div>
                @endif
                
                {{-- CATATAN --}}
                <div class="co-section">
                    <div class="co-section-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Catatan (Opsional)
                    </div>
                    <div class="form-group mb-0">
                        <textarea name="notes" class="form-input" rows="2" placeholder="Pesan untuk penjual..."></textarea>
                    </div>
                </div>
            </div>

            <div class="co-right">
                <div class="co-section" style="position:sticky;top:100px;">
                    <div class="co-section-title">Ringkasan Pesanan</div>
                    
                    <div style="margin-bottom:1.5rem;">
                        @foreach($summary['items'] as $item)
                            <div class="summary-item">
                                @if($item->product && !empty($item->product->image))
                                    <img src="{{ asset('storage/'.$item->product->image) }}" class="summary-img">
                                @else
                                    <div class="summary-img" style="display:flex;align-items:center;justify-content:center;color:#94A3B8;">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                @endif
                                <div style="flex:1;">
                                    <div class="summary-title">{{ $item->product->name ?? 'Produk Telah Dihapus' }}</div>
                                    <div class="summary-meta">{{ $item->qty }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                                    <div class="summary-price mt-1">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="shipping_cost" value="0" id="shipping_cost_input">

                    <div class="summary-row">
                        <span>Total Harga Barang</span>
                        <span>Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
                    </div>

                    @if($summary['has_physical_product'])
                    <div class="summary-row" id="ongkir-row">
                        <span>Ongkos Kirim</span>
                        <span id="ongkir-row-val" style="color:#0EA5E9; font-weight:600; font-size:0.8rem;">Pilih Lokasi & Kurir</span>
                    </div>
                    @endif

                    <div class="form-group" style="margin-top:1.5rem;">
                        <label class="form-label">Kode Kupon (Opsional)</label>
                        <input type="text" name="coupon_code" class="form-input" placeholder="Masukkan kode promo">
                    </div>

                    <div class="summary-total">
                        <span>Total Belanja</span>
                        <span id="total-row-val">Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn-pay" onclick="prepareSubmit(event)">Pilih Pembayaran</button>
                    
                    <div style="display:flex;align-items:center;justify-content:center;gap:0.5rem;margin-top:1.5rem;color:var(--c-muted);font-size:0.75rem;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Pembayaran 100% Aman & Terenkripsi
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const subtotal = {{ $summary['subtotal'] }};
    const totalWeight = {{ $summary['total_weight'] > 0 ? $summary['total_weight'] : 1000 }};
    
    let selectedCost = 0;
    let allProvinces = [];

    // ────────────────────────────────────────────
    // INIT
    // ────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function() {
        toggleNewAddress();
        loadProvincesAll();
    });

    // ────────────────────────────────────────────
    // LOAD PROVINCES — shared for both flows
    // ────────────────────────────────────────────
    function loadProvincesAll() {
        fetch(`{{ route('api.rajaongkir.provinces') }}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) throw new Error(data.error);
                allProvinces = data;

                const provSelect = document.getElementById('province_select');
                const savedProvSelect = document.getElementById('saved_province_select');

                if (provSelect) {
                    provSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                    data.forEach(prov => provSelect.add(new Option(prov.province, prov.province_id)));
                }

                if (savedProvSelect) {
                    savedProvSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                    data.forEach(prov => savedProvSelect.add(new Option(prov.province, prov.province_id)));
                }
                
                // Now that provinces are loaded, try to auto-match saved address
                toggleNewAddress();
            })
            .catch(err => {
                console.error('Provinces API Error:', err);
                toggleNewAddress(); // still run to handle display logic
            });
    }

    // ────────────────────────────────────────────
    // NEW-ADDRESS FLOW: Province → City
    // ────────────────────────────────────────────
    document.getElementById('province_select')?.addEventListener('change', function() {
        const text = this.options[this.selectedIndex].text;
        document.getElementById('province_name').value = this.value ? text : '';
        loadCitiesInto('city_select', this.value, null);
        resetShipping();
    });

    document.getElementById('city_select')?.addEventListener('change', function() {
        const text = this.options[this.selectedIndex].text;
        document.getElementById('city_name').value = this.value ? text : '';
        resetShipping();
        if (this.value && document.getElementById('courier_name_select')?.value) {
            checkCost();
        }
    });

    // ────────────────────────────────────────────
    // SAVED-ADDRESS FLOW: Province → City
    // ────────────────────────────────────────────
    document.getElementById('saved_province_select')?.addEventListener('change', function() {
        loadCitiesInto('saved_city_select', this.value, null);
        document.getElementById('saved_city_id').value = '';
        resetShipping();
    });

    document.getElementById('saved_city_select')?.addEventListener('change', function() {
        document.getElementById('saved_city_id').value = this.value;
        resetShipping();
        if (this.value && document.getElementById('courier_name_select')?.value) {
            checkCost();
        }
    });

    // ────────────────────────────────────────────
    // SHARED: Load cities into any select
    // ────────────────────────────────────────────
    function loadCitiesInto(selectId, provId, preselectedCityId, matchCityName = null) {
        const citySelect = document.getElementById(selectId);
        if (!citySelect) return;
        if (!provId) {
            citySelect.innerHTML = '<option value="">Pilih Provinsi Dulu</option>';
            return;
        }
        citySelect.innerHTML = '<option value="">Memuat kota...</option>';
        return fetch(`{{ url('/api/rajaongkir/cities') }}/${provId}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) throw new Error(data.error);
                citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                data.forEach(city => {
                    const type = city.type === 'Kabupaten' ? 'Kab.' : 'Kota';
                    const opt = new Option(`${type} ${city.city_name}`, city.city_id);
                    citySelect.add(opt);
                });
                
                // Match by text (for saved addresses)
                if (matchCityName) {
                    const target = matchCityName.toLowerCase().replace(/^(kota|kabupaten|kab\.)\s+/i, '').trim();
                    for (let i = 0; i < citySelect.options.length; i++) {
                        const optText = citySelect.options[i].text.toLowerCase().replace(/^(kota|kabupaten|kab\.)\s+/i, '').trim();
                        if (optText === target || optText.includes(target)) {
                            citySelect.value = citySelect.options[i].value;
                            citySelect.dispatchEvent(new Event('change'));
                            return true; // Match found
                        }
                    }
                }
                
                // Auto-select exact ID
                if (preselectedCityId) {
                    citySelect.value = preselectedCityId;
                    citySelect.dispatchEvent(new Event('change'));
                }
                return false;
            })
            .then(undefined, err => {
                citySelect.innerHTML = '<option value="">Gagal memuat kota — coba lagi</option>';
                return false;
            });
    }

    // ────────────────────────────────────────────
    // KURIR: Same trigger for both flows
    // ────────────────────────────────────────────
    document.getElementById('courier_name_select')?.addEventListener('change', function() {
        const cityId = getActiveCityId();
        if (cityId && this.value) {
            checkCost();
        } else {
            resetShipping();
        }
    });

    function getActiveCityId() {
        const addrSelect = document.getElementById('address_id_select');
        if (addrSelect && addrSelect.value && addrSelect.value !== 'new') {
            // Using saved address → use saved_city_id
            return document.getElementById('saved_city_id')?.value || '';
        } else {
            // Using new address → use city_select
            return document.getElementById('city_select')?.value || '';
        }
    }

    // ────────────────────────────────────────────
    // SHIPPING COST CALCULATION
    // ────────────────────────────────────────────
    function resetShipping() {
        const serviceContainer = document.getElementById('courier_service_container');
        if (serviceContainer) {
            serviceContainer.innerHTML = `
                <div style="padding: 1rem; border: 1px dashed #CBD5E1; border-radius: 10px; background: #F8FAFC; color: #64748B; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Pilih kota dan kurir terlebih dahulu untuk melihat opsi pengiriman.
                </div>
            `;
        }
        const hiddenInput = document.getElementById('courier_service_hidden');
        if (hiddenInput) hiddenInput.value = '';
        selectedCost = 0;
        updateTotal();
    }

    function checkCost() {
        const cityId  = getActiveCityId();
        const courier = document.getElementById('courier_name_select')?.value;
        const serviceContainer = document.getElementById('courier_service_container');
        const hiddenInput = document.getElementById('courier_service_hidden');
        const loadingEl = document.getElementById('ongkir_loading');

        if (!cityId || !courier) return;

        if (loadingEl) loadingEl.style.display = 'flex';
        serviceContainer.innerHTML = `
            <div style="padding: 1rem; border: 1px dashed #CBD5E1; border-radius: 10px; background: #F8FAFC; color: #0EA5E9; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem; font-weight:600;">
                <svg style="animation: spin 1s linear infinite;" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path></svg>
                Menghitung ongkir...
            </div>
        `;
        hiddenInput.value = '';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                       || '{{ csrf_token() }}';

        fetch(`{{ route('api.rajaongkir.cost') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                destination: parseInt(cityId),
                weight: totalWeight,
                courier: courier
            })
        })
        .then(res => {
            console.info('[ONGKIR] HTTP Status:', res.status);
            return res.json().then(data => ({ httpStatus: res.status, data }));
        })
        .then(({ httpStatus, data }) => {
            if (loadingEl) loadingEl.style.display = 'none';

            console.info('[ONGKIR] Response:', data);

            // Manual fallback: HANYA jika timeout/connection refused (bukan error API biasa)
            if (data.manual) {
                console.warn('[ONGKIR] Fallback manual. Debug:', data.debug_error);
                serviceContainer.innerHTML = `
                    <label class="service-card selected" style="cursor:pointer; display:flex; align-items:center; gap:1rem; padding:1rem; border:1px solid #0EA5E9; border-radius:10px; background:#F0F9FF;">
                        <input type="radio" name="courier_service_radio" value="manual" data-cost="0" checked style="accent-color:#0EA5E9; width:1.2rem; height:1.2rem;">
                        <div style="flex:1;">
                            <div style="font-weight:700; color:#0F172A; font-size:0.95rem;">Manual</div>
                            <div style="font-size:0.8rem; color:#64748B; margin-top:0.2rem;">Ongkir dikonfirmasi Admin setelah pesan</div>
                        </div>
                        <div style="font-weight:700; color:#0EA5E9; font-size:1rem;">Rp 0</div>
                    </label>
                `;
                hiddenInput.value = 'manual';
                hiddenInput.removeAttribute('required');
                selectedCost = 0;
                updateTotal('manual');
                attachRadioListeners();
                return;
            }

            // Error dari API (origin salah, kurir tidak tersedia, dll) — tampilkan, jangan silent fallback
            if (data.error) {
                console.warn('[ONGKIR] API error:', data.error);
                serviceContainer.innerHTML = `
                    <div style="padding: 1rem; border: 1px dashed #FCA5A5; border-radius: 10px; background: #FEF2F2; color: #B91C1C; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0zM12 9v4m0 4h.01"></path></svg>
                        ${data.error}
                    </div>
                `;
                hiddenInput.value = '';
                hiddenInput.removeAttribute('required');
                return;
            }

            // Validasi: harus array dan tidak kosong
            if (!Array.isArray(data) || data.length === 0) {
                console.warn('[ONGKIR] Data kosong atau bukan array:', data);
                serviceContainer.innerHTML = `
                    <label class="service-card selected" style="cursor:pointer; display:flex; align-items:center; gap:1rem; padding:1rem; border:1px solid #0EA5E9; border-radius:10px; background:#F0F9FF;">
                        <input type="radio" name="courier_service_radio" value="manual" data-cost="0" checked style="accent-color:#0EA5E9; width:1.2rem; height:1.2rem;">
                        <div style="flex:1;">
                            <div style="font-weight:700; color:#0F172A; font-size:0.95rem;">Manual</div>
                            <div style="font-size:0.8rem; color:#64748B; margin-top:0.2rem;">Ongkir dikonfirmasi Admin setelah pesan</div>
                        </div>
                        <div style="font-weight:700; color:#0EA5E9; font-size:1rem;">Rp 0</div>
                    </label>
                `;
                hiddenInput.value = 'manual';
                hiddenInput.removeAttribute('required');
                selectedCost = 0;
                updateTotal('manual');
                attachRadioListeners();
                return;
            }

            // SUCCESS — render semua pilihan layanan
            hiddenInput.setAttribute('required', 'required');
            let html = '';
            data.forEach((service, idx) => {
                const cost = service.cost[0]?.value ?? 0;
                const etd  = service.cost[0]?.etd  ? `${service.cost[0].etd} hari` : 'Estimasi tidak tersedia';
                const fmt  = new Intl.NumberFormat('id-ID').format(cost);
                
                // Tambahkan deskripsi agar pembeli gaptek mengerti
                let desc = service.description || '';
                if(service.service.toUpperCase() === 'JTR') desc = 'Layanan Kargo/Barang Berat (Lebih hemat)';
                if(service.service.toUpperCase() === 'REG' || service.service.toUpperCase() === 'EZ') desc = 'Layanan Standar Reguler';
                if(service.service.toUpperCase() === 'YES') desc = 'Layanan Cepat (Yakin Esok Sampai)';
                
                html += `
                    <label class="service-card" style="cursor:pointer; display:flex; align-items:center; gap:1rem; padding:1rem; border:1px solid #E2E8F0; border-radius:10px; background:#fff;">
                        <input type="radio" name="courier_service_radio" value="${service.service}" data-cost="${cost}" style="accent-color:#0EA5E9; width:1.2rem; height:1.2rem;">
                        <div style="flex:1;">
                            <div style="font-weight:700; color:#0F172A; font-size:0.95rem;">${service.service}</div>
                            <div style="font-size:0.8rem; color:#64748B; margin-top:0.2rem; display:flex; align-items:center; gap:0.3rem;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                ${desc}
                            </div>
                            <div style="font-size:0.8rem; color:#64748B; margin-top:0.2rem; display:flex; align-items:center; gap:0.3rem;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>
                                ${etd}
                            </div>
                        </div>
                        <div style="font-weight:800; color:#0EA5E9; font-size:1.1rem;">Rp ${fmt}</div>
                    </label>
                `;
            });
            serviceContainer.innerHTML = html;
            attachRadioListeners();
            console.info('[ONGKIR] Sukses:', data.length, 'layanan tampil.');
        })
        .catch(err => {
            // Hanya terjadi jika ada error JARINGAN di sisi browser (bukan response error)
            if (loadingEl) loadingEl.style.display = 'none';
            console.error('[ONGKIR] Fetch/jaringan error:', err);
            serviceContainer.innerHTML = `
                <label class="service-card selected" style="cursor:pointer; display:flex; align-items:center; gap:1rem; padding:1rem; border:1px solid #0EA5E9; border-radius:10px; background:#F0F9FF;">
                    <input type="radio" name="courier_service_radio" value="manual" data-cost="0" checked style="accent-color:#0EA5E9; width:1.2rem; height:1.2rem;">
                    <div style="flex:1;">
                        <div style="font-weight:700; color:#0F172A; font-size:0.95rem;">Manual</div>
                        <div style="font-size:0.8rem; color:#64748B; margin-top:0.2rem;">Ongkir dikonfirmasi Admin setelah pesan</div>
                    </div>
                    <div style="font-weight:700; color:#0EA5E9; font-size:1rem;">Rp 0</div>
                </label>
            `;
            hiddenInput.value = 'manual';
            hiddenInput.removeAttribute('required');
            selectedCost = 0;
            updateTotal('manual');
            attachRadioListeners();
        });
    }

    function attachRadioListeners() {
        const radios = document.querySelectorAll('input[name="courier_service_radio"]');
        const hiddenInput = document.getElementById('courier_service_hidden');
        
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Reset semua background card
                document.querySelectorAll('.service-card').forEach(card => {
                    card.style.borderColor = '#E2E8F0';
                    card.style.background = '#fff';
                });
                
                // Tambahkan styling di card yang dipilih
                if (this.checked) {
                    this.closest('.service-card').style.borderColor = '#0EA5E9';
                    this.closest('.service-card').style.background = '#F0F9FF';
                    
                    hiddenInput.value = this.value;
                    
                    if (this.value === 'manual') {
                        selectedCost = 0;
                        updateTotal('manual');
                    } else {
                        selectedCost = parseInt(this.dataset.cost) || 0;
                        updateTotal();
                    }
                }
            });
        });
    }

    function updateTotal(mode) {
        const input = document.getElementById('shipping_cost_input');
        if (input) input.value = selectedCost;
        
        const ongkirRowVal = document.getElementById('ongkir-row-val');
        if (ongkirRowVal) {
            if (mode === 'manual') {
                ongkirRowVal.innerText = 'Dikonfirmasi Admin';
                ongkirRowVal.style.color = '#F59E0B';
            } else {
                ongkirRowVal.innerText = selectedCost > 0
                    ? `Rp ${new Intl.NumberFormat('id-ID').format(selectedCost)}`
                    : 'Pilih kurir & layanan';
                ongkirRowVal.style.color = selectedCost > 0 ? '#1E293B' : '#0EA5E9';
            }
        }

        const totalRowVal = document.getElementById('total-row-val');
        if (totalRowVal) {
            const finalTotal = subtotal + selectedCost;
            totalRowVal.innerText = `Rp ${new Intl.NumberFormat('id-ID').format(finalTotal)}`;
        }
    }

    // Geolocation logic
    function getLocation() {
        const status = document.getElementById('loc_status');
        status.style.display = 'block';
        status.style.color = 'var(--c-muted)';
        status.innerText = 'Meminta izin lokasi GPS dari browser...';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError, { enableHighAccuracy: true });
        } else {
            status.style.color = '#EF4444';
            status.innerText = "GPS / Geolocation tidak didukung oleh browser Anda.";
        }
    }

    function showPosition(position) {
        const status = document.getElementById('loc_status');
        status.innerText = 'Mengambil alamat dari koordinat GPS...';
        
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        
        document.getElementById('new_addr_lat').value = lat;
        document.getElementById('new_addr_lng').value = lon;

        // Reverse geocoding via Nominatim
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1&accept-language=id`)
            .then(res => res.json())
            .then(data => {
                if (data && data.address) {
                    status.style.color = '#16A34A';
                    status.innerText = '✓ Lokasi berhasil ditemukan! Provinsi & Kota diisi otomatis.';
                    
                    const addr = data.address;
                    
                    // Fill address detail
                    document.getElementById('new_addr_full').value = data.display_name;
                    if (addr.postcode) document.getElementById('new_addr_postal').value = addr.postcode;
                    if (addr.village || addr.suburb || addr.town)
                        document.getElementById('district_name').value = addr.village || addr.suburb || addr.town || '';

                    // Auto-select Province from dropdown
                    const rawProv = addr.state || '';
                    const provSelect = document.getElementById('province_select');
                    let matchedProvId = null;
                    if (rawProv && provSelect) {
                        const targetP = rawProv.toLowerCase().replace(/^(provinsi|daerah istimewa|dki|daerah khusus)\s*/i,'').trim();
                        for (let i = 0; i < provSelect.options.length; i++) {
                            const optP = provSelect.options[i].text.toLowerCase().replace(/^(dki|daerah istimewa|daerah khusus)\s*/i,'').trim();
                            if (optP === targetP || optP.includes(targetP) || targetP.includes(optP)) {
                                matchedProvId = provSelect.options[i].value;
                                provSelect.value = matchedProvId;
                                provSelect.dispatchEvent(new Event('change'));
                                break;
                            }
                        }
                    }

                    // Auto-select City after cities load
                    if (matchedProvId) {
                        const rawCity = addr.city || addr.county || addr.town || '';
                        loadCitiesInto('city_select', matchedProvId, null, rawCity);
                    }
                } else {
                    status.style.color = '#EF4444';
                    status.innerText = 'Gagal mendapatkan detail alamat.';
                }
            })
            .catch(err => {
                status.style.color = '#EF4444';
                status.innerText = 'Gagal menterjemahkan koordinat GPS.';
            });
    }

    function updateMapAndAddress(lat, lon, showSwal = false) {
        // Legacy stub — no longer used (map removed)
    }

    function showError(error) {
        const status = document.getElementById('loc_status');
        status.style.color = '#EF4444';
        switch(error.code) {
            case error.PERMISSION_DENIED:
                status.innerText = "Anda menolak permintaan akses GPS.";
                break;
            case error.POSITION_UNAVAILABLE:
                status.innerText = "Informasi lokasi GPS tidak tersedia.";
                break;
            case error.TIMEOUT:
                status.innerText = "Waktu tunggu GPS habis (Timeout).";
                break;
            default:
                status.innerText = "Terjadi kesalahan tidak diketahui pada GPS.";
                break;
        }
    }



    function prepareSubmit(e) {
        const select = document.getElementById('address_id_select');
        if (select && select.value === 'new') {
            const provName = document.getElementById('province_name');
            const cityName = document.getElementById('city_name');
            const distName = document.getElementById('district_name');
            if (!provName.value || !cityName.value || !distName.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Mohon lengkapi pilihan Provinsi, Kota, dan Kecamatan.',
                    confirmButtonColor: '#0F172A',
                    confirmButtonText: 'Baiklah'
                });
                e.preventDefault();
                return;
            }
        } else if (select && select.value !== 'new') {
            // Saved address — check city id is selected
            const savedCityId = document.getElementById('saved_city_id')?.value;
            if (!savedCityId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Kota Tujuan',
                    text: 'Mohon pilih Provinsi dan Kota di bagian ongkir agar biaya pengiriman dapat dihitung.',
                    confirmButtonColor: '#0F172A'
                });
                e.preventDefault();
                return;
            }
        }

        if (document.getElementById('courier_name_select')) {
            const service = document.getElementById('courier_service_select')?.value;
            // Allow 'manual' value (when ongkir API is unreachable, admin confirms cost)
            if (!service) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Layanan Pengiriman',
                    text: 'Anda belum memilih layanan pengiriman (contoh: REG / YES).',
                    confirmButtonColor: '#0F172A'
                });
                e.preventDefault();
                return;
            }
        }
    }

    function toggleNewAddress() {
        const select = document.getElementById('address_id_select');
        const form   = document.getElementById('new_address_form');
        const savedWrap = document.getElementById('saved_addr_city_wrap');
        if (!select) return;

        const isNew = select.value === 'new';

        if (form) form.style.display = isNew ? 'block' : 'none';
        
        // Reset shipping when switching address
        resetShipping();

        if (isNew) {
            if (savedWrap) savedWrap.style.display = 'none';
        } else {
            // Auto-match province & city from data attributes
            const option = select.options[select.selectedIndex];
            const targetProv = option.dataset.province;
            const targetCity = option.dataset.city;
            
            let matchedProvId = null;
            const provSelect = document.getElementById('saved_province_select');
            
            if (targetProv && provSelect) {
                const targetP = targetProv.toLowerCase().trim();
                for (let i = 0; i < provSelect.options.length; i++) {
                    if (provSelect.options[i].text.toLowerCase().trim() === targetP) {
                        matchedProvId = provSelect.options[i].value;
                        provSelect.value = matchedProvId;
                        break;
                    }
                }
            }

            if (matchedProvId && targetCity) {
                // We matched province, now load cities and match city
                if (savedWrap) savedWrap.style.display = 'none'; // hide while loading
                
                loadCitiesInto('saved_city_select', matchedProvId, null, targetCity)
                    .then(matched => {
                        // If we couldn't match the city automatically, show the manual fallback
                        if (savedWrap && !matched) {
                            savedWrap.style.display = 'block';
                        }
                    });
            } else {
                // Fallback: show manual select if auto-match fails
                if (savedWrap) savedWrap.style.display = 'block';
            }
        }

        // Toggle required on new-address fields
        const reqEls    = ['new_addr_receiver','new_addr_phone','new_addr_postal','new_addr_full'];
        const selectEls = ['province_select','city_select','district_name'];
        [reqEls, selectEls].flat().forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                isNew ? el.setAttribute('required','required') : el.removeAttribute('required');
            }
        });
    }

    // Instead of triggering immediately, we now trigger after provinces are loaded
    // toggleNewAddress();
</script>
@endsection
