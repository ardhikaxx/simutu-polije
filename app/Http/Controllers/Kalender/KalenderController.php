<?php

namespace App\Http\Controllers\Kalender;

use App\Http\Controllers\Controller;
use App\Models\HasilAudit;
use App\Models\JadwalAudit;
use App\Models\PeriodeAudit;
use App\Models\PpeppPelaksanaan;
use App\Models\Survei;
use App\Models\TindakLanjutTemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KalenderController extends Controller
{
    public function index()
    {
        return view('kalender.index');
    }

    public function events(Request $request)
    {
        $events = [];

        JadwalAudit::with(['programStudi', 'periodeAudit'])
            ->whereNotNull('tanggal_audit')
            ->get()
            ->each(function ($jadwal) use (&$events) {
                $events[] = [
                    'title' => 'Audit: ' . ($jadwal->programStudi->nama_prodi ?? 'Umum'),
                    'start' => $jadwal->tanggal_audit->format('Y-m-d'),
                    'color' => '#1565c0',
                    'icon' => 'fa-clipboard-check',
                    'url' => route('jadwal-audit.show', $jadwal),
                    'type' => 'jadwal_audit',
                    'description' => 'Jenis: ' . $jadwal->jenis_audit . ' | Status: ' . $jadwal->status,
                ];
            });

        TindakLanjutTemuan::with(['temuanAudit.hasilAudit.jadwalAudit.programStudi', 'penanggungJawab'])
            ->whereNotNull('target_selesai')
            ->get()
            ->each(function ($tl) use (&$events) {
                $events[] = [
                    'title' => 'TL: ' . Str::limit($tl->penanggungJawab->nama ?? '-', 20),
                    'start' => $tl->target_selesai->format('Y-m-d'),
                    'color' => '#e53935',
                    'icon' => 'fa-tasks',
                    'url' => route('tindak-lanjut.show', $tl),
                    'type' => 'tindak_lanjut',
                    'description' => 'Status: ' . $tl->status . ' | Kategori: ' . ($tl->temuanAudit->kategori_temuan ?? '-'),
                ];
            });

        PeriodeAudit::whereNotNull('tanggal_mulai')
            ->whereNotNull('tanggal_selesai')
            ->get()
            ->each(function ($periode) use (&$events) {
                $events[] = [
                    'title' => 'Periode: ' . $periode->nama,
                    'start' => $periode->tanggal_mulai->format('Y-m-d'),
                    'end' => $periode->tanggal_selesai->addDay()->format('Y-m-d'),
                    'color' => '#f9a825',
                    'icon' => 'fa-calendar-check',
                    'type' => 'periode_audit',
                    'description' => 'Status: ' . $periode->status,
                    'allDay' => true,
                ];
            });

        Survei::whereNotNull('tanggal_mulai')
            ->whereNotNull('tanggal_selesai')
            ->get()
            ->each(function ($survei) use (&$events) {
                $events[] = [
                    'title' => 'Survei: ' . Str::limit($survei->judul, 30),
                    'start' => $survei->tanggal_mulai->format('Y-m-d'),
                    'end' => $survei->tanggal_selesai->addDay()->format('Y-m-d'),
                    'color' => '#2e7d32',
                    'icon' => 'fa-poll',
                    'type' => 'survei',
                    'description' => 'Status: ' . $survei->status,
                    'allDay' => true,
                ];
            });

        return response()->json($events);
    }
}
