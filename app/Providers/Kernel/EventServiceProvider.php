<?php
namespace Furnace\Providers\Kernel;

use Furnace\Entities\Models\Rating;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Observers\RatingObserver;
use Furnace\Entities\Observers\TrackObserver;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @type array
     */
    protected $listen = [
        'event.name' => [
            'EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function boot(DispatcherContract $events)
    {
        ServiceProvider::boot($events);

        Rating::observe(RatingObserver::class);
        Track::observe(TrackObserver::class);
    }
}
