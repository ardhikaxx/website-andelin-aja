@extends('layouts.admin')

@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin')

@section('content')
<div class="card-andelin p-4">
    <form action="{{ route('admin.admins.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Konfirmasi Password</label><input type="password" name="password_confirmation" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Telepon</label><input type="text" name="phone" class="form-control"></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-light">Kembali</a>
        </div>
    </form>
</div>
@endsection
