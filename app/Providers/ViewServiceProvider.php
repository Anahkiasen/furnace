<?php
namespace Furnace\Providers;

use Auth;
use Furnace\Entities\Models\Track;
use Furnace\Http\Composers\RatingsComposer;
use Furnace\Services\ScoreComputer;
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
            $view->rating_scale = ScoreComputer::RATING_SCALE;
            $view->current_user = Auth::user();
            $view->menu         = [
                'tracks.index'   => 'Tracks',
                'trackers.index' => 'Blacksmiths',
                'users.index'    => 'Users',
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
