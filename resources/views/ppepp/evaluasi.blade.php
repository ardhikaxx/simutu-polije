@extends('layouts.app')

@section('title', 'Evaluasi PPEPP - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Evaluasi: {{ $siklus->standarMutu->nama_standar ?? '' }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ppepp.index') }}" class="text-decoration-none">PPEPP</a></li>
                <li class="breadcrumb-item active">Evaluasi</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('ppepp.show', $siklus) }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Informasi Siklus</h6></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4"><small class="text-muted d-block">Standar Mutu</small><span class="fw-semibold">{{ $siklus->standarMutu->nama_standar ?? '-' }}</span></div>
            <div class="col-md-4"><small class="text-muted d-block">Tahun Akademik</small><span class="fw-semibold">{{ $siklus->tahunAkademik->nama ?? '-' }}</span></div>
            <div class="col-md-4"><small class="text-muted d-block">Tahap</small><span class="badge bg-primary">{{ ucfirst($siklus->tahap_sekarang) }}</span></div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Data Evaluasi</h6></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Capaian Indikator</th>
                        <th>Catatan Evaluasi</th>
                        <th>Dievaluasi Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siklus->ppeppEvaluasi as $index => $ev)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $ev->capaianIndikator->indikatorMutu->nama_indikator ?? '-' }}</td>
                        <td>{{ $ev->catatan_evaluasi ?? '-' }}</td>
                        <td>{{ $ev->dievaluasiOleh->nama ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="fas fa-chart-bar fa-2x mb-2 d-block"></i>Belum ada data evaluasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
