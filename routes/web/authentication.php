<?php

use App\Http\Controllers\AuthenticationFinalizeRegistrationController;
use App\Http\Controllers\AuthenticationLoginController;
use App\Http\Controllers\AuthenticationLogoutController;
use App\Http\Controllers\AuthenticationRegisterController;
use App\Http\Controllers\AuthenticationRequestResetPasswordController;
use App\Http\Controllers\AuthenticationResetPasswordController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages/authentication/index')->middleware(Authenticate::class)
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

Route::view('finalizar-cadastro', 'pages/authentication/finalize_registration')
    ->name('authentication.finalize_registration');

Route::post('finalizar-cadastro/{id}', AuthenticationFinalizeRegistrationController::class)
    ->name('authentication.finalize_registration-action');

Route::view('solicitar-redefinir-senha', 'pages/authentication/request_reset_password')
    ->name('authentication.request_reset_password');

Route::post('solicitar-redefinir-senha', AuthenticationRequestResetPasswordController::class)
    ->name('authentication.request_reset_password-action');

Route::view('redefinir-senha', 'pages/authentication/reset_password')
    ->name('authentication.reset_password');

Route::post('redefinir-senha/{id}', AuthenticationResetPasswordController::class)
    ->name('authentication.reset_password-action');

// Route::post('solicitar-atualizar-email', [AuthenticationRequestUpdateEmailController::class, 'requestUpdateEmail']);

// Route::put('atualizar-email/{id}/{email}', [AuthenticationUpdateEmailController::class, 'updateEmail'])
//     ->name('authentication.update_email');

// Route::put('atualizar-senha', [AuthenticationUpdatePasswordController::class, 'updatePassword']);
