<?php

use App\Http\Controllers\BookableController;
use Illuminate\Support\Facades\Route;

Route::get('reservaveis', [BookableController::class, 'paginate'])
    ->name('bookable.index');

Route::get('reservaveis/versoes/{id}', [BookableController::class, 'showVersion'])
    ->name('bookable.show-version');

Route::view('reservaveis/adicionar', 'pages/bookable/create')
    ->name('bookable.create');

Route::post('reservaveis/adicionar', [BookableController::class, 'create'])
    ->name('bookable.create--action');

Route::view('reservaveis/{id}/editar', 'pages/bookable/update')
    ->name('bookable.update');

Route::post('reservaveis/{id}/editar', [BookableController::class, 'update'])
    ->name('bookable.update--action');

Route::post('reservaveis/{id}/remover', [BookableController::class, 'remove'])
    ->name('bookable.remove--action');

Route::get('reservaveis/{id}/versoes', [BookableController::class, 'paginateVersions'])
    ->name('bookable.paginate-versions');
