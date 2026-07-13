<?php

namespace Database\Seeders;

use App\Models\TahunAkademik;
use Illuminate\Database\Seeder;

class TahunAkademikSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => '2023/2024',
                'semester' => 'Ganjil',
                'tanggal_mulai' => '2023-08-01',
                'tanggal_selesai' => '2023-12-31',
                'is_active' => false,
            ],
            [
                'nama' => '2023/2024',
                'semester' => 'Genap',
                'tanggal_mulai' => '2024-01-01',
                'tanggal_selesai' => '2024-06-30',
                'is_active' => false,
            ],
            [
                'nama' => '2024/2025',
                'semester' => 'Ganjil',
                'tanggal_mulai' => '2024-08-01',
                'tanggal_selesai' => '2024-12-31',
                'is_active' => false,
            ],
            [
                'nama' => '2024/2025',
                'semester' => 'Genap',
                'tanggal_mulai' => '2025-01-01',
                'tanggal_selesai' => '2025-06-30',
                'is_active' => false,
            ],
            [
                'nama' => '2025/2026',
                'semester' => 'Ganjil',
                'tanggal_mulai' => '2025-08-01',
                'tanggal_selesai' => '2025-12-31',
                'is_active' => true,
            ],
            [
                'nama' => '2025/2026',
                'semester' => 'Genap',
                'tanggal_mulai' => '2026-01-01',
                'tanggal_selesai' => '2026-06-30',
                'is_active' => false,
            ],
        ];

        foreach ($data as $item) {
            TahunAkademik::create($item);
        }
    }
}
