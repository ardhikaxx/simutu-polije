@extends('layouts.app')

@section('title', 'Dashboard Kajur - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Ketua Jurusan</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem;">Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>
    <div>
        <span class="badge bg-primary-subtle text-primary" style="font-size:0.8rem;">
            <i class="fas fa-building-columns me-1"></i>Ketua Jurusan
        </span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Prodi di Bawah Jurusan</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Dokumen Menunggu Review</div>
                        <div class="fw-bold fs-4" style="color:#e53935;">--</div>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-file-circle-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Tindak Lanjut Perlu Tindakan</div>
                        <div class="fw-bold fs-4" style="color:#f57c00;">--</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
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
                <div class="text-center">
                    <div class="fw-bold fs-4" style="color:#2e7d32;">--</div>
                    <div class="text-muted" style="font-size:0.78rem;">Hijau</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-center">
                    <div class="fw-bold fs-4" style="color:#f9a825;">--</div>
                    <div class="text-muted" style="font-size:0.78rem;">Kuning</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-center">
                    <div class="fw-bold fs-4" style="color:#e53935;">--</div>
                    <div class="text-muted" style="font-size:0.78rem;">Merah</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-center">
                    <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    <div class="text-muted" style="font-size:0.78rem;">Total Indikator</div>
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
                <canvas id="chartKajurCapaian" height="280"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-pie me-2 text-primary"></i>Status Dokumen Jurusan
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartKajurDokumen" height="280"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxCapaian = document.getElementById('chartKajurCapaian').getContext('2d');
    new Chart(ctxCapaian, {
        type: 'bar',
        data: {
            labels: ['TI', 'TK', 'AK', 'MI'],
            datasets: [{
                label: 'Capaian (%)',
                data: [82, 75, 88, 70],
                backgroundColor: '#1a237e'
            }, {
                label: 'Target (%)',
                data: [85, 85, 90, 85],
                backgroundColor: 'rgba(229,57,53,0.2)',
                borderColor: '#e53935',
                borderWidth: 1
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

    const ctxDokumen = document.getElementById('chartKajurDokumen').getContext('2d');
    new Chart(ctxDokumen, {
        type: 'doughnut',
        data: {
            labels: ['Published', 'Draft', 'Menunggu Review', 'Expired'],
            datasets: [{
                data: [20, 5, 3, 2],
                backgroundColor: ['#2e7d32', '#5c6bc0', '#f9a825', '#e53935']
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
