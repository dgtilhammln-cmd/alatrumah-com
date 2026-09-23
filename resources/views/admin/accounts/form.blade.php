@extends('layouts.admin')
@section('title', $isEdit ? 'Edit Akun Admin' : 'Tambah Akun Admin')
@section('page-title', $isEdit ? 'Edit Admin' : 'Tambah Admin')
@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
  <div>
    <h1 style="font-size:1.5rem;font-weight:800;color:#1E293B;margin:0 0 .25rem;letter-spacing:-.02em;">
      {{ $isEdit ? 'Edit Akun Admin: ' . $admin->name : 'Tambah Akun Admin Baru' }}
    </h1>
    <p style="font-size:.875rem;color:#94A3B8;margin:0;">Atur kredensial login dan centang menu mana saja yang boleh dibuka</p>
  </div>
  <a href="{{ route('admin.accounts.index') }}" style="display:inline-flex;align-items:center;gap:.5rem;background:#F1F5F9;color:#475569;font-size:.875rem;font-weight:700;padding:.625rem 1.25rem;border-radius:12px;text-decoration:none;">
    ← Kembali
  </a>
</div>

@if($errors->any())
  <div style="padding:1rem 1.25rem;background:#FEF2F2;border:1px solid #FCA5A5;border-radius:12px;color:#991B1B;font-size:.875rem;margin-bottom:1.5rem;">
    <ul style="margin:0;padding-left:1.25rem;">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ $isEdit ? route('admin.accounts.update', $admin->id) : route('admin.accounts.store') }}">
  @csrf
  @if($isEdit)
    @method('PUT')
  @endif

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    
    {{-- CARD 1: KREDENSIAL --}}
    <div style="background:#fff;border-radius:24px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
      <h2 style="font-size:1.1rem;font-weight:700;color:#1E293B;margin-bottom:1.25rem;display:flex;align-items:center;gap:.5rem;">
        <svg width="20" height="20" fill="none" stroke="#1B6FE8" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Informasi Akun & Login
      </h2>

      {{-- Nama --}}
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.8125rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Nama Admin <span style="color:#EF4444;">*</span></label>
        <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
               style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.875rem;outline:none;font-family:inherit;" placeholder="Contoh: Budi Santoso">
      </div>

      {{-- Email (Username) --}}
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.8125rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Email (Username Login) <span style="color:#EF4444;">*</span></label>
        <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
               style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.875rem;outline:none;font-family:inherit;" placeholder="admin@alatrumah.com">
      </div>

      {{-- Role --}}
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.8125rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Role Admin <span style="color:#EF4444;">*</span></label>
        <select name="role" id="role-select" onchange="togglePermissionSection(this.value)"
                style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.875rem;outline:none;font-family:inherit;background:#fff;">
          <option value="admin" {{ old('role', $admin->role) === 'admin' ? 'selected' : '' }}>Admin Biasa (Akses Berdasarkan Permission)</option>
          <option value="super_admin" {{ old('role', $admin->role) === 'super_admin' ? 'selected' : '' }}>⚡ Super Admin (Akses Penuh Semua Menu)</option>
        </select>
      </div>

      {{-- Password --}}
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.8125rem;font-weight:700;color:#475569;margin-bottom:.5rem;">
          Password {{ $isEdit ? '(Kosongkan jika tidak diganti)' : '*' }}
        </label>
        <input type="password" name="password" {{ $isEdit ? '' : 'required' }}
               style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.875rem;outline:none;font-family:inherit;" placeholder="Minimal 6 karakter">
      </div>

      {{-- Password Confirmation --}}
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.8125rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Konfirmasi Password</label>
        <input type="password" name="password_confirmation"
               style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.875rem;outline:none;font-family:inherit;" placeholder="Ulangi password">
      </div>

      {{-- Status Active --}}
      <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #F1F5F9;">
        <label style="display:inline-flex;align-items:center;gap:.75rem;cursor:pointer;">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active', $admin->is_active ?? true) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#1B6FE8;">
          <span style="font-size:.875rem;font-weight:700;color:#1E293B;">Akun Aktif (Dapat Login)</span>
        </label>
      </div>
    </div>

    {{-- CARD 2: PERMISSIONS (HAK AKSES SIDEBAR) --}}
    <div style="background:#fff;border-radius:24px;padding:1.75rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
        <h2 style="font-size:1.1rem;font-weight:700;color:#1E293B;margin:0;display:flex;align-items:center;gap:.5rem;">
          <svg width="20" height="20" fill="none" stroke="#1B6FE8" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          Hak Akses Menu (Permissions)
        </h2>
        <div id="select-all-btn" style="display:flex;gap:.5rem;">
          <button type="button" onclick="checkAllPerms(true)" style="font-size:.75rem;font-weight:700;color:#1B6FE8;background:#EEF2FF;border:none;padding:.3rem .6rem;border-radius:6px;cursor:pointer;">Pilih Semua</button>
          <button type="button" onclick="checkAllPerms(false)" style="font-size:.75rem;font-weight:700;color:#64748B;background:#F1F5F9;border:none;padding:.3rem .6rem;border-radius:6px;cursor:pointer;">Kosongkan</button>
        </div>
      </div>

      <div id="super-admin-notice" style="display:none;padding:1rem;background:#F0FDF4;border:1px solid #BBF7D0;border-radius:12px;color:#166534;font-size:.85rem;margin-bottom:1.25rem;">
        ⚡ <strong>Super Admin</strong> memiliki akses penuh ke seluruh menu secara otomatis.
      </div>

      <div id="permissions-grid" style="display:grid;grid-template-columns:1fr;gap:.625rem;max-height:420px;overflow-y:auto;padding-right:.5rem;">
        @php
          $currentPerms = old('admin_permissions', $admin->admin_permissions ?? []);
        @endphp

        @foreach($permissions as $key => $label)
          <label style="display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;cursor:pointer;transition:all .15s;" onmouseover="this.style.borderColor='#1B6FE8'" onmouseout="this.style.borderColor='#E2E8F0'">
            <div style="display:flex;align-items:center;gap:.75rem;">
              <input type="checkbox" class="perm-checkbox" name="admin_permissions[]" value="{{ $key }}"
                     {{ in_array($key, $currentPerms) ? 'checked' : '' }}
                     style="width:18px;height:18px;accent-color:#1B6FE8;">
              <span style="font-size:.875rem;font-weight:600;color:#334155;">{{ $label }}</span>
            </div>
            <span style="font-size:.7rem;font-weight:700;color:#94A3B8;background:#fff;padding:.15rem .45rem;border-radius:4px;border:1px solid #E2E8F0;">{{ $key }}</span>
          </label>
        @endforeach
      </div>
    </div>
  </div>

  {{-- SUBMIT BUTTON --}}
  <div style="margin-top:2rem;display:flex;justify-content:flex-end;">
    <button type="submit" style="background:#1B6FE8;color:#fff;font-size:.95rem;font-weight:700;padding:.875rem 2.5rem;border:none;border-radius:14px;cursor:pointer;box-shadow:0 4px 18px rgba(27,111,232,0.35);transition:all .2s;">
      {{ $isEdit ? 'Simpan Perubahan' : 'Buat Akun Admin' }}
    </button>
  </div>
</form>

<script>
function togglePermissionSection(role) {
  const notice = document.getElementById('super-admin-notice');
  const grid = document.getElementById('permissions-grid');
  const btn = document.getElementById('select-all-btn');

  if (role === 'super_admin') {
    notice.style.display = 'block';
    grid.style.opacity = '0.5';
    btn.style.display = 'none';
  } else {
    notice.style.display = 'none';
    grid.style.opacity = '1';
    btn.style.display = 'flex';
  }
}

function checkAllPerms(checked) {
  const checkboxes = document.querySelectorAll('.perm-checkbox');
  checkboxes.forEach(cb => cb.checked = checked);
}

document.addEventListener('DOMContentLoaded', function() {
  togglePermissionSection(document.getElementById('role-select').value);
});
</script>

@endsection
