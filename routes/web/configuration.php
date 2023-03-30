<?php

use App\Http\Controllers\ConfigurationController;
use Illuminate\Support\Facades\Route;

Route::view('configuracoes', 'pages/configuration/update')
    ->name('configuration');

Route::post('configuracoes', [ConfigurationController::class, 'update'])
    ->name('configuration--action');

Route::get('configuracoes/versoes', [ConfigurationController::class, 'paginateVersions'])
    ->name('configuration.paginate-versions');

Route::get('configuracoes/versoes/{id}', [ConfigurationController::class, 'showVersion'])
    ->name('configuration.show-version');
