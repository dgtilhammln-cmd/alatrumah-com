@extends('layouts.admin')
@section('title','API & Integrasi')
@section('page-title','API & Integrasi')
@section('content')

<style>
.api-tabs {
    display: flex;
    gap: 2rem;
    border-bottom: 1px solid #F1F5F9;
    margin-bottom: 2rem;
}
.api-tab {
    padding: 1rem 1.5rem;
    font-size: .95rem;
    font-weight: 700;
    color: #94A3B8;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all .2s;
}
.api-tab.active {
    color: #DC2626;
    background: #FEF2F2;
    border-bottom-color: #DC2626;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
.api-table {
    width: 100%;
    border-collapse: collapse;
}
.api-table th {
    text-align: left;
    padding: 1rem 1.5rem;
    font-size: .875rem;
    font-weight: 700;
    color: #475569;
    background: #F8FAFC;
    border-bottom: 1px solid #F1F5F9;
}
.api-table td {
    padding: 1.25rem 1.5rem;
    font-size: .9rem;
    color: #1E293B;
    border-bottom: 1px solid #F1F5F9;
    font-weight: 500;
}
.api-table tr:hover td {
    background: #FAFBFF;
}
.api-key-hidden {
    color: #DC2626;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-family: monospace;
    font-size: .95rem;
}
</style>

@if(session('success'))
  <div style="background:#F0FDF4;color:#166534;padding:1rem 1.25rem;border-radius:12px;margin-bottom:1.5rem;border:1px solid #BBF7D0;font-size:.875rem;">{{ session('success') }}</div>
@endif

<div class="api-tabs">
    <div class="api-tab active">API Key</div>
    <div class="api-tab">Access</div>
</div>

<div style="background:#fff;border-radius:16px;border:1px solid #E2E8F0;box-shadow:0 4px 20px rgba(0,0,0,0.03);overflow:hidden;padding:2rem;">
    <h2 style="font-size:1.25rem;font-weight:800;color:#1E293B;margin:0 0 .5rem;">Api Key List</h2>
    <p style="font-size:.9rem;color:#64748B;margin:0 0 2rem;">Manage API Keys for every services that you use.</p>

    <div style="border-radius:12px;overflow:hidden;border:1px solid #F1F5F9;">
        <table class="api-table">
            <thead>
                <tr>
                    <th style="width:60px;text-align:center;">#</th>
                    <th style="width:250px;">API Name</th>
                    <th>API Key</th>
                    <th style="width:150px;">Added</th>
                    <th style="width:100px;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Shipping Cost (RajaOngkir) -->
                <tr>
                    <td style="text-align:center;color:#94A3B8;">1</td>
                    <td>Shipping Cost <span style="font-size:.75rem;color:#94A3B8;display:block;font-weight:400;">RajaOngkir</span></td>
                    <td>
                        <div class="api-key-hidden">
                            <button type="button" onclick="toggleApiKey(this)" data-full="{{ $settings->get('rajaongkir_api_key', '') }}" data-hidden="{{ $settings->get('rajaongkir_api_key') ? substr($settings->get('rajaongkir_api_key'), 0, 5) . str_repeat('•', 20) : 'Belum diatur' }}" style="background:none;border:none;cursor:pointer;color:inherit;display:flex;align-items:center;padding:0;">
                                <svg class="icon-hide" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24M1 1l22 22"/></svg>
                                <svg class="icon-show" style="display:none;" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <span class="key-text" style="color:{{ $settings->get('rajaongkir_api_key') ? '#DC2626' : '#94A3B8' }}; letter-spacing:1px; font-family:monospace;">
                                {{ $settings->get('rajaongkir_api_key') ? substr($settings->get('rajaongkir_api_key'), 0, 5) . str_repeat('•', 20) : 'Belum diatur' }}
                            </span>
                        </div>
                    </td>
                    <td style="color:#64748B;font-size:.85rem;">{{ date('d/m/Y') }}</td>
                    <td style="text-align:center;">
                        <button onclick="openApiModal('rajaongkir')" style="background:transparent;border:none;color:#3B82F6;font-weight:600;cursor:pointer;font-size:.85rem;">Edit ➔</button>
                    </td>
                </tr>
                <!-- Payment API (Midtrans) -->
                <tr>
                    <td style="text-align:center;color:#94A3B8;">2</td>
                    <td>Payment API <span style="font-size:.75rem;color:#94A3B8;display:block;font-weight:400;">Midtrans Gateway</span></td>
                    <td>
                        <div class="api-key-hidden">
                            <button type="button" onclick="toggleApiKey(this)" data-full="{{ $settings->get('midtrans_server_key', '') }}" data-hidden="{{ $settings->get('midtrans_server_key') ? substr($settings->get('midtrans_server_key'), 0, 5) . str_repeat('•', 20) : 'Belum diatur' }}" style="background:none;border:none;cursor:pointer;color:inherit;display:flex;align-items:center;padding:0;">
                                <svg class="icon-hide" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24M1 1l22 22"/></svg>
                                <svg class="icon-show" style="display:none;" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <span class="key-text" style="color:{{ $settings->get('midtrans_server_key') ? '#DC2626' : '#94A3B8' }}; letter-spacing:1px; font-family:monospace;">
                                {{ $settings->get('midtrans_server_key') ? substr($settings->get('midtrans_server_key'), 0, 5) . str_repeat('•', 20) : 'Belum diatur' }}
                            </span>
                        </div>
                    </td>
                    <td style="color:#64748B;font-size:.85rem;">{{ date('d/m/Y') }}</td>
                    <td style="text-align:center;">
                        <button onclick="openApiModal('midtrans')" style="background:transparent;border:none;color:#3B82F6;font-weight:600;cursor:pointer;font-size:.85rem;">Edit ➔</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL RAJAONGKIR --}}
