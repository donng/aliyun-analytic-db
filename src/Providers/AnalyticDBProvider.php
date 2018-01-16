<?php

namespace Donng\AnalyticDB\Providers;

use Illuminate\Support\ServiceProvider;
use Donng\AnalyticDB\AliyunDatabaseManager;
use Donng\AnalyticDB\Connections\ConnectionFactory;

class AnalyticDBProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //php artisan vendor:publish --provider="Donng\AnalyticDB\Providers\AnalyticDBProvider"
        $this->loadMigrationsFrom(__DIR__.'/../../migrations');

        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('aliyun_db.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('AnalyticDB', function ($app) {
            return new AliyunDatabaseManager($app, new ConnectionFactory());
        });
    }
}
