<?php

namespace App\Services\Audit;

use App\Models\HasilAudit;
use Illuminate\Support\Facades\DB;

class AuditScoringService
{
    public function hitungTotalSkor(HasilAudit $hasil): string
    {
        $details = DB::table('hasil_audit_details')
            ->join('checklist_audit_items', 'hasil_audit_details.checklist_audit_item_id', '=', 'checklist_audit_items.id')
            ->where('hasil_audit_details.hasil_audit_id', $hasil->id)
            ->select(
                DB::raw('SUM(hasil_audit_details.skor_diberikan * checklist_audit_items.bobot_skor) as total_bobot_skor'),
                DB::raw('SUM(checklist_audit_items.bobot_skor) as total_bobot')
            )
            ->first();

        if (!$details || $details->total_bobot == 0) {
            return number_format(0, 2, '.', '');
        }

        $totalSkor = $details->total_bobot_skor / $details->total_bobot;

        $hasil->update(['total_skor' => $totalSkor]);

        return number_format($totalSkor, 2, '.', '');
    }
}
