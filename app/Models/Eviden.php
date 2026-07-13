<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Eviden extends Model
{
    use HasFactory;

    protected $table = 'eviden';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'tipe_file',
        'diunggah_oleh',
    ];

    public function evidenable(): MorphTo
    {
        return $this->morphTo();
    }

    public function diunggahOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diunggah_oleh');
    }
}
