<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HasilAudit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hasil_audit';

    protected $fillable = [
        'jadwal_audit_id',
        'checklist_audit_template_id',
        'total_skor',
        'kesimpulan',
        'status',
        'berita_acara_file',
        'ditandatangani_oleh',
    ];

    protected function casts(): array
    {
        return [
            'total_skor' => 'decimal:2',
            'ditandatangani_oleh' => 'array',
        ];
    }

    public function jadwalAudit(): BelongsTo
    {
        return $this->belongsTo(JadwalAudit::class, 'jadwal_audit_id');
    }

    public function checklistAuditTemplate(): BelongsTo
    {
        return $this->belongsTo(ChecklistAuditTemplate::class, 'checklist_audit_template_id');
    }

    public function hasilAuditDetails(): HasMany
    {
        return $this->hasMany(HasilAuditDetail::class, 'hasil_audit_id');
    }

    public function temuanAudit(): HasMany
    {
        return $this->hasMany(TemuanAudit::class, 'hasil_audit_id');
    }

    public function approvalHistories(): MorphMany
    {
        return $this->morphMany(ApprovalHistory::class, 'approvable');
    }

    public function digitalSignatures(): MorphMany
    {
        return $this->morphMany(DigitalSignature::class, 'approvable');
    }
}
