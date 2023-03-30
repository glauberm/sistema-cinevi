<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        Route::group(['middleware' => 'web'], function ($router) {
            require base_path('routes/web/authentication.php');
            require base_path('routes/web/bookable-category.php');
            require base_path('routes/web/bookable.php');
            require base_path('routes/web/booking.php');
            require base_path('routes/web/configuration.php');
            require base_path('routes/web/final-copy.php');
            require base_path('routes/web/production-category.php');
            require base_path('routes/web/production-role.php');
            require base_path('routes/web/project.php');
            require base_path('routes/web/user.php');
        });

        Route::group(
            ['middleware' => 'api', 'prefix' => 'api'],
            function ($router) {
            }
        );
    }
}
