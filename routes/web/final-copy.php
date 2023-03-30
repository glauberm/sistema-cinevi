<?php

use App\Http\Controllers\FinalCopyController;
use Illuminate\Support\Facades\Route;

Route::get('copias-finais', [FinalCopyController::class, 'paginate'])
    ->name('final-copy.index');

Route::get('copias-finais/versoes/{id}', [FinalCopyController::class, 'showVersion'])
    ->name('final-copy.show-version');

Route::view('copias-finais/adicionar', 'pages/final-copy/create')
    ->name('final-copy.create');

Route::post('copias-finais/adicionar', [FinalCopyController::class, 'create'])
    ->name('final-copy.create--action');

Route::view('copias-finais/{id}/editar', 'pages/final-copy/update')
    ->name('final-copy.update');

Route::post('copias-finais/{id}/editar', [FinalCopyController::class, 'update'])
    ->name('final-copy.update--action');

Route::post('copias-finais/{id}/remover', [FinalCopyController::class, 'remove'])
    ->name('final-copy.remove--action');

Route::get('copias-finais/{id}/versoes', [FinalCopyController::class, 'paginateVersions'])
    ->name('final-copy.paginate-versions');
