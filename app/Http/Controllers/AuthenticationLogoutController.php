<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthenticationLogoutController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
        $this->middleware(Authenticate::class);
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $this->authService->logout();

        Session::flash('message', 'Você saiu do sistema.');

        Session::flash('message-type', 'success');

        return Redirect::route('authentication.login');
    }
}
