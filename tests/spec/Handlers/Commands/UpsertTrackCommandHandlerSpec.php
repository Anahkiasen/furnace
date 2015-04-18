<?php

namespace spec\Furnace\Handlers\Commands;

use Furnace\Commands\UpsertTrackCommand;
use Furnace\Entities\Models\Track;
use Furnace\Handlers\Commands\UpsertTrackCommandHandler;
use Furnace\Services\Ignition;
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
        $this->mockIgnition($ignition);
        $command = new UpsertTrackCommand($this->ignitionKey);
        $track   = $this->handle($command);

        $track->shouldHaveType(Track::class);
        $track->name->shouldEqual('Stairway to Heaven');
        $track->ignition_id->shouldBeLike($this->ignitionKey);
    }

    public function it_can_retrieve_track(Ignition $ignition)
    {
        $this->mockIgnition($ignition);
        $existing = Track::where('ignition_id', $this->ignitionKey)->first();
        $command  = new UpsertTrackCommand($this->ignitionKey);
        $track    = $this->handle($command);

        $track->shouldHaveType(Track::class);
        $track->id->shouldBeLike($existing->id);
        $track->name->shouldEqual('Stairway to Heaven');
        $track->ignition_id->shouldBeLike($this->ignitionKey);
    }

    /**
     * @param $ignition
     */
    protected function mockIgnition($ignition)
    {
        $ignition->complete(['ignition_id' => $this->ignitionKey])->willReturn([
            'name'              => 'Stairway to Heaven',
            'parts'             => 'lead',
            'tuning'            => 'estandard',
            'version'           => '1.0',
            'difficulty_levels' => 8,
            'score'             => 2,
            'ignition_id'       => $this->ignitionKey,
        ]);

        $this->beConstructedWith($ignition, new Track);
    }
}
