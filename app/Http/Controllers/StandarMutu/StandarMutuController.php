<?php

namespace App\Http\Controllers\StandarMutu;

use App\Http\Controllers\Controller;
use App\Models\IndikatorMutu;
use App\Models\KategoriStandar;
use App\Models\StandarMutu;
use App\Models\StandarMutuVersion;
use App\Services\Ppepp\PpeppOrchestratorService;
use Illuminate\Http\Request;

class StandarMutuController extends Controller
{
    public function index(Request $request)
    {
        $query = StandarMutu::with(['kategoriStandar', 'versiAktif', 'dibuatOleh']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_standar_id', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_standar', 'like', "%{$request->search}%")
                    ->orWhere('kode_standar', 'like', "%{$request->search}%");
            });
        }

        $standarMutus = $query->latest()->get();
        $kategoriStandars = KategoriStandar::orderBy('urutan')->get();

        return view('standar-mutu.index', compact('standarMutus', 'kategoriStandars'));
    }

    public function create()
    {
        $kategoriStandars = KategoriStandar::orderBy('urutan')->get();

        return view('standar-mutu.create', compact('kategoriStandars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_standar_id' => 'required|exists:kategori_standar,id',
            'kode_standar' => 'required|string|max:20|unique:standar_mutu,kode_standar',
            'nama_standar' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'dasar_hukum' => 'nullable|string|max:255',
            'unit_terdampak' => 'nullable|array',
        ]);

        $validated['dibuat_oleh'] = auth()->id();
        $validated['status'] = 'Draft';

        $standar = StandarMutu::create($validated);

        $version = StandarMutuVersion::create([
            'standar_mutu_id' => $standar->id,
            'nomor_versi' => '1.0',
            'konten_lengkap' => $validated['deskripsi'] ?? '',
            'dibuat_oleh' => auth()->id(),
        ]);

        $standar->update(['versi_aktif_id' => $version->id]);

        return redirect()->route('standar-mutu.show', $standar)
            ->with('success', 'Standar Mutu berhasil ditambahkan.');
    }

    public function show(StandarMutu $standar)
    {
        $standar->load(['kategoriStandar', 'versiAktif.dibuatOleh', 'dibuatOleh', 'disahkanOleh', 'indikatorMutu']);

        return view('standar-mutu.show', compact('standar'));
    }

    public function edit(StandarMutu $standar)
    {
        $kategoriStandars = KategoriStandar::orderBy('urutan')->get();

        return view('standar-mutu.edit', compact('standar', 'kategoriStandars'));
    }

    public function update(Request $request, StandarMutu $standar)
    {
        $validated = $request->validate([
            'kategori_standar_id' => 'required|exists:kategori_standar,id',
            'kode_standar' => 'required|string|max:20|unique:standar_mutu,kode_standar,' . $standar->id,
            'nama_standar' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'dasar_hukum' => 'nullable|string|max:255',
            'unit_terdampak' => 'nullable|array',
        ]);

        if ($standar->status === 'Published') {
            $lastVersion = $standar->standarMutuVersions()->latest('id')->first();
            $nextVersion = $lastVersion ? (float) $lastVersion->nomor_versi + 1 : 1.0;

            $version = StandarMutuVersion::create([
                'standar_mutu_id' => $standar->id,
                'nomor_versi' => number_format($nextVersion, 1),
                'konten_lengkap' => $validated['deskripsi'] ?? '',
                'alasan_revisi' => $request->input('alasan_revisi', 'Revisi dari versi sebelumnya'),
                'dibuat_oleh' => auth()->id(),
            ]);

            $standar->update(['versi_aktif_id' => $version->id]);
        }

        $standar->update($validated);

        return redirect()->route('standar-mutu.show', $standar)
            ->with('success', 'Standar Mutu berhasil diperbarui.');
    }

    public function destroy(StandarMutu $standar)
    {
        $standar->delete();

        return redirect()->route('standar-mutu.index')
            ->with('success', 'Standar Mutu berhasil dihapus.');
    }

    public function submit(StandarMutu $standar)
    {
        $standar->update(['status' => 'Submitted']);

        return redirect()->route('standar-mutu.show', $standar)
            ->with('success', 'Standar Mutu berhasil disubmit untuk review.');
    }

    public function review(StandarMutu $standar)
    {
        $standar->update(['status' => 'Reviewed']);

        return redirect()->route('standar-mutu.show', $standar)
            ->with('success', 'Standar Mutu berhasil direview.');
    }

    public function approve(StandarMutu $standar)
    {
        $standar->update([
            'status' => 'Approved',
            'disahkan_oleh' => auth()->id(),
        ]);

        return redirect()->route('standar-mutu.show', $standar)
            ->with('success', 'Standar Mutu berhasil disetujui.');
    }

    public function publish(StandarMutu $standar, PpeppOrchestratorService $orchestrator)
    {
        $standar->update(['status' => 'Published']);

        $orchestrator->prosesPenetapan($standar);

        return redirect()->route('standar-mutu.show', $standar)
            ->with('success', 'Standar Mutu berhasil dipublikasikan dan siklus PPEPP dimulai.');
    }

    public function versions(StandarMutu $standar)
    {
        $versions = $standar->standarMutuVersions()->with('dibuatOleh')->latest()->get();

        return view('standar-mutu.versions', compact('standar', 'versions'));
    }
}
