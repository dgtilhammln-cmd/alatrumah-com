{{-- Shared Image Upload Partial --}}
{{-- Usage: @include('admin.partials.image-upload', ['item'=>$item??null,'field'=>'image','label'=>'Foto Utama','required'=>true]) --}}
@php
  $imgField      = $field    ?? 'image';
  $imgLabel      = $label    ?? 'Gambar';
  $imgRequired   = $required ?? false;
  $imgItem       = $item     ?? null;
  $imgPreviewId  = 'prev_'.Str::random(6);
  $imgInputId    = 'inp_'.Str::random(6);
  $currentSrc    = $imgItem && $imgItem->{$imgField} ? asset('storage/'.$imgItem->{$imgField}) : null;
@endphp

<div style="background:#fff;border-radius:20px;padding:1.5rem;box-shadow:0 2px 20px rgba(0,0,0,0.04);">
  {{-- Header --}}
  <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.125rem;">
    <div style="width:32px;height:32px;background:rgba(59,130,246,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
      <svg width="16" height="16" fill="none" stroke="#3B82F6" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
    </div>
    <h3 style="font-size:.875rem;font-weight:800;color:#1E293B;margin:0;">{{ $imgLabel }}</h3>
  </div>

@php $outBg = $currentSrc ? 'transparent' : '#F8FAFC'; @endphp
  {{-- Preview Area --}}
  <div id="drop_{{ $imgPreviewId }}" onclick="document.getElementById('{{ $imgInputId }}').click()"
       style="position:relative;border-radius:14px;overflow:hidden;cursor:pointer;border:2px dashed #E4E7F0;transition:all .2s;background:#F8FAFC;min-height:140px;display:flex;align-items:center;justify-content:center;"
       onmouseover="this.style.borderColor='#3B82F6';this.style.background='#F0F6FF'" onmouseout="this.style.borderColor='#E4E7F0';this.style.background='{{ $outBg }}'">

    @if($currentSrc)
      <img id="{{ $imgPreviewId }}" src="{{ $currentSrc }}"
           style="width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:12px;display:block;">
      <div style="position:absolute;inset:0;background:rgba(0,0,0,0);transition:background .2s;display:flex;align-items:center;justify-content:center;opacity:0;" id="overlay_{{ $imgPreviewId }}"
           onmouseover="this.style.opacity='1';this.style.background='rgba(0,0,0,0.4)'" onmouseout="this.style.opacity='0';this.style.background='rgba(0,0,0,0)'">
        <div style="color:#fff;font-size:.8rem;font-weight:700;display:flex;flex-direction:column;align-items:center;gap:.375rem;">
          <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          Ganti Foto
        </div>
      </div>
    @else
      <div id="{{ $imgPreviewId }}_placeholder" style="display:flex;flex-direction:column;align-items:center;gap:.625rem;padding:2rem;text-align:center;">
        <div style="width:48px;height:48px;background:#EFF6FF;border-radius:12px;display:flex;align-items:center;justify-content:center;">
          <svg width="22" height="22" fill="none" stroke="#3B82F6" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        </div>
        <div>
          <div style="font-size:.85rem;font-weight:700;color:#1E293B;">Klik untuk upload</div>
          <div style="font-size:.75rem;color:#94A3B8;margin-top:.2rem;">JPG, PNG, WebP — Maks 8MB</div>
        </div>
      </div>
      <img id="{{ $imgPreviewId }}" src="" style="display:none;width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:12px;">
    @endif
  </div>

  {{-- Hidden input --}}
  <input type="file" id="{{ $imgInputId }}" name="{{ $imgField }}" accept="image/*"
         {{ $imgRequired && !$imgItem ? 'required' : '' }}
         onchange="previewImgPremium(this,'{{ $imgPreviewId }}')"
         style="display:none;">

  {{-- Info --}}
  <div style="display:flex;align-items:center;gap:.375rem;margin-top:.75rem;font-size:.72rem;color:#94A3B8;">
    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    Auto convert ke WebP + kompres otomatis. Rasio ideal 16:9.
  </div>
</div>

<script>
function previewImgPremium(input, id) {
  if (!input.files || !input.files[0]) return;
  var img = document.getElementById(id);
  var placeholder = document.getElementById(id + '_placeholder');
  img.src = URL.createObjectURL(input.files[0]);
  img.style.display = 'block';
  if (placeholder) placeholder.style.display = 'none';
}
</script>
