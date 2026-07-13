<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;
use App\Models\HasilAudit;
use App\Models\HasilAuditDetail;
use App\Models\JadwalAudit;
use App\Models\TemuanAudit;
use Illuminate\Http\Request;

class HasilAuditController extends Controller
{
    public function index(Request $request)
    {
        $query = HasilAudit::with(['jadwalAudit.programStudi', 'jadwalAudit.periodeAudit', 'checklistAuditTemplate']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $hasilAudits = $query->latest()->get();

        return view('audit.hasil', compact('hasilAudits'));
    }

    public function show(HasilAudit $hasil)
    {
        $hasil->load([
            'jadwalAudit.programStudi',
            'jadwalAudit.periodeAudit',
            'jadwalAudit.timAudit.user',
            'checklistAuditTemplate',
            'hasilAuditDetails',
            'temuanAudit',
            'approvalHistories',
        ]);

        return view('audit.hasil-show', compact('hasil'));
    }

    public function checklist(JadwalAudit $jadwal)
    {
        $jadwal->load(['programStudi', 'periodeAudit']);

        $templates = \App\Models\ChecklistAuditTemplate::with('checklistAuditItems')->get();

        return view('audit.checklist', compact('jadwal', 'templates'));
    }

    public function submitChecklist(Request $request, JadwalAudit $jadwal)
    {
        $validated = $request->validate([
            'checklist_audit_template_id' => 'required|exists:checklist_audit_template,id',
            'items' => 'required|array',
            'items.*.checklist_item_id' => 'required|exists:checklist_audit_item,id',
            'items.*.skor_diberikan' => 'required|numeric|min:0|max:100',
            'items.*.catatan_auditor' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
        ]);

        $totalSkor = collect($validated['items'])->avg('skor_diberikan');

        $hasil = HasilAudit::create([
            'jadwal_audit_id' => $jadwal->id,
            'checklist_audit_template_id' => $validated['checklist_audit_template_id'],
            'total_skor' => $totalSkor,
            'kesimpulan' => $validated['kesimpulan'] ?? null,
            'status' => 'Draft',
        ]);

        foreach ($validated['items'] as $item) {
            HasilAuditDetail::create([
                'hasil_audit_id' => $hasil->id,
                'checklist_audit_item_id' => $item['checklist_item_id'],
                'skor_diberikan' => $item['skor_diberikan'],
                'catatan_auditor' => $item['catatan_auditor'] ?? null,
            ]);
        }

        $jadwal->update(['status' => 'Selesai']);

        return redirect()->route('audit.hasil.show', $hasil)
            ->with('success', 'Hasil checklist berhasil disimpan.');
    }

    public function approve(HasilAudit $hasil)
    {
        $hasil->update(['status' => 'Disetujui']);

        return redirect()->route('audit.hasil.show', $hasil)
            ->with('success', 'Hasil audit berhasil disetujui.');
    }
}
