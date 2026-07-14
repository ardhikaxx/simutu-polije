@extends('layouts.app')

@section('title', $dokumen->judul . ' - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">{{ $dokumen->judul }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dokumen-mutu.index') }}" class="text-decoration-none">Dokumen Mutu</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        @php $badgeClass = match($dokumen->status) { 'Draft'=>'secondary', 'Submitted'=>'warning', 'Reviewed'=>'info', 'Approved'=>'primary', 'Published'=>'success', default=>'secondary' }; @endphp
        <span class="badge bg-{{ $badgeClass }} fs-6">{{ $dokumen->status }}</span>
        <a href="{{ route('dokumen-mutu.versions', $dokumen) }}" class="btn btn-outline-info"><i class="fas fa-history me-1"></i>Riwayat Revisi</a>
        <a href="{{ route('dokumen-mutu.edit', $dokumen) }}" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i>Edit</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Informasi Dokumen</h6></div>
            <div class="card-body">
                <div class="d-flex flex-column flex-sm-row mb-2 pb-2 border-bottom">
                    <div class="text-muted fw-semibold" style="min-width:160px;">Nomor Dokumen</div>
                    <div class="fw-semibold"><code>{{ $dokumen->nomor_dokumen }}</code></div>
                </div>
                <div class="d-flex flex-column flex-sm-row mb-2 pb-2 border-bottom">
                    <div class="text-muted fw-semibold" style="min-width:160px;">Kategori</div>
                    <div>{{ $dokumen->kategoriDokumen->nama ?? '-' }}</div>
                </div>
                <div class="d-flex flex-column flex-sm-row mb-2 pb-2 border-bottom">
                    <div class="text-muted fw-semibold" style="min-width:160px;">Program Studi</div>
                    <div>{{ $dokumen->programStudi->nama_prodi ?? '-' }}</div>
                </div>
                <div class="d-flex flex-column flex-sm-row mb-2 pb-2 border-bottom">
                    <div class="text-muted fw-semibold" style="min-width:160px;">Unit Kerja</div>
                    <div>{{ $dokumen->unitKerja->nama_unit ?? '-' }}</div>
                </div>
                <div class="d-flex flex-column flex-sm-row mb-2 pb-2 border-bottom">
                    <div class="text-muted fw-semibold" style="min-width:160px;">Standar Mutu</div>
                    <div>{{ $dokumen->standarMutu->nama_standar ?? '-' }}</div>
                </div>
                <div class="d-flex flex-column flex-sm-row mb-2 pb-2 border-bottom">
                    <div class="text-muted fw-semibold" style="min-width:160px;">Versi Aktif</div>
                    <div>v{{ $dokumen->versiAktif->nomor_versi ?? '1.0' }}</div>
                </div>
                <div class="d-flex flex-column flex-sm-row mb-2">
                    <div class="text-muted fw-semibold" style="min-width:160px;">Dibuat Oleh</div>
                    <div>{{ $dokumen->dibuatOleh->nama ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Riwayat Versi</h6></div>
            <div class="card-body">
                @forelse($dokumen->dokumenMutuVersions->take(5) as $ver)
                <div class="d-flex align-items-start mb-3 {{ !$loop->last ? 'pb-2 border-bottom' : '' }}">
                    <div class="me-3">
                        <span class="badge bg-primary rounded-pill">v{{ $ver->nomor_versi }}</span>
                    </div>
                    <div class="flex-grow-1">
                        <div class="small fw-semibold">{{ $ver->catatan_revisi ?? 'Versi awal' }}</div>
                        <div class="text-muted" style="font-size:0.78rem;">Oleh {{ $ver->dibuatOleh->nama ?? '-' }} &middot; {{ $ver->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                @empty
                <p class="text-muted small mb-0">Belum ada riwayat versi.</p>
                @endforelse
                @if($dokumen->dokumenMutuVersions->count() > 5)
                <a href="{{ route('dokumen-mutu.versions', $dokumen) }}" class="text-primary small"><i class="fas fa-arrow-right me-1"></i>Lihat Semua Riwayat</a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Workflow</h6></div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($dokumen->status === 'Draft')
                    <form action="{{ route('dokumen-mutu.submit', $dokumen) }}" method="POST">@csrf
                        <button type="submit" class="btn btn-warning w-100"><i class="fas fa-paper-plane me-1"></i>Submit</button>
                    </form>
                    @endif
                    @if($dokumen->status === 'Submitted')
                    <form action="{{ route('dokumen-mutu.review', $dokumen) }}" method="POST">@csrf
                        <button type="submit" class="btn btn-info w-100"><i class="fas fa-search me-1"></i>Review</button>
                    </form>
                    @endif
                    @if($dokumen->status === 'Reviewed')
                    <form action="{{ route('dokumen-mutu.approve', $dokumen) }}" method="POST">@csrf
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-check me-1"></i>Setujui</button>
                    </form>
                    @endif
                    @if($dokumen->status === 'Approved')
                    <form action="{{ route('dokumen-mutu.publish', $dokumen) }}" method="POST">@csrf
                        <button type="submit" class="btn btn-success w-100"><i class="fas fa-globe me-1"></i>Publish</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