<div id="modal-rajaongkir" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.5);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
  <div style="background:#fff;border-radius:20px;padding:2.5rem;width:100%;max-width:500px;box-shadow:0 24px 64px rgba(0,0,0,0.2);margin:1rem;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
      <h3 style="font-size:1.25rem;font-weight:800;color:#1E293B;margin:0;">Shipping Cost (RajaOngkir)</h3>
      <button onclick="document.getElementById('modal-rajaongkir').style.display='none'" style="background:#F1F5F9;border:none;border-radius:8px;width:32px;height:32px;cursor:pointer;font-size:1rem;color:#64748B;">✕</button>
    </div>
    <form action="{{ route('admin.apikeys.update') }}" method="POST">
      @csrf
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.85rem;font-weight:700;color:#475569;margin-bottom:.5rem;">API Key RajaOngkir</label>
        <input type="text" name="rajaongkir_api_key" value="{{ $settings->get('rajaongkir_api_key', '') }}" required style="width:100%;padding:.875rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.95rem;outline:none;box-sizing:border-box;font-family:inherit;">
      </div>
      <div style="margin-bottom:2rem;">
        <label style="display:block;font-size:.85rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Tipe Akun</label>
        <select name="rajaongkir_type" style="width:100%;padding:.875rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.95rem;outline:none;background:#fff;font-family:inherit;">
          <option value="starter" {{ $settings->get('rajaongkir_type', '') == 'starter' ? 'selected' : '' }}>Starter (Gratis)</option>
          <option value="basic" {{ $settings->get('rajaongkir_type', '') == 'basic' ? 'selected' : '' }}>Basic</option>
          <option value="pro" {{ $settings->get('rajaongkir_type', '') == 'pro' ? 'selected' : '' }}>Pro</option>
        </select>
      </div>
      <div style="display:flex;gap:1rem;">
        <button type="button" onclick="document.getElementById('modal-rajaongkir').style.display='none'" style="flex:1;padding:.875rem;background:#F1F5F9;color:#475569;border:none;border-radius:12px;font-weight:700;cursor:pointer;font-family:inherit;">Batal</button>
        <button type="submit" style="flex:2;padding:.875rem;background:#DC2626;color:#fff;border:none;border-radius:12px;font-weight:700;cursor:pointer;font-family:inherit;">Simpan API Key</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL MIDTRANS --}}
