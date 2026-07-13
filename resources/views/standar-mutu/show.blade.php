@extends('layouts.app')

@section('title', $standar->nama_standar . ' - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">{{ $standar->nama_standar }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('standar-mutu.index') }}" class="text-decoration-none">Standar Mutu</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        @php
        $badgeClass = match($standar->status) {
            'Draft' => 'secondary',
            'Submitted' => 'warning',
            'Reviewed' => 'info',
            'Approved' => 'primary',
            'Published' => 'success',
            default => 'secondary',
        };
        @endphp
        <span class="badge bg-{{ $badgeClass }} fs-6">{{ $standar->status }}</span>
        <a href="{{ route('standar-mutu.edit', $standar) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <a href="{{ route('standar-mutu.versions', $standar) }}" class="btn btn-outline-info">
            <i class="fas fa-history me-1"></i>Versi
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">Informasi Standar Mutu</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:200px">Kode Standar</td>
                        <td class="fw-semibold"><code>{{ $standar->kode_standar }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kategori</td>
                        <td>{{ $standar->kategoriStandar->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Deskripsi</td>
                        <td>{{ $standar->deskripsi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dasar Hukum</td>
                        <td>{{ $standar->dasar_hukum ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Versi Aktif</td>
                        <td><span class="badge bg-light text-dark">v{{ $standar->versiAktif->nomor_versi ?? '1.0' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dibuat Oleh</td>
                        <td>{{ $standar->dibuatOleh->nama ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Indikator Mutu</h6>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addIndikatorModal">
                    <i class="fas fa-plus me-1"></i>Tambah
                </button>
            </div>
            <div class="card-body">
                @if($standar->indikatorMutu->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Indikator</th>
                                <th>Satuan</th>
                                <th>Sumber Data</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($standar->indikatorMutu as $idx => $ind)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td class="fw-semibold">{{ $ind->nama_indikator }}</td>
                                <td>{{ $ind->satuan }}</td>
                                <td>{{ $ind->sumber_data ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary edit-indikator"
                                        data-id="{{ $ind->id }}"
                                        data-nama="{{ $ind->nama_indikator }}"
                                        data-definisi="{{ $ind->definisi_operasional }}"
                                        data-satuan="{{ $ind->satuan }}"
                                        data-formula="{{ $ind->formula_perhitungan }}"
                                        data-sumber="{{ $ind->sumber_data }}"
                                        data-frekuensi="{{ $ind->frekuensi_pengukuran }}"
                                        data-penanggung="{{ $ind->penanggung_jawab_role }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('standar-mutu.indikator.destroy', [$standar, $ind]) }}" method="POST" class="d-inline delete-indikator-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-chart-line fa-2x mb-2 d-block"></i>
                    Belum ada indikator mutu.
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">Workflow</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($standar->status === 'Draft')
                    <form action="{{ route('standar-mutu.submit', $standar) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100"><i class="fas fa-paper-plane me-1"></i>Submit untuk Review</button>
                    </form>
                    @endif

                    @if($standar->status === 'Submitted')
                    <form action="{{ route('standar-mutu.review', $standar) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-info w-100"><i class="fas fa-search me-1"></i>Review</button>
                    </form>
                    @endif

                    @if($standar->status === 'Reviewed')
                    <form action="{{ route('standar-mutu.approve', $standar) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-check me-1"></i>Setujui</button>
                    </form>
                    @endif

                    @if($standar->status === 'Approved')
                    <form action="{{ route('standar-mutu.publish', $standar) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Publikasi akan memulai siklus PPEPP. Lanjutkan?')">
                            <i class="fas fa-globe me-1"></i>Publish & Mulai PPEPP
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">Unit Terdampak</h6>
            </div>
            <div class="card-body">
                @if(is_array($standar->unit_terdampak) && count($standar->unit_terdampak) > 0)
                <ul class="list-unstyled mb-0">
                    @foreach($standar->unit_terdampak as $unit)
                    <li class="py-1 border-bottom small">{{ $unit }}</li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted small mb-0">Belum ada unit terdampak.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addIndikatorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('standar-mutu.indikator.store', $standar) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Indikator Mutu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Indikator <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_indikator" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="satuan" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Definisi Operasional</label>
                            <textarea class="form-control" name="definisi_operasional" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Formula Perhitungan</label>
                            <input type="text" class="form-control" name="formula_perhitungan">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sumber Data</label>
                            <input type="text" class="form-control" name="sumber_data">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Frekuensi Pengukuran</label>
                            <input type="text" class="form-control" name="frekuensi_pengukuran">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penanggung Jawab</label>
                            <input type="text" class="form-control" name="penanggung_jawab_role">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('.delete-indikator-form').on('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Hapus Indikator?', text: 'Indikator ini akan dihapus permanen.',
        icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545',
        confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal'
    }).then((r) => { if (r.isConfirmed) this.submit(); });
});
</script>
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
