<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            JurusanProdiSeeder::class,
            UnitKerjaSeeder::class,
            TahunAkademikSeeder::class,
            KategoriStandarSeeder::class,
            KategoriDokumenSeeder::class,
            JenisSurveiSeeder::class,
            UserSeeder::class,
            StandarMutuSeeder::class,
            PeriodeAuditSeeder::class,
            DummyDataSeeder::class,
            PengaturanAplikasiSeeder::class,
        ]);
    }
}
