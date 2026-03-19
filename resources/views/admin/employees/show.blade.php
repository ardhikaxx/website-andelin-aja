@extends('layouts.admin')

@section('title', 'Detail Karyawan')
@section('page-title', 'Detail Karyawan')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-andelin p-4 h-100">
            <h5>{{ $employee->user->name }}</h5>
            <div class="text-muted mb-2">{{ $employee->user->email }}</div>
            <div class="mb-2">Posisi: {{ str_replace('_', ' ', $employee->position) }}</div>
            <div>Spesialisasi: {{ $employee->specializations->pluck('name')->join(', ') ?: '-' }}</div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-andelin p-4 mb-4">
            <h5 class="mb-3">Tugas</h5>
            <ul class="mb-0">
                @forelse($employee->tasks as $task)
                <li>{{ $task->title }} - {{ $task->deadline->format('d M Y') }}</li>
                @empty
                <li>Belum ada tugas.</li>
                @endforelse
            </ul>
        </div>
        <div class="card-andelin p-4">
            <h5 class="mb-3">Jadwal</h5>
            <ul class="mb-0">
                @forelse($employee->schedules as $schedule)
                <li>{{ $schedule->work_date->format('d M Y') }} | {{ $schedule->start_time }} - {{ $schedule->end_time }} | {{ $schedule->task?->title ?? 'Jadwal Kerja' }}</li>
                @empty
                <li>Belum ada jadwal.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
