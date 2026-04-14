@extends('layouts.employee')

@section('title', 'Jadwal Saya')
@section('page-title', 'Jadwal Saya')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<style>
    #calendar {
        background: var(--color-bg-card);
        border-radius: var(--radius-md);
        padding: 1rem;
        box-shadow: var(--shadow-soft);
        border: 1px solid var(--color-border);
    }
    .fc-button-primary {
        background: var(--color-primary) !important;
        border-color: var(--color-primary-dark) !important;
        border-radius: var(--radius-sm) !important;
    }
    .note-indicator {
        background: var(--color-warning);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        margin-left: 4px;
    }
    .swal2-popup {
        border-radius: 20px !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div id="calendar"></div>
</div>

<!-- Modal Tambah Catatan -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: var(--gradient-primary); color: white; border-radius: 20px 20px 0 0;">
                <h5 class="modal-title" id="addNoteModalLabel"><i class="fas fa-plus-circle me-2"></i>Tambah Catatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addNoteForm">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="noteTitle" class="form-label fw-bold">Nama Catatan</label>
                        <input type="text" class="form-control" id="noteTitle" placeholder="Masukkan nama catatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="noteDescription" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="noteDescription" rows="4" placeholder="Masukkan deskripsi catatan (opsional)"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="noteDate" class="form-label fw-bold">Tanggal</label>
                        <input type="date" class="form-control" id="noteDate" required readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Catatan -->
<div class="modal fade" id="detailNoteModal" tabindex="-1" aria-labelledby="detailNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: var(--gradient-primary); color: white; border-radius: 20px 20px 0 0;">
                <h5 class="modal-title" id="detailNoteModalLabel"><i class="fas fa-info-circle me-2"></i>Detail Catatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label text-muted small">Nama Catatan</label>
                    <h5 class="mb-0" id="detailTitle"></h5>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small">Tanggal</label>
                    <p class="mb-0 fw-bold" id="detailDate"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small">Deskripsi</label>
                    <p class="mb-0" id="detailDescription" style="white-space: pre-wrap;"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning" id="btnEditFromDetail"><i class="fas fa-edit me-2"></i>Edit</button>
                <button type="button" class="btn btn-danger" id="btnDeleteFromDetail"><i class="fas fa-trash me-2"></i>Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Catatan -->
<div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: var(--gradient-primary); color: white; border-radius: 20px 20px 0 0;">
                <h5 class="modal-title" id="editNoteModalLabel"><i class="fas fa-edit me-2"></i>Edit Catatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editNoteForm">
                <input type="hidden" id="editNoteId">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="editNoteTitle" class="form-label fw-bold">Nama Catatan</label>
                        <input type="text" class="form-control" id="editNoteTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNoteDescription" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="editNoteDescription" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editNoteDate" class="form-label fw-bold">Tanggal</label>
                        <input type="date" class="form-control" id="editNoteDate" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/id.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendar;
    let notesData = [];
    let currentDetailNoteId = null;

    // Load notes data
    async function loadNotes() {
        try {
            const response = await fetch('{{ route('employee.schedule.notes.index') }}');
            notesData = await response.json();
            updateCalendarEvents();
        } catch (error) {
            console.error('Error loading notes:', error);
        }
    }

    // Update calendar events with notes
    function updateCalendarEvents() {
        const noteEvents = notesData.map(note => ({
            id: `note-${note.id}`,
            title: note.title,
            start: note.note_date,
            backgroundColor: '#F59E0B',
            borderColor: '#F59E0B',
            textColor: '#FFFFFF',
            extendedProps: {
                type: 'note',
                noteId: note.id,
            }
        }));

        // Remove old note events if any
        calendar.getEvents()
            .filter(event => event.extendedProps.type === 'note')
            .forEach(event => event.remove());

        // Add note events alongside schedule events
        noteEvents.forEach(event => calendar.addEvent(event));
    }

    // Initialize calendar
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },
        events: '{{ route('employee.schedule.events') }}',
        eventColor: 'var(--color-primary)',
        editable: false,
        dateClick: function(info) {
            openAddNoteModal(info.dateStr);
        },
        eventClick: function(info) {
            const event = info.event;
            const props = event.extendedProps;
            
            if (props.type === 'note') {
                showNoteDetail(props.noteId);
            } else {
                Swal.fire({
                    title: event.title,
                    html: `📅 ${event.startStr}<br>⏰ ${props.time}`,
                    icon: 'info',
                    confirmButtonColor: 'var(--color-primary)'
                });
            }
        }
    });
    calendar.render();

    // Load notes on page load
    loadNotes();

    // Add Note Modal
    function openAddNoteModal(dateStr) {
        document.getElementById('addNoteForm').reset();
        document.getElementById('noteDate').value = dateStr;
        const modal = new bootstrap.Modal(document.getElementById('addNoteModal'));
        modal.show();
    }

    // Handle Add Note Form Submit
    document.getElementById('addNoteForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = {
            title: document.getElementById('noteTitle').value,
            description: document.getElementById('noteDescription').value,
            note_date: document.getElementById('noteDate').value,
        };

        try {
            const response = await fetch('{{ route('employee.schedule.notes.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                bootstrap.Modal.getInstance(document.getElementById('addNoteModal')).hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message,
                    confirmButtonColor: 'var(--color-primary)'
                });
                await loadNotes();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: result.message || 'Gagal menyimpan catatan',
                    confirmButtonColor: 'var(--color-primary)'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat menyimpan catatan',
                confirmButtonColor: 'var(--color-primary)'
            });
        }
    });

    // Show Note Detail
    async function showNoteDetail(noteId) {
        try {
            const response = await fetch(`/employee/schedule/notes/${noteId}`);
            const note = await response.json();

            document.getElementById('detailTitle').textContent = note.title;
            document.getElementById('detailDate').textContent = note.note_date_formatted;
            document.getElementById('detailDescription').textContent = note.description || '-';
            currentDetailNoteId = note.id;

            const modal = new bootstrap.Modal(document.getElementById('detailNoteModal'));
            modal.show();
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal memuat detail catatan',
                confirmButtonColor: 'var(--color-primary)'
            });
        }
    }

    // Handle Edit from Detail Modal
    document.getElementById('btnEditFromDetail').addEventListener('click', function() {
        if (!currentDetailNoteId) return;
        
        bootstrap.Modal.getInstance(document.getElementById('detailNoteModal')).hide();
        openEditModal(currentDetailNoteId);
    });

    // Handle Delete from Detail Modal
    document.getElementById('btnDeleteFromDetail').addEventListener('click', function() {
        if (!currentDetailNoteId) return;
        
        bootstrap.Modal.getInstance(document.getElementById('detailNoteModal')).hide();
        deleteNote(currentDetailNoteId);
    });

    // Open Edit Modal
    async function openEditModal(noteId) {
        try {
            const response = await fetch(`/employee/schedule/notes/${noteId}`);
            const note = await response.json();

            document.getElementById('editNoteId').value = note.id;
            document.getElementById('editNoteTitle').value = note.title;
            document.getElementById('editNoteDescription').value = note.description || '';
            document.getElementById('editNoteDate').value = note.note_date;

            const modal = new bootstrap.Modal(document.getElementById('editNoteModal'));
            modal.show();
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal memuat data catatan',
                confirmButtonColor: 'var(--color-primary)'
            });
        }
    }

    // Handle Edit Note Form Submit
    document.getElementById('editNoteForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const noteId = document.getElementById('editNoteId').value;
        const formData = {
            title: document.getElementById('editNoteTitle').value,
            description: document.getElementById('editNoteDescription').value,
            note_date: document.getElementById('editNoteDate').value,
        };

        try {
            const response = await fetch(`/employee/schedule/notes/${noteId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                bootstrap.Modal.getInstance(document.getElementById('editNoteModal')).hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message,
                    confirmButtonColor: 'var(--color-primary)'
                });
                await loadNotes();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: result.message || 'Gagal memperbarui catatan',
                    confirmButtonColor: 'var(--color-primary)'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat memperbarui catatan',
                confirmButtonColor: 'var(--color-primary)'
            });
        }
    });

    // Delete Note with SweetAlert
    async function deleteNote(noteId) {
        const result = await Swal.fire({
            title: 'Hapus Catatan?',
            text: 'Apakah Anda yakin ingin menghapus catatan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(`/employee/schedule/notes/${noteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: 'var(--color-primary)'
                    });
                    await loadNotes();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Gagal menghapus catatan',
                        confirmButtonColor: 'var(--color-primary)'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menghapus catatan',
                    confirmButtonColor: 'var(--color-primary)'
                });
            }
        }
    }
});
</script>
@endpush
