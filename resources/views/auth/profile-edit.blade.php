@extends('layouts.app')

@section('title', 'Edit Profil - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Edit Profil</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profile.show') }}" class="text-decoration-none">Profil Saya</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('profile.show') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                @if($user->foto_profil)
                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="rounded-circle mb-3" width="100" height="100" style="object-fit:cover;" id="preview">
                @else
                    <div class="avatar-placeholder-lg rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:100px;height:100px;background:#1a237e;color:#fff;font-weight:700;font-size:2.5rem;" id="preview-placeholder">
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    </div>
                    <img src="" alt="Preview" class="rounded-circle mb-3 d-none" width="100" height="100" style="object-fit:cover;" id="preview">
                @endif
                <h5 class="fw-bold mb-1">{{ $user->nama }}</h5>
                <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $user->getRoleNames()->first() ?? '')) }}</span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Form Edit Profil</h6></div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            <small class="text-muted">Email tidak dapat diubah.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP / NIM</label>
                            <input type="text" name="nip_nim" class="form-control" value="{{ old('nip_nim', $user->nip_nim) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="foto_profil" class="form-control @error('foto_profil') is-invalid @enderror" accept="image/*" onchange="previewImage(event)">
                            <small class="text-muted">Maks 2MB. Format: JPG, PNG.</small>
                            @error('foto_profil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jurusan</label>
                            <select name="jurusan_id" class="form-select">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ old('jurusan_id', $user->jurusan_id) == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Program Studi</label>
                            <select name="program_studi_id" class="form-select">
                                <option value="">-- Pilih Prodi --</option>
                                @foreach($prodis as $p)
                                <option value="{{ $p->id }}" {{ old('program_studi_id', $user->program_studi_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit Kerja</label>
                            <select name="unit_kerja_id" class="form-select">
                                <option value="">-- Pilih Unit Kerja --</option>
                                @foreach($unitKerjas as $u)
                                <option value="{{ $u->id }}" {{ old('unit_kerja_id', $user->unit_kerja_id) == $u->id ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        let preview = document.getElementById('preview');
        let placeholder = document.getElementById('preview-placeholder');
        preview.src = reader.result;
        preview.classList.remove('d-none');
        if (placeholder) placeholder.classList.add('d-none');
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
