<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'program_studi';

    protected $fillable = [
        'jurusan_id',
        'nama_prodi',
        'kode_prodi',
        'jenjang',
        'akreditasi_saat_ini',
        'kaprodi_id',
        'status',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(FakultasJurusan::class, 'jurusan_id');
    }

    public function kaprodi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kaprodi_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'program_studi_id');
    }

    public function targetIndikator(): HasMany
    {
        return $this->hasMany(TargetIndikator::class, 'program_studi_id');
    }

    public function capaianIndikator(): HasMany
    {
        return $this->hasMany(CapaianIndikator::class, 'program_studi_id');
    }

    public function ppeppPelaksanaan(): HasMany
    {
        return $this->hasMany(PpeppPelaksanaan::class, 'program_studi_id');
    }

    public function jadwalAudit(): HasMany
    {
        return $this->hasMany(JadwalAudit::class, 'program_studi_id');
    }
}
