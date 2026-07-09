@extends('layouts.admin')
@section('title','Analytics')
@section('page-title','Analytics & Statistik')
@section('content')

<style>
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.4; transform: scale(0.8); }
}
</style>

<div style="margin-bottom:2rem; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h1 style="font-size:1.5rem;font-weight:800;color:var(--text1);margin:0 0 .25rem;letter-spacing:-.02em;">Analytics & Statistik</h1>
    <p style="font-size:.875rem;color:var(--text3);margin:0;">Laporan performa website dan konversi Leads</p>
  </div>
  <div style="display: flex; gap: 0.5rem; align-items: center; background:#FFFFFF; padding:0.5rem; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.03);">
    <input type="date" id="date-from" style="padding: 0.375rem 0.5rem; font-size: 0.8rem; background: var(--bg3); border: 1px solid var(--border); border-radius: 6px; color: var(--text1); font-family: inherit; font-weight:600; outline:none;">
    <span style="color: var(--text3); font-weight:600; font-size:0.8rem;">s/d</span>
    <input type="date" id="date-to" style="padding: 0.375rem 0.5rem; font-size: 0.8rem; background: var(--bg3); border: 1px solid var(--border); border-radius: 6px; color: var(--text1); font-family: inherit; font-weight:600; outline:none;">
    <button onclick="loadCustomData()" style="padding: 0.4rem 1rem; font-size: 0.8rem; background:#3B82F6; color:#fff; border:none; border-radius:6px; font-weight:700; cursor:pointer; transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Filter</button>
    
    <div style="border-left: 1px solid var(--border); margin: 0 0.5rem; height: 30px;"></div>
    
    <button onclick="downloadReport('xls')" style="padding: 0.4rem 1rem; font-size: 0.8rem; background:rgba(16, 185, 129, 0.1); color: #10B981; border:none; border-radius:6px; font-weight:700; cursor:pointer; transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">↓ XLS</button>
    <button onclick="downloadReport('pdf')" style="padding: 0.4rem 1rem; font-size: 0.8rem; background:rgba(239, 68, 68, 0.1); color: #EF4444; border:none; border-radius:6px; font-weight:700; cursor:pointer; transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">↓ PDF</button>
  </div>
</div>
<div style="font-size:0.75rem; color:var(--text3); margin-top:-1.5rem; margin-bottom:2rem; text-align:right;">
  *Silakan filter periode tanggal terlebih dahulu sebelum men-download laporan.
</div>

<div style="display:flex;gap:0.75rem;margin-bottom:2rem;flex-wrap:wrap;align-items:center;">
    <span style="font-size:0.875rem;color:var(--text3);font-weight:700;">Periode Cepat:</span>
    @foreach(['7'=>'7 Hari','30'=>'30 Hari','365'=>'1 Tahun'] as $p=>$l)
    <button onclick="loadData('{{ $p }}')" id="btn-{{ $p }}" style="padding:0.4rem 1rem;font-size:0.8rem;font-weight:700;border:none;background:{{ $p==='30'?'rgba(59, 130, 246, 0.1)':'#FFFFFF' }};color:{{ $p==='30'?'#3B82F6':'var(--text3)' }};border-radius:100px;cursor:pointer;transition:all 0.2s;box-shadow:0 2px 10px rgba(0,0,0,0.02);">{{ $l }}</button>
    @endforeach
</div>

