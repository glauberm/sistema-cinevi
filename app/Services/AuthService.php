<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\AuthenticationFinalizeRegistrationMail;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AuthService
{
    public function getAuthIdOrFail(): int
    {
        $authId = Auth::id();

        if (is_null($authId)) {
            throw new AuthorizationException(
                'O id do usuário atual é inválido.'
            );
        }

        return (int) $authId;
    }

    public function getAuthUserOrFail(): User
    {
        $authUser = Auth::user();

        if (is_null($authUser)) {
            throw new AuthorizationException(
                'O usuário atual não foi encontrado.'
            );
        }

        return $authUser;
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();
    }

    public function sendFinalizeRegistrationMail(User $user): void
    {
        $url = URL::temporarySignedRoute(
            'authentication.finalize_registration',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id]
        );

        Mail::to($user->email)
            ->queue(new AuthenticationFinalizeRegistrationMail($url));
    }
}
