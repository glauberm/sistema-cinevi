<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('reservas', [BookingController::class, 'paginate']);

Route::get('reservas/entre', [BookingController::class, 'showBetween']);

Route::get('reservas/versoes/{id}', [BookingController::class, 'showVersion']);

Route::post('reservas/adicionar', [BookingController::class, 'create']);

Route::get('reservas/{id}', [BookingController::class, 'show']);

Route::put('reservas/{id}/editar', [BookingController::class, 'update']);

Route::delete('reservas/{id}/remover', [BookingController::class, 'remove']);

Route::get('reservas/{id}/versoes', [BookingController::class, 'paginateVersions']);
