<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriStandar extends Model
{
    use HasFactory;

    protected $table = 'kategori_standar';

    protected $fillable = [
        'nama',
        'urutan',
    ];

    public function standarMutu(): HasMany
    {
        return $this->hasMany(StandarMutu::class, 'kategori_standar_id');
    }
}
