<?php

namespace App\Exports\Laporan;

use App\Models\PeriodeAudit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AuditExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $periode;

    public function __construct(PeriodeAudit $periode)
    {
        $this->periode = $periode->load(['jadwalAudit.programStudi', 'jadwalAudit.hasilAudit', 'tahunAkademik']);
    }

    public function collection()
    {
        $rows = collect();
        foreach ($this->periode->jadwalAudit as $jadwal) {
            $rows->push([
                'jadwal' => $jadwal,
                'hasil' => $jadwal->hasilAudit->first(),
            ]);
        }
        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Program Studi',
            'Tanggal Audit',
            'Jenis Audit',
            'Status Jadwal',
            'Total Skor',
            'Status Hasil',
            'Kesimpulan',
        ];
    }

    public function map($item): array
    {
        static $no = 0;
        $jadwal = $item['jadwal'];
        $hasil = $item['hasil'];
        return [
            ++$no,
            $jadwal->programStudi->nama_prodi ?? '-',
            $jadwal->tanggal_audit->format('d/m/Y'),
            $jadwal->jenis_audit,
            $jadwal->status,
            $hasil ? number_format($hasil->total_skor, 1) : '-',
            $hasil ? $hasil->status : '-',
            $hasil->kesimpulan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
