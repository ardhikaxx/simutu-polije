@extends('layouts.app')

@section('title', 'Aktivitas ' . $user->nama . ' - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Aktivitas: {{ $user->nama }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('aktivitas.index') }}" class="text-decoration-none">Aktivitas</a></li>
                <li class="breadcrumb-item active">{{ $user->nama }}</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('aktivitas.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @forelse($activities as $activity)
        <div class="d-flex mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
            <div class="me-3">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;min-width:36px;">
                    <i class="fas fa-user text-primary" style="font-size:0.8rem;"></i>
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="text-muted" style="font-size:0.82rem;">{{ $activity->description }}</span>
                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                </div>
                @if($activity->subject_type)
                <div class="mt-1" style="font-size:0.78rem;">
                    <span class="badge bg-light text-muted">
                        <i class="fas fa-cube me-1"></i>{{ class_basename($activity->subject_type) }}
                        @if($activity->subject_id) #{{ $activity->subject_id }} @endif
                    </span>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-4 text-muted">
            <p>Belum ada aktivitas untuk user ini.</p>
        </div>
        @endforelse
    </div>
    @if(method_exists($activities, 'links'))
    <div class="card-footer bg-white">
        {{ $activities->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
