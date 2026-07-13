<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSurvei extends Model
{
    use HasFactory;

    protected $table = 'jenis_survei';

    protected $fillable = [
        'nama',
        'target_responden',
    ];

    public function survei(): HasMany
    {
        return $this->hasMany(Survei::class, 'jenis_survei_id');
    }
}
