<?php
namespace Furnace\Providers;

use Auth;
use Furnace\Entities\Models\Track;
use Furnace\Http\Composers\HelpComposer;
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
            HelpComposer::class                     => 'help/about',
        ]);

        View::share([
            'rating_scale'  => ScoreComputer::RATING_SCALE,
            'integer_scale' => ScoreComputer::INTEGER_CRITERIA_SCALE,
            'menu'          => [
                'tracks.index'   => 'Tracks',
                'trackers.index' => 'Blacksmiths',
                'users.index'    => 'Users',
                'ratings.create' => 'Rate a track',
                'help.about'     => 'About',
            ],
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
