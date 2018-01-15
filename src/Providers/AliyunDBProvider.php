<?php

namespace Donng\AliyunDB\Providers;

use Illuminate\Support\ServiceProvider;
use Donng\AliyunDB\AliyunDatabaseManager;
use Donng\AliyunDB\Connections\ConnectionFactory;

class AliyunDBProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //php artisan vendor:publish --provider="Donng\AliyunDB\Providers\AliyunDBProvider"

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
        $this->app->singleton('AliyunDB', function ($app) {
            return new AliyunDatabaseManager($app, new ConnectionFactory());
        });
    }
}
