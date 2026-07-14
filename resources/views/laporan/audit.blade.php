@extends('layouts.app')

@section('title', 'Laporan Audit - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Laporan Audit: {{ $periode->nama }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('laporan.index') }}" class="text-decoration-none">Laporan</a></li>
                <li class="breadcrumb-item active">Audit</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('laporan.download-pdf', ['audit', $periode->id]) }}" class="btn btn-outline-danger"><i class="fas fa-file-pdf me-1"></i>PDF</a>
        <a href="{{ route('laporan.download-excel', ['audit', $periode->id]) }}" class="btn btn-outline-success"><i class="fas fa-file-excel me-1"></i>Excel</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4"><small class="text-muted d-block">Periode</small><span class="fw-semibold">{{ $periode->nama }}</span></div>
            <div class="col-md-4"><small class="text-muted d-block">Tahun Akademik</small><span class="fw-semibold">{{ $periode->tahunAkademik->nama ?? '-' }}</span></div>
            <div class="col-md-4"><small class="text-muted d-block">Total Jadwal Audit</small><span class="fw-semibold">{{ $periode->jadwalAudit->count() }}</span></div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Hasil Audit per Periode</h6></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
                <thead class="table-light">
                    <tr><th>No</th><th>Program Studi</th><th>Tanggal</th><th>Jenis</th><th>Skor</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($periode->jadwalAudit as $idx => $jadwal)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $jadwal->programStudi->nama_prodi ?? '-' }}</td>
                        <td>{{ $jadwal->tanggal_audit->format('d/m/Y') }}</td>
                        <td><span class="badge bg-info">{{ $jadwal->jenis_audit }}</span></td>
                        <td>
                            @if($jadwal->hasilAudit->count() > 0)
                            {{ number_format($jadwal->hasilAudit->first()->total_skor ?? 0, 1) }}
                            @else - @endif
                        </td>
                        <td><span class="badge bg-{{ match($jadwal->status) { 'Selesai'=>'success', 'Berlangsung'=>'warning', default=>'secondary' } }}">{{ $jadwal->status }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data audit untuk periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
