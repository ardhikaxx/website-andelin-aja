@extends('layouts.admin')

@section('title', 'Pengajuan')
@section('page-title', 'Manajemen Pengajuan')

@section('content')
<div class="card-andelin p-4">
    <div class="table-responsive">
        <table class="table table-andelin align-middle mb-0">
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Jenis</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                <tr>
                    <td>{{ $request->employee->user->name }}</td>
                    <td>{{ str_replace('_', ' ', $request->type) }}</td>
                    <td>{{ $request->description }}</td>
                    <td>{{ ucfirst($request->status) }}</td>
                    <td class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.requests.show', $request) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                        @if($request->status === 'pending')
                        <form id="form-approve-{{ $request->id }}" action="{{ route('admin.requests.approve', $request) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="confirmApprove({{ $request->id }})">Approve</button>
                        </form>
                        <form id="form-reject-{{ $request->id }}" action="{{ route('admin.requests.reject', $request) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmReject({{ $request->id }})">Reject</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4">Belum ada pengajuan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $requests->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
function confirmApprove(id) {
    Swal.fire({
        title: 'Setujui Pengajuan?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Setujui',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById('form-approve-' + id).submit();
    });
}

function confirmReject(id) {
    Swal.fire({
        title: 'Tolak Pengajuan?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById('form-reject-' + id).submit();
    });
}
</script>
@endpush
