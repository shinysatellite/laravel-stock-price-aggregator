<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AlphaVantage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'alpha-vantage';
    }
}