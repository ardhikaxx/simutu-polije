<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PpeppSiklus extends Model
{
    use HasFactory;

    protected $table = 'ppepp_siklus';

    protected $fillable = [
        'standar_mutu_id',
        'tahun_akademik_id',
        'tahap_sekarang',
        'status_siklus',
    ];

    public function standarMutu(): BelongsTo
    {
        return $this->belongsTo(StandarMutu::class, 'standar_mutu_id');
    }

    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function ppeppPelaksanaan(): HasMany
    {
        return $this->hasMany(PpeppPelaksanaan::class, 'ppepp_siklus_id');
    }

    public function ppeppEvaluasi(): HasMany
    {
        return $this->hasMany(PpeppEvaluasi::class, 'ppepp_siklus_id');
    }
}
