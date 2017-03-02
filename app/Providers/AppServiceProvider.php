<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//app('Dingo\Api\Auth\Auth')->extend('basic', function ($app) {
//   return new Dingo\Api\Auth\Provider\Basic($app['auth'], 'username');
//});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'development') {
            $this->app->register(\Laravel\Tinker\TinkerServiceProvider::class);
            $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
        }

        if ($this->app->environment('development', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
