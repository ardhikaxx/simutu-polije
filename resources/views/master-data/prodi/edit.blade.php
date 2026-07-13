@extends('layouts.app')

@section('title', 'Edit Program Studi - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Edit Program Studi</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('master-data.prodi.index') }}" class="text-decoration-none">Program Studi</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('master-data.prodi.update', $prodi) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jurusan_id" class="form-label">Jurusan <span class="text-danger">*</span></label>
                    <select class="form-select @error('jurusan_id') is-invalid @enderror" id="jurusan_id" name="jurusan_id" required>
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $prodi->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jenjang" class="form-label">Jenjang <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenjang') is-invalid @enderror" id="jenjang" name="jenjang" required>
                        <option value="">-- Pilih Jenjang --</option>
                        @foreach(['D3', 'D4', 'S2Terapan'] as $j)
                        <option value="{{ $j }}" {{ old('jenjang', $prodi->jenjang) == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                    @error('jenjang')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="kode_prodi" class="form-label">Kode Prodi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('kode_prodi') is-invalid @enderror"
                        id="kode_prodi" name="kode_prodi" value="{{ old('kode_prodi', $prodi->kode_prodi) }}" required>
                    @error('kode_prodi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama_prodi" class="form-label">Nama Program Studi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_prodi') is-invalid @enderror"
                        id="nama_prodi" name="nama_prodi" value="{{ old('nama_prodi', $prodi->nama_prodi) }}" required>
                    @error('nama_prodi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('master-data.prodi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
