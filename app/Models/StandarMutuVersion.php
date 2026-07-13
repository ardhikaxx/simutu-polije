<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StandarMutuVersion extends Model
{
    use HasFactory;

    protected $table = 'standar_mutu_versions';

    protected $fillable = [
        'standar_mutu_id',
        'nomor_versi',
        'konten_lengkap',
        'file_pendukung',
        'alasan_revisi',
        'dibuat_oleh',
    ];

    public function standarMutu(): BelongsTo
    {
        return $this->belongsTo(StandarMutu::class, 'standar_mutu_id');
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
