<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpeppEvaluasi extends Model
{
    use HasFactory;

    protected $table = 'ppepp_evaluasi';

    protected $fillable = [
        'ppepp_siklus_id',
        'capaian_indikator_id',
        'catatan_evaluasi',
        'dievaluasi_oleh',
    ];

    public function ppeppSiklus(): BelongsTo
    {
        return $this->belongsTo(PpeppSiklus::class, 'ppepp_siklus_id');
    }

    public function capaianIndikator(): BelongsTo
    {
        return $this->belongsTo(CapaianIndikator::class, 'capaian_indikator_id');
    }

    public function dievaluasiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dievaluasi_oleh');
    }
}
