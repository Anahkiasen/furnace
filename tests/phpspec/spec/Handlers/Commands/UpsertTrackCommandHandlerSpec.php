<?php

namespace spec\Furnace\Handlers\Commands;

use Furnace\Commands\UpsertTrackCommand;
use Furnace\Entities\Models\Track;
use Furnace\Handlers\Commands\UpsertTrackCommandHandler;
use Furnace\Services\Ignition;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin UpsertTrackCommandHandler
 */
class UpsertTrackCommandHandlerSpec extends LaravelObjectBehavior
{
    protected $ignitionKey = 11019;

    public function let(Ignition $ignition)
    {
        $ignition->complete(['ignition_id' => $this->ignitionKey])->willReturn([
            'name' => 'Stairway to Heaven',
        ]);

        $this->beConstructedWith($ignition, new Track);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpsertTrackCommandHandler::class);
    }

    public function it_can_create_track()
    {
        $command = new UpsertTrackCommand($this->ignitionKey);
        $track   = $this->handle($command);

        $track->shouldHaveType(Track::class);
        $track->name->shouldEqual('Stairway to Heaven');
        $track->ignition_id->shouldEqual($this->ignitionKey);
    }

    public function it_can_retrieve_track()
    {
        $existing = Track::where('ignition_id', $this->ignitionKey)->first();
        $command  = new UpsertTrackCommand($this->ignitionKey);
        $track    = $this->handle($command);

        $track->shouldHaveType(Track::class);
        $track->id->shouldBeLike($existing->id);
        $track->name->shouldEqual('Stairway to Heaven');
        $track->ignition_id->shouldEqual($this->ignitionKey);
    }
}
