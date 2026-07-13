<?php

namespace App\Http\Controllers\StandarMutu;

use App\Http\Controllers\Controller;
use App\Models\IndikatorMutu;
use App\Models\StandarMutu;
use Illuminate\Http\Request;

class IndikatorMutuController extends Controller
{
    public function store(Request $request, StandarMutu $standar)
    {
        $validated = $request->validate([
            'nama_indikator' => 'required|string|max:255',
            'definisi_operasional' => 'nullable|string',
            'satuan' => 'required|string|max:100',
            'formula_perhitungan' => 'nullable|string|max:255',
            'sumber_data' => 'nullable|string|max:255',
            'frekuensi_pengukuran' => 'nullable|string|max:100',
            'penanggung_jawab_role' => 'nullable|string|max:100',
        ]);

        $validated['standar_mutu_id'] = $standar->id;

        IndikatorMutu::create($validated);

        return redirect()->route('standar-mutu.show', $standar)
            ->with('success', 'Indikator Mutu berhasil ditambahkan.');
    }

    public function update(Request $request, StandarMutu $standar, IndikatorMutu $indikator)
    {
        $validated = $request->validate([
            'nama_indikator' => 'required|string|max:255',
            'definisi_operasional' => 'nullable|string',
            'satuan' => 'required|string|max:100',
            'formula_perhitungan' => 'nullable|string|max:255',
            'sumber_data' => 'nullable|string|max:255',
            'frekuensi_pengukuran' => 'nullable|string|max:100',
            'penanggung_jawab_role' => 'nullable|string|max:100',
        ]);

        $indikator->update($validated);

        return redirect()->route('standar-mutu.show', $standar)
            ->with('success', 'Indikator Mutu berhasil diperbarui.');
    }

    public function destroy(StandarMutu $standar, IndikatorMutu $indikator)
    {
        $indikator->delete();

        return redirect()->route('standar-mutu.show', $standar)
            ->with('success', 'Indikator Mutu berhasil dihapus.');
    }
}
