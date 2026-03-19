@extends('layouts.admin')

@section('title', 'Log Admin')
@section('page-title', 'Log Admin')

@section('content')
<div class="card-andelin p-4">
    <h5 class="mb-3">{{ $admin->name }}</h5>
    <div class="table-responsive">
        <table class="table table-andelin align-middle mb-0">
            <thead>
                <tr>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center py-4">Belum ada log.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrap">{{ $logs->links() }}</div>
</div>
@endsection
