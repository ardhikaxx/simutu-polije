@extends('layouts.app')

@section('title', 'Dashboard Admin SPMI - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Admin SPMI</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem;">Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>
    <div>
        <span class="badge bg-primary-subtle text-primary" style="font-size:0.8rem;">
            <i class="fas fa-user-shield me-1"></i>Admin SPMI
        </span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Dokumen Menunggu Approval</div>
                        <div class="fw-bold fs-4" style="color:#e53935;">--</div>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-file-circle-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Prodi - PPEPP Berjalan</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Jadwal Audit Mendatang</div>
                        <div class="fw-bold fs-4" style="color:#f57c00;">--</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Tindak Lanjut Pending</div>
                        <div class="fw-bold fs-4" style="color:#e53935;">--</div>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-tasks"></i>
                    </div>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Capaian Hijau</div>
                        <div class="fw-bold fs-4" style="color:#2e7d32;">--</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(46,125,50,0.1);color:#2e7d32;">
                        <i class="fas fa-check-circle"></i>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Capaian Kuning</div>
                        <div class="fw-bold fs-4" style="color:#f9a825;">--</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(249,168,37,0.1);color:#f9a825;">
                        <i class="fas fa-exclamation-triangle"></i>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Capaian Merah</div>
                        <div class="fw-bold fs-4" style="color:#e53935;">--</div>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-times-circle"></i>
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
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-bar me-2 text-primary"></i>Capaian Indikator per Prodi
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartCapaianProdi" height="280"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-doughnut me-2 text-primary"></i>Status Temuan Audit
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartTemuan" height="280"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxProdi = document.getElementById('chartCapaianProdi').getContext('2d');
    new Chart(ctxProdi, {
        type: 'bar',
        data: {
            labels: ['TI', 'TK', 'AK', 'MI', 'AB', 'BD'],
            datasets: [{
                label: 'Hijau',
                data: [12, 10, 14, 8, 11, 9],
                backgroundColor: '#2e7d32'
            }, {
                label: 'Kuning',
                data: [3, 5, 2, 4, 3, 2],
                backgroundColor: '#f9a825'
            }, {
                label: 'Merah',
                data: [1, 2, 1, 3, 1, 2],
                backgroundColor: '#e53935'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            },
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            }
        }
    });

    const ctxTemuan = document.getElementById('chartTemuan').getContext('2d');
    new Chart(ctxTemuan, {
        type: 'doughnut',
        data: {
            labels: ['Observasi', 'Minor', 'Mayor'],
            datasets: [{
                data: [15, 8, 3],
                backgroundColor: ['#5c6bc0', '#f9a825', '#e53935']
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
