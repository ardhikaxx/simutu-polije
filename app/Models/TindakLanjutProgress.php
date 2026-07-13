<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TindakLanjutProgress extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjut_progress';

    protected $fillable = [
        'tindak_lanjut_temuan_id',
        'keterangan_progress',
        'file_bukti',
        'dilaporkan_oleh',
        'diverifikasi_oleh',
        'status_verifikasi',
    ];

    public function tindakLanjutTemuan(): BelongsTo
    {
        return $this->belongsTo(TindakLanjutTemuan::class, 'tindak_lanjut_temuan_id');
    }

    public function dilaporkanOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dilaporkan_oleh');
    }

    public function diverifikasiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}
