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

<form method="POST" action="{{ route('login.submit') }}">
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
        {{-- <a href="#" class="forgot-link">Lupa sandi?</a> --}}
    </div>

    <button type="submit" class="btn-primary">Masuk</button>
</form>



<script>
function togglePwd(id, el) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
}
</script>
@endsection
