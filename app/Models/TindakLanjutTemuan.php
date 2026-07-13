<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TindakLanjutTemuan extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjut_temuan';

    protected $fillable = [
        'temuan_audit_id',
        'penanggung_jawab_id',
        'rencana_tindak_lanjut',
        'target_selesai',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'target_selesai' => 'date',
        ];
    }

    public function temuanAudit(): BelongsTo
    {
        return $this->belongsTo(TemuanAudit::class, 'temuan_audit_id');
    }

    public function penanggungJawab(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }

    public function tindakLanjutProgress(): HasMany
    {
        return $this->hasMany(TindakLanjutProgress::class, 'tindak_lanjut_temuan_id');
    }
}
