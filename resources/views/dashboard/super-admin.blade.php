@extends('layouts.app')

@section('title', 'Dashboard Super Admin - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Super Admin</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem;">Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>
    <div>
        <span class="badge bg-primary-subtle text-primary" style="font-size:0.8rem;">
            <i class="fas fa-crown me-1"></i>Super Administrator
        </span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Total User</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div style="font-size:0.75rem;">
                    <span class="text-success"><i class="fas fa-arrow-up"></i> --%</span>
                    <span class="text-muted ms-1">dari bulan lalu</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Standar Mutu Aktif</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                </div>
                <div style="font-size:0.75rem;">
                    <span class="text-muted">Published</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Dokumen Mutu</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
                <div style="font-size:0.75rem;">
                    <span class="text-muted">Total dokumen</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Audit Berjalan</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
                <div style="font-size:0.75rem;">
                    <span class="text-muted">Periode aktif</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Tindak Lanjut Open</div>
                        <div class="fw-bold fs-4" style="color:#e53935;">--</div>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Survei Aktif</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-poll"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Prodi</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Kesehatan Sistem</div>
                        <div class="fw-bold fs-4 text-success">OK</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-line me-2 text-primary"></i>Capaian Mutu Institusi
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartCapaianMutu" height="280"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-pie me-2 text-primary"></i>Status PPEPP
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartPpepp" height="280"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxCapaian = document.getElementById('chartCapaianMutu').getContext('2d');
    new Chart(ctxCapaian, {
        type: 'line',
        data: {
            labels: ['2022/1', '2022/2', '2023/1', '2023/2', '2024/1', '2024/2', '2025/1'],
            datasets: [{
                label: 'Capaian Indikator (%)',
                data: [72, 75, 78, 80, 82, 85, 87],
                borderColor: '#1a237e',
                backgroundColor: 'rgba(26,35,126,0.1)',
                fill: true,
                tension: 0.4
            }, {
                label: 'Target (%)',
                data: [80, 80, 85, 85, 88, 88, 90],
                borderColor: '#e53935',
                borderDash: [5, 5],
                fill: false,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            },
            scales: {
                y: { beginAtZero: false, min: 50, max: 100 }
            }
        }
    });

    const ctxPpepp = document.getElementById('chartPpepp').getContext('2d');
    new Chart(ctxPpepp, {
        type: 'doughnut',
        data: {
            labels: ['Penetapan', 'Pelaksanaan', 'Evaluasi', 'Pengendalian', 'Peningkatan'],
            datasets: [{
                data: [10, 25, 15, 8, 5],
                backgroundColor: ['#1a237e', '#3949ab', '#5c6bc0', '#7986cb', '#9fa8da']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
        }
    });
});
</script>
@endpush
