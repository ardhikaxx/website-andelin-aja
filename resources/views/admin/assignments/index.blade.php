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
                <select name="task_id" class="form-select" required>
                    <option value="">Pilih tugas</option>
                    @foreach($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Karyawan</label>
                <select name="employee_ids[]" class="form-select" multiple required size="5">
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

@push('scripts')
<script>
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
