<?php

use App\Http\Controllers\BookableController;
use Illuminate\Support\Facades\Route;

Route::get('reservaveis', [BookableController::class, 'paginate']);

Route::get('reservaveis/versoes/{id}', [BookableController::class, 'showVersion']);

Route::post('reservaveis/adicionar', [BookableController::class, 'doCreate']);

Route::get('reservaveis/{id}', [BookableController::class, 'show']);

Route::put('reservaveis/{id}/editar', [BookableController::class, 'doUpdate']);

Route::delete('reservaveis/{id}/remover', [BookableController::class, 'remove']);

Route::get('reservaveis/{id}/versoes', [BookableController::class, 'paginateVersions']);
