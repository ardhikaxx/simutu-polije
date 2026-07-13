<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('users')->orderBy('name')->get();

        $roleDescriptions = [
            'super_admin' => 'Super Administrator',
            'admin_spmi' => 'Admin SPMI',
            'kajur' => 'Kepala Jurusan',
            'kaprodi' => 'Kepala Program Studi',
            'gpm' => 'Gunada Penjaminan Mutu',
            'auditor' => 'Auditor',
            'auditor_ketua' => 'Ketua Auditor',
            'dosen' => 'Dosen',
            'tendik' => 'Tenaga Kependidikan',
            'pimpinan' => 'Pimpinan',
            'mahasiswa' => 'Mahasiswa',
            'alumni' => 'Alumni',
            'mitra_industri' => 'Mitra Industri',
        ];

        return view('admin.roles.index', compact('roles', 'roleDescriptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:255',
        ]);

        Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'super_admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Tidak dapat menghapus role Super Admin.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
