<?php

namespace Hanoivip\Download;

use Illuminate\Support\ServiceProvider;
use Hanoivip\Download\Services\IIosProvision;
use Hanoivip\Download\Services\ManualProvision;
use Hanoivip\Download\Services\AutoProvision;

class LibServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/hanoivip'),
            __DIR__.'/../lang' => resource_path('lang/vendor/hanoivip'),
            __DIR__ . '/../resources/images' => public_path('img'),
        ]);
        $this->loadViewsFrom(__DIR__ . '/../views', 'hanoivip');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadTranslationsFrom( __DIR__.'/../lang', 'hanoivip');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ios.php', 'ios');
        $this->commands([
            \Hanoivip\Download\Commands\ClearPendingDevices::class,
            \Hanoivip\Download\Commands\ListPendingDevices::class,
            \Hanoivip\Download\Commands\InvalidPendingDevices::class,
        ]);
        $ops = config('ios.mode', 'manual');
        if ($ops == 'manual')
        {
            $this->app->bind(IIosProvision::class, ManualProvision::class);
        }
        else
        {
            $this->app->bind(IIosProvision::class, AutoProvision::class);
        }
    }
}
