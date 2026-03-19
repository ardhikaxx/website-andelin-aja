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
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div id="calendar"></div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/id.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },
        events: '{{ route('employee.schedule.events') }}',
        eventColor: 'var(--color-primary)',
        eventClick: function (info) {
            Swal.fire({
                title: info.event.title,
                html: `📅 ${info.event.startStr}<br>⏰ ${info.event.extendedProps.time}`,
                icon: 'info',
                confirmButtonColor: 'var(--color-primary)'
            });
        }
    });
    calendar.render();
});
</script>
@endpush
