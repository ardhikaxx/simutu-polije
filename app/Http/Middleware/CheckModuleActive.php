<?php

namespace App\Http\Middleware;

use App\Models\PengaturanAplikasi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    public function handle(Request $request, Closure $next, string $moduleName): Response
    {
        $activeModules = PengaturanAplikasi::getValue('modules_active', []);

        if (is_string($activeModules)) {
            $activeModules = json_decode($activeModules, true) ?? [];
        }

        if (!isset($activeModules[$moduleName]) || $activeModules[$moduleName] !== true) {
            abort(403, 'Modul "' . str_replace('-', ' ', $moduleName) . '" tidak aktif atau belum dikonfigurasi.');
        }

        return $next($request);
    }
}
