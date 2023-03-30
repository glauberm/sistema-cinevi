<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('reservas', [BookingController::class, 'paginate'])
    ->name('booking.index');

Route::get('reservas/versoes/{id}', [BookingController::class, 'showVersion'])
    ->name('booking.show-version');

Route::view('reservas/adicionar', 'pages/booking/create')
    ->name('booking.create');

Route::post('reservas/adicionar', [BookingController::class, 'create'])
    ->name('booking.create--action');

Route::view('reservas/{id}/editar', 'pages/booking/update')
    ->name('booking.update');

Route::post('reservas/{id}/editar', [BookingController::class, 'update'])
    ->name('booking.update--action');

Route::post('reservas/{id}/remover', [BookingController::class, 'remove'])
    ->name('booking.remove--action');

Route::get('reservas/{id}/versoes', [BookingController::class, 'paginateVersions'])
    ->name('booking.paginate-versions');
