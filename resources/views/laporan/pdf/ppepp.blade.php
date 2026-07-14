@extends('layouts.pdf.base')

@section('title', 'Laporan PPEPP - ' . ($siklus->standarMutu->nama_standar ?? ''))

@section('pdf-content')
<div class="content-title">LAPORAN PPEPP</div>
<div class="content-subtitle">Peningkatan Penerapan Evaluasi dan Penjaminan Politeknik Negeri Jember</div>

<table class="info-table">
    <tr><td>Standar Mutu</td><td>: {{ $siklus->standarMutu->nama_standar ?? '-' }}</td></tr>
    <tr><td>Tahun Akademik</td><td>: {{ $siklus->tahunAkademik->nama ?? '-' }}</td></tr>
    <tr><td>Status Siklus</td><td>: {{ $siklus->status_siklus }}</td></tr>
    <tr><td>Tanggal Cetak</td><td>: {{ now()->format('d/m/Y H:i') }}</td></tr>
</table>

<h4 style="color:#1a237e;font-size:13px;">Data Pelaksanaan</h4>
<table class="data">
    <thead>
        <tr><th width="30">No</th><th>Unit / Prodi</th><th>Status</th><th>Tanggal</th><th>Deskripsi Implementasi</th></tr>
    </thead>
    <tbody>
        @forelse($siklus->ppeppPelaksanaan as $idx => $pk)
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ $pk->programStudi->nama_prodi ?? $pk->unitKerja->nama_unit ?? '-' }}</td>
            <td>
                @if($pk->status === 'Selesai')<span class="badge-green">{{ $pk->status }}</span>
                @elseif($pk->status === 'Proses')<span class="badge-yellow">{{ $pk->status }}</span>
                @else<span class="badge-gray">{{ $pk->status }}</span>@endif
            </td>
            <td>{{ $pk->tanggal_pelaksanaan ? $pk->tanggal_pelaksanaan->format('d/m/Y') : '-' }}</td>
            <td>{{ \Illuminate\Support\Str::limit($pk->deskripsi_implementasi ?? '-', 60) }}</td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;color:#999;">Belum ada data pelaksanaan.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
