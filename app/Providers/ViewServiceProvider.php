<?php
namespace Furnace\Providers;

use Furnace\Http\Composers\TracksComposer;
use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Boot the provider
     */
    public function boot()
    {
        View::composer('tracks/index', TracksComposer::class);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
}
