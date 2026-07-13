<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleScopeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if ($user->jurusan_id) {
            $request->attributes->set('scope_jurusan_id', $user->jurusan_id);
        }

        if ($user->program_studi_id) {
            $request->attributes->set('scope_program_studi_id', $user->program_studi_id);
        }

        if ($user->unit_kerja_id) {
            $request->attributes->set('scope_unit_kerja_id', $user->unit_kerja_id);
        }

        $primaryRole = $user->getRoleNames()->first();

        $request->attributes->set('scope_role', $primaryRole);

        $scopeData = $this->buildScopeData($user, $primaryRole);
        $request->attributes->set('scope_data', $scopeData);

        return $next($request);
    }

    private function buildScopeData($user, ?string $role): array
    {
        $scope = [];

        match ($role) {
            'kaprodi', 'gpm' => $scope = [
                'program_studi_id' => $user->program_studi_id,
                'jurusan_id' => $user->programStudi?->jurusan_id,
            ],
            'kajur' => $scope = [
                'jurusan_id' => $user->jurusan_id,
            ],
            'dosen', 'tendik' => $scope = [
                'user_id' => $user->id,
                'unit_kerja_id' => $user->unit_kerja_id,
            ],
            'auditor' => $scope = [
                'user_id' => $user->id,
            ],
            default => $scope = [],
        };

        return $scope;
    }
}
