<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Audit - {{ $periode->nama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #198754; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #198754; }
        .header p { margin: 5px 0 0; color: #666; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px 8px; vertical-align: top; }
        .info-table td:first-child { font-weight: bold; width: 160px; color: #555; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background-color: #198754; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
        table.data td { padding: 6px 8px; border-bottom: 1px solid #ddd; font-size: 11px; }
        table.data tr:nth-child(even) { background-color: #f8f9fa; }
        .badge-success { background-color: #198754; color: #fff; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .badge-warning { background-color: #ffc107; color: #000; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .badge-secondary { background-color: #6c757d; color: #fff; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .badge-info { background-color: #0dcaf0; color: #000; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .footer { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN HASIL AUDIT</h2>
        <p>Politeknik Negeri Jember</p>
    </div>

    <table class="info-table">
        <tr><td>Periode</td><td>: {{ $periode->nama }}</td></tr>
        <tr><td>Tahun Akademik</td><td>: {{ $periode->tahunAkademik->nama ?? '-' }}</td></tr>
        <tr><td>Total Jadwal Audit</td><td>: {{ $periode->jadwalAudit->count() }}</td></tr>
        <tr><td>Tanggal Cetak</td><td>: {{ now()->format('d/m/Y H:i') }}</td></tr>
    </table>

    <h4 style="color:#198754;">Hasil Audit per Periode</h4>
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
                <td><span class="badge-info">{{ $jadwal->jenis_audit }}</span></td>
                <td>
                    @if($jadwal->hasilAudit->count() > 0)
                        {{ number_format($jadwal->hasilAudit->first()->total_skor ?? 0, 1) }}
                    @else - @endif
                </td>
                <td>
                    @if($jadwal->status === 'Selesai')<span class="badge-success">{{ $jadwal->status }}</span>
                    @elseif($jadwal->status === 'Berlangsung')<span class="badge-warning">{{ $jadwal->status }}</span>
                    @else<span class="badge-secondary">{{ $jadwal->status }}</span>@endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#999;">Belum ada data audit untuk periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh SIMUTU Politeknik Negeri Jember &mdash; {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
