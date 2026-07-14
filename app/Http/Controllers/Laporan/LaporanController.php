<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\Laporan\AuditExport;
use App\Exports\Laporan\IndikatorExport;
use App\Exports\Laporan\PpeppExport;
use App\Http\Controllers\Controller;
use App\Models\IndikatorMutu;
use App\Models\PeriodeAudit;
use App\Models\PpeppSiklus;
use App\Models\TahunAkademik;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $tahunAkademikAktif = TahunAkademik::where('is_active', true)->first();
        $indikators = IndikatorMutu::with(['standarMutu', 'targetIndikator', 'capaianIndikator'])->latest()->get();

        return view('laporan.indikator', compact('tahunAkademikAktif', 'indikators'));
    }

    public function downloadPdf($type, $id)
    {
        $filename = "laporan_{$type}_" . date('Y-m-d') . '.pdf';

        if ($type === 'ppepp') {
            $siklus = PpeppSiklus::with(['standarMutu', 'tahunAkademik', 'ppeppPelaksanaan.programStudi', 'ppeppPelaksanaan.unitKerja'])->findOrFail($id);
            $pdf = Pdf::loadView('laporan.pdf.ppepp', compact('siklus'))
                ->setPaper('a4', 'landscape');
        } elseif ($type === 'audit') {
            $periode = PeriodeAudit::with(['jadwalAudit.programStudi', 'jadwalAudit.hasilAudit', 'tahunAkademik'])->findOrFail($id);
            $pdf = Pdf::loadView('laporan.pdf.audit', compact('periode'))
                ->setPaper('a4', 'landscape');
        } else {
            $tahunAkademikAktif = TahunAkademik::where('is_active', true)->first();
            $indikators = IndikatorMutu::with(['standarMutu', 'targetIndikator', 'capaianIndikator'])->latest()->get();
            $pdf = Pdf::loadView('laporan.pdf.indikator', compact('tahunAkademikAktif', 'indikators'))
                ->setPaper('a4', 'landscape');
        }

        return $pdf->download($filename);
    }

    public function downloadExcel($type, $id)
    {
        $filename = "laporan_{$type}_" . date('Y-m-d') . '.xlsx';

        if ($type === 'ppepp') {
            $siklus = PpeppSiklus::findOrFail($id);
            return Excel::download(new PpeppExport($siklus), $filename);
        } elseif ($type === 'audit') {
            $periode = PeriodeAudit::findOrFail($id);
            return Excel::download(new AuditExport($periode), $filename);
        }

        return Excel::download(new IndikatorExport, $filename);
    }
}
