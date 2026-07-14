@extends('layouts.app')

@section('title', 'Riwayat Revisi - ' . $dokumen->judul)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Riwayat Revisi: {{ $dokumen->judul }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dokumen-mutu.index') }}" class="text-decoration-none">Dokumen Mutu</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dokumen-mutu.show', $dokumen) }}" class="text-decoration-none">{{ $dokumen->judul }}</a></li>
                <li class="breadcrumb-item active">Revisi</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('dokumen-mutu.show', $dokumen) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

@if(in_array($dokumen->status, ['Draft', 'Reviewed']))
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0" style="font-size:0.88rem;"><i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Revisi Baru</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('dokumen-mutu.revisi', $dokumen) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Catatan Revisi <span class="text-danger">*</span></label>
                <textarea name="catatan_revisi" class="form-control @error('catatan_revisi') is-invalid @enderror" rows="3" placeholder="Jelaskan perubahan yang dilakukan pada revisi ini..." required>{{ old('catatan_revisi') }}</textarea>
                @error('catatan_revisi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i>Simpan Revisi
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @forelse($versions as $index => $version)
        <div class="d-flex mb-4 {{ !$loop->last ? 'pb-4 border-bottom' : '' }}">
            <div class="me-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center {{ $version->id === $dokumen->versi_aktif_id ? 'bg-primary text-white' : 'bg-light text-muted' }}" style="width:40px;height:40px;min-width:40px;">
                    <span class="fw-bold" style="font-size:0.75rem;">v{{ $version->nomor_versi }}</span>
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <span class="fw-bold" style="font-size:0.88rem;">Versi {{ $version->nomor_versi }}</span>
                        @if($version->id === $dokumen->versi_aktif_id)
                            <span class="badge bg-primary ms-2" style="font-size:0.65rem;">Aktif</span>
                        @endif
                    </div>
                    <small class="text-muted">{{ $version->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <div class="text-muted mb-1" style="font-size:0.78rem;">
                    <i class="fas fa-user me-1"></i>{{ $version->dibuatOleh->nama ?? '-' }}
                </div>
                @if($version->catatan_revisi)
                <div class="bg-light rounded p-2 mt-2" style="font-size:0.8rem;">
                    <i class="fas fa-comment-alt me-1 text-primary"></i>{{ $version->catatan_revisi }}
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-4 text-muted">
            <i class="fas fa-history fa-2x mb-2"></i>
            <p>Belum ada riwayat revisi.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
