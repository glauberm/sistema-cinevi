<?php

use App\Http\Controllers\ProductionRoleController;
use Illuminate\Support\Facades\Route;

Route::get('funcoes', [ProductionRoleController::class, 'paginate']);

Route::get('funcoes/versoes/{id}', [ProductionRoleController::class, 'showVersion']);

Route::post('funcoes/adicionar', [ProductionRoleController::class, 'doCreate']);

Route::get('funcoes/{id}', [ProductionRoleController::class, 'show']);

Route::put('funcoes/{id}/editar', [ProductionRoleController::class, 'doUpdate']);

Route::delete('funcoes/{id}/remover', [ProductionRoleController::class, 'remove']);

Route::get('funcoes/{id}/versoes', [ProductionRoleController::class, 'paginateVersions']);
