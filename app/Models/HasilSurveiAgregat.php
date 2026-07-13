<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilSurveiAgregat extends Model
{
    use HasFactory;

    protected $table = 'hasil_survei_agregat';

    protected $fillable = [
        'survei_id',
        'program_studi_id',
        'indeks_kepuasan',
        'jumlah_responden',
        'dihitung_pada',
    ];

    protected function casts(): array
    {
        return [
            'indeks_kepuasan' => 'decimal:2',
            'dihitung_pada' => 'datetime',
        ];
    }

    public function survei(): BelongsTo
    {
        return $this->belongsTo(Survei::class, 'survei_id');
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
}
