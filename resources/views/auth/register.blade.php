@extends('auth.layout')

@section('title', 'Daftar – Alat Rumah')

@section('content')
<h1 class="auth-title">Buat Akun Baru</h1>
<p class="auth-subtitle">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>

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

<form method="POST" action="{{ route('register.submit') }}" id="registerForm">
    @csrf
    
    <!-- STEP 1 -->
    <div id="step1">
        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap <span>*</span></label>
            <input type="text" id="name" name="name" class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                   placeholder="Nama lengkap Anda" value="{{ old('name') }}" autocomplete="name" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email <span>*</span></label>
            <input type="email" id="email" name="email" class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                   placeholder="contoh@email.com" value="{{ old('email') }}" autocomplete="email" required>
        </div>

        <button type="button" class="btn-primary" style="margin-top:0.5rem;" onclick="nextStep()">Selanjutnya</button>
    </div>

    <!-- STEP 2 -->
    <div id="step2" style="display: none;">
        <button type="button" onclick="prevStep()" style="background:none; border:none; color:#64748B; font-size:0.8rem; font-weight:600; cursor:pointer; margin-bottom:1rem; display:flex; align-items:center; gap:0.25rem;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
            Kembali
        </button>

        <div class="form-group">
            <label class="form-label" for="phone">No. WhatsApp</label>
            <input type="tel" id="phone" name="phone" class="form-input"
                   placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" autocomplete="tel">
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Kata Sandi <span>*</span></label>
            <div class="input-wrap">
                <input type="password" id="password" name="password" class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                       placeholder="Minimal 8 karakter" autocomplete="new-password" oninput="checkPasswordStrength(this.value)">
                <span class="input-icon" onclick="togglePwd('password', this)">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </span>
            </div>
            <div id="pwd-reqs" style="margin-top:0.5rem;font-size:0.75rem;color:#64748B;line-height:1.4;">
                <div style="font-weight:600;margin-bottom:0.25rem;">Kata sandi harus mengandung:</div>
                <div id="req-len" style="display:flex;align-items:center;gap:0.3rem;"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg> Minimal 8 karakter</div>
                <div id="req-let" style="display:flex;align-items:center;gap:0.3rem;"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg> Huruf</div>
                <div id="req-num" style="display:flex;align-items:center;gap:0.3rem;"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg> Angka</div>
                <div id="req-sym" style="display:flex;align-items:center;gap:0.3rem;"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg> Simbol (misal: !@#$%)</div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi <span>*</span></label>
            <div class="input-wrap">
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="form-input" placeholder="Ulangi kata sandi" autocomplete="new-password">
                <span class="input-icon" onclick="togglePwd('password_confirmation', this)">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </span>
            </div>
        </div>

        <button type="submit" class="btn-primary" style="margin-top:0.5rem;" id="submitBtn">Buat Akun</button>
    </div>
</form>



<p style="text-align:center; font-size:0.75rem; color:#94A3B8; margin-top:1.5rem; line-height:1.6;">
    Dengan mendaftar, Anda menyetujui <a href="#" style="color:#0EA5E9;">Syarat & Ketentuan</a><br>dan <a href="#" style="color:#0EA5E9;">Kebijakan Privasi</a> kami.
</p>

<script>
function togglePwd(id) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
}

function nextStep() {
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    
    // Basic validation before next step
    if(!name.value || !email.value) {
        alert('Mohon lengkapi Nama dan Email terlebih dahulu.');
        return;
    }
    if(!email.value.includes('@')) {
        alert('Mohon masukkan email yang valid.');
        return;
    }
    
    document.getElementById('step1').style.display = 'none';
    document.getElementById('step2').style.display = 'block';
    
    // Required for step 2
    document.getElementById('password').required = true;
    document.getElementById('password_confirmation').required = true;
}

function prevStep() {
    document.getElementById('step2').style.display = 'none';
    document.getElementById('step1').style.display = 'block';
    
    // Remove required to prevent HTML5 validation error when hidden
    document.getElementById('password').required = false;
    document.getElementById('password_confirmation').required = false;
}
function updateReq(id, isValid, text) {
    const el = document.getElementById(id);
    const iconPass = '<svg width="12" height="12" fill="none" stroke="#10B981" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>';
    const iconWait = '<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>';
    
    el.style.color = isValid ? '#10B981' : '#64748B';
    el.innerHTML = (isValid ? iconPass : iconWait) + ' ' + text;
}

function checkPasswordStrength(pwd) {
    updateReq('req-len', pwd.length >= 8, 'Minimal 8 karakter');
    updateReq('req-let', /[a-zA-Z]/.test(pwd), 'Huruf');
    updateReq('req-num', /[0-9]/.test(pwd), 'Angka');
    updateReq('req-sym', /[^a-zA-Z0-9]/.test(pwd), 'Simbol (misal: !@#$%)');
}
</script>
@endsection
