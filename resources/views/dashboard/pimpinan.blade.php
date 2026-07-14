@extends('layouts.app')

@section('title', 'Dashboard Pimpinan - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard Executive Summary</h4>
        <p class="text-muted mb-0" style="font-size:0.85rem;">Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>
    <div>
        <span class="badge bg-primary-subtle text-primary" style="font-size:0.8rem;">
            <i class="fas fa-crown me-1"></i>Pimpinan
        </span>
    </div>
</div>

@if(count($alertRed) > 0)
<div class="alert alert-danger d-flex align-items-start mb-4" role="alert">
    <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
    <div>
        <strong>Perhatian!</strong> Beberapa standar mutu berada di bawah target (capaian &lt;70% target):
        <ul class="mb-0 mt-1" style="font-size:0.82rem;">
            @foreach($alertRed as $alert)
            <li>{{ $alert }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3">
                <h6 class="fw-bold mb-3" style="font-size:0.85rem;"><i class="fas fa-bolt me-2 text-warning"></i>Akses Cepat</h6>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-file-export me-1"></i>Laporan</a>
                    <a href="{{ route('laporan.export-all') }}" class="btn btn-sm btn-outline-success"><i class="fas fa-file-excel me-1"></i>Export Semua Data</a>
                    <a href="{{ route('audit.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-clipboard-check me-1"></i>Jadwal Audit</a>
                    <a href="{{ route('tindak-lanjut.index') }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-tasks me-1"></i>Tindak Lanjut</a>
                    <a href="{{ route('aktivitas.index') }}" class="btn btn-sm btn-outline-info"><i class="fas fa-user-clock me-1"></i>Aktivitas User</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Standar Aktif</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">{{ $stats['totalStandar'] }}</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-balance-scale"></i>
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
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Audit Selesai</div>
                        <div class="fw-bold fs-4 text-success">{{ $stats['totalAuditSelesai'] }}</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
                <div style="font-size:0.75rem;">
                    <span class="text-muted">{{ $stats['totalAuditBerjalan'] }} berjalan</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Tindak Lanjut</div>
                        <div class="fw-bold fs-4" style="color:#1a237e;">{{ $stats['totalTLSelesai'] }}/{{ $stats['totalTL'] }}</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
                <div style="font-size:0.75rem;">
                    <span class="text-danger">{{ $stats['totalTLOpen'] }} open</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-1" style="font-size:0.78rem;">Temuan Audit</div>
                        <div class="fw-bold fs-4" style="color:#e53935;">{{ $stats['totalTemuanOpen'] }}</div>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
                <div style="font-size:0.75rem;">
                    <span class="text-muted">Belum tertindaklanjuti</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-spider me-2 text-primary"></i>Capaian vs Target per Standar
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartRadar" height="280"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-line me-2 text-primary"></i>Tren Capaian Mutu Institusi
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartTrend" height="280"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-chart-bar me-2 text-warning"></i>Status Tindak Lanjut
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartTL" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0" style="font-size:0.9rem;">
                    <i class="fas fa-info-circle me-2 text-info"></i>Ringkasan
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:0.85rem;">
                    <tr><td class="text-muted">Total Dokumen Mutu</td><td class="fw-semibold text-end">{{ $stats['totalDokumen'] }}</td></tr>
                    <tr><td class="text-muted">Total Survei</td><td class="fw-semibold text-end">{{ $stats['totalSurvei'] }}</td></tr>
                    <tr><td class="text-muted">Persentase TL Selesai</td><td class="fw-semibold text-end text-success">{{ $stats['totalTL'] > 0 ? round(($stats['totalTLSelesai'] / $stats['totalTL']) * 100, 1) : 0 }}%</td></tr>
                    <tr><td class="text-muted">Audit Berjalan</td><td class="fw-semibold text-end">{{ $stats['totalAuditBerjalan'] }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Radar
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
            responsive: true, maintainAspectRatio: false,
            scales: { r: { beginAtZero: true, max: 100, ticks: { stepSize: 20, font: { size: 10 } } } },
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } }
        }
    });

    // Trend
    new Chart(document.getElementById('chartTrend').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Capaian (%)',
                data: @json($chartCapaian),
                borderColor: '#1a237e', backgroundColor: 'rgba(26,35,126,0.1)',
                fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#1a237e'
            }, {
                label: 'Target (%)',
                data: @json($chartTarget),
                borderColor: '#e53935', borderDash: [5,5], fill: false, tension: 0,
                pointRadius: 4, pointBackgroundColor: '#e53935'
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } },
            scales: { y: { beginAtZero: false, min: 0, max: 100, ticks: { callback: v => v + '%' } } }
        }
    });

    // TL Bar
    const tlData = @json($tlStatus);
    const tlLabels = Object.keys(tlData);
    const tlValues = Object.values(tlData);
    const tlColors = ['#ef4444','#f97316','#eab308','#22c55e','#3b82f6'];
    new Chart(document.getElementById('chartTL').getContext('2d'), {
        type: 'bar',
        data: {
            labels: tlLabels.length ? tlLabels : ['Belum Ada'],
            datasets: [{ data: tlValues.length ? tlValues : [0], backgroundColor: tlColors.slice(0, tlLabels.length || 1), borderRadius: 6 }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
});
</script>
@endpush
