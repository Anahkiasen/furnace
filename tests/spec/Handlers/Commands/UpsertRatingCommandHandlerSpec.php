<?php

namespace spec\Furnace\Handlers\Commands;

use Furnace\Commands\UpsertRatingCommand;
use Furnace\Entities\Models\Rating;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;
use Furnace\Entities\Models\User;
use Furnace\Handlers\Commands\UpsertRatingCommandHandler;
use Prophecy\Argument;
use spec\Furnace\FurnaceObjectBehavior;

/**
 * @mixin UpsertRatingCommandHandler
 */
class UpsertRatingCommandHandlerSpec extends FurnaceObjectBehavior
{
    public function let()
    {
        parent::let();

        $this->beConstructedWith(new Rating());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpsertRatingCommandHandler::class);
    }

    public function it_can_rate_track()
    {
        $track = $this->getDummyTrack();
        $user  = User::first();

        $command = new UpsertRatingCommand([
            'ignition_id' => $track->ignition_id,
            'audio'       => 2,
            'comments' => 'nope',
        ], $user);
        $rating  = $this->handle($command);

        $rating->shouldHaveType(Rating::class);
        $rating->track_id->shouldBeLike($track->id);
        $rating->audio->shouldEqual(2);
    }
}
