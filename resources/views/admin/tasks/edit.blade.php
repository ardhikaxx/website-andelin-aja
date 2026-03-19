@extends('layouts.admin')

@section('title', 'Edit Tugas')
@section('page-title', 'Edit Tugas')

@section('content')
<div class="card-andelin p-4">
    <form action="{{ route('admin.tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description', $task->description) }}</textarea>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Deadline</label>
                <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $task->deadline->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    @foreach(['pending','in_progress','done'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $task->status) === $status)>{{ str_replace('_', ' ', $status) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-light">Kembali</a>
        </div>
    </form>
</div>
@endsection
