@extends('layouts.app')

@section('title', 'Hasil Audit - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Hasil Audit</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Hasil Audit</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Program Studi</th>
                        <th>Periode</th>
                        <th>Total Skor</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasilAudits as $index => $hasil)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $hasil->jadwalAudit->programStudi->nama_prodi ?? '-' }}</td>
                        <td>{{ $hasil->jadwalAudit->periodeAudit->nama ?? '-' }}</td>
                        <td>
                            @if($hasil->total_skor)
                            <span class="fw-bold {{ $hasil->total_skor >= 80 ? 'text-success' : ($hasil->total_skor >= 60 ? 'text-warning' : 'text-danger') }}">
                                {{ number_format($hasil->total_skor, 1) }}
                            </span>
                            @else -
                            @endif
                        </td>
                        <td>
                            @php $sb = match($hasil->status) { 'Draft'=>'secondary', 'Approved'=>'success', 'Submitted'=>'info', default=>'warning' }; @endphp
                            <span class="badge bg-{{ $sb }}">{{ $hasil->status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('audit.hasil.show', $hasil) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i>Belum ada hasil audit.
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
