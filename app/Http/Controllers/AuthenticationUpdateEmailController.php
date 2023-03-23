<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthenticationUpdateEmailController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserService $userService
    ) {
        $this->middleware(Authenticate::class);
    }

    public function __invoke(Request $request, string $email): RedirectResponse
    {
        $authId = $this->authService->getAuthIdOrFail();

        $this->userService->update(
            ['email' => $email],
            $authId,
            'update_email',
            'O email do usuário foi atualizado.'
        );

        $this->authService->logout();

        Session::flash(
            'message',
            'Email editado com sucesso. Por favor, entre com seu novo email.'
        );

        Session::flash('message-type', 'success');

        return Redirect::route('authentication.login');
    }
}
