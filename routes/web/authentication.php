<?php

use App\Http\Controllers\AuthenticationFinalizeRegistrationController;
use App\Http\Controllers\AuthenticationLoginController;
use App\Http\Controllers\AuthenticationLogoutController;
use App\Http\Controllers\AuthenticationRegisterController;
use App\Http\Controllers\AuthenticationRequestResetPasswordController;
use App\Http\Controllers\AuthenticationRequestUpdateEmailController;
use App\Http\Controllers\AuthenticationResetPasswordController;
use App\Http\Controllers\AuthenticationUpdateEmailController;
use App\Http\Controllers\AuthenticationUpdatePasswordController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages/authentication/index')
    ->middleware(Authenticate::class)
    ->name('authentication.index');

Route::view('entrada', 'pages/authentication/login')
    ->name('authentication.login');

Route::post('entrada', AuthenticationLoginController::class)
    ->name('authentication.login-action');

Route::post('saida', AuthenticationLogoutController::class)
    ->name('authentication.logout-action');

Route::view('cadastro', 'pages/authentication/register')
    ->name('authentication.register');

Route::post('cadastro', AuthenticationRegisterController::class, 'register')
    ->name('authentication.register-action');

Route::get(
    'finalizar-cadastro/{id}',
    AuthenticationFinalizeRegistrationController::class
)
    ->name('authentication.finalize_registration');

Route::view(
    'solicitar-redefinir-senha',
    'pages/authentication/request_reset_password'
)
    ->name('authentication.request_reset_password');

Route::post(
    'solicitar-redefinir-senha',
    AuthenticationRequestResetPasswordController::class
)
    ->name('authentication.request_reset_password-action');

Route::view('redefinir-senha/{id}', 'pages/authentication/reset_password')
    ->name('authentication.reset_password');

Route::post(
    'redefinir-senha/{id}',
    AuthenticationResetPasswordController::class
)
    ->name('authentication.reset_password-action');

Route::view('solicitar-atualizar-email', 'pages/authentication/request_update_email')
    ->name('authentication.request_update_email');

Route::post(
    'solicitar-atualizar-email',
    AuthenticationRequestUpdateEmailController::class
)
    ->name('authentication.request_update_email-action');

Route::get(
    'atualizar-email/{email}',
    AuthenticationUpdateEmailController::class
)
    ->name('authentication.update_email');

Route::view('atualizar-senha', 'pages/authentication/update_password')
    ->name('authentication.update_password');

Route::post('atualizar-senha', AuthenticationUpdatePasswordController::class)
    ->name('authentication.update_password-action');
