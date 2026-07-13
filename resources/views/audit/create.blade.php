@extends('layouts.app')

@section('title', 'Buat Jadwal Audit - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Buat Jadwal Audit</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jadwal-audit.index') }}" class="text-decoration-none">Jadwal Audit</a></li>
                <li class="breadcrumb-item active">Buat</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('jadwal-audit.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Periode Audit <span class="text-danger">*</span></label>
                    <select class="form-select @error('periode_audit_id') is-invalid @enderror" name="periode_audit_id" required>
                        <option value="">-- Pilih Periode --</option>
                        @foreach($periodeAudits as $pa)
                        <option value="{{ $pa->id }}" {{ old('periode_audit_id') == $pa->id ? 'selected' : '' }}>{{ $pa->nama }}</option>
                        @endforeach
                    </select>
                    @error('periode_audit_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                    <select class="form-select @error('program_studi_id') is-invalid @enderror" name="program_studi_id" required>
                        <option value="">-- Pilih Prodi --</option>
                        @foreach($prodis as $p)
                        <option value="{{ $p->id }}" {{ old('program_studi_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                    @error('program_studi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Audit <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_audit') is-invalid @enderror" name="tanggal_audit" value="{{ old('tanggal_audit') }}" required>
                    @error('tanggal_audit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Audit <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_audit') is-invalid @enderror" name="jenis_audit" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Internal" {{ old('jenis_audit') == 'Internal' ? 'selected' : '' }}>Internal</option>
                        <option value="Eksternal" {{ old('jenis_audit') == 'Eksternal' ? 'selected' : '' }}>Eksternal</option>
                        <option value="Self Assessment" {{ old('jenis_audit') == 'Self Assessment' ? 'selected' : '' }}>Self Assessment</option>
                    </select>
                    @error('jenis_audit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('jadwal-audit.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
