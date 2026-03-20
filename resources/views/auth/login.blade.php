@extends('layouts.auth')

@section('page_title', 'Login')

@section('auth_content')
<div class="auth-card">
    <span class="auth-kicker"><i class="fas fa-lock"></i> Akses Sistem</span>
    <h2 class="auth-title">Masuk ke akun Anda</h2>
    <p class="auth-subtitle">Gunakan email dan password terdaftar untuk masuk ke sistem operasional Andelin Aja.</p>

    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="fas fa-key"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
        </div>
        <div class="auth-meta mb-4">
            <span style="color: var(--color-text-secondary); font-size: .88rem;">Masuk sesuai akun yang terdaftar.</span>
            <a href="{{ route('password.request') }}" class="auth-link">Lupa password?</a>
        </div>
        <button class="auth-button" type="submit">
            <i class="fas fa-right-to-bracket me-2"></i> Masuk
        </button>
    </form>

    <div class="info-box">
        <span class="info-label">Akun demo</span>
        <div class="info-item">
            <i class="fas fa-user-shield"></i>
            <span>Admin: <strong>admin@andelin.com</strong> / <strong>password</strong></span>
        </div>
        <div class="info-item">
            <i class="fas fa-user"></i>
            <span>Karyawan: <strong>karyawan1@andelin.com</strong> / <strong>password</strong></span>
        </div>
    </div>
</div>
@endsection