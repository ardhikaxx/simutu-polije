<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilAuditDetail extends Model
{
    use HasFactory;

    protected $table = 'hasil_audit_detail';

    protected $fillable = [
        'hasil_audit_id',
        'checklist_audit_item_id',
        'skor_diberikan',
        'catatan_auditor',
    ];

    protected function casts(): array
    {
        return [
            'skor_diberikan' => 'decimal:2',
        ];
    }

    public function hasilAudit(): BelongsTo
    {
        return $this->belongsTo(HasilAudit::class, 'hasil_audit_id');
    }

    public function checklistAuditItem(): BelongsTo
    {
        return $this->belongsTo(ChecklistAuditItem::class, 'checklist_audit_item_id');
    }
}
