<?php

use App\Http\Controllers\ProductionCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('modalidades', [ProductionCategoryController::class, 'paginate'])
    ->name('production-category.index');

Route::get('modalidades/versoes/{id}', [ProductionCategoryController::class, 'showVersion'])
    ->name('production-category.show-version');

Route::view('modalidades/adicionar', 'pages/production-category/create')
    ->name('production-category.create');

Route::post('modalidades/adicionar', [ProductionCategoryController::class, 'create'])
    ->name('production-category.create--action');

Route::view('modalidades/{id}/editar', 'pages/production-category/update')
    ->name('production-category.update');

Route::post('modalidades/{id}/editar', [ProductionCategoryController::class, 'update'])
    ->name('production-category.update--action');

Route::post('modalidades/{id}/remover', [ProductionCategoryController::class, 'remove'])
    ->name('production-category.remove--action');

Route::get('modalidades/{id}/versoes', [ProductionCategoryController::class, 'paginateVersions'])
    ->name('production-category.paginate-versions');
