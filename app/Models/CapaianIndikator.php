<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CapaianIndikator extends Model
{
    use HasFactory;

    protected $table = 'capaian_indikator';

    protected $fillable = [
        'indikator_mutu_id',
        'tahun_akademik_id',
        'program_studi_id',
        'nilai_capaian',
        'status_warna',
        'sumber_input',
        'dihitung_pada',
        'dihitung_oleh',
    ];

    protected function casts(): array
    {
        return [
            'nilai_capaian' => 'decimal:2',
            'dihitung_pada' => 'datetime',
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

    public function dihitungOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
