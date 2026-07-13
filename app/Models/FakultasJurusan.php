<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FakultasJurusan extends Model
{
    use HasFactory;

    protected $table = 'fakultas_jurusan';

    protected $fillable = [
        'nama_jurusan',
        'kode_jurusan',
        'ketua_jurusan_id',
        'status',
    ];

    public function ketuaJurusan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ketua_jurusan_id');
    }

    public function programStudi(): HasMany
    {
        return $this->hasMany(ProgramStudi::class, 'jurusan_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'jurusan_id');
    }
}
