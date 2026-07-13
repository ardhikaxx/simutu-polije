<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LocalAuthProvider implements AuthProviderInterface
{
    public function authenticate(string $credentials, string $password): ?User
    {
        $field = filter_var($credentials, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip_nim';

        $user = User::where($field, $credentials)->first();

        if (!$user) {
            return null;
        }

        if ($user->status !== 'aktif') {
            return null;
        }

        if (Auth::attempt([$field => $credentials, 'password' => $password])) {
            $user->update(['last_login_at' => now()]);

            return $user;
        }

        return null;
    }

    public function supports(string $provider): bool
    {
        return $provider === 'local';
    }
}
