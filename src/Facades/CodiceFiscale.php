<?php

namespace Dipta995\LaravelCodiceFiscale\Facades;

use Illuminate\Support\Facades\Facade;

class CodiceFiscale extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'codicefiscale';
    }
}
