@extends('layouts.employee')

@section('title', 'Tugas Saya')
@section('page-title', 'Tugas Saya')

@push('styles')
<style>
    .kanban-col {
        min-height: 320px;
        background: var(--color-bg-card);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-soft);
        padding: 1rem;
    }
    .task-card {
        background: var(--color-bg-main);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-sm);
        padding: 1rem;
        margin-bottom: .75rem;
        cursor: grab;
    }
</style>
@endpush

@section('content')
<div class="row g-4" id="kanban-board">
    @foreach(['pending' => 'Pending', 'in_progress' => 'In Progress', 'done' => 'Done'] as $status => $label)
    <div class="col-md-4">
        <div class="kanban-col" data-status="{{ $status }}">
            <h5 class="mb-3">{{ $label }}</h5>
            @foreach($tasks->where('status', $status) as $task)
            <div class="task-card draggable" data-id="{{ $task->id }}" data-status="{{ $status }}">
                <strong>{{ $task->title }}</strong>
                <div class="small text-muted mt-2">Deadline: {{ $task->deadline->format('d M Y') }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.12/lib/draggable.bundle.js"></script>
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const containers = document.querySelectorAll('.kanban-col');
const draggable = new Draggable.Sortable(containers, { draggable: '.task-card' });

draggable.on('drag:stop', (evt) => {
    const taskId = evt.data.source.dataset.id;
    const newStatus = evt.data.source.closest('.kanban-col').dataset.status;

    fetch(`/employee/tasks/${taskId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    }).then(() => {
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Status tugas diperbarui.', showConfirmButton: false, timer: 1500 });
    });
});
</script>
@endpush
