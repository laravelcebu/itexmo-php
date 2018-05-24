<?php

namespace LaravelCebu\Itexmo\Providers;

class SMSProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../assets/configs/itexmo.php' => config_path('itexmo.php')
        ], 'itexmo');
    }
}
