<?php

namespace Sova\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([

            ]);
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/admin.php');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'admin');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'admin');

        $this->publishes([
            __DIR__ . '/../config/admin.php' => config_path('admin.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('vendor/admin')
        ], 'lang');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/admin'),
        ], 'public');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admin.php', 'admin');

        $this->app->singleton('admin', function () {
            return new Admin();
        });
    }
}