<?php

use App\Http\Controllers\BookableCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('categorias-de-reservaveis', [BookableCategoryController::class, 'paginate'])
    ->name('bookable-category.index');

Route::get('categorias-de-reservaveis/versoes/{id}', [BookableCategoryController::class, 'showVersion'])
    ->name('bookable-category.show-version');

Route::view('categorias-de-reservaveis/adicionar', 'pages/bookable-category/create')
    ->name('bookable-category.create');

Route::post('categorias-de-reservaveis/adicionar', [BookableCategoryController::class, 'create'])
    ->name('bookable-category.create--action');

Route::view('categorias-de-reservaveis/{id}/editar', 'pages/bookable-category/update')
    ->name('bookable-category.update');

Route::post('categorias-de-reservaveis/{id}/editar', [BookableCategoryController::class, 'update'])
    ->name('bookable-category.update--action');

Route::post('categorias-de-reservaveis/{id}/remover', [BookableCategoryController::class, 'remove'])
    ->name('bookable-category.remove--action');

Route::get('categorias-de-reservaveis/{id}/versoes', [BookableCategoryController::class, 'paginateVersions'])
    ->name('bookable-category.paginate-versions');
