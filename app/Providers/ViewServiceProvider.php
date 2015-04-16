<?php
namespace Furnace\Providers;

use Furnace\Http\Composers\TracksComposer;
use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('tracks/index', TracksComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
}
