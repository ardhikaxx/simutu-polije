@extends('layouts.app')

@section('title', 'Kalender Aktivitas - SIMUTU POLIJE')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
<style>
    .fc .fc-toolbar-title { font-size: 1.2rem; font-weight: 700; }
    .fc .fc-button { background-color: var(--polije-primary); border-color: var(--polije-primary); font-size: 0.82rem; padding: 0.3rem 0.7rem; }
    .fc .fc-button:hover { background-color: var(--polije-secondary); border-color: var(--polije-secondary); }
    .fc .fc-button-active { background-color: var(--polije-secondary) !important; border-color: var(--polije-secondary) !important; }
    .fc .fc-daygrid-day-number { font-size: 0.82rem; }
    .fc .fc-event { font-size: 0.75rem; padding: 1px 4px; border-radius: 4px; cursor: pointer; }
    .fc .fc-col-header-cell { font-size: 0.82rem; font-weight: 600; }
    .fc .fc-scrollgrid { border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; }
    .legend-dot { width: 12px; height: 12px; border-radius: 3px; display: inline-block; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Kalender Aktivitas</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Kalender</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-2">
                <div class="d-flex flex-wrap gap-3 align-items-center" style="font-size:0.82rem;">
                    <span class="fw-semibold">Legenda:</span>
                    <span><span class="legend-dot" style="background:#1565c0;"></span> Jadwal Audit</span>
                    <span><span class="legend-dot" style="background:#e53935;"></span> Deadline Tindak Lanjut</span>
                    <span><span class="legend-dot" style="background:#f9a825;"></span> Periode Audit</span>
                    <span><span class="legend-dot" style="background:#2e7d32;"></span> Survei</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/locales/id.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'id',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '{{ route("kalender.events") }}',
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            if (info.event.url) {
                window.location.href = info.event.url;
            }
        },
        eventDidMount: function(info) {
            var tooltip = info.el.getAttribute('title') || '';
            info.el.setAttribute('title', info.event.title + (info.event.extendedProps.description ? '\n' + info.event.extendedProps.description : ''));
        },
        height: 'auto',
        dayMaxEvents: 4,
        nowIndicator: true,
    });
    calendar.render();
});
</script>
@endpush
