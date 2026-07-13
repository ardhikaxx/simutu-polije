@extends('layouts.app')

@section('title', 'Riwayat Versi - ' . $standar->nama_standar)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Riwayat Versi: {{ $standar->nama_standar }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('standar-mutu.index') }}" class="text-decoration-none">Standar Mutu</a></li>
                <li class="breadcrumb-item"><a href="{{ route('standar-mutu.show', $standar) }}" class="text-decoration-none">Detail</a></li>
                <li class="breadcrumb-item active">Versi</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('standar-mutu.show', $standar) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Nomor Versi</th>
                        <th>Alasan Revisi</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($versions as $index => $version)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-primary">v{{ $version->nomor_versi }}</span></td>
                        <td>{{ $version->alasan_revisi ?? '-' }}</td>
                        <td>{{ $version->dibuatOleh->nama ?? '-' }}</td>
                        <td>{{ $version->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada riwayat versi.
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
$(document).ready(function() {
    $('#dataTable').DataTable({ language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' } });
});
</script>
@endpush
