@extends('layouts.app')

@section('title', 'Tambah Jurusan - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Tambah Jurusan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('master-data.jurusan.index') }}" class="text-decoration-none">Jurusan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('master-data.jurusan.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode_jurusan" class="form-label">Kode Jurusan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('kode_jurusan') is-invalid @enderror"
                        id="kode_jurusan" name="kode_jurusan" value="{{ old('kode_jurusan') }}" required>
                    @error('kode_jurusan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama_jurusan" class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror"
                        id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan') }}" required>
                    @error('nama_jurusan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('master-data.jurusan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
