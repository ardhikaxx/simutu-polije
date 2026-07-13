<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChecklistAuditTemplate extends Model
{
    use HasFactory;

    protected $table = 'checklist_audit_template';

    protected $fillable = [
        'nama_template',
        'standar_mutu_id',
    ];

    public function standarMutu(): BelongsTo
    {
        return $this->belongsTo(StandarMutu::class, 'standar_mutu_id');
    }

    public function checklistAuditItems(): HasMany
    {
        return $this->hasMany(ChecklistAuditItem::class, 'checklist_audit_template_id');
    }
}
