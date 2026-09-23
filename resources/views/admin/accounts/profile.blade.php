@extends('layouts.admin')
@section('title','Pengaturan Profil & Password Saya')
@section('page-title','Profil Saya')
@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
  <div>
    <h1 style="font-size:1.5rem;font-weight:800;color:#1E293B;margin:0 0 .25rem;letter-spacing:-.02em;">Pengaturan Profil & Password Saya</h1>
    <p style="font-size:.875rem;color:#94A3B8;margin:0;">Ubah nama tampilan, email (username login), atau password akun Anda sendiri</p>
  </div>
</div>

@if(session('success'))
  <div style="padding:1rem 1.25rem;background:#ECFDF5;border:1px solid #6EE7B7;border-radius:12px;color:#065F46;font-size:.875rem;font-weight:600;margin-bottom:1.5rem;">
    ✓ {{ session('success') }}
  </div>
@endif

@if($errors->any())
  <div style="padding:1rem 1.25rem;background:#FEF2F2;border:1px solid #FCA5A5;border-radius:12px;color:#991B1B;font-size:.875rem;margin-bottom:1.5rem;">
    <ul style="margin:0;padding-left:1.25rem;">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div style="max-width:680px;background:#fff;border-radius:24px;padding:2rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
  <form method="POST" action="{{ route('admin.profile.update') }}">
    @csrf
    @method('PUT')

    {{-- Nama --}}
    <div style="margin-bottom:1.5rem;">
      <label style="display:block;font-size:.8125rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Nama Lengkap / Tampilan <span style="color:#EF4444;">*</span></label>
      <input type="text" name="name" value="{{ old('name', $user->name) }}" required
             style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.875rem;outline:none;font-family:inherit;">
    </div>

    {{-- Email / Username Login --}}
    <div style="margin-bottom:1.5rem;">
      <label style="display:block;font-size:.8125rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Email (Username Login) <span style="color:#EF4444;">*</span></label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}" required
             style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.875rem;outline:none;font-family:inherit;">
    </div>

    <div style="margin:2rem 0;border-top:1px solid #F1F5F9;padding-top:1.5rem;">
      <h3 style="font-size:1rem;font-weight:700;color:#1E293B;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;">
        <svg width="18" height="18" fill="none" stroke="#1B6FE8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        Ganti Password (Opsional)
      </h3>
      <p style="font-size:.8rem;color:#64748B;margin-top:-.5rem;margin-bottom:1.25rem;">Kosongkan form password di bawah ini jika tidak ingin mengubah password.</p>

      {{-- Current Password --}}
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.8125rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Password Saat Ini</label>
        <input type="password" name="current_password"
               style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.875rem;outline:none;font-family:inherit;" placeholder="Wajib diisi jika ganti password">
      </div>

      {{-- New Password --}}
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.8125rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Password Baru</label>
        <input type="password" name="password"
               style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.875rem;outline:none;font-family:inherit;" placeholder="Minimal 6 karakter">
      </div>

      {{-- New Password Confirmation --}}
      <div style="margin-bottom:1.25rem;">
        <label style="display:block;font-size:.8125rem;font-weight:700;color:#475569;margin-bottom:.5rem;">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation"
               style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:12px;font-size:.875rem;outline:none;font-family:inherit;" placeholder="Ulangi password baru">
      </div>
    </div>

    {{-- SUBMIT --}}
    <button type="submit" style="width:100%;background:#1B6FE8;color:#fff;font-size:.95rem;font-weight:700;padding:.875rem 1.5rem;border:none;border-radius:14px;cursor:pointer;box-shadow:0 4px 18px rgba(27,111,232,0.35);transition:all .2s;">
      Simpan Perubahan Profil
    </button>
  </form>
</div>

@endsection
