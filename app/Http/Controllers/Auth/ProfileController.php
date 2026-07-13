<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FakultasJurusan;
use App\Models\ProgramStudi;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('auth.profile', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        $jurusans = FakultasJurusan::orderBy('nama_jurusan')->get();
        $prodis = ProgramStudi::orderBy('nama_prodi')->get();
        $unitKerjas = UnitKerja::orderBy('nama_unit')->get();

        return view('auth.profile-edit', compact('user', 'jurusans', 'prodis', 'unitKerjas'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip_nim' => 'nullable|string|max:50',
            'jurusan_id' => 'nullable|exists:fakultas_jurusan,id',
            'program_studi_id' => 'nullable|exists:program_studi,id',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
        ]);

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('profile.show')->with('success', 'Password berhasil diubah.');
    }
}
