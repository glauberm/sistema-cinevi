<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function map()
    {
        Route::group(['middleware' => 'api', 'prefix' => 'api'], function ($router) {
        });

        Route::group(['middleware' => 'web'], function ($router) {
            require base_path('routes/web/authentication.php');
        });
    }
}
