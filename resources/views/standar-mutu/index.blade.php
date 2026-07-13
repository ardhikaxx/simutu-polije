@extends('layouts.app')

@section('title', 'Standar Mutu - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Standar Mutu</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Standar Mutu</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('standar-mutu.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Standar Mutu
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Cari</label>
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode standar..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Kategori</label>
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriStandars as $ks)
                    <option value="{{ $ks->id }}" {{ request('kategori') == $ks->id ? 'selected' : '' }}>{{ $ks->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach(['Draft', 'Submitted', 'Reviewed', 'Approved', 'Published'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i>Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Nama Standar</th>
                        <th>Kategori</th>
                        <th>Versi</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($standarMutus as $index => $sm)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><code>{{ $sm->kode_standar }}</code></td>
                        <td class="fw-semibold">{{ $sm->nama_standar }}</td>
                        <td>{{ $sm->kategoriStandar->nama ?? '-' }}</td>
                        <td><span class="badge bg-light text-dark">v{{ $sm->versiAktif->nomor_versi ?? '1.0' }}</span></td>
                        <td>
                            @php
                            $badgeClass = match($sm->status) {
                                'Draft' => 'secondary',
                                'Submitted' => 'warning',
                                'Reviewed' => 'info',
                                'Approved' => 'primary',
                                'Published' => 'success',
                                default => 'secondary',
                            };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}">{{ $sm->status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('standar-mutu.show', $sm) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('standar-mutu.edit', $sm) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('standar-mutu.destroy', $sm) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-balance-scale fa-2x mb-2 d-block"></i>
                            Belum ada data standar mutu.
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
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Hapus', text: 'Apakah Anda yakin ingin menghapus standar mutu ini?',
            icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal'
        }).then((result) => { if (result.isConfirmed) this.submit(); });
    });
});
</script>
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
