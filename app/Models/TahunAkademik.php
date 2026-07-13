<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAkademik extends Model
{
    use HasFactory;

    protected $table = 'tahun_akademik';

    protected $fillable = [
        'nama',
        'semester',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function periodeAudit(): HasMany
    {
        return $this->hasMany(PeriodeAudit::class, 'tahun_akademik_id');
    }

    public function targetIndikator(): HasMany
    {
        return $this->hasMany(TargetIndikator::class, 'tahun_akademik_id');
    }

    public function capaianIndikator(): HasMany
    {
        return $this->hasMany(CapaianIndikator::class, 'tahun_akademik_id');
    }

    public function ppeppSiklus(): HasMany
    {
        return $this->hasMany(PpeppSiklus::class, 'tahun_akademik_id');
    }

    public function survei(): HasMany
    {
        return $this->hasMany(Survei::class, 'tahun_akademik_id');
    }
}
