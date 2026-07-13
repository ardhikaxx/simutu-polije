<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenMutuVersion extends Model
{
    use HasFactory;

    protected $table = 'dokumen_mutu_versions';

    protected $fillable = [
        'dokumen_mutu_id',
        'nomor_versi',
        'file_path',
        'file_size',
        'catatan_revisi',
        'dibuat_oleh',
    ];

    public function dokumenMutu(): BelongsTo
    {
        return $this->belongsTo(DokumenMutu::class, 'dokumen_mutu_id');
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
