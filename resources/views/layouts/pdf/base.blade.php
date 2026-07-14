<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan SIMUTU' }}</title>
    <style>
        body { font-family: "Times New Roman", Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }

        /* Kop Surat */
        .kop { display: flex; align-items: flex-start; gap: 16px; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 24px; }
        .kop img { width: 100px; }
        .kop .kementerian { font-size: 14px; font-weight: bold; margin: 0; text-align: center; }
        .kop .institut { font-size: 18px; font-weight: bold; margin: 2px 0; text-align: center; letter-spacing: 1px; }
        .kop .alamat { margin: 2px 0; text-align: center; font-size: 10px; color: #444; }
        .kop .kontak { margin: 2px 0; text-align: center; font-size: 10px; color: #444; }

        /* Content */
        .content-title { text-align: center; font-size: 14px; font-weight: bold; text-transform: uppercase; margin: 20px 0 6px; color: #1a237e; }
        .content-subtitle { text-align: center; font-size: 11px; color: #666; margin-bottom: 16px; }

        /* Tables */
        .info-table { width: 100%; margin-bottom: 16px; }
        .info-table td { padding: 3px 6px; vertical-align: top; font-size: 11px; }
        .info-table td:first-child { font-weight: bold; width: 160px; color: #555; }

        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px; }
        table.data th { background-color: #1a237e; color: #fff; padding: 6px 8px; text-align: left; font-size: 10px; }
        table.data td { padding: 5px 8px; border-bottom: 1px solid #ddd; }
        table.data tr:nth-child(even) { background-color: #f8f9fa; }

        .badge-green { background-color: #198754; color: #fff; padding: 1px 5px; border-radius: 3px; font-size: 9px; }
        .badge-yellow { background-color: #ffc107; color: #000; padding: 1px 5px; border-radius: 3px; font-size: 9px; }
        .badge-red { background-color: #dc3545; color: #fff; padding: 1px 5px; border-radius: 3px; font-size: 9px; }
        .badge-blue { background-color: #0dcaf0; color: #000; padding: 1px 5px; border-radius: 3px; font-size: 9px; }
        .badge-gray { background-color: #6c757d; color: #fff; padding: 1px 5px; border-radius: 3px; font-size: 9px; }

        .footer { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 8px; font-size: 9px; color: #999; text-align: center; }
        .ttd { width: 260px; margin-left: auto; margin-top: 40px; text-align: center; font-size: 11px; }

        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>
    @include('layouts.pdf.kop-surat')
    @yield('pdf-content')
    <div class="footer">
        Dicetak otomatis oleh SIMUTU Politeknik Negeri Jember &mdash; {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
