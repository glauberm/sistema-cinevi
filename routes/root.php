<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::fallback([WebController::class, 'root'])->name('root');
