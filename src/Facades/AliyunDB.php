<?php

namespace Donng\AliyunDB\Facades;

use Illuminate\Support\Facades\Facade;

class AliyunDB extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'AliyunDB';
    }
}