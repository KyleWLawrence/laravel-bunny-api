<?php

namespace KyleWLawrence\Bunny\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Bunny\Api\HttpClient
 */
class Bunny extends Facade
{
    /**
     * Return facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Bunny';
    }
}
