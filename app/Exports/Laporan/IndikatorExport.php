<?php

namespace App\Exports\Laporan;

use App\Models\IndikatorMutu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IndikatorExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return IndikatorMutu::with(['standarMutu', 'targetIndikator', 'capaianIndikator'])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Standar Mutu',
            'Nama Indikator',
            'Formula',
            'Frekuensi',
            'Target',
            'Capaian',
            'Status',
        ];
    }

    public function map($item): array
    {
        static $no = 0;
        $target = $item->targetIndikator->latest()->first();
        $capaian = $item->capaianIndikator->latest()->first();
        return [
            ++$no,
            $item->standarMutu->nama_standar ?? '-',
            $item->nama_indikator,
            $item->formula_perhitungan ?? '-',
            $item->frekuensi_pengukuran,
            $target ? $target->nilai_target : '-',
            $capaian ? $capaian->nilai_capaian : '-',
            $capaian ? ucfirst($capaian->status_warna) : '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
