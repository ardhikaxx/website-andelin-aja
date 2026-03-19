@extends('layouts.admin')

@section('title', 'Edit Karyawan')
@section('page-title', 'Edit Karyawan')

@section('content')
<div class="card-andelin p-4">
    <form action="{{ route('admin.employees.update', $employee) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $employee->user->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $employee->user->email) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->user->phone) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Posisi</label>
                <select name="position" class="form-select" required>
                    @foreach(['pengawas_1','pengawas_2','senior_team','junior_team'] as $position)
                    <option value="{{ $position }}" @selected(old('position', $employee->position) === $position)>{{ str_replace('_', ' ', $position) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label d-block">Spesialisasi</label>
                <div class="row g-2">
                    @foreach($specializations as $specialization)
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="specializations[]" value="{{ $specialization->id }}" id="spec-{{ $specialization->id }}" @checked($employee->specializations->contains($specialization->id))>
                            <label class="form-check-label" for="spec-{{ $specialization->id }}">{{ $specialization->name }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-light">Kembali</a>
        </div>
    </form>
</div>
@endsection
