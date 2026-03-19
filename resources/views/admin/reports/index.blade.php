@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan & Arsip')

@section('content')
<div class="card-andelin p-4 mb-4">
    <form class="row g-3 align-items-end" method="GET">
        <div class="col-md-3">
            <label class="form-label">Bulan</label>
            <input type="number" name="month" class="form-control" min="1" max="12" value="{{ $month }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tahun</label>
            <input type="number" name="year" class="form-control" value="{{ $year }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Karyawan</label>
            <select name="employee_id" class="form-select">
                <option value="">Semua karyawan</option>
                @foreach($employees as $employee)
                <option value="{{ $employee->id }}" @selected(request('employee_id') == $employee->id)>{{ $employee->user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary flex-fill">Filter</button>
            <a href="{{ route('admin.reports.export', request()->query()) }}" class="btn btn-success flex-fill">Export</a>
        </div>
    </form>
</div>
<div class="card-andelin p-4">
    <div class="table-responsive">
        <table class="table table-andelin align-middle mb-0">
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Total Jam</th>
                    <th>Total Tugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr>
                    <td>{{ $report->employee->user->name }}</td>
                    <td>{{ $report->total_hours }}</td>
                    <td>{{ $report->total_tasks }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center py-4">Belum ada laporan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
