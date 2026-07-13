<?php

namespace Database\Seeders;

use App\Models\KategoriDokumen;
use Illuminate\Database\Seeder;

class KategoriDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Kebijakan Mutu', 'prefix_nomor' => 'POL'],
            ['nama' => 'Manual Mutu', 'prefix_nomor' => 'MM'],
            ['nama' => 'Standar Mutu', 'prefix_nomor' => 'STD'],
            ['nama' => 'SOP', 'prefix_nomor' => 'SOP'],
            ['nama' => 'Formulir', 'prefix_nomor' => 'FRM'],
            ['nama' => 'Instruksi Kerja', 'prefix_nomor' => 'IK'],
            ['nama' => 'Panduan', 'prefix_nomor' => 'PG'],
            ['nama' => 'Dokumen Pendukung', 'prefix_nomor' => 'DP'],
        ];

        foreach ($data as $item) {
            KategoriDokumen::create($item);
        }
    }
}
