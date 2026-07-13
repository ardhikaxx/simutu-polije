<?php

namespace App\Services\Auth;

use App\Models\User;

interface AuthProviderInterface
{
    public function authenticate(string $credentials, string $password): ?User;

    public function supports(string $provider): bool;
}
