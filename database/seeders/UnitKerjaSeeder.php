<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            [
                'nama_unit' => 'Pusat Penjaminan Mutu (Pusjianmut)',
                'jenis' => 'Penunjang',
            ],
            [
                'nama_unit' => 'Biro Administrasi Akademik',
                'jenis' => 'Non-Akademik',
            ],
            [
                'nama_unit' => 'Biro Administrasi Umum dan Keuangan',
                'jenis' => 'Non-Akademik',
            ],
            [
                'nama_unit' => 'Biro Kemahasiswaan',
                'jenis' => 'Non-Akademik',
            ],
            [
                'nama_unit' => 'Sub Bagian Akademik JPP',
                'jenis' => 'Akademik',
            ],
            [
                'nama_unit' => 'Sub Bagian Akademik JTP',
                'jenis' => 'Akademik',
            ],
            [
                'nama_unit' => 'Sub Bagian Akademik JPTN',
                'jenis' => 'Akademik',
            ],
            [
                'nama_unit' => 'Sub Bagian Akademik JMA',
                'jenis' => 'Akademik',
            ],
            [
                'nama_unit' => 'Sub Bagian Akademik JTI',
                'jenis' => 'Akademik',
            ],
            [
                'nama_unit' => 'Sub Bagian Akademik JBKP',
                'jenis' => 'Akademik',
            ],
            [
                'nama_unit' => 'Sub Bagian Akademik JKS',
                'jenis' => 'Akademik',
            ],
            [
                'nama_unit' => 'Sub Bagian Akademik JTK',
                'jenis' => 'Akademik',
            ],
            [
                'nama_unit' => 'Sub Bagian Akademik JBIS',
                'jenis' => 'Akademik',
            ],
            [
                'nama_unit' => 'Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM)',
                'jenis' => 'Penunjang',
            ],
            [
                'nama_unit' => 'Perpustakaan',
                'jenis' => 'Penunjang',
            ],
            [
                'nama_unit' => 'Laboratorium Pusat',
                'jenis' => 'Penunjang',
            ],
            [
                'nama_unit' => 'UPT Bahasa',
                'jenis' => 'Penunjang',
            ],
            [
                'nama_unit' => 'UPT TIK',
                'jenis' => 'Penunjang',
            ],
        ];

        foreach ($units as $unit) {
            UnitKerja::create([
                'nama_unit' => $unit['nama_unit'],
                'jenis' => $unit['jenis'],
                'status' => 'aktif',
            ]);
        }
    }
}
