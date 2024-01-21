<?php

namespace Akincand\LaraSocket\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ResponseBuilder.
 */
class Socket extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'larasocket';
    }
}