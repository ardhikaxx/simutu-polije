<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Capaian Indikator Mutu</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #0dcaf0; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #0dcaf0; }
        .header p { margin: 5px 0 0; color: #666; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px 8px; vertical-align: top; }
        .info-table td:first-child { font-weight: bold; width: 160px; color: #555; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background-color: #0dcaf0; color: #000; padding: 8px; text-align: left; font-size: 11px; }
        table.data td { padding: 6px 8px; border-bottom: 1px solid #ddd; font-size: 11px; }
        table.data tr:nth-child(even) { background-color: #f8f9fa; }
        .status-baik { background-color: #198754; color: #fff; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .status-perlu { background-color: #ffc107; color: #000; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .status-tidak { background-color: #dc3545; color: #fff; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .footer { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN CAPAIAN INDIKATOR MUTU</h2>
        <p>Politeknik Negeri Jember</p>
    </div>

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
                        @if($capaian->status_warna === 'baik')<span class="status-baik">Baik</span>
                        @elseif($capaian->status_warna === 'perlu_perbaikan')<span class="status-perlu">Perlu Perbaikan</span>
                        @else<span class="status-tidak">Tidak Baik</span>@endif
                    @else - @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#999;">Belum ada data indikator.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh SIMUTU Politeknik Negeri Jember &mdash; {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
