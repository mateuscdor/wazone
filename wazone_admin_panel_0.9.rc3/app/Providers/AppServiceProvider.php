<?php

namespace App\Providers;

// use Cache;
// use PDO;
// use Schema;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if (Schema::hasTable('settings'))
        //     Cache::forever('settings', \App\Models\Setting::all());
    }
}
