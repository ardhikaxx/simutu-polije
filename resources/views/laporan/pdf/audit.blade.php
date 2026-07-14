@extends('layouts.pdf.base')

@section('title', 'Laporan Audit - ' . ($periode->nama ?? ''))

@section('pdf-content')
<div class="content-title">LAPORAN HASIL AUDIT</div>
<div class="content-subtitle">Politeknik Negeri Jember</div>

<table class="info-table">
    <tr><td>Periode</td><td>: {{ $periode->nama }}</td></tr>
    <tr><td>Tahun Akademik</td><td>: {{ $periode->tahunAkademik->nama ?? '-' }}</td></tr>
    <tr><td>Total Jadwal Audit</td><td>: {{ $periode->jadwalAudit->count() }}</td></tr>
    <tr><td>Tanggal Cetak</td><td>: {{ now()->format('d/m/Y H:i') }}</td></tr>
</table>

<h4 style="color:#1a237e;font-size:13px;">Hasil Audit per Periode</h4>
<table class="data">
    <thead>
        <tr><th width="30">No</th><th>Program Studi</th><th>Tanggal</th><th>Jenis</th><th>Skor</th><th>Status</th></tr>
    </thead>
    <tbody>
        @forelse($periode->jadwalAudit as $idx => $jadwal)
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ $jadwal->programStudi->nama_prodi ?? '-' }}</td>
            <td>{{ $jadwal->tanggal_audit ? $jadwal->tanggal_audit->format('d/m/Y') : '-' }}</td>
            <td><span class="badge-blue">{{ $jadwal->jenis_audit }}</span></td>
            <td>
                @if($jadwal->hasilAudit->count() > 0)
                    {{ number_format($jadwal->hasilAudit->first()->total_skor ?? 0, 1) }}
                @else - @endif
            </td>
            <td>
                @if($jadwal->status === 'Selesai')<span class="badge-green">{{ $jadwal->status }}</span>
                @elseif($jadwal->status === 'Berlangsung')<span class="badge-yellow">{{ $jadwal->status }}</span>
                @else<span class="badge-gray">{{ $jadwal->status }}</span>@endif
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#999;">Belum ada data audit untuk periode ini.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
