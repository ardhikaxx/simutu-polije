<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalWorkflow extends Model
{
    use HasFactory;

    protected $table = 'approval_workflows';

    protected $fillable = [
        'kategori_dokumen_id',
        'nama_alur',
        'urutan_step',
    ];

    protected function casts(): array
    {
        return [
            'urutan_step' => 'array',
        ];
    }

    public function kategoriDokumen(): BelongsTo
    {
        return $this->belongsTo(KategoriDokumen::class, 'kategori_dokumen_id');
    }
}
