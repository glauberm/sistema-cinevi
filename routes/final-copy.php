<?php

use App\Http\Controllers\FinalCopyController;
use Illuminate\Support\Facades\Route;

Route::get('copias-finais', [FinalCopyController::class, 'paginate']);

Route::get('copias-finais/versoes/{id}', [FinalCopyController::class, 'showVersion']);

Route::post('copias-finais/adicionar', [FinalCopyController::class, 'doCreate']);

Route::get('copias-finais/{id}', [FinalCopyController::class, 'show']);

Route::put('copias-finais/{id}/editar', [FinalCopyController::class, 'doUpdate']);

Route::delete('copias-finais/{id}/remover', [FinalCopyController::class, 'remove']);

Route::get('copias-finais/{id}/versoes', [FinalCopyController::class, 'paginateVersions']);
