@extends('layouts.employee')

@section('title', 'Pengajuan')
@section('page-title', 'Pengajuan')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card-andelin p-4 h-100">
            <h5 class="mb-3">Form Cuti</h5>
            <form action="{{ route('employee.requests.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="cuti">
                <div class="mb-3"><label class="form-label">Tanggal Mulai</label><input type="date" name="start_date" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Tanggal Selesai</label><input type="date" name="end_date" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Alasan</label><textarea name="description" class="form-control" rows="4" required></textarea></div>
                <button class="btn btn-primary">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-andelin p-4 h-100">
            <h5 class="mb-3">Form Tukar Jadwal</h5>
            <form action="{{ route('employee.requests.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="tukar_jadwal">
                <div class="mb-3">
                    <label class="form-label">Pilih Jadwal Saya</label>
                    <select name="from_schedule_id" class="form-select" required>
                        <option value="">Pilih jadwal</option>
                        @foreach($schedules as $schedule)
                        <option value="{{ $schedule->id }}">{{ $schedule->work_date->format('d M Y') }} | {{ $schedule->task?->title ?? 'Jadwal Kerja' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilih Rekan</label>
                    <select name="to_employee_id" class="form-select" required>
                        <option value="">Pilih rekan</option>
                        @foreach($coworkers as $coworker)
                        <option value="{{ $coworker->id }}">{{ $coworker->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Alasan</label><textarea name="description" class="form-control" rows="4" required></textarea></div>
                <button class="btn btn-primary">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</div>

<div class="card-andelin p-4">
    <h5 class="mb-3">Riwayat Pengajuan</h5>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                <tr>
                    <td>{{ str_replace('_', ' ', $request->type) }}</td>
                    <td>{{ $request->description }}</td>
                    <td>{{ ucfirst($request->status) }}</td>
                    <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4">Belum ada pengajuan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
