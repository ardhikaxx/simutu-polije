@extends('layouts.app')

@section('title', 'Buat Survei - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Buat Survei</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('survei.index') }}" class="text-decoration-none">Survei</a></li>
                <li class="breadcrumb-item active">Buat</li>
            </ol>
        </nav>
    </div>
</div>

<form action="{{ route('survei.store') }}" method="POST">
    @csrf
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Informasi Survei</h6></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Judul Survei <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Survei <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_survei_id') is-invalid @enderror" name="jenis_survei_id" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($jenisSurveis as $js)
                        <option value="{{ $js->id }}" {{ old('jenis_survei_id') == $js->id ? 'selected' : '' }}>{{ $js->nama }}</option>
                        @endforeach
                    </select>
                    @error('jenis_survei_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun Akademik <span class="text-danger">*</span></label>
                    <select class="form-select @error('tahun_akademik_id') is-invalid @enderror" name="tahun_akademik_id" required>
                        <option value="">-- Pilih Tahun Akademik --</option>
                        @foreach($tahunAkademiks as $ta)
                        <option value="{{ $ta->id }}" {{ old('tahun_akademik_id') == $ta->id ? 'selected' : '' }}>{{ $ta->nama }}</option>
                        @endforeach
                    </select>
                    @error('tahun_akademik_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                    @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">Pertanyaan</h6>
            <button type="button" class="btn btn-sm btn-primary" id="addQuestion"><i class="fas fa-plus me-1"></i>Tambah</button>
        </div>
        <div class="card-body">
            <div id="questions-list">
                <div class="row mb-3 question-row">
                    <div class="col-md-7">
                        <label class="form-label small">Teks Pertanyaan <span class="text-danger">*</span></label>
                        <input type="text" name="pertanyaan[0][teks_pertanyaan]" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Tipe Jawaban <span class="text-danger">*</span></label>
                        <select name="pertanyaan[0][tipe_jawaban]" class="form-select" required>
                            <option value="skala_likert">Skala Likert (1-5)</option>
                            <option value="pilihan_ganda">Pilihan Ganda</option>
                            <option value="esai">Esai</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-question"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan Survei</button>
        <a href="{{ route('survei.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
var qIndex = 1;
$('#addQuestion').on('click', function() {
    var row = `<div class="row mb-3 question-row">
        <div class="col-md-7">
            <label class="form-label small">Teks Pertanyaan <span class="text-danger">*</span></label>
            <input type="text" name="pertanyaan[${qIndex}][teks_pertanyaan]" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label small">Tipe Jawaban <span class="text-danger">*</span></label>
            <select name="pertanyaan[${qIndex}][tipe_jawaban]" class="form-select" required>
                <option value="skala_likert">Skala Likert (1-5)</option>
                <option value="pilihan_ganda">Pilihan Ganda</option>
                <option value="esai">Esai</option>
            </select>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-sm btn-danger remove-question"><i class="fas fa-times"></i></button>
        </div>
    </div>`;
    $('#questions-list').append(row);
    qIndex++;
});
$(document).on('click', '.remove-question', function() { $(this).closest('.question-row').remove(); });
</script>
@endpush
