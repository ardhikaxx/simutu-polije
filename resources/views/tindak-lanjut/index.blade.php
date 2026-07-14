@extends('layouts.app')

@section('title', 'Tindak Lanjut - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Tindak Lanjut</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Tindak Lanjut</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-12 col-md-3">
                <label class="form-label small fw-semibold">Program Studi</label>
                <select name="program_studi_id" class="form-select form-select-sm">
                    <option value="">Semua Prodi</option>
                    @foreach($prodis as $prodi)
                    <option value="{{ $prodi->id }}" {{ request('program_studi_id') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold">Target Dari</label>
                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold">Target Sampai</label>
                <input type="date" name="tanggal_selesai" class="form-control form-control-sm" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach(['Open', 'On Progress', 'Need Revision', 'Verified', 'Closed'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fas fa-filter me-1"></i>Filter</button>
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
                        <th>Temuan</th>
                        <th>Kategori</th>
                        <th>Risiko</th>
                        <th>Penanggung Jawab</th>
                        <th>Target Selesai</th>
                        <th>Status</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tindakLanjuts as $index => $tl)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold small">{{ Str::limit($tl->temuanAudit->deskripsi_temuan ?? '-', 50) }}</td>
                        <td><span class="badge bg-info">{{ $tl->temuanAudit->kategori_temuan ?? '-' }}</span></td>
                        <td>
                            @php $rb = match($tl->temuanAudit->tingkat_risiko ?? '') { 'Tinggi'=>'danger', 'Sedang'=>'warning', 'Rendah'=>'info', default=>'secondary' }; @endphp
                            <span class="badge bg-{{ $rb }}">{{ $tl->temuanAudit->tingkat_risiko ?? '-' }}</span>
                        </td>
                        <td>{{ $tl->penanggungJawab->nama ?? '-' }}</td>
                        <td>{{ $tl->target_selesai ? $tl->target_selesai->format('d/m/Y') : '-' }}</td>
                        <td>
                            @php $sb = match($tl->status) { 'Closed'=>'success', 'Verified'=>'success', 'On Progress'=>'warning', 'Need Revision'=>'danger', default=>'secondary' }; @endphp
                            <span class="badge bg-{{ $sb }}">{{ $tl->status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('tindak-lanjut.show', $tl) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-tasks fa-2x mb-2 d-block"></i>Belum ada tindak lanjut.
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
