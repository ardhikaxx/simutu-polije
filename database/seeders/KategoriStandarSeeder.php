<?php

namespace Database\Seeders;

use App\Models\KategoriStandar;
use Illuminate\Database\Seeder;

class KategoriStandarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Standar Nasional Pendidikan (SN-DIKTI)', 'urutan' => 1],
            ['nama' => 'Standar Nasional Penelitian', 'urutan' => 2],
            ['nama' => 'Standar Nasional Pengabdian kepada Masyarakat', 'urutan' => 3],
            ['nama' => 'Standar Tambahan Polije', 'urutan' => 4],
        ];

        foreach ($data as $item) {
            KategoriStandar::create($item);
        }
    }
}
