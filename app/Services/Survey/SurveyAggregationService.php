<?php

namespace App\Services\Survey;

use App\Models\HasilSurveiAgregat;
use App\Models\JawabanSurvei;
use App\Models\PertanyaanSurvei;
use App\Models\Survei;
use Illuminate\Support\Facades\DB;

class SurveyAggregationService
{
    public function agregasi(Survei $survei): void
    {
        $pertanyaanLikert = PertanyaanSurvei::where('survei_id', $survei->id)
            ->where('tipe_jawaban', 'skala_likert')
            ->pluck('id');

        if ($pertanyaanLikert->isEmpty()) {
            return;
        }

        $jawabanPerProdi = JawabanSurvei::where('survei_id', $survei->id)
            ->whereIn('pertanyaan_survei_id', $pertanyaanLikert)
            ->join('users', 'jawaban_surveis.responden_id', '=', 'users.id')
            ->select(
                'users.program_studi_id',
                DB::raw('AVG(jawaban_surveis.nilai_jawaban) as rata_rata'),
                DB::raw('COUNT(DISTINCT jawaban_surveis.responden_id) as jumlah_responden')
            )
            ->groupBy('users.program_studi_id')
            ->get();

        foreach ($jawabanPerProdi as $row) {
            HasilSurveiAgregat::updateOrCreate(
                [
                    'survei_id' => $survei->id,
                    'program_studi_id' => $row->program_studi_id,
                ],
                [
                    'indeks_kepuasan' => round($row->rata_rata, 2),
                    'jumlah_responden' => $row->jumlah_responden,
                    'dihitung_pada' => now(),
                ]
            );
        }
    }
}
