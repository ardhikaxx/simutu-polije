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
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('laporan.download-pdf', ['indikator', 0]) }}" class="btn btn-outline-danger"><i class="fas fa-file-pdf me-1"></i>PDF</a>
        <a href="{{ route('laporan.download-excel', ['indikator', 0]) }}" class="btn btn-outline-success"><i class="fas fa-file-excel me-1"></i>Excel</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
</div>

@if($tahunAkademikAktif)
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>Menampilkan data indikator untuk Tahun Akademik <strong>{{ $tahunAkademikAktif->nama }}</strong>.
</div>
@else
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle me-2"></i>Belum ada tahun akademik aktif.
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
                <thead class="table-light">
                    <tr><th>No</th><th>Standar Mutu</th><th>Indikator</th><th>Formula</th><th>Frekuensi</th><th>Target</th><th>Capaian</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($indikators as $idx => $item)
                    @php
                        $target = $item->targetIndikator->latest()->first();
                        $capaian = $item->capaianIndikator->latest()->first();
                    @endphp
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $item->standarMutu->nama_standar ?? '-' }}</td>
                        <td>{{ $item->nama_indikator }}</td>
                        <td>{{ $item->formula_perhitungan ?? '-' }}</td>
                        <td>{{ $item->frekuensi_pengukuran }}</td>
                        <td>{{ $target ? $target->nilai_target : '-' }}</td>
                        <td>{{ $capaian ? $capaian->nilai_capaian : '-' }}</td>
                        <td>
                            @if($capaian)
                                @if($capaian->status_warna === 'baik')<span class="badge bg-success">Baik</span>
                                @elseif($capaian->status_warna === 'perlu_perbaikan')<span class="badge bg-warning text-dark">Perlu Perbaikan</span>
                                @else<span class="badge bg-danger">Tidak Baik</span>@endif
                            @else <span class="text-muted">-</span> @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data indikator.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
