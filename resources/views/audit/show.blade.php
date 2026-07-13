@extends('layouts.app')

@section('title', 'Detail Jadwal Audit - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Detail Jadwal Audit</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jadwal-audit.index') }}" class="text-decoration-none">Jadwal Audit</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        @php $sb = match($jadwal->status) { 'Terjadwal'=>'primary', 'Berlangsung'=>'warning', 'Selesai'=>'success', 'Dibatalkan'=>'danger', default=>'secondary' }; @endphp
        <span class="badge bg-{{ $sb }} fs-6">{{ $jadwal->status }}</span>
        <a href="{{ route('jadwal-audit.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Informasi Jadwal</h6></div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted" style="width:180px">Program Studi</td><td class="fw-semibold">{{ $jadwal->programStudi->nama_prodi ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Periode Audit</td><td>{{ $jadwal->periodeAudit->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Tanggal Audit</td><td>{{ $jadwal->tanggal_audit->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted">Jenis Audit</td><td><span class="badge bg-info">{{ $jadwal->jenis_audit }}</span></td></tr>
                    <tr><td class="text-muted">Dibuat Oleh</td><td>{{ $jadwal->dibuatOleh->nama ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Tim Audit</h6>
                @if(auth()->user()->hasAnyRole(['super_admin', 'admin_spmi']))
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignTeamModal">
                    <i class="fas fa-user-plus me-1"></i>Tetapkan Tim
                </button>
                @endif
            </div>
            <div class="card-body">
                @if($jadwal->timAudit->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle small">
                        <thead class="table-light">
                            <tr><th>No</th><th>Nama</th><th>Peran</th></tr>
                        </thead>
                        <tbody>
                            @foreach($jadwal->timAudit as $idx => $ta)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td class="fw-semibold">{{ $ta->user->nama ?? '-' }}</td>
                                <td><span class="badge bg-primary">{{ $ta->peran_dalam_tim }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted small mb-0">Belum ada tim audit yang ditetapkan.</p>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Hasil Audit</h6></div>
            <div class="card-body">
                @if($jadwal->hasilAudit->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($jadwal->hasilAudit as $hasil)
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <span class="fw-semibold">Skor: {{ $hasil->total_skor ?? '-' }}</span>
                            <span class="text-muted small ms-2">{{ $hasil->created_at->format('d/m/Y') }}</span>
                        </div>
                        <span class="badge bg-{{ $hasil->status === 'Disetujui' ? 'success' : 'secondary' }}">{{ $hasil->status }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted small mb-0">Belum ada hasil audit.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Aksi</h6></div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('audit.checklist', $jadwal) }}" class="btn btn-primary"><i class="fas fa-clipboard-check me-1"></i>Isi Checklist</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignTeamModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('jadwal-audit.assign-team', $jadwal) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tetapkan Tim Audit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="team-entries">
                        <div class="row mb-3 team-row">
                            <div class="col-md-8">
                                <label class="form-label small">Anggota Tim</label>
                                <select name="user_ids[]" class="form-select" required>
                                    <option value="">-- Pilih User --</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nama }} ({{ $user->getRoleNames()->first() ?? '-' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Peran</label>
                                <input type="text" name="peran_dalam_tim[]" class="form-control" placeholder="Ketua/Anggota">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addRow"><i class="fas fa-plus me-1"></i>Tambah Anggota</button>
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
$('#addRow').on('click', function() {
    var row = $('.team-row:first').clone();
    row.find('select').val('');
    row.find('input').val('');
    $('#team-entries').append(row);
});
$(document).on('click', '.remove-row', function() { $(this).closest('.team-row').remove(); });
</script>
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
