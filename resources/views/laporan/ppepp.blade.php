@extends('layouts.app')

@section('title', 'Laporan PPEPP - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Laporan PPEPP</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('laporan.index') }}" class="text-decoration-none">Laporan</a></li>
                <li class="breadcrumb-item active">PPEPP</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('laporan.download-pdf', ['ppepp', $siklus->id]) }}" class="btn btn-outline-danger"><i class="fas fa-file-pdf me-1"></i>PDF</a>
        <a href="{{ route('laporan.download-excel', ['ppepp', $siklus->id]) }}" class="btn btn-outline-success"><i class="fas fa-file-excel me-1"></i>Excel</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4"><small class="text-muted d-block">Standar Mutu</small><span class="fw-semibold">{{ $siklus->standarMutu->nama_standar ?? '-' }}</span></div>
            <div class="col-md-4"><small class="text-muted d-block">Tahun Akademik</small><span class="fw-semibold">{{ $siklus->tahunAkademik->nama ?? '-' }}</span></div>
            <div class="col-md-4"><small class="text-muted d-block">Tahap</small><span class="badge bg-primary">{{ ucfirst($siklus->tahap_sekarang) }}</span></div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white text-center">
            <div class="card-body">
                <h3 class="mb-0">{{ $siklus->ppeppPelaksanaan->count() }}</h3>
                <small>Total Pelaksanaan</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white text-center">
            <div class="card-body">
                <h3 class="mb-0">{{ $siklus->ppeppPelaksanaan->where('status', 'Selesai')->count() }}</h3>
                <small>Selesai</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-white text-center">
            <div class="card-body">
                <h3 class="mb-0">{{ $siklus->ppeppPelaksanaan->where('status', 'Proses')->count() }}</h3>
                <small>Proses</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card border-0 shadow-sm bg-secondary text-white text-center">
            <div class="card-body">
                <h3 class="mb-0">{{ $siklus->ppeppPelaksanaan->where('status', 'Belum')->count() }}</h3>
                <small>Belum</small>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Data Pelaksanaan</h6></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
                <thead class="table-light">
                    <tr><th>No</th><th>Unit</th><th>Status</th><th>Tanggal</th></tr>
                </thead>
                <tbody>
                    @foreach($siklus->ppeppPelaksanaan as $idx => $pk)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $pk->programStudi->nama_prodi ?? $pk->unitKerja->nama_unit ?? '-' }}</td>
                        <td><span class="badge bg-{{ match($pk->status) { 'Selesai'=>'success', 'Proses'=>'warning', default=>'secondary' } }}">{{ $pk->status }}</span></td>
                        <td>{{ $pk->tanggal_pelaksanaan ? $pk->tanggal_pelaksanaan->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
