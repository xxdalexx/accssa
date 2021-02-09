<?php

namespace App\Providers;

use App\DataProvider\DataProvider;
use App\DiscordAuth\DiscordAuthHandler;
use App\Http\Guzzle\Sgp\Get\DriverResults;
use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\Get\Responses\DriverResultsResponse;
use App\Http\Guzzle\Sgp\Get\Responses\LeagueViewsResponse;
use App\Http\Guzzle\Sgp\Get\Responses\SessionResponse;
use App\Http\Guzzle\Sgp\Get\Session;
use App\Http\Guzzle\Sgp\SgpApi;
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
        $this->app->singleton('MenuBuilder', function() {
            return new MenuBuilder(
                app('Illuminate\Http\Request')
            );
        });

        $this->app->singleton('DataProvider', function() {
            return new DataProvider;
        });

        $this->app->bind(LeagueViews::class);

        $this->app->bind(LeagueViewsResponse::class, function($app) {
            return new LeagueViewsResponse(app(LeagueViews::class));
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
