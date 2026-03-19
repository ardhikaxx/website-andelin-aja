@extends('layouts.admin')

@section('title', 'Spesialisasi')
@section('page-title', 'Manajemen Spesialisasi')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-andelin p-4">
            <h5 class="mb-3">Tambah Spesialisasi</h5>
            <form action="{{ route('admin.specializations.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>
                <button class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-andelin p-4">
            <h5 class="mb-3">Daftar Spesialisasi</h5>
            <div class="table-responsive">
                <table class="table table-andelin align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Karyawan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($specializations as $specialization)
                        <tr>
                            <td>{{ $specialization->name }}</td>
                            <td>{{ $specialization->description ?: '-' }}</td>
                            <td>{{ $specialization->employees_count }}</td>
                            <td>
                                <form action="{{ route('admin.specializations.update', $specialization) }}" method="POST" class="d-flex gap-2 mb-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $specialization->name }}" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-outline-primary">Update</button>
                                </form>
                                <form id="delete-spec-{{ $specialization->id }}" action="{{ route('admin.specializations.destroy', $specialization) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('delete-spec-{{ $specialization->id }}')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4">Belum ada spesialisasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $specializations->links() }}</div>
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
