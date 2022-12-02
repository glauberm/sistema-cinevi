<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function () {
            return base_path().'/public_html';
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading();
    }
}
