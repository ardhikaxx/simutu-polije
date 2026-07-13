<?php

namespace Database\Seeders;

use App\Models\JenisSurvei;
use Illuminate\Database\Seeder;

class JenisSurveiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Kepuasan Mahasiswa', 'target_responden' => 'mahasiswa'],
            ['nama' => 'Evaluasi Dosen', 'target_responden' => 'dosen'],
            ['nama' => 'Evaluasi Layanan Akademik', 'target_responden' => 'mahasiswa'],
            ['nama' => 'Evaluasi Fasilitas', 'target_responden' => 'mahasiswa'],
            ['nama' => 'Tracer Study Alumni', 'target_responden' => 'alumni'],
            ['nama' => 'Kepuasan Pengguna Lulusan', 'target_responden' => 'mitra_industri'],
        ];

        foreach ($data as $item) {
            JenisSurvei::create($item);
        }
    }
}
