@extends('layouts.app')

@section('title', 'Dashboard Alumni - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Alumni</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem;">Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>
    <div>
        <span class="badge bg-primary-subtle text-primary" style="font-size:0.8rem;">
            <i class="fas fa-user-graduate me-1"></i>Alumni
        </span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-6 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Tracer Study Aktif</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">--</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-poll"></i>
                    </div>
                </div>
                <a href="{{ route('survei.index') }}" class="btn btn-sm btn-outline-primary mt-2" style="font-size:0.8rem;">
                    <i class="fas fa-arrow-right me-1"></i>Isi Survei
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Riwayat Survei</div>
                        <div class="fw-bold fs-4" style="color:#2e7d32;">--</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(46,125,50,0.1);color:#2e7d32;">
                        <i class="fas fa-history"></i>
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
                    <i class="fas fa-chart-bar me-2 text-primary"></i>Riwayat Pengisian Survei
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartAlumni" height="250"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartAlumni').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['2022', '2023', '2024', '2025'],
            datasets: [{
                label: 'Jumlah Responden',
                data: [45, 62, 78, 50],
                backgroundColor: '#1a237e'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endpush
