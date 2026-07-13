@extends('layouts.app')

@section('title', 'Checklist Audit - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Checklist Audit</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jadwal-audit.index') }}" class="text-decoration-none">Jadwal Audit</a></li>
                <li class="breadcrumb-item active">Checklist</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('jadwal-audit.show', $jadwal) }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4"><small class="text-muted d-block">Program Studi</small><span class="fw-semibold">{{ $jadwal->programStudi->nama_prodi ?? '-' }}</span></div>
            <div class="col-md-4"><small class="text-muted d-block">Tanggal Audit</small><span class="fw-semibold">{{ $jadwal->tanggal_audit->format('d/m/Y') }}</span></div>
            <div class="col-md-4"><small class="text-muted d-block">Periode</small><span class="fw-semibold">{{ $jadwal->periodeAudit->nama ?? '-' }}</span></div>
        </div>
    </div>
</div>

<form action="{{ route('audit.checklist.submit', $jadwal) }}" method="POST" id="checklistForm">
    @csrf
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Template Checklist</label>
                    <select name="checklist_audit_template_id" class="form-select" required id="templateSelect">
                        <option value="">-- Pilih Template --</option>
                        @foreach($templates as $tpl)
                        <option value="{{ $tpl->id }}" data-items='{{ json_encode($tpl->checklistAuditItems) }}'>{{ $tpl->nama_template }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="checklistTable">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Item Checklist</th>
                            <th width="120">Skor (0-100)</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody id="checklistItems">
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Pilih template checklist terlebih dahulu.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Kesimpulan</h6></div>
        <div class="card-body">
            <textarea name="kesimpulan" class="form-control" rows="3" placeholder="Tulis kesimpulan audit..."></textarea>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary" id="submitBtn"><i class="fas fa-save me-1"></i>Simpan Checklist</button>
        <a href="{{ route('jadwal-audit.show', $jadwal) }}" class="btn btn-secondary">Batal</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
$('#templateSelect').on('change', function() {
    var selected = $(this).find(':selected');
    var items = selected.data('items');
    var tbody = $('#checklistItems');
    tbody.empty();
    if (items && items.length > 0) {
        items.forEach(function(item, idx) {
            tbody.append(`
                <tr>
                    <td>${idx + 1}</td>
                    <td class="fw-semibold">${item.nama_item || item.nama || '-'}</td>
                    <td><input type="number" name="items[${idx}][skor]" class="form-control form-control-sm" min="0" max="100" required></td>
                    <td><input type="text" name="items[${idx}][catatan]" class="form-control form-control-sm"></td>
                    <input type="hidden" name="items[${idx}][checklist_item_id]" value="${item.id}">
                </tr>
            `);
        });
    } else {
        tbody.append('<tr><td colspan="4" class="text-center text-muted">Template tidak memiliki item.</td></tr>');
    }
});
</script>
@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });</script>
@endif
@endpush
