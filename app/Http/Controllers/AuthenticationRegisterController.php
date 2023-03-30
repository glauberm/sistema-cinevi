<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\AuthenticationRegisterRequest;
use App\Models\User as UserModel;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthenticationRegisterController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly AuthService $authService
    ) {
        $this->middleware(RedirectIfAuthenticated::class);
    }

    public function __invoke(AuthenticationRegisterRequest $request): RedirectResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        /** @var UserModel $user */
        $user = $this->userService->create(
            [
                'is_enabled' => false,
                'is_confirmed' => false,
                'roles' => [],
                ...$data,
            ],
            'register',
            'O usuário foi cadastrado.'
        );

        $this->authService->sendFinalizeRegistrationMail($user);

        Session::flash(
            'message',
            "Foi enviado para {$user->email} um link válido por 60 minutos para você finalizar o seu cadastro. O email deve chegar em 15 minutos."
        );

        Session::flash('message-type', 'success');

        return Redirect::route('authentication.login');
    }
}
