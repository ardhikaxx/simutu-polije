<?php

namespace Database\Seeders;

use App\Models\PengaturanAplikasi;
use Illuminate\Database\Seeder;

class PengaturanAplikasiSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'nama_institusi', 'value' => 'Politeknik Negeri Jember'],
            ['key' => 'alamat', 'value' => 'Jl. Mastrip, Krajan Timur, Sumbersari, Jember'],
            ['key' => 'telepon', 'value' => '(0331) 332567'],
            ['key' => 'email', 'value' => 'info@polije.ac.id'],
            ['key' => 'website', 'value' => 'https://www.polije.ac.id'],
            ['key' => 'logo_path', 'value' => 'assets/logo-polije.png'],
        ];

        foreach ($settings as $setting) {
            PengaturanAplikasi::create($setting);
        }
    }
}
