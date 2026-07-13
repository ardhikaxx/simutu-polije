@extends('layouts.app')

@section('title', 'Tambah Standar Mutu - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Tambah Standar Mutu</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('standar-mutu.index') }}" class="text-decoration-none">Standar Mutu</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('standar-mutu.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kategori_standar_id" class="form-label">Kategori Standar <span class="text-danger">*</span></label>
                    <select class="form-select @error('kategori_standar_id') is-invalid @enderror" id="kategori_standar_id" name="kategori_standar_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriStandars as $ks)
                        <option value="{{ $ks->id }}" {{ old('kategori_standar_id') == $ks->id ? 'selected' : '' }}>{{ $ks->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_standar_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="kode_standar" class="form-label">Kode Standar <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('kode_standar') is-invalid @enderror"
                        id="kode_standar" name="kode_standar" value="{{ old('kode_standar') }}" required>
                    @error('kode_standar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="nama_standar" class="form-label">Nama Standar <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_standar') is-invalid @enderror"
                        id="nama_standar" name="nama_standar" value="{{ old('nama_standar') }}" required>
                    @error('nama_standar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                        id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="dasar_hukum" class="form-label">Dasar Hukum</label>
                    <input type="text" class="form-control @error('dasar_hukum') is-invalid @enderror"
                        id="dasar_hukum" name="dasar_hukum" value="{{ old('dasar_hukum') }}">
                    @error('dasar_hukum')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('standar-mutu.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
