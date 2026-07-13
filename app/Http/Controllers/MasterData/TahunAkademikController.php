<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function index()
    {
        $tahunAkademiks = TahunAkademik::latest()->get();

        return view('master-data.tahun-akademik.index', compact('tahunAkademiks'));
    }

    public function create()
    {
        return view('master-data.tahun-akademik.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        TahunAkademik::create($validated);

        return redirect()->route('master-data.tahun-akademik.index')
            ->with('success', 'Tahun Akademik berhasil ditambahkan.');
    }

    public function edit(TahunAkademik $tahunAkademik)
    {
        return view('master-data.tahun-akademik.edit', compact('tahunAkademik'));
    }

    public function update(Request $request, TahunAkademik $tahunAkademik)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $tahunAkademik->update($validated);

        return redirect()->route('master-data.tahun-akademik.index')
            ->with('success', 'Tahun Akademik berhasil diperbarui.');
    }

    public function destroy(TahunAkademik $tahunAkademik)
    {
        $tahunAkademik->delete();

        return redirect()->route('master-data.tahun-akademik.index')
            ->with('success', 'Tahun Akademik berhasil dihapus.');
    }

    public function activate(TahunAkademik $tahunAkademik)
    {
        TahunAkademik::where('is_active', true)->update(['is_active' => false]);
        $tahunAkademik->update(['is_active' => true]);

        return redirect()->route('master-data.tahun-akademik.index')
            ->with('success', 'Tahun Akademik berhasil diaktifkan.');
    }

    public function deactivate(TahunAkademik $tahunAkademik)
    {
        $tahunAkademik->update(['is_active' => false]);

        return redirect()->route('master-data.tahun-akademik.index')
            ->with('success', 'Tahun Akademik berhasil dinonaktifkan.');
    }
}
