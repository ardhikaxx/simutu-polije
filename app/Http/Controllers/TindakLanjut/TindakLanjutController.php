<?php

namespace App\Http\Controllers\TindakLanjut;

use App\Http\Controllers\Controller;
use App\Models\TindakLanjutProgress;
use App\Models\TindakLanjutTemuan;
use Illuminate\Http\Request;

class TindakLanjutController extends Controller
{
    public function index(Request $request)
    {
        $query = TindakLanjutTemuan::with(['temuanAudit.hasilAudit.jadwalAudit.programStudi', 'penanggungJawab', 'tindakLanjutProgress']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tindakLanjuts = $query->latest()->get();

        return view('tindak-lanjut.index', compact('tindakLanjuts'));
    }

    public function show(TindakLanjutTemuan $tl)
    {
        $tl->load([
            'temuanAudit.hasilAudit.jadwalAudit.programStudi',
            'temuanAudit.standarMutu',
            'penanggungJawab',
            'tindakLanjutProgress.dilaporkanOleh',
            'tindakLanjutProgress.diverifikasiOleh',
        ]);

        return view('tindak-lanjut.show', compact('tl'));
    }

    public function updateProgress(Request $request, TindakLanjutTemuan $tl)
    {
        $validated = $request->validate([
            'keterangan_progress' => 'required|string',
            'file_bukti' => 'nullable|file|max:10240',
        ]);

        $data = [
            'tindak_lanjut_temuan_id' => $tl->id,
            'keterangan_progress' => $validated['keterangan_progress'],
            'dilaporkan_oleh' => auth()->id(),
            'status_verifikasi' => 'Pending',
        ];

        if ($request->hasFile('file_bukti')) {
            $data['file_bukti'] = $request->file('file_bukti')->store('tindak-lanjut', 'public');
        }

        TindakLanjutProgress::create($data);

        if ($tl->status === 'Open') {
            $tl->update(['status' => 'On Progress']);
        }

        return redirect()->route('tindak-lanjut.show', $tl)
            ->with('success', 'Progress tindak lanjut berhasil ditambahkan.');
    }

    public function verify(Request $request, TindakLanjutProgress $progress)
    {
        $validated = $request->validate([
            'status_verifikasi' => 'required|in:Diterima,Ditolak',
        ]);

        $validated['diverifikasi_oleh'] = auth()->id();

        $progress->update($validated);

        $tl = $progress->tindakLanjutTemuan;

        $pendingCount = $tl->tindakLanjutProgress()
            ->where('status_verifikasi', 'Pending')
            ->count();

        $rejectedCount = $tl->tindakLanjutProgress()
            ->where('status_verifikasi', 'Ditolak')
            ->count();

        if ($pendingCount === 0 && $rejectedCount === 0) {
            $tl->update(['status' => 'Closed']);
        } elseif ($pendingCount === 0 && $rejectedCount > 0) {
            $tl->update(['status' => 'Need Revision']);
        }

        return redirect()->route('tindak-lanjut.show', $tl)
            ->with('success', 'Verifikasi progress berhasil diperbarui.');
    }
}
