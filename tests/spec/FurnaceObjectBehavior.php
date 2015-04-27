<?php
namespace spec\Furnace;

use Furnace\Entities\Models\Rating;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;
use Furnace\Entities\Models\User;
use Furnace\Entities\Models\Version;
use Furnace\Services\Ignition;
use League\FactoryMuffin\Facade;
use Mockery;
use PhpSpec\Laravel\LaravelObjectBehavior;

class FurnaceObjectBehavior extends LaravelObjectBehavior
{
    /**
     *
     */
    public function let()
    {
        $this->loadFactories();

        app()->bind(Ignition::class, function () {
            return Mockery::mock(Ignition::class)->shouldReceive('complete')->andReturn([])->getMock();
        });

        User::first() ?: Facade::create(User::class);
    }

    /**
     * Load the Faker factories
     */
    protected function loadFactories()
    {
        Facade::loadFactories(__DIR__.'/../../database/factories');
    }

    /**
     * @return object
     */
    protected function getDummyTrack()
    {
        $tracker = Facade::create(Tracker::class);
        $item    = Facade::create(Track::class, ['tracker_id' => $tracker->id]);
        $version = Version::create(['name' => '1.0', 'track_id' => $item->id]);

        return $item;
    }

    /**
     * @param integer $average
     * @param array   $attributes
     *
     * @return Rating
     */
    protected function getDummyRating($average, array $attributes = [])
    {
        return new Rating([
            'track_id'          => 1,
            'tone'              => $average,
            'audio'             => $average,
            'tab'               => $average,
            'sync'              => true,
            'techniques'        => true,
            'normalized_volume' => true,
            'presilence'        => true,
            'playable'          => true
        ]);
    }
}
