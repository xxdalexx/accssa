<?php

namespace App\Providers;

use App\MenuBuilder\MenuBuilder;
use Illuminate\Support\Facades\Auth;
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
        $this->app->singleton('MenuBuilder', function () {
            return new MenuBuilder(
                app('Illuminate\Http\Request')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::macro('driver', function () {
            return self::user()->driver;
        });
    }
}
