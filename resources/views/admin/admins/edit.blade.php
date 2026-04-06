@extends('layouts.admin')

@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')

@section('content')
<div class="card-andelin p-4">
    <form action="{{ route('admin.admins.update', $admin) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required></div>
            <div class="col-md-6 position-relative"><label class="form-label">Password Baru</label><input type="password" name="password" class="form-control" id="password"><span class="position-absolute end-0 top-50 translate-middle-y" style="top: 70%; right: 10px; cursor: pointer;" onclick="togglePassword('password', 'toggle-password')"><i class="fas fa-eye-slash text-muted" id="toggle-password"></i></span></div>
            <div class="col-md-6 position-relative"><label class="form-label">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" class="form-control" id="password_confirmation"><span class="position-absolute end-0 top-50 translate-middle-y" style="top: 70%; right: 10px; cursor: pointer;" onclick="togglePassword('password_confirmation', 'toggle-confirm')"><i class="fas fa-eye-slash text-muted" id="toggle-confirm"></i></span></div>
            <div class="col-md-6"><label class="form-label">Telepon</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $admin->phone) }}"></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-light">Kembali</a>
        </div>
    </form>
    <script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") { input.type = "text"; icon.classList.remove("fa-eye-slash"); icon.classList.add("fa-eye"); }
        else { input.type = "password"; icon.classList.remove("fa-eye"); icon.classList.add("fa-eye-slash"); }
    }
    </script>
</div>
@endsection
