<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survei extends Model
{
    use HasFactory;

    protected $table = 'survei';

    protected $fillable = [
        'jenis_survei_id',
        'judul',
        'tahun_akademik_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function jenisSurvei(): BelongsTo
    {
        return $this->belongsTo(JenisSurvei::class, 'jenis_survei_id');
    }

    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function pertanyaanSurvei(): HasMany
    {
        return $this->hasMany(PertanyaanSurvei::class, 'survei_id');
    }

    public function jawabanSurvei(): HasMany
    {
        return $this->hasMany(JawabanSurvei::class, 'survei_id');
    }

    public function hasilSurveiAgregat(): HasMany
    {
        return $this->hasMany(HasilSurveiAgregat::class, 'survei_id');
    }
}
