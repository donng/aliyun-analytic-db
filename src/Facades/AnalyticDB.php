<?php

namespace Donng\AnalyticDB\Facades;

use Illuminate\Support\Facades\Facade;

class AnalyticDB extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'AnalyticDB';
    }
}