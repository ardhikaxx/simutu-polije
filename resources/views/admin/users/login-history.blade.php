@extends('layouts.app')

@section('title', 'Riwayat Login - ' . $user->nama . ' - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Riwayat Login</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Manajemen User</a></li>
                <li class="breadcrumb-item active">{{ $user->nama }}</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:var(--polije-primary);color:#fff;font-weight:700;font-size:20px;">
                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                </div>
            </div>
            <div class="col">
                <h5 class="fw-bold mb-0">{{ $user->nama }}</h5>
                <span class="text-muted small">{{ $user->email }}</span>
                <div class="mt-1">
                    <span class="badge bg-primary rounded-pill">{{ $user->getRoleNames()->first() ?? '-' }}</span>
                    <span class="badge bg-{{ $user->status === 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($user->status) }}</span>
                </div>
            </div>
            <div class="col-auto text-end">
                <div class="text-muted small">Total Login</div>
                <h4 class="fw-bold mb-0 text-primary">{{ $activities->where('event', 'login')->count() }}</h4>
            </div>
            <div class="col-auto text-end">
                <div class="text-muted small">Login Gagal</div>
                <h4 class="fw-bold mb-0 text-danger">{{ $activities->where('event', 'login_failed')->count() }}</h4>
            </div>
            <div class="col-auto text-end">
                <div class="text-muted small">Terakhir Login</div>
                <div class="fw-semibold">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : '-' }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $index => $act)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $act->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>
                            @if($act->event === 'login')
                                <span class="badge bg-success">Berhasil</span>
                            @else
                                <span class="badge bg-danger">Gagal</span>
                            @endif
                        </td>
                        <td><code>{{ $act->properties['ip'] ?? '-' }}</code></td>
                        <td>
                            <span class="small text-muted" title="{{ $act->properties['user_agent'] ?? '-' }}">
                                {{ Str::limit($act->properties['user_agent'] ?? '-', 60) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-sign-in-alt fa-2x mb-2 d-block"></i>Belum ada riwayat login.
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
@endpush
