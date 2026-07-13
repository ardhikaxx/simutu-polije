<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\FakultasJurusan;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $prodis = ProgramStudi::with('jurusan')->latest()->get();

        return view('master-data.prodi.index', compact('prodis'));
    }

    public function create()
    {
        $jurusans = FakultasJurusan::orderBy('nama_jurusan')->get();

        return view('master-data.prodi.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:fakultas_jurusans,id',
            'nama_prodi' => 'required|string|max:255',
            'kode_prodi' => 'required|string|max:20|unique:program_studis,kode_prodi',
            'jenjang' => 'required|in:D3,S1,S2,S3',
        ]);

        ProgramStudi::create($validated);

        return redirect()->route('master-data.prodi.index')
            ->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function edit(ProgramStudi $prodi)
    {
        $jurusans = FakultasJurusan::orderBy('nama_jurusan')->get();

        return view('master-data.prodi.edit', compact('prodi', 'jurusans'));
    }

    public function update(Request $request, ProgramStudi $prodi)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:fakultas_jurusans,id',
            'nama_prodi' => 'required|string|max:255',
            'kode_prodi' => 'required|string|max:20|unique:program_studis,kode_prodi,' . $prodi->id,
            'jenjang' => 'required|in:D3,S1,S2,S3',
        ]);

        $prodi->update($validated);

        return redirect()->route('master-data.prodi.index')
            ->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function destroy(ProgramStudi $prodi)
    {
        $prodi->delete();

        return redirect()->route('master-data.prodi.index')
            ->with('success', 'Program Studi berhasil dihapus.');
    }
}
