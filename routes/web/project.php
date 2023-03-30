<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('projetos', [ProjectController::class, 'paginate'])
    ->name('project.index');

Route::get('projetos/versoes/{id}', [ProjectController::class, 'showVersion'])
    ->name('project.show-version');

Route::view('projetos/adicionar', 'pages/project/create')
    ->name('project.create');

Route::post('projetos/adicionar', [ProjectController::class, 'create'])
    ->name('project.create--action');

Route::view('projetos/{id}/editar', 'pages/project/update')
    ->name('project.update');

Route::post('projetos/{id}/editar', [ProjectController::class, 'update'])
    ->name('project.update--action');

Route::post('projetos/{id}/remover', [ProjectController::class, 'remove'])
    ->name('project.remove--action');

Route::get('projetos/{id}/versoes', [ProjectController::class, 'paginateVersions'])
    ->name('project.paginate-versions');
