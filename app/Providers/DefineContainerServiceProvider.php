<?php

namespace App\Providers;

use App\Http\Controllers\Admin\Container\DefineContainer;
use App\Http\Controllers\Admin\Container\DefineInterface;
use Illuminate\Support\ServiceProvider;

class DefineContainerServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (new DefineContainer() instanceof DefineInterface) {
            $this->app->bind('defineContainer', DefineContainer::class);
        }
    }
}
