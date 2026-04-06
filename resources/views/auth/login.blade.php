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
            <div class="input-wrap position-relative">
                <span class="input-icon"><i class="fas fa-key"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required id="password-input">
                <span class="position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password-input', 'toggle-icon')">
                    <i class="fas fa-eye-slash text-muted" id="toggle-icon"></i>
                </span>
            </div>
        </div>
        <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
        </script>
        <div class="auth-meta mb-4">
            <span style="color: var(--color-text-secondary); font-size: .88rem;">Masuk sesuai akun yang terdaftar.</span>
            <a href="{{ route('password.request') }}" class="auth-link">Lupa password?</a>
        </div>
        <button class="auth-button" type="submit">
            <i class="fas fa-right-to-bracket me-2"></i> Masuk
        </button>
    </form>
</div>
@endsection