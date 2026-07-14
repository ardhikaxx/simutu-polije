<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateDokumen extends Model
{
    use HasFactory;

    protected $table = 'template_dokumen';

    protected $fillable = [
        'standar_mutu_id',
        'nama_template',
        'deskripsi',
        'jenis_file',
        'ukuran_file',
        'downloads',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'ukuran_file' => 'integer',
            'downloads' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function standarMutu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StandarMutu::class, 'standar_mutu_id');
    }
}
