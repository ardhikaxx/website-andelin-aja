@extends('layouts.admin')

@section('title', 'Penugasan')
@section('page-title', 'Manajemen Penugasan')

@section('content')
<div class="card-andelin border-0 shadow-sm p-4 mb-4">
    <div class="d-flex align-items-center mb-4">
        <div class="icon-box bg-primary-soft me-3">
            <i class="fas fa-tasks text-primary"></i>
        </div>
        <div>
            <h5 class="mb-0 fw-bold text-dark">Assign Tugas Manual</h5>
            <small class="text-muted text-xs">Delegasikan tugas kepada karyawan yang tersedia.</small>
        </div>
    </div>

    <form action="{{ route('admin.assignments.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-5 col-md-12">
                <div class="form-group-andelin">
                    <label class="form-label-andelin"><i class="fas fa-clipboard-check me-2 text-primary"></i>Pilih Tugas</label>
                    <select name="task_id" id="task_id" class="form-select select2-standard" required style="width: 100%;">
                        <option value="">-- Cari Nama Tugas --</option>
                        @foreach($allTasks as $task)
                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="form-group-andelin">
                    <label class="form-label-andelin"><i class="fas fa-user-plus me-2 text-primary"></i>Pilih Karyawan</label>
                    <select name="employee_ids[]" id="employee_ids" class="form-select select2-standard" multiple required style="width: 100%;">
                        @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 d-flex align-items-end">
                <button class="btn btn-primary-andelin w-100 shadow-sm">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </form>
</div>

<div class="card-andelin border-0 shadow-sm p-0 overflow-hidden">
    <div class="px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark">Daftar Penugasan Aktif</h6>
            <small class="text-muted text-xs">Menampilkan seluruh delegasi tugas yang sedang berjalan.</small>
        </div>
        <span class="badge bg-primary rounded-pill px-3">{{ $tasks->total() }} Tugas</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light-soft text-secondary">
                <tr>
                    <th class="ps-4 py-3 border-0">Tugas</th>
                    <th class="py-3 border-0 text-center">Deadline</th>
                    <th class="py-3 border-0">Karyawan Ditugaskan</th>
                    <th class="pe-4 py-3 border-0 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td class="ps-4">
                        <div class="fw-bold text-dark">{{ $task->title }}</div>
                        <div class="text-muted text-xs">{{ Str::limit($task->description, 50) ?: 'Tanpa deskripsi' }}</div>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $task->deadline && $task->deadline->isPast() ? 'bg-danger-light text-danger' : 'bg-info-light text-info' }} rounded-pill px-3 py-2 fw-semibold">
                            {{ $task->deadline ? $task->deadline->format('d M Y') : '-' }}
                        </span>
                    </td>
                    <td>
                        @if($task->employees->count() > 0)
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($task->employees as $emp)
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-normal">
                                        <i class="fas fa-user-circle me-1 text-secondary"></i>{{ $emp->user->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted italic small">Belum ada karyawan ditugaskan</span>
                        @endif
                    </td>
                    <td class="pe-4 text-end">
                        <form id="delete-assignment-{{ $task->id }}" action="{{ route('admin.assignments.destroy', $task) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-action-delete" 
                                    onclick="confirmDelete('delete-assignment-{{ $task->id }}')" 
                                    title="Hapus Penugasan">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-clipboard-list fa-3x text-light mb-3"></i>
                            <p class="text-muted">Belum ada data penugasan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tasks->hasPages())
    <div class="px-4 py-3 border-top">
        {{ $tasks->links('vendor.pagination.bootstrap-5-clean') }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
/* Andelin Style Colors & Utilities */
:root {
    --primary-color: #2563EB;
    --primary-soft: rgba(37, 99, 235, 0.08);
    --secondary-color: #64748b;
    --border-color: #e2e8f0;
    --bg-light: #f8fafc;
}

.text-xs { font-size: 0.75rem; }
.bg-light-soft { background-color: #f1f5f9; }

/* Form Elements */
.form-group-andelin { margin-bottom: 0.5rem; }
.form-label-andelin {
    font-size: 0.85rem;
    font-weight: 700;
    color: #334155;
    margin-bottom: 0.6rem;
    display: block;
}

/* Select2 Global Customization - Cleaner Version */
.select2-container--default .select2-selection--single,
.select2-container--default .select2-selection--multiple {
    border: 2px solid var(--border-color);
    border-radius: 12px;
    min-height: 52px;
    padding: 6px 10px;
    transition: all 0.3s ease;
    background-color: var(--bg-light);
}

.select2-container--default.select2-container--focus .select2-selection--single,
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: var(--primary-color);
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 38px;
    color: #1e293b;
    font-weight: 500;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 50px;
}

.select2-dropdown {
    border: none;
    border-radius: 16px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    margin-top: 8px;
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.select2-results__option {
    padding: 12px 16px;
    font-size: 0.95rem;
}

/* Multi-select Tags (Pills) */
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: var(--primary-soft);
    border: 1px solid rgba(37, 99, 235, 0.2);
    color: var(--primary-color);
    border-radius: 8px;
    padding: 4px 12px;
    margin-top: 4px;
    font-size: 0.85rem;
    font-weight: 600;
}

/* Utilities */
.icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.btn-primary-andelin {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 12px;
    height: 52px;
    font-weight: 700;
    transition: all 0.3s ease;
}

.btn-primary-andelin:hover {
    background-color: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(37, 99, 235, 0.2);
}

.btn-action-delete {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #ef4444;
    background-color: rgba(239, 68, 68, 0.05);
    border: 1px solid rgba(239, 68, 68, 0.1);
    transition: all 0.2s;
}

.btn-action-delete:hover {
    background-color: #ef4444;
    color: white;
}

.bg-primary-soft { background-color: var(--primary-soft); }
.bg-danger-light { background-color: rgba(239, 68, 68, 0.08); }
.bg-info-light { background-color: rgba(6, 182, 212, 0.08); }

.card-andelin { background: #fff; border-radius: 1.25rem; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-standard').select2({
        placeholder: 'Cari atau Pilih...',
        allowClear: true,
        width: '100%'
    });
});

function confirmDelete(formId) {
    Swal.fire({
        title: 'Hapus Penugasan?',
        text: 'Karyawan akan dilepaskan dari tanggung jawab tugas ini.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Lepaskan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById(formId).submit();
    });
}
</script>
@endpush
