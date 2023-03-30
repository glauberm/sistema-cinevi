<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Mail\UserPendingApprovalMail;
use App\Models\User as UserModel;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthenticationFinalizeRegistrationController extends Controller
{
    public function __construct(private readonly UserService $service)
    {
        $this->middleware(RedirectIfAuthenticated::class);

        $this->middleware(ValidateSignature::class);
    }

    public function __invoke(Request $request, int $id): RedirectResponse
    {
        /** @var UserModel $user */
        $user = $this->service->get($id, []);

        if ($user->is_enabled) {
            Session::flash(
                'message',
                'Seu email já foi confirmado. Você pode entrar no sistema.'
            );

            Session::flash('message-type', 'info');

            return Redirect::route('authentication.login');
        }

        $this->service->update(
            ['is_enabled' => true],
            $id,
            'finalize_registration',
            'O cadastro do usuário foi finalizado.'
        );

        $departmentUsers = $this->service->getAllWithRole(UserRole::Department);

        foreach ($departmentUsers as $user) {
            Mail::to($user->email)
                ->queue(new UserPendingApprovalMail($user));
        }

        Session::flash(
            'message',
            'Seu email foi confirmado, mas o departamento ainda precisa aprovar seu cadastro. Você receberá um email nos próximos dias.'
        );

        Session::flash('message-type', 'warning');

        return Redirect::route('authentication.login');
    }
}
