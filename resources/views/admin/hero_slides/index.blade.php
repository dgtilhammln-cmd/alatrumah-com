@extends('layouts.admin')
@section('title', 'Hero Slides')
@section('page-title', 'Hero Slides (Maks. 5 Slide)')
@section('content')

@if(session('success'))
<div style="background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.3);color:#6ee7b7;padding:.875rem 1.25rem;border-radius:10px;margin-bottom:1.5rem;font-size:.875rem;">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#fca5a5;padding:.875rem 1.25rem;border-radius:10px;margin-bottom:1.5rem;font-size:.875rem;">
    {{ $errors->first() }}
</div>
@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <p style="font-size:.875rem;color:rgba(255,255,255,.45);margin:0;">{{ $slides->count() }} / 5 slide aktif</p>
    @if($slides->count() < 5)
    <a href="{{ route('admin.hero_slides.create') }}" class="btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Tambah Slide
    </a>
    @endif
</div>

@if($slides->isEmpty())
<div class="admin-card" style="text-align:center;padding:3rem;">
    <p style="color:rgba(255,255,255,.3);font-size:.9rem;">Belum ada slide. Klik "Tambah Slide" untuk membuat yang pertama.</p>
</div>
@else
<div style="display:flex;flex-direction:column;gap:1rem;">
    @foreach($slides as $slide)
    <div class="admin-card" style="display:flex;align-items:center;gap:1.5rem;">
        {{-- Thumbnail --}}
        <div style="width:100px;height:70px;border-radius:8px;overflow:hidden;flex-shrink:0;background:#1a1a1f;">
            @if($slide->image)
                <img src="{{ asset('storage/'.$slide->image) }}" style="width:100%;height:100%;object-fit:cover;" alt="{{ $slide->title }}">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.2);font-size:.7rem;">No Image</div>
            @endif
        </div>
        {{-- Info --}}
        <div style="flex:1;">
            <div style="font-size:.875rem;font-weight:600;color:#fff;margin-bottom:.25rem;">{{ $slide->title }}</div>
            <div style="font-size:.75rem;color:rgba(255,255,255,.4);line-height:1.4;">{{ Str::limit($slide->description, 80) }}</div>
            <div style="display:flex;gap:.75rem;margin-top:.5rem;align-items:center;">
                @if($slide->button_text)
                    <span style="font-size:.7rem;background:rgba(56,189,248,.1);color:#38BDF8;padding:.2rem .6rem;border-radius:4px;">{{ $slide->button_text }}</span>
                @endif
                @if($slide->button_url)
                    <span style="font-size:.7rem;color:rgba(255,255,255,.3);">→ {{ Str::limit($slide->button_url, 40) }}</span>
                @endif
            </div>
        </div>
        {{-- Order --}}
        <div style="text-align:center;flex-shrink:0;">
            <div style="font-size:.7rem;color:rgba(255,255,255,.3);margin-bottom:.25rem;">Urutan</div>
            <div style="font-size:1.25rem;font-weight:700;color:#fff;">{{ $slide->order }}</div>
        </div>
        {{-- Status --}}
        <div style="flex-shrink:0;">
            <span style="font-size:.7rem;padding:.3rem .75rem;border-radius:20px;{{ $slide->is_active ? 'background:rgba(16,185,129,.15);color:#34d399;' : 'background:rgba(255,255,255,.05);color:rgba(255,255,255,.3);' }}">
                {{ $slide->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
        {{-- Actions --}}
        <div style="display:flex;gap:.5rem;flex-shrink:0;">
            <a href="{{ route('admin.hero_slides.edit', $slide) }}" style="background:rgba(56,189,248,.1);color:#38BDF8;padding:.5rem .875rem;border-radius:6px;font-size:.8rem;text-decoration:none;transition:all .2s;">Edit</a>
            <form method="POST" action="{{ route('admin.hero_slides.destroy', $slide) }}" onsubmit="return confirm('Hapus slide ini?')">
                @csrf @method('DELETE')
                <button type="submit" style="background:rgba(239,68,68,.1);color:#f87171;padding:.5rem .875rem;border-radius:6px;font-size:.8rem;border:none;cursor:pointer;">Hapus</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