{{-- Summary Cards --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;margin-bottom:2rem;">
    <div style="background:#FFFFFF;border-radius:20px;padding:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;align-items:center;gap:1.25rem;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:50px;height:50px;background:rgba(59, 130, 246, 0.1);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="24" height="24" fill="none" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
      </div>
      <div>
        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Visitor</div>
        <div id="stat-pageview" style="font-size:1.5rem;font-weight:800;color:var(--text1);line-height:1;">—</div>
      </div>
    </div>
    
    <div style="background:#FFFFFF;border-radius:20px;padding:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;align-items:center;gap:1.25rem;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:50px;height:50px;background:rgba(16, 185, 129, 0.1);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="24" height="24" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
      </div>
      <div>
        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Klik WA</div>
        <div id="stat-wa" style="font-size:1.5rem;font-weight:800;color:var(--text1);line-height:1;">—</div>
      </div>
    </div>

    <div style="background:#FFFFFF;border-radius:20px;padding:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;align-items:center;gap:1.25rem;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:50px;height:50px;background:rgba(245, 158, 11, 0.1);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="24" height="24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
      </div>
      <div>
        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Leads</div>
        <div id="stat-leads" style="font-size:1.5rem;font-weight:800;color:var(--text1);line-height:1;">—</div>
      </div>
    </div>

    <div style="background:#FFFFFF;border-radius:20px;padding:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.03);display:flex;align-items:center;gap:1.25rem;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:50px;height:50px;background:rgba(139, 92, 246, 0.1);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="24" height="24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
      </div>
      <div>
        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Konversi (CTR)</div>
        <div id="stat-ctr" style="font-size:1.5rem;font-weight:800;color:var(--text1);line-height:1;">—</div>
      </div>
    </div>
</div>

{{-- CTR Alert Banner (visible only when CTR < 2%) --}}
<div id="ctr-alert-card" style="display:none;margin-bottom:2rem;">
    <div style="background:#fff;border-radius:20px;border:1.5px solid #BFDBFE;box-shadow:0 4px 24px rgba(59,130,246,0.08);padding:1.5rem 2rem;display:flex;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:1.25rem;flex:1;min-width:260px;">
            <div style="width:48px;height:48px;background:rgba(59,130,246,0.1);border-radius:14px;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
            </div>
            <div>
                <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.375rem;">
                    <span style="font-size:.65rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:#3B82F6;background:rgba(59,130,246,0.1);padding:.2rem .625rem;border-radius:100px;">Rekomendasi</span>
                    <span id="ctr-current-badge" style="font-size:.65rem;font-weight:700;color:#F59E0B;background:rgba(245,158,11,0.1);padding:.2rem .625rem;border-radius:100px;">CTR: 0%</span>
                </div>
                <div style="font-size:1rem;font-weight:800;color:#1E293B;margin-bottom:.25rem;">Tingkatkan Konversi Website Anda</div>
                <p style="font-size:.825rem;color:#64748B;margin:0;line-height:1.6;">CTR di bawah <strong style="color:#3B82F6;">2%</strong> menandakan banyak calon buyer yang lari ke kompetitor. Upgrade layanan SEO sekarang agar website Anda <strong>tampil teratas</strong> saat buyer mencari produk. Lebih dominan dari kompetitor = <strong style="color:#10B981;">Peluang deal jauh lebih besar!</strong></p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:.75rem;flex-shrink:0;">
            <a href="https://wa.me/6285179982373?text={{ urlencode('Halo, saya ingin konsultasi upgrade layanan SEO untuk website Cyclevent.') }}" target="_blank"
               style="display:inline-flex;align-items:center;gap:.5rem;background:#3B82F6;color:#fff;padding:.7rem 1.5rem;border-radius:12px;text-decoration:none;font-weight:700;font-size:.85rem;box-shadow:0 4px 14px rgba(59,130,246,0.3);transition:all .2s;"
               onmouseover="this.style.background='#2563EB';this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(59,130,246,0.4)';"
               onmouseout="this.style.background='#3B82F6';this.style.transform='';this.style.boxShadow='0 4px 14px rgba(59,130,246,0.3)';"
            >
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                Hubungi Developer
            </a>
            <button onclick="document.getElementById('ctr-alert-card').style.display='none';"
                style="width:36px;height:36px;border-radius:10px;border:1.5px solid #E2E8F0;background:#fff;color:#94A3B8;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;flex-shrink:0;"
                onmouseover="this.style.background='#F8FAFC';this.style.color='#475569';this.style.borderColor='#CBD5E1';"
                onmouseout="this.style.background='#fff';this.style.color='#94A3B8';this.style.borderColor='#E2E8F0';"
                title="Tutup notifikasi"
            >
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>
</div>

{{-- Chart + Top Pages --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-bottom:2rem;">
    <div style="display:flex;flex-direction:column;gap:1.5rem;">
        <div style="background:#FFFFFF;border-radius:24px;padding:1.75rem 1.75rem 1.5rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.75rem;">
              <div>
                <div style="font-size:.8rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.08em;margin-bottom:.35rem;">Grafik Performa</div>
                <div id="chart-period-label" style="font-size:1.35rem;font-weight:800;color:#1E293B;line-height:1;">30 Hari Terakhir</div>
              </div>
              <div style="display:flex;gap:.625rem;align-items:center;padding:.5rem .875rem;background:#F8FAFC;border-radius:100px;">
                <div style="display:flex;align-items:center;gap:.35rem;font-size:.72rem;font-weight:700;color:#64748B;"><span style="display:inline-block;width:10px;height:3px;background:#A3AED0;border-radius:2px;"></span>Visitor</div>
                <div style="display:flex;align-items:center;gap:.35rem;font-size:.72rem;font-weight:700;color:#64748B;"><span style="display:inline-block;width:10px;height:3px;background:#10B981;border-radius:2px;"></span>WA</div>
                <div style="display:flex;align-items:center;gap:.35rem;font-size:.72rem;font-weight:700;color:#64748B;"><span style="display:inline-block;width:10px;height:3px;background:#3B82F6;border-radius:2px;"></span>Leads</div>
              </div>
            </div>
            <canvas id="visits-chart" height="100"></canvas>
        </div>
        
        <div style="background:#FFFFFF;border-radius:20px;padding:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.03);">
            <h3 style="font-size:.875rem;font-weight:800;color:var(--text1);text-transform:uppercase;letter-spacing:.05em;margin:0 0 1.25rem;">Tipe Perangkat</h3>
            <div id="device-breakdown" style="display:flex;flex-direction:column;gap:1rem;">
                <div style="text-align:center;padding:1rem;color:var(--text3);font-weight:500;">Memuat...</div>
            </div>
        </div>
    </div>
    
    <div style="display:flex;flex-direction:column;gap:1.5rem;">
        <div style="background:#FFFFFF;border-radius:20px;padding:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.03);flex:1;">
            <h3 style="font-size:.875rem;font-weight:800;color:var(--text1);text-transform:uppercase;letter-spacing:.05em;margin:0 0 1.25rem;">Top Halaman</h3>
            <div id="top-pages" style="display:flex;flex-direction:column;gap:0.75rem;">
                <div style="text-align:center;padding:2rem;color:var(--text3);font-weight:500;">Memuat...</div>
            </div>
        </div>
    </div>
</div>

{{-- Location Card --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
    {{-- Top Locations --}}
    <div style="background:#FFFFFF;border-radius:20px;padding:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.03);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
            <div>
                <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .2rem;">Lokasi Pengunjung</h3>
                <p style="font-size:.75rem;color:#64748B;margin:0;">Deteksi kota berdasarkan IP</p>
            </div>
            <div id="loc-realtime-badge" style="display:flex;align-items:center;gap:0.4rem;background:rgba(16,185,129,0.1);padding:.35rem .75rem;border-radius:100px;">
                <span style="width:7px;height:7px;background:#10B981;border-radius:50%;animation:pulse-dot 1.5s infinite;"></span>
                <span style="font-size:.7rem;font-weight:700;color:#10B981;">REALTIME</span>
            </div>
        </div>
        <div id="location-list" style="display:flex;flex-direction:column;gap:0.75rem;">
            <div style="text-align:center;padding:2rem;color:#94A3B8;font-weight:500;">Memuat data lokasi...</div>
        </div>
    </div>

    {{-- Realtime Active Users --}}
    <div style="background:#FFFFFF;border-radius:20px;padding:1.5rem;box-shadow:0 4px 15px rgba(0,0,0,0.03);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
            <div>
                <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .2rem;">Pengunjung Aktif (1 Jam Terakhir)</h3>
                <p style="font-size:.75rem;color:#64748B;margin:0;">Berdasarkan kunjungan terbaru</p>
            </div>
            <div style="display:flex;align-items:center;gap:0.4rem;background:rgba(59,130,246,0.1);padding:.35rem .75rem;border-radius:100px;">
                <span style="width:7px;height:7px;background:#3B82F6;border-radius:50%;animation:pulse-dot 1.5s infinite .5s;"></span>
                <span style="font-size:.7rem;font-weight:700;color:#3B82F6;">LIVE</span>
            </div>
        </div>
        <div style="display:flex;align-items:center;justify-content:center;flex-direction:column;gap:0.5rem;padding:1.5rem 0;">
            <div id="active-count" style="font-size:4rem;font-weight:900;color:#1E293B;line-height:1;">—</div>
            <div style="font-size:.875rem;color:#64748B;font-weight:600;">Sesi aktif ditemukan</div>
        </div>
        <div id="recent-locations" style="display:flex;flex-direction:column;gap:0.5rem;max-height:200px;overflow-y:auto;">
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
let chart = null;
let currentPeriod = '30';

async function loadCustomData() {
    const from = document.getElementById('date-from').value;
    const to = document.getElementById('date-to').value;
    if (!from || !to) return alert('Pilih tanggal mulai dan selesai');
    
    currentPeriod = 'custom';
    ['7','30','365'].forEach(p => {
        const btn = document.getElementById('btn-' + p);
        btn.style.background = '#FFFFFF';
        btn.style.color = 'var(--text3)';
    });

    const res  = await fetch('/admin/analytics/data?period=custom&from=' + from + '&to=' + to);
    const data = await res.json();
    renderData(data);
}

async function loadData(period) {
    currentPeriod = period;
    // Update button styles
    ['7','30','365'].forEach(p => {
        const btn = document.getElementById('btn-' + p);
        btn.style.background = p === period ? 'rgba(59, 130, 246, 0.1)' : '#FFFFFF';
        btn.style.color = p === period ? '#3B82F6' : 'var(--text3)';
    });

    const res  = await fetch('/admin/analytics/data?period=' + period);
    const data = await res.json();
    renderData(data);
}

function renderData(data) {
    // Stats
    document.getElementById('stat-pageview').textContent = (data.summary.pageview || 0).toLocaleString();
    document.getElementById('stat-wa').textContent = (data.summary.wa_click || 0).toLocaleString();
    document.getElementById('stat-leads').textContent = (data.summary.leads || 0).toLocaleString();
    document.getElementById('stat-ctr').textContent = (data.summary.ctr || 0) + '%';

    // Chart — Premium GA Style
    if (chart) chart.destroy();
    const canvasEl = document.getElementById('visits-chart');
    const chartCtx = canvasEl.getContext('2d');

    // Build gradients fresh each time
    const gV = chartCtx.createLinearGradient(0, 0, 0, 300);
    gV.addColorStop(0, 'rgba(163,174,208,0.20)');
    gV.addColorStop(1, 'rgba(163,174,208,0.00)');

    const gW = chartCtx.createLinearGradient(0, 0, 0, 300);
    gW.addColorStop(0, 'rgba(16,185,129,0.15)');
    gW.addColorStop(1, 'rgba(16,185,129,0.00)');

    const gL = chartCtx.createLinearGradient(0, 0, 0, 300);
    gL.addColorStop(0, 'rgba(59,130,246,0.25)');
    gL.addColorStop(1, 'rgba(59,130,246,0.00)');

    // Update period label
    const periods = {'7':'7 Hari Terakhir','30':'30 Hari Terakhir','365':'1 Tahun Terakhir','custom':'Rentang Kustom'};
    const lbl = document.getElementById('chart-period-label');
    if (lbl) lbl.textContent = periods[currentPeriod] || '30 Hari Terakhir';

    chart = new Chart(chartCtx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: 'Visitor',
                    data: data.visitorValues,
                    borderColor: '#A3AED0',
                    backgroundColor: gV,
                    borderWidth: 2.5,
                    tension: 0.45,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#A3AED0',
                    pointHoverBorderWidth: 2.5,
                },
                {
                    label: 'WA Click',
                    data: data.waValues,
                    borderColor: '#10B981',
                    backgroundColor: gW,
                    borderWidth: 2.5,
                    tension: 0.45,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#10B981',
                    pointHoverBorderWidth: 2.5,
                },
                {
                    label: 'Leads',
                    data: data.leadsValues,
                    borderColor: '#3B82F6',
                    backgroundColor: gL,
                    borderWidth: 2.5,
                    tension: 0.45,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#3B82F6',
                    pointHoverBorderWidth: 2.5,
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    backgroundColor: '#FFFFFF',
                    titleColor: '#1E293B',
                    bodyColor: '#64748B',
                    borderColor: '#E4E7F0',
                    borderWidth: 1,
                    padding: { x: 14, y: 10 },
                    cornerRadius: 12,
                    titleFont: { size: 12, weight: '700' },
                    bodyFont: { size: 12, weight: '600' },
                    callbacks: {
                        label: function(ctx) {
                            return `  ${ctx.parsed.y}  ${ctx.dataset.label}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { color: '#94A3B8', font: { size: 11 }, maxRotation: 0, maxTicksLimit: 10 }
                },
                y: {
                    grid: { color: '#F1F5F9', lineWidth: 1, borderDash: [5, 4] },
                    border: { display: false },
                    ticks: { color: '#94A3B8', font: { size: 11 }, stepSize: 1, precision: 0 }
                }
            }
        }
    });

    // Top Pages
    const topPagesEl = document.getElementById('top-pages');
    if (data.top_pages && data.top_pages.length) {
        topPagesEl.innerHTML = data.top_pages.map(p => {
            const path = p.page_url ? (new URL(p.page_url, window.location.origin)).pathname : '/';
            return `<div style="display:flex;justify-content:space-between;align-items:center;padding:0.625rem 0;border-bottom:1px solid var(--border);font-size:0.875rem;">
                <span style="color:var(--text2);font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:75%;">${path}</span>
                <span style="font-weight:800;color:#3B82F6;flex-shrink:0;">${parseInt(p.views).toLocaleString()}</span>
            </div>`;
        }).join('');
    } else {
        topPagesEl.innerHTML = '<p style="color:var(--text3);text-align:center;padding:1rem;">Belum ada data.</p>';
    }

    // Device Breakdown
    const deviceEl = document.getElementById('device-breakdown');
    if (data.devices && Object.keys(data.devices).length) {
        const total = Object.values(data.devices).reduce((a, b) => a + b, 0);
        deviceEl.innerHTML = Object.entries(data.devices).map(([dev, count]) => {
            const pct = Math.round((count / total) * 100);
            const icon = dev.toLowerCase() === 'desktop'
                ? '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>'
                : '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>';
            return `
            <div style="margin-bottom:1rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.375rem;font-size:0.875rem;">
                    <div style="display:flex;align-items:center;gap:0.375rem;color:var(--text1);font-weight:600;">
                        ${icon} <span style="text-transform:capitalize;">${dev}</span>
                    </div>
                    <div style="font-weight:700;color:var(--text2);">${pct}% <span style="color:var(--text3);font-size:0.75rem;font-weight:500;">(${count})</span></div>
                </div>
                <div style="width:100%;background:var(--bg3);border-radius:100px;height:6px;overflow:hidden;">
                    <div style="height:100%;background:#3B82F6;border-radius:100px;width:${pct}%;"></div>
                </div>
            </div>`;
        }).join('');
    } else {
        deviceEl.innerHTML = '<p style="color:var(--text3);text-align:center;padding:1rem;">Belum ada data.</p>';
    }

    // Location Breakdown

    const locEl = document.getElementById('location-list');
    if (data.locations && Object.keys(data.locations).length) {
        const totalLoc = Object.values(data.locations).reduce((a, b) => a + b, 0);
        const colors = ['#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#06B6D4','#F97316','#6366F1','#14B8A6'];
        locEl.innerHTML = Object.entries(data.locations).map(([loc, count], i) => {
            const pct = Math.round((count / totalLoc) * 100);
            const color = colors[i % colors.length];
            const parts = loc.split(', ');
            const city = parts[0];
            const countryCode = parts[1] || '';
            return `
            <div style="margin-bottom:.25rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.35rem;">
                    <div style="display:flex;align-items:center;gap:.625rem;">
                        <span style="width:10px;height:10px;background:${color};border-radius:50%;flex-shrink:0;"></span>
                        <div>
                            <span style="font-size:.875rem;font-weight:700;color:#1E293B;">${city}</span>
                            ${countryCode ? `<span style="font-size:.7rem;color:#94A3B8;margin-left:.25rem;">${countryCode}</span>` : ''}
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:.5rem;flex-shrink:0;">
                        <span style="font-size:.8rem;font-weight:700;color:${color};">${count.toLocaleString()}</span>
                        <span style="font-size:.7rem;color:#94A3B8;">(${pct}%)</span>
                    </div>
                </div>
                <div style="width:100%;background:#F1F5F9;border-radius:100px;height:5px;overflow:hidden;">
                    <div style="height:100%;background:${color};border-radius:100px;width:${pct}%;transition:width .6s ease;"></div>
                </div>
            </div>`;
        }).join('');
    } else {
        locEl.innerHTML = '<p style="color:#94A3B8;text-align:center;padding:1rem;font-size:.875rem;">Belum ada data lokasi.<br><small>Data lokasi akan muncul pada kunjungan berikutnya.</small></p>';
    }

    // CTR Alert
    checkCtr(data.summary.ctr || 0);
}

function checkCtr(ctr) {
    const card = document.getElementById('ctr-alert-card');
    const badge = document.getElementById('ctr-current-badge');
    if (!card) return;
    if (parseFloat(ctr) < 2) {
        card.style.display = 'block';
        if (badge) badge.textContent = 'CTR: ' + ctr + '%';
    } else {
        card.style.display = 'none';
    }
}

// Load on page init
loadData('30');

// Auto-refresh realtime every 60s
setInterval(fetchRealtime, 60000);
fetchRealtime();

async function fetchRealtime() {
    try {
        const res = await fetch('/admin/analytics/data?period=7');
        const data = await res.json();

        // Active count (last 1h visits)
        const recent = await fetch('/admin/analytics/realtime');
        if (recent.ok) {
            const rt = await recent.json();
            document.getElementById('active-count').textContent = rt.active ?? '—';
            const rlEl = document.getElementById('recent-locations');
            if (rt.locations && rt.locations.length) {
                rlEl.innerHTML = rt.locations.map(l => `
                    <div style="display:flex;align-items:center;gap:.625rem;padding:.5rem .75rem;background:#F8FAFC;border-radius:10px;">
                        <span style="width:8px;height:8px;background:#10B981;border-radius:50%;flex-shrink:0;"></span>
                        <span style="font-size:.8rem;font-weight:600;color:#334155;">${l}</span>
                    </div>`).join('');
            }
        }
    } catch(e) {}
}

function downloadReport(format) {
    const start = document.getElementById('date-from').value;
    const end = document.getElementById('date-to').value;
    if(!start || !end) {
        alert('Mohon isi rentang tanggal (s/d) lalu klik Filter terlebih dahulu!');
        return;
    }
    const url = `/admin/analytics/export/${format}?start_date=${start}&end_date=${end}`;
    if(format === 'pdf') {
        window.open(url, '_blank');
    } else {
        window.location.href = url;
    }
}
</script>
@endpush
@endsection
