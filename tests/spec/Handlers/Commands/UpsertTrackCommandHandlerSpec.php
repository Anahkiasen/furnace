<?php

namespace spec\Furnace\Handlers\Commands;

use Furnace\Commands\UpsertTrackCommand;
use Furnace\Entities\Models\Artist;
use Furnace\Entities\Models\Track;
use Furnace\Handlers\Commands\UpsertTrackCommandHandler;
use Furnace\Services\Ignition;
use League\FactoryMuffin\Facade;
use Prophecy\Argument;
use spec\Furnace\FurnaceObjectBehavior;

/**
 * @mixin UpsertTrackCommandHandler
 */
class UpsertTrackCommandHandlerSpec extends FurnaceObjectBehavior
{
    /**
     * @type int
     */
    protected $ignitionKey = 11019;

    public function let()
    {
        parent::let();
        //Track::truncate();

        $this->beConstructedWith(
            app(Ignition::class),
            new Track()
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpsertTrackCommandHandler::class);
    }

    public function it_can_create_track(Ignition $ignition)
    {
        $this->ignitionKey = $this->mockIgnition($ignition);
        $command = new UpsertTrackCommand($this->ignitionKey);
        $track   = $this->handle($command);

        $track->shouldHaveType(Track::class);
        $track->ignition_id->shouldBeLike($this->ignitionKey);
    }

    public function it_can_retrieve_track(Ignition $ignition)
    {
        $this->ignitionKey = $this->mockIgnition($ignition);

        $command = new UpsertTrackCommand($this->ignitionKey);
        $existing   = $this->handle($command);

        $command  = new UpsertTrackCommand($this->ignitionKey);
        $track    = $this->handle($command);

        $track->shouldHaveType(Track::class);
        $track->id->shouldBeLike($existing->id);
        $track->ignition_id->shouldBeLike($this->ignitionKey);
    }

    /**
     * @param $ignition
     */
    protected function mockIgnition($ignition)
    {
        $artist = Facade::create(Artist::class);
        $track  = Facade::instance(Track::class, [
            'parts'       => 'lead',
            'platforms'   => 'mac',
            'artist_id'   => $artist->id,
        ]);

        $ignition->complete(['ignition_id' => $track->ignition_id])->willReturn($track->getAttributes());

        $this->beConstructedWith($ignition, new Track);

        return $track->ignition_id;
    }
}
