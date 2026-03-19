@extends('layouts.admin')

@section('title', 'Tugas')
@section('page-title', 'Manajemen Tugas')

@section('content')
<div class="card-andelin p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar Tugas</h5>
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Buat Tugas</a>
    </div>
    <div class="table-responsive">
        <table class="table table-andelin align-middle mb-0">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Penanggung Jawab</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->deadline->format('d M Y') }}</td>
                    <td>{{ str_replace('_', ' ', $task->status) }}</td>
                    <td>{{ $task->employees->pluck('user.name')->join(', ') ?: '-' }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                        <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form id="delete-task-{{ $task->id }}" action="{{ route('admin.tasks.destroy', $task) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('delete-task-{{ $task->id }}')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4">Belum ada tugas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $tasks->links() }}</div>
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
