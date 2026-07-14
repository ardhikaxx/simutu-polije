@extends('layouts.app')

@section('title', 'Detail Siklus PPEPP - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Detail Siklus PPEPP</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ppepp.index') }}" class="text-decoration-none">PPEPP</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('ppepp.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex flex-column flex-sm-row mb-2 pb-2 border-bottom">
                    <div class="text-muted fw-semibold" style="min-width:140px;">Standar Mutu</div>
                    <div class="fw-semibold">{{ $siklus->standarMutu->nama_standar ?? '-' }}</div>
                </div>
                <div class="d-flex flex-column flex-sm-row mb-2 pb-2 border-bottom">
                    <div class="text-muted fw-semibold" style="min-width:140px;">Tahun Akademik</div>
                    <div>{{ $siklus->tahunAkademik->nama ?? '-' }}</div>
                </div>
                <div class="d-flex flex-column flex-sm-row mb-2 pb-2 border-bottom">
                    <div class="text-muted fw-semibold" style="min-width:140px;">Tahap Sekarang</div>
                    <div><span class="badge bg-primary">{{ ucfirst($siklus->tahap_sekarang) }}</span></div>
                </div>
                <div class="d-flex flex-column flex-sm-row mb-2">
                    <div class="text-muted fw-semibold" style="min-width:140px;">Status</div>
                    <div><span class="badge bg-{{ $siklus->status_siklus === 'Selesai' ? 'success' : 'warning' }}">{{ $siklus->status_siklus }}</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="fw-bold mb-3">Progres Pelaksanaan</h6>
                <div class="progress mb-2" style="height: 25px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressPercent }}%;" aria-valuenow="{{ $progressPercent }}">{{ $progressPercent }}%</div>
                </div>
                <small class="text-muted">{{ $siklus->ppeppPelaksanaan->where('status', 'Selesai')->count() }} dari {{ $siklus->ppeppPelaksanaan->count() }} selesai</small>
            </div>
        </div>
    </div>
</div>

<h5 class="fw-bold mb-3">Tahapan PPEPP</h5>
<div class="row">
    @foreach($stages as $key => $stage)
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 {{ $siklus->tahap_sekarang === $key ? 'border-primary border-2' : '' }}">
            <div class="card-body text-center">
                <div class="mb-2">
                    @php
                    $stageIndex = array_search($key, array_keys($stages));
                    $isActive = $stageIndex <= $currentIndex;
                    $isCurrent = $siklus->tahap_sekarang === $key;
                    @endphp
                    <i class="fas {{ $stage['icon'] }} fa-2x {{ $isActive ? 'text-primary' : 'text-muted' }}"></i>
                </div>
                <h6 class="fw-bold {{ $isActive ? 'text-primary' : 'text-muted' }}">{{ $stage['label'] }}</h6>
                @if($isCurrent)
                    <span class="badge bg-primary">Tahap Aktif</span>
                @elseif($isActive)
                    <span class="badge bg-success">Selesai</span>
                @else
                    <span class="badge bg-secondary">Menunggu</span>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
