<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriDokumen extends Model
{
    use HasFactory;

    protected $table = 'kategori_dokumen';

    protected $fillable = [
        'nama',
        'prefix_nomor',
    ];

    public function dokumenMutu(): HasMany
    {
        return $this->hasMany(DokumenMutu::class, 'kategori_dokumen_id');
    }

    public function approvalWorkflow(): HasMany
    {
        return $this->hasMany(ApprovalWorkflow::class, 'kategori_dokumen_id');
    }
}
