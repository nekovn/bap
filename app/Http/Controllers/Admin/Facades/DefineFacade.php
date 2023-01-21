<?php

namespace App\Http\Controllers\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class DefineFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'defineContainer';
    }
}
