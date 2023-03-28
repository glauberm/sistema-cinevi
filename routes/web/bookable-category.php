<?php

use App\Http\Controllers\BookableCategoryController;
use Illuminate\Support\Facades\Route;

Route::get(
    'categorias-de-reservaveis',
    [BookableCategoryController::class, 'paginate']
)
    ->name('bookable_category.index');

Route::get(
    'categorias-de-reservaveis/versoes/{id}',
    [BookableCategoryController::class, 'showVersion']
)
    ->name('bookable_category.show-version');

Route::view(
    'categorias-de-reservaveis/adicionar',
    'pages/bookable_category/create'
)
    ->name('bookable_category.create');

Route::post(
    'categorias-de-reservaveis/adicionar',
    [BookableCategoryController::class, 'create']
)
    ->name('bookable_category.create-action');

Route::view(
    'categorias-de-reservaveis/{id}/editar',
    'pages/bookable_category/update'
)
    ->name('bookable_category.update');

Route::post(
    'categorias-de-reservaveis/{id}/editar',
    [BookableCategoryController::class, 'update']
)
    ->name('bookable_category.update-action');

Route::post(
    'categorias-de-reservaveis/{id}/remover',
    [BookableCategoryController::class, 'remove']
)
    ->name('bookable_category.remove-action');

Route::get(
    'categorias-de-reservaveis/{id}/versoes',
    [BookableCategoryController::class, 'paginateVersions']
)
    ->name('bookable_category.paginate-versions');
