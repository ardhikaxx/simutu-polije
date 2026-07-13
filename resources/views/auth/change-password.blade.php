@extends('layouts.app')

@section('title', 'Ganti Password - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Ganti Password</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profile.show') }}" class="text-decoration-none">Profil Saya</a></li>
                <li class="breadcrumb-item active">Ganti Password</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('profile.show') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold"><i class="fas fa-key me-2"></i>Form Ganti Password</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('password.change.store') }}" method="POST" id="changePasswordForm">
                    @csrf

                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold">
                            <i class="fas fa-lock me-1"></i>Password Lama
                        </label>
                        <div class="position-relative">
                            <input type="password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password"
                                   name="current_password"
                                   placeholder="Masukkan password lama"
                                   required
                                   autofocus>
                            <button type="button" class="password-toggle" onclick="togglePassword('current_password', 'toggleIcon1')">
                                <i class="fas fa-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            <i class="fas fa-key me-1"></i>Password Baru
                        </label>
                        <div class="position-relative">
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Masukkan password baru"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon2')">
                                <i class="fas fa-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">
                            <i class="fas fa-check-circle me-1"></i>Konfirmasi Password
                        </label>
                        <div class="position-relative">
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Ulangi password baru"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon3')">
                                <i class="fas fa-eye" id="toggleIcon3"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: none;
    color: #6b7280;
    cursor: pointer;
}
</style>
@endsection

@push('scripts')
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const errorEl = document.getElementById('password-errors');
    if (errorEl) {
        try {
            const errors = JSON.parse(errorEl.dataset.errors);
            const messages = Object.values(errors).flat().join('<br>');
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: messages,
                confirmButtonColor: '#1a237e',
                confirmButtonText: 'Tutup'
            });
        } catch(e) {}
    }
});
</script>
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal Mengubah Password',
    html: `{!! $errors->first() !!}`,
    confirmButtonColor: '#1a237e',
    confirmButtonText: 'Tutup'
});
</script>
@endif
@endpush
