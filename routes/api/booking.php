<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('reservas/entre', [BookingController::class, 'showBetween'])
    ->name('booking.show-between');
