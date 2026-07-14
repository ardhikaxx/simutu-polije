<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - SIMUTU POLIJE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a237e 0%, #283593 40%, #3949ab 70%, #5c6bc0 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-wrapper {
            width: 100%;
            max-width: 480px;
            padding: 1rem;
        }

        .register-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            padding: 2rem 2rem 1.5rem;
            text-align: center;
            color: #fff;
        }

        .register-logo {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            backdrop-filter: blur(10px);
        }

        .register-logo i {
            font-size: 1.7rem;
        }

        .register-header h1 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }

        .register-header p {
            font-size: 0.8rem;
            opacity: 0.85;
            margin: 0;
        }

        .register-body {
            padding: 1.5rem 2rem;
        }

        .register-body .form-label {
            font-weight: 600;
            font-size: 0.83rem;
            color: #374151;
        }

        .register-body .form-control,
        .register-body .form-select {
            border-radius: 8px;
            padding: 0.55rem 0.85rem;
            border-color: #d1d5db;
            font-size: 0.88rem;
        }

        .register-body .form-control:focus,
        .register-body .form-select:focus {
            border-color: #1a237e;
            box-shadow: 0 0 0 0.2rem rgba(26,35,126,0.15);
        }

        .btn-register {
            background: linear-gradient(135deg, #1a237e, #283593);
            border: none;
            border-radius: 8px;
            padding: 0.6rem;
            font-weight: 600;
            font-size: 0.92rem;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #283593, #3949ab);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(26,35,126,0.4);
        }

        .register-footer {
            text-align: center;
            padding: 0.75rem 2rem 1.25rem;
            font-size: 0.78rem;
            color: #6b7280;
        }

        .register-footer a {
            color: #1a237e;
            text-decoration: none;
            font-weight: 600;
        }

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

        @media (max-width: 575.98px) {
            .register-body {
                padding: 1.25rem 1rem;
            }
            .register-header {
                padding: 1.5rem 1rem 1.25rem;
            }
            .register-body .form-control,
            .register-body .form-select {
                font-size: 16px !important;
            }
            .register-footer {
                padding: 0.75rem 1rem 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-card">
            <div class="register-header">
                <div class="register-logo">
                    <img src="{{ asset('assets/logo-polije.png') }}" alt="Logo Polije" style="width:48px;height:48px;object-fit:contain;">
                </div>
                <h1>SIMUTU POLIJE</h1>
                <p>Daftar Akun Baru</p>
            </div>

            <div class="register-body">
                @if($errors->any())
                    <div id="register-errors" data-errors="{{ $errors->toJson() }}"></div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">
                            <i class="fas fa-user me-1"></i>Nama Lengkap
                        </label>
                        <input type="text"
                               class="form-control @error('nama') is-invalid @enderror"
                               id="nama"
                               name="nama"
                               value="{{ old('nama') }}"
                               placeholder="Masukkan nama lengkap"
                               required
                               autofocus>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-1"></i>Email
                        </label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Masukkan email"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">
                            <i class="fas fa-user-tag me-1"></i>Jenis Akun
                        </label>
                        <select class="form-select @error('role') is-invalid @enderror"
                                id="role"
                                name="role"
                                required>
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih jenis akun</option>
                            <option value="mahasiswa" {{ old('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="alumni" {{ old('role') === 'alumni' ? 'selected' : '' }}>Alumni</option>
                            <option value="mitra_industri" {{ old('role') === 'mitra_industri' ? 'selected' : '' }}>Mitra Industri</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-1"></i>Password
                        </label>
                        <div class="position-relative">
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Minimal 8 karakter"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="fas fa-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-1"></i>Konfirmasi Password
                        </label>
                        <div class="position-relative">
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Ulangi password"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                <i class="fas fa-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register btn-primary w-100">
                        <i class="fas fa-user-plus me-2"></i>Daftar
                    </button>
                </form>
            </div>

            <div class="register-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>

        <div class="text-center mt-3" style="font-size:0.72rem;color:rgba(255,255,255,0.6);">
            &copy; {{ date('Y') }} Politeknik Negeri Jember
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword(inputId, iconId) {
            const pwd = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const errorEl = document.getElementById('register-errors');
            if (errorEl) {
                try {
                    const errors = JSON.parse(errorEl.dataset.errors);
                    const messages = Object.values(errors).flat().join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Pendaftaran Gagal',
                        html: messages,
                        confirmButtonColor: '#1a237e',
                        confirmButtonText: 'Tutup'
                    });
                } catch(e) {}
            }
        });
    </script>
</body>
</html>
