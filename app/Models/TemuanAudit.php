<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TemuanAudit extends Model
{
    use HasFactory;

    protected $table = 'temuan_audit';

    protected $fillable = [
        'hasil_audit_id',
        'kategori_temuan',
        'tingkat_risiko',
        'deskripsi_temuan',
        'rekomendasi',
        'standar_mutu_id',
    ];

    public function hasilAudit(): BelongsTo
    {
        return $this->belongsTo(HasilAudit::class, 'hasil_audit_id');
    }

    public function standarMutu(): BelongsTo
    {
        return $this->belongsTo(StandarMutu::class, 'standar_mutu_id');
    }

    public function tindakLanjutTemuan(): HasOne
    {
        return $this->hasOne(TindakLanjutTemuan::class, 'temuan_audit_id');
    }
}
