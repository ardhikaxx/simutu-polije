@extends('layouts.app')

@section('title', 'Template Dokumen Mutu - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Template Dokumen Mutu</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Template Dokumen</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('template-dokumen.download-all') }}" class="btn btn-danger">
        <i class="fas fa-file-pdf me-1"></i>Download Semua Template (PDF)
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('template-dokumen.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Cari Template</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Nama template atau deskripsi..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Standar Mutu</label>
                    <select name="standar" class="form-select form-select-sm">
                        <option value="">Semua Standar</option>
                        @foreach($standarMutus as $sm)
                        <option value="{{ $sm->id }}" {{ request('standar') == $sm->id ? 'selected' : '' }}>{{ $sm->nama_standar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fas fa-search me-1"></i>Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row g-3">
    @forelse($templates as $template)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-start mb-3">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger me-3" style="width:44px;height:44px;min-width:44px;">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1" style="font-size:0.88rem;">{{ $template->nama_template }}</h6>
                        <span class="badge bg-light text-muted" style="font-size:0.7rem;">
                            {{ $template->standarMutu->kode_standar ?? '-' }}
                        </span>
                    </div>
                </div>
                <p class="text-muted small mb-3" style="font-size:0.78rem;">{{ $template->deskripsi ?? '-' }}</p>
                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size:0.72rem;">
                    <span><i class="fas fa-weight-hanging me-1"></i>{{ $template->ukuran_file }} KB</span>
                    <span><i class="fas fa-download me-1"></i>{{ $template->downloads }} unduhan</span>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0">
                <a href="{{ route('template-dokumen.download', $template) }}" class="btn btn-sm btn-outline-danger w-100">
                    <i class="fas fa-download me-1"></i>Download Template
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <h5 class="fw-bold">Belum Ada Template</h5>
            <p class="text-muted">Template dokumen mutu belum tersedia.</p>
        </div>
    </div>
    @endforelse
</div>
@endsection
