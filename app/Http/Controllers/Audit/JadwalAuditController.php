<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;
use App\Models\HasilAudit;
use App\Models\JadwalAudit;
use App\Models\PeriodeAudit;
use App\Models\ProgramStudi;
use App\Models\TimAudit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalAuditController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalAudit::with(['periodeAudit', 'programStudi', 'unitKerja', 'dibuatOleh']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('periode')) {
            $query->where('periode_audit_id', $request->periode);
        }

        $jadwalAudits = $query->latest('tanggal_audit')->get();
        $periodeAudits = PeriodeAudit::orderByDesc('created_at')->get();

        return view('audit.index', compact('jadwalAudits', 'periodeAudits'));
    }

    public function create()
    {
        $periodeAudits = PeriodeAudit::orderByDesc('created_at')->get();
        $prodis = ProgramStudi::orderBy('nama_prodi')->get();

        return view('audit.create', compact('periodeAudits', 'prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode_audit_id' => 'required|exists:periode_audit,id',
            'program_studi_id' => 'required|exists:program_studi,id',
            'tanggal_audit' => 'required|date',
            'jenis_audit' => 'required|in:Internal,Eksternal,Self Assessment',
        ]);

        $validated['dibuat_oleh'] = Auth::id();
        $validated['status'] = 'Terjadwal';

        JadwalAudit::create($validated);

        return redirect()->route('audit.index')
            ->with('success', 'Jadwal Audit berhasil dibuat.');
    }

    public function show(JadwalAudit $jadwal)
    {
        $jadwal->load(['periodeAudit', 'programStudi', 'unitKerja', 'dibuatOleh', 'timAudit.user', 'hasilAudit']);

        return view('audit.show', compact('jadwal'));
    }

    public function update(Request $request, JadwalAudit $jadwal)
    {
        $validated = $request->validate([
            'periode_audit_id' => 'required|exists:periode_audit,id',
            'program_studi_id' => 'required|exists:program_studi,id',
            'tanggal_audit' => 'required|date',
            'jenis_audit' => 'required|in:Internal,Eksternal,Self Assessment',
            'status' => 'required|in:Terjadwal,Berlangsung,Selesai,Dibatalkan',
        ]);

        $jadwal->update($validated);

        return redirect()->route('audit.show', $jadwal)
            ->with('success', 'Jadwal Audit berhasil diperbarui.');
    }

    public function destroy(JadwalAudit $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('audit.index')
            ->with('success', 'Jadwal Audit berhasil dihapus.');
    }

    public function assignTeam(Request $request, JadwalAudit $jadwal)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'peran_dalam_tim' => 'required|array',
            'peran_dalam_tim.*' => 'string|max:100',
        ]);

        $jadwal->timAudit()->delete();

        foreach ($validated['user_ids'] as $index => $userId) {
            $jadwal->timAudit()->create([
                'user_id' => $userId,
                'peran_dalam_tim' => $validated['peran_dalam_tim'][$index] ?? 'Anggota',
            ]);
        }

        return redirect()->route('audit.show', $jadwal)
            ->with('success', 'Tim Audit berhasil ditetapkan.');
    }
}
