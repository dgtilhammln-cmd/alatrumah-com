@extends('layouts.admin')
@section('title','Kelola Akun Admin')
@section('page-title','Akun Admin')
@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
  <div>
    <h1 style="font-size:1.5rem;font-weight:800;color:#1E293B;margin:0 0 .25rem;letter-spacing:-.02em;">Kelola Akun Admin</h1>
    <p style="font-size:.875rem;color:#94A3B8;margin:0;">Atur kredensial login dan hak akses (permission) sidebar per akun</p>
  </div>
  <a href="{{ route('admin.accounts.create') }}" style="display:inline-flex;align-items:center;gap:.5rem;background:#1B6FE8;color:#fff;font-size:.875rem;font-weight:700;padding:.625rem 1.25rem;border-radius:12px;text-decoration:none;transition:all .2s;box-shadow:0 4px 14px rgba(27,111,232,0.35);">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Tambah Akun Admin
  </a>
</div>

@if(session('error'))
  <div style="padding:1rem 1.25rem;background:#FEF2F2;border:1px solid #FCA5A5;border-radius:12px;color:#991B1B;font-size:.875rem;font-weight:600;margin-bottom:1.5rem;">
    {{ session('error') }}
  </div>
@endif

{{-- TABLE CARD --}}
<div style="background:#fff;border-radius:24px;box-shadow:0 2px 20px rgba(0,0,0,0.04);overflow:hidden;">
  <table style="width:100%;border-collapse:collapse;">
    <thead>
      <tr style="background:#F8FAFC;">
        <th style="padding:1rem 1.5rem;text-align:left;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">Admin</th>
        <th style="padding:1rem 1.5rem;text-align:left;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">Role</th>
        <th style="padding:1rem 1.5rem;text-align:left;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">Hak Akses Menu (Permissions)</th>
        <th style="padding:1rem 1.5rem;text-align:center;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">Status</th>
        <th style="padding:1rem 1.5rem;text-align:center;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($admins as $adm)
      <tr style="border-bottom:1px solid #F8FAFC;transition:background .15s;" onmouseover="this.style.background='#FAFBFF'" onmouseout="this.style.background='transparent'">
        
        {{-- Name & Email --}}
        <td style="padding:1.25rem 1.5rem;">
          <div style="font-size:.95rem;font-weight:700;color:#1E293B;">{{ $adm->name }}</div>
          <div style="font-size:.8rem;color:#64748B;">{{ $adm->email }}</div>
        </td>

        {{-- Role --}}
        <td style="padding:1.25rem 1.5rem;">
          @if($adm->isSuperAdmin())
            <span style="display:inline-block;padding:.25rem .75rem;background:#EEF2FF;color:#4F46E5;font-size:.75rem;font-weight:800;border-radius:20px;border:1px solid #C7D2FE;">
              ⚡ Super Admin
            </span>
          @else
            <span style="display:inline-block;padding:.25rem .75rem;background:#F1F5F9;color:#475569;font-size:.75rem;font-weight:700;border-radius:20px;">
              🛡️ Admin
            </span>
          @endif
        </td>

        {{-- Permissions --}}
        <td style="padding:1.25rem 1.5rem;max-width:350px;">
          @if($adm->isSuperAdmin())
            <span style="font-size:.8rem;color:#10B981;font-weight:600;">Semua Menu (Akses Penuh)</span>
          @else
            @php $perms = $adm->admin_permissions ?? []; @endphp
            @if(count($perms) > 0)
              <div style="display:flex;flex-wrap:wrap;gap:.35rem;">
                @foreach(array_slice($perms, 0, 5) as $p)
                  <span style="font-size:.7rem;padding:.15rem .45rem;background:#F3F4F6;color:#374151;border-radius:6px;font-weight:600;">{{ $p }}</span>
                @endforeach
                @if(count($perms) > 5)
                  <span style="font-size:.7rem;padding:.15rem .45rem;background:#E5E7EB;color:#4B5563;border-radius:6px;font-weight:700;">+{{ count($perms) - 5 }} lainnya</span>
                @endif
              </div>
            @else
              <span style="font-size:.8rem;color:#EF4444;font-style:italic;">Belum ada akses menu</span>
            @endif
          @endif
        </td>

        {{-- Status --}}
        <td style="padding:1.25rem 1.5rem;text-align:center;">
          @if($adm->is_active)
            <span style="display:inline-block;padding:.2rem .6rem;background:#ECFDF5;color:#059669;font-size:.75rem;font-weight:700;border-radius:20px;">Aktif</span>
          @else
            <span style="display:inline-block;padding:.2rem .6rem;background:#FEF2F2;color:#DC2626;font-size:.75rem;font-weight:700;border-radius:20px;">Nonaktif</span>
          @endif
        </td>

        {{-- Aksi --}}
        <td style="padding:1.25rem 1.5rem;text-align:center;">
          <div style="display:inline-flex;gap:.5rem;align-items:center;">
            {{-- Edit --}}
            <a href="{{ route('admin.accounts.edit', $adm->id) }}" title="Edit"
               style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;background:rgba(27,111,232,0.08);border-radius:8px;color:#1B6FE8;text-decoration:none;">
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </a>

            {{-- Hapus (kecuali diri sendiri) --}}
            @if($adm->id !== session('admin_id'))
              <form method="POST" action="{{ route('admin.accounts.destroy', $adm->id) }}" style="margin:0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" title="Hapus" style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;background:rgba(239,68,68,0.08);border:none;border-radius:8px;color:#EF4444;cursor:pointer;">
                  <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </button>
              </form>
            @endif
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5" style="padding:3rem;text-align:center;color:#94A3B8;font-size:.875rem;">
          Belum ada akun admin terdaftar.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection
