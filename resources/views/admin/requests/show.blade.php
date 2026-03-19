@extends('layouts.admin')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan')

@section('content')
<div class="card-andelin p-4">
    <div class="row g-3">
        <div class="col-md-6"><strong>Karyawan:</strong> {{ $item->employee->user->name }}</div>
        <div class="col-md-6"><strong>Jenis:</strong> {{ str_replace('_', ' ', $item->type) }}</div>
        <div class="col-md-6"><strong>Status:</strong> {{ ucfirst($item->status) }}</div>
        <div class="col-md-6"><strong>Tanggal:</strong> {{ $item->created_at->format('d M Y H:i') }}</div>
        <div class="col-12"><strong>Deskripsi:</strong><br>{{ $item->description }}</div>
        @if($item->type === 'cuti')
        <div class="col-md-6"><strong>Mulai:</strong> {{ optional($item->start_date)->format('d M Y') ?: '-' }}</div>
        <div class="col-md-6"><strong>Selesai:</strong> {{ optional($item->end_date)->format('d M Y') ?: '-' }}</div>
        @endif
        @if($item->type === 'tukar_jadwal')
        <div class="col-md-6"><strong>Jadwal:</strong> {{ $item->fromSchedule?->work_date?->format('d M Y') ?: '-' }}</div>
        <div class="col-md-6"><strong>Rekan:</strong> {{ $item->toEmployee?->user?->name ?: '-' }}</div>
        @endif
    </div>
</div>
@endsection
