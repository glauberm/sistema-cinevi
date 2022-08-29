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
            require base_path('routes/health-check.php');
            require base_path('routes/authentication.php');
            require base_path('routes/user.php');
            require base_path('routes/bookable.php');
            require base_path('routes/bookable-category.php');
            require base_path('routes/booking.php');
            require base_path('routes/production-category.php');
            require base_path('routes/production-role.php');
            require base_path('routes/project.php');
            require base_path('routes/final-copy.php');
        });

        Route::group(['middleware' => 'web'], function ($router) {
            require base_path('routes/root.php');
        });
    }
}
