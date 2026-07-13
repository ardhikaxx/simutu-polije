<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DashboardRedirectMiddleware
{
    private const ROLE_DASHBOARD_MAP = [
        'super_admin' => '/admin/dashboard',
        'admin_spmi' => '/spm/dashboard',
        'kajur' => '/kajur/dashboard',
        'kaprodi' => '/kaprodi/dashboard',
        'gpm' => '/gpm/dashboard',
        'auditor' => '/audit/dashboard',
        'auditor_ketua' => '/audit/dashboard',
        'dosen' => '/dosen/dashboard',
        'tendik' => '/tendik/dashboard',
        'pimpinan' => '/pimpinan/dashboard',
        'mahasiswa' => '/mahasiswa/dashboard',
        'alumni' => '/alumni/dashboard',
        'mitra_industri' => '/mitra/dashboard',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $primaryRole = $user->getRoleNames()->first();

            $dashboard = self::ROLE_DASHBOARD_MAP[$primaryRole] ?? '/dashboard';

            return redirect($dashboard);
        }

        return redirect('/login');
    }
}
