<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('usuarios', [UserController::class, 'paginate']);

Route::get('usuarios/versoes/{id}', [UserController::class, 'showVersion']);

Route::get('usuarios/{id}', [UserController::class, 'show']);

Route::put('usuarios/{id}/editar', [UserController::class, 'doUpdate']);

Route::delete('usuarios/{id}/remover', [UserController::class, 'doRemove']);

Route::get('usuarios/{id}/versoes', [UserController::class, 'paginateVersions']);
