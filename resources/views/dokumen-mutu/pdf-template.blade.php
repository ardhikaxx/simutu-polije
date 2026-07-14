<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Template {{ $standar->nama_standar }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #0d6efd; font-size: 16px; }
        .header p { margin: 4px 0 0; color: #666; font-size: 11px; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 3px 6px; vertical-align: top; font-size: 11px; }
        .info-table td:first-child { font-weight: bold; width: 160px; color: #555; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background-color: #0d6efd; color: #fff; padding: 6px; text-align: left; font-size: 10px; }
        table.data td { padding: 5px 6px; border-bottom: 1px solid #ddd; font-size: 10px; }
        table.data tr:nth-child(even) { background-color: #f8f9fa; }
        .section { margin-top: 20px; page-break-inside: avoid; }
        .section h4 { color: #0d6efd; font-size: 13px; border-bottom: 1px solid #ddd; padding-bottom: 4px; }
        .footer { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px; font-size: 9px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>TEMPLATE DOKUMEN MUTU</h2>
        <p>Politeknik Negeri Jember</p>
    </div>

    <table class="info-table">
        <tr><td>Kode Standar</td><td>: {{ $standar->kode_standar }}</td></tr>
        <tr><td>Nama Standar</td><td>: {{ $standar->nama_standar }}</td></tr>
        <tr><td>Deskripsi</td><td>: {{ $standar->deskripsi }}</td></tr>
        <tr><td>Dasar Hukum</td><td>: {{ $standar->dasar_hukum ?? '-' }}</td></tr>
        <tr><td>Unit Terdampak</td><td>: {{ is_array($standar->unit_terdampak) ? implode(', ', $standar->unit_terdampak) : '-' }}</td></tr>
    </table>

    <div class="section">
        <h4>Indikator Mutu</h4>
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
    </div>

    <div class="section" style="margin-top:30px;">
        <h4>Catatan Pengisian</h4>
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
    </div>

    <div class="footer">
        Template ini hanya sebagai panduan. Silakan menyesuaikan dengan kebutuhan masing-masing unit.
        <br>Dicetak oleh SIMUTU Politeknik Negeri Jember &mdash; {{ now()->format('d/m/Y') }}
    </div>
</body>
</html>
