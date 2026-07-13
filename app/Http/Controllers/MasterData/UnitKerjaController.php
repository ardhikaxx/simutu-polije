<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unitKerjas = UnitKerja::latest()->get();

        return view('master-data.unit-kerja.index', compact('unitKerjas'));
    }

    public function create()
    {
        return view('master-data.unit-kerja.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_unit' => 'required|string|max:255',
            'jenis' => 'required|in:Unit Kerja,Fungsional',
        ]);

        UnitKerja::create($validated);

        return redirect()->route('master-data.unit-kerja.index')
            ->with('success', 'Unit Kerja berhasil ditambahkan.');
    }

    public function edit(UnitKerja $unitKerja)
    {
        return view('master-data.unit-kerja.edit', compact('unitKerja'));
    }

    public function update(Request $request, UnitKerja $unitKerja)
    {
        $validated = $request->validate([
            'nama_unit' => 'required|string|max:255',
            'jenis' => 'required|in:Unit Kerja,Fungsional',
        ]);

        $unitKerja->update($validated);

        return redirect()->route('master-data.unit-kerja.index')
            ->with('success', 'Unit Kerja berhasil diperbarui.');
    }

    public function destroy(UnitKerja $unitKerja)
    {
        $unitKerja->delete();

        return redirect()->route('master-data.unit-kerja.index')
            ->with('success', 'Unit Kerja berhasil dihapus.');
    }
}
