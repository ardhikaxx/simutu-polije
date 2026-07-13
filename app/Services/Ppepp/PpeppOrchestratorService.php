<?php

namespace App\Services\Ppepp;

use App\Models\PpeppPelaksanaan;
use App\Models\PpeppSiklus;
use App\Models\StandarMutu;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\DB;

class PpeppOrchestratorService
{
    public function prosesPenetapan(StandarMutu $standar): PpeppSiklus
    {
        return DB::transaction(function () use ($standar) {
            $tahunAkademik = TahunAkademik::where('is_active', true)->first();

            if (!$tahunAkademik) {
                throw new \RuntimeException('Tidak ada tahun akademik aktif untuk memulai siklus PPEPP.');
            }

            $siklus = PpeppSiklus::create([
                'standar_mutu_id' => $standar->id,
                'tahun_akademik_id' => $tahunAkademik->id,
                'tahap_sekarang' => 'penetapan',
                'status_siklus' => 'Berjalan',
            ]);

            $unitTerdampak = $standar->unit_terdampak;

            if (is_array($unitTerdampak)) {
                foreach ($unitTerdampak as $unitId) {
                    PpeppPelaksanaan::create([
                        'ppepp_siklus_id' => $siklus->id,
                        'program_studi_id' => $unitId,
                        'deskripsi_implementasi' => null,
                        'tanggal_pelaksanaan' => null,
                        'status' => 'Belum',
                        'diisi_oleh' => null,
                    ]);
                }
            }

            $siklus->update(['tahap_sekarang' => 'pelaksanaan']);

            return $siklus->fresh();
        });
    }
}
