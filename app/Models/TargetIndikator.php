<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TargetIndikator extends Model
{
    use HasFactory;

    protected $table = 'target_indikator';

    protected $fillable = [
        'indikator_mutu_id',
        'tahun_akademik_id',
        'program_studi_id',
        'nilai_target',
        'ambang_kuning',
    ];

    protected function casts(): array
    {
        return [
            'nilai_target' => 'decimal:2',
            'ambang_kuning' => 'decimal:2',
        ];
    }

    public function indikatorMutu(): BelongsTo
    {
        return $this->belongsTo(IndikatorMutu::class, 'indikator_mutu_id');
    }

    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
}
