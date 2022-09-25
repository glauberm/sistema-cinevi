<?php

use App\Http\Controllers\ConfigurationController;
use Illuminate\Support\Facades\Route;

Route::get('configuracoes/versoes/{id}', [ConfigurationController::class, 'showVersion']);

Route::get('configuracoes/{id}', [ConfigurationController::class, 'show']);

Route::put('configuracoes/{id}/editar', [ConfigurationController::class, 'update']);
