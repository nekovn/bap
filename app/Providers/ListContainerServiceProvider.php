<?php

namespace App\Providers;
use App\Http\Controllers\Admin\Container\ListContainer;
use Illuminate\Auth\Events\Logout;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ListContainerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('listContainer', ListContainer::class);
        $this->app['events']->listen(Logout::class, function () {
            //すべてキャッシュ削除
            Cache::flush();
        });
    }
}
