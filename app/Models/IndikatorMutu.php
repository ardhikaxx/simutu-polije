<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IndikatorMutu extends Model
{
    use HasFactory;

    protected $table = 'indikator_mutu';

    protected $fillable = [
        'standar_mutu_id',
        'nama_indikator',
        'definisi_operasional',
        'satuan',
        'formula_perhitungan',
        'sumber_data',
        'frekuensi_pengukuran',
        'penanggung_jawab_role',
    ];

    public function standarMutu(): BelongsTo
    {
        return $this->belongsTo(StandarMutu::class, 'standar_mutu_id');
    }

    public function targetIndikator(): HasMany
    {
        return $this->hasMany(TargetIndikator::class, 'indikator_mutu_id');
    }

    public function capaianIndikator(): HasMany
    {
        return $this->hasMany(CapaianIndikator::class, 'indikator_mutu_id');
    }
}
