@extends('layouts.app')

@section('title', 'Periode Audit - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Periode Audit</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Periode Audit</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('master-data.periode-audit.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Periode Audit
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
                        <th>Tahun Akademik</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periodeAudits as $index => $periode)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $periode->nama }}</td>
                        <td>{{ $periode->tahunAkademik->nama ?? '-' }}</td>
                        <td>{{ $periode->tanggal_mulai->format('d/m/Y') }}</td>
                        <td>{{ $periode->tanggal_selesai->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $periode->status === 'Aktif' ? 'success' : ($periode->status === 'Selesai' ? 'info' : 'secondary') }}">
                                {{ $periode->status ?? 'Draft' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('master-data.periode-audit.edit', $periode) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('master-data.periode-audit.destroy', $periode) }}" method="POST" class="d-inline delete-form">
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
                            <i class="fas fa-calendar-check fa-2x mb-2 d-block"></i>
                            Belum ada data periode audit.
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
            title: 'Konfirmasi Hapus', text: 'Apakah Anda yakin ingin menghapus periode audit ini?',
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
