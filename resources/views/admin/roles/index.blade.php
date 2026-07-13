@extends('layouts.app')

@section('title', 'Manajemen Role - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Manajemen Role</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Manajemen Role</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @php
            $roles = Spatie\Permission\Models\Role::with('users')->get();

            $roleDescriptions = [
                'super_admin' => 'Super Administrator',
                'admin_spmi' => 'Admin SPMI',
                'kajur' => 'Kepala Jurusan',
                'kaprodi' => 'Kepala Program Studi',
                'gpm' => 'Gunada Penjaminan Mutu',
                'auditor' => 'Auditor',
                'auditor_ketua' => 'Ketua Auditor',
                'dosen' => 'Dosen',
                'tendik' => 'Tenaga Kependidikan',
                'pimpinan' => 'Pimpinan',
                'mahasiswa' => 'Mahasiswa',
                'alumni' => 'Alumni',
                'mitra_industri' => 'Mitra Industri',
            ];
        @endphp
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Role</th>
                        <th width="120">Jumlah User</th>
                        <th>Keterangan</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $index => $role)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-primary rounded-pill">{{ $role->name }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info rounded-pill">{{ $role->users->count() }}</span>
                        </td>
                        <td>{{ $roleDescriptions[$role->name] ?? $role->name }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-user-shield fa-2x mb-2 d-block"></i>
                            Belum ada data role.
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
$(document).ready(function() {
    $('#dataTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' }
    });
});
</script>
@endpush
