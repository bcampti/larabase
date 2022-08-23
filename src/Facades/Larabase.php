<?php

namespace Bcampti\Larabase\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bcampti\Larabase\Larabase
 */
class Larabase extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Bcampti\Larabase\Larabase::class;
    }
}
