<?php
namespace Furnace\Providers;

use Auth;
use Furnace\Http\Composers\RatingsComposer;
use Furnace\Http\Composers\TracksComposer;
use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Boot the provider.
     */
    public function boot()
    {
        View::composers([
            TracksComposer::class                   => 'tracks/index',
            RatingsComposer::class.'@composeCreate' => 'ratings/create',
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
