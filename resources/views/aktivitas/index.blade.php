@extends('layouts.app')

@section('title', 'Tracking Aktivitas - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Tracking Aktivitas User</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Aktivitas</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-5">
                    <label class="form-label small fw-semibold">Cari Aktivitas</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Deskripsi atau modul..." value="{{ request('search') }}">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label small fw-semibold">User</label>
                    <select name="user" class="form-select form-select-sm">
                        <option value="">Semua User</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user') == $u->id ? 'selected' : '' }}>{{ $u->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fas fa-search me-1"></i>Filter</button>
                </div>
            </div>
        </form>
    </div>
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
                    <div>
                        <span class="fw-semibold" style="font-size:0.85rem;">{{ $activity->causer->nama ?? 'System' }}</span>
                        <span class="text-muted" style="font-size:0.82rem;">{{ $activity->description }}</span>
                    </div>
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
                @if($activity->properties && count($activity->properties) > 0)
                <div class="bg-light rounded p-2 mt-2" style="font-size:0.75rem;">
                    @if(isset($activity->properties['attributes']))
                        @foreach($activity->properties['attributes'] as $key => $val)
                        <span class="me-2"><strong>{{ $key }}:</strong> {{ is_array($val) ? json_encode($val) : Str::limit($val, 40) }}</span>
                        @endforeach
                    @endif
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-4 text-muted">
            <i class="fas fa-history fa-2x mb-2"></i>
            <p>Belum ada aktivitas tercatat.</p>
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
