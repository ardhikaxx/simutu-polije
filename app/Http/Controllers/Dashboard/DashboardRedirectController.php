<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CapaianIndikator;
use App\Models\DokumenMutu;
use App\Models\IndikatorMutu;
use App\Models\JadwalAudit;
use App\Models\PpeppSiklus;
use App\Models\ProgramStudi;
use App\Models\StandarMutu;
use App\Models\Survei;
use App\Models\TahunAkademik;
use App\Models\TindakLanjutTemuan;
use App\Models\User;

class DashboardRedirectController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            $stats = [
                'totalUser' => User::count(),
                'standarMutuAktif' => StandarMutu::where('status', 'Published')->count(),
                'dokumenMutu' => DokumenMutu::count(),
                'auditBerjalan' => JadwalAudit::whereIn('status', ['Draft', 'Terjadwal', 'Berlangsung'])->count(),
                'tindakLanjutOpen' => TindakLanjutTemuan::whereIn('status', ['Open', 'On Progress'])->count(),
                'surveiAktif' => Survei::where('status', 'Aktif')->count(),
                'totalProdi' => ProgramStudi::count(),
            ];

            // Real chart data from DB
            $tahunAkademikList = TahunAkademik::orderBy('nama')->get();
            $chartLabels = $tahunAkademikList->pluck('nama')->toArray();

            // Capaian rata-rata per tahun akademik
            $chartCapaian = [];
            $chartTarget = [];
            foreach ($tahunAkademikList as $ta) {
                $avgCapaian = CapaianIndikator::where('tahun_akademik_id', $ta->id)->avg('nilai_capaian');
                $avgTarget = \App\Models\TargetIndikator::where('tahun_akademik_id', $ta->id)->avg('nilai_target');
                $chartCapaian[] = $avgCapaian ? round($avgCapaian, 1) : 0;
                $chartTarget[] = $avgTarget ? round($avgTarget, 1) : 0;
            }

            // Radar chart: capaian rata-rata per standar mutu (tahun akademik aktif)
            $taAktif = TahunAkademik::where('is_active', true)->first();
            $radarLabels = [];
            $radarData = [];
            $radarTarget = [];
            if ($taAktif) {
                $standars = StandarMutu::where('status', 'Published')->with('indikatorMutu')->get();
                foreach ($standars as $sm) {
                    $radarLabels[] = $sm->kode_standar;
                    $indIds = $sm->indikatorMutu->pluck('id');
                    $avgCap = CapaianIndikator::where('tahun_akademik_id', $taAktif->id)
                        ->whereIn('indikator_mutu_id', $indIds)
                        ->avg('nilai_capaian');
                    $avgTgt = \App\Models\TargetIndikator::where('tahun_akademik_id', $taAktif->id)
                        ->whereIn('indikator_mutu_id', $indIds)
                        ->avg('nilai_target');
                    $radarData[] = $avgCap ? round($avgCap, 1) : 0;
                    $radarTarget[] = $avgTgt ? round($avgTgt, 1) : 0;
                }
            }

            // PPEPP status distribution
            $ppeppStatus = PpeppSiklus::selectRaw('status_siklus, count(*) as total')
                ->groupBy('status_siklus')
                ->pluck('total', 'status_siklus')
                ->toArray();

            return view('dashboard.super-admin', compact(
                'stats', 'chartLabels', 'chartCapaian', 'chartTarget',
                'radarLabels', 'radarData', 'radarTarget', 'ppeppStatus'
            ));
        }

        if ($user->hasRole('admin_spmi')) {
            return view('dashboard.admin-spmi');
        }

        if ($user->hasRole('kajur')) {
            return view('dashboard.kajur');
        }

        if ($user->hasRole('kaprodi')) {
            return view('dashboard.kaprodi');
        }

        if ($user->hasRole('gpm')) {
            return view('dashboard.gpm');
        }

        if ($user->hasRole('auditor') || $user->hasRole('auditor_ketua')) {
            return view('dashboard.auditor');
        }

        if ($user->hasRole('dosen')) {
            return view('dashboard.dosen');
        }

        if ($user->hasRole('tendik')) {
            return view('dashboard.tendik');
        }

        if ($user->hasRole('pimpinan')) {
            $taAktif = TahunAkademik::where('is_active', true)->first();

            $stats = [
                'totalStandar' => StandarMutu::where('status', 'Published')->count(),
                'totalAuditSelesai' => JadwalAudit::where('status', 'Selesai')->count(),
                'totalAuditBerjalan' => JadwalAudit::whereIn('status', ['Draft', 'Terjadwal', 'Berlangsung'])->count(),
                'totalTemuanOpen' => \App\Models\TemuanAudit::whereHas('jadwalAudit', fn($q) => $q->where('status', '!=', 'Selesai'))->count(),
                'totalTLOpen' => TindakLanjutTemuan::whereIn('status', ['Open', 'On Progress'])->count(),
                'totalTLSelesai' => TindakLanjutTemuan::where('status', 'Closed')->count(),
                'totalTL' => TindakLanjutTemuan::count(),
                'totalDokumen' => DokumenMutu::count(),
                'totalSurvei' => Survei::count(),
            ];

            // Trend capaian per tahun akademik (3 tahun terakhir)
            $taList = TahunAkademik::orderBy('nama', 'desc')->take(6)->get()->reverse();
            $chartLabels = $taList->pluck('nama')->toArray();
            $chartCapaian = [];
            $chartTarget = [];
            foreach ($taList as $ta) {
                $avgCap = CapaianIndikator::where('tahun_akademik_id', $ta->id)->avg('nilai_capaian');
                $avgTgt = \App\Models\TargetIndikator::where('tahun_akademik_id', $ta->id)->avg('nilai_target');
                $chartCapaian[] = $avgCap ? round($avgCap, 1) : 0;
                $chartTarget[] = $avgTgt ? round($avgTgt, 1) : 0;
            }

            // Radar per standar
            $radarLabels = [];
            $radarData = [];
            $radarTarget = [];
            $alertRed = [];
            if ($taAktif) {
                $standars = StandarMutu::where('status', 'Published')->with('indikatorMutu')->get();
                foreach ($standars as $sm) {
                    $radarLabels[] = $sm->kode_standar;
                    $indIds = $sm->indikatorMutu->pluck('id');
                    $avgCap = CapaianIndikator::where('tahun_akademik_id', $taAktif->id)
                        ->whereIn('indikator_mutu_id', $indIds)->avg('nilai_capaian');
                    $avgTgt = \App\Models\TargetIndikator::where('tahun_akademik_id', $taAktif->id)
                        ->whereIn('indikator_mutu_id', $indIds)->avg('nilai_target');
                    $capVal = $avgCap ? round($avgCap, 1) : 0;
                    $tgtVal = $avgTgt ? round($avgTgt, 1) : 0;
                    $radarData[] = $capVal;
                    $radarTarget[] = $tgtVal;
                    if ($tgtVal > 0 && $capVal > 0 && $capVal < ($tgtVal * 0.7)) {
                        $alertRed[] = "{$sm->kode_standar} ({$sm->nama_standar}): capaian {$capVal}% vs target {$tgtVal}%";
                    }
                }
            }

            // TL status for bar chart
            $tlStatus = TindakLanjutTemuan::selectRaw('status, count(*) as total')
                ->groupBy('status')->pluck('total', 'status')->toArray();

            return view('dashboard.pimpinan', compact(
                'stats', 'chartLabels', 'chartCapaian', 'chartTarget',
                'radarLabels', 'radarData', 'radarTarget', 'alertRed', 'tlStatus'
            ));
        }

        if ($user->hasRole('mahasiswa')) {
            return view('dashboard.mahasiswa');
        }

        if ($user->hasRole('alumni')) {
            return view('dashboard.alumni');
        }

        if ($user->hasRole('mitra_industri')) {
            return view('dashboard.mitra');
        }

        return view('dashboard.default');
    }
}
