<?php
namespace Furnace\Providers;

use Auth;
use Furnace\Http\Composers\GlobalComposer;
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
        View::composers([
            TracksComposer::class => 'tracks/index',
        ]);

        View::composer('*', function ($view) {
           $view->current_user = Auth::user();
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
}
