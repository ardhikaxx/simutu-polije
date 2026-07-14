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
                        <div class="fw-bold fs-4" style="color:#1a237e;">{{ $stats['totalUser'] }}</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-users"></i>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Standar Mutu Aktif</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">{{ $stats['standarMutuAktif'] }}</div>
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
                        <div class="fw-bold fs-4" style="color:#1a237e;">{{ $stats['dokumenMutu'] }}</div>
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
                        <div class="fw-bold fs-4" style="color:#1a237e;">{{ $stats['auditBerjalan'] }}</div>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
                <div style="font-size:0.75rem;">
                    <span class="text-muted">Draft / Terjadwal / Berlangsung</span>
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
                        <div class="fw-bold fs-4" style="color:#e53935;">{{ $stats['tindakLanjutOpen'] }}</div>
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
                        <div class="fw-bold fs-4" style="color:#1a237e;">{{ $stats['surveiAktif'] }}</div>
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
                        <div class="fw-bold fs-4" style="color:#1a237e;">{{ $stats['totalProdi'] }}</div>
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

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-line me-2 text-primary"></i>Tren Capaian Mutu Institusi
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

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-spider me-2 text-info"></i>Capaian vs Target per Standar (Tahun Akademik Aktif)
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartRadar" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-bar me-2 text-success"></i>Distribusi Status Tindak Lanjut
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartTindakLanjut" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Line Chart - Tren Capaian
    const ctxCapaian = document.getElementById('chartCapaianMutu').getContext('2d');
    new Chart(ctxCapaian, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Capaian Indikator (%)',
                data: @json($chartCapaian),
                borderColor: '#1a237e',
                backgroundColor: 'rgba(26,35,126,0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#1a237e'
            }, {
                label: 'Target (%)',
                data: @json($chartTarget),
                borderColor: '#e53935',
                borderDash: [5, 5],
                fill: false,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#e53935'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            },
            scales: {
                y: { beginAtZero: false, min: 0, max: 100, ticks: { callback: v => v + '%' } }
            }
        }
    });

    // 2. Doughnut Chart - PPEPP Status
    const ppeppLabels = @json(array_keys($ppeppStatus));
    const ppeppValues = @json(array_values($ppeppStatus));
    const ppeppColors = ['#1a237e', '#3949ab', '#5c6bc0', '#7986cb', '#9fa8da'];
    new Chart(document.getElementById('chartPpepp').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ppeppLabels.length ? ppeppLabels : ['Belum Ada Data'],
            datasets: [{
                data: ppeppValues.length ? ppeppValues : [1],
                backgroundColor: ppeppLabels.length ? ppeppColors.slice(0, ppeppLabels.length) : ['#e0e0e0']
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

    // 3. Radar Chart - Capaian vs Target per Standar
    new Chart(document.getElementById('chartRadar').getContext('2d'), {
        type: 'radar',
        data: {
            labels: @json($radarLabels),
            datasets: [{
                label: 'Capaian (%)',
                data: @json($radarData),
                borderColor: '#1a237e',
                backgroundColor: 'rgba(26,35,126,0.15)',
                pointBackgroundColor: '#1a237e'
            }, {
                label: 'Target (%)',
                data: @json($radarTarget),
                borderColor: '#e53935',
                backgroundColor: 'rgba(229,57,53,0.05)',
                borderDash: [4, 4],
                pointBackgroundColor: '#e53935'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: { beginAtZero: true, max: 100, ticks: { stepSize: 20, font: { size: 10 } } }
            },
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
        }
    });

    // 4. Bar Chart - Tindak Lanjut
    const tlCtx = document.getElementById('chartTindakLanjut').getContext('2d');
    fetch('{{ route("dashboard.tl-stats") }}')
        .then(r => r.json())
        .then(data => {
            new Chart(tlCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        label: 'Jumlah',
                        data: Object.values(data),
                        backgroundColor: ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6'],
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        })
        .catch(() => {
            new Chart(tlCtx, {
                type: 'bar',
                data: {
                    labels: ['Open', 'On Progress', 'Need Revision', 'Verified', 'Closed'],
                    datasets: [{ label: 'Jumlah', data: [0,0,0,0,0], backgroundColor: '#e0e0e0', borderRadius: 6 }]
                },
                options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', plugins: { legend: { display: false } } }
            });
        });
});
</script>
@endpush
