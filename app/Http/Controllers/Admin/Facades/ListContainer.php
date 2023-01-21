<?php

namespace App\Http\Controllers\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class ListContainer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'listContainer';
    }
}
