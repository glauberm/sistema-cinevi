<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::group(['middleware' => 'api', 'prefix' => 'api'], function ($router) {
            require base_path('routes/api/health-check.php');
            require base_path('routes/api/authentication.php');
            require base_path('routes/api/production-role.php');
        });

        Route::group(['middleware' => 'web'], function ($router) {
            require base_path('routes/web/root.php');
        });
    }
}
