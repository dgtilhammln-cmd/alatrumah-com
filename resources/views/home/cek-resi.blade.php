@extends('layouts.app')

@section('title', 'Lacak Paket - AlatRumah')
@section('meta_description', 'Cek status pengiriman paket Anda secara real-time dengan semua kurir populer Indonesia.')

@section('content')
<style>
:root {
    --blue-900: #0C2340;
    --blue-700: #0369A1;
    --blue-500: #0EA5E9;
    --blue-400: #38BDF8;
    --blue-100: #E0F2FE;
    --slate-50:  #F8FAFC;
    --slate-100: #F1F5F9;
    --slate-200: #E2E8F0;
    --slate-300: #CBD5E1;
    --slate-400: #94A3B8;
    --slate-500: #64748B;
    --slate-700: #334155;
    --slate-800: #1E293B;
    --slate-900: #0F172A;
    --green-100: #DCFCE7; --green-600: #16A34A;
    --amber-100: #FEF3C7; --amber-600: #D97706;
    --red-100: #FEE2E2;
    --font: 'Montserrat', sans-serif;
    --radius: 20px;
    --shadow-card: 0 8px 40px rgba(0,0,0,0.06);
}
.resi-page { min-height:100vh; background:linear-gradient(160deg,#EEF7FF 0%,#F8FAFC 55%,#F0F9FF 100%); font-family:var(--font); padding-top:90px; padding-bottom:4rem; }
.resi-hero { text-align:center; padding:3.5rem 1rem 2rem; }
.resi-hero-eyebrow { display:inline-flex; align-items:center; gap:.4rem; background:var(--blue-100); color:var(--blue-700); font-size:.7rem; font-weight:600; letter-spacing:.08em; text-transform:uppercase; padding:.35rem .9rem; border-radius:999px; margin-bottom:1.25rem; }
.resi-hero h1 { font-size:clamp(1.6rem,4vw,2.5rem); font-weight:700; color:var(--slate-900); letter-spacing:-.025em; line-height:1.15; margin:0 0 .75rem; }
.resi-hero h1 span { color:var(--blue-500); }
.resi-hero p { color:var(--slate-500); font-size:1rem; max-width:460px; margin:0 auto; line-height:1.7; }
.resi-couriers { display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:.5rem; margin:1.5rem auto 0; max-width:560px; }
.resi-courier-chip { font-size:.72rem; font-weight:600; background:#fff; border:1.5px solid #CBD5E1; color:#475569; border-radius:999px; padding:.3rem .85rem; transition:all .2s; letter-spacing:.01em; }
.resi-courier-chip:hover { border-color:var(--blue-500); color:var(--blue-500); }
.resi-container { max-width:860px; margin:0 auto; padding:0 1.25rem; }
.resi-form-card { background:#fff; border-radius:var(--radius); padding:2.25rem; box-shadow:var(--shadow-card); border:1.5px solid var(--slate-100); margin-bottom:1.75rem; position:relative; overflow:hidden; }
.resi-form-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,var(--blue-500),var(--blue-400)); border-radius:var(--radius) var(--radius) 0 0; }
.resi-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; margin-bottom:1.5rem; }
@media(max-width:580px){ .resi-form-grid{grid-template-columns:1fr;} .resi-form-card{padding:1.5rem;} }
.resi-field label { display:block; font-size:.78rem; font-weight:600; color:var(--slate-600); margin-bottom:.5rem; letter-spacing:.01em; }
.resi-field input, .resi-field select { width:100%; padding:.9rem 1.1rem; border:1.5px solid var(--slate-200); border-radius:12px; font-size:.9rem; font-family:var(--font); font-weight:400; color:var(--slate-900); background:var(--slate-50); outline:none; transition:border-color .2s,box-shadow .2s,background .2s; }
.resi-field input:focus, .resi-field select:focus { border-color:var(--blue-500); background:#fff; box-shadow:0 0 0 3px rgba(14,165,233,.12); }
.resi-field-error { color:#DC2626; font-size:.78rem; margin-top:.35rem; }
.resi-submit-row { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; }
.resi-note { font-size:.75rem; color:var(--slate-400); display:flex; align-items:center; gap:.35rem; }
.resi-btn { display:inline-flex; align-items:center; gap:.5rem; background:linear-gradient(135deg,var(--blue-500),var(--blue-700)); color:#fff; border:none; padding:.85rem 2.25rem; border-radius:12px; font-size:.875rem; font-weight:700; font-family:var(--font); cursor:pointer; box-shadow:0 4px 18px rgba(14,165,233,.35); transition:transform .2s,box-shadow .2s; white-space:nowrap; }
.resi-btn:hover { transform:translateY(-2px); box-shadow:0 8px 26px rgba(14,165,233,.45); }
.resi-error { background:var(--red-100); border:1.5px solid #FECACA; border-radius:14px; padding:1.25rem 1.5rem; display:flex; align-items:flex-start; gap:.875rem; margin-bottom:1.75rem; color:#991B1B; }
.resi-result { background:#fff; border-radius:var(--radius); box-shadow:var(--shadow-card); border:1.5px solid var(--slate-100); overflow:hidden; animation:fadeUp .4s ease both; }
@keyframes fadeUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
.resi-result-header { background:linear-gradient(135deg,var(--slate-900) 0%,var(--blue-900) 100%); padding:1.75rem 2rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; }
.resi-awb-label { font-size:.68rem; font-weight:500; color:rgba(255,255,255,.5); letter-spacing:.1em; text-transform:uppercase; margin-bottom:.35rem; }
.resi-awb-num { font-size:1.3rem; font-weight:700; color:#fff; letter-spacing:.03em; }
.resi-courier-badge { display:block; background:rgba(255,255,255,.1); color:rgba(255,255,255,.75); border:1px solid rgba(255,255,255,.15); border-radius:999px; padding:.35rem .9rem; font-size:.72rem; font-weight:500; letter-spacing:.04em; text-transform:uppercase; margin-top:.25rem; }
.resi-status-pill { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1rem; border-radius:999px; font-size:.75rem; font-weight:700; letter-spacing:.03em; text-transform:uppercase; }
.resi-status-pill.delivered { background:var(--green-100); color:var(--green-600); }
.resi-status-pill.on-transit { background:var(--amber-100); color:var(--amber-600); }
.resi-status-pill.other { background:rgba(255,255,255,.15); color:#fff; }
.resi-result-body { padding:2rem; }
.resi-info-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:2rem; }
@media(max-width:520px){ .resi-info-grid{grid-template-columns:1fr;} .resi-result-header{padding:1.25rem;} .resi-result-body{padding:1.25rem;} }
.resi-info-box { background:var(--slate-50); border:1.5px solid var(--slate-100); border-radius:14px; padding:1.1rem 1.25rem; }
.resi-info-box-label { font-size:.68rem; font-weight:600; color:var(--slate-400); text-transform:uppercase; letter-spacing:.08em; margin-bottom:.4rem; display:flex; align-items:center; gap:.35rem; }
.resi-info-box-name { font-size:.95rem; font-weight:600; color:var(--slate-900); margin-bottom:.2rem; }
.resi-info-box-loc { font-size:.82rem; color:var(--slate-500); font-weight:400; }
.resi-timeline-title { font-size:.72rem; font-weight:700; color:var(--slate-400); text-transform:uppercase; letter-spacing:.08em; margin-bottom:1.5rem; display:flex; align-items:center; gap:.5rem; }
.resi-timeline-title::after { content:''; flex:1; height:1px; background:var(--slate-200); }
.resi-timeline { position:relative; padding-left:1.75rem; }
.resi-timeline-line { position:absolute; top:8px; bottom:8px; left:7px; width:2px; background:linear-gradient(180deg,var(--blue-500) 0%,var(--slate-200) 100%); }
.resi-timeline-item { position:relative; padding-bottom:1.75rem; animation:fadeUp .4s ease both; }
.resi-timeline-item:last-child { padding-bottom:0; }
.resi-timeline-dot { position:absolute; left:-1.75rem; top:3px; width:16px; height:16px; border-radius:50%; border:3px solid #fff; box-shadow:0 0 0 2px var(--slate-200); background:var(--slate-300); }
.resi-timeline-dot.active { background:var(--blue-500); box-shadow:0 0 0 3px rgba(14,165,233,.25); width:18px; height:18px; left:calc(-1.75rem - 1px); top:2px; }
.resi-timeline-date { font-size:.75rem; font-weight:400; color:var(--slate-400); margin-bottom:.2rem; }
.resi-timeline-desc { font-size:.9rem; font-weight:500; color:var(--slate-600); line-height:1.5; margin-bottom:.2rem; }
.resi-timeline-item.active .resi-timeline-desc { font-weight:700; color:var(--slate-900); }
.resi-timeline-loc { display:inline-flex; align-items:center; gap:.3rem; font-size:.78rem; color:var(--slate-400); }
.resi-footer-tips { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1rem; margin-top:2rem; }
.resi-tip-card { background:#fff; border-radius:16px; padding:1.25rem; border:1.5px solid var(--slate-100); box-shadow:0 2px 12px rgba(0,0,0,.04); display:flex; align-items:flex-start; gap:.875rem; }
.resi-tip-icon { width:38px; height:38px; border-radius:10px; background:var(--blue-100); color:var(--blue-700); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.resi-tip-title { font-size:.8rem; font-weight:700; color:var(--slate-800); margin-bottom:.2rem; }
.resi-tip-body { font-size:.74rem; color:var(--slate-400); line-height:1.6; font-weight:400; }
</style>

<div class="resi-page">
    <div class="resi-hero">
        <div class="resi-hero-eyebrow">
            <svg width="11" height="11" fill="currentColor" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
            Lacak Pengiriman Real-time
        </div>
        <h1>Status Paket <span>Langsung</span> Terpantau</h1>
        <p>Pantau perjalanan paket Anda dari gudang hingga depan pintu - akurat dan terupdate.</p>
        <div class="resi-couriers">
            @foreach(['JNE','J&T','SiCepat','AnterAja','POS','Ninja','Lion','ID Express'] as $chip)
                <span class="resi-courier-chip">{{ $chip }}</span>
            @endforeach
        </div>
    </div>

    <div class="resi-container">
        <div class="resi-form-card">
            <form action="{{ route('cek-resi.track') }}" method="POST" id="trackForm">
                @csrf
                <div class="resi-form-grid">
                    <div class="resi-field">
                        <label for="awb_input">Nomor Resi / AWB</label>
                        <input type="text" id="awb_input" name="awb" value="{{ old('awb', $awb ?? '') }}" required placeholder="Contoh: JX2024XXXXXX" autocomplete="off" spellcheck="false">
                        @error('awb')<div class="resi-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="resi-field">
                        <label for="courier_select">Pilih Kurir Ekspedisi</label>
                        <select id="courier_select" name="courier" required>
                            <option value="" disabled {{ empty($courier ?? '') ? 'selected' : '' }}>Pilih Kurir...</option>
                            <option value="jne"      {{ ($courier ?? '') == 'jne'      ? 'selected' : '' }}>JNE</option>
                            <option value="jnt"      {{ ($courier ?? '') == 'jnt'      ? 'selected' : '' }}>J&T Express</option>
                            <option value="sicepat"  {{ ($courier ?? '') == 'sicepat'  ? 'selected' : '' }}>SiCepat</option>
                            <option value="anteraja" {{ ($courier ?? '') == 'anteraja' ? 'selected' : '' }}>AnterAja</option>
                            <option value="pos"      {{ ($courier ?? '') == 'pos'      ? 'selected' : '' }}>POS Indonesia</option>
                            <option value="ninja"    {{ ($courier ?? '') == 'ninja'    ? 'selected' : '' }}>Ninja Xpress</option>
                            <option value="lion"     {{ ($courier ?? '') == 'lion'     ? 'selected' : '' }}>Lion Parcel</option>
                            <option value="idx"      {{ ($courier ?? '') == 'idx'      ? 'selected' : '' }}>ID Express</option>
                        </select>
                        @error('courier')<div class="resi-field-error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="resi-submit-row">
                    <div class="resi-note">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                        Data real-time langsung dari server kurir
                    </div>
                    <button type="submit" class="resi-btn" id="trackBtn">
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <span id="trackBtnText">Lacak Sekarang</span>
                    </button>
                </div>
            </form>
        </div>

        @if(!empty($error))
        <div class="resi-error">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            <div>
                <div style="font-weight:800;font-size:.95rem;margin-bottom:.2rem;">Gagal Melacak Paket</div>
                <div style="font-size:.875rem;">{{ $error }}</div>
            </div>
        </div>
        @endif

        @if(!empty($tracking))
        @php
            $status = strtolower($tracking['summary']['status'] ?? '');
            $isDelivered = str_contains($status,'delivered') || str_contains($status,'terkirim');
            $isTransit   = str_contains($status,'transit') || str_contains($status,'proses');
        @endphp
        <div class="resi-result">
            <div class="resi-result-header">
                <div>
                    <div class="resi-awb-label">Nomor Resi</div>
                    <div class="resi-awb-num">{{ $tracking['summary']['awb'] }}</div>
                    <span class="resi-courier-badge">{{ $tracking['summary']['courier'] }} - {{ $tracking['summary']['service'] }}</span>
                </div>
                <div>
                    @if($isDelivered)
                        <div class="resi-status-pill delivered">
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Terkirim
                        </div>
                    @elseif($isTransit)
                        <div class="resi-status-pill on-transit">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Dalam Perjalanan
                        </div>
                    @else
                        <div class="resi-status-pill other">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                            {{ $tracking['summary']['status'] }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="resi-result-body">
                <div class="resi-info-grid">
                    <div class="resi-info-box">
                        <div class="resi-info-box-label">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 10l7-7 7 7"/><path d="M12 3v18"/></svg>
                            Pengirim
                        </div>
                        <div class="resi-info-box-name">{{ $tracking['detail']['shipper'] ?? '-' }}</div>
                        <div class="resi-info-box-loc">{{ $tracking['detail']['origin'] ?? '' }}</div>
                    </div>
                    <div class="resi-info-box">
                        <div class="resi-info-box-label">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 14l-7 7-7-7"/><path d="M12 3v18"/></svg>
                            Penerima
                        </div>
                        <div class="resi-info-box-name">{{ $tracking['detail']['receiver'] ?? '-' }}</div>
                        <div class="resi-info-box-loc">{{ $tracking['detail']['destination'] ?? '' }}</div>
                    </div>
                </div>
                <div class="resi-timeline-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l2 2"/></svg>
                    Riwayat Perjalanan
                </div>
                <div class="resi-timeline">
                    <div class="resi-timeline-line"></div>
                    @foreach($tracking['history'] as $i => $hist)
                    <div class="resi-timeline-item {{ $i === 0 ? 'active' : '' }}" style="animation-delay:{{ $i * 0.06 }}s">
                        <div class="resi-timeline-dot {{ $i === 0 ? 'active' : '' }}"></div>
                        <div class="resi-timeline-date">{{ date('d M Y, H:i', strtotime($hist['date'])) }}</div>
                        <div class="resi-timeline-desc">{{ $hist['desc'] }}</div>
                        @if(!empty($hist['location']))
                        <div class="resi-timeline-loc">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                            {{ $hist['location'] }}
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if(empty($tracking))
        <div class="resi-footer-tips">
            <div class="resi-tip-card">
                <div class="resi-tip-icon"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <div><div class="resi-tip-title">8 Kurir Didukung</div><div class="resi-tip-body">JNE, J&T, SiCepat, AnterAja, POS, Ninja, Lion, ID Express.</div></div>
            </div>
            <div class="resi-tip-card">
                <div class="resi-tip-icon"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                <div><div class="resi-tip-title">Data Real-time</div><div class="resi-tip-body">Informasi perjalanan paket diperbarui langsung dari server kurir.</div></div>
            </div>
            <div class="resi-tip-card">
                <div class="resi-tip-icon"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg></div>
                <div><div class="resi-tip-title">Mobile Friendly</div><div class="resi-tip-body">Akses kapan saja dari smartphone, tablet, maupun laptop.</div></div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.getElementById('trackForm').addEventListener('submit', function() {
    var btn = document.getElementById('trackBtn');
    var txt = document.getElementById('trackBtnText');
    btn.disabled = true;
    btn.style.opacity = '.75';
    txt.textContent = 'Melacak...';
});
</script>
@endsection
