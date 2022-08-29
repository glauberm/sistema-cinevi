<?php

use App\Http\Controllers\BookableCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('categorias-de-reservaveis', [BookableCategoryController::class, 'paginate']);

Route::get('categorias-de-reservaveis/versoes/{id}', [BookableCategoryController::class, 'showVersion']);

Route::post('categorias-de-reservaveis/adicionar', [BookableCategoryController::class, 'doCreate']);

Route::get('categorias-de-reservaveis/{id}', [BookableCategoryController::class, 'show']);

Route::put('categorias-de-reservaveis/{id}/editar', [BookableCategoryController::class, 'doUpdate']);

Route::delete('categorias-de-reservaveis/{id}/remover', [BookableCategoryController::class, 'remove']);

Route::get('categorias-de-reservaveis/{id}/versoes', [BookableCategoryController::class, 'paginateVersions']);
