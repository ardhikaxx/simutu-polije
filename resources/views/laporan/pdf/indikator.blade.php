@extends('layouts.pdf.base')

@section('title', 'Laporan Capaian Indikator Mutu')

@section('pdf-content')
<div class="content-title">LAPORAN CAPAIAN INDIKATOR MUTU</div>
<div class="content-subtitle">Politeknik Negeri Jember</div>

<table class="info-table">
    <tr><td>Tahun Akademik Aktif</td><td>: {{ $tahunAkademikAktif->nama ?? '-' }}</td></tr>
    <tr><td>Tanggal Cetak</td><td>: {{ now()->format('d/m/Y H:i') }}</td></tr>
</table>

<table class="data">
    <thead>
        <tr><th width="30">No</th><th>Standar Mutu</th><th>Indikator</th><th>Formula</th><th>Target</th><th>Capaian</th><th>Status</th></tr>
    </thead>
    <tbody>
        @forelse($indikators as $idx => $item)
        @php
            $target = $item->targetIndikator->latest()->first();
            $capaian = $item->capaianIndikator->latest()->first();
        @endphp
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ $item->standarMutu->nama_standar ?? '-' }}</td>
            <td>{{ $item->nama_indikator }}</td>
            <td>{{ $item->formula_perhitungan ?? '-' }}</td>
            <td>{{ $target ? $target->nilai_target : '-' }}</td>
            <td>{{ $capaian ? $capaian->nilai_capaian : '-' }}</td>
            <td>
                @if($capaian)
                    @if($capaian->status_warna === 'baik')<span class="badge-green">Baik</span>
                    @elseif($capaian->status_warna === 'perlu_perbaikan')<span class="badge-yellow">Perlu Perbaikan</span>
                    @else<span class="badge-red">Tidak Baik</span>@endif
                @else - @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:#999;">Belum ada data indikator.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
