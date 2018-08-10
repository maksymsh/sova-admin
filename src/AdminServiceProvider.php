<?php

namespace Sova\Admin;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Sova\Admin\Console\InstallCommand;
use Sova\Admin\Console\MigrationMakeCommand;
use Sova\Admin\Console\ModelMakeCommand;
use Sova\Admin\Http\Middleware\AdminMiddleware;

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
                InstallCommand::class,
                ModelMakeCommand::class,
                MigrationMakeCommand::class
            ]);
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
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
        ], 'assets');

        $this->publishes([
            __DIR__.'/../database/seeds' => public_path('vendor/admin'),
        ], 'seeds');


        $this->app['router']->namespace('Admin')
            ->middleware(AdminMiddleware::class)
            ->prefix('admin')
            ->as('admin::')
            ->group(__DIR__.'/../routes/admin.php');
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