<div id="modal-midtrans" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.5);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
  <div style="background:#fff;border-radius:20px;padding:2.5rem;width:100%;max-width:500px;box-shadow:0 24px 64px rgba(0,0,0,0.2);margin:1rem;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
      <h3 style="font-size:1.25rem;font-weight:800;color:#1E293B;margin:0;">Payment API (Midtrans)</h3>
      <button onclick="document.getElementById('modal-midtrans').style.display='none'" style="background:#F1F5F9;border:none;border-radius:8px;width:32px;height:32px;cursor:pointer;font-size:1rem;color:#64748B;">✕</button>
    </div>
    <form action="{{ route('admin.apikeys.update') }}" method="POST">
      @csrf
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.85rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Environment</label>
        <select name="midtrans_is_production" style="width:100%;padding:.875rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.95rem;outline:none;background:#fff;font-family:inherit;">
          <option value="0" {{ $settings->get('midtrans_is_production', '0') == '0' ? 'selected' : '' }}>Sandbox (Mode Testing)</option>
          <option value="1" {{ $settings->get('midtrans_is_production', '0') == '1' ? 'selected' : '' }}>Production (Live)</option>
        </select>
      </div>
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.85rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Server Key</label>
        <input type="text" name="midtrans_server_key" value="{{ $settings->get('midtrans_server_key', '') }}" required style="width:100%;padding:.875rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.95rem;outline:none;box-sizing:border-box;font-family:inherit;">
      </div>
      <div style="margin-bottom:2rem;">
        <label style="display:block;font-size:.85rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Client Key</label>
        <input type="text" name="midtrans_client_key" value="{{ $settings->get('midtrans_client_key', '') }}" required style="width:100%;padding:.875rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.95rem;outline:none;box-sizing:border-box;font-family:inherit;">
      </div>
      <div style="display:flex;gap:1rem;">
        <button type="button" onclick="document.getElementById('modal-midtrans').style.display='none'" style="flex:1;padding:.875rem;background:#F1F5F9;color:#475569;border:none;border-radius:12px;font-weight:700;cursor:pointer;font-family:inherit;">Batal</button>
        <button type="submit" style="flex:2;padding:.875rem;background:#DC2626;color:#fff;border:none;border-radius:12px;font-weight:700;cursor:pointer;font-family:inherit;">Simpan API Key</button>
      </div>
    </form>
  </div>
</div>

<script>
function openApiModal(type) {
    document.getElementById('modal-' + type).style.display = 'flex';
}
document.getElementById('modal-rajaongkir').addEventListener('click', function(e){ if(e.target===this) this.style.display='none'; });
document.getElementById('modal-midtrans').addEventListener('click', function(e){ if(e.target===this) this.style.display='none'; });

function toggleApiKey(btn) {
    const container = btn.closest('.api-key-hidden');
    const textSpan = container.querySelector('.key-text');
    const iconHide = btn.querySelector('.icon-hide');
    const iconShow = btn.querySelector('.icon-show');
    const fullKey = btn.getAttribute('data-full');
    const hiddenKey = btn.getAttribute('data-hidden');

    if (!fullKey) return;

    if (textSpan.textContent.trim() === hiddenKey) {
        textSpan.textContent = fullKey;
        iconHide.style.display = 'none';
        iconShow.style.display = 'block';
    } else {
        textSpan.textContent = hiddenKey;
        iconHide.style.display = 'block';
        iconShow.style.display = 'none';
    }
}
</script>

@endsection
