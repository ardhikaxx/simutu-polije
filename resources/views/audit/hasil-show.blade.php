@extends('layouts.app')

@section('title', 'Detail Hasil Audit - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Detail Hasil Audit</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('audit.hasil.index') }}" class="text-decoration-none">Hasil Audit</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        @php $sb = match($hasil->status) { 'Draft'=>'secondary', 'Approved'=>'success', 'Submitted'=>'info', default=>'warning' }; @endphp
        <span class="badge bg-{{ $sb }} fs-6">{{ $hasil->status }}</span>
        <a href="{{ route('audit.hasil.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Informasi Audit</h6></div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted" style="width:180px">Program Studi</td><td class="fw-semibold">{{ $hasil->jadwalAudit->programStudi->nama_prodi ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Periode Audit</td><td>{{ $hasil->jadwalAudit->periodeAudit->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Template</td><td>{{ $hasil->checklistAuditTemplate->nama_template ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Total Skor</td><td class="fw-bold fs-5 {{ ($hasil->total_skor ?? 0) >= 80 ? 'text-success' : (($hasil->total_skor ?? 0) >= 60 ? 'text-warning' : 'text-danger') }}">{{ number_format($hasil->total_skor ?? 0, 1) }}</td></tr>
                    <tr><td class="text-muted">Kesimpulan</td><td>{{ $hasil->kesimpulan ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Detail Skor</h6></div>
            <div class="card-body">
                @if($hasil->hasilAuditDetails->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle small">
                        <thead class="table-light">
                            <tr><th>No</th><th>Item</th><th>Skor</th><th>Catatan</th></tr>
                        </thead>
                        <tbody>
                            @foreach($hasil->hasilAuditDetails as $idx => $detail)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>{{ $detail->checklistAuditItem->pertanyaan ?? '-' }}</td>
                                <td><span class="fw-bold {{ ($detail->skor_diberikan ?? 0) >= 80 ? 'text-success' : (($detail->skor_diberikan ?? 0) >= 60 ? 'text-warning' : 'text-danger') }}">{{ $detail->skor_diberikan ?? '-' }}</span></td>
                                <td>{{ $detail->catatan_auditor ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted small mb-0">Belum ada detail skor.</p>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Temuan Audit</h6>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTemuanModal"><i class="fas fa-plus me-1"></i>Tambah</button>
            </div>
            <div class="card-body">
                @if($hasil->temuanAudit->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle small">
                        <thead class="table-light">
                            <tr><th>No</th><th>Kategori</th><th>Risiko</th><th>Deskripsi</th></tr>
                        </thead>
                        <tbody>
                            @foreach($hasil->temuanAudit as $idx => $temuan)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td><span class="badge bg-info">{{ $temuan->kategori_temuan }}</span></td>
                                <td><span class="badge bg-{{ match($temuan->tingkat_risiko) { 'Tinggi'=>'danger', 'Sedang'=>'warning', default=>'info' } }}">{{ $temuan->tingkat_risiko }}</span></td>
                                <td>{{ $temuan->deskripsi_temuan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted small mb-0">Belum ada temuan.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Tim Audit</h6></div>
            <div class="card-body">
                @forelse($hasil->jadwalAudit->timAudit as $ta)
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar-placeholder-sm rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;background:#1a237e;color:#fff;font-size:12px;font-weight:600;">
                        {{ strtoupper(substr($ta->user->nama ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <div class="small fw-semibold">{{ $ta->user->nama ?? '-' }}</div>
                        <div class="text-muted" style="font-size:0.7rem;">{{ $ta->peran_dalam_tim }}</div>
                    </div>
                </div>
                @empty
                <p class="text-muted small mb-0">Belum ada tim.</p>
                @endforelse
            </div>
        </div>

        @if($hasil->status === 'Draft')
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Aksi</h6></div>
            <div class="card-body">
                <form action="{{ route('audit.hasil.approve', $hasil) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-100"><i class="fas fa-check me-1"></i>Setujui Hasil Audit</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="addTemuanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('audit.temuan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="hasil_audit_id" value="{{ $hasil->id }}">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Temuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori Temuan <span class="text-danger">*</span></label>
                            <select name="kategori_temuan" class="form-select" required>
                                <option value="Observasi">Observasi</option>
                                <option value="Minor">Minor</option>
                                <option value="Mayor">Mayor</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tingkat Risiko <span class="text-danger">*</span></label>
                            <select name="tingkat_risiko" class="form-select" required>
                                <option value="Rendah">Rendah</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Tinggi">Tinggi</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Deskripsi Temuan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi_temuan" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Rekomendasi</label>
                            <textarea name="rekomendasi" class="form-control" rows="2"></textarea>
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
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
