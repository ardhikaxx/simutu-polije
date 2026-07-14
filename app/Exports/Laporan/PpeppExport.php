<?php

namespace App\Exports\Laporan;

use App\Models\PpeppSiklus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PpeppExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $siklus;

    public function __construct(PpeppSiklus $siklus)
    {
        $this->siklus = $siklus->load(['standarMutu', 'tahunAkademik', 'ppeppPelaksanaan.programStudi', 'ppeppPelaksanaan.unitKerja']);
    }

    public function collection()
    {
        return $this->siklus->ppeppPelaksanaan;
    }

    public function headings(): array
    {
        return [
            'No',
            'Standar Mutu',
            'Tahun Akademik',
            'Unit / Prodi',
            'Status',
            'Tanggal Pelaksanaan',
            'Deskripsi Implementasi',
        ];
    }

    public function map($item): array
    {
        static $no = 0;
        return [
            ++$no,
            $this->siklus->standarMutu->nama_standar ?? '-',
            $this->siklus->tahunAkademik->nama ?? '-',
            $item->programStudi->nama_prodi ?? $item->unitKerja->nama_unit ?? '-',
            $item->status,
            $item->tanggal_pelaksanaan ? $item->tanggal_pelaksanaan->format('d/m/Y') : '-',
            $item->deskripsi_implementasi ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
