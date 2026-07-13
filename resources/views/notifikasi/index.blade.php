@extends('layouts.app')

@section('title', 'Notifikasi - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Notifikasi</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Notifikasi</li>
            </ol>
        </nav>
    </div>
    <form action="{{ route('notifikasi.mark-all-read') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-check-double me-1"></i>Tandai Semua Sudah Dibaca
        </button>
    </form>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @forelse($notifications as $notification)
        <div class="d-flex align-items-start py-3 {{ !$notification->read_at ? 'bg-light rounded px-3' : '' }} mb-2">
            <div class="me-3">
                @if($notification->type === 'App\Notifications\ApprovalNotification')
                    <i class="fas fa-check-circle text-success fa-lg"></i>
                @elseif($notification->type === 'App\Notifications\AuditNotification')
                    <i class="fas fa-clipboard-check text-warning fa-lg"></i>
                @else
                    <i class="fas fa-bell text-primary fa-lg"></i>
                @endif
            </div>
            <div class="flex-grow-1">
                <div class="fw-semibold small">
                    {{ $notification->data['title'] ?? 'Notifikasi' }}
                </div>
                <div class="text-muted small">
                    {{ $notification->data['message'] ?? '' }}
                </div>
                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
            </div>
            <div>
                @if(!$notification->read_at)
                <form action="{{ route('notifikasi.mark-read', $notification->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="Tandai sudah dibaca">
                        <i class="fas fa-check"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center text-muted py-5">
            <i class="fas fa-bell-slash fa-3x mb-3 d-block"></i>
            <h5 class="fw-bold">Tidak Ada Notifikasi</h5>
            <p>Anda tidak memiliki notifikasi baru saat ini.</p>
        </div>
        @endforelse

        <div class="d-flex justify-content-center mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection
