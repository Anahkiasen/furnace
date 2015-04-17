<?php
namespace Furnace\Providers;

use Auth;
use Furnace\Http\Composers\LayoutComposer;
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
            RatingsComposer::class.'@composeCreate' => 'ratings/edit',
        ]);

        View::composer('*', function ($view) {
            $view->current_user = Auth::user();
            $view->menu         = [
                'tracks.index'   => 'Tracks',
                'trackers.index' => 'Blacksmiths',
                'ratings.create' => 'Rate a track',
                'help.about'     => 'About',
            ];
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
