<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\PeriodeAudit;
use App\Models\PpeppSiklus;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $ppeppSikluses = PpeppSiklus::with(['standarMutu', 'tahunAkademik'])->latest()->get();
        $periodeAudits = PeriodeAudit::with('tahunAkademik')->latest()->get();

        return view('laporan.index', compact('ppeppSikluses', 'periodeAudits'));
    }

    public function ppepp(PpeppSiklus $siklus)
    {
        $siklus->load(['standarMutu', 'tahunAkademik', 'ppeppPelaksanaan', 'ppeppEvaluasi']);

        return view('laporan.ppepp', compact('siklus'));
    }

    public function audit(PeriodeAudit $periode)
    {
        $periode->load(['jadwalAudit.hasilAudit', 'tahunAkademik']);

        return view('laporan.audit', compact('periode'));
    }

    public function indikator()
    {
        $tahunAkademikAktif = \App\Models\TahunAkademik::where('is_active', true)->first();

        return view('laporan.indikator', compact('tahunAkademikAktif'));
    }

    public function downloadPdf($type, $id)
    {
        return redirect()->route('laporan.index')
            ->with('success', "PDF Laporan {$type} akan segera diunduh.");
    }

    public function downloadExcel($type, $id)
    {
        return redirect()->route('laporan.index')
            ->with('success', "Excel Laporan {$type} akan segera diunduh.");
    }
}
