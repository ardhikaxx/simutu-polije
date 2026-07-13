@extends('layouts.app')

@section('title', 'Edit Unit Kerja - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Edit Unit Kerja</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('master-data.unit-kerja.index') }}" class="text-decoration-none">Unit Kerja</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('master-data.unit-kerja.update', $unitKerja) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_unit" class="form-label">Nama Unit <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_unit') is-invalid @enderror"
                        id="nama_unit" name="nama_unit" value="{{ old('nama_unit', $unitKerja->nama_unit) }}" required>
                    @error('nama_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                        <option value="Unit Kerja" {{ old('jenis', $unitKerja->jenis) == 'Unit Kerja' ? 'selected' : '' }}>Unit Kerja</option>
                        <option value="Fungsional" {{ old('jenis', $unitKerja->jenis) == 'Fungsional' ? 'selected' : '' }}>Fungsional</option>
                    </select>
                    @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('master-data.unit-kerja.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
