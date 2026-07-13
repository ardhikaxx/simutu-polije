@extends('layouts.app')

@section('title', 'PPEPP - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Siklus PPEPP</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">PPEPP</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-sync-alt fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $sikluses->count() }}</h3>
                <small>Total Siklus</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $sikluses->where('status_siklus', 'Selesai')->count() }}</h3>
                <small>Selesai</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-spinner fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $sikluses->where('status_siklus', 'Berjalan')->count() }}</h3>
                <small>Berjalan</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $sikluses->where('tahap_sekarang', 'evaluasi')->count() }}</h3>
                <small>Evaluasi</small>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Standar Mutu</th>
                        <th>Tahun Akademik</th>
                        <th>Tahap Sekarang</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sikluses as $index => $siklus)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $siklus->standarMutu->nama_standar ?? '-' }}</td>
                        <td>{{ $siklus->tahunAkademik->nama ?? '-' }}</td>
                        <td>
                            @php
                            $tahapBadge = match($siklus->tahap_sekarang) {
                                'penetapan' => 'primary',
                                'pelaksanaan' => 'info',
                                'pengendalian' => 'warning',
                                'evaluasi' => 'success',
                                'peningkatan' => 'danger',
                                default => 'secondary',
                            };
                            @endphp
                            <span class="badge bg-{{ $tahapBadge }}">{{ ucfirst($siklus->tahap_sekarang) }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $siklus->status_siklus === 'Selesai' ? 'success' : 'warning' }}">{{ $siklus->status_siklus }}</span>
                        </td>
                        <td>
                            <a href="{{ route('ppepp.show', $siklus) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('ppepp.pelaksanaan', $siklus) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-cogs"></i></a>
                            <a href="{{ route('ppepp.evaluasi', $siklus) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-chart-bar"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-sync-alt fa-2x mb-2 d-block"></i>Belum ada siklus PPEPP.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() { $('#dataTable').DataTable({ language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' } }); });
</script>
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
