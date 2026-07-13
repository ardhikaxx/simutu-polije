@extends('layouts.app')

@section('title', 'Pengaturan - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Pengaturan Sistem</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengaturan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-server me-2 text-primary"></i>Informasi Sistem
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" width="40%">Nama Aplikasi</td>
                        <td class="fw-semibold">{{ config('app.name', 'SIMUTU POLIJE') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Versi</td>
                        <td><span class="badge bg-primary">v1.0.0</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">PHP Version</td>
                        <td><code>{{ PHP_VERSION }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Laravel Version</td>
                        <td><code>{{ app()->version() }}</code></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-database me-2 text-primary"></i>Database
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" width="40%">Host</td>
                        <td><code>{{ config('database.connections.mysql.host', '-') }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Port</td>
                        <td><code>{{ config('database.connections.mysql.port', '-') }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Database</td>
                        <td><code>{{ config('database.connections.mysql.database', '-') }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Driver</td>
                        <td><code>{{ config('database.default', '-') }}</code></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
