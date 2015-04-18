<?php
namespace spec\Furnace;

use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;
use Furnace\Entities\Models\User;
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

        return $item;
    }
}
