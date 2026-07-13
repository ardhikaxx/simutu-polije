@extends('layouts.app')

@section('title', 'Laporan - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Laporan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-sync-alt fa-3x text-primary mb-3"></i>
                <h5 class="fw-bold">Laporan PPEPP</h5>
                <p class="text-muted small">Generate laporan siklus PPEPP berdasarkan standar mutu.</p>
            </div>
            <div class="card-footer bg-white">
                @if($ppeppSikluses->count() > 0)
                <select class="form-select form-select-sm mb-2" id="ppepp-select">
                    @foreach($ppeppSikluses as $siklus)
                    <option value="{{ $siklus->id }}">{{ $siklus->standarMutu->nama_standar ?? '-' }} ({{ $siklus->tahunAkademik->nama ?? '-' }})</option>
                    @endforeach
                </select>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-sm btn-outline-danger" id="ppepp-pdf"><i class="fas fa-file-pdf me-1"></i>Download PDF</a>
                    <a href="#" class="btn btn-sm btn-outline-success" id="ppepp-excel"><i class="fas fa-file-excel me-1"></i>Download Excel</a>
                </div>
                @else
                <p class="text-muted small mb-0">Belum ada siklus PPEPP.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-clipboard-check fa-3x text-success mb-3"></i>
                <h5 class="fw-bold">Laporan Audit</h5>
                <p class="text-muted small">Generate laporan hasil audit per periode.</p>
            </div>
            <div class="card-footer bg-white">
                @if($periodeAudits->count() > 0)
                <select class="form-select form-select-sm mb-2" id="audit-select">
                    @foreach($periodeAudits as $periode)
                    <option value="{{ $periode->id }}">{{ $periode->nama }} ({{ $periode->tahunAkademik->nama ?? '-' }})</option>
                    @endforeach
                </select>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-sm btn-outline-danger" id="audit-pdf"><i class="fas fa-file-pdf me-1"></i>Download PDF</a>
                    <a href="#" class="btn btn-sm btn-outline-success" id="audit-excel"><i class="fas fa-file-excel me-1"></i>Download Excel</a>
                </div>
                @else
                <p class="text-muted small mb-0">Belum ada periode audit.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-3x text-info mb-3"></i>
                <h5 class="fw-bold">Laporan Indikator</h5>
                <p class="text-muted small">Generate laporan capaian indikator mutu.</p>
            </div>
            <div class="card-footer bg-white">
                <div class="d-grid gap-2">
                    <a href="{{ route('laporan.indikator') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-chart-bar me-1"></i>Lihat Laporan</a>
                    <a href="{{ route('laporan.download-pdf', ['indikator', 0]) }}" class="btn btn-sm btn-outline-danger"><i class="fas fa-file-pdf me-1"></i>Download PDF</a>
                    <a href="{{ route('laporan.download-excel', ['indikator', 0]) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-file-excel me-1"></i>Download Excel</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#ppepp-pdf').on('click', function(e) { e.preventDefault(); var id = $('#ppepp-select').val(); window.location.href = '{{ url("laporan/download-pdf/ppepp") }}/' + id; });
$('#ppepp-excel').on('click', function(e) { e.preventDefault(); var id = $('#ppepp-select').val(); window.location.href = '{{ url("laporan/download-excel/ppepp") }}/' + id; });
$('#audit-pdf').on('click', function(e) { e.preventDefault(); var id = $('#audit-select').val(); window.location.href = '{{ url("laporan/download-pdf/audit") }}/' + id; });
$('#audit-excel').on('click', function(e) { e.preventDefault(); var id = $('#audit-select').val(); window.location.href = '{{ url("laporan/download-excel/audit") }}/' + id; });
</script>
@endpush
