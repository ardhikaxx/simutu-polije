@extends('layouts.app')

@section('title', 'Jadwal Audit - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Jadwal Audit</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Jadwal Audit</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->hasAnyRole(['super_admin', 'admin_spmi']))
    <a href="{{ route('jadwal-audit.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Buat Jadwal
    </a>
    @endif
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-12 col-md-4">
                <label class="form-label small fw-semibold">Periode Audit</label>
                <select name="periode" class="form-select">
                    <option value="">Semua Periode</option>
                    @foreach($periodeAudits as $pa)
                    <option value="{{ $pa->id }}" {{ request('periode') == $pa->id ? 'selected' : '' }}>{{ $pa->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach(['Draft', 'Terjadwal', 'Berlangsung', 'Selesai'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
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
                        <th>Program Studi</th>
                        <th>Periode</th>
                        <th>Tanggal Audit</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalAudits as $index => $jadwal)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $jadwal->programStudi->nama_prodi ?? '-' }}</td>
                        <td>{{ $jadwal->periodeAudit->nama ?? '-' }}</td>
                        <td>{{ $jadwal->tanggal_audit->format('d/m/Y') }}</td>
                        <td><span class="badge bg-info">{{ $jadwal->jenis_audit }}</span></td>
                        <td>
                            @php $sb = match($jadwal->status) { 'Terjadwal'=>'primary', 'Berlangsung'=>'warning', 'Selesai'=>'success', 'Draft'=>'info', default=>'secondary' }; @endphp
                            <span class="badge bg-{{ $sb }}">{{ $jadwal->status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('jadwal-audit.show', $jadwal) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('jadwal-audit.destroy', $jadwal) }}" method="POST" class="d-inline delete-form">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-clipboard-check fa-2x mb-2 d-block"></i>Belum ada jadwal audit.
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
$('.delete-form').on('submit', function(e) { e.preventDefault(); Swal.fire({ title: 'Hapus Jadwal?', text: 'Tindakan ini tidak dapat dibatalkan.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal' }).then((r) => { if (r.isConfirmed) this.submit(); }); });
</script>
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
