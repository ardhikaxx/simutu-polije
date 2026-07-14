<?php

namespace App\Http\Controllers\Ppepp;

use App\Http\Controllers\Controller;
use App\Models\PpeppEvaluasi;
use App\Models\PpeppPelaksanaan;
use App\Models\PpeppSiklus;
use Illuminate\Http\Request;

class PpeppController extends Controller
{
    public function index()
    {
        $sikluses = PpeppSiklus::with(['standarMutu', 'tahunAkademik'])
            ->latest()
            ->get();

        return view('ppepp.index', compact('sikluses'));
    }

    public function show(PpeppSiklus $siklus)
    {
        $siklus->load(['standarMutu', 'tahunAkademik', 'ppeppPelaksanaan.programStudi', 'ppeppPelaksanaan.unitKerja', 'ppeppEvaluasi']);

        $totalPelaksanaan = $siklus->ppeppPelaksanaan->count();
        $completedPelaksanaan = $siklus->ppeppPelaksanaan->where('status', 'Selesai')->count();
        $progressPercent = $totalPelaksanaan > 0 ? round(($completedPelaksanaan / $totalPelaksanaan) * 100) : 0;

        $stages = [
            'penetapan' => ['label' => 'Penetapan', 'icon' => 'fa-bookmark'],
            'pelaksanaan' => ['label' => 'Pelaksanaan', 'icon' => 'fa-cogs'],
            'pengendalian' => ['label' => 'Pengendalian', 'icon' => 'fa-search'],
            'evaluasi' => ['label' => 'Evaluasi', 'icon' => 'fa-chart-bar'],
            'peningkatan' => ['label' => 'Peningkatan', 'icon' => 'fa-arrow-up'],
        ];

        $currentIndex = array_search($siklus->tahap_sekarang, array_keys($stages));

        return view('ppepp.show', compact('siklus', 'progressPercent', 'stages', 'currentIndex'));
    }

    public function pelaksanaan(PpeppSiklus $siklus)
    {
        $siklus->load(['standarMutu', 'ppeppPelaksanaan.programStudi', 'ppeppPelaksanaan.unitKerja', 'ppeppPelaksanaan.diisiOleh', 'ppeppPelaksanaan.eviden']);

        return view('ppepp.pelaksanaan', compact('siklus'));
    }

    public function updatePelaksanaan(Request $request, PpeppPelaksanaan $pelaksanaan)
    {
        $validated = $request->validate([
            'status' => 'required|in:Belum,Proses,Selesai',
            'deskripsi_implementasi' => 'nullable|string',
        ]);

        if ($pelaksanaan->status !== 'Selesai') {
            $validated['diisi_oleh'] = $pelaksanaan->diisi_oleh ?? auth()->id();
        }

        if (!empty($validated['status']) && $validated['status'] === 'Selesai') {
            $validated['tanggal_pelaksanaan'] = now();
        }

        $pelaksanaan->update($validated);

        return redirect()->route('ppepp.pelaksanaan', $pelaksanaan->ppepp_siklus_id)
            ->with('success', 'Status pelaksanaan berhasil diperbarui.');
    }

    public function uploadEviden(Request $request, PpeppPelaksanaan $pelaksanaan)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'required|file|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->store('eviden', 'public');

        $pelaksanaan->eviden()->create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'file_path' => $path,
            'tipe_file' => $file->getMimeType(),
            'diunggah_oleh' => auth()->id(),
        ]);

        return redirect()->route('ppepp.pelaksanaan', $pelaksanaan->ppepp_siklus_id)
            ->with('success', 'Eviden berhasil diunggah.');
    }

    public function evaluasi(PpeppSiklus $siklus)
    {
        $siklus->load(['standarMutu', 'ppeppEvaluasi.capaianIndikator', 'ppeppEvaluasi.dievaluasiOleh']);

        return view('ppepp.evaluasi', compact('siklus'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        $tahunAkademikAktif = \App\Models\TahunAkademik::where('is_active', true)->first();

        $sikluses = PpeppSiklus::with(['standarMutu', 'tahunAkademik'])
            ->when($tahunAkademikAktif, fn($q) => $q->where('tahun_akademik_id', $tahunAkademikAktif->id))
            ->latest()
            ->get();

        return view('ppepp.dashboard', compact('sikluses', 'tahunAkademikAktif'));
    }
}
