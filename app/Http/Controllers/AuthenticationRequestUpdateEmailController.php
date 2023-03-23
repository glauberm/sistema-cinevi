<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\AuthenticationRequestUpdateEmailRequest;
use App\Mail\AuthenticationUpdateEmailMail;
use App\Services\AuthService;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class AuthenticationRequestUpdateEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function __invoke(AuthenticationRequestUpdateEmailRequest $request): RedirectResponse
    {
        /** @var array{email:string,password:string} $data */
        $data = $request->validated();

        /** @var string $email */
        $email = $data['email'];

        $url = URL::temporarySignedRoute(
            'authentication.update_email',
            CarbonImmutable::now()->addMinutes(60),
            ['email' => $email]
        );

        Mail::to($email)->queue(new AuthenticationUpdateEmailMail($url));

        Session::flash(
            'message',
            "Foi enviado para {$email} um link válido por 60 minutos para
            finalizar a atualização do seu email. O email deve chegar em 15
            minutos."
        );

        Session::flash('message-type', 'success');

        return Redirect::route('authentication.login');
    }
}
