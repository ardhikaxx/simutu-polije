<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimAudit extends Model
{
    use HasFactory;

    protected $table = 'tim_audit';

    protected $fillable = [
        'jadwal_audit_id',
        'user_id',
        'peran_dalam_tim',
    ];

    public function jadwalAudit(): BelongsTo
    {
        return $this->belongsTo(JadwalAudit::class, 'jadwal_audit_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
