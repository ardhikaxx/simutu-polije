@extends('layouts.pdf.base')

@section('title', 'Template ' . ($standar->nama_standar ?? ''))

@section('pdf-content')
<div class="content-title">TEMPLATE DOKUMEN MUTU</div>
<div class="content-subtitle">Politeknik Negeri Jember</div>

<table class="info-table">
    <tr><td>Kode Standar</td><td>: {{ $standar->kode_standar }}</td></tr>
    <tr><td>Nama Standar</td><td>: {{ $standar->nama_standar }}</td></tr>
    <tr><td>Deskripsi</td><td>: {{ $standar->deskripsi }}</td></tr>
    <tr><td>Dasar Hukum</td><td>: {{ $standar->dasar_hukum ?? '-' }}</td></tr>
    <tr><td>Unit Terdampak</td><td>: {{ is_array($standar->unit_terdampak) ? implode(', ', $standar->unit_terdampak) : '-' }}</td></tr>
</table>

<h4 style="color:#1a237e;font-size:13px;">Indikator Mutu</h4>
<table class="data">
    <thead>
        <tr><th width="30">No</th><th>Nama Indikator</th><th>Satuan</th><th>Formula</th><th>Sumber Data</th><th>Frekuensi</th></tr>
    </thead>
    <tbody>
        @forelse($indikators as $idx => $ind)
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ $ind->nama_indikator }}</td>
            <td>{{ $ind->satuan }}</td>
            <td>{{ $ind->formula_perhitungan }}</td>
            <td>{{ $ind->sumber_data }}</td>
            <td>{{ $ind->frekuensi_pengukuran }}</td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#999;">Belum ada indikator.</td></tr>
        @endforelse
    </tbody>
</table>

<h4 style="color:#1a237e;font-size:13px;margin-top:24px;">Catatan Pengisian</h4>
<table class="data">
    <thead><tr><th>Bagian</th><th>Deskripsi</th><th>Diisi Oleh</th></tr></thead>
    <tbody>
        <tr><td>1. Profil Unit</td><td>Isi data identitas unit / program studi</td><td>Admin / Kaprodi</td></tr>
        <tr><td>2. Sasaran</td><td>Isi sasaran mutu sesuai standar</td><td>Kaprodi / Kajur</td></tr>
        <tr><td>3. Program Kerja</td><td>Isi rencana kegiatan pencapaian mutu</td><td>Tim Penjaminan Mutu</td></tr>
        <tr><td>4. Eviden</td><td>Lampirkan bukti-bukti pendukung</td><td>Unit Terkait</td></tr>
        <tr><td>5. Evaluasi</td><td>Isi hasil evaluasi dan rekomendasi</td><td>Auditor / GPM</td></tr>
    </tbody>
</table>

<div class="footer" style="margin-top:30px;">
    Template ini hanya sebagai panduan. Silakan menyesuaikan dengan kebutuhan masing-masing unit.
</div>
@endsection
