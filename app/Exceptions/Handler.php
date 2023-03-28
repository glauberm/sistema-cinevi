<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(
            function (AuthenticationException $exception, $request) {
                Session::flash('message', $exception->getMessage());

                Session::flash('message-type', 'info');

                return Redirect::route('authentication.login');
            }
        );

        $this->renderable(
            function (InvalidSignatureException $exception, $request) {
                Session::flash(
                    'message',
                    'Seu link expirou. Por favor, repita a operação.'
                );

                Session::flash('message-type', 'info');

                return Redirect::route('authentication.login');
            }
        );
    }
}
