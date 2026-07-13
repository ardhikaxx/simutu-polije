<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\PeriodeAudit;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class PeriodeAuditController extends Controller
{
    public function index()
    {
        $periodeAudits = PeriodeAudit::with('tahunAkademik')->latest()->get();

        return view('master-data.periode-audit.index', compact('periodeAudits'));
    }

    public function create()
    {
        $tahunAkademiks = TahunAkademik::orderByDesc('is_active')->orderByDesc('nama')->get();

        return view('master-data.periode-audit.create', compact('tahunAkademiks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        PeriodeAudit::create($validated);

        return redirect()->route('master-data.periode-audit.index')
            ->with('success', 'Periode Audit berhasil ditambahkan.');
    }

    public function edit(PeriodeAudit $periodeAudit)
    {
        $tahunAkademiks = TahunAkademik::orderByDesc('is_active')->orderByDesc('nama')->get();

        return view('master-data.periode-audit.edit', compact('periodeAudit', 'tahunAkademiks'));
    }

    public function update(Request $request, PeriodeAudit $periodeAudit)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $periodeAudit->update($validated);

        return redirect()->route('master-data.periode-audit.index')
            ->with('success', 'Periode Audit berhasil diperbarui.');
    }

    public function destroy(PeriodeAudit $periodeAudit)
    {
        $periodeAudit->delete();

        return redirect()->route('master-data.periode-audit.index')
            ->with('success', 'Periode Audit berhasil dihapus.');
    }
}
