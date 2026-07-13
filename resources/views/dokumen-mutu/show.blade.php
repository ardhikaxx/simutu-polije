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
    <div class="d-flex gap-2">
        @php $badgeClass = match($dokumen->status) { 'Draft'=>'secondary', 'Submitted'=>'warning', 'Reviewed'=>'info', 'Approved'=>'primary', 'Published'=>'success', default=>'secondary' }; @endphp
        <span class="badge bg-{{ $badgeClass }} fs-6">{{ $dokumen->status }}</span>
        <a href="{{ route('dokumen-mutu.edit', $dokumen) }}" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i>Edit</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Informasi Dokumen</h6></div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted" style="width:200px">Nomor Dokumen</td><td class="fw-semibold"><code>{{ $dokumen->nomor_dokumen }}</code></td></tr>
                    <tr><td class="text-muted">Kategori</td><td>{{ $dokumen->kategoriDokumen->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Program Studi</td><td>{{ $dokumen->programStudi->nama_prodi ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Unit Kerja</td><td>{{ $dokumen->unitKerja->nama_unit ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Standar Mutu</td><td>{{ $dokumen->standarMutu->nama_standar ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Versi Aktif</td><td>v{{ $dokumen->versiAktif->nomor_versi ?? '1.0' }}</td></tr>
                    <tr><td class="text-muted">Dibuat Oleh</td><td>{{ $dokumen->dibuatOleh->nama ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Riwayat Versi</h6></div>
            <div class="card-body">
                @forelse($dokumen->dokumenMutuVersions as $ver)
                <div class="d-flex align-items-start mb-3">
                    <div class="me-3">
                        <span class="badge bg-primary rounded-pill">v{{ $ver->nomor_versi }}</span>
                    </div>
                    <div>
                        <div class="small fw-semibold">{{ $ver->catatan_revisi ?? 'Versi awal' }}</div>
                        <div class="text-muted" style="font-size:0.78rem;">Oleh {{ $ver->dibuatOleh->nama ?? '-' }} &middot; {{ $ver->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                @empty
                <p class="text-muted small mb-0">Belum ada riwayat versi.</p>
                @endforelse
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
