@extends('layouts.app')

@section('title', 'Edit Periode Audit - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Edit Periode Audit</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('master-data.periode-audit.index') }}" class="text-decoration-none">Periode Audit</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('master-data.periode-audit.update', $periodeAudit) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Periode <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                        id="nama" name="nama" value="{{ old('nama', $periodeAudit->nama) }}" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tahun_akademik_id" class="form-label">Tahun Akademik <span class="text-danger">*</span></label>
                    <select class="form-select @error('tahun_akademik_id') is-invalid @enderror" id="tahun_akademik_id" name="tahun_akademik_id" required>
                        <option value="">-- Pilih Tahun Akademik --</option>
                        @foreach($tahunAkademiks as $ta)
                        <option value="{{ $ta->id }}" {{ old('tahun_akademik_id', $periodeAudit->tahun_akademik_id) == $ta->id ? 'selected' : '' }}>
                            {{ $ta->nama }} {{ $ta->is_active ? '(Aktif)' : '' }}
                        </option>
                        @endforeach
                    </select>
                    @error('tahun_akademik_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                        id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $periodeAudit->tanggal_mulai->format('Y-m-d')) }}" required>
                    @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                        id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $periodeAudit->tanggal_selesai->format('Y-m-d')) }}" required>
                    @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('master-data.periode-audit.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
