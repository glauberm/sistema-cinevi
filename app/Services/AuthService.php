<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function getAuthIdOrFail(): int
    {
        $authId = Auth::id();

        if (! \is_int($authId)) {
            throw new AuthorizationException('O id do usuário atual é inválido.');
        }

        return $authId;
    }

    public function getAuthUserOrFail(): User
    {
        $authUser = Auth::user();

        if (\is_null($authUser)) {
            throw new AuthorizationException('O usuário atual não foi encontrado.');
        }

        return $authUser;
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();
    }
}
