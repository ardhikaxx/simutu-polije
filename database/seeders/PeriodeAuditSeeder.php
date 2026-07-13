<?php

namespace Database\Seeders;

use App\Models\PeriodeAudit;
use App\Models\TahunAkademik;
use Illuminate\Database\Seeder;

class PeriodeAuditSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAkademikList = TahunAkademik::all();

        foreach ($tahunAkademikList as $ta) {
            if ($ta->semester === 'Ganjil') {
                PeriodeAudit::create([
                    'nama' => "Audit Internal {$ta->nama} Semester Ganjil",
                    'tahun_akademik_id' => $ta->id,
                    'tanggal_mulai' => $ta->tanggal_mulai,
                    'tanggal_selesai' => $ta->tanggal_selesai,
                    'status' => $ta->is_active ? 'Berjalan' : 'Selesai',
                ]);
            } else {
                PeriodeAudit::create([
                    'nama' => "Audit Internal {$ta->nama} Semester Genap",
                    'tahun_akademik_id' => $ta->id,
                    'tanggal_mulai' => $ta->tanggal_mulai,
                    'tanggal_selesai' => $ta->tanggal_selesai,
                    'status' => $ta->is_active ? 'Berjalan' : 'Selesai',
                ]);
            }
        }
    }
}
