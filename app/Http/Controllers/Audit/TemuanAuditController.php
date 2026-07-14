<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;
use App\Models\HasilAudit;
use App\Models\TemuanAudit;
use Illuminate\Http\Request;

class TemuanAuditController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hasil_audit_id' => 'required|exists:hasil_audit,id',
            'kategori_temuan' => 'required|in:Observasi,Minor,Major',
            'tingkat_risiko' => 'required|in:Rendah,Sedang,Tinggi',
            'deskripsi_temuan' => 'required|string',
            'rekomendasi' => 'nullable|string',
            'standar_mutu_id' => 'nullable|exists:standar_mutu,id',
        ]);

        $validated['kategori_temuan'] = $validated['kategori_temuan'] === 'Major' ? 'Mayor' : $validated['kategori_temuan'];

        TemuanAudit::create($validated);

        return redirect()->route('audit.hasil.show', $validated['hasil_audit_id'])
            ->with('success', 'Temuan Audit berhasil ditambahkan.');
    }

    public function update(Request $request, TemuanAudit $temuan)
    {
        $validated = $request->validate([
            'kategori_temuan' => 'required|in:Observasi,Minor,Major',
            'tingkat_risiko' => 'required|in:Rendah,Sedang,Tinggi',
            'deskripsi_temuan' => 'required|string',
            'rekomendasi' => 'nullable|string',
            'standar_mutu_id' => 'nullable|exists:standar_mutu,id',
        ]);

        $validated['kategori_temuan'] = $validated['kategori_temuan'] === 'Major' ? 'Mayor' : $validated['kategori_temuan'];

        $temuan->update($validated);

        return redirect()->route('audit.hasil.show', $temuan->hasil_audit_id)
            ->with('success', 'Temuan Audit berhasil diperbarui.');
    }
}
