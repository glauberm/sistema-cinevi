<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('projetos', [ProjectController::class, 'paginate']);

Route::get('projetos/versoes/{id}', [ProjectController::class, 'showVersion']);

Route::post('projetos/adicionar', [ProjectController::class, 'doCreate']);

Route::get('projetos/{id}', [ProjectController::class, 'show']);

Route::put('projetos/{id}/editar', [ProjectController::class, 'doUpdate']);

Route::delete('projetos/{id}/remover', [ProjectController::class, 'remove']);

Route::get('projetos/{id}/versoes', [ProjectController::class, 'paginateVersions']);
