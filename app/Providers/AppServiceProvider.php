<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // load helper
        require_once app_path() . '/Helpers/load.php';
        // load ekspedisi plugin
        require_once app_path() . '/Ekspedisi/load.php';
        Schema::defaultStringLength(191);
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
