<?php

namespace App\Exports\Laporan;

use App\Models\StandarMutu;
use App\Models\TahunAkademik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllDataExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $tahunAkademikId;

    public function __construct($tahunAkademikId = null)
    {
        $this->tahunAkademikId = $tahunAkademikId;
    }

    public function collection()
    {
        $rows = collect();
        $standars = StandarMutu::where('status', 'Published')
            ->with(['indikatorMutu.targetIndikator', 'indikatorMutu.capaianIndikator'])
            ->get();

        foreach ($standars as $sm) {
            foreach ($sm->indikatorMutu as $ind) {
                $targetQuery = $ind->targetIndikator;
                $capaianQuery = $ind->capaianIndikator;
                if ($this->tahunAkademikId) {
                    $targetQuery = $targetQuery->where('tahun_akademik_id', $this->tahunAkademikId);
                    $capaianQuery = $capaianQuery->where('tahun_akademik_id', $this->tahunAkademikId);
                }
                $target = $targetQuery->latest()->first();
                $capaian = $capaianQuery->latest()->first();

                $rows->push([
                    'kode_standar' => $sm->kode_standar,
                    'nama_standar' => $sm->nama_standar,
                    'nama_indikator' => $ind->nama_indikator,
                    'satuan' => $ind->satuan,
                    'formula' => $ind->formula_perhitungan,
                    'sumber_data' => $ind->sumber_data,
                    'frekuensi' => $ind->frekuensi_pengukuran,
                    'target' => $target ? $target->nilai_target : '-',
                    'capaian' => $capaian ? $capaian->nilai_capaian : '-',
                    'status' => $capaian ? ucfirst($capaian->status_warna) : '-',
                ]);
            }
        }
        return $rows;
    }

    public function headings(): array
    {
        return [
            'Kode Standar', 'Nama Standar', 'Indikator', 'Satuan', 'Formula',
            'Sumber Data', 'Frekuensi', 'Target', 'Capaian', 'Status',
        ];
    }

    public function map($item): array
    {
        return [
            $item['kode_standar'], $item['nama_standar'], $item['nama_indikator'],
            $item['satuan'], $item['formula'], $item['sumber_data'], $item['frekuensi'],
            $item['target'], $item['capaian'], $item['status'],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '1A237E']]]];
    }
}
