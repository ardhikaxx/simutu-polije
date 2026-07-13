<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StandarMutu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'standar_mutu';

    protected $fillable = [
        'kategori_standar_id',
        'kode_standar',
        'nama_standar',
        'deskripsi',
        'dasar_hukum',
        'unit_terdampak',
        'status',
        'versi_aktif_id',
        'dibuat_oleh',
        'disahkan_oleh',
        'tanggal_berlaku',
    ];

    protected function casts(): array
    {
        return [
            'unit_terdampak' => 'array',
            'tanggal_berlaku' => 'date',
        ];
    }

    public function kategoriStandar(): BelongsTo
    {
        return $this->belongsTo(KategoriStandar::class, 'kategori_standar_id');
    }

    public function versiAktif(): BelongsTo
    {
        return $this->belongsTo(StandarMutuVersion::class, 'versi_aktif_id');
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function disahkanOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disahkan_oleh');
    }

    public function standarMutuVersions(): HasMany
    {
        return $this->hasMany(StandarMutuVersion::class, 'standar_mutu_id');
    }

    public function indikatorMutu(): HasMany
    {
        return $this->hasMany(IndikatorMutu::class, 'standar_mutu_id');
    }

    public function ppeppSiklus(): HasMany
    {
        return $this->hasMany(PpeppSiklus::class, 'standar_mutu_id');
    }
}
