<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\AuthenticationRequestResetPasswordRequest;
use App\Mail\AuthenticationResetPasswordMail;
use App\Services\UserService;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class AuthenticationRequestResetPasswordController extends Controller
{
    public function __construct(private readonly UserService $service)
    {
        $this->middleware(RedirectIfAuthenticated::class);

        if (! App::environment('testing') && ! App::environment('development')) {
            $this->middleware(ThrottleRequests::class.':5,5');
        }
    }

    public function __invoke(AuthenticationRequestResetPasswordRequest $request): RedirectResponse
    {
        /** @var array{email:string} */
        $data = $request->validated();

        $email = $data['email'];

        $user = $this->service->getByEmail($email);

        if (\is_null($user)) {
            throw new ModelNotFoundException('Um usuário com esse email não foi encontrado no sistema.');
        }

        $url = URL::temporarySignedRoute(
            'authentication.reset_password',
            CarbonImmutable::now()->addMinutes(60),
            ['id' => $user->id]
        );

        Mail::to($user->email)
            ->queue(new AuthenticationResetPasswordMail($url));

        Session::flash('message', "Foi enviado para {$email} um link válido por 60 minutos para redefinição de senha. 
                                    O email deve chegar em 15 minutos.");
        Session::flash('message-type', 'success');

        return Redirect::route('authentication.login');
    }
}
