<?php

namespace spec\Furnace\Handlers\Commands;

use Furnace\Commands\UpsertRatingCommand;
use Furnace\Entities\Models\Rating;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;
use Furnace\Entities\Models\User;
use Furnace\Handlers\Commands\UpsertRatingCommandHandler;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin UpsertRatingCommandHandler
 */
class UpsertRatingCommandHandlerSpec extends LaravelObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new Rating());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpsertRatingCommandHandler::class);
    }

    public function it_can_rate_track()
    {
        $tracker = Tracker::create([]);
        $track   = Track::firstOrCreate(['ignition_id' => 123, 'tracker_id' => $tracker->id]);
        $user    = User::first();

        $command = new UpsertRatingCommand([
            'ignition_id' => 123,
            'audio'       => 2,
        ], $user);
        $rating  = $this->handle($command);

        $rating->shouldHaveType(Rating::class);
        $rating->track_id->shouldBeLike($track->id);
        $rating->audio->shouldEqual(2);
    }
}
