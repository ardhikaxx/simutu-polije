<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PPEPP - {{ $siklus->standarMutu->nama_standar }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #0d6efd; }
        .header p { margin: 5px 0 0; color: #666; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px 8px; vertical-align: top; }
        .info-table td:first-child { font-weight: bold; width: 160px; color: #555; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background-color: #0d6efd; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
        table.data td { padding: 6px 8px; border-bottom: 1px solid #ddd; font-size: 11px; }
        table.data tr:nth-child(even) { background-color: #f8f9fa; }
        .badge-success { background-color: #198754; color: #fff; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .badge-warning { background-color: #ffc107; color: #000; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .badge-secondary { background-color: #6c757d; color: #fff; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .footer { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PPEPP</h2>
        <p>Peningkatan Penerapan Evaluasi dan Penjaminan Politeknik Negeri Jember</p>
    </div>

    <table class="info-table">
        <tr><td>Standar Mutu</td><td>: {{ $siklus->standarMutu->nama_standar ?? '-' }}</td></tr>
        <tr><td>Tahun Akademik</td><td>: {{ $siklus->tahunAkademik->nama ?? '-' }}</td></tr>
        <tr><td>Status Siklus</td><td>: {{ $siklus->status_siklus }}</td></tr>
        <tr><td>Tanggal Cetak</td><td>: {{ now()->format('d/m/Y H:i') }}</td></tr>
    </table>

    <h4 style="color:#0d6efd;">Data Pelaksanaan</h4>
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
                    @if($pk->status === 'Selesai')<span class="badge-success">{{ $pk->status }}</span>
                    @elseif($pk->status === 'Proses')<span class="badge-warning">{{ $pk->status }}</span>
                    @else<span class="badge-secondary">{{ $pk->status }}</span>@endif
                </td>
                <td>{{ $pk->tanggal_pelaksanaan ? $pk->tanggal_pelaksanaan->format('d/m/Y') : '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($pk->deskripsi_implementasi ?? '-', 60) }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#999;">Belum ada data pelaksanaan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh SIMUTU Politeknik Negeri Jember &mdash; {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
