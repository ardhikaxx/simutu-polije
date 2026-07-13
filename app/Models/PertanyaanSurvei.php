<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PertanyaanSurvei extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_survei';

    protected $fillable = [
        'survei_id',
        'teks_pertanyaan',
        'tipe_jawaban',
        'urutan',
    ];

    public function survei(): BelongsTo
    {
        return $this->belongsTo(Survei::class, 'survei_id');
    }

    public function jawabanSurvei(): HasMany
    {
        return $this->hasMany(JawabanSurvei::class, 'pertanyaan_survei_id');
    }
}
