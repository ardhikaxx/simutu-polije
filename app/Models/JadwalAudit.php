<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalAudit extends Model
{
    use HasFactory;

    protected $table = 'jadwal_audit';

    protected $fillable = [
        'periode_audit_id',
        'program_studi_id',
        'unit_kerja_id',
        'tanggal_audit',
        'jenis_audit',
        'status',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_audit' => 'date',
        ];
    }

    public function periodeAudit(): BelongsTo
    {
        return $this->belongsTo(PeriodeAudit::class, 'periode_audit_id');
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function timAudit(): HasMany
    {
        return $this->hasMany(TimAudit::class, 'jadwal_audit_id');
    }

    public function hasilAudit(): HasMany
    {
        return $this->hasMany(HasilAudit::class, 'jadwal_audit_id');
    }
}
