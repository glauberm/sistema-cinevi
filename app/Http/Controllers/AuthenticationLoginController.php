<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\AuthenticationLoginRequest;
use App\Services\AuthService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthenticationLoginController extends Controller
{
    public function __construct(private readonly AuthService $service)
    {
        $this->middleware(RedirectIfAuthenticated::class);

        if (!App::environment('testing') && !App::environment('development')) {
            $this->middleware(ThrottleRequests::class . ':5,5');
        }
    }

    public function __invoke(AuthenticationLoginRequest $request): RedirectResponse
    {
        /** @var array{email:string,password:string} */
        $data = $request->validated();

        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ])) {
            try {
                $authUser = $this->service->getAuthUserOrFail();
            } catch (AuthorizationException $e) {
                $this->service->logout();
                throw $e;
            }

            if ($authUser->is_enabled && $authUser->is_confirmed) {
                return Redirect::route('authentication.index');
            }

            if (!$authUser->is_enabled) {
                $this->service->sendFinalizeRegistrationMail($authUser);

                $this->service->logout();

                throw new AuthenticationException(
                    'Seu email ainda não foi confirmado. O email de confirmação foi reenviado e deve chegar em 15 minutos.'
                );
            }

            if (!$authUser->is_confirmed) {
                $this->service->logout();

                throw new AuthenticationException(
                    'Seu cadastro ainda não foi confirmado pelo departamento. Quando ele for, você receberá um email.'
                );
            }
        }

        throw new AuthenticationException('O email ou senha estão incorretos.');
    }
}
