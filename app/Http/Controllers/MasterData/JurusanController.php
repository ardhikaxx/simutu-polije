<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\FakultasJurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = FakultasJurusan::withCount('programStudi')->latest()->get();

        return view('master-data.jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('master-data.jurusan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:20|unique:fakultas_jurusan,kode_jurusan',
        ]);

        FakultasJurusan::create($validated);

        return redirect()->route('master-data.jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(FakultasJurusan $jurusan)
    {
        return view('master-data.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, FakultasJurusan $jurusan)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:20|unique:fakultas_jurusan,kode_jurusan,' . $jurusan->id,
        ]);

        $jurusan->update($validated);

        return redirect()->route('master-data.jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(FakultasJurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('master-data.jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}
