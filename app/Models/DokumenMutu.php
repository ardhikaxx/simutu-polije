<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumenMutu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_mutu';

    protected $fillable = [
        'kategori_dokumen_id',
        'nomor_dokumen',
        'judul',
        'program_studi_id',
        'unit_kerja_id',
        'standar_mutu_id',
        'status',
        'versi_aktif_id',
        'tanggal_berlaku',
        'tanggal_kedaluwarsa',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_berlaku' => 'date',
            'tanggal_kedaluwarsa' => 'date',
        ];
    }

    public function kategoriDokumen(): BelongsTo
    {
        return $this->belongsTo(KategoriDokumen::class, 'kategori_dokumen_id');
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function standarMutu(): BelongsTo
    {
        return $this->belongsTo(StandarMutu::class, 'standar_mutu_id');
    }

    public function versiAktif(): BelongsTo
    {
        return $this->belongsTo(DokumenMutuVersion::class, 'versi_aktif_id');
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function dokumenMutuVersions(): HasMany
    {
        return $this->hasMany(DokumenMutuVersion::class, 'dokumen_mutu_id');
    }

    public function approvalHistories(): MorphMany
    {
        return $this->morphMany(ApprovalHistory::class, 'approvable');
    }

    public function digitalSignatures(): MorphMany
    {
        return $this->morphMany(DigitalSignature::class, 'approvable');
    }
}
