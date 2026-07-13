@extends('layouts.app')

@section('title', 'Edit Dokumen Mutu - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Edit Dokumen Mutu</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dokumen-mutu.index') }}" class="text-decoration-none">Dokumen Mutu</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('dokumen-mutu.update', $dokumen) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori Dokumen <span class="text-danger">*</span></label>
                    <select class="form-select @error('kategori_dokumen_id') is-invalid @enderror" name="kategori_dokumen_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriDokumens as $kd)
                        <option value="{{ $kd->id }}" {{ old('kategori_dokumen_id', $dokumen->kategori_dokumen_id) == $kd->id ? 'selected' : '' }}>{{ $kd->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_dokumen_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Standar Mutu</label>
                    <select class="form-select" name="standar_mutu_id">
                        <option value="">-- Pilih Standar Mutu --</option>
                        @foreach($standarMutus as $sm)
                        <option value="{{ $sm->id }}" {{ old('standar_mutu_id', $dokumen->standar_mutu_id) == $sm->id ? 'selected' : '' }}>{{ $sm->nama_standar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $dokumen->judul) }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Program Studi</label>
                    <select class="form-select" name="program_studi_id">
                        <option value="">-- Pilih Prodi --</option>
                        @foreach($prodis as $p)
                        <option value="{{ $p->id }}" {{ old('program_studi_id', $dokumen->program_studi_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Unit Kerja</label>
                    <select class="form-select" name="unit_kerja_id">
                        <option value="">-- Pilih Unit Kerja --</option>
                        @foreach($unitKerjas as $uk)
                        <option value="{{ $uk->id }}" {{ old('unit_kerja_id', $dokumen->unit_kerja_id) == $uk->id ? 'selected' : '' }}>{{ $uk->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('dokumen-mutu.show', $dokumen) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
