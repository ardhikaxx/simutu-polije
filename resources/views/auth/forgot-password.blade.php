<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIMUTU POLIJE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1a237e 0%, #283593 50%, #3949ab 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .card-forgot { max-width: 440px; width: 100%; border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .card-header-custom { background: #fff; border-radius: 16px 16px 0 0; padding: 2rem 2rem 1rem; text-align: center; border-bottom: 3px solid #1a237e; }
        .card-body-custom { background: #fff; border-radius: 0 0 16px 16px; padding: 1.5rem 2rem 2rem; }
        .logo-text { font-size: 1.5rem; font-weight: 700; color: #1a237e; }
        .btn-primary { background: #1a237e; border: none; }
        .btn-primary:hover { background: #283593; }
    </style>
</head>
<body>
    <div class="card card-forgot">
        <div class="card-header-custom">
            <img src="{{ asset('assets/logo-polije.png') }}" alt="Logo Polije" style="height:56px;object-fit:contain;" class="mb-2">
            <div class="logo-text">SIMUTU POLIJE</div>
            <small class="text-muted">Sistem Informasi Penjaminan Mutu</small>
        </div>
        <div class="card-body-custom">
            <h5 class="text-center mb-2">Lupa Password?</h5>
            <p class="text-center text-muted mb-4" style="font-size:0.9rem;">
                Masukkan alamat email Anda yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang password.
            </p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="contoh: nama@polije.ac.id" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Tautan Reset
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" style="color:#1a237e;text-decoration:none;font-size:0.9rem;">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Halaman Login
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
