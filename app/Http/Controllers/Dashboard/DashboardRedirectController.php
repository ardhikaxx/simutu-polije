<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DashboardRedirectController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return view('dashboard.super-admin');
        }

        if ($user->hasRole('admin_spmi')) {
            return view('dashboard.admin-spmi');
        }

        if ($user->hasRole('kajur')) {
            return view('dashboard.kajur');
        }

        if ($user->hasRole('kaprodi')) {
            return view('dashboard.kaprodi');
        }

        if ($user->hasRole('gpm')) {
            return view('dashboard.gpm');
        }

        if ($user->hasRole('auditor') || $user->hasRole('auditor_ketua')) {
            return view('dashboard.auditor');
        }

        if ($user->hasRole('dosen')) {
            return view('dashboard.dosen');
        }

        if ($user->hasRole('tendik')) {
            return view('dashboard.tendik');
        }

        if ($user->hasRole('pimpinan')) {
            return view('dashboard.pimpinan');
        }

        if ($user->hasRole('mahasiswa')) {
            return view('dashboard.mahasiswa');
        }

        if ($user->hasRole('alumni')) {
            return view('dashboard.alumni');
        }

        if ($user->hasRole('mitra_industri')) {
            return view('dashboard.mitra');
        }

        return view('dashboard.default');
    }
}
