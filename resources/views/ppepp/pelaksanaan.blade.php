@extends('layouts.app')

@section('title', 'Pelaksanaan PPEPP - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Pelaksanaan: {{ $siklus->standarMutu->nama_standar ?? '' }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ppepp.index') }}" class="text-decoration-none">PPEPP</a></li>
                <li class="breadcrumb-item active">Pelaksanaan</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('ppepp.show', $siklus) }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Unit / Prodi</th>
                        <th>Deskripsi Implementasi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Eviden</th>
                        <th width="250">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siklus->ppeppPelaksanaan as $index => $pk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $pk->programStudi->nama_prodi ?? $pk->unitKerja->nama_unit ?? '-' }}</td>
                        <td>{{ $pk->deskripsi_implementasi ?? '-' }}</td>
                        <td>{{ $pk->tanggal_pelaksanaan ? $pk->tanggal_pelaksanaan->format('d/m/Y') : '-' }}</td>
                        <td>
                            @php $sb = match($pk->status) { 'Selesai'=>'success', 'Berjalan'=>'warning', default=>'secondary' }; @endphp
                            <span class="badge bg-{{ $sb }}">{{ $pk->status }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $pk->eviden->count() }} File</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <form action="{{ route('ppepp.pelaksanaan.update', $pk) }}" method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                        <option value="Belum" {{ $pk->status === 'Belum' ? 'selected' : '' }}>Belum</option>
                                        <option value="Berjalan" {{ $pk->status === 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                                        <option value="Selesai" {{ $pk->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                            </div>
                            <button class="btn btn-sm btn-outline-success ms-1" data-bs-toggle="modal" data-bs-target="#evidenModal{{ $pk->id }}">
                                <i class="fas fa-upload"></i> Eviden
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data pelaksanaan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($siklus->ppeppPelaksanaan as $pk)
<div class="modal fade" id="evidenModal{{ $pk->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('ppepp.eviden.upload', $pk) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Upload Eviden</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
