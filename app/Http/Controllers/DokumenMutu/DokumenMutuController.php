<?php

namespace App\Http\Controllers\DokumenMutu;

use App\Http\Controllers\Controller;
use App\Models\DokumenMutu;
use App\Models\DokumenMutuVersion;
use App\Models\KategoriDokumen;
use App\Models\ProgramStudi;
use App\Models\StandarMutu;
use App\Models\UnitKerja;
use App\Services\Numbering\DocumentNumberingService;
use Illuminate\Http\Request;

class DokumenMutuController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenMutu::with(['kategoriDokumen', 'programStudi', 'unitKerja', 'standarMutu', 'dibuatOleh']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_dokumen_id', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                    ->orWhere('nomor_dokumen', 'like', "%{$request->search}%");
            });
        }

        $dokumenMutus = $query->latest()->get();
        $kategoriDokumens = KategoriDokumen::orderBy('nama')->get();

        return view('dokumen-mutu.index', compact('dokumenMutus', 'kategoriDokumens'));
    }

    public function create()
    {
        $kategoriDokumens = KategoriDokumen::orderBy('nama')->get();
        $prodis = ProgramStudi::orderBy('nama_prodi')->get();
        $unitKerjas = UnitKerja::orderBy('nama_unit')->get();
        $standarMutus = StandarMutu::orderBy('nama_standar')->get();

        return view('dokumen-mutu.create', compact('kategoriDokumens', 'prodis', 'unitKerjas', 'standarMutus'));
    }

    public function store(Request $request, DocumentNumberingService $numbering)
    {
        $validated = $request->validate([
            'kategori_dokumen_id' => 'required|exists:kategori_dokumen,id',
            'judul' => 'required|string|max:255',
            'program_studi_id' => 'nullable|exists:program_studi,id',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
            'standar_mutu_id' => 'nullable|exists:standar_mutu,id',
        ]);

        $kategori = KategoriDokumen::findOrFail($validated['kategori_dokumen_id']);
        $unitId = $validated['program_studi_id'] ?? $validated['unit_kerja_id'] ?? 1;

        $validated['nomor_dokumen'] = $numbering->generate($kategori, $unitId);
        $validated['dibuat_oleh'] = auth()->id();
        $validated['status'] = 'Draft';

        $dokumen = DokumenMutu::create($validated);

        $version = DokumenMutuVersion::create([
            'dokumen_mutu_id' => $dokumen->id,
            'nomor_versi' => '1.0',
            'dibuat_oleh' => auth()->id(),
        ]);

        $dokumen->update(['versi_aktif_id' => $version->id]);

        return redirect()->route('dokumen-mutu.show', $dokumen)
            ->with('success', 'Dokumen Mutu berhasil ditambahkan.');
    }

    public function show(DokumenMutu $dokumen)
    {
        $dokumen->load(['kategoriDokumen', 'programStudi', 'unitKerja', 'standarMutu', 'versiAktif', 'dibuatOleh', 'dokumenMutuVersions.dibuatOleh', 'approvalHistories']);

        return view('dokumen-mutu.show', compact('dokumen'));
    }

    public function edit(DokumenMutu $dokumen)
    {
        $kategoriDokumens = KategoriDokumen::orderBy('nama')->get();
        $prodis = ProgramStudi::orderBy('nama_prodi')->get();
        $unitKerjas = UnitKerja::orderBy('nama_unit')->get();
        $standarMutus = StandarMutu::orderBy('nama_standar')->get();

        return view('dokumen-mutu.edit', compact('dokumen', 'kategoriDokumens', 'prodis', 'unitKerjas', 'standarMutus'));
    }

    public function update(Request $request, DokumenMutu $dokumen)
    {
        $validated = $request->validate([
            'kategori_dokumen_id' => 'required|exists:kategori_dokumen,id',
            'judul' => 'required|string|max:255',
            'program_studi_id' => 'nullable|exists:program_studi,id',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
            'standar_mutu_id' => 'nullable|exists:standar_mutu,id',
        ]);

        $dokumen->update($validated);

        return redirect()->route('dokumen-mutu.show', $dokumen)
            ->with('success', 'Dokumen Mutu berhasil diperbarui.');
    }

    public function destroy(DokumenMutu $dokumen)
    {
        $dokumen->delete();

        return redirect()->route('dokumen-mutu.index')
            ->with('success', 'Dokumen Mutu berhasil dihapus.');
    }

    public function submit(DokumenMutu $dokumen)
    {
        $dokumen->update(['status' => 'Submitted']);

        return redirect()->route('dokumen-mutu.show', $dokumen)
            ->with('success', 'Dokumen berhasil disubmit untuk review.');
    }

    public function review(DokumenMutu $dokumen)
    {
        $dokumen->update(['status' => 'Reviewed']);

        return redirect()->route('dokumen-mutu.show', $dokumen)
            ->with('success', 'Dokumen berhasil direview.');
    }

    public function approve(DokumenMutu $dokumen)
    {
        $dokumen->update(['status' => 'Approved']);

        return redirect()->route('dokumen-mutu.show', $dokumen)
            ->with('success', 'Dokumen berhasil disetujui.');
    }

    public function publish(DokumenMutu $dokumen)
    {
        $dokumen->update(['status' => 'Published']);

        return redirect()->route('dokumen-mutu.show', $dokumen)
            ->with('success', 'Dokumen berhasil dipublikasikan.');
    }

    public function versions(DokumenMutu $dokumen)
    {
        $versions = $dokumen->dokumenMutuVersions()->with('dibuatOleh')->latest()->get();

        return view('dokumen-mutu.versions', compact('dokumen', 'versions'));
    }

    public function revisi(Request $request, DokumenMutu $dokumen)
    {
        $validated = $request->validate([
            'catatan_revisi' => 'required|string|max:1000',
            'file_revisi' => 'nullable|file|max:10240',
        ]);

        $lastVersion = $dokumen->dokumenMutuVersions()->latest()->first();
        $lastNumber = $lastVersion ? floatval($lastVersion->nomor_versi) : 0;
        $newNumber = number_format($lastNumber + 0.1, 1);

        $version = DokumenMutuVersion::create([
            'dokumen_mutu_id' => $dokumen->id,
            'nomor_versi' => $newNumber,
            'catatan_revisi' => $validated['catatan_revisi'],
            'dibuat_oleh' => auth()->id(),
        ]);

        $dokumen->update(['versi_aktif_id' => $version->id, 'status' => 'Draft']);

        return redirect()->route('dokumen-mutu.versions', $dokumen)
            ->with('success', "Revisi v{$newNumber} berhasil ditambahkan.");
    }
}
