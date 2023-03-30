<?php

use App\Http\Controllers\ProductionRoleController;
use Illuminate\Support\Facades\Route;

Route::get('funcoes', [ProductionRoleController::class, 'paginate'])
    ->name('production-role.index');

Route::get('funcoes/versoes/{id}', [ProductionRoleController::class, 'showVersion'])
    ->name('production-role.show-version');

Route::view('funcoes/adicionar', 'pages/production-role/create')
    ->name('production-role.create');

Route::post('funcoes/adicionar', [ProductionRoleController::class, 'create'])
    ->name('production-role.create--action');

Route::view('funcoes/{id}/editar', 'pages/production-role/update')
    ->name('production-role.update');

Route::post('funcoes/{id}/editar', [ProductionRoleController::class, 'update'])
    ->name('production-role.update--action');

Route::post('funcoes/{id}/remover', [ProductionRoleController::class, 'remove'])
    ->name('production-role.remove--action');

Route::get('funcoes/{id}/versoes', [ProductionRoleController::class, 'paginateVersions'])
    ->name('production-role.paginate-versions');
