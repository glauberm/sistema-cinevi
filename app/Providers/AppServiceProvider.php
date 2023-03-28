<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        $app->usePublicPath(base_path() . '/public_html');
    }

    public function boot(): void
    {
        Model::shouldBeStrict();
    }
}
