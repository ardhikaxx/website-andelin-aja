@extends('layouts.admin')

@section('title', 'Karyawan')
@section('page-title', 'Manajemen Karyawan')

@section('content')
<div class="card-andelin p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar Karyawan</h5>
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah</a>
    </div>
    <div class="table-responsive">
        <table class="table table-andelin align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Spesialisasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $employee->user->name }}</div>
                        <div class="small text-muted">{{ $employee->user->email }}</div>
                    </td>
                    <td>{{ str_replace('_', ' ', $employee->position) }}</td>
                    <td>{{ $employee->specializations->pluck('name')->join(', ') ?: '-' }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                        <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form id="delete-employee-{{ $employee->id }}" action="{{ route('admin.employees.destroy', $employee) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('delete-employee-{{ $employee->id }}')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4">Belum ada data karyawan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $employees->links() }}</div>
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
