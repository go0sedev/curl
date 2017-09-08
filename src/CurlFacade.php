<?php

namespace GustavTrenwith\Curl;

use Illuminate\Support\Facades\Facade;

/**
 * Class CurlFacade
 * @package gustavtrenwith\curl
 * @author Gustav Trenwith <gtrenwith@gmail.com>
 */
class CurlFacade extends Facade
{
    /**
     * Name of the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Curl';
    }
}
