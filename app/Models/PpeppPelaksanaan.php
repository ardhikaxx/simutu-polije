<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PpeppPelaksanaan extends Model
{
    use HasFactory;

    protected $table = 'ppepp_pelaksanaan';

    protected $fillable = [
        'ppepp_siklus_id',
        'program_studi_id',
        'unit_kerja_id',
        'deskripsi_implementasi',
        'tanggal_pelaksanaan',
        'status',
        'diisi_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pelaksanaan' => 'date',
        ];
    }

    public function ppeppSiklus(): BelongsTo
    {
        return $this->belongsTo(PpeppSiklus::class, 'ppepp_siklus_id');
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function diisiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diisi_oleh');
    }

    public function eviden(): MorphMany
    {
        return $this->morphMany(Eviden::class, 'evidenable');
    }
}
