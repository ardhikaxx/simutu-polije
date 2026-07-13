@extends('layouts.app')

@section('title', 'Laporan Indikator - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Laporan Capaian Indikator</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('laporan.index') }}" class="text-decoration-none">Laporan</a></li>
                <li class="breadcrumb-item active">Indikator</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('laporan.download-pdf', ['indikator', 0]) }}" class="btn btn-outline-danger"><i class="fas fa-file-pdf me-1"></i>PDF</a>
        <a href="{{ route('laporan.download-excel', ['indikator', 0]) }}" class="btn btn-outline-success"><i class="fas fa-file-excel me-1"></i>Excel</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($tahunAkademikAktif)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>Menampilkan data indikator untuk Tahun Akademik <strong>{{ $tahunAkademikAktif->nama }}</strong>.
        </div>
        @else
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>Belum ada tahun akademik aktif.
        </div>
        @endif

        <div class="text-center py-5">
            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
            <h5 class="fw-bold">Laporan Indikator Mutu</h5>
            <p class="text-muted">Halaman laporan capaian indikator akan menampilkan data target vs capaian untuk setiap indikator mutu.</p>
        </div>
    </div>
</div>
@endsection
