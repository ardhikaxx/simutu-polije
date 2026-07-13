@extends('layouts.app')

@section('title', 'Tahun Akademik - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Tahun Akademik</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Tahun Akademik</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('master-data.tahun-akademik.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Tahun Akademik
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Semester</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tahunAkademiks as $index => $ta)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $ta->nama }}</td>
                        <td><span class="badge bg-info">{{ $ta->semester }}</span></td>
                        <td>{{ $ta->tanggal_mulai->format('d/m/Y') }}</td>
                        <td>{{ $ta->tanggal_selesai->format('d/m/Y') }}</td>
                        <td>
                            @if($ta->is_active)
                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            @if(!$ta->is_active)
                            <form action="{{ route('master-data.tahun-akademik.activate', $ta) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" title="Aktifkan">
                                    <i class="fas fa-check"></i> Aktifkan
                                </button>
                            </form>
                            @else
                            <form action="{{ route('master-data.tahun-akademik.deactivate', $ta) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning" title="Nonaktifkan">
                                    <i class="fas fa-times"></i> Nonaktifkan
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('master-data.tahun-akademik.edit', $ta) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('master-data.tahun-akademik.destroy', $ta) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-calendar-days fa-2x mb-2 d-block"></i>
                            Belum ada data tahun akademik.
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
            title: 'Konfirmasi Hapus', text: 'Apakah Anda yakin ingin menghapus tahun akademik ini?',
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
