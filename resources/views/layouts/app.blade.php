<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIMUTU POLIJE - Sistem Informasi Penjaminan Mutu Politeknik Negeri Jember">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIMUTU POLIJE')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="app-wrapper" class="d-flex">
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="sidebar-brand">
                    <span class="sidebar-brand-icon">
                        <img src="{{ asset('assets/logo-polije.png') }}" alt="Logo Polije" height="36" style="object-fit:contain;">
                    </span>
                    <div class="sidebar-brand-text-group">
                        <span class="sidebar-brand-text">SIMUTU</span>
                        <div class="sidebar-brand-subtitle">Sistem Informasi Penjaminan Mutu</div>
                    </div>
                </a>
                <button id="sidebarClose" class="sidebar-close d-lg-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="sidebar-user px-3 py-3">
                <div class="d-flex align-items-center">
                    <div class="user-avatar me-2">
                        <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:rgba(255,255,255,0.2);color:#fff;font-weight:600;font-size:14px;">
                            {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                        </div>
                    </div>
                    <div class="user-info overflow-hidden">
                        <div class="text-white fw-semibold text-truncate" style="font-size:0.85rem;">{{ auth()->user()->nama }}</div>
                        <div class="text-white-50 text-truncate" style="font-size:0.72rem;">{{ ucfirst(str_replace('_', ' ', auth()->user()->getRoleNames()->first() ?? '')) }}</div>
                    </div>
                </div>
            </div>

            <ul class="sidebar-nav" data-simplebar>
                <li class="nav-item-section px-3 py-2">
                    <small class="text-uppercase fw-bold" style="color:rgba(255,255,255,0.4);font-size:0.65rem;letter-spacing:1px;">Menu Utama</small>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if(auth()->user()->hasRole('super_admin'))
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span>Manajemen Role</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['super_admin', 'admin_spmi']))
                <li class="nav-item-section px-3 py-2 mt-3">
                    <small class="text-uppercase fw-bold" style="color:rgba(255,255,255,0.4);font-size:0.65rem;letter-spacing:1px;">Master Data</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('master-data.jurusan.index') }}" class="nav-link {{ request()->routeIs('master-data.jurusan.*') ? 'active' : '' }}">
                        <i class="fas fa-building-columns"></i>
                        <span>Jurusan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('master-data.prodi.index') }}" class="nav-link {{ request()->routeIs('master-data.prodi.*') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Program Studi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('master-data.unit-kerja.index') }}" class="nav-link {{ request()->routeIs('master-data.unit-kerja.*') ? 'active' : '' }}">
                        <i class="fas fa-sitemap"></i>
                        <span>Unit Kerja</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('master-data.tahun-akademik.index') }}" class="nav-link {{ request()->routeIs('master-data.tahun-akademik.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-days"></i>
                        <span>Tahun Akademik</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('master-data.periode-audit.index') }}" class="nav-link {{ request()->routeIs('master-data.periode-audit.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Periode Audit</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['super_admin', 'admin_spmi', 'kajur', 'kaprodi', 'gpm', 'auditor', 'auditor_ketua', 'dosen', 'tendik', 'pimpinan']))
                <li class="nav-item-section px-3 py-2 mt-3">
                    <small class="text-uppercase fw-bold" style="color:rgba(255,255,255,0.4);font-size:0.65rem;letter-spacing:1px;">Penjaminan Mutu</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('standar-mutu.index') }}" class="nav-link {{ request()->routeIs('standar-mutu.*') ? 'active' : '' }}">
                        <i class="fas fa-balance-scale"></i>
                        <span>Standar Mutu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dokumen-mutu.index') }}" class="nav-link {{ request()->routeIs('dokumen-mutu.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Dokumen Mutu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('template-dokumen.index') }}" class="nav-link {{ request()->routeIs('template-dokumen.*') ? 'active' : '' }}">
                        <i class="fas fa-file-download"></i>
                        <span>Template Dokumen</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ppepp.index') }}" class="nav-link {{ request()->routeIs('ppepp.*') ? 'active' : '' }}">
                        <i class="fas fa-sync-alt"></i>
                        <span>PPEPP</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['super_admin', 'admin_spmi', 'auditor', 'auditor_ketua']))
                <li class="nav-item">
                    <a href="{{ route('audit.index') }}" class="nav-link {{ request()->routeIs('audit.*', 'jadwal-audit.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Audit Mutu</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['super_admin', 'admin_spmi', 'kajur', 'kaprodi', 'gpm', 'auditor', 'auditor_ketua']))
                <li class="nav-item">
                    <a href="{{ route('tindak-lanjut.index') }}" class="nav-link {{ request()->routeIs('tindak-lanjut.*') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i>
                        <span>Tindak Lanjut</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['super_admin', 'admin_spmi', 'kajur', 'kaprodi', 'mahasiswa', 'alumni', 'mitra_industri']))
                <li class="nav-item">
                    <a href="{{ route('survei.index') }}" class="nav-link {{ request()->routeIs('survei.*') ? 'active' : '' }}">
                        <i class="fas fa-poll"></i>
                        <span>Survei</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['super_admin', 'admin_spmi', 'kajur', 'kaprodi', 'gpm', 'auditor', 'auditor_ketua', 'pimpinan']))
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasRole('super_admin'))
                <li class="nav-item-section px-3 py-2 mt-3">
                    <small class="text-uppercase fw-bold" style="color:rgba(255,255,255,0.4);font-size:0.65rem;letter-spacing:1px;">Sistem</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.activity-log.index') }}" class="nav-link {{ request()->routeIs('admin.activity-log.*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                        <span>Activity Log</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('aktivitas.index') }}" class="nav-link {{ request()->routeIs('aktivitas.*') ? 'active' : '' }}">
                        <i class="fas fa-user-clock"></i>
                        <span>Tracking Aktivitas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                @endif
            </ul>

            <div class="sidebar-footer px-3 py-3">
                <div class="text-center" style="font-size:0.68rem;color:rgba(255,255,255,0.35);">
                    &copy; {{ date('Y') }} SIMUTU POLIJE
                </div>
            </div>
        </nav>

        <div id="main-wrapper" class="main-wrapper flex-grow-1">
            <nav class="navbar navbar-expand-lg topbar">
                <div class="container-fluid">
                    <button id="sidebarToggle" class="btn btn-link topbar-btn me-2">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="d-none d-lg-flex flex-grow-1 ms-3">
                    </div>

                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a href="{{ route('notifikasi.index') }}" class="btn btn-link topbar-btn position-relative" title="Notifikasi">
                                <i class="fas fa-bell"></i>
                                @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                                @if($unreadCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge-top" style="font-size:0.6rem;">
                                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                    </span>
                                @else
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none notification-badge-top" style="font-size:0.6rem;">
                                        0
                                    </span>
                                @endif
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center topbar-user" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="avatar-placeholder-sm rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:#1a237e;color:#fff;font-weight:600;font-size:12px;">
                                    {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                                </div>
                                <span class="d-none d-lg-inline text-dark ms-2" style="font-size:0.85rem;">{{ auth()->user()->nama }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li class="dropdown-header">
                                    <div class="fw-semibold">{{ auth()->user()->nama }}</div>
                                    <div class="text-muted small">{{ auth()->user()->email }}</div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        <i class="fas fa-user me-2"></i>Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('password.change') }}">
                                        <i class="fas fa-key me-2"></i>Ganti Password
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="content-wrapper">
                <div class="container-fluid px-4 py-3">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>

            <footer class="main-footer">
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-size:0.78rem;color:#6c757d;">
                            &copy; {{ date('Y') }} SIMUTU POLIJE - Politeknik Negeri Jember
                        </span>
                        <span style="font-size:0.78rem;color:#6c757d;">
                            v1.0.0
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <div id="sidebar-overlay" class="sidebar-overlay d-lg-none"></div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        document.querySelector('#logout-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1a237e',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
