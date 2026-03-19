@extends('layouts.admin')

@section('title', 'Manajemen Admin')
@section('page-title', 'Manajemen Admin')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card-andelin p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Daftar Admin</h5>
                <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">Tambah Admin</a>
            </div>
            <div class="table-responsive">
                <table class="table table-andelin align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.admins.show', $admin) }}" class="btn btn-sm btn-outline-secondary">Log</a>
                                <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                @if($admin->id !== auth()->id())
                                <form id="delete-admin-{{ $admin->id }}" action="{{ route('admin.admins.destroy', $admin) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('delete-admin-{{ $admin->id }}')">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-4">Belum ada admin.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $admins->links() }}</div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-andelin p-4">
            <h5 class="mb-3">Admin Logs</h5>
            <div class="d-flex flex-column gap-3">
                @forelse($logs as $log)
                <div class="border rounded-3 p-3">
                    <div class="fw-semibold">{{ $log->action }}</div>
                    <div class="small text-muted">{{ $log->description }}</div>
                    <div class="small text-muted mt-1">{{ $log->created_at->format('d M Y H:i') }}</div>
                </div>
                @empty
                <div class="text-muted">Belum ada log.</div>
                @endforelse
            </div>
        </div>
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
