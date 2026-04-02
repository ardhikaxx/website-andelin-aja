@extends('layouts.admin')

@section('title', 'Penugasan')
@section('page-title', 'Manajemen Penugasan')

@section('content')
<div class="card-andelin p-4 mb-4">
    <h5 class="mb-3">Assign Tugas Manual</h5>
    <form action="{{ route('admin.assignments.store') }}" method="POST">
        @csrf
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Tugas</label>
                <select name="task_id" class="form-select select2" required>
                    <option value="">Pilih tugas</option>
                    @foreach($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Karyawan</label>
                <select name="employee_ids[]" class="form-select select2" multiple required>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Simpan</button>
            </div>
        </div>
    </form>
</div>
<div class="card-andelin p-4">
    <h5 class="mb-3">Existing Assignments</h5>
    <div class="table-responsive">
        <table class="table table-andelin align-middle mb-0">
            <thead>
                <tr>
                    <th>Tugas</th>
                    <th>Karyawan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->employees->pluck('user.name')->join(', ') ?: '-' }}</td>
                    <td>
                        <form id="delete-assignment-{{ $task->id }}" action="{{ route('admin.assignments.destroy', $task) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('delete-assignment-{{ $task->id }}')">Hapus Assignment</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center py-4">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
.select2-container .select2-selection--multiple {
    min-height: 42px;
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
}
.select2-container--focus .select2-selection--multiple {
    border-color: #2563EB;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: 'Pilih opsi',
        allowClear: true
    });
});

function confirmDelete(formId) {
    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#9CA3AF',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById(formId).submit();
    });
}
</script>
@endpush