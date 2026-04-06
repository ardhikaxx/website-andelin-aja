@extends('layouts.admin')

@section('title', 'Edit Karyawan')
@section('page-title', 'Edit Karyawan')

@section('content')
<div class="card-andelin p-4">
    <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Foto Karyawan</label>
                @if($employee->photo)
                <div class="mb-2">
                    <img src="{{ $employee->photo ? '/photos/' . basename($employee->photo) : '' }}" alt="Foto" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remove_photo" value="1" id="remove_photo">
                    <label class="form-check-label" for="remove_photo">Hapus foto</label>
                </div>
                @endif
                <input type="file" name="photo" class="form-control mt-2" accept="image/*">
                <small class="text-muted">Format: jpg, png, jpeg, gif, webp. Max 2MB</small>
            </div>
            <div class="col-md-8">
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
                        <label class="form-label">Password Baru (Opsional)</label>
                        <div class="position-relative">
                            <input type="password" name="password" class="form-control" id="password">
                            <span class="position-absolute end-0 top-50 translate-middle-y" style="top: 70%; right: 10px; cursor: pointer;" onclick="togglePassword('password', 'toggle-password')"><i class="fas fa-eye-slash text-muted" id="toggle-password"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="position-relative">
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                            <span class="position-absolute end-0 top-50 translate-middle-y" style="top: 70%; right: 10px; cursor: pointer;" onclick="togglePassword('password_confirmation', 'toggle-confirm')"><i class="fas fa-eye-slash text-muted" id="toggle-confirm"></i></span>
                        </div>
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
                </div>
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