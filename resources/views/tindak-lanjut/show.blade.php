@extends('layouts.app')

@section('title', 'Detail Tindak Lanjut - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Detail Tindak Lanjut</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tindak-lanjut.index') }}" class="text-decoration-none">Tindak Lanjut</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('tindak-lanjut.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Informasi Temuan</h6></div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted" style="width:180px">Deskripsi Temuan</td><td>{{ $tl->temuanAudit->deskripsi_temuan ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Kategori</td><td><span class="badge bg-info">{{ $tl->temuanAudit->kategori_temuan ?? '-' }}</span></td></tr>
                    <tr><td class="text-muted">Tingkat Risiko</td><td>{{ $tl->temuanAudit->tingkat_risiko ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Rekomendasi</td><td>{{ $tl->temuanAudit->rekomendasi ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Rencana Tindak Lanjut</td><td>{{ $tl->rencana_tindak_lanjut ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Penanggung Jawab</td><td>{{ $tl->penanggungJawab->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Target Selesai</td><td>{{ $tl->target_selesai ? $tl->target_selesai->format('d/m/Y') : '-' }}</td></tr>
                    <tr><td class="text-muted">Status</td><td>
                        @php $sb = match($tl->status) { 'Closed'=>'success', 'Verified'=>'success', 'On Progress'=>'warning', 'Need Revision'=>'danger', default=>'secondary' }; @endphp
                        <span class="badge bg-{{ $sb }}">{{ $tl->status }}</span>
                    </td></tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Riwayat Progress</h6></div>
            <div class="card-body">
                @forelse($tl->tindakLanjutProgress as $progress)
                <div class="border-start border-3 {{ $progress->status_verifikasi === 'Diterima' ? 'border-success' : ($progress->status_verifikasi === 'Ditolak' ? 'border-danger' : 'border-warning') }} ps-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold small">{{ $progress->keterangan_progress }}</span>
                        <span class="badge bg-{{ $progress->status_verifikasi === 'Diterima' ? 'success' : ($progress->status_verifikasi === 'Ditolak' ? 'danger' : 'warning') }}">{{ $progress->status_verifikasi }}</span>
                    </div>
                    <div class="text-muted small">
                        Dilaporkan: {{ $progress->dilaporkanOleh->nama ?? '-' }} &middot; {{ $progress->created_at->format('d/m/Y H:i') }}
                    </div>
                    @if($progress->file_bukti)
                    <a href="{{ asset('storage/' . $progress->file_bukti) }}" class="small" target="_blank"><i class="fas fa-paperclip me-1"></i>Lihat Bukti</a>
                    @endif
                    @if($progress->status_verifikasi === 'Pending')
                    <div class="mt-2">
                        <form action="{{ route('tindak-lanjut.progress.verify', $progress) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status_verifikasi" value="Diterima">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check me-1"></i>Verifikasi</button>
                        </form>
                        <form action="{{ route('tindak-lanjut.progress.verify', $progress) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status_verifikasi" value="Ditolak">
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-times me-1"></i>Tolak</button>
                        </form>
                    </div>
                    @endif
                </div>
                @empty
                <p class="text-muted small">Belum ada progress.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Tambah Progress</h6></div>
            <div class="card-body">
                <form action="{{ route('tindak-lanjut.progress.update', $tl) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                        <textarea name="keterangan_progress" class="form-control" rows="3" required placeholder="Jelaskan progress tindak lanjut..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Bukti</label>
                        <input type="file" class="form-control" name="file_bukti">
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane me-1"></i>Kirim Progress</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
