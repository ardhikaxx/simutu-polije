<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistAuditItem extends Model
{
    use HasFactory;

    protected $table = 'checklist_audit_item';

    protected $fillable = [
        'checklist_audit_template_id',
        'pertanyaan',
        'bobot_skor',
        'indikator_mutu_id',
    ];

    protected function casts(): array
    {
        return [
            'bobot_skor' => 'decimal:2',
        ];
    }

    public function checklistAuditTemplate(): BelongsTo
    {
        return $this->belongsTo(ChecklistAuditTemplate::class, 'checklist_audit_template_id');
    }

    public function indikatorMutu(): BelongsTo
    {
        return $this->belongsTo(IndikatorMutu::class, 'indikator_mutu_id');
    }
}
