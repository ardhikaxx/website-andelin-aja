@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <h2 class="stat-number">{{ $stats['employees'] }}</h2>
                <p class="stat-label">Total Karyawan</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-tasks"></i></div>
            <div>
                <h2 class="stat-number">{{ $stats['active_tasks'] }}</h2>
                <p class="stat-label">Total Tugas Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-robot"></i></div>
            <div>
                <h2 class="stat-number">{{ $stats['greedy_schedules'] }}</h2>
                <p class="stat-label">Dijadwalkan Greedy</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-star"></i></div>
            <div>
                <h2 class="stat-number">{{ $stats['specializations'] }}</h2>
                <p class="stat-label">Total Spesialisasi</p>
            </div>
        </div>
    </div>
</div>

<div class="card-andelin p-4 mb-4">
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i> Tambah Karyawan
        </a>
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle me-2"></i> Buat Tugas
        </a>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-info text-white">
            <i class="fas fa-chart-bar me-2"></i> Lihat Laporan
        </a>
    </div>
</div>

<div class="card-andelin p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar Tugas Terbaru</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-andelin align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama Tugas</th>
                    <th>Penanggung Jawab</th>
                    <th>Tenggat Waktu</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->employees->pluck('user.name')->join(', ') ?: '-' }}</td>
                    <td>{{ $task->deadline->format('d M Y') }}</td>
                    <td>
                        @if($task->status === 'pending')
                            <span class="badge bg-warning">Tertunda</span>
                        @elseif($task->status === 'in_progress')
                            <span class="badge bg-info">Berjalan</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">Belum ada tugas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
