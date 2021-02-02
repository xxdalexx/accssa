<?php

namespace App\Providers;

use App\DataProvider\DataProvider;
use App\DiscordAuth\DiscordAuthHandler;
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

        $this->app->singleton('DataProvider', function () {
            return new DataProvider;
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

        \Illuminate\Support\Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }        return $value;
            });
        });
    }
}
