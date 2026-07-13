@extends('layouts.app')

@section('title', 'Dashboard Survei - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Dashboard Survei</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard Survei</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white text-center">
            <div class="card-body">
                <h3 class="mb-0">{{ $stats['total_survei'] }}</h3>
                <small>Total Survei</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white text-center">
            <div class="card-body">
                <h3 class="mb-0">{{ $stats['survei_aktif'] }}</h3>
                <small>Survei Aktif</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-info text-white text-center">
            <div class="card-body">
                <h3 class="mb-0">{{ $stats['total_responden'] }}</h3>
                <small>Total Responden</small>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th>No</th><th>Judul</th><th>Jenis</th><th>Responden</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($surveis as $idx => $survei)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td class="fw-semibold">{{ $survei->judul }}</td>
                        <td><span class="badge bg-info">{{ $survei->jenisSurvei->nama ?? '-' }}</span></td>
                        <td>{{ $survei->jawabanSurvei->unique('diisi_oleh')->count() }}</td>
                        <td><span class="badge bg-{{ $survei->status === 'Aktif' ? 'success' : 'secondary' }}">{{ $survei->status }}</span></td>
                        <td><a href="{{ route('survei.hasil', $survei) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-chart-bar"></i></a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada survei.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
