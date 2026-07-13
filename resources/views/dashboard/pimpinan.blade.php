@extends('layouts.app')

@section('title', 'Dashboard Pimpinan - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Pimpinan</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem;">Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>
    <div>
        <span class="badge bg-primary-subtle text-primary" style="font-size:0.8rem;">
            <i class="fas fa-crown me-1"></i>Pimpinan
        </span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Capaian Mutu Institusi</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--%</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-chart-line"></i>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Tren Multi-Tahun</div>
                        <div class="fw-bold fs-4 text-success">Naik</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(46,125,50,0.1);color:#2e7d32;">
                        <i class="fas fa-arrow-trend-up"></i>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Penyelesaian Audit</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--%</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-clipboard-check"></i>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Tindak Lanjut Selesai</div>
                        <div class="fw-bold fs-4" style="color:#2e7d32;">--%</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(46,125,50,0.1);color:#2e7d32;">
                        <i class="fas fa-check-double"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-line me-2 text-primary"></i>Tren Capaian Mutu Institusi
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartPimpinan" height="280"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartPimpinan').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2022/1', '2022/2', '2023/1', '2023/2', '2024/1', '2024/2', '2025/1'],
            datasets: [{
                label: 'Capaian Institusi (%)',
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
                tension: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            },
            scales: { y: { beginAtZero: false, min: 50, max: 100 } }
        }
    });
});
</script>
@endpush
