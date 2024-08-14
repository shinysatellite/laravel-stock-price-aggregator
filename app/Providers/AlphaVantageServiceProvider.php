<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AlphaVantageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('alpha-vantage', function ($app) {
            return new Client([
                'base_uri' => 'https://www.alphavantage.co/query',
                'timeout'  => 10.0,
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
