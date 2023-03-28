<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('usuarios', [UserController::class, 'paginate'])
    ->name('user.index');

Route::get('usuarios/versoes/{id}', [UserController::class, 'showVersion'])
    ->name('user.show-version');

Route::view('usuarios/adicionar', 'pages/user/create')
    ->name('user.create');

Route::post('usuarios/adicionar', [UserController::class, 'create'])
    ->name('user.create-action');

Route::view('usuarios/{id}/editar', 'pages/user/update')
    ->name('user.update');

Route::post('usuarios/{id}/editar', [UserController::class, 'update'])
    ->name('user.update-action');

Route::post('usuarios/{id}/remover', [UserController::class, 'remove'])
    ->name('user.remove-action');

Route::get('usuarios/{id}/versoes', [UserController::class, 'paginateVersions'])
    ->name('user.paginate-versions');
