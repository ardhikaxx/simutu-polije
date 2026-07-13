@extends('layouts.app')

@section('title', 'Manajemen Jurusan - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Jurusan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Jurusan</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('master-data.jurusan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Jurusan
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Nama Jurusan</th>
                        <th>Jumlah Prodi</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurusans as $index => $jurusan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><code>{{ $jurusan->kode_jurusan }}</code></td>
                        <td class="fw-semibold">{{ $jurusan->nama_jurusan }}</td>
                        <td>
                            <span class="badge bg-info rounded-pill">{{ $jurusan->program_studi_count }} Prodi</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $jurusan->status === 'Aktif' ? 'success' : 'secondary' }}">
                                {{ $jurusan->status ?? 'Aktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('master-data.jurusan.edit', $jurusan) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('master-data.jurusan.destroy', $jurusan) }}" method="POST" class="d-inline delete-form">
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
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-building-columns fa-2x mb-2 d-block"></i>
                            Belum ada data jurusan.
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
    $('#dataTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' }
    });

    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus jurusan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) this.submit();
        });
    });
});
</script>
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
