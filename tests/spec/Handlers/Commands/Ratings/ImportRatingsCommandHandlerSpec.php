<?php

namespace spec\Furnace\Handlers\Commands\Ratings;

use Furnace\Commands\Ratings\ImportRatingsCommand;
use Furnace\Entities\Models\Rating;
use Furnace\Entities\Models\User;
use Furnace\Handlers\Commands\Ratings\ImportRatingsCommandHandler;
use Prophecy\Argument;
use spec\Furnace\FurnaceObjectBehavior;

/**
 * @mixin ImportRatingsCommandHandler
 */
class ImportRatingsCommandHandlerSpec extends FurnaceObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ImportRatingsCommandHandler::class);
    }

    public function it_can_import_ratings()
    {
        $user   = User::first();
        $track  = $this->getDummyTrack();
        $rating = $this->getDummyRating(1)->getAttributes();

        $rating['ignition_id'] = $track->ignition_id;

        $ratings = [
            $rating,
            array_merge($rating, ['presilence' => 0]),
        ];

        $command = new ImportRatingsCommand($user, $ratings);
        $ratings = $this->handle($command);

        $ratings->shouldHaveCount(2);
        $ratings[0]->shouldHaveType(Rating::class);
        $ratings[0]->presilence->shouldBe(true);
        $ratings[1]->shouldHaveType(Rating::class);
        $ratings[1]->presilence->shouldBe(false);
    }
}
