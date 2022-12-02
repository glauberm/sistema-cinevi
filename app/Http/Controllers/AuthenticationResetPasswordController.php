<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\AuthenticationResetPasswordRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthenticationResetPasswordController extends Controller
{
    public function __construct(private readonly UserService $service)
    {
        $this->middleware(RedirectIfAuthenticated::class);

        $this->middleware(ValidateSignature::class);
    }

    public function __invoke(AuthenticationResetPasswordRequest $request, int $id): RedirectResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $this->service->update($data, $id, 'reset_password', 'A senha do usuário foi redefinida.');

        Session::flash('message', 'Sua senha foi redefinida. Você já pode entrar no sistema com sua nova senha.');
        Session::flash('message-type', 'success');

        return Redirect::route('authentication.login');
    }
}
