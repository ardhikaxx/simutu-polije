@extends('layouts.app')

@section('title', 'Dashboard Auditor - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Auditor</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem;">Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>
    <div>
        @if(auth()->user()->hasRole('auditor_ketua'))
            <span class="badge bg-warning-subtle text-warning" style="font-size:0.8rem;">
                <i class="fas fa-star me-1"></i>Auditor Ketua
            </span>
        @else
            <span class="badge bg-primary-subtle text-primary" style="font-size:0.8rem;">
                <i class="fas fa-clipboard-check me-1"></i>Auditor
            </span>
        @endif
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Tugas Audit Mendatang</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Checklist Belum Selesai</div>
                        <div class="fw-bold fs-4" style="color:#f57c00;">--</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-clipboard-list"></i>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Hasil Audit Dikerjakan</div>
                        <div class="fw-bold fs-4" style="color:#2e7d32;">--</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(46,125,50,0.1);color:#2e7d32;">
                        <i class="fas fa-check-double"></i>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Temuan Diajukan</div>
                        <div class="fw-bold fs-4" style="color:#e53935;">--</div>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
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
                    <i class="fas fa-chart-bar me-2 text-primary"></i>Skor Audit per Unit
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartAuditorSkor" height="280"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-pie me-2 text-primary"></i>Kategori Temuan
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartAuditorTemuan" height="280"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxSkor = document.getElementById('chartAuditorSkor').getContext('2d');
    new Chart(ctxSkor, {
        type: 'bar',
        data: {
            labels: ['TI', 'TK', 'AK', 'MI'],
            datasets: [{
                label: 'Skor Audit',
                data: [82, 75, 88, 70],
                backgroundColor: ['#1a237e', '#283593', '#3949ab', '#5c6bc0']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: { y: { beginAtZero: false, min: 50, max: 100 } }
        }
    });

    const ctxTemuan = document.getElementById('chartAuditorTemuan').getContext('2d');
    new Chart(ctxTemuan, {
        type: 'doughnut',
        data: {
            labels: ['Observasi', 'Minor', 'Mayor'],
            datasets: [{
                data: [8, 4, 2],
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
