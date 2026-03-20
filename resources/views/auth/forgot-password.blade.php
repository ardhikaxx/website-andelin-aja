@extends('layouts.auth')

@section('page_title', 'Lupa Password')

@section('auth_content')
<div class="auth-card">
    <span class="auth-kicker"><i class="fas fa-envelope-circle-check"></i> Verifikasi Email</span>
    <h2 class="auth-title">Lupa password</h2>
    <p class="auth-subtitle">Masukkan email yang terdaftar. Sistem akan memeriksa apakah email dikenali sebelum Anda diarahkan ke halaman ubah password baru.</p>

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="form-label">Email</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email terdaftar" required>
            </div>
        </div>
        <button class="auth-button" type="submit">
            <i class="fas fa-arrow-right me-2"></i> Verifikasi Email
        </button>
    </form>

    <div class="auth-meta">
        <a href="{{ route('login') }}" class="auth-link"><i class="fas fa-arrow-left me-1"></i> Kembali ke login</a>
    </div>
</div>
@endsection