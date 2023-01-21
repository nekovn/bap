<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $service_dirs = ['/Services/*.php', '/Services/**/*.php', '/Services/**/**/*.php'];
        foreach($service_dirs as $dir) {
            foreach (glob(app_path().$dir) as $filename) {
                require_once($filename);
            }
        }

        $repositories_dirs = ['/Repositories/*.php', '/Repositories/**/*.php', '/Repositories/**/**/*.php'];
        foreach($service_dirs as $dir) {
            foreach (glob(app_path().$dir) as $filename) {
                require_once($filename);
            }
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (app()->isProduction()) {
            $url->forceScheme('https');
        }
        //https://sethphat.com/sp-457/laravel-5-4-loi-specified-key-long
        Schema::defaultStringLength(191);
    }
}
