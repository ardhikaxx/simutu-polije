@extends('layouts.pdf.base')

@section('title', 'Semua Template Dokumen Mutu')

@section('pdf-content')
<div class="content-title">KUMPULAN TEMPLATE DOKUMEN MUTU</div>
<div class="content-subtitle">Politeknik Negeri Jember</div>

<table class="info-table">
    <tr><td>Total Template</td><td>: {{ count($templates) }} template</td></tr>
    <tr><td>Dicetak</td><td>: {{ now()->format('d/m/Y H:i') }}</td></tr>
</table>

<h4 style="color:#1a237e;font-size:13px;margin-top:20px;">Daftar Isi</h4>
<table class="data">
    <thead>
        <tr><th width="30">No</th><th>Nama Template</th><th>Kode Standar</th><th>Standar Mutu</th></tr>
    </thead>
    <tbody>
        @foreach($templates as $idx => $tpl)
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ $tpl->nama_template }}</td>
            <td>{{ $tpl->standarMutu->kode_standar ?? '-' }}</td>
            <td>{{ $tpl->standarMutu->nama_standar ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@php
$grouped = $templates->groupBy('standar_mutu_id');
@endphp

@foreach($grouped as $standarId => $groupTemplates)
@php $standar = $groupTemplates->first()->standarMutu; @endphp

<div style="page-break-before:always;"></div>

<div class="content-title" style="font-size:13px;">{{ $standar->kode_standar ?? '-' }} - {{ $standar->nama_standar ?? '-' }}</div>
<div class="content-subtitle">Standar Mutu</div>

<table class="info-table">
    <tr><td>Kode Standar</td><td>: {{ $standar->kode_standar ?? '-' }}</td></tr>
    <tr><td>Nama Standar</td><td>: {{ $standar->nama_standar ?? '-' }}</td></tr>
    <tr><td>Deskripsi</td><td>: {{ $standar->deskripsi ?? '-' }}</td></tr>
</table>

@foreach($groupTemplates as $tplIdx => $tpl)
<h4 style="color:#1a237e;font-size:12px;margin-top:16px;">
    {{ $tplIdx + 1 }}. {{ $tpl->nama_template }}
</h4>
<table class="info-table">
    <tr><td>Deskripsi</td><td>: {{ $tpl->deskripsi ?? '-' }}</td></tr>
    <tr><td>Jenis File</td><td>: {{ $tpl->jenis_file ?? '-' }}</td></tr>
    <tr><td>Ukuran</td><td>: {{ $tpl->ukuran_file }} KB</td></tr>
</table>

<table class="data">
    <thead>
        <tr><th>No</th><th>Nama Indikator</th><th>Satuan</th><th>Formula</th><th>Sumber Data</th></tr>
    </thead>
    <tbody>
        @forelse($standar->indikatorMutu as $idx => $ind)
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ $ind->nama_indikator }}</td>
            <td>{{ $ind->satuan }}</td>
            <td>{{ $ind->formula_perhitungan }}</td>
            <td>{{ $ind->sumber_data }}</td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;color:#999;">Belum ada indikator.</td></tr>
        @endforelse
    </tbody>
</table>
@endforeach

@endforeach

<div class="footer" style="margin-top:30px;">
    Dokumen ini digenerate otomatis oleh SIMUTU Politeknik Negeri Jember
</div>
@endsection
