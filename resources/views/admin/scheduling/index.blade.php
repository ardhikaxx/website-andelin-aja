@extends('layouts.admin')

@section('title', 'Penjadwalan')
@section('page-title', 'Penjadwalan Otomatis (Greedy)')

@push('styles')
<style>
    .greedy-result-item {
        padding: .5rem 1rem;
        border-left: 3px solid var(--color-primary);
        background: rgba(59, 130, 246, 0.05);
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        margin-bottom: .5rem;
        font-size: .875rem;
        color: var(--color-text-secondary);
    }
    .rules-card {
        background: var(--color-bg-card);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-soft);
        padding: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="rules-card h-100">
            <h5 class="mb-3">Aturan Penjadwalan</h5>
            <form action="{{ route('admin.scheduling.rules') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Max Jam / Minggu</label>
                    <input type="number" name="max_hours_per_week" class="form-control" value="{{ $rules?->max_hours_per_week ?? 40 }}" min="1" max="168" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Max Tugas / Hari</label>
                    <input type="number" name="max_tasks_per_day" class="form-control" value="{{ $rules?->max_tasks_per_day ?? 3 }}" min="1" max="24" required>
                </div>
                <button class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="rules-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-1">Generate Jadwal Otomatis</h5>
                    <div class="text-muted small">Algoritma Greedy akan memproses semua tugas pending.</div>
                </div>
                <button id="btn-generate" class="btn btn-primary"><i class="fas fa-robot me-2"></i>Generate</button>
            </div>
            <div id="greedy-results">
                <div class="greedy-result-item">Klik tombol generate untuk menjalankan penjadwalan otomatis.</div>
            </div>
        </div>
    </div>
</div>

<div class="card-andelin p-4">
    <form class="row g-3 mb-4">
        <div class="col-md-3"><input type="date" name="work_date" class="form-control" value="{{ request('work_date') }}"></div>
        <div class="col-md-3">
            <select name="employee_id" class="form-select">
                <option value="">Semua karyawan</option>
                @foreach($employees as $employee)
                <option value="{{ $employee->id }}" @selected(request('employee_id') == $employee->id)>{{ $employee->user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Semua status</option>
                <option value="scheduled" @selected(request('status') === 'scheduled')>Scheduled</option>
                <option value="completed" @selected(request('status') === 'completed')>Completed</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="generated_by" class="form-select">
                <option value="">Semua generate</option>
                <option value="manual" @selected(request('generated_by') === 'manual')>Manual</option>
                <option value="greedy" @selected(request('generated_by') === 'greedy')>Greedy</option>
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-outline-primary w-100">Filter</button></div>
    </form>

    <div class="table-responsive">
        <table class="table table-andelin align-middle mb-0">
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Tugas</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th>By</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->employee->user->name }}</td>
                    <td>{{ $schedule->task?->title ?? 'Jadwal Kerja' }}</td>
                    <td>{{ $schedule->work_date->format('d M Y') }}</td>
                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                    <td>{{ ucfirst($schedule->status) }}</td>
                    <td>
                        <span class="badge bg-{{ $schedule->generated_by === 'greedy' ? 'success' : 'secondary' }}">
                            <i class="fas fa-{{ $schedule->generated_by === 'greedy' ? 'robot' : 'hand-paper' }}"></i>
                            {{ ucfirst($schedule->generated_by) }}
                        </span>
                    </td>
                    <td>
                        <form id="delete-schedule-{{ $schedule->id }}" action="{{ route('admin.scheduling.destroy', $schedule) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('delete-schedule-{{ $schedule->id }}')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4">Belum ada jadwal.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrap">{{ $schedules->links() }}</div>
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

document.getElementById('btn-generate').addEventListener('click', function () {
    Swal.fire({
        title: 'Generate Jadwal Otomatis?',
        text: 'Sistem akan menjalankan Algoritma Greedy.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'var(--color-primary)',
        cancelButtonColor: 'var(--color-text-muted)',
        confirmButtonText: 'Ya, Generate!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Memproses...',
                html: 'Algoritma Greedy sedang berjalan...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch('{{ route('admin.scheduling.generate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('greedy-results').innerHTML = data.details.map((item) => {
                    if (item.employee) {
                        return `<div class="greedy-result-item"><strong>${item.task}</strong> -> ${item.employee} (${item.date})</div>`;
                    }
                    return `<div class="greedy-result-item"><strong>${item.task}</strong> -> ${item.reason}</div>`;
                }).join('');

                Swal.fire({
                    title: 'Selesai!',
                    html: `Berhasil: <b>${data.scheduled}</b> tugas berhasil dijadwalkan<br>Dilewati: <b>${data.skipped}</b> tugas dilewati`,
                    icon: 'success',
                    confirmButtonColor: 'var(--color-primary)'
                }).then(() => location.reload());
            });
        }
    });
});
</script>
@endpush
