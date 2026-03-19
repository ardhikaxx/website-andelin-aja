@extends('layouts.admin')

@section('title', 'Detail Tugas')
@section('page-title', 'Detail Tugas')

@section('content')
<div class="card-andelin p-4 mb-4">
    <h4>{{ $task->title }}</h4>
    <p class="text-muted">{{ $task->description ?: 'Tidak ada deskripsi.' }}</p>
    <div class="row g-3">
        <div class="col-md-4">Deadline: {{ $task->deadline->format('d M Y') }}</div>
        <div class="col-md-4">Status: {{ str_replace('_', ' ', $task->status) }}</div>
        <div class="col-md-4">Dibuat oleh: {{ $task->creator->name }}</div>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card-andelin p-4">
            <h5 class="mb-3">Penanggung Jawab</h5>
            <ul class="mb-0">
                @forelse($task->employees as $employee)
                <li>{{ $employee->user->name }}</li>
                @empty
                <li>Belum ada penugasan.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-andelin p-4">
            <h5 class="mb-3">Jadwal Terkait</h5>
            <ul class="mb-0">
                @forelse($task->schedules as $schedule)
                <li>{{ $schedule->work_date->format('d M Y') }} - {{ $schedule->employee->user->name }}</li>
                @empty
                <li>Belum ada jadwal.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
