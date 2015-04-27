<?php

namespace spec\Furnace\Handlers\Commands\Ratings;

use Furnace\Collection;
use Furnace\Commands\Ratings\ExportRatingsCommand;
use Furnace\Entities\Transformers\RatingExportTransformer;
use Furnace\Handlers\Commands\Ratings\ExportRatingsCommandHandler;
use League\Csv\Writer;
use Prophecy\Argument;
use spec\Furnace\FurnaceObjectBehavior;

/**
 * @mixin ExportRatingsCommandHandler
 */
class ExportRatingsCommandHandlerSpec extends FurnaceObjectBehavior
{
    public function let()
    {
        parent::let();

        $this->beConstructedWith(new RatingExportTransformer());
    }


    function it_is_initializable()
    {
        $this->shouldHaveType(ExportRatingsCommandHandler::class);
    }

    public function it_can_export_ratings()
    {
        $ratings = new Collection([$this->getDummyRating(1), $this->getDummyRating(2)]);
        $command = new ExportRatingsCommand($ratings);
        $file    = $this->handle($command);

        $file->shouldHaveType(Writer::class);
        $serialized = $file->jsonSerialize();

        $serialized[0]->shouldBeLike([
            'ignition_id',
            'version_id',
            'presilence',
            'normalized_volume',
            'playable',
            'tone',
            'audio',
            'sync',
            'techniques',
            'tab',
            'difficulty',
            'comments',
        ]);
        $serialized[1][5]->shouldBeLike(1);
        $serialized[2][5]->shouldBeLike(2);
    }
}
