@extends('layouts.employee')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="card-andelin p-4">
    <form action="{{ route('employee.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required></div>
            <div class="col-md-6"><label class="form-label">Telepon</label><input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}"></div>
            <div class="col-md-6"><label class="form-label">Password Lama</label><input type="password" name="current_password" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Password Baru</label><input type="password" name="password" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" class="form-control"></div>
        </div>
        <div class="mt-4"><button class="btn btn-primary">Simpan Perubahan</button></div>
    </form>
</div>
@endsection
