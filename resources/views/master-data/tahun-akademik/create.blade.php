@extends('layouts.app')

@section('title', 'Tambah Tahun Akademik - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Tambah Tahun Akademik</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('master-data.tahun-akademik.index') }}" class="text-decoration-none">Tahun Akademik</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('master-data.tahun-akademik.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Tahun Akademik <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                        id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: 2024/2025" required>
                    @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                    <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                        <option value="">-- Pilih Semester --</option>
                        <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                        <option value="Pendek" {{ old('semester') == 'Pendek' ? 'selected' : '' }}>Pendek</option>
                    </select>
                    @error('semester')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                        id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                        id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                    @error('tanggal_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('master-data.tahun-akademik.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
