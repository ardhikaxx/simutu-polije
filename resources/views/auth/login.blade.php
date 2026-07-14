<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SIMUTU POLIJE</title>
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

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 1rem;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            color: #fff;
        }

        .login-logo {
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
        }

        .login-logo i {
            font-size: 2rem;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            letter-spacing: 1px;
        }

        .login-header p {
            font-size: 0.82rem;
            opacity: 0.85;
            margin: 0;
        }

        .login-body {
            padding: 2rem;
        }

        .login-body .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #374151;
        }

        .login-body .form-control {
            border-radius: 8px;
            padding: 0.6rem 0.85rem;
            border-color: #d1d5db;
            font-size: 0.9rem;
        }

        .login-body .form-control:focus {
            border-color: #1a237e;
            box-shadow: 0 0 0 0.2rem rgba(26,35,126,0.15);
        }

        .btn-login {
            background: linear-gradient(135deg, #1a237e, #283593);
            border: none;
            border-radius: 8px;
            padding: 0.65rem;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #283593, #3949ab);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(26,35,126,0.4);
        }

        .login-footer {
            text-align: center;
            padding: 1rem 2rem 1.5rem;
            font-size: 0.78rem;
            color: #6b7280;
        }

        .login-footer a {
            color: #1a237e;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .form-check-input:checked {
            background-color: #1a237e;
            border-color: #1a237e;
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
            .login-body {
                padding: 1.25rem 1rem;
            }
            .login-header {
                padding: 1.75rem 1rem 1.5rem;
            }
            .login-body .form-control {
                font-size: 16px !important;
            }
            .login-footer {
                padding: 0.75rem 1rem 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <img src="{{ asset('assets/logo-polije.png') }}" alt="Logo Polije" style="width:52px;height:52px;object-fit:contain;">
                </div>
                <h1>SIMUTU POLIJE</h1>
                <p>Sistem Informasi Penjaminan Mutu</p>
            </div>

            <div class="login-body">
                @if($errors->any())
                    <div id="login-errors" data-errors="{{ $errors->toJson() }}"></div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

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
                               required
                               autofocus>
                        @error('email')
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
                                   placeholder="Masukkan password"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember" style="font-size:0.85rem;">
                                Ingat saya
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" style="font-size:0.82rem;color:#1a237e;text-decoration:none;">
                            Lupa password?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-login btn-primary w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </button>
                </form>
            </div>

            <div class="login-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </div>
        </div>

        <div class="text-center mt-3" style="font-size:0.72rem;color:rgba(255,255,255,0.6);">
            &copy; {{ date('Y') }} Politeknik Negeri Jember
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const errorEl = document.getElementById('login-errors');
            if (errorEl) {
                try {
                    const errors = JSON.parse(errorEl.dataset.errors);
                    const messages = Object.values(errors).flat().join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
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
