@extends('layouts.app')

@section('title', 'Dashboard PPEPP - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Dashboard PPEPP</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard PPEPP</li>
            </ol>
        </nav>
    </div>
</div>

@if($tahunAkademikAktif)
<div class="alert alert-info mb-4">
    <i class="fas fa-calendar-check me-2"></i>Tahun Akademik Aktif: <strong>{{ $tahunAkademikAktif->nama }}</strong>
</div>
@endif

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $sikluses->count() }}</h3>
                <small>Total Siklus</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $sikluses->where('status_siklus', 'Selesai')->count() }}</h3>
                <small>Selesai</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $sikluses->where('status_siklus', 'Berjalan')->count() }}</h3>
                <small>Berjalan</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-danger text-white">
            <div class="card-body text-center">
                @php
                $overdue = $sikluses->filter(function($s) { return $s->status_siklus === 'Berjalan' && $s->created_at->diffInDays(now()) > 90; })->count();
                @endphp
                <h3 class="mb-0">{{ $overdue }}</h3>
                <small>Lewat Target</small>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>No</th><th>Standar Mutu</th><th>Tahap</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($sikluses as $idx => $s)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td class="fw-semibold">{{ $s->standarMutu->nama_standar ?? '-' }}</td>
                        <td><span class="badge bg-primary">{{ ucfirst($s->tahap_sekarang) }}</span></td>
                        <td><span class="badge bg-{{ $s->status_siklus === 'Selesai' ? 'success' : 'warning' }}">{{ $s->status_siklus }}</span></td>
                        <td><a href="{{ route('ppepp.show', $s) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada siklus PPEPP.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
