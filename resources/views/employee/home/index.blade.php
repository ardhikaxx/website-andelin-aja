@extends('layouts.employee')

@section('title', 'Beranda')
@section('page-title', 'Beranda')

@section('content')
<div class="card-andelin p-4">
    <h5 class="mb-3">Jadwal Hari Ini</h5>
    <div class="row g-4">
        @forelse($todaySchedules as $schedule)
        <div class="col-md-6 col-xl-4">
            <div class="card-andelin p-4 h-100">
                <div class="small text-muted mb-2">{{ $schedule->start_time }} - {{ $schedule->end_time }}</div>
                <h5>{{ $schedule->task?->title ?? 'Jadwal Kerja' }}</h5>
                <div class="text-muted">Status: {{ ucfirst($schedule->status) }}</div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-muted">Tidak ada jadwal hari ini.</div>
        </div>
        @endforelse
    </div>
</div>
@endsection
