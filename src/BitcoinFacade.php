<?php

namespace RifkyEkayama\BitcoinAPI;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RifkyEkayama\BitcoinBot\EndPoints
 */
class BitcoinFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bitcoin';
    }
}
