@extends('auth.layout')

@section('title', 'Masuk – Alat Rumah')

@section('content')
<h1 class="auth-title">Selamat datang!</h1>
<p class="auth-subtitle">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>

@if($errors->any())
    <div class="alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    </div>
@endif

<form method="POST" action="{{ route('login.submit') }}" id="loginForm">
    @csrf
    <div class="form-group">
        <label class="form-label" for="email">Email <span>*</span></label>
        <input type="email" id="email" name="email" class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
               placeholder="contoh@email.com" value="{{ old('email') }}" autocomplete="email" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Kata Sandi <span>*</span></label>
        <div class="input-wrap">
            <input type="password" id="password" name="password" class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                   placeholder="••••••••" autocomplete="current-password" required>
            <span class="input-icon" onclick="togglePwd('password', this)">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </span>
        </div>
    </div>

    <div class="remember-row">
        <label class="remember-label">
            <input type="checkbox" name="remember"> Ingat saya
        </label>
        <a href="javascript:void(0)" class="forgot-link" onclick="toggleResetForm()">Lupa sandi?</a>
    </div>

    <button type="submit" class="btn-primary">Masuk</button>
</form>

<form method="POST" action="#" id="resetForm" style="display: none;">
    <p style="font-size: 0.9rem; color: #475569; margin-bottom: 1rem; line-height: 1.5;">Masukkan email Anda dan alasan reset password. Permintaan akan diteruskan ke admin via WhatsApp.</p>
    <div class="form-group">
        <label class="form-label" for="reset_email">Email <span>*</span></label>
        <input type="email" id="reset_email" class="form-input" placeholder="contoh@email.com" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="reset_reason">Alasan Reset <span>*</span></label>
        <textarea id="reset_reason" class="form-input" placeholder="Contoh: Saya lupa kata sandi saya" rows="3" required style="resize: vertical; font-family: inherit;"></textarea>
    </div>
    
    @php
        $wa = \App\Models\WaSetting::primary();
        $waNumber = $wa ? preg_replace('/[^0-9]/', '', $wa->number) : '';
        if (substr($waNumber, 0, 1) === '0') {
            $waNumber = '62' . substr($waNumber, 1);
        }
    @endphp

    <button type="button" class="btn-primary" onclick="sendResetWhatsApp('{{ $waNumber }}')">Kirim Permintaan ke WhatsApp</button>
    <div style="text-align: center; margin-top: 1rem;">
        <a href="javascript:void(0)" onclick="toggleResetForm()" style="color: #64748B; text-decoration: none; font-size: 0.85rem; font-weight: 500;">Batal & Kembali ke Login</a>
    </div>
</form>



<script>
function togglePwd(id, el) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
}

function toggleResetForm() {
    const loginForm = document.getElementById('loginForm');
    const resetForm = document.getElementById('resetForm');
    const title = document.querySelector('.auth-title');
    const subtitle = document.querySelector('.auth-subtitle');
    
    if (loginForm.style.display === 'none') {
        loginForm.style.display = 'block';
        resetForm.style.display = 'none';
        title.innerText = 'Selamat datang!';
        subtitle.style.display = 'block';
    } else {
        loginForm.style.display = 'none';
        resetForm.style.display = 'block';
        title.innerText = 'Reset Kata Sandi';
        subtitle.style.display = 'none';
    }
}

function sendResetWhatsApp(waNumber) {
    const email = document.getElementById('reset_email').value;
    const reason = document.getElementById('reset_reason').value;
    
    if (!email || !reason) {
        alert('Mohon lengkapi email dan alasan reset terlebih dahulu.');
        return;
    }
    
    if (!waNumber) {
        alert('Nomor WhatsApp admin belum diatur sistem.');
        return;
    }
    
    const text = `Halo Admin Alat Rumah,%0A%0ASaya ingin mereset kata sandi akun saya.%0A%0A*Email:* ${email}%0A*Alasan:* ${reason}%0A%0AMohon bantuannya untuk mereset kata sandi saya. Terima kasih.`;
    const waUrl = `https://wa.me/${waNumber}?text=${text}`;
    
    window.open(waUrl, '_blank');
}
</script>
@endsection
