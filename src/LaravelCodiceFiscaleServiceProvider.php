<?php

namespace Dipta995\LaravelCodiceFiscale;

use Illuminate\Support\ServiceProvider;

class LaravelCodiceFiscaleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Optionally, you can load routes, views, etc.
    }

    public function register()
    {
        // Bind a singleton instance to the key 'codicefiscale'
        $this->app->singleton('codicefiscale', function($app) {
            return new CodiceFiscale();
        });
    }
}
