@extends('layouts.app')

@section('title', 'Survei - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Survei</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Survei</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->hasAnyRole(['super_admin', 'admin_spmi']))
    <a href="{{ route('survei.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Buat Survei
    </a>
    @endif
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Tahun Akademik</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surveis as $index => $survei)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $survei->judul }}</td>
                        <td><span class="badge bg-info">{{ $survei->jenisSurvei->nama ?? '-' }}</span></td>
                        <td>{{ $survei->tahunAkademik->nama ?? '-' }}</td>
                        <td>
                            <small>{{ $survei->tanggal_mulai->format('d/m') }} - {{ $survei->tanggal_selesai->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            @php $sb = match($survei->status) { 'Aktif'=>'success', 'Selesai'=>'primary', default=>'secondary' }; @endphp
                            <span class="badge bg-{{ $sb }}">{{ $survei->status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('survei.fill', $survei) }}" class="btn btn-sm btn-outline-success" title="Isi Survei"><i class="fas fa-pen"></i></a>
                            <a href="{{ route('survei.hasil', $survei) }}" class="btn btn-sm btn-outline-info" title="Hasil"><i class="fas fa-chart-bar"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-poll fa-2x mb-2 d-block"></i>Belum ada survei.
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
