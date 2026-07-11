@extends('layouts.admin')

@section('title', 'Buat Tugas')
@section('page-title', 'Buat Tugas')

@section('content')
<div class="card-andelin p-4">
    <form action="{{ route('admin.tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Spesialisasi</label>
            <select name="specialization_id" class="form-select" required>
                <option value="">-- Pilih Spesialisasi --</option>
                @foreach($specializations as $spec)
                    <option value="{{ $spec->id }}" {{ old('specialization_id') == $spec->id ? 'selected' : '' }}>
                        {{ $spec->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" required>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-light">Kembali</a>
    </form>
</div>
@endsection
