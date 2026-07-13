@extends('layouts.app')

@section('title', 'Activity Log - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Activity Log</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Activity Log</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @php
            $logs = Spatie\Activitylog\Models\Activity::with('causer')->latest()->get();
        @endphp
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Log Name</th>
                        <th>Description</th>
                        <th width="100">Properties</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $index => $log)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span title="{{ $log->created_at->format('d M Y H:i') }}">
                                {{ $log->created_at->diffForHumans() }}
                            </span>
                        </td>
                        <td class="fw-semibold">{{ $log->causer->nama ?? '-' }}</td>
                        <td>
                            @if($log->event === 'created')
                                <span class="badge bg-success">{{ $log->event }}</span>
                            @elseif($log->event === 'updated')
                                <span class="badge bg-primary">{{ $log->event }}</span>
                            @elseif($log->event === 'deleted')
                                <span class="badge bg-danger">{{ $log->event }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $log->event }}</span>
                            @endif
                        </td>
                        <td>{{ $log->log_name ?? '-' }}</td>
                        <td>{{ $log->description ?? '-' }}</td>
                        <td>
                            @if($log->properties)
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#properties-{{ $log->id }}" title="Lihat Properties">
                                <i class="fas fa-code"></i>
                            </button>
                            <div class="collapse mt-2" id="properties-{{ $log->id }}">
                                <pre class="mb-0 small bg-light p-2 rounded" style="max-height:200px;overflow:auto;"><code>{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                            </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-history fa-2x mb-2 d-block"></i>
                            Belum ada activity log.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        order: [[1, 'desc']]
    });
});
</script>
@endpush
