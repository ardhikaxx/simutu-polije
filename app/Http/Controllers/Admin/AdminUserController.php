<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FakultasJurusan;
use App\Models\ProgramStudi;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('jurusan', 'programStudi', 'unitKerja', 'roles')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $jurusans = FakultasJurusan::orderBy('nama_jurusan')->get();
        $prodis = ProgramStudi::orderBy('nama_prodi')->get();
        $unitKerjas = UnitKerja::orderBy('nama_unit')->get();
        $roles = Role::orderBy('name')->get();

        return view('admin.users.create', compact('jurusans', 'prodis', 'unitKerjas', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nip_nim' => 'nullable|string|max:50',
            'role' => 'required|exists:roles,name',
            'jurusan_id' => 'nullable|exists:fakultas_jurusan,id',
            'program_studi_id' => 'nullable|exists:program_studi,id',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $jurusans = FakultasJurusan::orderBy('nama_jurusan')->get();
        $prodis = ProgramStudi::orderBy('nama_prodi')->get();
        $unitKerjas = UnitKerja::orderBy('nama_unit')->get();
        $roles = Role::orderBy('name')->get();
        $currentRole = $user->getRoleNames()->first();

        return view('admin.users.edit', compact('user', 'jurusans', 'prodis', 'unitKerjas', 'roles', 'currentRole'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'nip_nim' => 'nullable|string|max:50',
            'role' => 'required|exists:roles,name',
            'jurusan_id' => 'nullable|exists:fakultas_jurusan,id',
            'program_studi_id' => 'nullable|exists:program_studi,id',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
