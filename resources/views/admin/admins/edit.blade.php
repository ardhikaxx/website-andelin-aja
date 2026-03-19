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
            <div class="col-md-6"><label class="form-label">Password Baru</label><input type="password" name="password" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Telepon</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $admin->phone) }}"></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-light">Kembali</a>
        </div>
    </form>
</div>
@endsection
