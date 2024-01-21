<?php

namespace AkincanD\LaraSocket\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ResponseBuilder.
 */
class LaraSocket extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'larasocket';
    }
}