<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::post('entrada', [AuthenticationController::class, 'login']);

Route::post('saida', [AuthenticationController::class, 'logout']);

Route::get('usuario-autenticado', [AuthenticationController::class, 'getAuthenticatedUser']);

Route::post('cadastro', [AuthenticationController::class, 'register']);

Route::put('finalizar-cadastro/{id}', [AuthenticationController::class, 'finalizeRegistration'])
    ->name('authentication.finalize_registration');

Route::post('solicitar-redefinir-senha', [AuthenticationController::class, 'requestResetPassword']);

Route::put('redefinir-senha/{id}', [AuthenticationController::class, 'resetPassword'])
    ->name('authentication.reset_password');

Route::post('solicitar-atualizar-email', [AuthenticationController::class, 'requestUpdateEmail']);

Route::put('atualizar-email/{id}/{email}', [AuthenticationController::class, 'updateEmail'])
    ->name('authentication.update_email');

Route::put('atualizar-senha', [AuthenticationController::class, 'updatePassword']);
