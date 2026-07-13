<?php

namespace App\Services\Report;

use App\Models\HasilAudit;
use App\Models\JadwalAudit;
use App\Models\PeriodeAudit;
use App\Models\PpeppSiklus;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class ReportGeneratorService
{
    public function generateLaporanPPEPP(PpeppSiklus $siklus): string
    {
        $siklus->load([
            'standarMutu.kategoriStandar',
            'tahunAkademik',
            'ppeppPelaksanaan.programStudi',
        ]);

        $data = [
            'siklus' => $siklus,
            'standar' => $siklus->standarMutu,
            'tahunAkademik' => $siklus->tahunAkademik,
            'pelaksanaan' => $siklus->ppeppPelaksanaan,
            'tanggalCetak' => now()->format('d/m/Y'),
            'judulLaporan' => 'Laporan Siklus PPEPP - ' . $siklus->standarMutu->nama_standar,
        ];

        $pdf = Pdf::loadView('laporan.pempepp', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->output();
    }

    public function generateLaporanAudit(PeriodeAudit $periode): string
    {
        $jadwalAudits = JadwalAudit::where('periode_audit_id', $periode->id)
            ->with(['programStudi', 'unitKerja', 'hasilAudit.temuanAudit'])
            ->get();

        $totalAudit = $jadwalAudits->count();
        $auditSelesai = $jadwalAudits->where('status', 'Selesai')->count();

        $hasilAudits = HasilAudit::whereIn('jadwal_audit_id', $jadwalAudits->pluck('id'))
            ->get();

        $totalTemuan = $hasilAudits->sum(fn($h) => $h->temuanAudit->count());
        $temuanMayor = $hasilAudits->sum(fn($h) => $h->temuanAudit->where('kategori_temuan', 'Mayor')->count());
        $temuanMinor = $hasilAudits->sum(fn($h) => $h->temuanAudit->where('kategori_temuan', 'Minor')->count());
        $temuanObservasi = $hasilAudits->sum(fn($h) => $h->temuanAudit->where('kategori_temuan', 'Observasi')->count());
        $rataRataSkor = $hasilAudits->avg('total_skor');

        $data = [
            'periode' => $periode,
            'jadwalAudits' => $jadwalAudits,
            'totalAudit' => $totalAudit,
            'auditSelesai' => $auditSelesai,
            'totalTemuan' => $totalTemuan,
            'temuanMayor' => $temuanMayor,
            'temuanMinor' => $temuanMinor,
            'temuanObservasi' => $temuanObservasi,
            'rataRataSkor' => $rataRataSkor ? number_format($rataRataSkor, 2) : '0.00',
            'tanggalCetak' => now()->format('d/m/Y'),
            'judulLaporan' => 'Laporan Audit Mutu Internal - ' . $periode->nama,
        ];

        $pdf = Pdf::loadView('laporan.audit', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->output();
    }
}
