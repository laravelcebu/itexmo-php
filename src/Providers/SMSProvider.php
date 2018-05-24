<?php

namespace LaravelCebu\Itexmo\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelCebu\Itexmo\Itexmo;

class SMSProvider extends ServiceProvider
{

    public function provides()
    {
        return [Itexmo::class];
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../assets/configs/itexmo.php' => config_path('itexmo.php')
        ], 'itexmo');
    }
}
