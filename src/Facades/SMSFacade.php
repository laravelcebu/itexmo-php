<?php

namespace LaravelCebu\Itexmo\Facades;

use Illuminate\Support\Facades\Facade;
use LaravelCebu\Itexmo\Itexmo;

class TenancyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'itexmo';
    }
}
