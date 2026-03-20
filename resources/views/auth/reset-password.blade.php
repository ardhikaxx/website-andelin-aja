@extends('layouts.auth')

@section('page_title', 'Ubah Password Baru')

@section('auth_content')
<div class="auth-card">
    <span class="auth-kicker"><i class="fas fa-key"></i> Password Baru</span>
    <h2 class="auth-title">Ubah password baru</h2>
    <p class="auth-subtitle">Email sudah dikenali oleh sistem. Masukkan password baru Anda, lalu setelah berhasil Anda akan diarahkan kembali ke halaman login.</p>

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email Terverifikasi</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="fas fa-envelope-circle-check"></i></span>
                <input type="email" class="form-control" value="{{ $email }}" readonly>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password baru" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Konfirmasi Password Baru</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="fas fa-shield-heart"></i></span>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
            </div>
        </div>
        <button class="auth-button" type="submit">
            <i class="fas fa-floppy-disk me-2"></i> Simpan Password Baru
        </button>
    </form>

    <div class="auth-meta">
        <a href="{{ route('password.request') }}" class="auth-link"><i class="fas fa-arrow-left me-1"></i> Kembali ke verifikasi email</a>
    </div>
</div>
@endsection