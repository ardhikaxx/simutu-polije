@extends('layouts.app')

@section('title', 'Hasil Survei - SIMUTU POLIJE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Hasil Survei: {{ $survei->judul }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('survei.index') }}" class="text-decoration-none">Survei</a></li>
                <li class="breadcrumb-item active">Hasil</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('survei.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
</div>

<div class="row mb-4">
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $stats['total_responden'] }}</h3>
                <small>Total Responden</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $stats['total_jawaban'] }}</h3>
                <small>Total Jawaban</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $survei->pertanyaanSurvei->count() }}</h3>
                <small>Jumlah Pertanyaan</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach($pertanyaanStats as $ps)
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold small">{{ $ps['pertanyaan']->teks_pertanyaan }}</h6>
                <small class="text-muted">{{ $ps['pertanyaan']->tipe_jawaban }} &middot; {{ $ps['total_jawaban'] }} jawaban</small>
            </div>
            <div class="card-body">
                @if($ps['rata_rata_rating'])
                <div class="text-center">
                    <h2 class="text-primary fw-bold">{{ $ps['rata_rata_rating'] }}</h2>
                    <div class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= round($ps['rata_rata_rating']) ? '' : 'text-muted' }}"></i>
                        @endfor
                    </div>
                    <small class="text-muted">Rata-rata rating</small>
                </div>
                @endif
                @if($ps['jawaban_teks']->count() > 0)
                <div class="mt-3">
                    <small class="fw-semibold d-block mb-2">Jawaban Teks:</small>
                    @foreach($ps['jawaban_teks']->take(5) as $jawaban)
                    <div class="bg-light rounded p-2 mb-1 small">"{{ $jawaban }}"</div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
