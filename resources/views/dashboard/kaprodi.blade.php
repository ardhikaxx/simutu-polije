@extends('layouts.app')

@section('title', 'Dashboard Kaprodi - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Kaprodi</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem;">Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>
    <div>
        <span class="badge bg-primary-subtle text-primary" style="font-size:0.8rem;">
            <i class="fas fa-user-tie me-1"></i>Ketua Program Studi
        </span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Progress PPEPP</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--%</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                </div>
                <div class="progress mt-2" style="height:4px;">
                    <div class="progress-bar" style="width:0%;background:#1a237e;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Dokumen Perlu Dilengkapi</div>
                        <div class="fw-bold fs-4" style="color:#f57c00;">--</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Eviden Terunggah</div>
                        <div class="fw-bold fs-4" style="color:#2e7d32;">--</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(46,125,50,0.1);color:#2e7d32;">
                        <i class="fas fa-paperclip"></i>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Deadline Terdekat</div>
                        <div class="fw-bold fs-6" style="color:#e53935;">--</div>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-center">
                    <div class="fw-bold fs-4" style="color:#2e7d32;">--</div>
                    <div class="text-muted" style="font-size:0.78rem;">Capaian Hijau</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-center">
                    <div class="fw-bold fs-4" style="color:#f9a825;">--</div>
                    <div class="text-muted" style="font-size:0.78rem;">Capaian Kuning</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-center">
                    <div class="fw-bold fs-4" style="color:#e53935;">--</div>
                    <div class="text-muted" style="font-size:0.78rem;">Capaian Merah</div>
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
                    <i class="fas fa-chart-line me-2 text-primary"></i>Progress PPEPP per Tahap
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartKaprodiPpepp" height="280"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-pie me-2 text-primary"></i>Status Temuan Audit
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartKaprodiTemuan" height="280"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxPpepp = document.getElementById('chartKaprodiPpepp').getContext('2d');
    new Chart(ctxPpepp, {
        type: 'line',
        data: {
            labels: ['Std 1', 'Std 2', 'Std 3', 'Std 4', 'Std 5', 'Std 6', 'Std 7', 'Std 8'],
            datasets: [{
                label: 'Capaian (%)',
                data: [80, 75, 85, 70, 90, 82, 78, 88],
                borderColor: '#1a237e',
                backgroundColor: 'rgba(26,35,126,0.1)',
                fill: true,
                tension: 0.4
            }, {
                label: 'Target (%)',
                data: [85, 85, 85, 85, 90, 85, 85, 90],
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

    const ctxTemuan = document.getElementById('chartKaprodiTemuan').getContext('2d');
    new Chart(ctxTemuan, {
        type: 'doughnut',
        data: {
            labels: ['Open', 'On Progress', 'Verified', 'Closed'],
            datasets: [{
                data: [2, 3, 4, 8],
                backgroundColor: ['#e53935', '#f9a825', '#5c6bc0', '#2e7d32']
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
