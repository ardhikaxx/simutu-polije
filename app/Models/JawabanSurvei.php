<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanSurvei extends Model
{
    use HasFactory;

    protected $table = 'jawaban_survei';

    protected $fillable = [
        'survei_id',
        'pertanyaan_survei_id',
        'responden_id',
        'nilai_jawaban',
        'teks_jawaban',
    ];

    public function survei(): BelongsTo
    {
        return $this->belongsTo(Survei::class, 'survei_id');
    }

    public function pertanyaanSurvei(): BelongsTo
    {
        return $this->belongsTo(PertanyaanSurvei::class, 'pertanyaan_survei_id');
    }

    public function responden(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responden_id');
    }
}
