<?php

use App\Http\Controllers\ProductionCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('modalidades', [ProductionCategoryController::class, 'paginate']);

Route::get('modalidades/versoes/{id}', [ProductionCategoryController::class, 'showVersion']);

Route::post('modalidades/adicionar', [ProductionCategoryController::class, 'doCreate']);

Route::get('modalidades/{id}', [ProductionCategoryController::class, 'show']);

Route::put('modalidades/{id}/editar', [ProductionCategoryController::class, 'doUpdate']);

Route::delete('modalidades/{id}/remover', [ProductionCategoryController::class, 'remove']);

Route::get('modalidades/{id}/versoes', [ProductionCategoryController::class, 'paginateVersions']);
