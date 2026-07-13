@extends('layouts.app')

@section('title', 'Profil Saya - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Profil Saya</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Profil Saya</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="#" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i>Edit Profil</a>
        <a href="{{ route('password.change') }}" class="btn btn-outline-secondary"><i class="fas fa-key me-1"></i>Ganti Password</a>
    </div>
</div>

@php $user = auth()->user(); @endphp

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                @if($user->foto_profil)
                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="rounded-circle mb-3" width="100" height="100" style="object-fit:cover;">
                @else
                    <div class="avatar-placeholder-lg rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:100px;height:100px;background:#1a237e;color:#fff;font-weight:700;font-size:2.5rem;">
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    </div>
                @endif
                <h5 class="fw-bold mb-1">{{ $user->nama }}</h5>
                <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $user->getRoleNames()->first() ?? '')) }}</span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white"><h6 class="mb-0 fw-bold">Informasi Profil</h6></div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:200px">Nama Lengkap</td>
                        <td class="fw-semibold">{{ $user->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Email</td>
                        <td>{{ $user->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">NIP / NIM</td>
                        <td><code>{{ $user->nip_nim ?? '-' }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Role</td>
                        <td>
                            @foreach($user->getRoleNames() as $role)
                                <span class="badge bg-primary me-1">{{ ucfirst(str_replace('_', ' ', $role)) }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jurusan</td>
                        <td>{{ $user->jurusan->nama_jurusan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Program Studi</td>
                        <td>{{ $user->programStudi->nama_prodi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Unit Kerja</td>
                        <td>{{ $user->unitKerja->nama_unit ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            @if($user->status == 'active')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($user->status ?? 'Tidak Aktif') }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Last Login</td>
                        <td>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                </table>
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
