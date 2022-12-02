<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationUpdatePasswordRequest;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthenticationUpdatePasswordController extends Controller
{
    public function __construct(private readonly UserService $userService, private readonly AuthService $authService)
    {
    }

    public function updatePassword(AuthenticationUpdatePasswordRequest $request): RedirectResponse
    {
        $authId = $this->authService->getAuthIdOrFail();

        /** @var array<string,mixed> */
        $data = $request->validated();

        $password = $data['new_password'];

        $this->userService->update(
            ['password' => $password],
            $authId,
            'update_password',
            'A senha do usuário foi atualizada.'
        );

        $this->authService->logout();

        Session::flash('message', 'Senha editada com sucesso. Por favor, entre com sua nova senha.');
        Session::flash('message-type', 'success');

        return Redirect::route('authentication.login');
    }
}
